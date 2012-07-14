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

$_MAIN_DESCR="Formulare verwalten";
$_MAIN_MESSAGE.="";

$FORMULAR=new mnlFRM();
$ADDRESS=new mnlADR();

$adr_grp_id=getVar("adr_grp_id");

$frm_id=getVar("frm_id");
$set=getVar("set");
$val=getVar("val");
$doit=getVar("doit");//wird per js an url angefuegt!!! confirm()

if ($set=="aktiv") {
	$FORMULAR->setAktiv($frm_id,$val);
	if ($val==1) { 
		$_MAIN_MESSAGE.="<br>Eintrag wurde aktiviert.";
	} else  {
		$_MAIN_MESSAGE.="<br>Eintrag wurde de-aktiviert.";
	}
}
if ($set=="delete" && $doit==1) {
	$FORMULAR->delForm($frm_id);
	$_MAIN_MESSAGE.="<br>Eintrag wurde geloescht.";
}
if ($set=="copy" && $doit==1) {
	$FORMULAR->copyForm($frm_id);
	$_MAIN_MESSAGE.="<br>Eintrag wurde kopiert.";
}

if ($adr_grp_id!=0)
{
	$FRM=$FORMULAR->getForm(0,0,0,$adr_grp_id);//id,offset,limit,group
} else {
	$FRM=$FORMULAR->getForm(0,0,0,0);//id,offset,limit,group
}
$ac=count($FRM);

$sortIndex=getVar("si");
if (empty($sortIndex)) {
	$sortIndex="id";
}
$sortType=getVar("st");
if (empty($sortType)) {
	$sortType="0";//asc
}

$FRM=sort_array($FRM,$sortIndex,$sortType);

$sortURLPara=$mSTDURL;
$sortURLPara->addParam("adr_grp_id",$adr_grp_id);
$sortURLPara->addParam("act","form_list");
$sortURLPara_=$sortURLPara->getAllParams();

$editURLPara=$mSTDURL;
$editURLPara->addParam("frm_id",$frm_id);
$editURLPara->addParam("act","form_edit");

$aktivURLPara=$mSTDURL;
$aktivURLPara->addParam("act","form_list");
$aktivURLPara->addParam("set","aktiv");

$delURLPara=$mSTDURL;
$delURLPara->addParam("act","form_list");
$delURLPara->addParam("set","delete");

$copyURLPara=$mSTDURL;
$copyURLPara->addParam("act","form_list");
$copyURLPara->addParam("set","copy");

$statURLPara=$mSTDURL;
$statURLPara->addParam("act","statistic");
$statURLPara->addParam("set","frm");

$_MAIN_OUTPUT="<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" width=100%>";
$_MAIN_OUTPUT.= "<thead>
						<tr>
						<td><b>ID</b>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=id&st=0\">".$img_arrowup."</a>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=id&st=1\">".$img_arrowdown."</a>
						</td>
						<td><b>Name</b>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=name&st=0\">".$img_arrowup."</a>
						<a href=\"".$mnl_URL."/".$sortURLPara_."&si=name&st=1\">-</a>
						</td>
						<td><b>Beschreibung</b>
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
	if ($FRM[$acc]['aktiv']!=1) {
		$bgcolor=$row_bgcolor_inactive;
		$new_aktiv=1;
	} else {
		$new_aktiv=0;
	}

	/*
	$created_date=strftime("%d-%m-%Y",mk_microtime($FRM[$acc]['created']));
	$updated_date=strftime("%d-%m-%Y",mk_microtime($FRM[$acc]['updated']));
	*/
	$created_date=$FRM[$acc]['created'];
	$updated_date=$FRM[$acc]['updated'];
	
	$author=$FRM[$acc]['author'];
	$editor=$FRM[$acc]['editor'];
	

	$editURLPara->addParam("frm_id",$FRM[$acc]['id']);
	$editURLPara_=$editURLPara->getAllParams();

	$aktivURLPara->addParam("frm_id",$FRM[$acc]['id']);
	$aktivURLPara->addParam("val",$new_aktiv);
	$aktivURLPara_=$aktivURLPara->getAllParams();

	$delURLPara->addParam("frm_id",$FRM[$acc]['id']);
	$delURLPara_=$delURLPara->getAllParams();

	$copyURLPara->addParam("frm_id",$FRM[$acc]['id']);
	$copyURLPara_=$copyURLPara->getAllParams();
	
	$statURLPara->addParam("frm_id",$FRM[$acc]['id']);
	$statURLPara_=$statURLPara->getAllParams();
	
	$_MAIN_OUTPUT.= "<tr id=\"row_".$acc."\"  bgcolor=\"".$bgcolor."\" onmouseover=\"setBGColor('row_".$acc."','".$row_bgcolor_hilite."');\" onmouseout=\"setBGColor('row_".$acc."','".$bgcolor."');\">";
	$_MAIN_OUTPUT.= "<td onmousemove=\"showToolTip('tt_adr_list_".$FRM[$acc]['id']."')\" onmouseout=\"hideToolTip();\">";
	$_MAIN_OUTPUT.= "<b>".$FRM[$acc]['id']."</b>";

	//markierung doubleoptin
	if ($FRM[$acc]['double_optin']==1) {
		$_MAIN_OUTPUT.=  "<img src=\"".$mnl_iconURL."/arrow_refresh_small.png\" border=\"0\" title=\"Double Opt-In\" alt=\"Double Opt-In\">";
	}



	
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td onmousemove=\"showToolTip('tt_adr_list_".$FRM[$acc]['id']."')\" onmouseout=\"hideToolTip();\">";
	$_MAIN_OUTPUT.= "<a href=\"".$mnl_URL."/".$editURLPara_."\"  title=\"Formular bearbeiten\">".$FRM[$acc]['name']."</a>";
	$_MAIN_OUTPUT.= "<div id=\"tt_adr_list_".$FRM[$acc]['id']."\" class=\"tooltip\">";
	$_MAIN_OUTPUT.= "ID: ".$FRM[$acc]['id']." ";
	if ($FRM[$acc]['aktiv']==1) {
		$_MAIN_OUTPUT.=  "<img src=\"".$mnl_iconURL."/tick.png\" border=\"0\">";
		$_MAIN_OUTPUT.=  "(aktiv)";
	} else {
		$_MAIN_OUTPUT.=  "<img src=\"".$mnl_iconURL."/cancel.png\" border=\"0\">";
		$_MAIN_OUTPUT.=  "(inaktiv)";
	}
	//markierung doubleoptin
	if ($FRM[$acc]['double_optin']==1) {
		$_MAIN_OUTPUT.=  "&nbsp;<img src=\"".$mnl_iconURL."/arrow_refresh_small.png\" border=\"0\">DoubleOptin";
	}
	$_MAIN_OUTPUT.= "<br><b>".$FRM[$acc]['name']."</b>
							<font size=-1><br>".$FRM[$acc]['descr']."
							<br><br>Anmeldungen: ".$FRM[$acc]['subscriptions']."
							<br><br>f0= ".$FRM[$acc]['f0']." &nbsp; [".$FRM[$acc]['f0_value']."]
							<br>f1= ".$FRM[$acc]['f1']." &nbsp; [".$FRM[$acc]['f1_value']."]
							<br>f2= ".$FRM[$acc]['f2']." &nbsp; [".$FRM[$acc]['f2_value']."]
							<br>f3= ".$FRM[$acc]['f3']." &nbsp; [".$FRM[$acc]['f3_value']."]
							<br>f4= ".$FRM[$acc]['f4']." &nbsp; [".$FRM[$acc]['f4_value']."]
							<br>f5= ".$FRM[$acc]['f5']." &nbsp; [".$FRM[$acc]['f5_value']."]
							<br>f6= ".$FRM[$acc]['f6']." &nbsp; [".$FRM[$acc]['f6_value']."]
							<br>f7= ".$FRM[$acc]['f7']." &nbsp; [".$FRM[$acc]['f7_value']."]
							<br>f8= ".$FRM[$acc]['f8']." &nbsp; [".$FRM[$acc]['f8_value']."]
							<br>f9= ".$FRM[$acc]['f9']." &nbsp; [".$FRM[$acc]['f9_value']."]
							<br><br>erstellt am: ".$created_date." von ".$author."
							<br>bearbeitet am: ".$updated_date." von ".$editor."
							";
	$_MAIN_OUTPUT.= "<br><br>Anmeldungen ueber dieses Formular werden in die folgenden Gruppen eingeordnet: <br>";
	$_MAIN_OUTPUT.= "<ul>";

	$GRP=$ADDRESS->getGroup(0,0,$FRM[$acc]['id']);
	$acg=count($GRP);
	for ($accg=0;$accg<$acg;$accg++) {
		$_MAIN_OUTPUT.= "<li>".$GRP[$accg]['name']."</li>";
	}

	$_MAIN_OUTPUT.= "</ul>";
	$_MAIN_OUTPUT.= "</font>";
	$_MAIN_OUTPUT.= "</div>";
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= $FRM[$acc]['descr'];
	$_MAIN_OUTPUT.= "</td>";

	$_MAIN_OUTPUT.= "<td>";

	for ($accg=0;$accg<$acg;$accg++) {
		$_MAIN_OUTPUT.= "".$GRP[$accg]['name'].", ";
	}

	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= "<a href=\"".$mnl_URL."/".$aktivURLPara_."\" title=\"aktivieren/de-aktivieren\">";
	if ($FRM[$acc]['aktiv']==1) {
		$_MAIN_OUTPUT.=  "<img src=\"".$mnl_iconURL."/tick.png\" border=\"0\">";
	} else {
		$_MAIN_OUTPUT.=  "<img src=\"".$mnl_iconURL."/cancel.png\" border=\"0\">";
	}
	$_MAIN_OUTPUT.= "</a>";
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	//link zur dynamischen onlineversion!
	$_MAIN_OUTPUT.= "&nbsp;&nbsp;<a href=\"".$mnl_URL."/subscribe.php?fid=".$FRM[$acc]['id']."\" target=\"_preview\" title=\"Dynamische Onlineversion anzeigen: subscribe.php?fid=".$FRM[$acc]['id']."\"><img src=\"".$mnl_iconURL."/eye.png\" border=\"0\"></a>";
	//link zum template
	if (file_exists($mnl_formpath."/Form_".$FRM[$acc]['id'].".html")) {
		$_MAIN_OUTPUT.= "&nbsp;&nbsp;<a href=\"".$mnl_URL."/".$mnl_formdir."/Form_".$FRM[$acc]['id'].".html\" target=\"_preview\" title=\"Template anzeigen: ".$mnl_formdir."/Form_".$FRM[$acc]['id'].".html\"><img src=\"".$mnl_iconURL."/page_white_code.png\" border=\"0\"></a>";
	}
	//link zur geparsten Version
	if (file_exists($mnl_formpath."/Form_".$FRM[$acc]['id']."_p.html")) {
		$_MAIN_OUTPUT.= "&nbsp;&nbsp;<a href=\"".$mnl_URL."/".$mnl_formdir."/Form_".$FRM[$acc]['id']."_p.html\" target=\"_preview\" title=\"statische Onlineversion anzeigen: ".$mnl_formdir."/Form_".$FRM[$acc]['id']."_p.html\"><img src=\"".$mnl_iconURL."/application_form_magnify.png\" border=\"0\"></a>";
	}
	$_MAIN_OUTPUT.= "<a href=\"".$mnl_URL."/".$editURLPara_."\" title=\"Formular bearbeiten\"><img src=\"".$mnl_iconURL."/pencil.png\" border=\"0\"></a>";
	$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$mnl_URL."/".$copyURLPara_."\" onclick=\"return confirmLink(this, 'Formular kopieren')\" title=\"Formular kopieren\"><img src=\"".$mnl_iconURL."/add.png\" border=\"0\"></a>";
//	$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$mnl_URL."/".$statURLPara_."\" title=\"Statistik anzeigen\"><img src=\"".$mnl_iconURL."/chart_pie.png\" border=\"0\"></a>";
	$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$mnl_URL."/".$delURLPara_."\" onclick=\"return confirmLink(this, 'Formular ".$FRM[$acc]['name']." loeschen')\" title=\"Formular loeschen\"><img src=\"".$mnl_iconURL."/cross.png\" border=\"0\"></a>";
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "</tr>";
}

$_MAIN_OUTPUT.= "</tbody></table>";

include($mnl_includepath."/form_list_legende.inc");
?>