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
$$InputName_AktivNew=getVar($InputName_AktivNew);
//aktiv fuer existierende adr.
$InputName_AktivEx="aktiv_existing";//
$$InputName_AktivEx=getVar($InputName_AktivEx);

//Dublettencheck on off
$InputName_DoubleCheck="check_double";//
$$InputName_DoubleCheck=getVar($InputName_DoubleCheck);

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
$$InputName_Delete=getVar($InputName_Delete,0);

//blacklist
$InputName_Blacklist="blacklist";//
$$InputName_Blacklist=getVar($InputName_Blacklist,0);

//merge groups
$InputName_GroupsMerge="merge_groups";//
$$InputName_GroupsMerge=getVar($InputName_GroupsMerge);

//emailcheck
$InputName_ECheckImport="check_mail_import";//
$$InputName_ECheckImport=getVar($InputName_ECheckImport);

//usr limit
$InputName_Limit="import_limit_user";//
$$InputName_Limit=getVar($InputName_Limit);
if (empty($$InputName_Limit)) $$InputName_Limit=1000;

//usr offset
$InputName_Offset="import_offset_user";//
$$InputName_Offset=getVar($InputName_Offset);
if (empty($$InputName_Offset)) $$InputName_Offset=0;

$uploaded_file_new=false;

$IMPORT_MESSAGE="";
$IMPORT_LOG="";

if ($set=="import") {
	$BLACKLIST=new tm_BLACKLIST();
	$created=date("Y-m-d H:i:s");
	$author=$LOGIN->USER['name'];
	$CSV_Filename="import_".date_convert_to_string($created).".csv";
	$check=false;

	$EMailcheck_Import=$check_mail_import;

	if (empty($adr_grp)) {
		$IMPORT_MESSAGE.= "<br>".___("Keine Gruppe gewählt. Es werden keine neuen Daten importiert.");
	} else {
		$check=true;
	}

	if (!is_numeric($import_offset_user)) {
		$IMPORT_MESSAGE.= "<br>".sprintf(___("Offset '%s' ist kein gültiger Wert."),$import_offset_user);
	} else {
		$check=true;
	}

	if (!is_numeric($import_limit_user)) {
		$IMPORT_MESSAGE.= "<br>".sprintf(___("Limit '%s' ist kein gültiger Wert."),$import_limit_user);
	} else {
		$check=true;
	}

	//upload prozedur
	if($check && is_uploaded_file($_FILES["file_new"]["tmp_name"])) {
		$uploaded_file_new=true;
		// Gültige Endung? ($ = Am Ende des Dateinamens) (/i = Groß- Kleinschreibung nicht berücksichtigen)
		if(preg_match("/\." . $allowed_csv_filetypes . "$/i", $_FILES["file_new"]["name"])) {
			// Datei auch nicht zu groß
			if($_FILES["file_new"]["size"] <= $max_upload_size) {
				// Alles OK -> Datei kopieren
				if (move_uploaded_file($_FILES["file_new"]["tmp_name"], $tm_datapath."/".$CSV_Filename)) {
					$IMPORT_MESSAGE.= "<br>".___("CSV-Datei erfolgreich hochgeladen.");
					$IMPORT_MESSAGE.= "<ul>".$_FILES["file_new"]["name"];
					$IMPORT_MESSAGE.= " / ".$_FILES["file_new"]["size"]." Byte";
					$IMPORT_MESSAGE.= ", ".$_FILES["file_new"]["type"];
					$IMPORT_MESSAGE.= "<br>".sprintf(___("Datei gespeichert unter: %s"),"<a href=\"".$tm_URL_FE."/".$tm_datadir."/".$CSV_Filename."\" target=\"_preview\">".$tm_datadir."/".$CSV_Filename."</a>");
					$IMPORT_MESSAGE.= "</ul>";
					$check=true;
				} else {
					$IMPORT_MESSAGE.= "<br>".___("CSV-Datei konnte nicht hochgeladen werden.");
					$check=false;
				}//copy
			} else {
				$IMPORT_MESSAGE.= "<br>".sprintf(___("Die CSV-Datei darf nur eine Grösse von max. %s Byte besitzen."),$max_byte_size);
				$check=false;
			}//max size
		} else {
			$IMPORT_MESSAGE.= "<br>".___("Die CSV-Datei besitzt eine ungültige Endung.");
			$check=false;
		}//extension
	} else {
		$IMPORT_MESSAGE.= "<br>".___("Keine CSV-Datei zum Hochladen angegeben.");
		$check=false;
	}//no file
	//ende upload

	if (!$uploaded_file_new) {
		if (!empty($file_existing)) {
			$IMPORT_MESSAGE.="<br>".sprintf(___("Importiere bestehende CSV-Datei %s"),"<b>".$tm_datadir."/".$CSV_Filename."</b>");
			$CSV_Filename=$file_existing;
			$check=true;
		}
	}



	if ($check && $delete!=1 && $blacklist!=1) {
		$IMPORT_MESSAGE.="<br>".___("Status für neue Adressen: ");
		$IMPORT_MESSAGE.=tm_icon($STATUS['adr']['statimg'][$status_new],$STATUS['adr']['descr'][$status_new]);
		$IMPORT_MESSAGE.= "  ".$STATUS['adr']['status'][$status_new]."  (".$STATUS['adr']['descr'][$status_new].")";

		$IMPORT_MESSAGE.="<br>".___("Status für bestehende Adressen: ");
		if ($status_ex>0) {
		$IMPORT_MESSAGE.=tm_icon($STATUS['adr']['statimg'][$status_ex],$STATUS['adr']['descr'][$status_ex]);
			$IMPORT_MESSAGE.= "  ".$STATUS['adr']['status'][$status_ex]."  (".$STATUS['adr']['descr'][$status_ex].")";
		} else {
			$IMPORT_MESSAGE.= " ".___("Keine Änderung");
		}

		if ($check_double==1) {
			$IMPORT_MESSAGE.="<br>".tm_icon("key_go.png",___("Adressen werden auf Eindeutigkeit geprüft."));
			$IMPORT_MESSAGE.= "&nbsp;".___("Adressen werden auf Eindeutigkeit geprüft.");
		} else {
			$IMPORT_MESSAGE.="<br>".tm_icon("key_delete.png",___("Adressen werden nicht auf Eindeutigkeit geprüft."));
			$IMPORT_MESSAGE.= "&nbsp;".___("Adressen werden nicht auf Eindeutigkeit geprüft.");
		}


		if ($aktiv_new==1) {
			$IMPORT_MESSAGE.="<br>".tm_icon("tick.png",___("Aktiv"));
			$IMPORT_MESSAGE.= "&nbsp;".___("Neue Adressen sind aktiv.");
		} else {
			$IMPORT_MESSAGE.="<br>".tm_icon("cancel.png",___("Inaktiv"));
			$IMPORT_MESSAGE.= "&nbsp;".___("Neue Adressen sind inaktiv.");
		}

		if ($aktiv_existing==1) {
			$IMPORT_MESSAGE.="<br>".tm_icon("tick.png",___("Aktiv"));
			$IMPORT_MESSAGE.= "&nbsp;".___("Bestehende Adressen werden aktiviert.");
		}
		if ($aktiv_existing==0) {
			$IMPORT_MESSAGE.="<br>".tm_icon("cancel.png",___("Inaktiv"));
			$IMPORT_MESSAGE.= "&nbsp;".___("Bestehende Adressen werden de-aktiviert.");
		}

	}//check && delete !=1 && blacklist!=1

/******************************************************************************/

/******************************************************************************/

	$author=$LOGIN->USER['name'];
	$code=0;
	$lines=0;//zaehler zeilen gesamt
	$lines_b=0;//zaehler zeilen bulk
	$lines_f=0;//zaehler zeilen aus datei

	$ifail=0;
/******************************************************************************/
//Bulk Import
/******************************************************************************/
	if (!empty($bulk)) {
		//jede zeile eine email...
	  	$IMPORT_MESSAGE.= "<br>".___("Importiere E-Mail-Adressen aus Textfeld")."<br>";
		$lines_bulk = explode("\n", $bulk);
		$lc=count($lines_bulk);
		for ($lcc=0; $lcc<$lc; $lcc++) {
			$row=$lines_bulk[$lcc];
			$fields=splitWithEscape($row, $delimiter,'"');//escape char is "
			if (isset($fields[0]) && !empty($fields[0])) {
		    	$field_0=str_replace("\"","",trim($fields[0]));
		    	$check_mail=checkEmailAdr($field_0,$EMailcheck_Import);
				if ($check_mail[0]) {
					$addr[$lines]['email']=$field_0;
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
				} else {//checkemail
					$IMPORT_LOG.="<br>".sprintf(___("Bulk Zeile %s: E-Mail %s hat ein falsches Format."),($lines+1),"<em>".$fields[0]."</em>")." ".$check_mail[1];
					$ifail++;
				}//check email
			}//isset fields[0]
	    	$lines++;
			$lines_b++;
		}
		unset($fields);
	     $IMPORT_MESSAGE.="<br>".sprintf(___("%s Einträge gefunden!"),$lines_b);
	}//!empty bulk

/******************************************************************************/
//CSV Datei einlesen:
/******************************************************************************/
	if ($check && file_exists($tm_datapath."/".$CSV_Filename)) {
		$uf=fopen($tm_datapath."/".$CSV_Filename,"r");
		if ($uf) {
		  	$IMPORT_MESSAGE.= "<br>".sprintf(___("Importiere Datei %s"),"<b>".$CSV_Filename."</b>")."<br>";
		  	$IMPORT_MESSAGE.= "<br>".___("Offset")." ".$import_offset_user;
		  	$IMPORT_MESSAGE.= " / ".___("Limit")." ".$import_limit_user;
		  	$lines_tmp=0;
			//offset
			if (DEBUG) $IMPORT_MESSAGE.="<br>import_offset_user=$import_offset_user";
			if ($import_offset_user) {
				if (DEBUG) $IMPORT_MESSAGE.="<br>Jump to row ".($import_offset_user+1).": ";
				//zeilen auslesen und vergessen
			  	while(!feof($uf) && $lines_tmp < $import_offset_user) {
				  	$tmp=fgets($uf);//, 4096
					$lines_tmp++;
			  	}//while
			  	unset($tmp);
			}//import offset user
			//zeilen auslesen bis limit erreicht
			while(!feof($uf) && $lines_f < $import_limit_user) {
				$row=fgets($uf, 4096);
				$fields=splitWithEscape($row, $delimiter,'"');//escape char is "
				//erstes feld, emil, muss gefuellt sein!
				//adr in array speichern
		    	if (isset($fields[0]) && !empty($fields[0])) {
			    	$field_0=str_replace("\"","",trim($fields[0]));
			    	$check_mail=checkEmailAdr($field_0,$EMailcheck_Import);
					if ($check_mail[0]) {
					      $addr[$lines]['email']=$field_0;
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
					} else {//check email
						$IMPORT_LOG.="<br>".sprintf(___("Datei Zeile %s: E-Mail %s hat ein falsches Format."),($lines+1),"<em>".$fields[0]."</em>")." ".$check_mail[1];
						$ifail++;
					}//check email
				}//isset fields[0]
				$lines++;
				$lines_f++;
			}//while
			unset($fields);
			$IMPORT_MESSAGE.="<br>".sprintf(___("%s Einträge gefunden!"),$lines_f);
	    } else {//if uf, fopen
			$IMPORT_MESSAGE.= "<br>".sprintf(___("Die Import-Datei %s konnte nicht geöffnet werden."),$tm_datapath."/".$CSV_Filename);
		}
	}//check && file exists

//neue addressen anlegen
	//wenn min. 1 adresse gefudnen wurde//lines=anzahl adressen
	if ($lines>0) { //!empty($adr_grp) && // check nicht pruefen, sonst werden keine bulkadressen aus dem textfeld importiert
		$ADDRESS=new tm_ADR();
		$iok=0;
		#$ifail=0;//oben!!! vor dem einlesen, da email check schon beim einlesen
		$idouble=0;
		$idelete=0;
		$iblacklist=0;
		for ($i=0;$i<$lines;$i++) {
			srand((double)microtime()*1000000);
			$code=rand(111111,999999);
			//eintragen des datensatzes
			if (isset($addr[$i]['email'])) {
				//email auf gültigkeit prüfen
					$new_adr_grp=$adr_grp; //default
					$adr_exists=false;
					//adressen auf dubletten pruefen?
					//auch pruefen wenn delete, da adressen anhand id oder email gefunden werden sollen
					//achtung, gruppen zusammenfuehren geht natuerlich nur mit dublettencheck!! ;)
					if ($check_double == 1 || $delete==1) {
						//dublettencheck
						$search['email']=$addr[$i]['email'];
						$search['email_exact_match']=true;
						//auf existenz pruefen und wenn email noch nicht existiert dann eintragen.
						//	function getAdr($id=0,$offset=0,$limit=0,$group_id=0,$search=Array(),$sortIndex="",$sortType=0,$Details=1) {
						$ADR=$ADDRESS->getAdr(0,0,0,0,$search,"","",0);
						$ac=count($ADR);//anzahl gefundener adressen
						if ($ac>0) {
							//gruppen zusammenfuehren, nur wenn nicht geloescht werden soll
							if ($merge_groups==1 && $delete !=1) {
								//wir diffen die gruppen und fuegen nur die referenzen hinzu die noch nicht existieren!
								//$check=false;
								//gruppen denen die adr bereits  angehoert
								$old_adr_grp = $ADDRESS->getGroupID(0,$ADR[0]['id'],0);//alte gruppen
								//neue gruppen nur die die neu sind, denen die adr noch nicht angehoert!
								//adr_grp=gruppen aus dem formular
								
								//old:
								#$new_adr_grp = array_diff($adr_grp,$old_adr_grp);//nur neue gruppen
								#$all_adr_grp = array_merge($old_adr_grp, $new_adr_grp);//alte+neue gruppen zusammenfuegen
								//next we should use method mergeGroups
								$all_adr_grp=$ADDRESS->mergeGroups($adr_grp,$old_adr_grp);//testing!
							} else {// merge groups
								$all_adr_grp=$new_adr_grp;//gruppe aus formular uebernehmen, ueberschreiben!
							}//merge
							$adr_exists=true;//adresse existiert
						}//ac>0
					}//check_double
					//////////////////////
					//oh! adresse ist bereits vorhanden!
					if ($adr_exists) {
					//wenn adresse existiert,
						//und nicht loeschen...:
						if ($delete!=1) {
							//adressdaten updaten!
							$code=$ADR[0]['code'];//code
							if ($aktiv_existing==-1) {
								$aktiv_update=$ADR[0]['aktiv'];//aktiv übernehmen
							} else {
								$aktiv_update=$aktiv_existing;//aktiv updaten
							}
							//adresse aktualisieren
							$ADDRESS->updateAdr(Array(
								"id"=>$ADR[0]['id'],
								"email"=>$addr[$i]['email'],
								"aktiv"=>$aktiv_update,
								"created"=>$created,
								"author"=>$author,
								"memo"=>"import update: ".$ADR[0]['memo'],
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
								$IMPORT_LOG.="<br>".sprintf(___("Zeile %s: E-Mail %s existiert Bereits und wurde aktualisiert und ggf. in neue Gruppen eingetragen."),($import_offset_user+$i+1),"<em>".$addr[$i]['email']."</em>");
							//wenn status_ex >0 dann aendern! status fuer bestehende adressen
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
							$IMPORT_LOG.="<br>".sprintf(___("Zeile %s: E-Mail %s wurde gelöscht."),($i+1),"<em>".$addr[$i]['email']."</em>");
							$idelete++;
						}

					}//adr_exists true

					if ($blacklist==1) {
							if (!$BLACKLIST->isBlacklisted($addr[$i]['email'],"email",0)) {//only_active=0, also alle, nicht nur aktive, was default waere
								$BLACKLIST->addBL(Array(
										"siteid"=>TM_SITEID,
										"expr"=>$addr[$i]['email'],
										"aktiv"=>1,
										"type"=>"email"
										));
								$IMPORT_LOG.="<br>".sprintf(___("Zeile %s: E-Mail %s wurde zur Blacklist hinzugefügt."),($i+1),"<em>".$addr[$i]['email']."</em>");
								$iblacklist++;
							} else {
								$IMPORT_LOG.="<br>".sprintf(___("Zeile %s: E-Mail %s ist bereits in der Blacklist vorhanden."),($i+1),"<em>".$addr[$i]['email']."</em>");
							}
					}
					if ($delete==1 && !$adr_exists) { // not exists
						$IMPORT_LOG.="<br>".sprintf(___("Zeile %s: E-Mail %s existiert nicht."),($i+1),"<em>".$addr[$i]['email']."</em>");
					}
					if (!$adr_exists) { // not exists
						//nur importieren und neu eintragen wenn auch ene gruppe gewaehlt wurde, sonst enstehen datenleichen ohne gruppe! das waere sinnlos!
						//und nur einfuegen wenn nicht geloescht werden soll, ne, is klar!
						if ($delete != 1 && !empty($adr_grp)) {
							//wenn adresse noch nicht existiert , neu anlegen
							$ADDRESS->addAdr(Array(
								"email"=>$addr[$i]['email'],
								"aktiv"=>$aktiv_new,
								"created"=>$created,
								"author"=>$author,
								"status"=>$status_new,
								"code"=>$code,
								"memo"=>"import",
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
								$IMPORT_LOG.="<br>".sprintf(___("Zeile %s: E-Mail %s  wurde hinzugefügt und in gewählten Gruppen eingetragen."),($import_offset_user+$i+1),"<em>".$addr[$i]['email']."</em>");
							$iok++;
						} // ! delete
					}//adr exists false

					//importierte Adressen loeschen?
			}//isset email
		}//for

		//adressen vergessen
		unset ($addr);
		
		if ($blacklist==1) {
			$IMPORT_MESSAGE.= "<br><br>".sprintf(___("Es wurden %s von %s Einträgen in die Blacklist eingefügt."),$iblacklist,($i));//i-1
		}
		if ($delete==1) {
			$IMPORT_MESSAGE.= "<br><br>".sprintf(___("Es wurden %s von %s Einträgen gelöscht."),$idelete,($i));//i-1
		} else {
			$IMPORT_MESSAGE.= "<br><br>".sprintf(___("Es wurden %s von %s Einträgen importiert und in die gewählten Gruppen eingetragen."),$iok,($i));//i-1
			$IMPORT_MESSAGE.= "<br>".sprintf(___("%s Einträge waren Fehlerhaft und wurden NICHT importiert."),$ifail);
			$IMPORT_MESSAGE.= "<br>".sprintf(___("%s Eintraege sind bereits vorhanden und wurden aktualisiert."),$idouble);
		}

		$IMPORT_MESSAGE.= "<br>".sprintf(___("Bearbeitungszeit: %s Sekunden"),number_format($T->MidResult(), 2, ',', ''));
		$action="adr_import";

		//import messages vor log einfuegen
		$IMPORT_LOG=$IMPORT_MESSAGE.$IMPORT_LOG;
		//logdatei schreiben:
		$logfilename="import_".date_convert_to_string($created).".html";
		$IMPORT_MESSAGE.= "<br>".___("Logdatei für Import wurde gespeichert unter:")." <a href=\"".$tm_URL_FE."/".$tm_logdir."/".$logfilename."\" target=\"_preview\">".$tm_logdir."/".$logfilename."</a>";
		//$IMPORT_LOG nach text convertieren
	    #$htmlToText=new Html2Text($IMPORT_LOG, 1024);
	    #$IMPORT_LOG=$htmlToText->convert();
		//logdatei speichern
		write_file($tm_logpath,$logfilename,$IMPORT_LOG);
	} else {//if lines>0
	}
} else {
}
$_MAIN_MESSAGE.=$IMPORT_MESSAGE;
require_once (TM_INCLUDEPATH."/adr_import_form.inc.php");
?>