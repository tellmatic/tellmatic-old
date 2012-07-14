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

$_MAIN_DESCR=___("Adressen importieren (CSV-Import)");
$set=getVar("set");

//status f. neue adr
$InputName_Status="status_new";//
$status_new=getVar("status_new");
//status fuer existierende adr.
$InputName_StatusEx="status_exists";//
$status_ex=getVar("status_exists");

//array mit gruppen
$adr_grp=Array();
$InputName_Group="adr_grp";//
pt_register("POST","adr_grp");

$InputName_File="file";//datei
pt_register("POST","file");

if ($set=="import") {
	$created=date("Y-m-d H:i:s");
	$author=$LOGIN->USER['name'];
	$CSV_Filename="import_".date_convert_to_string($created).".csv";

	$check=false;
//upload prozedur
	if(is_uploaded_file($_FILES["file"]["tmp_name"])) {
		// Gültige Endung? ($ = Am Ende des Dateinamens) (/i = Groß- Kleinschreibung nicht berücksichtigen)
		if(preg_match("/\." . $allowed_csv_filetypes . "$/i", $_FILES["file"]["name"])) {
			// Datei auch nicht zu groß
			if($_FILES["file"]["size"] <= $max_upload_size) {
				// Alles OK -> Datei kopieren
				if(copy($_FILES["file"]["tmp_name"], $mnl_datapath."/".$CSV_Filename)) { //$_FILES["file"]["name"]
					$_MAIN_MESSAGE.= "<br>HTML-Datei erfolgreich hochgeladen!";
					$_MAIN_MESSAGE.= "<ul>".$_FILES["file"]["name"];
					$_MAIN_MESSAGE.= " / ".$_FILES["file"]["size"]." Byte";
					$_MAIN_MESSAGE.= ", ".$_FILES["file"]["type"];
					$_MAIN_MESSAGE.= "<br>".sprintf(___("Datei gespeichert unter: %s"),"<a href=\"".$mnl_datadir."/".$CSV_Filename."\" target=\"_preview\">".$mnl_datadir."/".$CSV_Filename."</a>");
					$_MAIN_MESSAGE.= "</ul>";
					$check=true;
				} else {
					$_MAIN_MESSAGE.= "<br>".___("CSV-Datei konnte nicht hochgeladen werden.");
					$check=false;
				}//copy
			} else {
				$_MAIN_MESSAGE.= "<br>".sprintf(___("Die CSV-Datei darf nur eine Gr&ouml;sse von %s Byte besitzen."),$max_byte_size);
				$check=false;
			}//max size
		} else {
			$_MAIN_MESSAGE.= "<br>".___("Die CSV-Datei besitzt eine ung&uuml;ltige Endung.");
			$check=false;
		}//extension
	} else {
		$_MAIN_MESSAGE.= "<br>".___("Keine CSV-Datei zum Hochladen angegeben.");
		$check=false;
	}//no file
	//ende upload 

	$_MAIN_MESSAGE.="<br>".___("Status f&uuml;r neue Adressen: ");	
	$_MAIN_MESSAGE.= "<img src=\"".$mnl_iconURL."/".$STATUS['adr']['statimg'][$status_new]."\" border=\"0\"   title=\"".$STATUS['adr']['descr'][$status_new]."\" alt=\"".$STATUS['adr']['descr'][$status_new]."\">";
	$_MAIN_MESSAGE.= "  ".$STATUS['adr']['status'][$status_new]."  (".$STATUS['adr']['descr'][$status_new].")";

	$_MAIN_MESSAGE.="<br>".___("Status f&uuml;r bestehende Adressen: ");	
	if ($status_ex>0) {
		$_MAIN_MESSAGE.= "<img src=\"".$mnl_iconURL."/".$STATUS['adr']['statimg'][$status_ex]."\" border=\"0\"   title=\"".$STATUS['adr']['descr'][$status_ex]."\" alt=\"".$STATUS['adr']['descr'][$status_ex]."\">";
		$_MAIN_MESSAGE.= "  ".$STATUS['adr']['status'][$status_ex]."  (".$STATUS['adr']['descr'][$status_ex].")";
	} else {
		$_MAIN_MESSAGE.= " ".___("Keine &Auml;nderung");
	}

//datei einlesen
	$author=$LOGIN->USER['name'];
	$code=0;
	$lines=0;

	if ($check && file_exists($mnl_datapath."/".$CSV_Filename))
	{   
		  $uf=fopen($mnl_datapath."/".$CSV_Filename,"r");
		  if ($uf)
		  {
		  	$_MAIN_MESSAGE.= "<br>".sprintf(___("Importiere Datei %s"),"<b>".$CSV_Filename."</b>")."<br>";
		   while(!feof($uf))
	 		{
				$row=fgets($uf, 4096);
		      $fields=explode(",", $row);
		      if (isset($fields[0]) && !empty($fields[0])) {
			      $addr[$lines]['email']=str_replace("\"","",trim($fields[0]));

			      if (isset($fields[1]) && !empty($fields[1])) {
				      $addr[$lines]['f0']=str_replace("\"","",trim($fields[1]));
			      } else {
				      $addr[$lines]['f0']="";
			      }
			      if (isset($fields[2]) && !empty($fields[2])) {
				      $addr[$lines]['f1']=str_replace("\"","",trim($fields[2]));
			      } else {
				      $addr[$lines]['f1']="";
			      }
			      if (isset($fields[3]) && !empty($fields[3])) {
		  		      $addr[$lines]['f2']=str_replace("\"","",trim($fields[3]));
			      } else {
				      $addr[$lines]['f2']="";
			      }
			      if (isset($fields[4]) && !empty($fields[4])) {
		  		      $addr[$lines]['f3']=str_replace("\"","",trim($fields[4]));
			      } else {
				      $addr[$lines]['f3']="";
			      }
			      if (isset($fields[5]) && !empty($fields[5])) {
		  		      $addr[$lines]['f4']=str_replace("\"","",trim($fields[5]));
			      } else {
				      $addr[$lines]['f4']="";
			      }
			      if (isset($fields[6]) && !empty($fields[6])) {
		  		      $addr[$lines]['f5']=str_replace("\"","",trim($fields[6]));
			      } else {
				      $addr[$lines]['f5']="";
			      }
			      if (isset($fields[7]) && !empty($fields[7])) {
		  		      $addr[$lines]['f6']=str_replace("\"","",trim($fields[7]));
			      } else {
				      $addr[$lines]['f6']="";
			      }
			      if (isset($fields[8]) && !empty($fields[8])) {
		  		      $addr[$lines]['f7']=str_replace("\"","",trim($fields[8]));
			      } else {
				      $addr[$lines]['f7']="";
			      }
			      if (isset($fields[9]) && !empty($fields[9])) {
		  		      $addr[$lines]['f8']=str_replace("\"","",trim($fields[9]));
			      } else {
				      $addr[$lines]['f8']="";
			      }
			      if (isset($fields[10]) && !empty($fields[10])) {
		  		      $addr[$lines]['f9']=str_replace("\"","",trim($fields[10]));
			      } else {
				      $addr[$lines]['f9']="";
			      }
		      }
		      $lines++;
	     }
		     $_MAIN_MESSAGE.="<br>".sprintf(___("%s Eintr&auml;ge gefunden!"),$lines);
	    } else {
			$_MAIN_MESSAGE.= "<br>".sprintf(___("%s existiert nicht!"),$mnl_datapath."/".$CSV_Filename);
		}
	}
	
//neue addressen anlegen	
	
	if ($lines>0) {
		$ADDRESS=new mnlADR();
		$iok=0;
		$ifail=0;
		$idouble=0;
		for ($i=0;$i<$lines;$i++) {
			srand((double)microtime()*1000000); 
			$code=rand(111111,999999); 
			 // $_MAIN_MESSAGE.= $i.":".$addr[$i]['name1']." ".$addr[$i]['name2']." ".$addr[$i]['email']."<br>";
			//eintragen des datensatzes
			if (isset($addr[$i]['email'])) {
				if (checkemailadr($addr[$i]['email'],$EMailcheck_Intern)) {
					//dublettencheck
					$search['email']=$addr[$i]['email'];
					//auf existenz pruefen und wenn email noch nicht existiert dann eintragen.
					$ADR=$ADDRESS->getAdr(0,0,0,0,$search);
					$ac=count($ADR);

					$new_adr_grp=$adr_grp;
					$adr_exists=false;
					if ($ac>0) {
						///////////////////////////
						//oh! adresse ist bereits vorhanden!
						//wir diffen die gruppen und fuegen nur die referenzen hinzu die noch nicht existieren!
		//				$check=false;
						//gruppen denen die adr bereits  angehoert
						$old_adr_grp = $ADDRESS->getGroupID(0,$ADR[0]['id'],0);
						//neue gruppen nur die die neu sind, denen die adr noch nicht angehoert!
						//adr_grp=gruppen aus dem formular
						$new_adr_grp = array_diff($adr_grp,$old_adr_grp);
						$all_adr_grp = array_merge($old_adr_grp, $new_adr_grp);
	
						/*
						echo "<hr>".$addr[$i]['email']."<hr>";
						print_r($adr_grp);echo "<hr>";
						print_r($old_adr_grp);echo "<hr>";
						print_r($new_adr_grp);echo "<hr>";
						print_r($all_adr_grp);echo "<hr>";
						*/
						$adr_exists=true;
					}
					//////////////////////
					if ($adr_exists) {
					//wenn adresse existiert, adressdaten updaten!
					//
						$code=$ADR[0]['code'];
						$ADDRESS->updateAdr(Array(
							"id"=>$ADR[0]['id'],
							"email"=>$addr[$i]['email'],
							"aktiv"=>$ADR[0]['aktiv'],
							"created"=>$created, 
							"author"=>$author, 
							"f0"=>$addr[$i]['f0'],
							"f1"=>$addr[$i]['f1'],
							"f2"=>$addr[$i]['f2'],
							"f3"=>$addr[$i]['f3'],
							"f4"=>$addr[$i]['f4'],
							"f5"=>$addr[$i]['f5'],
							"f6"=>$addr[$i]['f6'],
							"f7"=>$addr[$i]['f7'],
							"f8"=>$addr[$i]['f8'],
							"f9"=>$addr[$i]['f9'] 
							),
							$all_adr_grp);

							$_MAIN_MESSAGE.="<br>".sprintf(___("Zeile %s: E-Mail %s existiert Bereits und wurde aktualisiert und ggf in Neue Gruppen eingetragen."),($i+1),"<em>".$addr[$i]['email']."</em>");

							//wenn status_ex >0 dann aendern!
							if ($status_ex>0) {
								$ADDRESS->setStatus($ADR[0]['id'],$status_ex);
							}

							$idouble++;

						//
						//und neue referenzen zu neuen gruppen hinzufuegen
						//$ADDRESS->addRef($ADR[0]['id'],$new_adr_grp);
						// ^^^ nur fuer den fall das daten nicht geupdated werden!!! sondern nur referenzen hinzugefuegt!
						//optional nachzuruesten und in den settings einstellbar :)
											
						} else {
						//wenn adresse noch nicht existiert , neu anlegen
							$ADDRESS->addAdr(Array(
								"email"=>$addr[$i]['email'],
								"aktiv"=>1, 
								"created"=>$created, 
								"author"=>$author, 
								"status"=>$status_new, 
								"code"=>$code, 
								"f0"=>$addr[$i]['f0'],
								"f1"=>$addr[$i]['f1'],
								"f2"=>$addr[$i]['f2'],
								"f3"=>$addr[$i]['f3'],
								"f4"=>$addr[$i]['f4'],
								"f5"=>$addr[$i]['f5'],
								"f6"=>$addr[$i]['f6'],
								"f7"=>$addr[$i]['f7'],
								"f8"=>$addr[$i]['f8'],
								"f9"=>$addr[$i]['f9']
								),
								$new_adr_grp);
						$iok++;
					}//adr exists
				} else {//emailcheck
					$_MAIN_MESSAGE.="<br>".sprintf(___("Zeile %s: E-Mail %s hat ein falsches Format."),($i+1),"<em>".$addr[$i]['email']."</em>");
					$ifail++;
				}//emailcheck
			}//isset email
		}//for
		$_MAIN_MESSAGE.= "<br><br>".sprintf(___("Es wurden %s von %s Eintr&auml;gen importiert und in die gew&auml;hlten Gruppen eingetragen."),$iok,($i-1));
		$_MAIN_MESSAGE.= "<br>".sprintf(___("%s Eintr&auml;ge waren Fehlerhaft und wurden NICHT importiert."),$ifail);
		$_MAIN_MESSAGE.= "<br>".sprintf(___("%s Eintraege sind bereits vorhanden und wurden aktualisiert."),$idouble);
		$action="adr_import";
		//include_once ("adr_list.inc");
		include_once ($mnl_includepath."/adr_import_form.inc");
	} else {//if lines>0
		//upload_form
		include_once ($mnl_includepath."/adr_import_form.inc");
	}
} else {
	//upload_form
	include_once ($mnl_includepath."/adr_import_form.inc");
}
?>
