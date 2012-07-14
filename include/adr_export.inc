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

$InputName_Delimiter="delimiter";//
$$InputName_Delimiter=getVar($InputName_Delimiter);

$InputName_File="filename";//
$$InputName_File=clear_text(getVar($InputName_File));

$set=getVar("set");
$InputName_Group="adr_grp_id";//gruppen id
$$InputName_Group=getVar($InputName_Group);

//ausgabedatei:
//standard name fuer export generieren
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
//neuer name im formular ist default
$$InputName_File=$Export_Filename;	


//export und gruppe gewaehlt?
if ($set=="export" && $adr_grp_id>0) {
	//extension .csv
	$CSV_Filename=$CSV_Filename.".csv";
//addressen einlesen
	$ADDRESS=new mnlADR();
	// getAdr($id=0,$offset=0,$limit=0,$group_id=0,$search=Array(),$sortIndex="",$sortType=0)
	$search['status']=$status;
	$code=0;
	$ADR=$ADDRESS->getAdr(0,0,0,$adr_grp_id,$search);//id,offset,limit,group
	$adr_grp=$ADDRESS->getGroup($adr_grp_id);
	$ADR=sort_array($ADR,"email",1);
	$ac=count($ADR);

	$_MAIN_MESSAGE.="<br>".sprintf(___("gewählte Gruppe: %s"),$adr_grp[0]['name']);
	$_MAIN_MESSAGE.= "<br>".sprintf(___("%s Einträge gefunden."),$ac);
	if ($ac>0) {
  	$_MAIN_MESSAGE.= "<br>".sprintf(___("Exportiere %s"),"<b>".$CSV_Filename."</b>");
		$CSV="\"email\"$delimiter\"f0\"$delimiter\"f1\"$delimiter\"f2\"$delimiter\"f3\"$delimiter\"f4\"$delimiter\"f5\"$delimiter\"f6\"$delimiter\"f7\"$delimiter\"f8\"$delimiter\"f9\"$delimiter\"memo\"$delimiter\"created\"$delimiter\"aktiv\"$delimiter\"status\"$delimiter\"code\"$delimiter\"id\"\n";
	$CSV="\"email\",\"f0\",\"f1\",\"f2\",\"f3\",\"f4\",\"f5\",\"f6\",\"f7\",\"f8\",\"f9\",\"created\",\"aktiv\",\"status\",\"code\",\"id\"\n";
	//CSV erstellen
	for ($acc=0;$acc<$ac;$acc++) {
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
			$CSV.="\"".$memo."\"$delimiter";
			$CSV.="\"".$ADR[$acc]['created']."\"$delimiter";
			$CSV.="\"".$ADR[$acc]['aktiv']."\"$delimiter";
			$CSV.="\"".$ADR[$acc]['status']."\"$delimiter";
			$CSV.="\"".$ADR[$acc]['code']."\"$delimiter";
		$CSV.="\"".$ADR[$acc]['id']."\"";
		$CSV.="\n";
	}	
		//datei schreiben:
	write_file($mnl_datapath,$CSV_Filename,$CSV);
		$_MAIN_MESSAGE.= "<br>".sprintf(___("Datei gespeichert unter: %s"),"<a href=\"".$mnl_URL_FE."/".$mnl_datadir."/".$CSV_Filename."\" target=\"_preview\">".$mnl_datadir."/".$CSV_Filename."</a>");
	}//ac>0
}//export 

include ($mnl_includepath."/adr_export_form.inc");
?>
