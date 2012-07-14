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

	//hochgeladene html datei
	$NL_Filename="nl_".date_convert_to_string($created).".html";
	//komplettes newsletter raw, body+file
	$NL_Filename_N="nl_".date_convert_to_string($created)."_n.html";
	//komplettes newsletter raw, body+file
	$NL_Filename_T="nl_".date_convert_to_string($created)."_t.txt";
	//geparster Newsletter Online
	$NL_Filename_P="nl_".date_convert_to_string($created)."_p.html";
	//Bild 1
	$NL_Imagename1="nl_".date_convert_to_string($created)."_1.jpg";
	
	#image watermark and resize	
	//temporary image	
	$NL_Imagename1_tmp="nl_".date_convert_to_string($created)."_1_tmp.jpg";
	//source image, original, delete if resize and/or watermark!
	$NL_Imagename1_source="nl_".date_convert_to_string($created)."_1_src.jpg";
	//resized image
	$NL_Imagename1_resized="nl_".date_convert_to_string($created)."_1_resized.jpg";
	//watermark image
	$NL_Imagename1_watermarked="nl_".date_convert_to_string($created)."_1_watermarked.jpg";


	$watermark_image=TM_IMGPATH."/".$$InputName_ImageWatermarkImage;

	//html datei
	// Wurde wirklich eine Datei hochgeladen?
	if(is_uploaded_file($_FILES["file"]["tmp_name"])) {
		// Gültige Endung? ($ = Am Ende des Dateinamens) (/i = Groß- Kleinschreibung nicht berücksichtigen)
		if(preg_match("/\." . $allowed_html_filetypes . "$/i", $_FILES["file"]["name"])) {
			// Datei auch nicht zu groß
			if($_FILES["file"]["size"] <= $max_upload_size) {
				// Alles OK -> Datei kopieren
				if($check) {
					//http://www.php.net/manual/en/features.file-upload.php, use basename to preserve filename for multiple uploaded files.... if needed ;)
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $tm_nlpath."/".$NL_Filename)) {
						$_MAIN_MESSAGE.= "<br>".___("HTML-Datei erfolgreich hochgeladen.");
						$_MAIN_MESSAGE.= "<ul>".$_FILES["file"]["name"];
						$_MAIN_MESSAGE.= " / ".$_FILES["file"]["size"]." Byte";
						$_MAIN_MESSAGE.= ", ".$_FILES["file"]["type"];
						$_MAIN_MESSAGE.= "<br>".___("HTML-Code wurde angefügt.").
												"<br>".___("Datei gespeichert unter:")." <a href=\"".$tm_URL_FE."/".$tm_nldir."/".$NL_Filename."\" target=\"_preview\">".$tm_nldir."/".$NL_Filename."</a>";
						$_MAIN_MESSAGE.= "</ul>";
						$uploaded_html=true;
					} else {
						$_MAIN_MESSAGE.= "<br>".___("Fehler beim kopieren.");
						$_MAIN_MESSAGE.= "<br>".___("HTML-Datei konnte nicht hochgeladen werden.");
						$check=false;
					}//copy
				} else {
					$_MAIN_MESSAGE.= "<br>".___("HTML-Datei konnte nicht hochgeladen werden.");
				}//check
			} else {
				$_MAIN_MESSAGE.= "<br>".sprintf(___("Die HTML-Datei darf nur eine Grösse von %s Byte haben."),$max_byte_size);
				$check=false;
			}//max size
		} else {
			$_MAIN_MESSAGE.= "<br>".___("Die HTML-Datei besitzt eine ungültige Endung.");
			$check=false;
		}//extension
	} else {
	}//no file
	//ende upload html

	//image
	if($check) {
		//imageupload
		// Wurde wirklich eine Datei hochgeladen?
		if(is_uploaded_file($_FILES["image1"]["tmp_name"])) {
			// Gültige Endung? ($ = Am Ende des Dateinamens) (/i = Groß- Kleinschreibung nicht berücksichtigen)
			if(preg_match("/\." . $allowed_image_filetypes . "$/i", $_FILES["image1"]["name"])) {
				// Datei auch nicht zu groß
				if($_FILES["image1"]["size"] <= $max_upload_size) {
					// Alles OK -> Datei kopieren
					//http://www.php.net/manual/en/features.file-upload.php, use basename to preserve filename for multiple uploaded files.... if needed ;)
					//save uploaded source image, do watermark and resize
					if (move_uploaded_file($_FILES["image1"]["tmp_name"], $tm_nlimgpath."/".$NL_Imagename1_source)) {
						//copy source image to tmp image
						copy ($tm_nlimgpath."/".$NL_Imagename1_source,$tm_nlimgpath."/".$NL_Imagename1_tmp);
						//create thumb ?!
						if ($$InputName_ImageResize==1 && $$InputName_ImageResizeSize > 0) {
							//save resized image
							$rs=createThumb($tm_nlimgpath."/".$NL_Imagename1_tmp,$tm_nlimgpath."/".$NL_Imagename1_resized,$$InputName_ImageResizeSize,95);
							if ($rs) {
								//move resized image to tmp image
								rename($tm_nlimgpath."/".$NL_Imagename1_resized,$tm_nlimgpath."/".$NL_Imagename1_tmp);
								unlink ($tm_nlimgpath."/".$NL_Imagename1_resized);
								$_MAIN_MESSAGE.= "<br>".sprintf(___("Bildgröße geändert in max. %s px."),$$InputName_ImageResizeSize);
							} else {
								$_MAIN_MESSAGE.= "<br>".sprintf(___("Fehler beim Ändern der Bildgröße in max. %s px."),$$InputName_ImageResizeSize);
							}
						}
						#add watermark to image?						
						if ($$InputName_ImageWatermark==1) {
							if (file_exists($watermark_image)) {
								$wm=watermark($tm_nlimgpath."/".$NL_Imagename1_tmp, $tm_nlimgpath."/".$NL_Imagename1_watermarked, $watermark_image, 95);
								if ($wm[0]) {
									//move resized image to tmp image
									rename($tm_nlimgpath."/".$NL_Imagename1_watermarked,$tm_nlimgpath."/".$NL_Imagename1_tmp);
									unlink ($tm_nlimgpath."/".$NL_Imagename1_watermarked);
									$_MAIN_MESSAGE.= "<br>".sprintf(___("Wasserzeichen zum Bild hinzugefügt (%s)."),$$InputName_ImageWatermarkImage);
								} else {
									$_MAIN_MESSAGE.= "<br>".sprintf(___("Fehler beim Hinzufügen des Wasserzeichens (%s)."),$$InputName_ImageWatermarkImage);
									$_MAIN_MESSAGE.= "<br>".$wm[1];//fehlermeldung aus createThumb
								}
							} else {
								$_MAIN_MESSAGE.= "<br>".sprintf(___("Wasserzeichen existiert nicht (%s)."),$$InputName_ImageResizeSize);							
							}
						}
						//copy tmp image to nl image
						copy ($tm_nlimgpath."/".$NL_Imagename1_tmp,$tm_nlimgpath."/".$NL_Imagename1);
						//unlink() source and temp image;
						unlink ($tm_nlimgpath."/".$NL_Imagename1_tmp);
						unlink ($tm_nlimgpath."/".$NL_Imagename1_source);
						$_MAIN_MESSAGE.= "<br>".___("BILD-Datei erfolgreich hochgeladen.");
						$_MAIN_MESSAGE.= "<ul>".$_FILES["image1"]["name"];
						$_MAIN_MESSAGE.= " / ".$_FILES["image1"]["size"]." Byte";
						$_MAIN_MESSAGE.= ", ".$_FILES["image1"]["type"];
						$_MAIN_MESSAGE.= "<br>".___("gespeichert unter:")." <a href=\"".$tm_URL_FE."/".$tm_nlimgdir."/".$NL_Imagename1."\"  target=\"_preview\">".$tm_nlimgdir."/".$NL_Imagename1."</a>";
						$_MAIN_MESSAGE.= "</ul>";
						$uploaded_image1=true;
					} else {
						$_MAIN_MESSAGE.= "<br>".___("Fehler beim kopieren.");
						$_MAIN_MESSAGE.= "<br>".___("BILD-Datei konnte nicht hochgeladen werden.");
						$check=false;
					}//copy
				} else {
					$_MAIN_MESSAGE.= "<br>".sprintf(___("Die BILD-Datei darf nur eine Grösse von %s Byte besitzen."),$max_byte_size);
					$check=false;
				}//max size
			} else {
				$_MAIN_MESSAGE.= "<br>".___("Die BILD-Datei besitzt eine ungültige Endung.");
				$check=false;
			}//extension
		}//no file
	}//check
	//ende upload image

	//attachement
	//attaxchement upload
	// Wurde wirklich eine Datei hochgeladen?
	if(is_uploaded_file($_FILES["attach1"]["tmp_name"])) {
			// Datei auch nicht zu groß
			if($_FILES["attach1"]["size"] <= $max_upload_size) {
				// Alles OK -> Datei kopieren
				$attachinfo=pathinfo($_FILES["attach1"]["name"]);
				if($check) {
					$uploaded_attachement_new_name=$_FILES["attach1"]["name"];
					//http://www.php.net/manual/en/features.file-upload.php, use basename to preserve filename for multiple uploaded files.... if needed ;)
					if (move_uploaded_file($_FILES["attach1"]["tmp_name"], $tm_nlattachpath."/".$uploaded_attachement_new_name)) {
						$_MAIN_MESSAGE.= "<br>".___("Anhang erfolgreich hochgeladen.");
						$_MAIN_MESSAGE.= "<ul>".$_FILES["attach1"]["name"];
						$_MAIN_MESSAGE.= " / ".$_FILES["attach1"]["size"]." Byte";
						$_MAIN_MESSAGE.= ", ".$_FILES["attach1"]["type"];
						$_MAIN_MESSAGE.= "<br>".___("gespeichert unter:")." <a href=\"".$tm_URL_FE."/".$tm_nlattachdir."/".$uploaded_attachement_new_name."\"  target=\"_preview\">".$tm_nlattachdir."/".$uploaded_attachement_new_name."</a>";
						$_MAIN_MESSAGE.= "</ul>";
						$uploaded_attach1=true;
						$atc=count($attach_existing);
						$attach_existing[$atc]=$uploaded_attachement_new_name;
					} else {
						$_MAIN_MESSAGE.= "<br>".___("Fehler beim kopieren.");
						$_MAIN_MESSAGE.= "<br>".___("Anhang konnte nicht hochgeladen werden.");
						$check=false;
					}//copy
				} else {
					$_MAIN_MESSAGE.= "<br>".___("Anhang konnte nicht hochgeladen werden.");
				}//check
			} else {
				$_MAIN_MESSAGE.= "<br>".sprintf(___("Der Anhang Datei darf nur eine Grösse von %s Byte haben."),$max_byte_size);
				$check=false;
			}//max size
	} else {
	}//no file


//ende upload attachement

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
				$_MAIN_MESSAGE.= "<br>".sprintf(___("Die Tracker-BILD-Datei darf nur eine Grösse von %s Byte besitzen."),$max_byte_size);
				$check=false;
			}//max size
		} else {
			$_MAIN_MESSAGE.= "<br>".___("Die Tracker-BILD-Datei besitzt eine ungültige Endung.");
			$check=false;
		}//extension
	} else {
		//$_MAIN_MESSAGE.= "Keine HTML-Datei zum Hochladen angegeben.";
	}//no file


//ende upload image



	// kompletter content= $body + html content = $body_tmp
	if (file_exists($tm_nlpath."/".$NL_Filename)) {
		$file_content.=file_get_contents($tm_nlpath."/".$NL_Filename);
	}
	$body_tmp=$body.$file_content;
	// wenn html datei hochgeladen, datei auslesen und an eingegebenen Content anhaengen! $body_tmp !
	// 	vorher/nachher option?
	//wir speichern nur ungeparsten content in der DB!!!! ---> $body
	//und in einer Datei! als Template fuer den geparsten Newsletter
	$body_tmp=stripslashes($body_tmp);
	write_file($tm_nlpath,$NL_Filename_N,$body_tmp);
	//template fuer textpart speichern
	#$body_text_tmp=$body_text;
	$body_text_tmp=stripslashes($body_text);
	write_file($tm_nlpath,$NL_Filename_T,$body_text_tmp);
	//wird nun zur onlineversion geparsed!
	//geparster content, wird als nl file gespeichert nl+created bei new und update!
	// ----> $body_tmp; --> Template ist $NL_Filename_N
	//content parsen nach  {IMAGE1} etc.
	//dieses dann ersetzen durch das bild!
	//template values
	$IMAGE1="";
	$LINK1="";
	$ATTACHEMENTS="";
	$IMAGE1_URL="";
	$LINK1_URL="";
	//Bild
	if (file_exists($tm_nlimgpath."/".$NL_Imagename1)) {
		$IMAGE1_URL=$tm_URL_FE."/".$tm_nlimgdir."/".$NL_Imagename1;
		$IMAGE1="<img src=\"".$IMAGE1_URL."\" border=0>";
	}
	//Link
	if (!empty($link)) {
		$LINK1_URL=$link;
		$LINK1="<a href=\"".$LINK1_URL."\" target=\"_link\">";
	}
	//link zu attachement:
			foreach ($attach_existing as $filename) {
				$ATTACHEMENTS.= "<a href=\"".$tm_URL_FE."/".$tm_nlattachdir."/".$filename."\" target=\"_blank\" title=\"".$filename."\">";
				$ATTACHEMENTS.=$filename;
				$ATTACHEMENTS.= "</a><br>\n";
			}
	//blindimage
	$BLINDIMAGE_URL=$tm_URL_FE."/news_blank.png.php?nl_id=".$nl_id;//?nl_id=".$Q[$qcc]['nl_id'];
	$BLINDIMAGE="<img src=\"".$BLINDIMAGE_URL."\" border=0>";
	//link zu unsubscribe
	$UNSUBSCRIBE_URL=$tm_URL_FE."/unsubscribe.php?nl_id=".$nl_id;//?nl_id=".$Q[$qcc]['nl_id'];
	$UNSUBSCRIBE="<a href=\"".$UNSUBSCRIBE_URL."\" target=\"_blank\">";
	//link zur onlineversion, geparsed
	$NLONLINE_URL=$tm_URL_FE."/".$tm_nldir."/".$NL_Filename_P;
	$NLONLINE="<a href=\"".$NLONLINE_URL."\" target=\"_blank\">";

	$SUBSCRIBE_URL=$tm_URL_FE."/subscribe.php?nl_id=".$nl_id."&doptin=1&c=&email=";
	$SUBSCRIBE="<a href=\"".$SUBSCRIBE_URL."\" target=\"_blank\">";

	//$SUBSCRIBE_URL="#";
	//$SUBSCRIBE="<a href=\"".$SUBSCRIBE_URL."\" target=\"_self\">";

	// ---> $body_p
	//new Template
	$_Tpl_NL=new tm_Template();
	$_Tpl_NL->setTemplatePath($tm_nlpath);
	$_Tpl_NL->setParseValue("IMAGE1", $IMAGE1);
	$_Tpl_NL->setParseValue("LINK1", $LINK1);
	$_Tpl_NL->setParseValue("ATTACHEMENTS", $ATTACHEMENTS);
	$_Tpl_NL->setParseValue("ATTACH1", "");
	$_Tpl_NL->setParseValue("NLONLINE", $NLONLINE);
	$_Tpl_NL->setParseValue("BLINDIMAGE", $BLINDIMAGE);
	$_Tpl_NL->setParseValue("UNSUBSCRIBE", $UNSUBSCRIBE);
	$_Tpl_NL->setParseValue("SUBSCRIBE", $SUBSCRIBE);

	$_Tpl_NL->setParseValue("IMAGE1_URL", $IMAGE1_URL);
	$_Tpl_NL->setParseValue("LINK1_URL", $LINK1_URL);
	$_Tpl_NL->setParseValue("ATTACH1_URL", "");
	$_Tpl_NL->setParseValue("NLONLINE_URL", $NLONLINE_URL);
	$_Tpl_NL->setParseValue("BLINDIMAGE_URL", $BLINDIMAGE_URL);
	$_Tpl_NL->setParseValue("UNSUBSCRIBE_URL", $UNSUBSCRIBE_URL);
	$_Tpl_NL->setParseValue("SUBSCRIBE_URL", $SUBSCRIBE_URL);

	$_Tpl_NL->setParseValue("CLOSELINK", "</a>");
	$_Tpl_NL->setParseValue("DATE", date(TM_NL_DATEFORMAT));
	$_Tpl_NL->setParseValue("EMAIL","");
	$_Tpl_NL->setParseValue("CODE","");
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
	//title /subtitle, unpersonalisiert!
	$_Tpl_NL->setParseValue("TITLE",$title);
	$_Tpl_NL->setParseValue("TITLE_SUB",$title_sub);
	$_Tpl_NL->setParseValue("SUMMARY",$summary);

	$body_p=$_Tpl_NL->renderTemplate($NL_Filename_N);
	//geparste nl datei speichern!
	write_file($tm_nlpath,$NL_Filename_P,$body_p);

	//
?>