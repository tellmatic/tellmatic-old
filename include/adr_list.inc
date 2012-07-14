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

$_MAIN_DESCR="Adressen verwalten";
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

$sortIndex=getVar("si");
if (empty($sortIndex)) {
	$sortIndex="id";
}
$sortType=getVar("st");
if (empty($sortType)) {
	$sortType="0";//asc
}

$ADDRESS=new mnlADR();
$QUEUE=new mnlQ();

$adr_grp_id=getVar("adr_grp_id");

$adr_id=getVar("adr_id");
$set=getVar("set");
$val=getVar("val");
$doit=getVar("doit");//wird per js an url angefuegt!!! confirm()
if (!isset($search)) {
	$search=Array();
}

include ("adr_search.inc");



if ($set=="aktiv") {
	$ADDRESS->setAktiv($adr_id,$val);
	if ($val==1) { 
		$_MAIN_MESSAGE.="<br>Eintrag wurde aktiviert.";
	} else  {
		$_MAIN_MESSAGE.="<br>Eintrag wurde de-aktiviert.";
	}
}
if ($set=="delete" && $doit==1) {
	$ADDRESS->delAdr($adr_id);
	$_MAIN_MESSAGE.="<br>Eintrag wurde geloescht.";
}


if ($adr_grp_id>0)
{
	$ADR=$ADDRESS->getAdr(0,$offset,$limit,$adr_grp_id,$search,$sortIndex,$sortType);//id,offset,limit,group,$search_array
	$adr_grp=$ADDRESS->getGroup($adr_grp_id);
	$_MAIN_MESSAGE.="<br>gewaehlte Gruppe: <b>".$adr_grp[0]['name']."</b>";
} else {
	$ADR=$ADDRESS->getAdr(0,$offset,$limit,0,$search,$sortIndex,$sortType);//id,offset,limit,group,$search_array
}

$ac=count($ADR);
$entrys=$ac; // fuer pager.inc!!!
$entrys_total=$ADDRESS->countADR($adr_grp_id,$search);
//wir sortieren ueber die db, sortIndex und Type werden uebergeben an get ADR
//damit die sortierung auch mit limits klappt.... sonst werden nur die gezeigten eintraege im array sortiert, nichjt aber die geamte adressliste in der db... etc
//sortierung ueber array:
//$ADR=sort_array($ADR,$sortIndex,$sortType);


//globale parameter die angefuegt werden sollen!
$mSTDURL->addParam("offset",0);
$mSTDURL->addParam("limit",$limit);
$mSTDURL->addParam("st",$sortType);
$mSTDURL->addParam("si",$sortIndex);
$mSTDURL->addParam("email",$email);
$mSTDURL->addParam("f0_9",$f0_9);
$mSTDURL->addParam("status",$status);
$mSTDURL->addParam("adr_grp_id",$adr_grp_id);
if ($set=="search") {
	$mSTDURL->addParam("set",$set);
}

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
$aktivURLPara->addParam("st",$sortType);
$aktivURLPara->addParam("si",$sortIndex);
$aktivURLPara->addParam("act","adr_list");
$aktivURLPara->addParam("set","aktiv");

$delURLPara=$mSTDURL;
$delURLPara->addParam("adr_grp_id",$adr_grp_id);
$delURLPara->addParam("offset",$offset);
$delURLPara->addParam("limit",$limit);
$delURLPara->addParam("st",$sortType);
$delURLPara->addParam("si",$sortIndex);
$delURLPara->addParam("act","adr_list");
$delURLPara->addParam("set","delete");

$statURLPara=$mSTDURL;
$statURLPara->addParam("act","statistic");
$statURLPara->addParam("set","adr");

//$_MAIN_OUTPUT="";
include($mnl_includepath."/pager.inc");

$_MAIN_OUTPUT.="<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" width=100%>";
$_MAIN_OUTPUT.= "<thead>
						<tr>
						<!--td><b>ID/Detail_ID</b>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=id&st=0\">".$img_arrowup."</a>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=id&st=1\">".$img_arrowdown."</a>
						</td-->
						<td><b>e-Mail</b>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=email&st=0\">".$img_arrowup."</a>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=email&st=1\">".$img_arrowdown."</a>
						</td>
<!--
						<td><b>f0</b>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=f0&st=0\">".$img_arrowup."</a>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=f0&st=1\">".$img_arrowdown."</a>
						</td>
						<td><b>f1</b>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=f1&st=0\">".$img_arrowup."</a>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=f1&st=1\">".$img_arrowdown."</a>
						</td>
						<td><b>f2</b>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=f2&st=0\">".$img_arrowup."</a>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=f2&st=1\">".$img_arrowdown."</a>
						</td>
						<td><b>f3</b>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=f3&st=0\">".$img_arrowup."</a>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=f3&st=1\">".$img_arrowdown."</a>
						</td>
						<td><b>f4</b>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=f4&st=0\">".$img_arrowup."</a>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=f4&st=1\">".$img_arrowdown."</a>
						</td>
						<td><b>f5</b>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=f5&st=0\">".$img_arrowup."</a>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=f5&st=1\">".$img_arrowdown."</a>
						</td>
						<td><b>f6</b>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=f6&st=0\">".$img_arrowup."</a>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=f6&st=1\">".$img_arrowdown."</a>
						</td>
						<td><b>f7</b>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=f7&st=0\">".$img_arrowup."</a>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=f7&st=1\">".$img_arrowdown."</a>
						</td>
						<td><b>f8</b>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=f8&st=0\">".$img_arrowup."</a>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=f8&st=1\">".$img_arrowdown."</a>
						</td>
						<td><b>f9</b>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=f9&st=0\">".$img_arrowup."</a>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=f9&st=1\">".$img_arrowdown."</a>
						</td>
-->
						<td><b>Status</b>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=status&st=0\">".$img_arrowup."</a>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=status&st=1\">".$img_arrowdown."</a>
						</td>
						<td>Gruppen
						</td>
						<td><b>Aktiv</b>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=aktiv&st=0\">".$img_arrowup."</a>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=aktiv&st=1\">".$img_arrowdown."</a>
						</td>
						<td>...</td>
						</tr>
						</thead>
						<tbody>
						";

for ($acc=0;$acc<$ac;$acc++) {
	if ($acc%2==0) {$bgcolor=$row_bgcolor;} else {$bgcolor=$row_bgcolor2;}
	if ($ADR[$acc]['aktiv']!=1) {
		$bgcolor=$row_bgcolor_inactive;
		$new_aktiv=1;
	} else {
		$new_aktiv=0;
	}

	/*fuer denn fall als created noch varchar war
	$created_date=strftime("%d-%m-%Y",mk_microtime($ADR[$acc]['created']));
	$updated_date=strftime("%d-%m-%Y",mk_microtime($ADR[$acc]['updated']));
	*/
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
	$_MAIN_OUTPUT.= "<a href=\"".$mnl_URL."/".$editURLPara_."\">".$ADR[$acc]['email']."</a>";
	$_MAIN_OUTPUT.= "<div id=\"tt_adr_list_".$ADR[$acc]['id']."\" class=\"tooltip\">";
	$_MAIN_OUTPUT.= "ID: ".$ADR[$acc]['id']." / ".$ADR[$acc]['d_id']." ";
	if ($ADR[$acc]['aktiv']==1) {
		$_MAIN_OUTPUT.=  "<img src=\"".$mnl_iconURL."/tick.png\" border=\"0\">";
		$_MAIN_OUTPUT.=  "(aktiv)";
	} else {
		$_MAIN_OUTPUT.=  "<img src=\"".$mnl_iconURL."/cancel.png\" border=\"0\">";
		$_MAIN_OUTPUT.=  "(inaktiv)";
	}

	$_MAIN_OUTPUT.= " Status: <img src=\"".$mnl_iconURL."/".$STATUS['adr']['statimg'][$ADR[$acc]['status']]."\" border=\"0\">".$STATUS['adr']['status'][$ADR[$acc]['status']];
	
	$_MAIN_OUTPUT.= "<br><b>".$ADR[$acc]['email']."</b>
							<br>CODE: ".$ADR[$acc]['code']." &nbsp;
							<!--br>".$ADR[$acc]['f0']." &nbsp;
							<br>".$ADR[$acc]['f1']." &nbsp;
							<br>".$ADR[$acc]['f2']." &nbsp;
							<br>".$ADR[$acc]['f3']." &nbsp;
							<br>".$ADR[$acc]['f4']." &nbsp;
							<br>".$ADR[$acc]['f5']." &nbsp;
							<br>".$ADR[$acc]['f6']." &nbsp;
							<br>".$ADR[$acc]['f7']." &nbsp;
							<br>".$ADR[$acc]['f8']." &nbsp;
							<br>".$ADR[$acc]['f9']." &nbsp;-->
							<br>erstellt am: ".$created_date." von ".$author."
							<br>bearbeitet am: ".$updated_date." von ".$editor."
							<br>Newsletter Aktuell: ".$nlc." 
							<br>Newsletter Gesamt: ".$ADR[$acc]['newsletter']." 
							<br>Views: ".$ADR[$acc]['views']."
							<br>Clicks: ".$ADR[$acc]['clicks']."
							<br>Sendefehler: ".$ADR[$acc]['errors']." &nbsp;
							";
	$_MAIN_OUTPUT.= "<br>Mitglied in den Gruppen: ";
	$_MAIN_OUTPUT.= "<ul>";
	$GRP=$ADDRESS->getGroup(0,$ADR[$acc]['id']);
	$acg=count($GRP);
	for ($accg=0;$accg<$acg;$accg++) {
		$_MAIN_OUTPUT.= "<li>".$GRP[$accg]['name']."</li>";
	}
	$_MAIN_OUTPUT.= "</ul>";
	$_MAIN_OUTPUT.= "<br><font size=-1>".$ADR[$acc]['f0'].",&nbsp;".$ADR[$acc]['f1'].",&nbsp;".$ADR[$acc]['f2'].",&nbsp;".$ADR[$acc]['f3'].",&nbsp;".$ADR[$acc]['f4'].",&nbsp;".$ADR[$acc]['f5'].",&nbsp;";
	$_MAIN_OUTPUT.= "<br>".$ADR[$acc]['f6'].",&nbsp;".$ADR[$acc]['f7'].",&nbsp;".$ADR[$acc]['f8'].",&nbsp;".$ADR[$acc]['f9']."</font>";

	$_MAIN_OUTPUT.= "</div>";
	$_MAIN_OUTPUT.= "</td>";

	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/".$STATUS['adr']['statimg'][$ADR[$acc]['status']]."\" border=\"0\" title=\"".$STATUS['adr']['descr'][$ADR[$acc]['status']]."\" alt=\"".$STATUS['adr']['descr'][$ADR[$acc]['status']]."\">&nbsp;".$STATUS['adr']['status'][$ADR[$acc]['status']];
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	for ($accg=0;$accg<$acg;$accg++) {
		$_MAIN_OUTPUT.= "".$GRP[$accg]['name'].", ";
	}
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= "<a href=\"".$mnl_URL."/".$aktivURLPara_."\" title=\"aktivieren/de-aktivieren\">";
	if ($ADR[$acc]['aktiv']==1) {
		$_MAIN_OUTPUT.=  "<img src=\"".$mnl_iconURL."/tick.png\" border=\"0\">";
	} else {
		$_MAIN_OUTPUT.=  "<img src=\"".$mnl_iconURL."/cancel.png\" border=\"0\">";
	}
	$_MAIN_OUTPUT.= "</a>";
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= "<a href=\"".$mnl_URL."/".$editURLPara_."\" title=\"Adresse bearbeiten\"><img src=\"".$mnl_iconURL."/pencil.png\" border=\"0\"></a>";
	$_MAIN_OUTPUT.=  "&nbsp;<a href=\"".$mnl_URL."/".$statURLPara_."\" title=\"Statistik anzeigen\"><img src=\"".$mnl_iconURL."/chart_pie.png\" border=\"0\"></a>";
	$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$mnl_URL."/".$delURLPara_."\" onclick=\"return confirmLink(this, 'Adresse loeschen')\" title=\"Adresse loeschen\"><img src=\"".$mnl_iconURL."/cross.png\" border=\"0\"></a>";
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "</tr>";
}

$_MAIN_OUTPUT.= "</tbody></table>";

include($mnl_includepath."/pager.inc");
include($mnl_includepath."/adr_list_legende.inc");
?>