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

$_MAIN_DESCR=___("Systemeinstellungen ändern");

if (!$user_is_admin) {
	$_MAIN_MESSAGE.="<br>".___("Sie haben keine Berechtigung dies zu tun");
	$LOGIN->Logout();
}

if ($user_is_admin) {
	$_MAIN_MESSAGE.="";

	$set=getVar("set");

	//field names for query
	$InputName_Name="name";//name
	$$InputName_Name=getVar($InputName_Name);
	$InputName_NotifySubscribe="notify_subscribe";
	$$InputName_NotifySubscribe=getVar($InputName_NotifySubscribe);

	$InputName_NotifyUnsubscribe="notify_unsubscribe";
	$$InputName_NotifyUnsubscribe=getVar($InputName_NotifyUnsubscribe);

	$InputName_NotifyMail="notify_mail";
	$$InputName_NotifyMail=getVar($InputName_NotifyMail);
	$InputName_MaxRetry="max_retry";
	$$InputName_MaxRetry=getVar($InputName_MaxRetry);

	$InputName_ECheckIntern="emailcheck_intern";
	$$InputName_ECheckIntern=getVar($InputName_ECheckIntern);

	$InputName_ECheckSubscribe="emailcheck_subscribe";
	$$InputName_ECheckSubscribe=getVar($InputName_ECheckSubscribe);
	$InputName_CheckVersion="check_version";
	$$InputName_CheckVersion=getVar($InputName_CheckVersion);

	$InputName_TrackImageExisting="track_image_existing";//trackimage auswahl
	$$InputName_TrackImageExisting=getVar($InputName_TrackImageExisting);

	$InputName_TrackImageNew="track_image_new";//trackimage upload
	pt_register("POST","track_image_new");

	$InputName_RCPTName="rcpt_name";//name
	$$InputName_RCPTName=getVar($InputName_RCPTName);


	$CONFIG=new tm_CFG();

	$check=true;
	if ($set=="save") {

		//image
		//imageupload
		// Wurde wirklich eine Datei hochgeladen?
		$uploaded_track_image_new=false;
		if(is_uploaded_file($_FILES["track_image_new"]["tmp_name"])) {
			// Gültige Endung? ($ = Am Ende des Dateinamens) (/i = Groß- Kleinschreibung nicht berücksichtigen)
			if(preg_match("/\." . $allowed_trackimage_filetypes . "$/i", $_FILES["track_image_new"]["name"])) {
				// Datei auch nicht zu groß
				if($_FILES["track_image_new"]["size"] <= $max_upload_size) {
					// Alles OK -> Datei kopieren
					$uploaded_track_image_new_name=$_FILES["track_image_new"]["name"];
					if($check) {
						//http://www.php.net/manual/en/features.file-upload.php, use basename to preserve filename for multiple uploaded files.... if needed ;)
						if (move_uploaded_file($_FILES["track_image_new"]["tmp_name"], $tm_nlimgpath."/".$uploaded_track_image_new_name)) {
							$_MAIN_MESSAGE.= "<br>".___("Track-BILD-Datei erfolgreich hochgeladen.");
							$_MAIN_MESSAGE.= "<ul>".$_FILES["track_image_new"]["name"];
							$_MAIN_MESSAGE.= " / ".$_FILES["track_image_new"]["size"]." Byte";
							$_MAIN_MESSAGE.= ", ".$_FILES["track_image_new"]["type"];
							$_MAIN_MESSAGE.= "<br>".___("gespeichert unter:")." <a href=\"".$tm_URL_FE."/".$tm_nlimgdir."/".$uploaded_track_image_new_name."\"  target=\"_preview\">".$tm_nlimgdir."/".$uploaded_track_image_new_name."</a>";
							$_MAIN_MESSAGE.= "</ul>";
							$uploaded_track_image_new=true;
						} else {
							$_MAIN_MESSAGE.= "<br>".___("Fehler beim kopieren.");
							$_MAIN_MESSAGE.= "<br>".___("Tracker-BILD-Datei konnte nicht hochgeladen werden.");
							$check=false;
						}//copy
					} else {
						$_MAIN_MESSAGE.= "<br>".___("Tracker-BILD-Datei konnte nicht hochgeladen werden.");
					}//check
				} else {
					$_MAIN_MESSAGE.= "<br>".sprintf(___("Die Tracker-BILD-Datei darf nur eine Größe von %s Byte besitzen."),$max_byte_size);
					$check=false;
				}//max size
			} else {
				$_MAIN_MESSAGE.= "<br>".___("Die Tracker-BILD-Datei besitzt eine ungültige Endung.");
				$check=false;
			}//extension
		} else {
		}//no file
		//ende upload image



		//checkinput
		$check_mail=checkEmailAdr($return_mail,$EMailcheck_Intern);
		if (!empty($return_mail) && !$check_mail[0]) {$check=false;$_MAIN_MESSAGE.="<br>".___("Die E-Mail-Adresse für Fehlermeldungen ist nicht gültig.")." ".$check_mail[1];}
		if (($notify_subscribe==1 || $notify_unsubscribe==1) && empty($notify_mail)) {$check=false;$_MAIN_MESSAGE.="<br>".___("Die E-Mail-Adresse für Benachrichtigungen darf nicht leer sein").".";}
		$check_mail=checkEmailAdr($notify_mail,$EMailcheck_Intern);
		if (!empty($notify_mail) && !$check_mail[0]) {$check=false;$_MAIN_MESSAGE.="<br>".___("Die E-Mail-Adresse für Benachrichtigungen bei An-/Abmeldungen ist nicht gültig.")." ".$check_mail[1];}

		//check smtp/pop3 connection .... and maybe give a warning message, dont fail :)
		//still to do , connect doesnt work here, need a testfunction........
		if (!DEMO && $check) {
			$track_image="";
			if ($uploaded_track_image_new) {
				$track_image="/".$uploaded_track_image_new_name;
			} else {
				$track_image=$track_image_existing;
			}
			$CONFIG->updateCFG(Array(
					"siteid"=>TM_SITEID,
					"name"=>$name,
					"notify_mail"=>$notify_mail,
					"notify_subscribe"=>$notify_subscribe,
					"notify_unsubscribe"=>$notify_unsubscribe,
					"max_mails_retry"=>$max_retry,
					"emailcheck_intern"=>$emailcheck_intern,
					"emailcheck_subscribe"=>$emailcheck_subscribe,
					"check_version"=>$check_version,
					"track_image"=>$track_image,
					"rcpt_name"=>$rcpt_name
					));
			$_MAIN_MESSAGE.="<br>".___("Die Einstellungen wurden gespeichert und sind ab sofort gültig")."!";
			$action="adm_set";
		} else {
			include_once (TM_INCLUDEPATH."/adm_set_form.inc.php");
		}
	} else {
		$C=$CONFIG->getCFG(TM_SITEID);
		$$InputName_Name=$C[0]['name'];//
		$$InputName_NotifySubscribe=$C[0]['notify_subscribe'];//
		$$InputName_NotifyUnsubscribe=$C[0]['notify_unsubscribe'];//
		$$InputName_NotifyMail=$C[0]['notify_mail'];//
		$$InputName_MaxRetry=$C[0]['max_mails_retry'];//
		$$InputName_ECheckIntern=$C[0]['emailcheck_intern'];//
		$$InputName_ECheckSubscribe=$C[0]['emailcheck_subscribe'];//
		$$InputName_CheckVersion=$C[0]['check_version'];//
		$$InputName_TrackImageExisting=$C[0]['track_image'];
		$$InputName_RCPTName=$C[0]['rcpt_name'];
		require_once (TM_INCLUDEPATH."/adm_set_form.inc.php");
		#$_MAIN_OUTPUT.="<br><br><a href=\"javascript:switchSection('div_debug');\">".tm_icon("information.png",___("Serverinfo"))."&nbsp;".___("Serverinfo")."</a>";
	}

}//user_is_admin
?>