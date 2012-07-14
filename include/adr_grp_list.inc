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

$_MAIN_DESCR="Adressgruppen verwalten";
$_MAIN_MESSAGE.="";

$ADDRESS=new mnlADR();

$adr_grp_id=getVar("adr_grp_id");
$set=getVar("set");
$val=getVar("val");
$doit=getVar("doit");//wird per js an url angefuegt!!! confirm()

if ($set=="aktiv") {
	$ADDRESS->setGRPAktiv($adr_grp_id,$val);
	if ($val==1) { 
		$_MAIN_MESSAGE.="<br>Eintrag wurde aktiviert.";
	} else  {
		$_MAIN_MESSAGE.="<br>Eintrag wurde de-aktiviert.";
	}
}
if ($set=="standard") {
	$ADDRESS->setGRPStd($adr_grp_id,$val);
	$_MAIN_MESSAGE.="<br>Neue Standardgruppe wurde definiert.";
}
if ($set=="delete" && $doit==1) {
	$ADDRESS->delGRP($adr_grp_id,1,0);
	$_MAIN_MESSAGE.="<br>Eintrag wurde geloescht.";
}
if ($set=="deleteall" && $doit==1) {
	$ADDRESS->delGRP($adr_grp_id,0,1);
	$_MAIN_MESSAGE.="<br>Eintrag und die zugeordneten Adressen wurden geloescht.";
}
$GRP=$ADDRESS->getGroup(0,0,0,1);
$acg=count($GRP);

$editURLPara=$mSTDURL;
$editURLPara->addParam("act","adr_grp_edit");

$addadrURLPara=$mSTDURL;
$addadrURLPara->addParam("act","adr_new");

$showadrURLPara=$mSTDURL;
$showadrURLPara->addParam("act","adr_list");

$aktivURLPara=$mSTDURL;
$aktivURLPara->addParam("act","adr_grp_list");
$aktivURLPara->addParam("set","aktiv");

$delURLPara=$mSTDURL;
$delURLPara->addParam("act","adr_grp_list");
$delURLPara->addParam("set","delete");

$delallURLPara=$mSTDURL;
$delallURLPara->addParam("act","adr_grp_list");
$delallURLPara->addParam("set","deleteall");

$stdURLPara=$mSTDURL;
$stdURLPara->addParam("act","adr_grp_list");
$stdURLPara->addParam("set","standard");

$statURLPara=$mSTDURL;
$statURLPara->addParam("act","statistic");
$statURLPara->addParam("set","adrg");

$_MAIN_OUTPUT="<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" width=100%>";
$_MAIN_OUTPUT.= "<thead>
						<tr>
						<td><b>&nbsp;</b>
						</td>
						<td><b>Name</b>
						</td>
						<td><b>Beschreibung</b>
						</td>
						<td><b>Aktiv</b>
						</td>
						<td>...</td>
						</tr>
						</thead>
						<tbody>
						";

for ($accg=0;$accg<$acg;$accg++) {
	if ($accg%2==0) {$bgcolor=$row_bgcolor;} else {$bgcolor=$row_bgcolor2;}
	if ($GRP[$accg]['aktiv']!=1) {
		$bgcolor=$row_bgcolor_inactive;
		$new_aktiv=1;
	} else {
		$new_aktiv=0;
	}

	$editURLPara->addParam("adr_grp_id",$GRP[$accg]['id']);
	$editURLPara_=$editURLPara->getAllParams();

	$addadrURLPara->addParam("adr_grp_id",$GRP[$accg]['id']);
	$addadrURLPara_=$addadrURLPara->getAllParams();

	$showadrURLPara->addParam("adr_grp_id",$GRP[$accg]['id']);
	$showadrURLPara_=$showadrURLPara->getAllParams();

	$aktivURLPara->addParam("adr_grp_id",$GRP[$accg]['id']);
	$aktivURLPara->addParam("val",$new_aktiv);
	$aktivURLPara_=$aktivURLPara->getAllParams();

	$delURLPara->addParam("adr_grp_id",$GRP[$accg]['id']);
	$delURLPara_=$delURLPara->getAllParams();

	$delallURLPara->addParam("adr_grp_id",$GRP[$accg]['id']);
	$delallURLPara_=$delallURLPara->getAllParams();

	$stdURLPara->addParam("adr_grp_id",$GRP[$accg]['id']);
	$stdURLPara_=$stdURLPara->getAllParams();

	$statURLPara->addParam("adr_grp_id",$GRP[$accg]['id']);
	$statURLPara_=$statURLPara->getAllParams();

	$_MAIN_OUTPUT.= "<tr id=\"row_".$accg."\"  bgcolor=\"".$bgcolor."\" onmouseover=\"setBGColor('row_".$accg."','".$row_bgcolor_hilite."');\" onmouseout=\"setBGColor('row_".$accg."','".$bgcolor."');\">";
	$_MAIN_OUTPUT.= "<td onmousemove=\"showToolTip('tt_adr_grp_list_".$GRP[$accg]['id']."')\" onmouseout=\"hideToolTip();\">";

	//wenn standardgruppe, dann icon anzeigen
	if ($GRP[$accg]['standard']==1) {
		$_MAIN_OUTPUT.=  "&nbsp;<img src=\"".$mnl_iconURL."/page_white_lightning.png\" title=\"Diese Gruppe ist die Standardgruppe\" alt=\"Diese Gruppe ist die Standardgruppe\" border=\"0\">";
	}
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td onmousemove=\"showToolTip('tt_adr_grp_list_".$GRP[$accg]['id']."')\" onmouseout=\"hideToolTip();\">";
	$_MAIN_OUTPUT.= "<a href=\"".$mnl_URL."/".$editURLPara_."\"  title=\"Adressgruppe bearbeiten\">".$GRP[$accg]['name']."</a>";
	$_MAIN_OUTPUT.= "<div id=\"tt_adr_grp_list_".$GRP[$accg]['id']."\" class=\"tooltip\">";
	$_MAIN_OUTPUT.= "ID: ".$GRP[$accg]['id']." ";
	if ($GRP[$accg]['aktiv']==1) {
		$_MAIN_OUTPUT.=  "<img src=\"".$mnl_iconURL."/tick.png\" border=\"0\">";
		$_MAIN_OUTPUT.=  "(aktiv)";
	} else {
		$_MAIN_OUTPUT.=  "<img src=\"".$mnl_iconURL."/cancel.png\" border=\"0\">";
		$_MAIN_OUTPUT.=  "(inaktiv)";
	}
	//wenn standardgruppe, dann icon anzeigen
	if ($GRP[$accg]['standard']==1) {
		$_MAIN_OUTPUT.=  "<br><img src=\"".$mnl_iconURL."/page_white_lightning.png\" titlt=\"Diese Gruppe ist die Standardgruppe\" border=\"0\">Standardgruppe!";
	}
	$_MAIN_OUTPUT.="<br><b>".$GRP[$accg]['name']."</b><br>";
	$_MAIN_OUTPUT.=$GRP[$accg]['adr_count']." Adressen<br>";
	$_MAIN_OUTPUT.= "<font size=\"-1\">".$GRP[$accg]['descr']."</font>";
	$_MAIN_OUTPUT.= "</div>";
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= $GRP[$accg]['descr'];
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	//wenn gruppe keine standardgruppe ist, dann link zum deaktivieren, deaktivierete gruppen koennen naemlich keine standardgruppe sein
	if ($GRP[$accg]['standard']!=1) {
		$_MAIN_OUTPUT.= "<a href=\"".$mnl_URL."/".$aktivURLPara_."\" title=\"aktivieren/de-aktivieren\">";
	}
	if ($GRP[$accg]['aktiv']==1) {
		//aktiv
		$_MAIN_OUTPUT.=  "<img src=\"".$mnl_iconURL."/tick.png\" border=\"0\">";
	} else {
		//inaktiv
		$_MAIN_OUTPUT.=  "<img src=\"".$mnl_iconURL."/cancel.png\" border=\"0\">";
	}
	//link schliessen
	if ($GRP[$accg]['standard']!=1) {
		$_MAIN_OUTPUT.= "</a>";
	}
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$mnl_URL."/".$editURLPara_."\" title=\"Adressgruppe bearbeiten\"><img src=\"".$mnl_iconURL."/pencil.png\" border=\"0\"></a>";
	$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$mnl_URL."/".$addadrURLPara_."\" title=\"Neue Adresse in dieser Gruppe anlegen\"><img src=\"".$mnl_iconURL."/vcard_add.png\" border=\"0\"></a>";
	$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$mnl_URL."/".$showadrURLPara_."\" title=\"alle Adressen in dieser Gruppe anzeigen\"><img src=\"".$mnl_iconURL."/group_go.png\" border=\"0\">&nbsp;".$GRP[$accg]['adr_count']."</a>";
	$_MAIN_OUTPUT.=  "&nbsp;<a href=\"".$mnl_URL."/".$statURLPara_."\" title=\"Statistik anzeigen\"><img src=\"".$mnl_iconURL."/chart_pie.png\" border=\"0\"></a>";
	if ($GRP[$accg]['standard']==1) {
		//wenn gruppe standard ist, dann bildchen anzeigen, wird auch neben id angezeigt
		//$_MAIN_OUTPUT.=  "&nbsp;<img src=\"".$mnl_iconURL."/page_white_lightning.png\" border=\"0\">";
	} else {
		//wenn gruppe aktiv ist, dann darf man sie als standard definieren
		if ($GRP[$accg]['aktiv']==1) {
			$_MAIN_OUTPUT.=  "&nbsp;<a href=\"".$mnl_URL."/".$stdURLPara_."\" onclick=\"return confirmLink(this, 'Adressgruppe ".$GRP[$accg]['name']." als Standard definieren')\" title=\"Diese Addressgruppe als Standardgruppe\"><img src=\"".$mnl_iconURL."/page_white_go.png\" border=\"0\"></a>";
		}
		//loeschen
		$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$mnl_URL."/".$delURLPara_."\" onclick=\"return confirmLink(this, 'Adressgruppe ".$GRP[$accg]['name']." loeschen und Adressen dieser Gruppe der Standardgruppe zuordnen und Verknuepfungen zu Formularen aufheben?')\" title=\"Addressgruppe loeschen\"><img src=\"".$mnl_iconURL."/cross.png\" border=\"0\"></a>";
		//bomb! gruppe UND Addressen loeschen!!!
		$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$mnl_URL."/".$delallURLPara_."\" onclick=\"return confirmLink(this, 'Adressgruppe ".$GRP[$accg]['name']." UND Addressen dieser Gruppe loeschen?')\" title=\"Addressgruppe und Adressen loeschen\"><img src=\"".$mnl_iconURL."/bomb.png\" border=\"0\"></a>";

	}
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "</tr>";
}

$_MAIN_OUTPUT.= "<tbody></table>";

include($mnl_includepath."/adr_grp_list_legende.inc");
?>