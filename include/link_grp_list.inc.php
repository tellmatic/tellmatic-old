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

$_MAIN_DESCR=___("Linkgruppen verwalten");
$_MAIN_MESSAGE.="";

$LINKS=new tm_LNK();
$lnk_grp_id=getVar("lnk_grp_id");
$set=getVar("set");
$val=getVar("val");
$doit=getVar("doit");//wird per js an url angefuegt!!! confirm()

if ($set=="aktiv") {
	$LINKS->setGRPAktiv($lnk_grp_id,$val);
	if ($val==1) {
		$_MAIN_MESSAGE.="<br>".___("Eintrag wurde aktiviert.");
	} else  {
		$_MAIN_MESSAGE.="<br>".___("Eintrag wurde de-aktiviert.");
	}
}
if ($set=="standard") {
	$LINKS->setGRPStd($lnk_grp_id,$val);
	$_MAIN_MESSAGE.="<br>".___("Neue Standardgruppe wurde definiert.");
}
if ($set=="delete" && $doit==1) {
	if (!DEMO) $LINKS->delGRP($lnk_grp_id,1,0);
	$_MAIN_MESSAGE.="<br>".___("Eintrag wurde gelöscht.");
}
if ($set=="deleteall" && $doit==1) {
	if (!DEMO) $LINKS->delGRP($lnk_grp_id,0,1);
	$_MAIN_MESSAGE.="<br>".___("Eintrag und die zugeordneten Adressen wurden gelöscht.");
}

$GRP=$LINKS->getGroup(0,Array("count"=>1));

//sort array:
#if (!isset($sortIndex)) {
	$sortIndex=getVar("si");
#}
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

$editURLPara=tmObjCopy($mSTDURL);
$editURLPara->addParam("act","link_grp_edit");

$addlnkURLPara=tmObjCopy($mSTDURL);
$addlnkURLPara->addParam("act","link_new");

$showlnkURLPara=tmObjCopy($mSTDURL);
$showlnkURLPara->addParam("act","link_list");

$aktivURLPara=tmObjCopy($mSTDURL);
$aktivURLPara->addParam("act","link_grp_list");
$aktivURLPara->addParam("set","aktiv");

$delURLPara=tmObjCopy($mSTDURL);
$delURLPara->addParam("act","link_grp_list");
$delURLPara->addParam("set","delete");

$delallURLPara=tmObjCopy($mSTDURL);
$delallURLPara->addParam("act","link_grp_list");
$delallURLPara->addParam("set","deleteall");

$stdURLPara=tmObjCopy($mSTDURL);
$stdURLPara->addParam("act","link_grp_list");
$stdURLPara->addParam("set","standard");

$sortURLPara=tmObjCopy($mSTDURL);
$sortURLPara->addParam("act","link_grp_list");
$sortURLPara_=$sortURLPara->getAllParams();

//show log summary
//search for logs, only section
$search_log['object']="lnk_grp";
include(TM_INCLUDEPATH."/log_summary_section.inc.php");

$_MAIN_OUTPUT.="<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" width=\"100%\">";
$_MAIN_OUTPUT.= "<thead>".
						"<tr>".
						"<td><b>ID</b>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=id&amp;st=0\">".$img_arrowup."</a>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=id&amp;st=1\">".$img_arrowdown."</a>".
						"</td>".
						"<td><b>".___("Kurz")."</b>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=short&amp;st=0\">".$img_arrowup."</a>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=short&amp;st=1\">".$img_arrowdown."</a>".
						"</td>".
						"<td><b>".___("Name")."</b>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=name&amp;st=0\">".$img_arrowup."</a>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=name&amp;st=1\">".$img_arrowdown."</a>".
						"</td>".
						"<td><b>".___("Links")."</b>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=item_count&amp;st=0\">".$img_arrowup."</a>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=item_count&amp;st=1\">".$img_arrowdown."</a>".
						"</td>".
						"<td><b>".___("Beschreibung")."</b>".
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

	$editURLPara->addParam("lnk_grp_id",$GRP[$accg]['id']);
	$editURLPara_=$editURLPara->getAllParams();

	$addlnkURLPara->addParam("lnk_grp_id",$GRP[$accg]['id']);
	$addlnkURLPara_=$addlnkURLPara->getAllParams();

	$showlnkURLPara->addParam("lnk_grp_id",$GRP[$accg]['id']);
	$showlnkURLPara_=$showlnkURLPara->getAllParams();

	$aktivURLPara->addParam("lnk_grp_id",$GRP[$accg]['id']);
	$aktivURLPara->addParam("val",$new_aktiv);
	$aktivURLPara_=$aktivURLPara->getAllParams();

	$delURLPara->addParam("lnk_grp_id",$GRP[$accg]['id']);
	$delURLPara_=$delURLPara->getAllParams();

	$delallURLPara->addParam("lnk_grp_id",$GRP[$accg]['id']);
	$delallURLPara_=$delallURLPara->getAllParams();

	$stdURLPara->addParam("lnk_grp_id",$GRP[$accg]['id']);
	$stdURLPara_=$stdURLPara->getAllParams();


	$_MAIN_OUTPUT.= "<tr id=\"row_".$accg."\"  bgcolor=\"".$bgcolor."\" onmouseover=\"setBGColor('row_".$accg."','".$row_bgcolor_hilite."');\" onmouseout=\"setBGColor('row_".$accg."','".$bgcolor."');\">";
	$_MAIN_OUTPUT.= "<td onmousemove=\"showToolTip('tt_lnk_grp_list_".$GRP[$accg]['id']."')\" onmouseout=\"hideToolTip();\">";

	//wenn standardgruppe, dann icon anzeigen
	$_MAIN_OUTPUT.=  $GRP[$accg]['id'];
	if ($GRP[$accg]['standard']==1) {
		$_MAIN_OUTPUT.= "&nbsp;".tm_icon("page_white_lightning.png",___("Diese Gruppe ist die Standardgruppe"));
	}
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td onmousemove=\"showToolTip('tt_lnk_grp_list_".$GRP[$accg]['id']."')\" onmouseout=\"hideToolTip();\">";
	$_MAIN_OUTPUT.= "<a href=\"".$tm_URL."/".$editURLPara_."\"  title=\"".___("Gruppe bearbeiten")."\">".display($GRP[$accg]['short'])."</a>";
	$_MAIN_OUTPUT.= "<div id=\"tt_lnk_grp_list_".$GRP[$accg]['id']."\" class=\"tooltip\">";
	$_MAIN_OUTPUT.="<b>".display($GRP[$accg]['name'])."</b>";
	$_MAIN_OUTPUT.="<br><em>".display($GRP[$accg]['short'])."</em>";
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
	$_MAIN_OUTPUT.="<br>".sprintf(___("%s Einträge"),display($GRP[$accg]['item_count'])).
									"<br>".sprintf(___("Erstellt am: %s von %s"),display($GRP[$accg]['created']),display($GRP[$accg]['author'])).
									"<br>".sprintf(___("Bearbeitet am: %s von %s"),display($GRP[$accg]['updated']),display($GRP[$accg]['editor'])).
									"";

	$_MAIN_OUTPUT.= "</div>";
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= display($GRP[$accg]['name']);
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= display($GRP[$accg]['item_count']);
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= display($GRP[$accg]['descr']);
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
	$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$tm_URL."/".$editURLPara_."\" title=\"".___("Gruppe bearbeiten")."\">".tm_icon("pencil.png",___("Adressgruppe bearbeiten"))."</a>";
	$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$tm_URL."/".$addlnkURLPara_."\" title=\"".___("Neuen Eintrag in dieser Gruppe anlegen")."\">".tm_icon("link_add.png",___("Neuen Eintrag in dieser Gruppe anlegen"))."</a>";
	$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$tm_URL."/".$showlnkURLPara_."\" title=\"".___("Alle Einträge in dieser Gruppe anzeigen")."\">".tm_icon("link_go.png",___("Alle Einträge in dieser Gruppe anzeigen"))."</a>";;
	#."&nbsp;".$GRP[$accg]['adr_count']."</a>";
	if ($GRP[$accg]['standard']==1) {
		//wenn gruppe standard ist, dann bildchen anzeigen, wird auch neben id angezeigt
		//$_MAIN_OUTPUT.=  "&nbsp;<img src=\"".$tm_iconURL."/page_white_lightning.png\" border=\"0\">";
	} else {
		//wenn gruppe aktiv ist, dann darf man sie als standard definieren
		if ($GRP[$accg]['aktiv']==1) {
			$_MAIN_OUTPUT.=  "&nbsp;<a href=\"".$tm_URL."/".$stdURLPara_."\" onclick=\"return confirmLink(this, '".sprintf(___("Gruppe %s als Standard definieren."),display($GRP[$accg]['name']))."')\" title=\"".___("Diese Gruppe als Standardgruppe")."\">".tm_icon("page_white_go.png",___("Diese Gruppe als Standardgruppe"))."</a>";
		}
		//loeschen
		$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$tm_URL."/".$delURLPara_."\" onclick=\"return confirmLink(this, '".sprintf(___("Gruppe %s löschen und Einträge dieser Gruppe der Standardgruppe zuordnen?"),display($GRP[$accg]['name']))."')\" title=\"".___("Gruppe löschen")."\">".tm_icon("cross.png",___("Gruppe löschen"))."</a>";
		//bomb! gruppe UND Adressen loeschen!!!
		$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$tm_URL."/".$delallURLPara_."\" onclick=\"return confirmLink(this, '".sprintf(___("Gruppe %s UND Einträge dieser Gruppe löschen?"),display($GRP[$accg]['name']))."')\" title=\"".___("Gruppe und Einträge löschen")."\">".tm_icon("bomb.png",___("Gruppe und Einträge löschen"))."</a>";

	}

	//show log summary
	//search for logs, section and entry!
	//$search_log['object']="xxx"; <-- is set above in section link to logbook
	$search_log['edit_id']=$GRP[$accg]['id'];
	include(TM_INCLUDEPATH."/log_summary_section_entry.inc.php");


	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "</tr>";
}

$_MAIN_OUTPUT.= "</tbody></table>";

include(TM_INCLUDEPATH."/link_grp_list_legende.inc.php");
?>