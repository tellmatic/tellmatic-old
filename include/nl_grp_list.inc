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

$_MAIN_DESCR="Newslettergruppen verwalten";
$_MAIN_MESSAGE.="";

$NEWSLETTER=new mnlNL();

$nl_grp_id=getVar("nl_grp_id");
$set=getVar("set");
$val=getVar("val");
$doit=getVar("doit");//wird per js an url angefuegt!!! confirm()

if ($set=="aktiv") {
	$NEWSLETTER->setGRPAktiv($nl_grp_id,$val);
	if ($val==1) { 
		$_MAIN_MESSAGE.="<br>Eintrag wurde aktiviert.";
	} else  {
		$_MAIN_MESSAGE.="<br>Eintrag wurde de-aktiviert.";
	}
}
if ($set=="standard") {
	$NEWSLETTER->setGRPStd($nl_grp_id,$val);
	$_MAIN_MESSAGE.="<br>Neue Standardgruppe wurde definiert.";
}
if ($set=="delete" && $doit==1) {
	$NEWSLETTER->delGRP($nl_grp_id);
	$_MAIN_MESSAGE.="<br>Eintrag wurde geloescht.";
}


$GRP=$NEWSLETTER->getGroup(0,0,1);
$ncg=count($GRP);

$editURLPara=$mSTDURL;
$editURLPara->addParam("act","nl_grp_edit");

$shownlURLPara=$mSTDURL;
$shownlURLPara->addParam("act","nl_list");

$addnlURLPara=$mSTDURL;
$addnlURLPara->addParam("act","nl_new");

$aktivURLPara=$mSTDURL;
$aktivURLPara->addParam("act","nl_grp_list");
$aktivURLPara->addParam("set","aktiv");

$delURLPara=$mSTDURL;
$delURLPara->addParam("act","nl_grp_list");
$delURLPara->addParam("set","delete");

$stdURLPara=$mSTDURL;
$stdURLPara->addParam("act","nl_grp_list");
$stdURLPara->addParam("set","standard");

$statURLPara=$mSTDURL;
$statURLPara->addParam("act","statistic");
$statURLPara->addParam("set","nlg");

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

for ($nccg=0;$nccg<$ncg;$nccg++) {
	if ($nccg%2==0) {$bgcolor=$row_bgcolor;} else {$bgcolor=$row_bgcolor2;}
	if ($GRP[$nccg]['aktiv']!=1) {
		$bgcolor=$row_bgcolor_inactive;
		$new_aktiv=1;
	} else {
		$new_aktiv=0;
	}

	$editURLPara->addParam("nl_grp_id",$GRP[$nccg]['id']);
	$editURLPara_=$editURLPara->getAllParams();

	$shownlURLPara->addParam("nl_grp_id",$GRP[$nccg]['id']);
	$shownlURLPara_=$shownlURLPara->getAllParams();

	$addnlURLPara->addParam("nl_grp_id",$GRP[$nccg]['id']);
	$addnlURLPara_=$addnlURLPara->getAllParams();

	$aktivURLPara->addParam("nl_grp_id",$GRP[$nccg]['id']);
	$aktivURLPara->addParam("val",$new_aktiv);
	$aktivURLPara_=$aktivURLPara->getAllParams();

	$delURLPara->addParam("nl_grp_id",$GRP[$nccg]['id']);
	$delURLPara_=$delURLPara->getAllParams();

	$stdURLPara->addParam("nl_grp_id",$GRP[$nccg]['id']);
	$stdURLPara_=$stdURLPara->getAllParams();

	$statURLPara->addParam("nl_grp_id",$GRP[$nccg]['id']);
	$statURLPara_=$statURLPara->getAllParams();

	$_MAIN_OUTPUT.= "<tr id=\"row_".$nccg."\" bgcolor=\"".$bgcolor."\" onmouseover=\"setBGColor('row_".$nccg."','".$row_bgcolor_hilite."');\" onmouseout=\"setBGColor('row_".$nccg."','".$bgcolor."');\">";
	$_MAIN_OUTPUT.= "<td onmousemove=\"showToolTip('tt_adr_grp_list_".$GRP[$nccg]['id']."')\" onmouseout=\"hideToolTip();\">";
/*
	$_MAIN_OUTPUT.= $GRP[$nccg]['id'];
*/
	//wenn standardgruppe, dann icon anzeigen
	if ($GRP[$nccg]['standard']==1) {
		$_MAIN_OUTPUT.=  "&nbsp;<img src=\"".$mnl_iconURL."/page_white_lightning.png\" titlt=\"Diese Gruppe ist die Standardgruppe\" border=\"0\">";
	}
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td onmousemove=\"showToolTip('tt_adr_grp_list_".$GRP[$nccg]['id']."')\" onmouseout=\"hideToolTip();\">";
	$_MAIN_OUTPUT.= "<a href=\"".$mnl_URL."/".$editURLPara_."\" title=\"Newslettergruppe bearbeiten\">".$GRP[$nccg]['name']."</a>";
	$_MAIN_OUTPUT.= "<div id=\"tt_adr_grp_list_".$GRP[$nccg]['id']."\" class=\"tooltip\">";
	$_MAIN_OUTPUT.= "ID: ".$GRP[$nccg]['id']." ";
	if ($GRP[$nccg]['aktiv']==1) {
		$_MAIN_OUTPUT.=  "<img src=\"".$mnl_iconURL."/tick.png\" border=\"0\">";
		$_MAIN_OUTPUT.=  "(aktiv)";
	} else {
		$_MAIN_OUTPUT.=  "<img src=\"".$mnl_iconURL."/cancel.png\" border=\"0\">";
		$_MAIN_OUTPUT.=  "(inaktiv)";
	}
	//wenn standardgruppe, dann icon anzeigen
	if ($GRP[$nccg]['standard']==1) {
		$_MAIN_OUTPUT.=  "<br><img src=\"".$mnl_iconURL."/page_white_lightning.png\" title=\"Diese Gruppe ist die Standardgruppe\" alt=\"Diese Gruppe ist die Standardgruppe\" border=\"0\">Standardgruppe!";
	}
	$_MAIN_OUTPUT.="<br><b>".$GRP[$nccg]['name']."</b><br>";
	$_MAIN_OUTPUT.=$GRP[$nccg]['nl_count']." Newsletter<br>";
	$_MAIN_OUTPUT.= "<font size=\"-1\">".$GRP[$nccg]['descr']."</font>";
	$_MAIN_OUTPUT.= "</div>";
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= $GRP[$nccg]['descr'];
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	//wenn gruppe keine standardgruppe ist, dann link zum deaktivieren, deaktivierete gruppen koennen naemlich keine standardgruppe sein
	if ($GRP[$nccg]['standard']!=1) {
		$_MAIN_OUTPUT.= "<a href=\"".$mnl_URL."/".$aktivURLPara_."\" title=\"aktivieren/de-aktivieren\">";
	}
	if ($GRP[$nccg]['aktiv']==1) {
		//aktiv
		$_MAIN_OUTPUT.=  "<img src=\"".$mnl_iconURL."/tick.png\" border=\"0\">";
	} else {
		//inaktiv
		$_MAIN_OUTPUT.=  "<img src=\"".$mnl_iconURL."/cancel.png\" border=\"0\">";
	}
	//link schliessen
	if ($GRP[$nccg]['standard']!=1) {
		$_MAIN_OUTPUT.= "</a>";
	}
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= "<a href=\"".$mnl_URL."/".$editURLPara_."\" title=\"Newslettergruppe bearbeiten\"><img src=\"".$mnl_iconURL."/pencil.png\" border=\"0\"></a>";
	$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$mnl_URL."/".$addnlURLPara_."\" title=\"neuen Newsletter in dieser Gruppe erstellen\"><img src=\"".$mnl_iconURL."/newspaper_add.png\" border=\"0\"></a>";	
	$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$mnl_URL."/".$shownlURLPara_."\" title=\"alle Newsletter in dieser Gruppe anzeigen\"><img src=\"".$mnl_iconURL."/newspaper_go.png\" border=\"0\">&nbsp;".$GRP[$nccg]['nl_count']."</a>";
	//$_MAIN_OUTPUT.=  "&nbsp;<a href=\"".$mnl_URL."/".$statURLPara_."\" title=\"Statistik anzeigen\"><img src=\"".$mnl_iconURL."/chart_pie.png\" border=\"0\"></a>";
	if ($GRP[$nccg]['standard']==1) {
		//wenn gruppe standard ist, dann bildchen anzeigen, wird auch neben id angezeigt
		//$_MAIN_OUTPUT.=  "&nbsp;<img src=\"".$mnl_iconURL."/page_white_lightning.png\" border=\"0\">";
	} else {
		//wenn gruppe aktiv ist, dann darf man sie als standard definieren
		if ($GRP[$nccg]['aktiv']==1) {
			$_MAIN_OUTPUT.=  "&nbsp;<a href=\"".$mnl_URL."/".$stdURLPara_."\" onclick=\"return confirmLink(this, 'Newslettergruppe ".$GRP[$nccg]['name']." als Standard definieren')\" title=\"Diese Newslettergruppe als Standardgruppe\"><img src=\"".$mnl_iconURL."/page_white_go.png\" border=\"0\"></a>";
		}
		//loeschen
		$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$mnl_URL."/".$delURLPara_."\" onclick=\"return confirmLink(this, 'Newslettergruppe ".$GRP[$nccg]['name']." loeschen und Newsletter dieser Gruppe der Standardgruppe zuordnen?')\" title=\"Newslettergruppe loeschen\"><img src=\"".$mnl_iconURL."/cross.png\" border=\"0\"></a>";
	}
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "</tr>";
}

$_MAIN_OUTPUT.= "</tbody></table>";

include($mnl_includepath."/nl_grp_list_legende.inc");
?>