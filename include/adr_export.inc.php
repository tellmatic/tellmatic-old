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

$_MAIN_DESCR=___("Adressen exportieren (CSV-Export)");
$_MAIN_MESSAGE="";

//status
$InputName_Status="status";//
$$InputName_Status=getVar($InputName_Status);
//trennzeichen
$InputName_Delimiter="delimiter";//
$$InputName_Delimiter=getVar($InputName_Delimiter);
//export dateiname
$InputName_File="filename";//
$$InputName_File=clear_text(getVar($InputName_File));
//status
$InputName_Status="status";//
$$InputName_Status=getVar($InputName_Status);

//usr limit
$InputName_Limit="export_limit_user";//
$$InputName_Limit=getVar($InputName_Limit);
if (empty($$InputName_Limit)) $$InputName_Limit=0;

//usr offset
$InputName_Offset="export_offset_user";//
$$InputName_Offset=getVar($InputName_Offset);
if (empty($$InputName_Offset)) $$InputName_Offset=0;

$InputName_FileExisting="file_existing";//datei auswahl
$$InputName_FileExisting=getVar($InputName_FileExisting);

//append//an bestehende datei anfügen
$InputName_Append="append";//
$$InputName_Append=getVar($InputName_Append);

//aaaaand action
$set=getVar("set");
//adr gruppe
$InputName_Group="adr_grp_id";//gruppen id
$$InputName_Group=getVar($InputName_Group);

//ausgabedatei:
//standard name aus datum fuer export generieren
$created=date("Y-m-d H:i:s");
//default:
$Export_Filename="export_".date_convert_to_string($created)."";
if (!empty($$InputName_File)) {
	//wenn dateiname angegeben...:
	$CSV_Filename=$$InputName_File;
} else {
	//wenn kein name --> default
	$CSV_Filename=$Export_Filename;
}
//extension .csv
$CSV_Filename=$CSV_Filename.".csv";
//oder
//wenn bestehende datei ausgewaehlt, nehmen wir diese!
if (!empty($file_existing)) {
	$CSV_Filename=$file_existing;
}
//neuer name im formular ist default fuer naechsten aufruf
$$InputName_File=$Export_Filename;


//export und gruppe gewaehlt?
if ($set=="export" && $adr_grp_id>0) {
	//anzahl adressen die auf einmal in ein array gepackt und geschrieben werden sollen, abhaengig vom Speicher fuer PHP. wird definiert in tm_lib
	$export_limit_run=$adr_row_limit;//default limit adressen im array pro durchgang
	//addressen initialisieren
	$ADDRESS=new tm_ADR();
	//ggf nach status filtern?
	$search['status']=$status;
	$code=0;
	/*********************************************/
	//gesamtanzahl adressen ermitteln
	$adc=$ADDRESS->countAdr($adr_grp_id,$search);//grp_id,search//
	$export_total=$adc;
	if (DEBUG) $_MAIN_MESSAGE.="<br>export_total=$export_total";
	//wenn limit_usr angegeben ist, und kleiner oder gleich export_total(anzahl eintraege gesamt), dann setze export_total=limit_usr
	//if (limit_usr > 0 && !empty && limit_usr <= export_total) export_total=limit_usr
	if ($export_limit_user > 0 && $export_limit_user <= $export_total)	{
		if (DEBUG) $_MAIN_MESSAGE.="<br>export_limit_user ($export_limit_user) &gt; 0 && &lt;= export_total ($export_total)";
		$export_total=$export_limit_user;
		if (DEBUG) $_MAIN_MESSAGE.="<br>new export_total = export_limit_user ($export_limit_user)";
	}
	//wenn limit_usr kleiner der anzahl zu exportierender eintraege pro durchlauf, dann setze limit_run=limit_usr
	//if (limit_usr < limit_run) limit_run=limit_usr
	if ($export_limit_user >0 && $export_limit_user < $export_limit_run)	{
		if (DEBUG) $_MAIN_MESSAGE.="<br>export_limit_user ($export_limit_user) &lt; export_limit_run ($export_limit_run)";
		$export_limit_run=$export_limit_user;
		if (DEBUG) $_MAIN_MESSAGE.="<br>new export_limit_run = export_limit_user ($export_limit_user)";
	}
	//anzahl maximaler durchlaeufe
	//run_max=(int)(export_total / limit_run)
	$export_run_max=(int)($export_total / $export_limit_run);
	if (DEBUG) $_MAIN_MESSAGE.="<br>export_run_max = (int) export_total ($export_total) / export_limit_run ($export_limit_run) = $export_run_max";
	/*********************************************/
	//hat der user einen offset gesetzt?
	$export_offset=0;
	if ($export_offset_user>0)	{
		$export_offset=$export_offset_user;
	}
	/*********************************************/
	//Gruppe auslesen
	$adr_grp=$ADDRESS->getGroup($adr_grp_id);
	$_MAIN_MESSAGE.="<br>".sprintf(___("gewählte Gruppe: %s"),$adr_grp[0]['name']);

	$status_message=___("Alle");
	if (!empty($status)) {
		$status_message="&nbsp;<img src=\"".$tm_iconURL."/".$STATUS['adr']['statimg'][$status]."\" border=\"0\">".
								"&nbsp;".$STATUS['adr']['status'][$status].
								"&nbsp;(".$STATUS['adr']['descr'][$status].")";
	}
	$_MAIN_MESSAGE.="<br>".sprintf(___("mit Status: %s"),$status_message);
	$_MAIN_MESSAGE.= "<br>".sprintf(___("%s Einträge gesamt."),$adc);
	$_MAIN_MESSAGE.= "<br>".sprintf(___("Maximal %s Einträge werden exportiert."),($export_total));
	$_MAIN_MESSAGE.= "<br>".sprintf(___("Offset: %s"),$export_offset_user);

	if ($export_total>0) {	//wenn min 1 eintrag:
		 $_MAIN_MESSAGE.= "<br>".sprintf(___("Exportiere %s"),"<b>".$CSV_Filename."</b>");
		//adressen haeppchenweise auslesen
		//File oeffnen!
		if ($append==1) {
			$fp = fopen($tm_datapath."/".$CSV_Filename,"a");
			 $_MAIN_MESSAGE.= "<br>".sprintf(___("Daten werden an bestehende Datei angefügt: %s"),"<b>".$CSV_Filename."</b>");
		} else {
			$fp = fopen($tm_datapath."/".$CSV_Filename,"w");
			 $_MAIN_MESSAGE.= "<br>".sprintf(___("Daten werden in neue Datei gespeichert: %s"),"<b>".$CSV_Filename."</b>");
		}
		if (!$fp) {
			 $_MAIN_MESSAGE.= "<br>".sprintf(___("Export-Datei kann nicht geöffnet werden %s"),"<b>".$CSV_Filename."</b>");
		} else {
			if ($append!=1) {
				//CSV Headline
				$CSV="\"email\"$delimiter\"f0\"$delimiter\"f1\"$delimiter\"f2\"$delimiter\"f3\"$delimiter\"f4\"$delimiter\"f5\"$delimiter\"f6\"$delimiter\"f7\"$delimiter\"f8\"$delimiter\"f9\"$delimiter\"id\"$delimiter\"created\"$delimiter\"author\"$delimiter\"updated\"$delimiter\"editor\"$delimiter\"aktiv\"$delimiter\"status\"$delimiter\"code\"$delimiter\"errors\"$delimiter\"clicks\"$delimiter\"views\"$delimiter\"newsletter\"\n";
				//write header
				if (DEBUG) $_MAIN_MESSAGE.="<br>Schreibe CSV-Header";
				fputs($fp,$CSV,strlen($CSV));
			}
			//anzahl wirklich exportierter eintraege:
			$exported=0;
			//loop 1
			if (DEBUG) $_MAIN_MESSAGE.="<br>Do Loop:";
			for ($export_run=0;$export_run <= $export_run_max; $export_run++) { //<=
			//schleife
			//for (run=0; run <= run_max; run++)
				if (DEBUG) $_MAIN_MESSAGE.="<br>export_run ($export_run) &lt;= export_run_max ($export_run_max)";
				//wenn anz durchlaeufe * limit_run >= export_total, limit anpassen!
				//if ( (run+1) * limit_run) > export_total)
				if ( (($export_run +1) * $export_limit_run  ) >= $export_total ) {
					if (DEBUG) $_MAIN_MESSAGE.="<br>export_run+1 (".($export_run+1).") * export_limit_run ($export_limit_run) &gt;= export_total ($export_total)";
					//limit_run justieren: gesamt - durchlaeufe * anzahl_pro_durchlauf
					//limit_run = export_total - ( run * limit_run)
					$export_limit_run_prev=$export_limit_run;
					$export_limit_run = $export_total - ($export_run * $export_limit_run);
					if (DEBUG) $_MAIN_MESSAGE.="<br>new export_limit_run ($export_limit_run) = export_total ($export_total) - (export_run($export_run) * export_limit_run($export_limit_run_prev))";
				}
				if ($export_limit_run>0) {
					if (DEBUG) $_MAIN_MESSAGE.="<br>export_limit_run ($export_limit_run) >0";
					//hole adressen
					//get(offset,limit_run)
					// getAdr($id=0,$offset=0,$limit=0,$group_id=0,$search=Array(),$sortIndex="",$sortType=0)
					//adressen auslesen
					if (DEBUG) $_MAIN_MESSAGE.="<br>get($export_offset,$export_limit_run)";
					$ADR=$ADDRESS->getAdr(0,$export_offset,$export_limit_run,$adr_grp_id,$search);//id,offset,limit,group
					$ac=count($ADR);//aktuelle anzahl ermittelte adressen
					if ($ac>0) {
						if (DEBUG) $_MAIN_MESSAGE.="<br>export_run $export_run von $export_run_max , Found: $ac Adr: $export_offset - ".($export_offset+$ac)." , Total: $adc Adr, Limit: $export_limit_run, Offset: $export_offset<br>";
						//loop 2
						for ($acc=0;$acc<$ac;$acc++) {
							//CSV Zeile erstellen:
							$CSV="";
							$memo=str_replace("\n"," --|-- ",$ADR[$acc]['memo']);
							$memo=str_replace("\r"," --|-- ",$memo);
							$CSV.="\"".$ADR[$acc]['email']."\"$delimiter";
							$CSV.="\"".$ADR[$acc]['f0']."\"$delimiter";
							$CSV.="\"".$ADR[$acc]['f1']."\"$delimiter";
							$CSV.="\"".$ADR[$acc]['f2']."\"$delimiter";
							$CSV.="\"".$ADR[$acc]['f3']."\"$delimiter";
							$CSV.="\"".$ADR[$acc]['f4']."\"$delimiter";
							$CSV.="\"".$ADR[$acc]['f5']."\"$delimiter";
							$CSV.="\"".$ADR[$acc]['f6']."\"$delimiter";
							$CSV.="\"".$ADR[$acc]['f7']."\"$delimiter";
							$CSV.="\"".$ADR[$acc]['f8']."\"$delimiter";
							$CSV.="\"".$ADR[$acc]['f9']."\"$delimiter";
							$CSV.="\"".$ADR[$acc]['id']."\"$delimiter";
							$CSV.="\"".$ADR[$acc]['created']."\"$delimiter";
							$CSV.="\"".$ADR[$acc]['author']."\"$delimiter";
							$CSV.="\"".$ADR[$acc]['updated']."\"$delimiter";
							$CSV.="\"".$ADR[$acc]['editor']."\"$delimiter";
							$CSV.="\"".$ADR[$acc]['aktiv']."\"$delimiter";
							$CSV.="\"".$ADR[$acc]['status']."\"$delimiter";
							$CSV.="\"".$ADR[$acc]['code']."\"$delimiter";
							$CSV.="\"".$ADR[$acc]['errors']."\"$delimiter";
							$CSV.="\"".$ADR[$acc]['clicks']."\"$delimiter";
							$CSV.="\"".$ADR[$acc]['views']."\"$delimiter";
							$CSV.="\"".$ADR[$acc]['newsletter']."\"$delimiter";
							$CSV.="\"".$memo;
							$CSV.="\n";
							//free some memory ;-)
							unset($ADR[$acc]);
							//und in file schreiben:
							fputs($fp,$CSV,strlen($CSV));
							$exported++;
						}//for	$acc
						//datei schreiben:	war: append_file($tm_datapath,$CSV_Filename,$CSV);, verbraucht aber da die werte in CSV gesammelt werde zu viel RAM, wir schreiben innerhalb der schleife einfach direkt ins file
						//neuer offset:
						//offset +=limit_run
						$export_offset +=$export_limit_run;
						if (DEBUG) $_MAIN_MESSAGE.="new export_offset = $export_offset";
						if (DEBUG) $_MAIN_MESSAGE.="<hr>";
						#$CSV="";
					}//if ac>0
				}//export_limit_run >0
			}//for $export run
			unset($CSV);
			unset($ADR);
			//close file
			fclose($fp);
			//chmod
			chmod ($tm_datapath."/".$CSV_Filename, 0664);
		}//if $fp
		$_MAIN_MESSAGE.= "<br>".sprintf(___("Es wurden insgesamt %s Einträge exportiert."),$exported);
		$_MAIN_MESSAGE.= "<br>".sprintf(___("Datei gespeichert unter: %s"),"<a href=\"".$tm_URL_FE."/".$tm_datadir."/".$CSV_Filename."\" target=\"_preview\">".$tm_datadir."/".$CSV_Filename."</a>");
	}//adc>0
}//export
include (TM_INCLUDEPATH."/adr_export_form.inc.php");
?>