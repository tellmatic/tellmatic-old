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
//if unsubscribe.php is included in your script, please set $called_via_url=false; $_CONTENT holds the html output
if (!isset($_CONTENT)) {$_CONTENT="";}
if (!isset($called_via_url)) {$called_via_url=true;}

$HOSTS=new tm_HOST();
$HOST=$HOSTS->getStdSMTPHost();
//aufruf: unsubscribe.php?h_id=&nl_id=&a_id=
//oder auch ohne parameter
//da wir ja ein formular haben
//und die email abfragen da wir bei massenmails keinen hinweis haben
//und ein massenmailing kein personalisiertes newsletter ist.....

$ADDRESS=new tm_ADR();
$MESSAGE="";
$FMESSAGE="";
$OUTPUT="";
$set=getVar("set");
$h_id=getVar("h_id");
$nl_id=getVar("nl_id");
$a_id=getVar("a_id");
$code=getVar("c");
$check=true;

$InputName_Name="email";//email
$$InputName_Name=getVar($InputName_Name);

$InputName_Captcha="fcpt";//einbgegebener Captcha Code
$$InputName_Captcha=getVar($InputName_Captcha);
$cpt=getVar("cpt");//zu pruefender captchacode, hidden field, $captcha_code
//if isset $a_id and adr exists and adr code=c, then prefill email!
if (check_dbid($a_id)) {
	$ADR_TMP=$ADDRESS->getAdr($a_id);
	//found entry?
	if (count($ADR_TMP)>0) {
		if (DEBUG) {
			$FMESSAGE.="<br>found entry with id $a_id";
		}
		//additionally check code!
		if ($ADR_TMP[0]['code']==$code) {
			if (DEBUG) {
				$FMESSAGE.="<br>code ok!";
				$FMESSAGE.="<br>email: ".display($ADR_TMP[0]['email']);
			}
			//ok, prefill value with email fetched from db via adr_id
			$$InputName_Name=$ADR_TMP[0]['email'];
		} else {
			if (DEBUG) {
				$FMESSAGE.="<br>code NOT ok!";
			}
		}
	}
}
//check input

if ($set=='unsubscribe' && ( !is_numeric($fcpt) || empty($fcpt) || md5($fcpt)!=$cpt ) ) {
		$check=false;
		$email="";
		$FMESSAGE.=$MSG['unsubscribe']['invalid_captcha'];
}

$check_mail=checkEmailAdr($email,$EMailcheck_Subscribe);
 if ($set=='unsubscribe' && !$check_mail[0]) {
	$check=false;
	$email=""; 
	$FMESSAGE.="<br>".$MSG['unsubscribe']['invalid_email'];
 } 
//create captcha code
#if (!$check || $set!='unsubscribe') {
	//create captcha code
	//captcha digits werden einzeln erzeugt ....
	$captcha_code="";
	//5 digits
	for ($digits=0;$digits<5;$digits++) {
		if ($digits>0) {
			$captcha_code .= rand(0,9);
		} else {
			$captcha_code .= rand(1,9);//wenn digits=0 == erste stelle, dann keine fuehrende 0!!! bei 1 beginnen.
		}
	}
	//der md5 wird im formular uebergeben und dann mit dem md5 der eingabe verglichen
	$captcha_md5=md5($captcha_code);
	//erzeugt neuen css captcha
	$captcha_text = new Number( $captcha_code );
	//rendert den css captcha
	$FCAPTCHAIMG=$captcha_text->printNumber();
	//$FCAPTCHAIMG ist jetzt der html code fuer den css captcha...
#}//if set !=unsubscribe

//unsubscribe
if ($check && $set=="unsubscribe") {
//unbedingt ^^^ pruefen auf gueltige email!
//sonst findet getAdr alle adressen!!! da search - email null ist / leer ist
	//adr anhand email suchen!
	$search['email']=$email;
	$search['email_exact_match']=true;
	$ADR=$ADDRESS->getAdr(0,0,1,0,$search);
	//print_r($ADR);
	if (count($ADR)>0) {
		//noch nicht abgemeldet?
		if ($ADR[0]['status']!=11) {
			/*
			if ($ADR[0]['code']==$code) {
			*/
				if (checkid($h_id)) {
					$QUEUE=new tm_Q();
					$QUEUE->setHStatus($h_id,7);	//unsubscribe!
				}
				$created=date("Y-m-d H:i:s");
				//im memo speichern wir den namen des newsletter etc.
				$memo="unsubscribed";
				$NEWSLETTER=new tm_NL();
				$NL=$NEWSLETTER->getNL($nl_id);
				if (count($NL)>0) {
					$memo.=" (".$NL[0]['subject'].")";
				}
				//set status adresse, set editor...
				if ($ADDRESS->unsubscribe($ADR[0]['id'],$author)) {
					$ADDRESS->setAktiv($ADR[0]['id'],0);
					$ADDRESS->addMemo($ADR[0]['id'],$memo);
					//unsubscribed
					if ($C[0]['notify_unsubscribe']==1) {
						//email bei subscrption an admin....
						$SubscriptionMail_Subject="Tellmatic: Abmeldung";
						$SubscriptionMail_HTML="";
						$SubscriptionMail_HTML.="<br><b>".$created."</b>\n".
														"<br>'<b>".$memo."</b>'\n".
														"<br>AID: <b>".$ADR[0]['id']."</b>\n".
														"<br>\n".
														"<br>Folgender Benutzer hat sich aus der Verteilerliste ausgetragen und moechte kein Newsletter mehr erhalten:\n".
														"<br>The following user has unsubscribed:\n".
														"<ul>Daten:\n".
														"<li>e-Mail: <b>".$ADR[0]['email']."</b></li>\n".
														"<li>F0: <b>".$ADR[0]['f0']."</b></li>\n".
														"<li>F1: <b>".$ADR[0]['f1']."</b></li>\n".
														"<li>F2: <b>".$ADR[0]['f2']."</b></li>\n".
														"<li>F3: <b>".$ADR[0]['f3']."</b></li>\n".
														"<li>F4: <b>".$ADR[0]['f4']."</b></li>\n".
														"<li>F5: <b>".$ADR[0]['f5']."</b></li>\n".
														"<li>F6: <b>".$ADR[0]['f6']."</b></li>\n".
														"<li>F7: <b>".$ADR[0]['f7']."</b></li>\n".
														"<li>F8: <b>".$ADR[0]['f8']."</b></li>\n".
														"<li>F9: <b>".$ADR[0]['f9']."</b></li>\n".
														"</ul>\n".
														"<br>\n".
														"Code: <b>".$code."</b>\n".
														"<br>\n".
														"<br>\n".
														"Der Datensatz wurde de-aktiviert und markiert (Unsubscribed) und wurde ab sofort aus der Empfaengerliste ausgeschlossen.\n".
														"<br>The Address has been deactivated and marked as unsubscribed and will be excluded from recipients list.\n";
						@SendMail($HOST[0]['sender_email'],$HOST[0]['sender_name'],$C[0]['notify_mail'],$HOST[0]['sender_name'],$SubscriptionMail_Subject,clear_text($SubscriptionMail_HTML),$SubscriptionMail_HTML,Array(),$HOST);//fixed, now uses defaulthost
					}//send notify
					$FMESSAGE.= $MSG['unsubscribe']['unsubscribe'];
				} else {//unsubscribe()
					//sonstiger fehler
					$email="";
					$FMESSAGE.= $MSG['unsubscribe']['error'];
				}
			/*
			} else {//code=code
				//code ungueltig
				$email="";
				$FMESSAGE.= $MSG['unsubscribe']['error'];
			}
			*/
		} else {//status!=11
			//bereits abgemeldet
			$email="";
			$FMESSAGE.= $MSG['unsubscribe']['already_unsubscribed'];
		}
	} else {//count adr
		//adresse existiert nicht, nix gefunden
		$email="";
		$FMESSAGE.= $MSG['unsubscribe']['invalid_email'];//$check_mail[1]
	}
} else {
 //keine eingabe
 $FMESSAGE.= "";
}

require_once(TM_INCLUDEPATH."/unsubscribe_form.inc.php");
//new Template
$_Tpl_FRM=new tm_Template();
$_Tpl_FRM->setTemplatePath(TM_TPLPATH);
$_Tpl_FRM->setParseValue("FMESSAGE", $FMESSAGE);
$_Tpl_FRM->setParseValue("FHEAD", $FHEAD);
$_Tpl_FRM->setParseValue("FFOOT", $FFOOT);
$_Tpl_FRM->setParseValue("FSUBMIT", $FSUBMIT);
$_Tpl_FRM->setParseValue("FEMAIL", $FEMAIL);
$_Tpl_FRM->setParseValue("FCAPTCHA", $FCAPTCHA);
$_Tpl_FRM->setParseValue("FCAPTCHAIMG", $FCAPTCHAIMG);
$OUTPUT=$_Tpl_FRM->renderTemplate("Unsubscribe.html");
//anzeige
if ($called_via_url) {
	echo $OUTPUT;
} else {
	$_CONTENT.= $OUTPUT;
}
?>