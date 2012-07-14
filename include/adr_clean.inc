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

$_MAIN_DESCR=___("Adressdatenbank bereinigen");
$_MAIN_MESSAGE.="";
//$search_array=Array();
$ADDRESS=new mnlADR();

$InputName_Set="set";//
$$InputName_Set=getVar($InputName_Set);

$InputName_Name="email";//
$$InputName_Name=getVar($InputName_Name);

$InputName_Status="status";//
$$InputName_Status=getVar($InputName_Status);

$InputName_Group="adr_grp_id";//
$$InputName_Group=getVar($InputName_Group);

$InputName_GroupDst="adr_grp_id_dst";//
$$InputName_GroupDst=getVar($InputName_GroupDst);




if (!empty($set)) {
	$search['email']=str_replace("*","%",$email);
	$search['status']=$status;
	$search['group']=$adr_grp_id;
	$GRP=$ADDRESS->getGroup($adr_grp_id);
	$ADR=$ADDRESS->getAdrID($adr_grp_id,$search);
	$ac=count($ADR);
}


//if ($set=="delete" && $doit==1) {
if ($set=="delete" && $status!="delete_all") {
	for ($acc=0;$acc<$ac;$acc++) {
		if (!DEMO) $ADDRESS->delAdr($ADR[$acc]);
		//$_MAIN_MESSAGE.=$ADR[$acc]."<br>";
	}
	$_MAIN_MESSAGE.="<br>".sprintf(___("%s Einträge aus der Gruppe %s mit dem Status %s wurden gelÖscht."),"<b>".$ac."</b>","<b>".$GRP[0]['name']."</b>","<b>".$STATUS['adr']['status'][$search['status']]."</b>");
}


if ($set=="delete" && $status=="delete_all") { // && $doit==1
	$GRP=$ADDRESS->getGroup($adr_grp_id);
	$search['email']=str_replace("*","%",$email);
	$search['group']=$adr_grp_id;
	//	8
	$search['status']=8;
	$ADR=$ADDRESS->getAdrID($adr_grp_id,$search);
	$ac=count($ADR);
	for ($acc=0;$acc<$ac;$acc++) {
		if (!DEMO) $ADDRESS->delAdr($ADR[$acc]);
		//$_MAIN_MESSAGE.=$ADR[$acc]."<br>";
	}
	$_MAIN_MESSAGE.="<br>".sprintf(___("%s Einträge aus der Gruppe %s mit dem Status %s wurden gelÖscht."),"<b>".$ac."</b>","<b>".$GRP[0]['name']."</b>","<b>".$STATUS['adr']['status'][$search['status']]."</b>");
	//	9
	$search['status']=9;
	$ADR=$ADDRESS->getAdrID($adr_grp_id,$search);
	$ac=count($ADR);
	for ($acc=0;$acc<$ac;$acc++) {
		if (!DEMO) $ADDRESS->delAdr($ADR[$acc]);
		//$_MAIN_MESSAGE.=$ADR[$acc]."<br>";
	}
	$_MAIN_MESSAGE.="<br>".sprintf(___("%s Einträge aus der Gruppe %s mit dem Status %s wurden gelÖscht."),"<b>".$ac."</b>","<b>".$GRP[0]['name']."</b>","<b>".$STATUS['adr']['status'][$search['status']]."</b>");
	//	11
	$search['status']=11;
	$ADR=$ADDRESS->getAdrID($adr_grp_id,$search);
	$ac=count($ADR);
	for ($acc=0;$acc<$ac;$acc++) {
		if (!DEMO) $ADDRESS->delAdr($ADR[$acc]);
		//$_MAIN_MESSAGE.=$ADR[$acc]."<br>";
	}
	$_MAIN_MESSAGE.="<br>".sprintf(___("%s Einträge aus der Gruppe %s mit dem Status %s wurden gelÖscht."),"<b>".$ac."</b>","<b>".$GRP[0]['name']."</b>","<b>".$STATUS['adr']['status'][$search['status']]."</b>");


}



//uebersicht anzeigen!
	//adr_grp_id
	$_MAIN_OUTPUT.="<b>".___("Übersicht").":</b><br><br>";
	$AG=$ADDRESS->getGroup();
	$agc=count($AG);
	for ($agcc=0;$agcc<$agc;$agcc++) {
		$_MAIN_OUTPUT.= "<a  href=\"javascript:switchSection('g_".$AG[$agcc]['id']."')\" title=\"".___("Details")."\">";
		$_MAIN_OUTPUT.="<img src=\"".$mnl_iconURL."/add.png\" border=\"0\" alt=\"".___("Details")."\" title=\"".___("Details")."\">";
		$_MAIN_OUTPUT.="&nbsp;'<b>".$AG[$agcc]['name']."</b>'</a>&nbsp;&nbsp;";
		//Gesamtstatus, anzahl per adr-status
		$ac=$ADDRESS->countADR($AG[$agcc]['id']);
		$_MAIN_OUTPUT.=sprintf(___("%s Adressen"),"<b>".$ac."</b>");
		$_MAIN_OUTPUT.="<div id=\"g_".$AG[$agcc]['id']."\" style=\"border:1px dashed #eeeeee; -moz-border-radius:2em 2em 2em 2em; padding:8px;\">";
		//per adr status:
		$asc=count($STATUS['adr']['status']);
		for ($ascc=1; $ascc<=$asc; $ascc++) {
			unset($search);
			$search['status']=$ascc;
			$ac=$ADDRESS->countADR($AG[$agcc]['id'],$search);
			if ($ac>0) {
				$_MAIN_OUTPUT.="<b>".$ac."</b>".
								"&nbsp;<img src=\"".$mnl_iconURL."/".$STATUS['adr']['statimg'][$ascc]."\" border=\"0\">".
								"&nbsp;".$STATUS['adr']['status'][$ascc].
								"&nbsp;(".$STATUS['adr']['descr'][$ascc].")<br>";	
			}
		}
		$_MAIN_OUTPUT.="</div>";
		$_MAIN_OUTPUT.= "<script type=\"text/javascript\">switchSection('g_".$AG[$agcc]['id']."');</script>";
		$_MAIN_OUTPUT.="<br>";

	}
$_MAIN_OUTPUT.="<br>";
include_once ($mnl_includepath."/adr_clean_form.inc");
?>