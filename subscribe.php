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


//config einbinden
include ("./include/mnl_config.inc");

//if subscribe.php is included in your script, please set frm_id to Form ID and $called_via_url=false; $_CONTENT holds the html output
if (!isset($_CONTENT)) {$_CONTENT="";}
if (!isset($called_via_url)) {$called_via_url=true;}

//

$MESSAGE="";
$OUTPUT="";
if (!isset($frm_id)) {
	$frm_id=getVar("fid");//formular id
}
$set=getVar("set");
$doptin=getVar("doptin");//opt in click, bestaetigung, aus email f. double optin
$email=getVar("email");
$touch=getVar("touch");//touch=1 wenn erster kontakt und benutzer prueft gegen....
//$adr_id=getVar("adr_id");
$c=getVar("c");//recheck code
$check=true;

//opt in click?
if ($doptin==1 && !empty($c) && !empty($email)) { // && checkemailadr($email,$EMailcheck_Intern) //&& !empty($frm_id) rausgenommen!
	//adresse pruefen:
	$_Tpl_FRM=new mTemplate();
	$_Tpl_FRM->setTemplatePath($mnl_formpath);

	if (checkemailadr($email,$EMailcheck_Subscribe)) {
		//double optin bestaetigung:
		//adr suchen, code vergleichen, wenn ok, weiter, sonst ...... leere seite! -?
		$ADDRESS=new mnlADR();
		$search['email']=$email;
		$search['code']=$c;
		//harte pruefung, nur wenn noch nicht bestaetigt:	$search['status']=5;
		//limit=1: adr holen
		$ADR=$ADDRESS->getAdr(0,0,1,0,$search);
	//	print_r($ADR);
		if (!empty($ADR[0]['id']) && $ADR[0]['code']==$c) {
			//ja, code muesste man nicht nochmal pruefen, wird ja in search bereits in der db gesucht....
			//setstatus adr_id = 3
			$ADDRESS->setStatus($ADR[0]['id'],3);
			if (!empty($frm_id)) {
				$FORMULAR=new mnlFRM();
				/*
				//wir zaehlen auch double optins schon bei eintragung...
				//nicht erst bei bestatigung, siehe unten bei anmeldung....
				//alternativ koennte man auch bei double optin die subs erst zaehlen wenn bestateigt wird....:
				//$FORMULAR->addSub($frm_id);
				*/
				//template laden, vielen dank etc, Form_R.html R wie rechecked
				//evtl mail an empfaenger, vielen dank etc... blabla
			}//empty frm_id
			$MESSAGE.="Die Registrierung war erfolgreich.";
		} else {
			$OUTPUT.="not found";
		}

		if ($touch==1) { //not via form, touch optin! always calls Form_0_os.html in the tpldirectory!
			$frm_id=0;
			$_Tpl_FRM->setTemplatePath($mnl_tplpath);//set path for new template Form_0_os.html!
		}
	} else {
		$MESSAGE.="Ungueltige E-Mail-Adresse!.";
	}//checkemail

	$Form_Filename_OS="/Form_".$frm_id."_os.html";//meldung wenn subscribed

	$_Tpl_FRM->setParseValue("FMESSAGE", $MESSAGE);
	//template ausgeben
	$OUTPUT.=$_Tpl_FRM->renderTemplate($Form_Filename_OS);

}

//wenn formularid uebermittelt (fid), nur wenn kein optin recheck!
if ($frm_id>0 && $doptin!=1) {
	//formularfelder definieren, mForm
	$InputName_Name="email";//email
	$$InputName_Name=getVar($InputName_Name);

	$InputName_Captcha="fcpt";//einbgegebener Captcha Code
	$$InputName_Captcha=getVar($InputName_Captcha);
	$cpt=getVar("cpt");//zu pruefender captchacode, hidden field, $captcha_code

	$InputName_F0="f0";
	$$InputName_F0=getVar($InputName_F0);
	$InputName_F1="f1";
	$$InputName_F1=getVar($InputName_F1);
	$InputName_F2="f2";
	$$InputName_F2=getVar($InputName_F2);
	$InputName_F3="f3";
	$$InputName_F3=getVar($InputName_F3);
	$InputName_F4="f4";
	$$InputName_F4=getVar($InputName_F4);
	$InputName_F5="f5";
	$$InputName_F5=getVar($InputName_F5);
	$InputName_F6="f6";
	$$InputName_F6=getVar($InputName_F6);
	$InputName_F7="f7";
	$$InputName_F7=getVar($InputName_F7);
	$InputName_F8="f8";
	$$InputName_F8=getVar($InputName_F8);
	$InputName_F9="f9";
	$$InputName_F9=getVar($InputName_F9);

	$InputName_Memo="memo";
	$$InputName_Memo=clear_text(getVar($InputName_Memo));
	$FORMULAR=new mnlFRM();
	$FRM=$FORMULAR->getForm($frm_id);
	//$FRM[0]['name']

	if ($FRM[0]['aktiv']==1) {

		if ($set=="save") {
			$ADDRESS=new mnlADR();
			$created=date("Y-m-d H:i:s");
			//$date_sub=strftime("%d-%m-%Y %H:%M:%S",mk_microtime($created));
			$date_sub=$created;
			$author=$FRM[0]['id'];

			//double optin
			if ($FRM[0]['double_optin']==1) {
				$status=5;//warten auf recheck
			} else {
				$status=1;//neu
			}
			$MESSAGE="";


			//checkinput
			if ($FRM[0]['use_captcha']==1) {
				if (empty($fcpt) || md5($fcpt)!=$cpt) {$check=false;$MESSAGE.="<br>Spamschutz! Bitte geben Sie untenstehenden Zahlen-Code ein um Ihre Angaben zu bestaetigen.";}
			}
			if (empty($email)) {$check=false;$MESSAGE.="<br>e-Mail darf nicht leer sein.";}
			//email auf gueltigkeit pruefen
			if (!checkemailadr($email,$EMailcheck_Subscribe)) {$check=false;$MESSAGE.="<br>e-Mail hat ein falsches Format oder ist nicht gueltig.";}

			/////// pruefen pflichtfelder!
			if ($FRM[0]['f0_required']==1 && empty($f0) ) {$check=false; $MESSAGE.="<br>Bitte fuellen Sie das Feld '".$FRM[0]['f0']."' aus.";}
			if ($FRM[0]['f1_required']==1 && empty($f1) ) {$check=false; $MESSAGE.="<br>Bitte fuellen Sie das Feld '".$FRM[0]['f1']."' aus.";}
			if ($FRM[0]['f2_required']==1 && empty($f2) ) {$check=false; $MESSAGE.="<br>Bitte fuellen Sie das Feld '".$FRM[0]['f2']."' aus.";}
			if ($FRM[0]['f3_required']==1 && empty($f3) ) {$check=false; $MESSAGE.="<br>Bitte fuellen Sie das Feld '".$FRM[0]['f3']."' aus.";}
			if ($FRM[0]['f4_required']==1 && empty($f4) ) {$check=false; $MESSAGE.="<br>Bitte fuellen Sie das Feld '".$FRM[0]['f4']."' aus.";}
			if ($FRM[0]['f5_required']==1 && empty($f5) ) {$check=false; $MESSAGE.="<br>Bitte fuellen Sie das Feld '".$FRM[0]['f5']."' aus.";}
			if ($FRM[0]['f6_required']==1 && empty($f6) ) {$check=false; $MESSAGE.="<br>Bitte fuellen Sie das Feld '".$FRM[0]['f6']."' aus.";}
			if ($FRM[0]['f7_required']==1 && empty($f7) ) {$check=false; $MESSAGE.="<br>Bitte fuellen Sie das Feld '".$FRM[0]['f7']."' aus.";}
			if ($FRM[0]['f8_required']==1 && empty($f8) ) {$check=false; $MESSAGE.="<br>Bitte fuellen Sie das Feld '".$FRM[0]['f8']."' aus.";}
			if ($FRM[0]['f9_required']==1 && empty($f9) ) {$check=false; $MESSAGE.="<br>Bitte fuellen Sie das Feld '".$FRM[0]['f9']."' aus.";}

			if ($check) {
				///////////////////////////
				//dublettencheck
				$search['email']=$email;
				//auf existenz pruefen und wenn email noch nicht existiert dann eintragen.
				$ADR=$ADDRESS->getAdr(0,0,0,0,$search);
				$ac=count($ADR);
				//oh! adresse ist bereits vorhanden!
				//wir diffen die gruppen und fuegen nur die referenzen hinzu die noch nicht existieren!
				$adr_grp=$ADDRESS->getGroupID(0,0,$frm_id);
				$new_adr_grp=$adr_grp;
				$adr_exists=false;
				if ($ac>0) {
	//				$check=false;
					$MESSAGE.="<br>e-Mail existiert bereits. Ihre Daten wurden aktualisiert.";
					//gruppen denen die adr bereits  angehoert
					$old_adr_grp = $ADDRESS->getGroupID(0,$ADR[0]['id'],0);
					//neue gruppen nur die die neu sind, denen die adr noch nicht angehoert!
					//adr_grp=gruppen aus dem formular
					$new_adr_grp = array_diff($adr_grp,$old_adr_grp);
					$all_adr_grp = array_merge($old_adr_grp, $new_adr_grp);

/*
					print_r($adr_grp);echo "<hr>";
					print_r($old_adr_grp);echo "<hr>";
					print_r($new_adr_grp);echo "<hr>";
					print_r($all_adr_grp);echo "<hr>";
*/
					$adr_exists=true;
				}
				//////////////////////


				srand((double)microtime()*1000000);
				$code=rand(111111,999999);

				if ($adr_exists) {
					//wenn adresse existiert, adressdaten updaten!
					//
					$code=$ADR[0]['code'];
					$ADDRESS->updateAdr(Array(
						"id"=>$ADR[0]['id'],
						"email"=>$email,
						"aktiv"=>$ADR[0]['aktiv'],
						"created"=>$created,
						"author"=>$author,
						"f0"=>$f0,
						"f1"=>$f1,
						"f2"=>$f2,
						"f3"=>$f3,
						"f4"=>$f4,
						"f5"=>$f5,
						"f6"=>$f6,
						"f7"=>$f7,
						"f8"=>$f8,
						"f9"=>$f9,
						"memo"=>"\n".$created.":\n".$memo."\n".$ADR[0]['memo'],
						),
						$all_adr_grp);

					//wenn user abgemeldet und sich wieder anmelden will... dann status aendern, sonst bleibt alles wie es ist...:
					//update status wenn unsubscribed (11)! -- status: 1 , neu
					if ($ADR[0]['status'] ==11) {
						$ADDRESS->setStatus($ADR[0]['id'],1);
						$ADDRESS->setAktiv($ADR[0]['id'],1);
					}
					
					//
					//und neue referenzen zu neuen gruppen hinzufuegen
					//$ADDRESS->addRef($ADR[0]['id'],$new_adr_grp);
					// ^^^ nur fuer den fall das daten nicht geupdated werden!!! sondern nur referenzen hinzugefuegt!
					//optional nachzuruesten und in den settings einstellbar :)

				} else {
					//wenn adresse noch nicht existiert , neu anlegen
					$newADRID=$ADDRESS->addAdr(Array(
						"email"=>$email,
						"aktiv"=>$FRM[0]['subscribe_aktiv'],
						"created"=>$created,
						"status"=>$status,
						"code"=>$code,
						"author"=>$author,
						"f0"=>$f0,
						"f1"=>$f1,
						"f2"=>$f2,
						"f3"=>$f3,
						"f4"=>$f4,
						"f5"=>$f5,
						"f6"=>$f6,
						"f7"=>$f7,
						"f8"=>$f8,
						"f9"=>$f9,
						"memo"=>$created.":\n".$memo,
						),
						$new_adr_grp);
				}


				if ($send_notification_subscribe==1) {
					//email bei subscrption an admin....
					$SubscriptionMail_Subject="";
					$SubscriptionMail_HTML="";
					if ($adr_exists) {
						$SubscriptionMail_Subject="mNL: Aktualisierung '".$FRM[0]['name']."'";
						$SubscriptionMail_HTML.="<br><b>Aktualisierung</b>";
					} else {
						$SubscriptionMail_Subject="mNL: Neuanmeldung '".$FRM[0]['name']."'";
						$SubscriptionMail_HTML.="<br><b>Neuanmeldung</b>";
					}
					$SubscriptionMail_HTML.="<br><b>".$date_sub."</b><br>Neuanmeldung/Aktualisierung ueber das Formular
													<br>'<b>".$FRM[0]['name']."</b>'
													<br>ID: <b>".$FRM[0]['id']."</b>
													<br>
													<ul>Daten:
													<li>e-Mail: <b>".$email."</b></li>
													<li>(F0) ".$FRM[0]['f0'].": <b>".$f0."</b></li>
													<li>(F1) ".$FRM[0]['f1'].": <b>".$f1."</b></li>
													<li>(F2) ".$FRM[0]['f2'].": <b>".$f2."</b></li>
													<li>(F3) ".$FRM[0]['f3'].": <b>".$f3."</b></li>
													<li>(F4) ".$FRM[0]['f4'].": <b>".$f4."</b></li>
													<li>(F5) ".$FRM[0]['f5'].": <b>".$f5."</b></li>
													<li>(F6) ".$FRM[0]['f6'].": <b>".$f6."</b></li>
													<li>(F7) ".$FRM[0]['f7'].": <b>".$f7."</b></li>
													<li>(F8) ".$FRM[0]['f8'].": <b>".$f8."</b></li>
													<li>(F9) ".$FRM[0]['f9'].": <b>".$f9."</b></li>
													</ul>
													<br>
													Code: <b>".$code."</b>
													<br>
													Memo: <b>".$memo."</b>
													<br>
													<br>
													";

					if ($FRM[0]['double_optin']==1) {
						$SubscriptionMail_HTML.="<br>Double Opt-In: Es wurde eine e-Mail zu Bestaetigung an die angegebene Adresse geschickt.
														<br>Es werden keine Newsletter an diesen Empfaenger geschickt,
														<br>bis dieser die Anmeldung bestaetigt hat.";
					}
					if ($adr_exists) {
						$SubscriptionMail_HTML.="<br>Aktualisierung: Daten wurden aktualisiert.<br>
									Diese e-Mailadresse existiert schon.<br>
									Der gespeicherte Datensatz wurde mit den eingegebenen Daten aktualisiert.<br>
									Die Adresse wurde ggf. zusaetzlichen Gruppen zugeordnet";
					} else {
						$SubscriptionMail_HTML.="<br>Neuanmeldung: Daten wurden gespeichert.<br>
									Die Adresse wurde den Gruppen zugewiesen, die fuer dieses Formular zum Zeitpunkt der Anmeldung markiert waren.";
					}

					@SendMail($From,$FromName,$send_notification_email,$FromName,$SubscriptionMail_Subject,clear_text($SubscriptionMail_HTML),$SubscriptionMail_HTML);
				}//send notify

				//send double optin:
				if (!$adr_exists && $FRM[0]['double_optin']==1) {
					//template an angemeldete adr schicken _O
					//SUBSCRIBE ... = link zu subscribe.php , doptin=1, adr_id, code!=$c fid !!
					//EMAIL
					//CLOSELINK
					$SUBSCRIBE_URL=$mnl_URL."/subscribe.php?doptin=1&email=".$email."&fid=".$frm_id."&c=".$code;
					$SUBSCRIBE="<a href=\"".$SUBSCRIBE_URL."\" target=\"_blank\">";

					$Form_Filename_O="/Form_".$frm_id."_o.html";//email wenn doubleoptin
					$_Tpl_FRM=new mTemplate();
					$_Tpl_FRM->setTemplatePath($mnl_formpath);
					$_Tpl_FRM->setParseValue("DATE", $date_sub);
					$_Tpl_FRM->setParseValue("EMAIL", $email);
					$_Tpl_FRM->setParseValue("SUBSCRIBE", $SUBSCRIBE);
					$_Tpl_FRM->setParseValue("SUBSCRIBE_URL", $SUBSCRIBE_URL);
					$_Tpl_FRM->setParseValue("CLOSELINK", "</a>");
					//template ausgeben
					$OptinMail_HTML=$_Tpl_FRM->renderTemplate($Form_Filename_O);
					$OptinMail_Subject="Newsletteranmeldung";
					@SendMail($From,$FromName,$email,$FromName,$OptinMail_Subject,clear_text($OptinMail_HTML),$OptinMail_HTML);
				}

				if (!$adr_exists) {
				//subscription counter hochzaehlen, wenn nicht double opt in dann schon hier, ansonsten erst bei bestaetigung!?
				//nein, wir zaehlen immer.... aber nur bei neuen, nicht bei update!
					$FORMULAR->addSub($frm_id,$newADRID);
				}

				//$MESSAGE.="<br>Vielen Dank! Sie erhalten nun unseren Newsletter.";
			}//check
		}



		//formular template --> id
		$Form_Filename="/Form_".$frm_id.".html";//formular
		$Form_Filename_S="/Form_".$frm_id."_s.html";//meldung wenn subscribed

		//tpl variablen fuellen
		$_Tpl_FRM=new mTemplate();
		$_Tpl_FRM->setTemplatePath($mnl_formpath);

		if (!$check || $set!="save") {

			//captcha code
			$captcha_code="";
			for ($digits=0;$digits<$FRM[0]['digits_captcha'];$digits++) {
				$captcha_code .= rand(0,9);
			}
			$captcha_md5=md5($captcha_code);
			$captcha_text = new Number( $captcha_code );
			$FCAPTCHAIMG=$captcha_text->printNumber();;

			include_once($mnl_includepath."/subscribe_form.inc");

			$_Tpl_FRM->setParseValue("FMESSAGE", $MESSAGE);
			$_Tpl_FRM->setParseValue("FNAME", $FRM[0]['name']);
			$_Tpl_FRM->setParseValue("FDESCR", $FRM[0]['descr']);
			$_Tpl_FRM->setParseValue("FHEAD", $FHEAD);
			$_Tpl_FRM->setParseValue("FFOOT", $FFOOT);
			$_Tpl_FRM->setParseValue("FRESET", $FRESET);
			$_Tpl_FRM->setParseValue("FSUBMIT", $FSUBMIT);
			$_Tpl_FRM->setParseValue("FEMAIL", $FEMAIL);
			$_Tpl_FRM->setParseValue("FEMAILNAME", "e-Mail");
			$_Tpl_FRM->setParseValue("FCAPTCHA", $FCAPTCHA);
			$_Tpl_FRM->setParseValue("FCAPTCHAIMG", $FCAPTCHAIMG);
			$_Tpl_FRM->setParseValue("F0", $F0);
			$_Tpl_FRM->setParseValue("F1", $F1);
			$_Tpl_FRM->setParseValue("F2", $F2);
			$_Tpl_FRM->setParseValue("F3", $F3);
			$_Tpl_FRM->setParseValue("F4", $F4);
			$_Tpl_FRM->setParseValue("F5", $F5);
			$_Tpl_FRM->setParseValue("F6", $F6);
			$_Tpl_FRM->setParseValue("F7", $F7);
			$_Tpl_FRM->setParseValue("F8", $F8);
			$_Tpl_FRM->setParseValue("F9", $F9);
			$_Tpl_FRM->setParseValue("F0NAME", $FRM[0]['f0']);
			$_Tpl_FRM->setParseValue("F1NAME", $FRM[0]['f1']);
			$_Tpl_FRM->setParseValue("F2NAME", $FRM[0]['f2']);
			$_Tpl_FRM->setParseValue("F3NAME", $FRM[0]['f3']);
			$_Tpl_FRM->setParseValue("F4NAME", $FRM[0]['f4']);
			$_Tpl_FRM->setParseValue("F5NAME", $FRM[0]['f5']);
			$_Tpl_FRM->setParseValue("F6NAME", $FRM[0]['f6']);
			$_Tpl_FRM->setParseValue("F7NAME", $FRM[0]['f7']);
			$_Tpl_FRM->setParseValue("F8NAME", $FRM[0]['f8']);
			$_Tpl_FRM->setParseValue("F9NAME", $FRM[0]['f9']);
			$_Tpl_FRM->setParseValue("MEMO", $FMEMO);
			//template ausgeben
			$OUTPUT=$_Tpl_FRM->renderTemplate($Form_Filename);

		} else {

			$_Tpl_FRM->setParseValue("FMESSAGE", $MESSAGE);
			$_Tpl_FRM->setParseValue("FNAME", $FRM[0]['name']);
			$_Tpl_FRM->setParseValue("FDESCR", $FRM[0]['descr']);
			$_Tpl_FRM->setParseValue("FEMAIL", $email);
			$_Tpl_FRM->setParseValue("FEMAILNAME", "e-Mail");
			$_Tpl_FRM->setParseValue("F0", $f0);
			$_Tpl_FRM->setParseValue("F1", $f1);
			$_Tpl_FRM->setParseValue("F2", $f2);
			$_Tpl_FRM->setParseValue("F3", $f3);
			$_Tpl_FRM->setParseValue("F4", $f4);
			$_Tpl_FRM->setParseValue("F5", $f5);
			$_Tpl_FRM->setParseValue("F6", $f6);
			$_Tpl_FRM->setParseValue("F7", $f7);
			$_Tpl_FRM->setParseValue("F8", $f8);
			$_Tpl_FRM->setParseValue("F9", $f9);
			$_Tpl_FRM->setParseValue("F0NAME", $FRM[0]['f0']);
			$_Tpl_FRM->setParseValue("F1NAME", $FRM[0]['f1']);
			$_Tpl_FRM->setParseValue("F2NAME", $FRM[0]['f2']);
			$_Tpl_FRM->setParseValue("F3NAME", $FRM[0]['f3']);
			$_Tpl_FRM->setParseValue("F4NAME", $FRM[0]['f4']);
			$_Tpl_FRM->setParseValue("F5NAME", $FRM[0]['f5']);
			$_Tpl_FRM->setParseValue("F6NAME", $FRM[0]['f6']);
			$_Tpl_FRM->setParseValue("F7NAME", $FRM[0]['f7']);
			$_Tpl_FRM->setParseValue("F8NAME", $FRM[0]['f8']);
			$_Tpl_FRM->setParseValue("F9NAME", $FRM[0]['f9']);
			$_Tpl_FRM->setParseValue("MEMO", $memo);
			//template ausgeben
			$OUTPUT=$_Tpl_FRM->renderTemplate($Form_Filename_S);

		}

	} else {
		$OUTPUT.="na";
	}//aktiv==1
} else {
	//$OUTPUT.="?";
}//frm_id>0

//anzeige
if ($called_via_url) {
	echo $OUTPUT;
} else {
	$_CONTENT.= $OUTPUT;
}
?>