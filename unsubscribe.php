<?php
/********************************************************************************/
/* this file is part of: / diese Datei ist ein Teil von:                        */
/* tellmatic, the newslettermachine                                             */
/* tellmatic, die Newslettermaschine                                            */
/* 2006/7 by Volker Augustin, multi.art.studio Hanau                            */
/* Contact/Kontakt: mnl@multiartstudio.com                                      */
/* Homepage: www.tellmatic.de                                                   */
/* leave this header in file!                                                   */
/* diesen Header nicht loeschen!                                                */
/* check Homepage for Updates and more Infos                                    */
/* Besuchen Sie die Homepage fuer Updates und weitere Infos                     */
/********************************************************************************/

//config einbinden
include ("./include/mnl_config.inc");

//if unsubscribe.php is included in your script, please set $called_via_url=false; $_CONTENT holds the html output 
if (!isset($_CONTENT)) {$_CONTENT="";}
if (!isset($called_via_url)) {$called_via_url=true;}

//
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

if (checkemailadr($email,$EMailcheck_Intern) && $set=="unsubscribe") {
//unbedingt ^^^ pruefen auf gueltige email!
//sonst findet getAdr alle adressen!!! da search - email null ist / leer ist
	$ADDRESS=new mnlAdr();

	//$ADR=$ADDRESS->getAdr($a_id);
	//adr anhand email suchen!
	$search['email']=$email;
	$ADR=$ADDRESS->getAdr(0,0,1,0,$search);
	//print_r($ADR);
	if (count($ADR)>0) {
		//noch nicht abgemeldet?
		if ($ADR[0]['status']!=11) {
			/*
			if ($ADR[0]['code']==$code) {
			*/
				//im author speichern wir den namen des newsletter etc.
				$author="unsubscribed";
				$NEWSLETTER=new mnlNL();
				$NL=$NEWSLETTER->getNL($nl_id);
				if (count($NL)>0) {
					$author.=" (".$NL[0]['subject'].")";
				}
				//set status adresse, set editor...
				if ($ADDRESS->unsubscribe($ADR[0]['id'],$author)) {
					$ADDRESS->setAktiv($ADR[0]['id'],0);
					//unsubscribed
					if ($send_notification_unsubscribe==1) {
						$created=date("Y-m-d H:i:s");
						//email bei subscrption an admin....
						$SubscriptionMail_Subject="mNL: Abmeldung";
						$SubscriptionMail_HTML="";
						$SubscriptionMail_HTML.="<br><b>".$created."</b>
														<br>'<b>".$author."</b>'
														<br>AID: <b>".$ADR[0]['id']."</b>
														<br>
														<br>Folgender Benutzer hat sich aus der Verteilerliste ausgetragen und moechte kein Newsletter mehr erhalten
														<ul>Daten:
														<li>e-Mail: <b>".$ADR[0]['email']."</b></li>
														<li>F0: <b>".$ADR[0]['f0']."</b></li>
														<li>F1: <b>".$ADR[0]['f1']."</b></li>
														<li>F2: <b>".$ADR[0]['f2']."</b></li>
														<li>F3: <b>".$ADR[0]['f3']."</b></li>
														<li>F4: <b>".$ADR[0]['f4']."</b></li>
														<li>F5: <b>".$ADR[0]['f5']."</b></li>
														<li>F6: <b>".$ADR[0]['f6']."</b></li>
														<li>F7: <b>".$ADR[0]['f7']."</b></li>
														<li>F8: <b>".$ADR[0]['f8']."</b></li>
														<li>F9: <b>".$ADR[0]['f9']."</b></li>
														</ul>
														<br>
														Code: <b>".$code."</b>
														<br>
														<br>
														Der Datensatz wurde de-aktiviert und markiert (Unsubscribed) und wurde ab sofort aus der Empfaengerliste ausgeschlossen.
														";
						@SendMail($From,$FromName,$send_notification_email,$FromName,$SubscriptionMail_Subject,clear_text($SubscriptionMail_HTML),$SubscriptionMail_HTML);
					}//send notify
					$FMESSAGE.= "Sie wurden abgemeldet.";
				} else {//unsubscribe()
					//sonstiger fehler
					$FMESSAGE.= "Fehler!";
				}
			/*
			} else {//code=code
				//code ungueltig
				$FMESSAGE.= "Ungueltig!";
			}
			*/
		} else {//status!=11
			//bereits abgemeldet
			$FMESSAGE.= "Sie sind nicht mehr angemeldet.";
		}
	} else {//count adr
		//adresse existiert nicht, nix gefunden
		$FMESSAGE.= "Adresse Ungueltig!";
	}
} else {
 //keine eingabe
 $FMESSAGE.= "";
}

$email="";// !
include_once($mnl_includepath."/unsubscribe_form.inc");

//new Template
$_Tpl_FRM=new mTemplate();
$_Tpl_FRM->setTemplatePath($mnl_tplpath);
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