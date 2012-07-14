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

//send_it.php version 3, smtp direkt + massenmailing!

require_once ("./tm_config.inc.php");
require_once($tm_includepath."/Class_SMTP.inc.php");
#require_once ($tm_includepath."/phphtmlparser/html2text.inc");

$QUEUE=new tm_Q();
$NEWSLETTER=new tm_NL();
$ADDRESS=new tm_ADR();

$T=new Timer();//zeitmessung

$LOG="";

function send_log($text) {
	global $LOG;
	$LOG.=$text;
}


//Q holen
$limitQ=1;//nur ein q eintrag bearbeiten!
$Q=$QUEUE->getQtoSend(0,0,$limitQ,0);//id offse limit nl-id
$qc=count($Q);//wieviel zu sendende q eintraege gibt es?

//Schleife Qs
for ($qcc=0;$qcc<$qc;$qcc++) {
	$logfilename="q_".$Q[$qcc]['id']."_".$Q[$qcc]['grp_id']."_".date_convert_to_string($Q[$qcc]['created']).".log.html";

	send_log("<pre>\n".($qcc+1)." of $qc Qs\nbegin\n");
	//wenn Q status gestartet oder running // 2 oder 3
		send_log("\n\n".date("Y-m-d H:i:s")."\n");
		send_log( "\n QID=".$Q[$qcc]['id']);
		send_log(  "\n Status=".$Q[$qcc]['status']);
		send_log(  "\n nl_id=".$Q[$qcc]['nl_id']);
		send_log(  "\n grp_id=".$Q[$qcc]['grp_id']);

		//set status = running =3
		send_log(  "\n set q status=3");
		$QUEUE->setStatus($Q[$qcc]['id'],3);//running

		//Newsletter holen
		send_log(  "\n get nl");
		$NL=$NEWSLETTER->getNL($Q[$qcc]['nl_id']);


		//status fuer nl auf 3=running setzen
		send_log(  "\n set nl status=3");
		$NEWSLETTER->setStatus($NL[0]['id'],3);//versand gestartet


		//wenn q status==2, neu... dann mail an admin das versenden gestartet wurde....
		if ($Q[$qcc]['status']==2) {
			send_log(  "\n q status =2, sending mail to admin");
			$G=$ADDRESS->getGroup($Q[$qcc]['grp_id']);
			//report an sender....
			$ReportMail_Subject="Tellmatic: Start sending Newsletter (QId: ".$Q[$qcc]['id']." / ".$Q[$qcc]['created'].") ".display($NL[0]['subject'])." an ".display($G[0]['name']);
			$ReportMail_HTML="";
			$created_date=$Q[$qcc]['created'];
			$ReportMail_HTML.="<br><b>".$created_date."</b>".
									"<br>Der Versand des Newsletter <b>".display($NL[0]['subject'])."</b> an die Gruppe <b>".display($G[0]['name'])."</b> wurde gestartet.".
									"<br>The Mailing for Newsletter <b>".display($NL[0]['subject'])."</b> to Group <b>".display($G[0]['name'])."</b> started.".
									"<br>".
									"<br>erstellt (nur versand vorbereitet): /created (prepared): ".$created_date.
									"<br>Versand terminiert fuer: / Send at: ".$Q[$qcc]['send_at'].
									"<br>Gestartet: / Started: ".date("Y-m-d H:i:s").
									"<br>Logfile: ".$tm_URL_FE."/".$tm_logdir."/".$logfilename;
			if (!DEMO) @SendMail($From,$From,$From,$From,$ReportMail_Subject,clear_text($ReportMail_HTML),$ReportMail_HTML);
		}

		//filenames zusammensetzen
		//html datei
		$NL_Filename_N="nl_".date_convert_to_string($NL[0]['created'])."_n.html";
		//bild
		$NL_Imagename1="nl_".date_convert_to_string($NL[0]['created'])."_1.jpg";
		//attachement
		$NL_Attachfile1=$tm_nlattachpath."/a".date_convert_to_string($NL[0]['created'])."_1.".$NL[0]['attm'];
		//online:
		$NL_Filename_P="nl_".date_convert_to_string($NL[0]['created'])."_p.html";
		$NLONLINE_URL=$tm_URL_FE."/".$tm_nldir."/".$NL_Filename_P;
		$NLONLINE="<a href=\"".$NLONLINE_URL."\" target=\"_blank\">";

		//template values
		$IMAGE1="";
		$LINK1="";
		$ATTACH1="";
		$IMAGE1_URL="";
		$LINK1_URL="";
		$ATTACH1_URL="";

		//Bild
		if (file_exists($tm_nlimgpath."/".$NL_Imagename1)) {
			send_log(  "\n  NL Image:".$tm_URL_FE."/".$tm_nlimgdir."/".$NL_Imagename1);
			$IMAGE1_URL=$tm_URL_FE."/".$tm_nlimgdir."/".$NL_Imagename1;
			$IMAGE1="<img src=\"".$IMAGE1_URL."\" border=0>";
		}

		//attachement?
		$ATTM=Array();
		$attach_file=false;
		if (file_exists($NL_Attachfile1)) {
			send_log(  "\n  NL Attachement:".$tm_URL_FE."/".$tm_nlattachdir."/a".date_convert_to_string($NL[0]['created'])."_1.".$NL[0]['attm']);
			$attach_file=true;
			$ATTM=array(
					"FileName"=>$NL_Attachfile1,
					"Content-Type"=>"automatic/name",
					"Disposition"=>"attachment"
					);
			//$email_obj->AddFilePart($ATTM); //dieser part darf erst nach anfuegen des body hinzugefuegt werden, da sonst evtl ein jpeg am anfang der mail erscheint.....
			//leider ne performancebremse aber ok...... beim personalisierten NL ist eh langsam....
			//bei massenmail wird die mail anders zusammengesetzt!
			//link zum attachement fuer newsletter
			$ATTACH1_URL=$tm_URL_FE."/".$tm_nlattachdir."/a".date_convert_to_string($NL[0]['created'])."_1.".$NL[0]['attm'];
			$ATTACH1="<a href=\"".$ATTACH1_URL_FE."\" target=\"_blank\">";
		}

		//Link wird weiter unten aufbereitet da evtl personalisiert .....
		//unsubscribe ist auch personalisiert
		//blindimage ist auch personalisiert

		send_log(  "\n prepare e-Mailobject");
		send_log(  "\n From $FromName ($From)");
		send_log(  "\n Subject".display($NL[0]['subject']));

		//emailobjekt vorbereiten, wird dann kopiert, hier globale einstellungen
		$email_obj=new smtp_message_class;
		$email_obj->default_charset=$encoding;
		$email_obj->authentication_mechanism="LOGIN";
		$email_obj->localhost=$SMTPDomain;
		$email_obj->smtp_host=$SMTPHost;
		$email_obj->smtp_user=$SMTPUser;
		$email_obj->smtp_realm="";
		$email_obj->smtp_workstation="";
		$email_obj->smtp_password=$SMTPPasswd;
		$email_obj->smtp_pop3_auth_host="";
		if ($SMTPPopB4SMTP==1)
		{
			$email_obj->smtp_pop3_auth_host=$SMTPHost;
		}
		$email_obj->smtp_debug=0;
		$email_obj->SetBulkMail=1;
		$email_obj->smtp_html_debug=0;
		$email_obj->mailer=$ApplicationText;
		$email_obj->SetEncodedEmailHeader("From",$From,$FromName);
		$email_obj->SetEncodedEmailHeader("Reply-To",$From,$FromName);
		$email_obj->SetHeader("Return-Path",$ReturnPath);
		$email_obj->SetEncodedEmailHeader("Errors-To",$ReturnPath,$ReturnPath);
		$email_obj->SetEncodedHeader("Subject",$NL[0]['subject']);

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
			send_log(  "\n massmailing");
			$massmail=true;
		} else {
			// hier setzen wir auf 1 damit wir nur einmal die anzal zu berechnen brauchen!
			//personalisiertes newsletter!
			send_log(  "\n personalized newsletter!");
			//max bcc adressen =1
			$max_mails_bcc=1;
		}

		$max_mails=($max_mails_atonce * $max_mails_bcc);//maximale anzahl zu bearbeitender mails/empfaenger insgesamt! faktor max_mails_bcc

		send_log(  "\n creating list");
		//aktuel offene versandauftraege
		$H=$QUEUE->getHtoSend(0,0,$max_mails,$Q[$qcc]['id']);//id , offset, limit, q_id !!!, ....
		$hc=count($H);//wieviel sendeeintraege

		send_log(  "\n  ".$hc." Entrys found\n");

		$time=$T->MidResult();
		send_log(  "\n time: ".$time);

		send_log(  "\n working on total $max_mails addresses in $max_mails_atonce mails with $max_mails_bcc recipients for each mail");

		//wenn massenmailing, body hier schon parsen!!!
		if ($massmail) {
			//to fuer massenmailing
			send_log(  "\n prepare Massmail");
			$To=$From;
			$ToName="Newsletter";

			send_log(  "\n   set To: Header $ToName ($To)");
			$email_obj->SetEncodedEmailHeader("To",$To,$ToName);

			send_log(  "\n prepare Template Vars for Massmail");
			$BLINDIMAGE_URL=$tm_URL_FE."/news_blank.png.php?nl_id=".$Q[$qcc]['nl_id'];
			$UNSUBSCRIBE_URL=$tm_URL_FE."/unsubscribe.php?nl_id=".$Q[$qcc]['nl_id'];

			$SUBSCRIBE_URL=$tm_URL_FE."/subscribe.php?doptin=1&c=&email=";
			$SUBSCRIBE="<a href=\"".$SUBSCRIBE_URL."\" target=\"_blank\">";
			send_log(  "\n   Subscribe (touch/double optin): ".$SUBSCRIBE_URL);

			$BLINDIMAGE="<img src=\"".$BLINDIMAGE_URL."\" border=0>";
			send_log(  "\n   Blindimage: ".$BLINDIMAGE_URL);
			//link zu unsubscribe
			$UNSUBSCRIBE="<a href=\"".$UNSUBSCRIBE_URL."\" target=\"_blank\">";
			send_log(  "\n   Unsubscribe: ".$UNSUBSCRIBE_URL);

			if (!empty($NL[0]['link'])) {
				$LINK1_URL=$tm_URL_FE."/click.php?nl_id=".$Q[$qcc]['nl_id'];
				$LINK1="<a href=\"".$LINK1_URL."\" target=\"_blank\">";
				send_log(  "\n   Link1: ".$LINK1_URL);
			}
			send_log(  "\n     parse Template - Massmailing");
			$_Tpl_NL=new tm_Template();
			$_Tpl_NL->setTemplatePath($tm_nlpath);
			$_Tpl_NL->setParseValue("IMAGE1", $IMAGE1);
			$_Tpl_NL->setParseValue("LINK1", $LINK1);
			$_Tpl_NL->setParseValue("ATTACH1", $ATTACH1);
			$_Tpl_NL->setParseValue("CLOSELINK", "</a>");
			$_Tpl_NL->setParseValue("BLINDIMAGE", $BLINDIMAGE);
			$_Tpl_NL->setParseValue("UNSUBSCRIBE", $UNSUBSCRIBE);
			$_Tpl_NL->setParseValue("SUBSCRIBE", $SUBSCRIBE);
			$_Tpl_NL->setParseValue("NLONLINE", $NLONLINE);

			$_Tpl_NL->setParseValue("IMAGE1_URL", $IMAGE1_URL);
			$_Tpl_NL->setParseValue("LINK1_URL", $LINK1_URL);
			$_Tpl_NL->setParseValue("ATTACH1_URL", $ATTACH1_URL);
			$_Tpl_NL->setParseValue("NLONLINE_URL", $NLONLINE_URL);
			$_Tpl_NL->setParseValue("BLINDIMAGE_URL", $BLINDIMAGE_URL);
			$_Tpl_NL->setParseValue("UNSUBSCRIBE_URL", $UNSUBSCRIBE_URL);
			$_Tpl_NL->setParseValue("SUBSCRIBE_URL", $SUBSCRIBE_URL);

			$_Tpl_NL->setParseValue("EMAIL","");
			$_Tpl_NL->setParseValue("F0","");
			$_Tpl_NL->setParseValue("F1","");
			$_Tpl_NL->setParseValue("F2","");
			$_Tpl_NL->setParseValue("F3","");
			$_Tpl_NL->setParseValue("F4","");
			$_Tpl_NL->setParseValue("F5","");
			$_Tpl_NL->setParseValue("F6","");
			$_Tpl_NL->setParseValue("F7","");
			$_Tpl_NL->setParseValue("F8","");
			$_Tpl_NL->setParseValue("F9","");
			send_log(  "\n   render Template");
			//Template rendern und body zusammenbauen
			$NLBODY=$_Tpl_NL->renderTemplate($NL_Filename_N);//$_Tpl_NL->renderTemplate($NL_Filename_N)//html
			$NLBODY_TEXT=$NEWSLETTER->convertNL2Text($NLBODY,$NL[0]['content_type']);
		}//massmail

		//Schleife Versandliste h....
		//bei massenmail..... immer um max_mails_bcc erhoehen!
		//(max_mails_bcc) * (hcc/max_mails_bcc) ??? limit... hc
		for ($hcc=0;$hcc<$hc;$hcc=$hcc+$max_mails_bcc) { //$hcc=$hcc+$max_mails_bcc //war : $hcc++, jetzt ist offset!
			send_log(  "\n ----------------------------------------------------");
			send_log(  "\n\n runnning Entry $hcc to $hcc+$max_mails_bcc");

			//NEUE EMAIL bauen
			send_log(  "\n create New Mail");
			$email_message=$email_obj;

			//schleife... max mails bcc
			$bc=$hcc+$max_mails_bcc;
			$BCC="";
			for ($bcc=$hcc;$bcc<$bc;$bcc++) {
				if (isset($H[$bcc]['id'])) {
						send_log(  "\n   $bcc : ");
						// ok, wir muessen nun um zu vermeiden,
						// das bei gleichzeitigen aufrufen doppelte mails verschickt werden,
						// den status erneut abfragen auf 5=running, und wenn nichts gefunden wurde
						// einen status setzen fuer die history 5=running !!!

						//aktuellen eintrag abrufen und auf status 5 pruefen! ebenfalls ob nicht schon status fertig etc.
						//$HRun=$QUEUE->getH($H[$bcc]['id'],0,0,0,0,0,0,5);
						//wir drehen es um, wir pruefen nur ob dieser eintrag in der sendeliste auch noch auf status 1, warten auf versand, steht....
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
						send_log( "\n     HID: ".$H[$bcc]['id']." adrid:".$H[$bcc]['adr_id']." ");
						if ($hc_wait>0) { //ok
							
							$send_it=true;//wird gebraucht um versenden abzufangen wenn aktuell bearbeiteter eintrag
							
							send_log( "\n     OK: HID: ".$H[$bcc]['id']." adrid:".$H[$bcc]['adr_id']." --- ");
							//adresse holen
							send_log(  "  getAdr() ");
							$ADR=$ADDRESS->getAdr($H[$bcc]['adr_id']);

							//nur senden wenn korrekte emailadr! und fehlerrate < max errors
							//erstmal ok, kein fehler
							//fehler beim senden? adresse ok?
							$a_error=false;
							$h_error=false;
							$a_status=$ADR[0]['status'];
							$check_mail=checkEmailAdr($ADR[0]['email'],$EMailcheck_Intern);
							if ($check_mail[0] && $ADR[0]['errors']<=$max_mails_retry) {
								send_log(  "   checkemail: OK");
								//wenn adresse auch wirklich aktiv etc.
								if ($ADR[0]['aktiv']==1) {
									send_log(  " Aktiv: OK");
									//status adresse pruefen , kann sich seit eintrag in die liste geaendert haben!
									if ($ADR[0]['status']==1 || $ADR[0]['status']==2 || $ADR[0]['status']==3 || $ADR[0]['status']==4  || $ADR[0]['status']==10 || $ADR[0]['status']==12) {
										send_log(  " Adr-Status: OK (1|2|3|4|10|12)");
										$h_status=5;
									} else {//adr status
										//////wenn adresse nicht richtigen status, status geaendert wurde nachdem h sendeliste erzeugt....
										/////$a_error=true;
										/////$a_status=8;//fehler, status changed!
										////nein ! ^^ fehler! wir belassen den alten status!!!!
										$h_status=4;//fehler , aber hier machen wir nen fehler!
										$h_error=true;
									}//adr status

								} else {//adr aktiv
										//addresse nicht aktiv
										//$a_status=8;//fehler, status changed! // adresse wurde zwischenzeitlich deaktiviert, wir belassen alten status!!!
										$h_status=4;//fehler
										$h_error=true;
										//$a_error=true;wir belassen alten status!!!
								}//adr aktiv

							} else {//wenn errors < max errors // !checkEmailAdr()
								//fehler!
								$a_status=9;//fehlerhafte adr o. ruecklaeufer
								$a_error=true;
								$h_status=4;//fehler
								$h_error=true;
								send_log(  "\n 	ERROR: invalid email: ".$ADR[0]['email']." ".$check_mail[1]);
							}//wenn errors < max errors

							if ($a_error) {
								send_log(  "\n 	ERROR: set adr status=$a_status");
								//$ADDRESS->setStatus($H[$bcc]['adr_id'],$a_status);
								$ADDRESS->setStatus($ADR[0]['id'],$a_status);
								$ADDRESS->setAError($ADR[0]['id'],($ADR[0]['errors']+1));//fehler um 1 erhoehen
								//ADR Status
								send_log(  "\n      err new: ".($ADR[0]['errors']+1));
							}

							send_log(  ", set h status=$h_status");
							$QUEUE->setHStatus($H[$bcc]['id'],$h_status);
							$created=date("Y-m-d H:i:s");
							$QUEUE->setHSentDate($H[$bcc]['id'],$created);


							//wenn kein fehler aufgetreten... dann mail vorbereiten

							if (!$a_error && !$h_error)	{
								if (!$massmail) {
									send_log(  "\n   prepare Template for personal Newsletter");
									//tracker images und link, unsubscribe! da personalisiert kann erst hie rzusammengesetzt werden
									//bild fuer anzeigecheck! funktioniert nur bei html anzeige
									//als parameter dienen h_id nl_id und adr_id
									//nur nl_id bei massenmails! evtl qid wenn man unbedingt noch was auswerten will welche gruppe wieviel bekommen hat etc, geldesen... bla, views + clicks in q
									$BLINDIMAGE_URL=$tm_URL_FE."/news_blank.png.php?h_id=".$H[$hcc]['id']."&nl_id=".$H[$hcc]['nl_id']."&a_id=".$H[$hcc]['adr_id'];
									$BLINDIMAGE="<img src=\"".$BLINDIMAGE_URL."\" border=0>";
									send_log(  "\n   Blindimage: ".$BLINDIMAGE_URL);
									//link zu unsubscribe
									$UNSUBSCRIBE_URL=$tm_URL_FE."/unsubscribe.php?h_id=".$H[$hcc]['id']."&nl_id=".$H[$hcc]['nl_id']."&a_id=".$H[$hcc]['adr_id']."&c=".$ADR[0]['code'];
									$UNSUBSCRIBE="<a href=\"".$UNSUBSCRIBE_URL."\" target=\"_blank\">";

									$SUBSCRIBE_URL=$tm_URL_FE."/subscribe.php?doptin=1&email=".$ADR[0]['email']."&c=".$ADR[0]['code']."&touch=1";
									$SUBSCRIBE="<a href=\"".$SUBSCRIBE_URL."\" target=\"_blank\">";


									send_log(  "\n   Unsubscribe: ".$UNSUBSCRIBE_URL);
									send_log(  "\n   Subscribe (touch/double optin): ".$SUBSCRIBE_URL);

									if (!empty($NL[0]['link'])) {
										$LINK1_URL=$tm_URL_FE."/click.php?h_id=".$H[$hcc]['id']."&nl_id=".$H[$hcc]['nl_id']."&a_id=".$H[$hcc]['adr_id'];
									}
									$LINK1="<a href=\"".$LINK1_URL."\" target=\"_blank\">";
									send_log(  "\n   Link1: ".$LINK1_URL);

								//Template parsen!

									send_log(  "\n     parse Template - personal Mailing");
									$_Tpl_NL=new tm_Template();
									$_Tpl_NL->setTemplatePath($tm_nlpath);
									$_Tpl_NL->setParseValue("IMAGE1", $IMAGE1);
									$_Tpl_NL->setParseValue("LINK1", $LINK1);
									$_Tpl_NL->setParseValue("ATTACH1", $ATTACH1);
									$_Tpl_NL->setParseValue("CLOSELINK", "</a>");
									$_Tpl_NL->setParseValue("BLINDIMAGE", $BLINDIMAGE);
									$_Tpl_NL->setParseValue("UNSUBSCRIBE", $UNSUBSCRIBE);
									$_Tpl_NL->setParseValue("SUBSCRIBE", $SUBSCRIBE);
									$_Tpl_NL->setParseValue("NLONLINE", $NLONLINE);

									$_Tpl_NL->setParseValue("IMAGE1_URL", $IMAGE1_URL);
									$_Tpl_NL->setParseValue("LINK1_URL", $LINK1_URL);
									$_Tpl_NL->setParseValue("ATTACH1_URL", $ATTACH1_URL);
									$_Tpl_NL->setParseValue("NLONLINE_URL", $NLONLINE_URL);
									$_Tpl_NL->setParseValue("BLINDIMAGE_URL", $BLINDIMAGE_URL);
									$_Tpl_NL->setParseValue("UNSUBSCRIBE_URL", $UNSUBSCRIBE_URL);
									$_Tpl_NL->setParseValue("SUBSCRIBE_URL", $SUBSCRIBE_URL);


									$_Tpl_NL->setParseValue("EMAIL", $ADR[0]['email']);
									$_Tpl_NL->setParseValue("F0", $ADR[0]['f0']);
									$_Tpl_NL->setParseValue("F1", $ADR[0]['f1']);
									$_Tpl_NL->setParseValue("F2", $ADR[0]['f2']);
									$_Tpl_NL->setParseValue("F3", $ADR[0]['f3']);
									$_Tpl_NL->setParseValue("F4", $ADR[0]['f4']);
									$_Tpl_NL->setParseValue("F5", $ADR[0]['f5']);
									$_Tpl_NL->setParseValue("F6", $ADR[0]['f6']);
									$_Tpl_NL->setParseValue("F7", $ADR[0]['f7']);
									$_Tpl_NL->setParseValue("F8", $ADR[0]['f8']);
									$_Tpl_NL->setParseValue("F9", $ADR[0]['f9']);
									send_log(  "\n   render Template");
									//Template rendern und body zusammenbauen
									$NLBODY=$_Tpl_NL->renderTemplate($NL_Filename_N);//html
									$NLBODY_TEXT=$NEWSLETTER->convertNL2Text($NLBODY,$NL[0]['content_type']);
								}

								send_log(  "\n    create Mail, set To/From");
								//Name darf nicht = email sein und auch kein komma enthalten, plaintext!
								send_log(  "\n      prepare Header for");
								//to etc fuer personalisiertes nl:
								if (!$massmail) {
									send_log(  " personal Mailing, add TO: ");
									$To=$ADR[0]['email'];
									$ToName="Newsletter";
									$email_message->SetEncodedEmailHeader("To",$To,$ToName);//bei massenmailing tun wir das schon oben
								}
								if ($massmail) {
									send_log(  " Massmailing, add BCC: ");
									$BCC.=$ADR[0]['email'];
									if ($bcc<($bc-1) && isset($H[($bcc+1)]['adr_id'])) {
										$BCC.=",";
									}
								}//massenmail

								send_log(  $ADR[0]['email']);
								//send_log(  "\n      count NL");
								$ADDRESS->addNL($ADR[0]['id']);//newsletter counter hochzaehlen!
								send_log(  "\n      no.: ".$bcc." | email: ".$ADR[0]['email']." | id:".$ADR[0]['id']." | status_A: ".$ADR[0]['status']."/".$a_status." | status_H: ".$H[$bcc]['status']."/".$h_status." err : ".$ADR[0]['errors']);
							} else {// !$a_error && !$h_error
								send_log(  "\n *** Address: Error");
							}
						} else {//hc_run==0 bzw $hc_wait>0
							//nix machen
							//send_log(  "\n *** Eintrag wird gerade versendet und wird uebersprungen");
							send_log(  "\n *** Entry was already processed");
							if (!$massmail) {
								$send_it=false;
							}
						}
					} else {//if isset h[bcc][id]
						send_log(  "\n *** h[][id] not set");
					}
				}//for bcc

				if ($massmail) {
					send_log(  "\n\n BCC=".$BCC."\n\n");
					$email_message->SetHeader("Bcc",$BCC);
					$email_message->SetHeader("Precedence","bulk");
					$email_message->SetBulkMail(1);
				}
				
			$send_ok=false;

			if (!$a_error && !$h_error && $send_it)	{
				send_log(  "\n add Mail Body");
				//text/html part anfuegen:
				send_log(  "\n    Newsletter is from type: '".$NL[0]['content_type']."'");
				if ($NL[0]['content_type']=="html" || $NL[0]['content_type']=="text/html") {
					send_log(  "\n    add HTML Part");
					$email_message->AddQuotedPrintableHtmlPart($NLBODY);
				}
	
				if ($NL[0]['content_type']=="text" || $NL[0]['content_type']=="text/html") {
					send_log(  "\n    add TEXT Part");
					$email_message->AddQuotedPrintableTextPart($NLBODY_TEXT);//$NLBODY_TEXT
				}
	
				//erst jetzt darf der part f.d. attachement hinzugefuegt werden!
				if ($attach_file) {
					send_log(  "\n add Mail Attachement");
					$email_message->AddFilePart($ATTM);
				}

				//Versenden
				send_log(  "\n\n SEND Mail\n");
				if (!DEMO) $error=$email_message->Send();

				if (empty($error)) {
					$send_ok=true;
					send_log(  "   OK");
				} else {
					$send_ok=false;
					send_log(  "   ERROR!!!\n $error \n");
				}
			}//							if (!$a_error && !$h_error)	{
				//wenn senden ok....fein!
				if ($send_ok) {
					$a_status=2;//ok
					$h_status=2;//gesendet
				} else {
					$a_status=10;//sende fehler, wait retry
					$h_status=4;//fehler
					$a_error=true;
				}//send ok

			send_log(  "\n set h status=$h_status for entry $hcc to $bc -1");
			$created=date("Y-m-d H:i:s");
			for ($bcc=$hcc;$bcc<$bc;$bcc++) {
				if (isset($H[$bcc]['id'])) {
					//H Status setzen
					$QUEUE->setHStatus($H[$bcc]['id'],$h_status);
					$QUEUE->setHSentDate($H[$bcc]['id'],$created);
				}
			}

				//////////////////////////////////////////


				//wenn address-fehler aufgetreten ist und KEIN Massenmailing!
				if (!$massmail && !$a_error) {
						//ADR Fehler zuruecksetzen....
						$ADDRESS->setAError($ADR[0]['id'],0);//fehler auf 0
						//ADR Status
						if ($ADR[0]['status']!=4) {
							send_log(  "\n     set Adr status: $a_status");
							$ADDRESS->setStatus($ADR[0]['id'],$a_status);
						}
						send_log(  "\n     set Adr err changhed from ".$ADR[0]['errors']." to: 0");
				}//massmail && no error

			$time=$T->MidResult();
			send_log(  "\n time: ".$time);

		}//hcc

		send_log(  "\n\n $hc Entrys have been processed");
		$time_total=$T->Result();
		send_log(  "\n time: ".$time_total);

		///////////////////////////////////////////////////////////////////////////////////

		//ist die Q beendet? keine zu sendenen eintraege in h gefunden?
		if ($hc==0) {
			$created=date("Y-m-d H:i:s");
			//set Q status = finished =4
			send_log(  "\n Q ".$Q[$qcc]['id']." finished!");
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
			}
			//report an sender....
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
			if (!DEMO) @SendMail($From,$From,$From,$From,$ReportMail_Subject,clear_text($ReportMail_HTML),$ReportMail_HTML);
		}
//	}//q status 2 o 3

	send_log(  "\n\n".($qcc+1)." of $qc Qs \nend\n");
	send_log(  "</pre>\n");
	send_log( "\n\n\n\nwrite Log to ".$tm_URL_FE."/".$tm_logdir."/".$logfilename);

	update_file($tm_logpath,$logfilename,$LOG);

	//a http refresh may work
	echo "<html>\n".
			"<head>\n".
			"<meta http-equiv=\"refresh\" content=\"66; URL=".$tm_Domain.$_SERVER["PHP_SELF"]."\">\n".
			"</head>\n".
			"<body bgcolor=\"#ffffff\">\n".
			sprintf(___("Die Seite wird in %s Sekunden automatisch neu geladen."),"66").
			"<br>\n".
			___("Klicken Sie auf 'Neu laden' wenn Sie diese Seite erneut aufrufen wollen.").
			"<a href=\"".$tm_Domain.$_SERVER["PHP_SELF"]."\"><br>".
			___("Neu laden").
			"</a>";
	echo $LOG;
}//$qcc
if ($qc==0) {
	echo "<html>\n".
			"<head>\n".
			"<meta http-equiv=\"refresh\" content=\"66; URL=".$tm_Domain.$_SERVER["PHP_SELF"]."\">\n".
			"</head>\n".
			"<body bgcolor=\"#ffffff\">\n".
			___("Zur Zeit gibt es keine zu verarbeitenden Versandauftraege.").
			"<br>\n".
			sprintf(___("Die Seite wird in %s Sekunden automatisch neu geladen."),"66").
			"<br>\n".
			___("Klicken Sie auf 'Neu laden' wenn Sie diese Seite erneut aufrufen wollen.").
			"<a href=\"".$tm_Domain.$_SERVER["PHP_SELF"]."\"><br>".
			___("Neu laden").
			"</a>";
}
	echo "\n</body>\n</html>";

?>