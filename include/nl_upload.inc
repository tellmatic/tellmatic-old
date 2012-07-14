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

	//dateiupload
	$file_content="";
	$body_tmp="";
	
	$uploaded_html=false;
	$uploaded_image1=false;
	$uploaded_attach1=false;
	
	echo $created."    ".date_convert_to_string($created);
	
	//hochgeladene html datei
	$NL_Filename="nl_".date_convert_to_string($created).".html";
	//komplettes newsletter raw, body+file
	$NL_Filename_N="nl_".date_convert_to_string($created)."_n.html";
	//geparster Newsletter Online
	$NL_Filename_P="nl_".date_convert_to_string($created)."_p.html";
	//Bild 1
	$NL_Imagename1="nl_".date_convert_to_string($created)."_1.jpg";
	//Attachement 1
	$NL_Attachname1="a".date_convert_to_string($created)."_1.";//+extension!!! wie uploaded file! weiter unten!



	//html datei
	// Wurde wirklich eine Datei hochgeladen?
	if(is_uploaded_file($_FILES["file"]["tmp_name"])) {
		// Gültige Endung? ($ = Am Ende des Dateinamens) (/i = Groß- Kleinschreibung nicht berücksichtigen)
		if(preg_match("/\." . $allowed_html_filetypes . "$/i", $_FILES["file"]["name"])) {
			// Datei auch nicht zu groß
			if($_FILES["file"]["size"] <= $max_upload_size) {
				// Alles OK -> Datei kopieren
				if($check && copy($_FILES["file"]["tmp_name"], $mnl_nlpath."/".$NL_Filename)) { //$_FILES["file"]["name"]
					$_MAIN_MESSAGE.= "<br>".___("HTML-Datei erfolgreich hochgeladen.");
					$_MAIN_MESSAGE.= "<ul>".$_FILES["file"]["name"];
					$_MAIN_MESSAGE.= " / ".$_FILES["file"]["size"]." Byte";
					$_MAIN_MESSAGE.= ", ".$_FILES["file"]["type"];
					$_MAIN_MESSAGE.= "<br>".___("HTML-Code wurde angef&uuml;gt.").
											"<br>".___("Datei gespeichert unter:")." <a href=\"".$mnl_nldir."/".$NL_Filename."\" target=\"_preview\">".$mnl_nldir."/".$NL_Filename."</a>";
					$_MAIN_MESSAGE.= "</ul>";
					$uploaded_html=true;
				} else {
					$_MAIN_MESSAGE.= "<br>".___("HTML-Datei konnte nicht hochgeladen werden.");
					$check=false;
				}//copy
			} else {
				$_MAIN_MESSAGE.= "<br>".sprintf(___("Die HTML-Datei darf nur eine Gr&ouml;sse von %s Byte haben."),$max_byte_size);
				$check=false;
			}//max size
		} else {
			$_MAIN_MESSAGE.= "<br>".___("Die HTML-Datei besitzt eine ung&uuml;ltige Endung.");
			$check=false;
		}//extension
	} else {
		//$_MAIN_MESSAGE.= "Keine HTML-Datei zum Hochladen angegeben.";
	}//no file
	//ende upload html

	//image
	//imageupload
	// Wurde wirklich eine Datei hochgeladen?
	if(is_uploaded_file($_FILES["image1"]["tmp_name"])) {
		// Gültige Endung? ($ = Am Ende des Dateinamens) (/i = Groß- Kleinschreibung nicht berücksichtigen)
		if(preg_match("/\." . $allowed_image_filetypes . "$/i", $_FILES["image1"]["name"])) {
			// Datei auch nicht zu groß
			if($_FILES["image1"]["size"] <= $max_upload_size) {
				// Alles OK -> Datei kopieren
				if($check && copy($_FILES["image1"]["tmp_name"], $mnl_nlimgpath."/".$NL_Imagename1)) { //$_FILES["image"]["name"]
					$_MAIN_MESSAGE.= "<br>".___("BILD-Datei erfolgreich hochgeladen.");
					$_MAIN_MESSAGE.= "<ul>".$_FILES["image1"]["name"];
					$_MAIN_MESSAGE.= " / ".$_FILES["image1"]["size"]." Byte";
					$_MAIN_MESSAGE.= ", ".$_FILES["image1"]["type"];
					$_MAIN_MESSAGE.= "<br>".___("gespeichert unter:")." <a href=\"".$mnl_nlimgdir."/".$NL_Imagename1."\"  target=\"_preview\">".$mnl_nlimgdir."/".$NL_Imagename1."</a>";
					$_MAIN_MESSAGE.= "</ul>";
					$uploaded_image1=true;
				} else {
					$_MAIN_MESSAGE.= "<br>".___("BILD-Datei konnte nicht hochgeladen werden.");
					$check=false;
				}//copy
			} else {
				$_MAIN_MESSAGE.= "<br>".sprintf(___("Die BILD-Datei darf nur eine Gr&ouml;sse von %s Byte besitzen."),$max_byte_size);
				$check=false;
			}//max size
		} else {
			$_MAIN_MESSAGE.= "<br>".___("Die BILD-Datei besitzt eine ung&uuml;ltige Endung.");
			$check=false;
		}//extension
	} else {
		//$_MAIN_MESSAGE.= "Keine HTML-Datei zum Hochladen angegeben.";
	}//no file

	
//ende upload image


	//attachement
	//attaxchement upload
	// Wurde wirklich eine Datei hochgeladen?
	$attach_ext="";
	if(is_uploaded_file($_FILES["attach1"]["tmp_name"])) {
		// Gültige Endung? ($ = Am Ende des Dateinamens) (/i = Groß- Kleinschreibung nicht berücksichtigen)
		//if(preg_match("/\." . $allowed_attach_filetypes . "$/i", $_FILES["attach1"]["name"])) {
			// Datei auch nicht zu groß
			if($_FILES["attach1"]["size"] <= $max_upload_size) {
				// Alles OK -> Datei kopieren

				$attachinfo=pathinfo($_FILES["attach1"]["name"]);
				$attach_ext=$attachinfo['extension'];
				$NL_Attachname1.=$attach_ext;

				if($check && copy($_FILES["attach1"]["tmp_name"], $mnl_nlattachpath."/".$NL_Attachname1)) { //$_FILES["image"]["name"]
					$_MAIN_MESSAGE.= "<br>".___("Anhang erfolgreich hochgeladen.");
					$_MAIN_MESSAGE.= "<ul>".$_FILES["attach1"]["name"];
					$_MAIN_MESSAGE.= " / ".$_FILES["attach1"]["size"]." Byte";
					$_MAIN_MESSAGE.= ", ".$_FILES["attach1"]["type"];
					$_MAIN_MESSAGE.= "<br>".___("gespeichert unter:")." <a href=\"".$mnl_nlattachdir."/".$NL_Attachname1."\"  target=\"_preview\">".$mnl_nlattachdir."/".$NL_Attachname1."</a>";
					$_MAIN_MESSAGE.= "</ul>";
					$uploaded_attach1=true;
				} else {
					$_MAIN_MESSAGE.= "<br>".___("Anhang konnte nicht hochgeladen werden.");
					$check=false;
				}//copy
			} else {
				$_MAIN_MESSAGE.= "<br>".sprintf(___("Der Anhang Datei darf nur eine Gr&ouml;sse von %s Byte haben."),$max_byte_size);
				$check=false;
			}//max size
		/*
		} else {
			$_MAIN_MESSAGE.= "<br>".___("Der Anhang besitzt eine ung&uuml;tige Endung.");
			$check=false;
		}//extension
		*/
	} else {
		//$_MAIN_MESSAGE.= ___("Keine Datei zum Hochladen angegeben.");
	}//no file

	
//ende upload attachement

	// kompletter content= $body + html content = $body_tmp	
	if (file_exists($mnl_nlpath."/".$NL_Filename)) {
		$file_content.=file_get_contents($mnl_nlpath."/".$NL_Filename);
	}
	$body_tmp=$body.$file_content;
	// wenn html datei hochgeladen, datei auslesen und an eingegebenen Content anhaengen! $body_tmp !
	// 	vorher/nachher option?
	//wir speichern nur ungeparsten content in der DB!!!! ---> $body
	//und in einer Datei! als Template fuer den geparsten Newsletter

	$body_tmp=stripslashes($body_tmp);
	write_file($mnl_nlpath,$NL_Filename_N,$body_tmp);
	//wird nun zur onlineversion geparsed!
	//////////////////////////////////////////////////////////////////
	//geparster content, wird als nl file gespeichert nl+created bei new und update!
	// ----> $body_tmp; --> Template ist $NL_Filename_N
	//content parsen nach  {IMAGE1} etc.
	//dieses dann ersetzen durch das bild!
	//template values
	$IMAGE1="";
	$LINK1="";
	$ATTACH1="";
	$IMAGE1_URL="";
	$LINK1_URL="";
	$ATTACH1_URL="";
	//Bild
	if (file_exists($mnl_nlimgpath."/".$NL_Imagename1)) {
		$IMAGE1_URL=$mnl_URL."/".$mnl_nlimgdir."/".$NL_Imagename1;
		$IMAGE1="<img src=\"".$IMAGE1_URL."\" border=0>";
	}
	//Link
	if (!empty($link)) {
		$LINK1_URL=$link;
		$LINK1="<a href=\"".$LINK1_URL."\" target=\"_link\">";
	}
	//link zu attachement:
	//attachement?
	$NL_Attachfile1=$mnl_nlattachpath."/".$NL_Attachname1;
	if (file_exists($NL_Attachfile1)) {
		//link zum attachement fuer newsletter
		$ATTACH1_URL=$mnl_URL."/".$mnl_nlattachdir."/".$NL_Attachname1;
		$ATTACH1="<a href=\"".$ATTACH1_URL."\" target=\"_blank\">";
	}
	//blindimage
	$BLINDIMAGE_URL=$mnl_URL."/news_blank.png.php";//?nl_id=".$Q[$qcc]['nl_id'];
	$BLINDIMAGE="<img src=\"".$BLINDIMAGE_URL."\" border=0>";
	//link zu unsubscribe
	$UNSUBSCRIBE_URL=$mnl_URL."/unsubscribe.php";//?nl_id=".$Q[$qcc]['nl_id'];
	$UNSUBSCRIBE="<a href=\"".$UNSUBSCRIBE_URL."\" target=\"_blank\">";
	//link zur onlineversion, geparsed
	$NLONLINE_URL=$mnl_URL."/".$mnl_nldir."/".$NL_Filename_P;
	$NLONLINE="<a href=\"".$NLONLINE_URL."\" target=\"_blank\">";

	$SUBSCRIBE_URL=$mnl_URL."/subscribe.php?doptin=1&c=&email=";
	$SUBSCRIBE="<a href=\"".$SUBSCRIBE_URL."\" target=\"_blank\">";

	//$SUBSCRIBE_URL="#";
	//$SUBSCRIBE="<a href=\"".$SUBSCRIBE_URL."\" target=\"_self\">";

	// ---> $body_p
	//new Template
	$_Tpl_NL=new mTemplate();
	$_Tpl_NL->setTemplatePath($mnl_nlpath);
	$_Tpl_NL->setParseValue("IMAGE1", $IMAGE1);
	$_Tpl_NL->setParseValue("LINK1", $LINK1);
	$_Tpl_NL->setParseValue("ATTACH1", $ATTACH1);
	$_Tpl_NL->setParseValue("NLONLINE", $NLONLINE);
	$_Tpl_NL->setParseValue("BLINDIMAGE", $BLINDIMAGE);
	$_Tpl_NL->setParseValue("UNSUBSCRIBE", $UNSUBSCRIBE);
	$_Tpl_NL->setParseValue("SUBSCRIBE", $SUBSCRIBE);

	$_Tpl_NL->setParseValue("IMAGE1_URL", $IMAGE1_URL);
	$_Tpl_NL->setParseValue("LINK1_URL", $LINK1_URL);
	$_Tpl_NL->setParseValue("ATTACH1_URL", $ATTACH1_URL);
	$_Tpl_NL->setParseValue("NLONLINE_URL", $NLONLINE_URL);
	$_Tpl_NL->setParseValue("BLINDIMAGE_URL", $BLINDIMAGE_URL);
	$_Tpl_NL->setParseValue("UNSUBSCRIBE_URL", $UNSUBSCRIBE_URL);
	$_Tpl_NL->setParseValue("SUBSCRIBE_URL", $SUBSCRIBE_URL);

	$_Tpl_NL->setParseValue("CLOSELINK", "</a>");
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

	$body_p=$_Tpl_NL->renderTemplate($NL_Filename_N);
	//geparste nl datei speichern!
	//$body_p=stripslashes($body_p);
	write_file($mnl_nlpath,$NL_Filename_P,$body_p);

	//		
?>