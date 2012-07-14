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

$_MAIN_DESCR=___("Adressen exportieren (CSV-Export)");
$_MAIN_MESSAGE="";

//status
$InputName_Status="status";//
$status=getVar("status");


$set=getVar("set");
$InputName_Group="adr_grp_id";//gruppen id
$$InputName_Group=getVar($InputName_Group);

if ($set=="export" && $adr_grp_id>0) {
	$created=date("Y-m-d H:i:s");
	$CSV_Filename="export_".date_convert_to_string($created).".csv";$code=0;


	
//addressen einlesen
	$ADDRESS=new mnlADR();
	// getAdr($id=0,$offset=0,$limit=0,$group_id=0,$search=Array(),$sortIndex="",$sortType=0)
	$search['status']=$status;
	$ADR=$ADDRESS->getAdr(0,0,0,$adr_grp_id,$search);//id,offset,limit,group
	$adr_grp=$ADDRESS->getGroup($adr_grp_id);
	$ADR=sort_array($ADR,"email",1);
	$ac=count($ADR);

	$_MAIN_MESSAGE.="<br>".sprintf(___("gew&auml;hlte Gruppe: %s"),$adr_grp[0]['name']);
  	$_MAIN_MESSAGE.= "<br>".sprintf(___("Exportiere %s"),"<b>".$CSV_Filename."</b>");
   $_MAIN_MESSAGE.= "<br>".sprintf(___("%s Eintr&auml;ge gefunden."),$ac);
	$CSV="\"email\",\"f0\",\"f1\",\"f2\",\"f3\",\"f4\",\"f5\",\"f6\",\"f7\",\"f8\",\"f9\",\"created\",\"aktiv\",\"status\",\"code\",\"id\"\n";
	//CSV erstellen
	for ($acc=0;$acc<$ac;$acc++) {
		$CSV.="\"".$ADR[$acc]['email']."\",";
		$CSV.="\"".$ADR[$acc]['f0']."\",";
		$CSV.="\"".$ADR[$acc]['f1']."\",";
		$CSV.="\"".$ADR[$acc]['f2']."\",";
		$CSV.="\"".$ADR[$acc]['f3']."\",";
		$CSV.="\"".$ADR[$acc]['f4']."\",";
		$CSV.="\"".$ADR[$acc]['f5']."\",";
		$CSV.="\"".$ADR[$acc]['f6']."\",";
		$CSV.="\"".$ADR[$acc]['f7']."\",";
		$CSV.="\"".$ADR[$acc]['f8']."\",";
		$CSV.="\"".$ADR[$acc]['f9']."\",";
		$CSV.="\"".$ADR[$acc]['created']."\",";
		$CSV.="\"".$ADR[$acc]['aktiv']."\",";
		$CSV.="\"".$ADR[$acc]['status']."\",";
		$CSV.="\"".$ADR[$acc]['code']."\",";
		$CSV.="\"".$ADR[$acc]['id']."\"";
		$CSV.="\n";
	}	

	write_file($mnl_datapath,$CSV_Filename,$CSV);
	$_MAIN_MESSAGE.= "<br>".sprintf(___("Datei gespeichert unter: %s"),"<a href=\"".$mnl_datadir."/".$CSV_Filename."\" target=\"_preview\">".$mnl_datadir."/".$CSV_Filename."</a>");
	//upload_form

}
include ($mnl_includepath."/adr_export_form.inc");
?>
