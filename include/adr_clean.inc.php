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

$InputName_Blacklist="blacklist";//
$$InputName_Blacklist=getVar($InputName_Blacklist);

$InputName_Name="email";//
$$InputName_Name=getVar($InputName_Name);

$InputName_Status="status";//
$$InputName_Status=getVar($InputName_Status);

$InputName_Group="adr_grp_id";//
$$InputName_Group=getVar($InputName_Group);

$InputName_StatusDst="status_multi";//
$$InputName_StatusDst=getVar($InputName_StatusDst);

$InputName_GroupDst="adr_grp_id_multi";//
pt_register("POST",$InputName_GroupDst);
if (!isset($$InputName_GroupDst)) {
	$$InputName_GroupDst=Array();
}

$showGroupUrlPara=$mSTDURL;
$showGroupStatusUrlPara=$mSTDURL;

$showGroupUrlPara->addParam("act","adr_list");
$showGroupStatusUrlPara->addParam("act","adr_list");

if (!empty($set)) {
	$GRP=$ADDRESS->getGroup($adr_grp_id);
	$search['email']=str_replace("*","%",$email);
	$search['status']=$status;
	$search['group']=$adr_grp_id;
	$ac=$ADDRESS-> countAdr(0,$search);
	$_MAIN_MESSAGE.="<br>".sprintf(___("%s Einträge werden bearbeitet."),"<b>".$ac."</b>");
}

if (((!empty($set) && $set!="delete") || $blacklist==1) && $ac>0) { // wenn min 1 adr gefunden
	//meldungen ausgeben
	if ($set=="aktiv_1") {
		$_MAIN_MESSAGE.="<br>".___("Ausgewählte Adressen werden aktiviert");
	}
	if ($set=="aktiv_0") {
		$_MAIN_MESSAGE.="<br>".___("Ausgewählte Adressen werden deaktiviert.");
	}
	if ($set=="set_status") {
		$_MAIN_MESSAGE.="<br>".sprintf(___("Setze neuen Status für ausgewählte Adressen auf %s"),tm_icon($STATUS['adr']['statimg'][$status_multi],$STATUS['adr']['status'][$status_multi])."&nbsp;\"<b>".$STATUS['adr']['status'][$status_multi])."</b>\"";
	}
	if ($set=="copy_grp") {
		$_MAIN_MESSAGE.="<br>".___("Ausgewählte Adressen werden in die gewählten Gruppen kopiert.");
	}
	if ($set=="move_grp") {
		$_MAIN_MESSAGE.="<br>".___("Ausgewählte Adressen werden in die gewählten Gruppen verschoben.");
	}
	if ($set=="delete_grp") {
		$_MAIN_MESSAGE.="<br>".___("Ausgewählte Adressen werden aus den gewählten Gruppen gelöscht.");
	}
	if ($blacklist==1) {
		$BLACKLIST=new tm_BLACKLIST();
		$_MAIN_MESSAGE.="<br>".___("Ausgewählte Adressen werden zur Blacklist hinzugefügt.");
	}
	if ($set=="delete_history") {
		$QUEUE=new tm_Q();
		$_MAIN_MESSAGE.="<br>".___("Historie ausgewählter Adressen werden gelöscht.");
	}
//adressids holen ud in adr_id_arr speichern
	$adr_id_arr=$ADDRESS->getAdrID(0,$search);
	//adrarray durchwandern
	for ($acc_m=0;$acc_m<$ac;$acc_m++) {
		//blacklist? MUSS vor anderen aktionen stehen wegen getAdr!!
		if ($blacklist==1) {//hier wird naemlich auch nich $set abgefragt! sondern eben $blacklist als eigenes flag! (checkbox), soll aber auch verfuegbar sein wenn set==delete 
		//ist.... sonst muesste man zum blacklisten alle anderen aktionen kombinieren :O
		//andere loesung waere checkboxen, die aber per js auf gueltigkeit geprueft werden muessen da verschieben und loeschen nix bringt!
			//get adr
			$ADR_BL=$ADDRESS->getAdr($adr_id_arr[$acc_m]);
			//checkblacklist
			if (!$BLACKLIST->isBlacklisted($ADR_BL[0]['email'],"email")) {
			//blacklist adr
				$BLACKLIST->addBL(Array(
						"siteid"=>TM_SITEID,
						"expr"=>$ADR_BL[0]['email'],
						"aktiv"=>1,
						"type"=>"email"
						));
			}
		}
		//activate adr
		if ($set=="aktiv_1") {
			$ADDRESS->setAktiv($adr_id_arr[$acc_m],1);
		}
		//deactivate adr
		if ($set=="aktiv_0") {
			$ADDRESS->setAktiv($adr_id_arr[$acc_m],0);
		}
		//set status
		if ($set=="set_status") {
			$ADDRESS->setStatus($adr_id_arr[$acc_m],$status_multi);
		}
		//copy adr to selected grps
		if ($set=="copy_grp") {
			//get old groups
			$adr_groups=$ADDRESS->getGroupID(0,$adr_id_arr[$acc_m],0);
			//set new groups
			$ADDRESS->setGroup($adr_id_arr[$acc_m],$adr_grp_id_multi,$adr_groups,1);//set groups, merge=1=merge groups
		}
		//move adr to selected grps
		if ($set=="move_grp") {
			//set new groups
			$ADDRESS->setGroup($adr_id_arr[$acc_m],$adr_grp_id_multi,0);//merge=0=move
		}
		//delete adr ref from selected grps
		if ($set=="delete_grp") {
			//get old groups
			$adr_groups=$ADDRESS->getGroupID(0,$adr_id_arr[$acc_m],0);
			//set new groups
			$ADDRESS->setGroup($adr_id_arr[$acc_m],$adr_grp_id_multi,$adr_groups,2);//set groups, merge=2=diff
		}
		//delete history
		if ($set=="delete_history") {
			$QUEUE->clearH(Array("adr_id"=>$adr_id_arr[$acc_m]));
		}

	}
}

//muss nach blacklisting kommen!!! wegen getAdr abfrage in blacklist, siehe oben
if ($set=="delete") {// && $status!="delete_all"
	if (!DEMO) $ADDRESS->cleanAdr($search);
	if ($status==0) $_MAIN_MESSAGE.="<br>".sprintf(___("%s Einträge aus der Gruppe %s wurden gelöscht."),"<b>".$ac."</b>","<b>".$GRP[0]['name']."</b>");
	if ($status>0) $_MAIN_MESSAGE.="<br>".sprintf(___("%s Einträge aus der Gruppe %s mit dem Status %s wurden gelöscht."),"<b>".$ac."</b>","<b>".$GRP[0]['name']."</b>","<b>".$STATUS['adr']['status'][$search['status']]."</b>");
}



//uebersicht anzeigen!
	//adr_grp_id
	$_MAIN_OUTPUT.="<br><b>".___("Übersicht").":</b><br><br>";
	$AG=$ADDRESS->getGroup();
	$agc=count($AG);
	for ($agcc=0;$agcc<$agc;$agcc++) {
	
		$showGroupUrlPara->addParam("adr_grp_id",$AG[$agcc]['id']);
		$showGroupStatusUrlPara->addParam("adr_grp_id",$AG[$agcc]['id']);

		$showGroupUrlPara_=$showGroupUrlPara->getAllParams();
		
		$_MAIN_OUTPUT.= "<a  href=\"javascript:switchSection('g_".$AG[$agcc]['id']."')\" title=\"".___("Details")."\">";
		$_MAIN_OUTPUT.=tm_icon("add.png",___("Details"));
		$_MAIN_OUTPUT.="&nbsp;'<b>".$AG[$agcc]['name']."</b>'</a>&nbsp;&nbsp;";
		//Gesamtstatus, anzahl per adr-status
		$ac=$ADDRESS->countADR($AG[$agcc]['id']);
		$_MAIN_OUTPUT.=sprintf(___("%s Adressen"),"<b>".$ac."</b>");
		$_MAIN_OUTPUT.= "<a href=\"".$tm_URL."/".$showGroupUrlPara_."\" title=\"".___("Adressen anzeigen")."\">".tm_icon("eye.png",___("Adressen anzeigen"))."</a>";
		$_MAIN_OUTPUT.="<div id=\"g_".$AG[$agcc]['id']."\" style=\"border:1px dashed #eeeeee; -moz-border-radius:2em 2em 2em 2em; padding:8px;\">";
		//per adr status:
		$asc=count($STATUS['adr']['status']);
		for ($ascc=1; $ascc<=$asc; $ascc++) {
			$showGroupStatusUrlPara->addParam("s_status",$ascc);
			$showGroupStatusUrlPara_=$showGroupStatusUrlPara->getAllParams();
			unset($search);
			$search['status']=$ascc;
			$ac=$ADDRESS->countADR($AG[$agcc]['id'],$search);
			if ($ac>0) {
				$_MAIN_OUTPUT.="<b>".$ac."</b>".
								"&nbsp;".tm_icon($STATUS['adr']['statimg'][$ascc],$STATUS['adr']['status'][$ascc]).
								"&nbsp;".$STATUS['adr']['status'][$ascc].
								"&nbsp;(".$STATUS['adr']['descr'][$ascc].")";
				$_MAIN_OUTPUT.= "<a href=\"".$tm_URL."/".$showGroupStatusUrlPara_."\" title=\"".___("Adressen anzeigen")."\">".tm_icon("eye.png",___("Adressen anzeigen"))."</a>";
				$_MAIN_OUTPUT.= "<br>";
			}
		}
		$_MAIN_OUTPUT.="</div>";
		$_MAIN_OUTPUT.= "<script type=\"text/javascript\">switchSection('g_".$AG[$agcc]['id']."');</script>";
		$_MAIN_OUTPUT.="<br>";

	}
$_MAIN_OUTPUT.="<br>";
include_once (TM_INCLUDEPATH."/adr_clean_form.inc.php");
?>