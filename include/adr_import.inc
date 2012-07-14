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

//aktiv fuer neue adr.
$InputName_AktivNew="aktiv_new";//
$aktiv_new=getVar("aktiv_new");
//aktiv fuer existierende adr.
$InputName_AktivEx="aktiv_existing";//
$aktiv_existing=getVar("aktiv_existing");

//trennzeichen
$InputName_Delimiter="delimiter";//
$$InputName_Delimiter=getVar($InputName_Delimiter);

//array mit gruppen
$adr_grp=Array();
$InputName_Group="adr_grp";//
pt_register("POST","adr_grp");

$InputName_File="file_new";//datei
pt_register("POST","file_new");

//trennzeichen
$InputName_Bulk="bulk";//
$$InputName_Bulk=getVar($InputName_Bulk,0);

$InputName_FileExisting="file_existing";//trackimage auswahl
$$InputName_FileExisting=getVar($InputName_FileExisting);

//delete
$InputName_Delete="delete";//
$$InputName_Delete=getVar($InputName_Delete);

//merge groups
$InputName_GroupsMerge="merge_groups";//
$$InputName_GroupsMerge=getVar($InputName_GroupsMerge);

//emailcheck
$InputName_ECheckImport="check_mail_import";//
$$InputName_ECheckImport=getVar($InputName_ECheckImport);

$uploaded_file_new=false;

if ($set=="import") {
	$created=date("Y-m-d H:i:s");
	$author=$LOGIN->USER['name'];
	$CSV_Filename="import_".date_convert_to_string($created).".csv";

	$check=false;
//upload prozedur
	if(is_uploaded_file($_FILES["file_new"]["tmp_name"])) {
		$uploaded_file_new=true;
		// Gültige Endung? ($ = Am Ende des Dateinamens) (/i = Groß- Kleinschreibung nicht berücksichtigen)
		if(preg_match("/\." . $allowed_csv_filetypes . "$/i", $_FILES["file_new"]["name"])) {
			// Datei auch nicht zu groß
			if($_FILES["file_new"]["size"] <= $max_upload_size) {
				// Alles OK -> Datei kopieren
				if(copy($_FILES["file_new"]["tmp_name"], $mnl_datapath."/".$CSV_Filename)) { //$_FILES["file"]["name"]
					$_MAIN_MESSAGE.= "<br>HTML-Datei erfolgreich hochgeladen!";
					$_MAIN_MESSAGE.= "<ul>".$_FILES["file_new"]["name"];
					$_MAIN_MESSAGE.= " / ".$_FILES["file_new"]["size"]." Byte";
					$_MAIN_MESSAGE.= ", ".$_FILES["file_new"]["type"];
					$_MAIN_MESSAGE.= "<br>".sprintf(___("Datei gespeichert unter: %s"),"<a href=\"".$mnl_datadir."/".$CSV_Filename."\" target=\"_preview\">".$mnl_datadir."/".$CSV_Filename."</a>");
					$_MAIN_MESSAGE.= "</ul>";
					$check=true;
				} else {
					$_MAIN_MESSAGE.= "<br>".___("CSV-Datei konnte nicht hochgeladen werden.");
					$check=false;
				}//copy
			} else {
				$_MAIN_MESSAGE.= "<br>".sprintf(___("Die CSV-Datei darf nur eine GrÖsse von %s Byte besitzen."),$max_byte_size);
				$check=false;
			}//max size
		} else {
			$_MAIN_MESSAGE.= "<br>".___("Die CSV-Datei besitzt eine ungültige Endung.");
			$check=false;
		}//extension
	} else {
		$_MAIN_MESSAGE.= "<br>".___("Keine CSV-Datei zum Hochladen angegeben.");
		$check=false;
	}//no file
	//ende upload 

	if (!$uploaded_file_new) {
		if (!empty($file_existing)) {
			$_MAIN_MESSAGE.="<br>".sprintf(___("Importiere bestehende CSV-Datei %s"),"<b>".$mnl_datadir."/".$CSV_Filename."</b>");
			$CSV_Filename=$file_existing;
			$check=true;
		}
	}

	if ($check && $delete!=1) {
		$_MAIN_MESSAGE.="<br>".___("Status für neue Adressen: ");	
	$_MAIN_MESSAGE.= "<img src=\"".$mnl_iconURL."/".$STATUS['adr']['statimg'][$status_new]."\" border=\"0\"   title=\"".$STATUS['adr']['descr'][$status_new]."\" alt=\"".$STATUS['adr']['descr'][$status_new]."\">";
	$_MAIN_MESSAGE.= "  ".$STATUS['adr']['status'][$status_new]."  (".$STATUS['adr']['descr'][$status_new].")";

		$_MAIN_MESSAGE.="<br>".___("Status für bestehende Adressen: ");	
	if ($status_ex>0) {
		$_MAIN_MESSAGE.= "<img src=\"".$mnl_iconURL."/".$STATUS['adr']['statimg'][$status_ex]."\" border=\"0\"   title=\"".$STATUS['adr']['descr'][$status_ex]."\" alt=\"".$STATUS['adr']['descr'][$status_ex]."\">";
		$_MAIN_MESSAGE.= "  ".$STATUS['adr']['status'][$status_ex]."  (".$STATUS['adr']['descr'][$status_ex].")";
	} else {
			$_MAIN_MESSAGE.= " ".___("Keine Änderung");
	}
		if ($aktiv_new==1) {
			$_MAIN_MESSAGE.= "<br><img src=\"".$mnl_iconURL."/tick.png\" border=\"0\">";
			$_MAIN_MESSAGE.= "&nbsp;".___("Neue Adressen sind aktiv.");
		} else {
			$_MAIN_MESSAGE.= "<br><img src=\"".$mnl_iconURL."/cancel.png\" border=\"0\">";
			$_MAIN_MESSAGE.= "&nbsp;".___("Neue Adressen sind inaktiv.");
		}
		if ($aktiv_existing==1) {
			$_MAIN_MESSAGE.= "<br><img src=\"".$mnl_iconURL."/tick.png\" border=\"0\">";
			$_MAIN_MESSAGE.= "&nbsp;".___("Bestehende Adressen werden aktiviert.");
		}
		if ($aktiv_existing==0) {
			$_MAIN_MESSAGE.= "<br><img src=\"".$mnl_iconURL."/cancel.png\" border=\"0\">";
			$_MAIN_MESSAGE.= "&nbsp;".___("Bestehende Adressen werden de-aktiviert.");
		}

	}//check && delete !=1
//datei einlesen
	$author=$LOGIN->USER['name'];
	$code=0;
	$lines=0;
	$lines_b=0;
	$lines_f=0;	
	//Bulk Import
	if (!empty($bulk)) {
		//jede zeile eine email...
	  	$_MAIN_MESSAGE.= "<br>".___("Importiere E-Mail-Adressen aus Textfeld")."<br>";
		$lines_bulk = explode("\n", $bulk);
		$lc=count($lines_bulk);
		for ($lcc=0; $lcc<$lc; $lcc++) {
			$row=$lines_bulk[$lcc];
			#$addr[$lines]['email']=$lines_bulk[$lcc];
////////////////
		      $fields=explode($delimiter, $row);
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

//////////
	    	$lines++;
			$lines_b++;
		}
	     $_MAIN_MESSAGE.="<br>".sprintf(___("%s Einträge gefunden!"),$lines_b);
	}//!empty bulk
	//CSV Datei einlesen:
	if ($check && file_exists($mnl_datapath."/".$CSV_Filename))
	{   
		  $uf=fopen($mnl_datapath."/".$CSV_Filename,"r");
		  if ($uf)
		  {
		  	$_MAIN_MESSAGE.= "<br>".sprintf(___("Importiere Datei %s"),"<b>".$CSV_Filename."</b>")."<br>";
		   while(!feof($uf))
	 		{
				$row=fgets($uf, 4096);
		      $fields=explode($delimiter, $row);
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
			$lines_f++;
	     }
		     $_MAIN_MESSAGE.="<br>".sprintf(___("%s Einträge gefunden!"),$lines_f);
	    } else {
			$_MAIN_MESSAGE.= "<br>".sprintf(___("%s existiert nicht!"),$mnl_datapath."/".$CSV_Filename);
		}
	}
	
//neue addressen anlegen	
	
	if ($lines>0) {
		$EMailcheck_Import=$check_mail_import;
		$ADDRESS=new mnlADR();
		$iok=0;
		$ifail=0;
		$idouble=0;
		$idelete=0;
		for ($i=0;$i<$lines;$i++) {
			srand((double)microtime()*1000000); 
			$code=rand(111111,999999); 
			 // $_MAIN_MESSAGE.= $i.":".$addr[$i]['name1']." ".$addr[$i]['name2']." ".$addr[$i]['email']."<br>";
			//eintragen des datensatzes
			if (isset($addr[$i]['email'])) {
				if (checkemailadr($addr[$i]['email'],$EMailcheck_Import)) {
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
						if ($merge_groups==1) {
						//wir diffen die gruppen und fuegen nur die referenzen hinzu die noch nicht existieren!
						//gruppen denen die adr bereits  angehoert
						$old_adr_grp = $ADDRESS->getGroupID(0,$ADR[0]['id'],0);
						//neue gruppen nur die die neu sind, denen die adr noch nicht angehoert!
						//adr_grp=gruppen aus dem formular
						$new_adr_grp = array_diff($adr_grp,$old_adr_grp);
						$all_adr_grp = array_merge($old_adr_grp, $new_adr_grp);
						} else {// merge groups
							$all_adr_grp=$new_adr_grp;
						}
						$adr_exists=true;
					}
					//////////////////////
					if ($adr_exists) {
					//wenn adresse existiert, 
						if ($delete!=1) {
							//adressdaten updaten!
						$code=$ADR[0]['code'];
							if ($aktiv_existing==-1) {
								$aktiv_update=$ADR[0]['aktiv'];
							} else {
								$aktiv_update=$aktiv_existing;
							}
						$ADDRESS->updateAdr(Array(
							"id"=>$ADR[0]['id'],
							"email"=>$addr[$i]['email'],
								"aktiv"=>$aktiv_update,
							"created"=>$created, 
							"author"=>$author, 
								"memo"=>$ADR[0]['memo'],
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
							//und neue referenzen zu neuen gruppen hinzufügen
							//$ADDRESS->addRef($ADR[0]['id'],$new_adr_grp);
							// ^^^ nur fuer den fall das daten nicht geupdated werden!!! sondern nur referenzen hinzugefuegt!
							//optional nachzuruesten und in den settings einstellbar :)
							// ok: merge
							$idouble++;
						} // delete != 1
						//importierte Adressen loeschen?
						if ($delete==1) {
							if (!DEMO) $ADDRESS->delAdr($ADR[0]['id']);
							$_MAIN_MESSAGE.="<br>".sprintf(___("Zeile %s: E-Mail %s wurde gelöscht."),($i+1),"<em>".$addr[$i]['email']."</em>");
							$idelete++;
						}
											
					} else { // exists

						if ($delete != 1) {
						//wenn adresse noch nicht existiert , neu anlegen
							$ADDRESS->addAdr(Array(
								"email"=>$addr[$i]['email'],
								"aktiv"=>$aktiv_new, 
								"created"=>$created, 
								"author"=>$author, 
								"status"=>$status_new, 
								"code"=>$code, 
								"memo"=>"", 
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
						} // ! delete
					}//adr exists
				} else {//emailcheck
					$_MAIN_MESSAGE.="<br>".sprintf(___("Zeile %s: E-Mail %s hat ein falsches Format."),($i+1),"<em>".$addr[$i]['email']."</em>");
					$ifail++;
				}//emailcheck
			}//isset email
		}//for
		if ($delete==1) {
			$_MAIN_MESSAGE.= "<br><br>".sprintf(___("Es wurden %s von %s Einträgen gelöscht."),$idelete,($i-1));
		} else {
			$_MAIN_MESSAGE.= "<br><br>".sprintf(___("Es wurden %s von %s Einträgen importiert und in die gewählten Gruppen eingetragen."),$iok,($i-1));
			$_MAIN_MESSAGE.= "<br>".sprintf(___("%s Einträge waren Fehlerhaft und wurden NICHT importiert."),$ifail);
			$_MAIN_MESSAGE.= "<br>".sprintf(___("%s Eintraege sind bereits vorhanden und wurden aktualisiert."),$idouble);
		}
		$action="adr_import";
		//include_once ("adr_list.inc");
	} else {//if lines>0
		//upload_form
	}
} else {
	//upload_form
}
require_once ($mnl_includepath."/adr_import_form.inc");
?>
