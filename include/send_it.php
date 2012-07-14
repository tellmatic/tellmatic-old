<?php
/********************************************************************************/
/* this file is part of: / diese Datei ist ein Teil von:                        */
/* tellmatic, the newslettermachine                                             */
/* tellmatic, die Newslettermaschine                                            */
/* 2006/7 by Volker Augustin, multi.art.studio Hanau                            */
/* Contact/Kontakt: info@tellmatic.org                                      */
/* Homepage: www.tellmatic.org                                                   */
/* leave this header in file!                                                   */
/* diesen Header nicht loeschen!                                                */
/* check Homepage for Updates and more Infos                                    */
/* Besuchen Sie die Homepage fuer Updates und weitere Infos                     */
/********************************************************************************/

#exit;
#include config file: edit line if you run this script via cronjob, add full path to tellmatic config file
require_once ("./tm_config.inc.php");
ob_start();
/********************************************************************************/
require_once(TM_INCLUDEPATH."/Class_SMTP.inc.php");
#require_once (TM_INCLUDEPATH."/phphtmlparser/html2text.inc");

$called_via_url=FALSE;

if (isset($_SERVER['REMOTE_ADDR'])) {
	$called_via_url=TRUE;
}

//a http refresh may work
$reload_intervall=300;

if ($called_via_url) {
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$encoding."\">\n";
	echo "<html>\n<body bgcolor=\"#ffffff\">\n";
	echo "<pre>\n";
}

$QUEUE=new tm_Q();
$NEWSLETTER=new tm_NL();
$ADDRESS=new tm_ADR();
$HOSTS=new tm_HOST();
$BLACKLIST=new tm_BLACKLIST();
$T=new Timer();//zeitmessung

$skip_send=FALSE;//if true, skip sending routine// is true after new q has been prepared
$log_proc_id=rand(111111,999999);
$log_q_id="0";
$log_nl_id="0";
$log_grp_id="0";
$log_adr_id="0";
$log_msg="";

function send_log($text) {
	#update log on the fly
	global $tm_logpath;//make a constant!
	global $logfilename;
	global $log_proc_id;
	global $log_q_id;
	global $log_nl_id;
	global $log_grp_id;
	global $log_adr_id;
	global $called_via_url;

	$timestamp=microtime(TRUE);//microtime(TRUE);
	$datetime=date("Y-m-d H:i:s");
	
	$log="";	
	$log.="[".$timestamp."][".$log_proc_id."],".$datetime.",q:".$log_q_id.",n:".$log_nl_id.",g:".$log_grp_id.",a:".$log_adr_id; 
	$log.=",t: ".$text;
	$log.="\n";
	
	update_file($tm_logpath,$logfilename,$log);
	
	#output to browser or cron:
	echo $log;
	if ($called_via_url) {
		#echo "<br>";
	}
	#echo(str_repeat(' ',256));
    // check that buffer is actually set before flushing
	if (ob_get_length()) {
		//http://www.php.net/manual/de/function.ob-end-flush.php
		flush();
		ob_end_flush();
		#ob_end_clean();		
		#$out=ob_get_contents() ;
		#ob_flush();
	}
	ob_start();
}

//Q's vorbereiten // status=1, autogen=1, startet zwischen jetzt und +xx stunden!
$QP=$QUEUE->getQtoPrepare(Array("limit"=>1));
$qpc=count($QP);//wieviel zu sendende q eintraege gibt es?
//Schleife Qs
for ($qpcc=0;$qpcc<$qpc;$qpcc++) {
	$skip_send=TRUE;
	$logfilename="q_".$QP[$qpcc]['id']."_".$QP[$qpcc]['grp_id']."_".date_convert_to_string($QP[$qpcc]['created']).".log.html";
	
	//set log_q_id, nl_id and adr_id
	$log_q_id=$QP[$qpcc]['id'];
	$log_nl_id=$QP[$qpcc]['nl_id'];
	$log_grp_id=$QP[$qpcc]['grp_id'];
	
	send_log("Preparing ".($qpcc+1)." of $qpc Qs");
	send_log("begin");
	send_log("QID=".$QP[$qpcc]['id']);
	send_log("Status=".$QP[$qpcc]['status']);
	send_log("nl_id=".$QP[$qpcc]['nl_id']);
	send_log("grp_id=".$QP[$qpcc]['grp_id']);
	send_log("host_id=".$QP[$qpcc]['host_id']);
	send_log("send_at=".$QP[$qpcc]['send_at']);
	send_log("autogen=".$QP[$qpcc]['autogen']);
	$ReportMail_HTML="";
	$G=$ADDRESS->getGroup($QP[$qpcc]['grp_id']);
	$NL=$NEWSLETTER->getNL($QP[$qpcc]['nl_id']);
	$HOST=$HOSTS->getHost($QP[$qpcc]['host_id'],Array("aktiv"=>1,"type"=>"smtp"));
	send_log("q status=1, q autogen =1");
	send_log("creating recipients list:");
	$h_refresh=$QUEUE->addHQ( Array ( 'nl_id' => $QP[$qpcc]['nl_id'],
																				'q_id' => $QP[$qpcc]['id'],
																				'grp_id' =>$QP[$qpcc]['grp_id'],
																				'host_id' =>$QP[$qpcc]['host_id'],
																				'status' => 1,
																				'created' => date("Y-m-d H:i:s")
																				)
																		);

	#proof?!
	if ($C[0]['proof']==1) {
		if (DEBUG) $MESSAGE.=send_log("proofing global enabled");
		if ($QP[$qpcc]['proof']==1) {
			if (DEBUG) $MESSAGE.=send_log("proofing for this q enabled");
			$ADDRESS->proof();
		}	else {
			if (DEBUG) $MESSAGE.=send_log("proofing for this q disabled");		
		}
	}	

	if ($h_refresh[0]) {
		$ReportMail_HTML.="<br>AutoGen=1";
		$ReportMail_HTML.="<br>Die Empfängerliste wurde automatisch erzeugt! Es wurden ".$h_refresh[2]." Adressen für Gruppe ".$G[0]['name']." eingetragen.";
		$ReportMail_HTML.="<br>The recipientslist has been automagical created, ".$h_refresh[2]." adresses for group ".$G[0]['name']." inserted.";
		$ReportMail_HTML.="<br>SMTP-Mailserver: ".$HOST[0]['name']." / ".$HOST[0]['user'].":[pass]@".$HOST[0]['host'].":".$HOST[0]['port'];
		send_log($h_refresh[2]." adresses for group ".$G[0]['name']." inserted in recipients list");
		send_log("set q status=2, started!");
		$QUEUE->setStatus($QP[$qpcc]['id'],2);//gestartet
	} else {
		$ReportMail_HTML.="<br>Feher beim aktualisieren der Empfängerliste.".
		$ReportMail_HTML.="<br>Error refreshing the recipients list.".
		send_log("Error refreshing recipients list!");
	}
	send_log("q status =1, new status=2, sending mail to admin");
	//report an sender....
	$ReportMail_Subject="Tellmatic: Prepare recipients list (QId: ".$QP[$qpcc]['id']." / ".$QP[$qpcc]['created'].") ".display($NL[0]['subject'])." an ".display($G[0]['name']);
	//$created_date=strftime("%d-%m-%Y %H:%M:%S",mk_microtime($QP[$qpcc]['created']));
	$created_date=$QP[$qpcc]['created'];
	$ReportMail_HTML.="<br><b>".$created_date."</b>".
									"<br>Der Versand des Newsletter <b>".display($NL[0]['subject'])."</b> an die Gruppe <b>".display($G[0]['name'])."</b> wurde vorbereitet.".
									"<br>The Mailing for Newsletter <b>".display($NL[0]['subject'])."</b> to Group <b>".display($G[0]['name'])."</b> prepared.".
									"<br>".
									"<br>Versand terminiert fuer: / Send at: ".$QP[$qpcc]['send_at'].
									"<br>Logfile: ".$tm_URL_FE."/".$tm_logdir."/".$logfilename;
	if (!DEMO) @SendMail_smtp($HOST[0]['sender_email'],$HOST[0]['sender_name'],$HOST[0]['sender_email'],$HOST[0]['sender_name'],$ReportMail_Subject,clear_text($ReportMail_HTML),$ReportMail_HTML,Array(),$HOST);
	//sendmail_smtp[0]=true/false [1]=""/errormessage
	
	send_log("write Log to ".$tm_URL_FE."/".$tm_logdir."/".$logfilename);
}//for qpc

//jetzt aktuelle q's zum versenden holen...:

//Q holen
$limitQ=1;//nur ein q eintrag bearbeiten!
$Q=Array();
if (!$skip_send) {
	$Q=$QUEUE->getQtoSend(0,0,$limitQ,0);//id offset limit nl-id
}
$qc=count($Q);//wieviel zu sendende q eintraege gibt es?

//Schleife Qs
for ($qcc=0;$qcc<$qc;$qcc++) {
		//set log_q_id, nl_id and adr_id
		$log_q_id=$Q[$qcc]['id'];
		$log_nl_id=$Q[$qcc]['nl_id'];
		$log_grp_id=$Q[$qcc]['grp_id'];
	
	$logfilename="q_".$Q[$qcc]['id']."_".$Q[$qcc]['grp_id']."_".date_convert_to_string($Q[$qcc]['created']).".log.html";

	
	send_log("Running ".($qcc+1)." of $qc Qs");
	send_log("begin");
	$HOST=$HOSTS->getHost($Q[$qcc]['host_id'],Array("aktiv"=>1,"type"=>"smtp"));
	//wenn Q status gestartet oder running // 2 oder 3
		send_log("QID=".$Q[$qcc]['id']);
		send_log("Status=".$Q[$qcc]['status']);
		send_log("nl_id=".$Q[$qcc]['nl_id']);
		send_log("grp_id=".$Q[$qcc]['grp_id']);
		send_log("host_id=".$Q[$qcc]['host_id']);
		send_log("send_at=".$Q[$qcc]['send_at']);
		send_log("autogen=".$Q[$qcc]['autogen']);
	if (!isset($HOST[0]))	{ //wenn kein gueltiger smtp host, filter: aktiv=1 und typ=smtp
		send_log("host id:".$Q[$qcc]['host_id']." inactive / not from type smtp or does not exist! skipping!");
		$QUEUE->setStatus($Q[$qcc]['id'],5);//stopped
		send_log("Q ID ".$Q[$qcc]['host_id']." stopped!");
	}
	
	if (isset($HOST[0]))	{ //wenn gueltiger smtp host, filter: aktiv=1 und typ=smtp
		send_log("hostname/ip=".$HOST[0]['name']."(".$HOST[0]['host'].":".$HOST[0]['port'].")");
		$max_mails_atonce=$HOST[0]['max_mails_atonce'];
		$max_mails_bcc=$HOST[0]['max_mails_bcc'];
		if ($HOST[0]['smtp_ssl']) send_log("use SSL");
		//Newsletter holen
		send_log("get nl");
		$NL=$NEWSLETTER->getNL($Q[$qcc]['nl_id'],0,0,0,1);//mit content!!!

		//status fuer nl auf 3=running setzen
		send_log("set nl status=3");
		$NEWSLETTER->setStatus($NL[0]['id'],3);//versand gestartet

		//wenn q status==2, neu... dann mail an admin das versenden gestartet wurde....
		if ($Q[$qcc]['status']==2) {//ist status=2, neu und in aktueller getQtosend-liste!  //neuer status ist schon 3 running!!! wurde oben bereits gemacht
			$ReportMail_HTML="";
			$G=$ADDRESS->getGroup($Q[$qcc]['grp_id']);
			//hier adressen nachfassen! fuer status=2, q_id und grp_id etc.
			if ($Q[$qcc]['autogen']==1) {
				//adressen nachfassen
				send_log("q status=2, q autogen =1, refreshing recipients list:");
				$h_refresh=$QUEUE->addHQ( Array ( 'nl_id' => $Q[$qcc]['nl_id'],
																				'q_id' => $Q[$qcc]['id'],
																				'grp_id' =>$Q[$qcc]['grp_id'],
																				'host_id' =>$Q[$qcc]['host_id'],
																				'status' => 1,
																				'created' => date("Y-m-d H:i:s")
																				)
																		);
				if ($h_refresh[0]) {
					$ReportMail_HTML.="<br>AutoGen=1".
					$ReportMail_HTML.="<br>Die Empfängerliste wurde automatisch aktualisiert! Es wurden ".$h_refresh[2]." neue Adressen für Gruppe ".$G[0]['name']." eingetragen.".
					$ReportMail_HTML.="<br>The recipientslist has been automagical refreshed, ".$h_refresh[2]." new adresses for group ".$G[0]['name']." inserted.".
					send_log($h_refresh[2]." new adresses for group ".$G[0]['name']." inserted in recipients list");
				} else {
					$ReportMail_HTML.="<br>Fehler beim aktualisieren der Empfängerliste.";
					$ReportMail_HTML.="<br>Error refreshing the recipients list.";
					send_log("Error refreshing recipients list!");
				}
			}
			send_log("q status =2, new status=3, sending mail to admin (".$HOST[0]['sender_email'].")");
			//report an sender....
			$ReportMail_Subject="Tellmatic: Start sending Newsletter (QId: ".$Q[$qcc]['id']." / ".$Q[$qcc]['created'].") ".display($NL[0]['subject'])." an ".display($G[0]['name']);
			//$created_date=strftime("%d-%m-%Y %H:%M:%S",mk_microtime($Q[$qcc]['created']));
			$created_date=$Q[$qcc]['created'];
			$ReportMail_HTML.="<br><b>".$created_date."</b>".
									"<br>Der Versand des Newsletter <b>".display($NL[0]['subject'])."</b> an die Gruppe <b>".display($G[0]['name'])."</b> wurde gestartet.".
									"<br>The Mailing for Newsletter <b>".display($NL[0]['subject'])."</b> to Group <b>".display($G[0]['name'])."</b> started.".
									"<br>".
									"<br>SMTP-Mailserver: ".$HOST[0]['name']." / ".$HOST[0]['user'].":[pass]@".$HOST[0]['host'].":".$HOST[0]['port'].
									"<br>erstellt (nur versand vorbereitet): /created (prepared): ".$created_date.
									"<br>Versand terminiert fuer: / Send at: ".$Q[$qcc]['send_at'].
									"<br>Gestartet: / Started: ".date("Y-m-d H:i:s").
									"<br>Logfile: ".$tm_URL_FE."/".$tm_logdir."/".$logfilename;
			if (!DEMO) @SendMail_smtp($HOST[0]['sender_email'],$HOST[0]['sender_name'],$HOST[0]['sender_email'],$HOST[0]['sender_name'],$ReportMail_Subject,clear_text($ReportMail_HTML),$ReportMail_HTML,Array(),$HOST);
			//sendmail_smtp[0]=true/false [1]=""/errormessage
		}

		//set status = running =3
		//erst hier, da addHQ den status 1 oder 2 verlangt! und es schon 3 waere wenn wir dat oben machen
		send_log("set q status=3");
		$QUEUE->setStatus($Q[$qcc]['id'],3);//running

		//		
		send_log("prepare E-Mail-Object");
		send_log("From: ".$HOST[0]['sender_email']." (".$HOST[0]['sender_name'].")");
		send_log("Subject: ".display($NL[0]['subject']));

		//emailobjekt vorbereiten, wird dann kopiert, hier globale einstellungen
		$email_obj=new smtp_message_class;//use SMTP!
		$email_obj->default_charset=$encoding;
		$email_obj->authentication_mechanism=$HOST[0]['smtp_auth'];
		$email_obj->ssl=$HOST[0]['smtp_ssl'];
		$email_obj->localhost=$HOST[0]['smtp_domain'];
		$email_obj->smtp_host=$HOST[0]['host'];
		$email_obj->smtp_port=$HOST[0]['port'];
		$email_obj->smtp_user=$HOST[0]['user'];
		$email_obj->smtp_realm="";
		$email_obj->smtp_workstation="";
		$email_obj->smtp_password=$HOST[0]['pass'];
		$email_obj->smtp_pop3_auth_host="";
		//important! max 1 rcpt to before waiting for ok, tarpiting!
		$email_obj->maximum_piped_recipients=$HOST[0]['smtp_max_piped_rcpt'];//sends only XX rcpt to before waiting for ok from server!
		#if ($SMTPPopB4SMTP==1)	$email_obj->smtp_pop3_auth_host=$HOST[0]['host'];
		//debug
		if (DEBUG_SMTP) {
			$email_obj->smtp_debug=1;
			$email_obj->smtp_html_debug=0;
		} else {
			$email_obj->smtp_debug=0;
			$email_obj->smtp_html_debug=0;
		}

		$email_obj->SetBulkMail=1;
		$email_obj->mailer=TM_APPTEXT;
		$email_obj->SetEncodedEmailHeader("From",$HOST[0]['sender_email'],$HOST[0]['sender_name']);
		$email_obj->SetEncodedEmailHeader("Reply-To",$HOST[0]['reply_to'],$HOST[0]['sender_name']);
		$email_obj->SetHeader("Return-Path",$HOST[0]['return_mail']);
		$email_obj->SetEncodedEmailHeader("Errors-To",$HOST[0]['return_mail'],$HOST[0]['return_mail']);

		//set additional headers
		//list unsubscribe!
		$email_obj->SetEncodedHeader("List-Unsubscribe",$tm_URL_FE."/unsubscribe.php");
		//date
		$email_obj->SetEncodedHeader("X-TM_DATE",date("Y-m-d H:i:s"));
		//mark massmails
		$email_obj->SetEncodedHeader("X-TM_MASSMAIL",$NL[0]['massmail']);
		//queue id
		$email_obj->SetHeader("X-TM_QID",$Q[$qcc]['id']);
		//newsletter id		
		$email_obj->SetHeader("X-TM_NLID",$NL[0]['id']);
		//adr grp id		
		$email_obj->SetHeader("X-TM_GRPID",$Q[$qcc]['grp_id']);


		//H holen

		//Sendeliste Eintraege die versendet werden duerfen, also kein fehler etc, nur 'neu' , status 1
		//limit $max_mails_atonce
		//nur fuer gewahlte Q, achtung: dadurch muessen wir nl nur einmal holen und auslesen!!!
		//ansonsten muesste man jedesmal nl holen aus hist. nl_id

		//bei massenmail faktor max_mails_bcc!
		//$max_mails=($max_mails_atonce * $max_mails_bcc);
		//bei personalisierter mail ist:
		//$max_mails=$max_mails_atonce;
		$massmail=false;
		if ($NL[0]['massmail']==1) {
			send_log("massmailing");
			$massmail=true;
		} else {
			// hier setzen wir auf 1 damit wir nur einmal die anzal zu berechnen brauchen!
			//personalisiertes newsletter!
			send_log("personalized newsletter!");
			//max bcc adressen =1
			$max_mails_bcc=1;
		}

		//if massmail, we can cache body parts
		if ($massmail) {
			$email_obj->cache_body=1;
		} else {
			$email_obj->cache_body=0;
		}

		$max_mails=($max_mails_atonce * $max_mails_bcc);//maximale anzahl zu bearbeitender mails/empfaenger insgesamt! faktor max_mails_bcc

		send_log("creating list");
		//aktuel offene versandauftraege
		$H=$QUEUE->getHtoSend(0,0,$max_mails,$Q[$qcc]['id']);//id , offset, limit, q_id !!!, ....
		$hc=count($H);//wieviel sendeeintraege

		send_log($hc." Entrys found\n");

		$time=$T->MidResult();
		send_log("time: ".$time);
		send_log("working on max $max_mails addresses in $max_mails_atonce mails with $max_mails_bcc recipients for each mail");
		//wenn massenmailing, body hier schon parsen!!!
		if ($massmail) {
			//to fuer massenmailing
			send_log("prepare Massmail");
			$SUBJ = $NEWSLETTER->parseSubject( Array('text'=>$NL[0]['subject'], 'date'=>date(TM_NL_DATEFORMAT)));//hmmm, we should use date from send_at in q!
			send_log("Subject: ".$NL[0]['subject']);
			send_log("Subject (parsed): ".$SUBJ);
			$email_obj->SetEncodedHeader("Subject",$SUBJ);
			//argh, this class forces us to add a to header which is definitely not needed if we have bcc or cc!!!
			$To=$HOST[0]['sender_email'];//wird $HOST!
			if (!empty($NL[0]['rcpt_name'])) {
					$ToName = $NEWSLETTER->parseRcptName( Array('text'=>$NL[0]['rcpt_name'], 'date'=>date(TM_NL_DATEFORMAT)) );//hmmm, we should use date from send_at in q!
			} else {
				if (!empty($C[0]['rcpt_name'])) {
					$ToName = $NEWSLETTER->parseRcptName( Array('text'=>$C[0]['rcpt_name'], 'date'=>date(TM_NL_DATEFORMAT)) );//hmmm, we should use date from send_at in q!
				} else {
					$ToName="Tellmatic Newsletter";
				}
			}
			send_log("rcpt_name=".$NL[0]['rcpt_name']);
			send_log("ToName=".$ToName);
			#send_log(  "\n".date("Y-m-d H:i:s").":   set To: Header $ToName ($To)");
			send_log("TO: NOT SET, USING BCC");
			//dont add to: header in massmails, only use bcc! but:
			send_log("prepare Template Vars for Massmail");

			//new, 1088, use parseNL
			send_log("parse Newsletter");
			$NLBODY="";
			if ($NL[0]['content_type']=="html" || $NL[0]['content_type']=="text/html") {
				send_log("parse Newsletter html version");
				$NLBODY=$NEWSLETTER->parseNL(Array('nl'=>$NL[0]),"html");
			}
			$NLBODY_TEXT="";
			if ($NL[0]['content_type']=="text" || $NL[0]['content_type']=="text/html") {
				send_log("parse Newsletter text version");
				$NLBODY_TEXT=$NEWSLETTER->parseNL(Array('nl'=>$NL[0]),"text");
			}

			#hmmm, date is set to now! ?
			#weird, but we will get rid of the massmail feature in 1090, so doesnt really matter

		}//massmail

		//Schleife Versandliste h....
		//bei massenmail..... immer um max_mails_bcc erhoehen!
		//(max_mails_bcc) * (hcc/max_mails_bcc) ??? limit... hc
		for ($hcc=0;$hcc<$hc;$hcc=$hcc+$max_mails_bcc) {
			send_log("runnning Entry $hcc to $hcc+$max_mails_bcc");
			//NEUE EMAIL bauen
			send_log("create New Mail");
			
			//schleife... max mails bcc
			$bc=$hcc+$max_mails_bcc;
			$BCC="";
			$BCC_Arr=Array();
			for ($bcc=$hcc;$bcc<$bc;$bcc++) {
				$a_error=false;
				$h_error=false;
				$skipped=false;

				if (isset($H[$bcc]['id'])) {
						//set adr_id for logging						
						$log_adr_id=$H[$bcc]['adr_id'];
						send_log($bcc.".) ");
						// ok, wir muessen nun um zu vermeiden,
						// das bei gleichzeitigen aufrufen doppelte mails verschickt werden,
						// den status erneut abfragen auf 5=running, und wenn nichts gefunden wurde
						// einen status setzen fuer die history 5=running !!!

						//aktuellen eintrag abrufen und auf status 5 pruefen! ebenfalls ob nicht schon status fertig etc.
						//$HRun=$QUEUE->getH($H[$bcc]['id'],0,0,0,0,0,0,5);
						//wir drehen es um, wir pruefen nur ob dieser eintrag in der sendeliste auch noch auf status 1, warten auf versand=neu, steht....
						//function getH($id=0,$offset=0,$limit=0,$q_id=0,$nl_id=0,$grp_id=0,$adr_id=0,$status=0) {
						$HWait=$QUEUE->getH($H[$bcc]['id'],0,0,0,0,0,0,1);
						//und wenn nun hc_run==1 ist, dann senden
						//eigentlich muesste die variable nun HWait und hc_wait heissen!

						//$hc_run=count($HRun);//wieviel running sendeeintraege
						$hc_wait=count($HWait);//wieviel running sendeeintraege
						//wenn der aktuelle eintrag kein status 5 hat, versenden! evtl auch pruefen auf bereits versendet!
						// ^^^korrektur: wenn status == 1 ist, dann versenden, ansonsten ist der eintrag schon irgendwie bearbeitet worden!!!!

						//weil wenn konkurrierende jobs, dann kann der eine 5 setzen und dann ist ok, wenn wir aber gerade dann dort ankommen ... und der eintrag ist noch in im H Array... dann wird email evtl 2x versendet!
						//eigentlich nur kritisch bei konkurrierenden eintraegen
						//umgedreht:
						//if ($hc_run==0) { //ok
						//jetzt abfragen ob was gefunden fuer status wait==1
						send_log("HID: ".$H[$bcc]['id']);
						send_log("adr_id: ".$H[$bcc]['adr_id']);
						send_log("h_status: ".$H[$bcc]['status']."==1");
						if ($hc_wait>0) { //ok

							$send_it=true;//wird gebraucht um versenden abzufangen wenn aktuell bearbeiteter eintrag

							send_log("OK: HID: ".$H[$bcc]['id']);

							//vor der pruefung auf valide email status schon auf 5 setzen, 
							//ist ggf doppelt gemobbelt, kann aber ggf. unter bestimmten Umstaenden dazu fuehren
							// das eine validierung auf gueltigen mx etwas laenger dauert, 
							//der job mit einem anderen konkurriert und waehrend die 
							//pruefung und mx abfrage laeuft der konkurrierende job sich die adresse krallt, man weiss nix genaues nich ;)
							//h eintrag wird zum bearbeiten gesperrt, status 5!
							send_log("setHStatus 5");
							$QUEUE->setHStatus($H[$bcc]['id'],5);

							send_log("adr_id: ".$H[$bcc]['adr_id']);
							//adresse holen
							send_log("getAdr()");
							$ADR=$ADDRESS->getAdr($H[$bcc]['adr_id']);


							//nur senden wenn korrekte emailadr! und fehlerrate < max errors
							//erstmal ok, kein fehler
							//fehler beim senden? adresse ok?
							$a_error=false;
							$h_error=false;
							$a_status=$ADR[0]['status'];
////todo optimierung: check errors vor blacklist und vor mx, spart ggf zeit und abfragen von adressen die eh zu viele fehler haben oder geblacklisted wurden!

							//BLACKLIST prüfen
							if ($Q[$qcc]['check_blacklist']) {
								send_log("checking blacklist");	
								if ($BLACKLIST->isBlacklisted($ADR[0]['email'])) {
									//wenn adr auf blacklist steht, fehler setzen und abbrechen
									send_log("email ".$ADR[0]['email']." matches the active blacklist");
									//statt a_error setzen wir h_error!
									#$a_error=true;
									//aber skipped nutzen
									$skipped=true;
									send_log("set h_status to 6 (canceled)");
									send_log("set skipped=true");
									$h_error=true;
									$h_status=6;//cancel, abbruch (status 6), oder 4 fehler?
									//lieber 6, abbruch, da fehlerhafte q's ggf nochmal bearbeitet werden!
								} else {
									send_log("OK, does not match the active blacklist");
								}
							}

							//email pruefen
							$check_mail=checkEmailAdr($ADR[0]['email'],$EMailcheck_Sendit);
							//if !a_error auch abfragen wegen blacklist pruefung oben!
							//if (!$a_error && $check_mail[0] && $ADR[0]['errors']<=$C[0]['max_mails_retry']) {
							//statt a_error nehmen wir jetzt h_error! das hat den grund das adressen in der blacklist als fehlerhaft markiert wurden mit a_error
							//das waere aber unlogisch! stattdessen h_error und h_status=6
							if (!$skipped && !$h_error && $check_mail[0] && $ADR[0]['errors']<=$C[0]['max_mails_retry']) {
								send_log("checkemail: OK");
								//wenn adresse auch wirklich aktiv etc.
								if ($ADR[0]['aktiv']==1) {
									send_log("Aktiv: OK");
									//status adresse pruefen , kann sich seit eintrag in die liste geaendert haben!
									if ($ADR[0]['status']==1 || $ADR[0]['status']==2 || $ADR[0]['status']==3 || $ADR[0]['status']==4  || $ADR[0]['status']==10 || $ADR[0]['status']==12) {
										send_log("Adr-Status: OK (1|2|3|4|10|12)");
										$h_status=5;
									} else {//adr status
										//////wenn adresse nicht richtigen status, status geaendert wurde nachdem h sendeliste erzeugt....
										/////$a_error=true;
										/////$a_status=8;//fehler, status changed!
										////nein ! ^^ fehler! wir belassen den alten status!!!!
										send_log("Adr-Status: NOT OK !=(1|2|3|4|10|12)");
										$h_status=4;//fehler , aber hier machen wir nen fehler!
										$h_error=true;
									}//adr status

								} else {//adr aktiv
										//addresse nicht aktiv
										//$a_status=8;//fehler, status changed! // adresse wurde zwischenzeitlich deaktiviert, wir belassen alten status!!!
										send_log("Adr not active");
										$h_status=4;//fehler
										$h_error=true;
										//$a_error=true;wir belassen alten status!!!
								}//adr aktiv

							} // if !skipped ...etc

							if (!$check_mail[0] || $ADR[0]['errors']>$C[0]['max_mails_retry']) {
								$a_status=9;//fehlerhafte adr o. ruecklaeufer
								$a_error=true;
								$h_status=4;//fehler
								$h_error=true;
								//adr add memo:
								$log_msg="ERROR: invalid email (".$ADR[0]['email'].") [".$check_mail[1]."] or reached max errors [".$ADR[0]['errors']." of max. ".$C[0]['max_mails_retry']."]";
								$ADDRESS->addMemo($H[$bcc]['adr_id'],"send_it: ".$log_msg);
								send_log($log_msg);
							}//wenn errors > max errors oder !check_mail

							if ($a_error) {
								$log_msg="ERROR: set adr to status=".$a_status;
								$ADDRESS->addMemo($H[$bcc]['adr_id'],"send_it: ".$log_msg);
								send_log($log_msg);
								
								//$ADDRESS->setStatus($H[$bcc]['adr_id'],$a_status);
								$ADDRESS->setStatus($ADR[0]['id'],$a_status);
								$ADDRESS->setAError($ADR[0]['id'],($ADR[0]['errors']+1));//fehler um 1 erhoehen
								//ADR Status
								$log_msg="adr errors (new): ".($ADR[0]['errors']+1);
								$ADDRESS->addMemo($H[$bcc]['adr_id'],"send_it: ".$log_msg);
								send_log($log_msg);
							}

							send_log("set h_status=$h_status");
							$QUEUE->setHStatus($H[$bcc]['id'],$h_status);
							$created=date("Y-m-d H:i:s");
							$QUEUE->setHSentDate($H[$bcc]['id'],$created);


							//wenn kein fehler aufgetreten... dann mail vorbereiten

							if (!$a_error && !$h_error)	{
								if (!$massmail) {

									//add some additional personalized headers
									$email_obj->SetEncodedHeader("X-TM_ACODE",$ADR[0]['code']);  
									$email_obj->SetEncodedHeader("X-TM_AID",$ADR[0]['id']);

									//new, 1088, use parseNL
									send_log("parse Newsletter");
									$NLBODY="empty htmlpart";
									if ($NL[0]['content_type']=="html" || $NL[0]['content_type']=="text/html") {
										send_log("parse Newsletter html version");
										$NLBODY=$NEWSLETTER->parseNL(Array('nl'=>$NL[0],'adr'=>$ADR[0],'h'=>Array('id'=>$H[$bcc]['id']),'q'=>Array('id'=>$H[$bcc]['q_id'])),"html");
									}
									$NLBODY_TEXT="empty textpart";
									if ($NL[0]['content_type']=="text" || $NL[0]['content_type']=="text/html") {
										send_log("parse Newsletter text version");
											$NLBODY_TEXT=$NEWSLETTER->parseNL(Array('nl'=>$NL[0],'adr'=>$ADR[0],'h'=>Array('id'=>$H[$bcc]['id']),'q'=>Array('id'=>$H[$bcc]['q_id'])),"text");
									}

								}//!massmail

								send_log("create Mail, set To/From and prepare Header");
								//Name darf nicht = email sein und auch kein komma enthalten, plaintext!
								//to etc fuer personalisiertes nl:
								if (!$massmail) {
									$SUBJ = $NEWSLETTER->parseSubject( Array('text'=>$NL[0]['subject'], 'date'=>date(TM_NL_DATEFORMAT), 'adr'=>$ADR[0]) );//hmmm, we should use date from send_at in q!
									send_log("Subject: ".$NL[0]['subject']);
									send_log("Subject (parsed): ".$SUBJ);
									$email_obj->SetEncodedHeader("Subject",$SUBJ);
						
									send_log("personal Mailing, add TO:");
									$To=$ADR[0]['email'];
									if (!empty($NL[0]['rcpt_name'])) {
										$RCPT_Name_TMP=$NL[0]['rcpt_name'];
									} else {
										if (!empty($C[0]['rcpt_name'])) {
											$RCPT_Name_TMP=$C[0]['rcpt_name'];
										} else {
											$RCPT_Name_TMP="Tellmatic Newsletter";
										}
									}
									$RCPT_Name = $NEWSLETTER->parseRcptName( Array('text'=>$RCPT_Name_TMP, 'date'=>date(TM_NL_DATEFORMAT), 'adr'=>$ADR[0]) );//hmmm, we should use date from send_at in q!									$RCPT_Name = str_replace($RCPT_Name_search, $RCPT_Name_replace, $RCPT_Name_TMP);
									send_log("rcpt_name: ".$NL[0]['rcpt_name']);
									send_log("rcpt_name_tmp: ".$RCPT_Name_TMP);
									send_log("rcpt_name_parsed: ".$RCPT_Name);
									//rcpt name should NOT be empty AND NOT email!
									$ToName=$RCPT_Name;//hmpf....
									$email_obj->SetEncodedEmailHeader("To",$To,$ToName);//bei massenmailing tun wir das schon oben
								}
								if ($massmail) {
									send_log("Massmailing, add BCC:");
									$BCC.=$ADR[0]['email'];
									$BCC_Arr[$ADR[0]['email']]=$ADR[0]['email'];//create array required by message class.... grml
									if ($bcc<($bc-1) && isset($H[($bcc+1)]['adr_id'])) {
										$BCC.=",";
									}
								}//massenmail

								send_log($ADR[0]['email']);
								//send_log(  "\n      count NL");
								$ADDRESS->addNL($ADR[0]['id']);//newsletter counter hochzaehlen!
								send_log("no.=".$bcc.", email=".$ADR[0]['email'].", adr_id=".$ADR[0]['id'].", status_A=".$ADR[0]['status']."/".$a_status.", status_H=".$H[$bcc]['status']."/".$h_status.",err=".$ADR[0]['errors']);
							} else {// !$a_error && !$h_error
								send_log("*** Address: Error");
							}
						} else {//hc_run==0 bzw $hc_wait>0
							//nix machen
							//send_log(  "\n *** Eintrag wird gerade versendet und wird uebersprungen");
							send_log("*** Entry was already processed");
							if (!$massmail) {
								$send_it=false;
								$skipped=true;
							}
						}
					} else {//if isset h[bcc][id]
						send_log("*** h[][id] not set");
					}
					$ADDRESS->markRecheck($ADR[0]['id'],0);				
				}//for bcc
	/*
	BCC
	*/
				if ($massmail) {
					send_log("BCC=".$BCC);
					$email_obj->SetMultipleEncodedEmailHeader('BCC', $BCC_Arr);
					$email_obj->SetHeader("Precedence","bulk");
					$log_adr_id=0;
				}

			$send_ok=false;

			if (!$a_error && !$h_error && $send_it)	{
				send_log("add Mail Body");

				$use_textpart=false;
				$use_htmlpart=false;
				//add mailparts in first run, otherwise: if massmail: use cached body, add nothing, or if personalized: replace part
				//if massmail and first run, or on each run if personalizef mailing: create parts				
				if ( !$massmail || ($massmail && $hcc==0) ) {
					//create text/html part:
					send_log("Newsletter is from type: '".$NL[0]['content_type']."'");
					//we want mixed multipart, with alternative text/html and attachements, inlineimages and all that
					//text part must be the first one!!!
					if ($NL[0]['content_type']=="text" || $NL[0]['content_type']=="text/html") {
						$use_textpart=true;
						send_log("create TEXT Part");
						//only create part
						$email_obj->CreateQuotedPrintableTextPart($email_obj->WrapText($NLBODY_TEXT),"",$mimepart_text);
					}
					if ($NL[0]['content_type']=="html" || $NL[0]['content_type']=="text/html") {
						$use_htmlpart=true;
						send_log("create HTML Part");
						//only create part
						$email_obj->CreateQuotedPrintableHtmlPart($NLBODY,"",$mimepart_html);
					}

					$partids=array();//array of partnumbers, returned by reference from createpart etc
					if ($use_textpart) {
						array_push($partids,$mimepart_text);
						if (DEBUG) send_log(print_r($mimepart_text));
					}
					if ($use_htmlpart) {
						array_push($partids,$mimepart_html);
						if (DEBUG) send_log(print_r($mimepart_html));
					}
				}//!massmail || ($masmail && hcc==0)
					
				//on first entry add parts
				if ($hcc==0) {
					//AddAlternativeMultiparts
					if (DEBUG) print_r($partids);
					//save initial part ids					
					if ($use_textpart) {
						$mimepart_text_init=$mimepart_text;
					}	
					if ($use_htmlpart) {
						$mimepart_html_init=$mimepart_html;
					}
					send_log("add Parts");
					$email_obj->AddAlternativeMultipart($partids);
				}
				
				//if not massmail: only replace part
				if (!$massmail && $hcc > 0) {
					send_log("replace Parts for personalized mailing");
					if ($use_htmlpart) {
						$email_obj->ReplacePart($mimepart_html_init,$mimepart_html);
					}
					if ($use_textpart) {
						$email_obj->ReplacePart($mimepart_text_init,$mimepart_text);
					}					
				}
				if ($massmail && $hcc > 0) {
					send_log("use cached body parts");
				}
			
				//only add attachements on first run, hcc=0
				if ($hcc==0) {
					//erst jetzt darf der part f.d. attachement hinzugefuegt werden!
					$attachements=$NL[0]['attachements'];
					$atc=count($attachements);
					if ($atc>0) {
						send_log("adding ".$atc." Attachements:");
						foreach ($attachements as $attachfile) {
							if (file_exists($tm_nlattachpath."/".$attachfile['file'])) {
								send_log("add Attachement ".$attachfile['file']);
								$ATTM=array(
									"FileName"=>$tm_nlattachpath."/".$attachfile['file'],
									"Content-Type"=>"automatic/name",
									"Disposition"=>"attachment"
								);
								$email_obj->AddFilePart($ATTM);
							} else {//file_exists
								send_log("Attachement ".$attachfile['file']." does not exist.");
							}//file_exists
						}//foreach
					}//if count/atc
				}//hcc==0
				
				//Send!
				send_log("SEND Mail");
				$smtp_error="";
				if (!DEMO) $smtp_error=$email_obj->Send();

				if (empty($error)) {
					$send_ok=true;
					send_log("OK");
				} else {
					$send_ok=false;
					send_log("ERROR: ".$smtp_error);
				}
			}// !$a_error && !$h_error
			
			//wenn senden ok....fein!
			if ($send_ok) {
				$a_status=2;//ok
				$h_status=2;//gesendet
			} else {
				//wenn nihct uebersprungen, status markieren
				if (!$skipped) {
					$a_status=10;//sende fehler, wait retry
					$h_status=4;//fehler
					$a_error=true;
				}
				if ($skipped) {
					//wenn uebersprungen, alten status behalten
					$h_status=$H[$bcc]['status'];
					//undefined index? hmmm, check!
				}
			}//send ok

			if (!$skipped) {
				send_log("set h status=$h_status for entry $hcc to $bc -1");
				$created=date("Y-m-d H:i:s");
				for ($bcc=$hcc;$bcc<$bc;$bcc++) {
					if (isset($H[$bcc]['id'])) {
						//H Status setzen
						$QUEUE->setHStatus($H[$bcc]['id'],$h_status);
						$QUEUE->setHSentDate($H[$bcc]['id'],$created);
					}
				}
			}

			if ($skipped) {
				send_log("skipped.");
			}

			//wenn kein address-fehler aufgetreten ist und KEIN Massenmailing!
			if (!$massmail && !$a_error && !$skipped) {
					//ADR Fehler zuruecksetzen....
					$ADDRESS->setAError($ADR[0]['id'],0);//fehler auf 0
					//ADR Status
					if ($ADR[0]['status']!=4) {
						send_log("set Adr status: $a_status");
						$ADDRESS->setStatus($ADR[0]['id'],$a_status);
					}
					send_log("set Adr err changed from ".$ADR[0]['errors']." to: 0");
			}//massmail && no error
			$time=$T->MidResult();
			send_log("time: ".$time);
			$log_adr_id=0;

			///hmmm, some of this stuff must go to the bcc loop maybe.
/*
HCC
*/
			//add delay between mails
			if ($HOST[0]['delay']>0) {
				send_log("sleeping: ".($HOST[0]['delay']/1000000)." seconds before processing next entry.");
				usleep($HOST[0]['delay'])	;
			} else {
				send_log("sleeping: 0 seconds, no pause between two mails");
			}
		}//hcc

		send_log("$hc Entrys have been processed");
		$time_total=$T->Result();
		send_log("time total: ".$time_total);

		//Q finished? n omore records in nl_h found?
		if ($hc==0) {
			$created=date("Y-m-d H:i:s");
			//set Q status = finished =4
			send_log("Q ".$Q[$qcc]['id']." finished!");
			$QUEUE->setStatus($Q[$qcc]['id'],4);//fertig
			$QUEUE->setSentDate($Q[$qcc]['id'],$created);//fertig
			$NEWSLETTER->setStatus($Q[$qcc]['nl_id'],4);

			//Daten fuer den Report aus der History holen.....
			$H=$QUEUE->getH(0,0,0,$Q[$qcc]['id']);//getHtoSend($id=0,$offset=0,$limit=0,$q_id=0,$nl_id=0,$grp_id=0,$adr_id=0)
			$hc=count($H);
			$hc_new=0;
			$hc_fail=0;
			$hc_view=0;
			$hc_ok=0;
			for ($hcc=0;$hcc<$hc;$hcc++) {
				if ($H[$hcc]['status']==1)	{
					$hc_new++;
				}
				if ($H[$hcc]['status']==2)	{
					$hc_ok++;
				}
				if ($H[$hcc]['status']==3)	{
					$hc_view++;
					$hc_ok++;
				}
				if ($H[$hcc]['status']==4)	{
					$hc_fail++;
				}
			}//$hc==0, no (more) entries
			
			//report
			//should use a template..... :P
			$G=$ADDRESS->getGroup($Q[$qcc]['grp_id']);
			$ReportMail_Subject="Tellmatic: Q finished (QId: ".$Q[$qcc]['id']." / ".$Q[$qcc]['created'].") ".display($NL[0]['subject'])." an ".display($G[0]['name']);
			$ReportMail_HTML="";
			$created_date=$Q[$qcc]['created'];
			$sent_date=$created;
			$ReportMail_HTML.="<br><b>".$sent_date."</b>".
									"<br>Der Versand des Newsletter <b>".display($NL[0]['subject'])."</b> an die Gruppe <b>".display($G[0]['name'])."</b> ist abgeschlossen.".
									"<br>The Mailing for Newsletter <b>".display($NL[0]['subject'])."</b> to Group <b>".display($G[0]['name'])."</b> is finished.".
									"<br><ul>".
									"Adressen/s:".$hc.
									"<br>Gesendet/Sent: ".$hc_ok.
									"<br>Fehler/Errors:".$hc_fail.
									"<br>versendet am/sent at: ".$sent_date.
									"<br>erstellt (nur versand vorbereitet)/created (prepared): ".$created_date.
									"<br>Log: ".$tm_URL_FE."/".$tm_logdir."/".$logfilename.
									"</ul>";
			if (!DEMO) @SendMail_smtp($HOST[0]['sender_email'],$HOST[0]['sender_name'],$HOST[0]['sender_email'],$HOST[0]['sender_name'],$ReportMail_Subject,clear_text($ReportMail_HTML),$ReportMail_HTML,Array(),$HOST);
			//sendmail_smtp[0]=true/false [1]=""/errormessage
		}//hc==0
//	}//q status 2 o 3

	send_log(($qcc+1)." of $qc Qs");
	send_log("end");
	} //isset HOST[0]!!!!
	#send_log("write Log to ".$tm_URL_FE."/".$tm_logdir."/".$logfilename);
}//$qcc

/*
QCC
*/

if ($called_via_url) {
	echo "</pre>";
	echo	"<meta http-equiv=\"refresh\" content=\"".$reload_intervall."; URL=".TM_DOMAIN.$_SERVER["PHP_SELF"]."\">\n";
	if ($qc==0) {
		echo "<br>".___("Zur Zeit gibt es keine zu verarbeitenden Versandaufträge.");
	}
	echo	"<br>".sprintf(___("Die Seite wird in %s Sekunden automatisch neu geladen."),$reload_intervall).
				"<br>\n".
				___("Klicken Sie auf 'Neu laden' wenn Sie diese Seite erneut aufrufen wollen.").
				"<a href=\"".TM_DOMAIN.$_SERVER["PHP_SELF"]."\"><br>".
				___("Neu laden").
				"</a>";
	echo "\n</body>\n</html>";
}
?>