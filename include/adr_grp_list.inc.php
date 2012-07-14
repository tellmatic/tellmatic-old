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

$_MAIN_DESCR=___("Adressgruppen verwalten");
$_MAIN_MESSAGE.="";

$ADDRESS=new tm_ADR();

$adr_grp_id=getVar("adr_grp_id");
$set=getVar("set");
$val=getVar("val");
$doit=getVar("doit");//wird per js an url angefuegt!!! confirm()

if ($set=="aktiv") {
	$ADDRESS->setGRPAktiv($adr_grp_id,$val);
	if ($val==1) {
		$_MAIN_MESSAGE.="<br>".___("Eintrag wurde aktiviert.");
	} else  {
		$_MAIN_MESSAGE.="<br>".___("Eintrag wurde de-aktiviert.");
	}
}
if ($set=="standard") {
	$ADDRESS->setGRPStd($adr_grp_id,$val);
	$_MAIN_MESSAGE.="<br>".___("Neue Standardgruppe wurde definiert.");
}
if ($set=="delete" && $doit==1) {
	if (!DEMO) $ADDRESS->delGRP($adr_grp_id,1,0);
	$_MAIN_MESSAGE.="<br>".___("Eintrag wurde gelöscht.");
}
if ($set=="deleteall" && $doit==1) {
	if (!DEMO) $ADDRESS->delGRP($adr_grp_id,0,1);
	$_MAIN_MESSAGE.="<br>".___("Eintrag und die zugeordneten Adressen wurden gelöscht.");
}
$GRP=$ADDRESS->getGroup(0,0,0,1);

//sort array:
	$sortIndex=getVar("si");
if (empty($sortIndex)) {
	$sortIndex="id";
}
$sortType=getVar("st");
if (empty($sortType)) {
	$sortType="0";//asc
}
$GRP=sort_array($GRP,$sortIndex,$sortType);

//count entries:
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

$sortURLPara=$mSTDURL;
$sortURLPara->addParam("act","adr_grp_list");
$sortURLPara_=$sortURLPara->getAllParams();

$_MAIN_OUTPUT="<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" width=\"100%\">";
$_MAIN_OUTPUT.= "<thead>".
						"<tr>".
						"<td><b>ID</b>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=id&amp;st=0\">".$img_arrowup."</a>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=id&amp;st=1\">".$img_arrowdown."</a>".
						"</td>".
						"<td><b>".___("Name")."</b>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=name&amp;st=0\">".$img_arrowup."</a>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=name&amp;st=1\">".$img_arrowdown."</a>".
						"</td>".
						"<td><b>".___("Name (öffentlich)")."</b>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=public_name&amp;st=0\">".$img_arrowup."</a>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=public_name&amp;st=1\">".$img_arrowdown."</a>".
						"</td>".
						"<td><b>".___("Beschreibung")."</b>".
						"</td>".
						"<td><b>".___("Adressen")."</b>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=adr_count&amp;st=0\">".$img_arrowup."</a>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=adr_count&amp;st=1\">".$img_arrowdown."</a>".
						"</td>".
						"<td><b>".___("Aktiv")."</b>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=aktiv&amp;st=0\">".$img_arrowup."</a>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=aktiv&amp;st=1\">".$img_arrowdown."</a>".
						"</td>".
						"<td>...</td>".
						"</tr>".
						"</thead>".
						"<tbody>";

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
	$_MAIN_OUTPUT.=  $GRP[$accg]['id'];
	if ($GRP[$accg]['standard']==1) {
		$_MAIN_OUTPUT.= "&nbsp;".tm_icon("page_white_lightning.png",___("Diese Gruppe ist die Standardgruppe"));
	}
	if ($GRP[$accg]['public']==1) {
		$_MAIN_OUTPUT.= "&nbsp;".tm_icon("cup.png",___("Diese Gruppe ist die öffentlich"));
	}
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td onmousemove=\"showToolTip('tt_adr_grp_list_".$GRP[$accg]['id']."')\" onmouseout=\"hideToolTip();\">";
	$_MAIN_OUTPUT.= "<a href=\"".$tm_URL."/".$editURLPara_."\"  title=\"".___("Adressgruppe bearbeiten")."\">".display($GRP[$accg]['name'])."</a>";
	$_MAIN_OUTPUT.= "<div id=\"tt_adr_grp_list_".$GRP[$accg]['id']."\" class=\"tooltip\">";
	$_MAIN_OUTPUT.="<b>".display($GRP[$accg]['name'])."</b>";
	if ($GRP[$accg]['public']==1) {
		$_MAIN_OUTPUT.= "<br>".tm_icon("cup.png",___("Diese Gruppe ist die öffentlich"))."&nbsp;".___("Diese Gruppe ist die öffentlich");
		$_MAIN_OUTPUT.="<br>".___("Name (öffentlich)").": <b>".display($GRP[$accg]['name'])."</b>";
	}
	$_MAIN_OUTPUT.= "<br><font size=\"-1\">".display($GRP[$accg]['descr'])."</font>";
	$_MAIN_OUTPUT.= "<br>ID: ".$GRP[$accg]['id']." ";
	if ($GRP[$accg]['aktiv']==1) {
		$_MAIN_OUTPUT.=  "<br>".tm_icon("tick.png",___("Aktiv"))."&nbsp;";
		$_MAIN_OUTPUT.=  ___("(aktiv)");
	} else {
		$_MAIN_OUTPUT.=  "<br>".tm_icon("cancel.png",___("Inaktiv"))."&nbsp;";
		$_MAIN_OUTPUT.=  ___("(inaktiv)");
	}
	//wenn standardgruppe, dann icon anzeigen
	if ($GRP[$accg]['standard']==1) {
		$_MAIN_OUTPUT.=  "<br>".tm_icon("page_white_lightning.png",___("Diese Gruppe ist die Standardgruppe"))."&nbsp;".___("Standardgruppe");
	}
	$_MAIN_OUTPUT.="<br>".sprintf(___("%s Adressen"),$GRP[$accg]['adr_count']).
									"<br>".sprintf(___("Erstellt am: %s von %s"),$GRP[$accg]['created'],$GRP[$accg]['author']).
									"<br>".sprintf(___("Bearbeitet am: %s von %s"),$GRP[$accg]['updated'],$GRP[$accg]['editor']).
									"";

	$_MAIN_OUTPUT.= "</div>";
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= display($GRP[$accg]['public_name']);
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= display($GRP[$accg]['descr']);
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= display($GRP[$accg]['adr_count']);
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	//wenn gruppe keine standardgruppe ist, dann link zum deaktivieren, deaktivierete gruppen koennen naemlich keine standardgruppe sein
	if ($GRP[$accg]['standard']!=1) {
		$_MAIN_OUTPUT.= "<a href=\"".$tm_URL."/".$aktivURLPara_."\" title=\"".___("aktivieren/de-aktivieren")."\">";
	}
	if ($GRP[$accg]['aktiv']==1) {
		//aktiv
		$_MAIN_OUTPUT.=  tm_icon("tick.png",___("Aktiv"))."&nbsp;";
	} else {
		//inaktiv
		$_MAIN_OUTPUT.=  tm_icon("cancel.png",___("Inaktiv"))."&nbsp;";
	}
	//link schliessen
	if ($GRP[$accg]['standard']!=1) {
		$_MAIN_OUTPUT.= "</a>";
	}
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$tm_URL."/".$editURLPara_."\" title=\"".___("Adressgruppe bearbeiten")."\">".tm_icon("pencil.png",___("Adressgruppe bearbeiten"))."</a>";
	$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$tm_URL."/".$addadrURLPara_."\" title=\"".___("Neue Adresse in dieser Gruppe anlegen")."\">".tm_icon("vcard_add.png",___("Neue Adresse in dieser Gruppe anlegen"))."</a>";
	$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$tm_URL."/".$showadrURLPara_."\" title=\"".___("Alle Adressen in dieser Gruppe anzeigen")."\">".tm_icon("group_go.png",___("Alle Adressen in dieser Gruppe anzeigen"))."</a>";;
	#."&nbsp;".$GRP[$accg]['adr_count']."</a>";
	$_MAIN_OUTPUT.=  "&nbsp;<a href=\"".$tm_URL."/".$statURLPara_."\" title=\"".___("Statistik anzeigen")."\">".tm_icon("chart_pie.png",___("Statistik anzeigen"))."</a>";
	if ($GRP[$accg]['standard']==1) {
		//wenn gruppe standard ist, dann bildchen anzeigen, wird auch neben id angezeigt
		//$_MAIN_OUTPUT.=  "&nbsp;<img src=\"".$tm_iconURL."/page_white_lightning.png\" border=\"0\">";
	} else {
		//wenn gruppe aktiv ist, dann darf man sie als standard definieren
		if ($GRP[$accg]['aktiv']==1) {
			$_MAIN_OUTPUT.=  "&nbsp;<a href=\"".$tm_URL."/".$stdURLPara_."\" onclick=\"return confirmLink(this, '".sprintf(___("Adressgruppe %s als Standard definieren."),display($GRP[$accg]['name']))."')\" title=\"".___("Diese Adressgruppe als Standardgruppe")."\">".tm_icon("page_white_go.png",___("Diese Adressgruppe als Standardgruppe"))."</a>";
		}
		//loeschen
		$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$tm_URL."/".$delURLPara_."\" onclick=\"return confirmLink(this, '".sprintf(___("Adressgruppe %s löschen und Adressen dieser Gruppe der Standardgruppe zuordnen und Verknüpfungen zu Formularen aufheben?"),display($GRP[$accg]['name']))."')\" title=\"".___("Adressgruppe löschen")."\">".tm_icon("cross.png",___("Adressgruppe löschen"))."</a>";
		//bomb! gruppe UND Adressen loeschen!!!
		$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$tm_URL."/".$delallURLPara_."\" onclick=\"return confirmLink(this, '".sprintf(___("Adressgruppe %s UND Adressen dieser Gruppe löschen?"),display($GRP[$accg]['name']))."')\" title=\"".___("Adressgruppe und Adressen löschen")."\">".tm_icon("bomb.png",___("Adressgruppe und Adressen löschen"))."</a>";

	}
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "</tr>";
}

$_MAIN_OUTPUT.= "</tbody></table>";

include(TM_INCLUDEPATH."/adr_grp_list_legende.inc.php");
?>