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

$_MAIN_DESCR=___("Adressen verwalten");
$_MAIN_MESSAGE.="";

if (!isset($offset)) {
	$offset=getVar("offset");
}
if (empty($offset) || $offset<0) {
	$offset=0;
}
if (!isset($limit)) {
	$limit=getVar("limit");
}
if (empty($limit)) {
	$limit=25;
}

//sort und sorttype nach search verschoben

$ADDRESS=new tm_ADR();
$QUEUE=new tm_Q();

$adr_grp_id=getVar("adr_grp_id");

$adr_id=getVar("adr_id");
$set=getVar("set");
$val=getVar("val");
$doit=getVar("doit");//wird per js an url angefuegt!!! confirm()
if (!isset($search)) {
	$search=Array();
}

require_once ($tm_includepath."/adr_search.inc.php");



if ($set=="aktiv") {
	$ADDRESS->setAktiv($adr_id,$val);
	if ($val==1) {
		$_MAIN_MESSAGE.="<br>".___("Eintrag wurde aktiviert.");
	} else  {
		$_MAIN_MESSAGE.="<br>".___("Eintrag wurde de-aktiviert.");
	}
}
if ($set=="delete" && $doit==1) {
	if (!DEMO) $ADDRESS->delAdr($adr_id);
	$_MAIN_MESSAGE.="<br>".___("Eintrag wurde gelöscht.");
}


if ($adr_grp_id>0)
{
	$ADR=$ADDRESS->getAdr(0,$offset,$limit,$adr_grp_id,$search,$sortIndex,$sortType);//id,offset,limit,group,$search_array
	$adr_grp=$ADDRESS->getGroup($adr_grp_id);
	$_MAIN_MESSAGE.="<br>".sprintf(___("gewählte Gruppe: %s"),"<b>".display($adr_grp[0]['name'])."</b>");
} else {
	$ADR=$ADDRESS->getAdr(0,$offset,$limit,0,$search,$sortIndex,$sortType);//id,offset,limit,group,$search_array
}
#print_r($search);
$ac=count($ADR);
$entrys=$ac; // fuer pager.inc!!!
$entrys_total=$ADDRESS->countADR($adr_grp_id,$search);
//wir sortieren ueber die db, sortIndex und Type werden uebergeben an get ADR
//damit die sortierung auch mit limits klappt.... sonst werden nur die gezeigten eintraege im array sortiert, nichjt aber die geamte adressliste in der db... etc
//sortierung ueber array:
//$ADR=sort_array($ADR,$sortIndex,$sortType);


//globale parameter die angefuegt werden sollen!
$mSTDURL->addParam("offset",$offset);
$mSTDURL->addParam("limit",$limit);
#$mSTDURL->addParam("st",$sortType);
#$mSTDURL->addParam("si",$sortIndex);
if (isset($s_email)) {
	$mSTDURL->addParam("s_email",$s_email);
}
if (isset($s_author)) {
	$mSTDURL->addParam("s_author",$s_author);
}
if (isset($f0_9)) {
	$mSTDURL->addParam("f0_9",$f0_9);
}
if (isset($s_status)) {
	$mSTDURL->addParam("s_status",$s_status);
}
$mSTDURL->addParam("adr_grp_id",$adr_grp_id);
if ($set=="search") {
	$mSTDURL->addParam("set",$set);
}

$mSTDURL->addParam("st",$sortType);
$mSTDURL->addParam("si",$sortIndex);

$firstURLPara=$mSTDURL;
$firstURLPara->addParam("act","adr_list");
$firstURLPara_=$firstURLPara->getAllParams();

$nextURLPara=$mSTDURL;
$nextURLPara->addParam("adr_grp_id",$adr_grp_id);
//neuer offset!
$nextURLPara->addParam("offset",($offset+$limit));
$nextURLPara->addParam("act","adr_list");
$nextURLPara_=$nextURLPara->getAllParams();

$prevURLPara=$mSTDURL;
$prevURLPara->addParam("adr_grp_id",$adr_grp_id);
//neuer offset!
$prevURLPara->addParam("offset",($offset-$limit));
$prevURLPara->addParam("act","adr_list");
$prevURLPara_=$prevURLPara->getAllParams();

$sortURLPara=$mSTDURL;
$sortURLPara->addParam("act","adr_list");
$sortURLPara_=$sortURLPara->getAllParams();

$editURLPara=$mSTDURL;
$editURLPara->addParam("adr_id",$adr_id);
$editURLPara->addParam("act","adr_edit");

$aktivURLPara=$mSTDURL;
$aktivURLPara->addParam("adr_grp_id",$adr_grp_id);
$aktivURLPara->addParam("offset",$offset);
$aktivURLPara->addParam("limit",$limit);
$aktivURLPara->addParam("act","adr_list");
$aktivURLPara->addParam("set","aktiv");

$delURLPara=$mSTDURL;
$delURLPara->addParam("adr_grp_id",$adr_grp_id);
$delURLPara->addParam("offset",$offset);
$delURLPara->addParam("limit",$limit);
$delURLPara->addParam("act","adr_list");
$delURLPara->addParam("set","delete");

$statURLPara=$mSTDURL;
$statURLPara->addParam("act","statistic");
$statURLPara->addParam("set","adr");

include($tm_includepath."/pager.inc.php");

$_MAIN_OUTPUT.="<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" width=\"100%\">";
$_MAIN_OUTPUT.= "<thead>".
						"<tr>".
						"<td><b>".___("E-Mail")."</b>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=email&amp;st=0\">".$img_arrowup."</a>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=email&amp;st=1\">".$img_arrowdown."</a>".
						"</td>".
						"<td>&nbsp;".
						"</td>".
						"<td><b>".___("Status")."</b>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=status&amp;st=0\">".$img_arrowup."</a>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=status&amp;st=1\">".$img_arrowdown."</a>".
						"</td>".
						"<td>".___("Gruppen")."</td>".
						"<td><b>".___("Aktiv")."</b>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=aktiv&amp;st=0\">".$img_arrowup."</a>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=aktiv&amp;st=1\">".$img_arrowdown."</a>".
						"</td>".
						"<td>...</td>".
						"</tr>".
						"</thead>".
						"<tbody>";


for ($acc=0;$acc<$ac;$acc++) {
	if ($acc%2==0) {$bgcolor=$row_bgcolor;} else {$bgcolor=$row_bgcolor2;}
	if ($ADR[$acc]['aktiv']!=1) {
		$bgcolor=$row_bgcolor_inactive;
		$new_aktiv=1;
	} else {
		$new_aktiv=0;
	}

	$created_date=$ADR[$acc]['created'];
	$updated_date=$ADR[$acc]['updated'];

	$author=$ADR[$acc]['author'];
	$editor=$ADR[$acc]['editor'];

	if (is_numeric($author)) {
		$author="Form_".$author;
	}
	if (is_numeric($editor)) {
		$editor="Form_".$editor;
	}

	$nlc=$QUEUE->countH(0,0,0,$ADR[$acc]['id'],0);

	$editURLPara->addParam("adr_id",$ADR[$acc]['id']);
	$editURLPara->addParam("adr_d_id",$ADR[$acc]['d_id']);
	$editURLPara_=$editURLPara->getAllParams();

	$aktivURLPara->addParam("adr_id",$ADR[$acc]['id']);
	$aktivURLPara->addParam("val",$new_aktiv);
	$aktivURLPara_=$aktivURLPara->getAllParams();

	$delURLPara->addParam("adr_id",$ADR[$acc]['id']);
	$delURLPara_=$delURLPara->getAllParams();

	$statURLPara->addParam("adr_id",$ADR[$acc]['id']);
	$statURLPara_=$statURLPara->getAllParams();

	$row_bgcolor_hilite;

	$_MAIN_OUTPUT.= "<tr id=\"row_".$acc."\" bgcolor=\"".$bgcolor."\" onmouseover=\"setBGColor('row_".$acc."','".$row_bgcolor_hilite."');\" onmouseout=\"setBGColor('row_".$acc."','".$bgcolor."');\">";

	$_MAIN_OUTPUT.= "<td onmousemove=\"showToolTip('tt_adr_list_".$ADR[$acc]['id']."')\" onmouseout=\"setBGColor('row_".$acc."','".$bgcolor."');hideToolTip();\">";
	$_MAIN_OUTPUT.= "<a href=\"".$tm_URL."/".$editURLPara_."\">".$ADR[$acc]['email']."</a>";
	$_MAIN_OUTPUT.= "<div id=\"tt_adr_list_".$ADR[$acc]['id']."\" class=\"tooltip\">";

	$_MAIN_OUTPUT.= "<b>".$ADR[$acc]['email']."</b>";
	$_MAIN_OUTPUT.= "<br><font size=-1>".$ADR[$acc]['f0'].",&nbsp;".$ADR[$acc]['f1'].",&nbsp;".$ADR[$acc]['f2'].",&nbsp;".$ADR[$acc]['f3'].",&nbsp;".$ADR[$acc]['f4'].",&nbsp;".$ADR[$acc]['f5'].",&nbsp;";
	$_MAIN_OUTPUT.= "<br>".$ADR[$acc]['f6'].",&nbsp;".$ADR[$acc]['f7'].",&nbsp;".$ADR[$acc]['f8'].",&nbsp;".$ADR[$acc]['f9']."</font>";

	$_MAIN_OUTPUT.= "<br>ID: ".$ADR[$acc]['id']." / ".$ADR[$acc]['d_id']." ";
	if ($ADR[$acc]['aktiv']==1) {
		$_MAIN_OUTPUT.=  "<br>".tm_icon("tick.png",___("Aktiv"))."&nbsp;";
		$_MAIN_OUTPUT.=  ___("(aktiv)");
	} else {
		$_MAIN_OUTPUT.=  "<br>".tm_icon("cancel.png",___("Inaktiv"))."&nbsp;";
		$_MAIN_OUTPUT.=  ___("(Inaktiv)");
	}

	$_MAIN_OUTPUT.= "<br>".sprintf(___("Status: %s"),tm_icon($STATUS['adr']['statimg'][$ADR[$acc]['status']],$STATUS['adr']['status'][$ADR[$acc]['status']]));

	$_MAIN_OUTPUT.= "<br>CODE: ".$ADR[$acc]['code']." &nbsp;".
							"<br>".sprintf(___("Erstellt am: %s von %s"),$created_date,$author).
							"<br>".sprintf(___("Bearbeitet am: %s von %s"),$updated_date,$editor).
							"<br>".sprintf(___("Newsletter Aktuell: %s"),$nlc).
							"<br>".sprintf(___("Newsletter Gesamt: %s"),$ADR[$acc]['newsletter']).
							"<br>".sprintf(___("Views: %s"),$ADR[$acc]['views']).
							"<br>".sprintf(___("Clicks: %s"),$ADR[$acc]['clicks']).
							"<br>".sprintf(___("Sendefehler: %s"),$ADR[$acc]['errors']).
							"<br>".___("Memo:")."<font size=\"-1\">".$ADR[$acc]['memo']."</font>";
	$_MAIN_OUTPUT.= "<br>".___("Mitglied in den Gruppen:");
	$_MAIN_OUTPUT.= "<ul>";
	$GRP=$ADDRESS->getGroup(0,$ADR[$acc]['id']);
	$acg=count($GRP);
	for ($accg=0;$accg<$acg;$accg++) {
		$_MAIN_OUTPUT.= "<li>".$GRP[$accg]['name']."</li>";
	}
	$_MAIN_OUTPUT.= "</ul>";

	$_MAIN_OUTPUT.= "</div>";
	$_MAIN_OUTPUT.= "</td>";

	$_MAIN_OUTPUT.= "<td bgcolor=\"".$STATUS['adr']['color'][$ADR[$acc]['status']]."\">&nbsp;";
	$_MAIN_OUTPUT.= "</td>";

	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= tm_icon($STATUS['adr']['statimg'][$ADR[$acc]['status']],$STATUS['adr']['descr'][$ADR[$acc]['status']])."&nbsp;".$STATUS['adr']['status'][$ADR[$acc]['status']];
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	for ($accg=0;$accg<$acg;$accg++) {
		$_MAIN_OUTPUT.= "".$GRP[$accg]['name'].", ";
	}
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= "<a href=\"".$tm_URL."/".$aktivURLPara_."\" title=\"".___("aktivieren/de-aktivieren")."\">";
	if ($ADR[$acc]['aktiv']==1) {
		$_MAIN_OUTPUT.=  tm_icon("tick.png",___("Aktiv"))."&nbsp;";
	} else {
		$_MAIN_OUTPUT.=  tm_icon("cancel.png",___("Inaktiv"))."&nbsp;";
	}
	$_MAIN_OUTPUT.= "</a>";
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= "<a href=\"".$tm_URL."/".$editURLPara_."\" title=\"".___("Adresse bearbeiten")."\">".tm_icon("pencil.png",___("Adresse bearbeiten"))."</a>";
	$_MAIN_OUTPUT.=  "&nbsp;<a href=\"".$tm_URL."/".$statURLPara_."\" title=\"".___("Statistik anzeigen")."\">".tm_icon("chart_pie.png",___("Statistik anzeigen"))."</a>";
	$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$tm_URL."/".$delURLPara_."\" onclick=\"return confirmLink(this, '".___("Adresse löschen")."')\" title=\"".___("Adresse löschen")."\">".tm_icon("cross.png",___("Adresse löschen"))."</a>";
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "</tr>";
}

$_MAIN_OUTPUT.= "</tbody></table>";

include($tm_includepath."/pager.inc.php");
require_once($tm_includepath."/adr_list_legende.inc.php");
?>