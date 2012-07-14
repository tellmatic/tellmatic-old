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
$ADDRESS=new tm_ADR();

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
	$GRP=$ADDRESS->getGroup($adr_grp_id);
	$search['email']=str_replace("*","%",$email);
	$search['status']=$status;
	$search['group']=$adr_grp_id;
	$ac=$ADDRESS-> countAdr(0,$search);
}

if ($set=="delete" && $status!="delete_all") {
	if (!DEMO) $ADDRESS->cleanAdr($search);
	$_MAIN_MESSAGE.="<br>".sprintf(___("%s Einträge aus der Gruppe %s mit dem Status %s wurden gelöscht."),"<b>".$ac."</b>","<b>".$GRP[0]['name']."</b>","<b>".$STATUS['adr']['status'][$search['status']]."</b>");
}


if ($set=="delete" && $status=="delete_all") { // && $doit==1
	//	6
	$search['status']=6;
	$ac=$ADDRESS-> countAdr(0,$search);
	if (!DEMO) $ADDRESS->cleanAdr($search);
	$_MAIN_MESSAGE.="<br>".sprintf(___("%s Einträge aus der Gruppe %s mit dem Status %s wurden gelöscht."),"<b>".$ac."</b>","<b>".$GRP[0]['name']."</b>","<b>".$STATUS['adr']['status'][$search['status']]."</b>");
	//	7
	$search['status']=7;
	$ac=$ADDRESS-> countAdr(0,$search);
	if (!DEMO) $ADDRESS->cleanAdr($search);
	$_MAIN_MESSAGE.="<br>".sprintf(___("%s Einträge aus der Gruppe %s mit dem Status %s wurden gelöscht."),"<b>".$ac."</b>","<b>".$GRP[0]['name']."</b>","<b>".$STATUS['adr']['status'][$search['status']]."</b>");
	//	8
	$search['status']=8;
	$ac=$ADDRESS-> countAdr(0,$search);
	if (!DEMO) $ADDRESS->cleanAdr($search);
	$_MAIN_MESSAGE.="<br>".sprintf(___("%s Einträge aus der Gruppe %s mit dem Status %s wurden gelöscht."),"<b>".$ac."</b>","<b>".$GRP[0]['name']."</b>","<b>".$STATUS['adr']['status'][$search['status']]."</b>");
	//	9
	$search['status']=9;
	$ac=$ADDRESS-> countAdr(0,$search);
	if (!DEMO) $ADDRESS->cleanAdr($search);
	$_MAIN_MESSAGE.="<br>".sprintf(___("%s Einträge aus der Gruppe %s mit dem Status %s wurden gelöscht."),"<b>".$ac."</b>","<b>".$GRP[0]['name']."</b>","<b>".$STATUS['adr']['status'][$search['status']]."</b>");
	/*
	//	10
	$search['status']=10;
	$ac=$ADDRESS-> countAdr(0,$search);
	if (!DEMO) $ADDRESS->cleanAdr($search);
	$_MAIN_MESSAGE.="<br>".sprintf(___("%s Einträge aus der Gruppe %s mit dem Status %s wurden gelöscht."),"<b>".$ac."</b>","<b>".$GRP[0]['name']."</b>","<b>".$STATUS['adr']['status'][$search['status']]."</b>");
	*/
	//	11
	$search['status']=11;
	$ac=$ADDRESS-> countAdr(0,$search);
	if (!DEMO) $ADDRESS->cleanAdr($search);
	$_MAIN_MESSAGE.="<br>".sprintf(___("%s Einträge aus der Gruppe %s mit dem Status %s wurden gelöscht."),"<b>".$ac."</b>","<b>".$GRP[0]['name']."</b>","<b>".$STATUS['adr']['status'][$search['status']]."</b>");
}



//uebersicht anzeigen!
	//adr_grp_id
	$_MAIN_OUTPUT.="<b>".___("Übersicht").":</b><br><br>";
	$AG=$ADDRESS->getGroup();
	$agc=count($AG);
	for ($agcc=0;$agcc<$agc;$agcc++) {
		$_MAIN_OUTPUT.= "<a  href=\"javascript:switchSection('g_".$AG[$agcc]['id']."')\" title=\"".___("Details")."\">";
		$_MAIN_OUTPUT.=tm_icon("add.png",___("Details"));
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
								"&nbsp;".tm_icon($STATUS['adr']['statimg'][$ascc],$STATUS['adr']['status'][$ascc]).
								"&nbsp;".$STATUS['adr']['status'][$ascc].
								"&nbsp;(".$STATUS['adr']['descr'][$ascc].")<br>";
			}
		}
		$_MAIN_OUTPUT.="</div>";
		$_MAIN_OUTPUT.= "<script type=\"text/javascript\">switchSection('g_".$AG[$agcc]['id']."');</script>";
		$_MAIN_OUTPUT.="<br>";

	}
$_MAIN_OUTPUT.="<br>";
include_once (TM_INCLUDEPATH."/adr_clean_form.inc.php");
?>