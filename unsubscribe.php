<?php
/********************************************************************************/
/* this file is part of: / diese Datei ist ein Teil von:                        */
/* tellmatic, the newslettermachine                                             */
/* tellmatic, die Newslettermaschine                                            */
/* 2006/7 by Volker Augustin, multi.art.studio Hanau                            */
/* Contact/Kontakt: info@tellmatic.org                                      */
/* Homepage: www.tellmatic.de                                                   */
/* leave this header in file!                                                   */
/* diesen Header nicht loeschen!                                                */
/* check Homepage for Updates and more Infos                                    */
/* Besuchen Sie die Homepage fuer Updates und weitere Infos                     */
/********************************************************************************/

//config einbinden
include ("./include/tm_config.inc.php");

//if unsubscribe.php is included in your script, please set $called_via_url=false; $_CONTENT holds the html output
if (!isset($_CONTENT)) {$_CONTENT="";}
if (!isset($called_via_url)) {$called_via_url=true;}

//aufruf: unsubscribe.php?h_id=&nl_id=&a_id=
//oder auch ohne parameter
//da wir ja ein formular haben
//und die email abfragen da wir bei massenmails keinen hinweis haben
//und ein massenmailing kein personalisiertes newsletter ist.....

$MESSAGE="";
$OUTPUT="";
$set=getVar("set");
$h_id=getVar("h_id");
$nl_id=getVar("nl_id");
$a_id=getVar("a_id");
$code=getVar("c");

$FMESSAGE="";

$InputName_Name="email";//email
$$InputName_Name=getVar($InputName_Name);

$check_mail=checkEmailAdr($email,$EMailcheck_Intern);
if ($check_mail[0] && $set=="unsubscribe") {
//unbedingt ^^^ pruefen auf gueltige email!
//sonst findet getAdr alle adressen!!! da search - email null ist / leer ist
	$ADDRESS=new tm_ADR();
	//adr anhand email suchen!
	$search['email']=$email;
	$search['email_exact_match']=true;
	$ADR=$ADDRESS->getAdr(0,0,1,0,$search);
	//print_r($ADR);
	if (count($ADR)>0) {
		//noch nicht abgemeldet?
		if ($ADR[0]['status']!=11) {
				if (checkid($h_id)) {
					$QUEUE=new tm_Q();
					$QUEUE->setHStatus($h_id,7);	//unsubscribe!
				}	
				$created=date("Y-m-d H:i:s");
				//im memo speichern wir den namen des newsletter etc.
				$memo="\n".$created.": unsubscribed";
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
					if ($send_notification_unsubscribe==1) {
						//email bei subscrption an admin....
						$SubscriptionMail_Subject="mNL: Abmeldung";
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
						@SendMail($From,$FromName,$send_notification_email,$FromName,$SubscriptionMail_Subject,clear_text($SubscriptionMail_HTML),$SubscriptionMail_HTML);
					}//send notify
					$FMESSAGE.= $MSG['unsubscribe']['unsubscribe'];
				} else {//unsubscribe()
					//sonstiger fehler
					$FMESSAGE.= $MSG['unsubscribe']['error'];
				}
		} else {//status!=11
			//bereits abgemeldet
			$FMESSAGE.= $MSG['unsubscribe']['already_unsubscribed'];
		}
	} else {//count adr
		//adresse existiert nicht, nix gefunden
		$FMESSAGE.= $MSG['unsubscribe']['invalid_email'];//$check_mail[1]
	}
} else {
 //keine eingabe
 $FMESSAGE.= "";
}
$email="";// !
include_once(TM_INCLUDEPATH."/unsubscribe_form.inc.php");
//new Template
$_Tpl_FRM=new tm_Template();
$_Tpl_FRM->setTemplatePath(TM_TPLPATH);
$_Tpl_FRM->setParseValue("FMESSAGE", $FMESSAGE);
$_Tpl_FRM->setParseValue("FHEAD", $FHEAD);
$_Tpl_FRM->setParseValue("FFOOT", $FFOOT);
$_Tpl_FRM->setParseValue("FSUBMIT", $FSUBMIT);
$_Tpl_FRM->setParseValue("FEMAIL", $FEMAIL);
$OUTPUT=$_Tpl_FRM->renderTemplate("Unsubscribe.html");
//anzeige
if ($called_via_url) {
	echo $OUTPUT;
} else {
	$_CONTENT.= $OUTPUT;
}
?>