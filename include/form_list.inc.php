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

$_MAIN_DESCR=___("Formulare verwalten");
$_MAIN_MESSAGE.="";

$FORMULAR=new tm_FRM();
$ADDRESS=new tm_ADR();

$adr_grp_id=getVar("adr_grp_id");

$frm_id=getVar("frm_id");
$set=getVar("set");
$val=getVar("val");
$doit=getVar("doit");//wird per js an url angefuegt!!! confirm()

if ($set=="aktiv") {
	$FORMULAR->setAktiv($frm_id,$val);
	if ($val==1) {
		$_MAIN_MESSAGE.="<br>".___("Eintrag wurde aktiviert.");
	} else  {
		$_MAIN_MESSAGE.="<br>".___("Eintrag wurde de-aktiviert.");
	}
}
if ($set=="delete" && $doit==1) {
	if (!DEMO) $FORMULAR->delForm($frm_id);
	$_MAIN_MESSAGE.="<br>".___("Eintrag wurde gelöscht.");
}
if ($set=="copy" && $doit==1) {
	$FORMULAR->copyForm($frm_id);
	$_MAIN_MESSAGE.="<br>".___("Eintrag wurde kopiert.");
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

$_MAIN_OUTPUT="<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" width=\"100%\">";
$_MAIN_OUTPUT.= "<thead>".
						"<tr>".
						"<td><b>".___("ID")."</b>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=id&amp;st=0\">".$img_arrowup."</a>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=id&amp;st=1\">".$img_arrowdown."</a>".
						"</td>".
						"<td><b>".___("Name")."</b>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=name&amp;st=0\">".$img_arrowup."</a>".
						"<a href=\"".$tm_URL."/".$sortURLPara_."&amp;si=name&amp;st=1\">".$img_arrowdown."</a>".
						"</td>".
						"<td><b>".___("Beschreibung")."</b>".
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
	if ($FRM[$acc]['aktiv']!=1) {
		$bgcolor=$row_bgcolor_inactive;
		$new_aktiv=1;
	} else {
		$new_aktiv=0;
	}

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
	$_MAIN_OUTPUT.= "<b>".$FRM[$acc]['id']."</b>&nbsp;&nbsp;";

	if ($FRM[$acc]['subscribe_aktiv']==1) {
		$_MAIN_OUTPUT.=  tm_icon("user_green.png",___("Aktiv"))."&nbsp;";
	} else {
		$_MAIN_OUTPUT.=  tm_icon("user_red.png",___("Inaktiv"))."&nbsp;";
	}
	//markierung doubleoptin
	if ($FRM[$acc]['use_captcha']==1) {
		$_MAIN_OUTPUT.=  tm_icon("sport_8ball.png",___("Captcha")).$FRM[$acc]['digits_captcha']."&nbsp;";
	}
	if ($FRM[$acc]['double_optin']==1) {
		$_MAIN_OUTPUT.=  tm_icon("arrow_refresh_small.png",___("Double-Opt-In"));
	}
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td onmousemove=\"showToolTip('tt_adr_list_".$FRM[$acc]['id']."')\" onmouseout=\"hideToolTip();\">";
	$_MAIN_OUTPUT.= "<a href=\"".$tm_URL."/".$editURLPara_."\"  title=\"".___("Formular bearbeiten")."\">".display($FRM[$acc]['name'])."</a>";
	$_MAIN_OUTPUT.= "<div id=\"tt_adr_list_".$FRM[$acc]['id']."\" class=\"tooltip\">";
	$_MAIN_OUTPUT.= "<b>".display($FRM[$acc]['name'])."</b>".
							"<font size=-1><br>".display($FRM[$acc]['descr']);

	$_MAIN_OUTPUT.= "<br>ID: ".$FRM[$acc]['id']." ";
	if ($FRM[$acc]['aktiv']==1) {
		$_MAIN_OUTPUT.=  "<br>".tm_icon("tick.png",___("Aktiv"));
		$_MAIN_OUTPUT.=  ___("(aktiv)");
	} else {
		$_MAIN_OUTPUT.=  "<br>".tm_icon("cancel.png",___("Inaktiv"));
		$_MAIN_OUTPUT.=  ___("(inaktiv)");
	}
	if ($FRM[$acc]['subscribe_aktiv']==1) {
		$_MAIN_OUTPUT.=  "<br>".tm_icon("user_green.png",___("Aktiv"));
		$_MAIN_OUTPUT.=  ___("Neuangemeldete Adressen sind aktiv");
	} else {
		$_MAIN_OUTPUT.=  "<br>".tm_icon("user_red.png",___("Inaktiv"));
		$_MAIN_OUTPUT.=  ___("Neuangemeldete Adressen sind deaktiviert");
	}
	//captcha
	if ($FRM[$acc]['use_captcha']==1) {
		$_MAIN_OUTPUT.=  "<br>".tm_icon("sport_8ball.png",___("Captcha"))."&nbsp;".___("Captcha").",&nbsp;";
		$_MAIN_OUTPUT.=  sprintf(___("%s Ziffern"),$FRM[$acc]['digits_captcha']);
		$_MAIN_OUTPUT.=  "<br>".___("Fehlermeldung").": <em>".$FRM[$acc]['captcha_errmsg']."</em>";
	}
	//markierung doubleoptin
	if ($FRM[$acc]['double_optin']==1) {
		$_MAIN_OUTPUT.=  "<br>".tm_icon("arrow_refresh_small.png",___("Double-Opt-In"))."&nbsp;".___("Double-Opt-In");
	}
	$_MAIN_OUTPUT.= 	"<br><br>".sprintf(___("Anmeldungen: %s"),$FRM[$acc]['subscriptions']).
							"<br><br>email= ".display($FRM[$acc]['email'])." &nbsp; [] &nbsp; <em>".display($FRM[$acc]['email_errmsg'])."</em>".
							"<br><br>f0= ".display($FRM[$acc]['f0'])." &nbsp; [".display($FRM[$acc]['f0_value'])."] &nbsp; <em>".display($FRM[$acc]['f0_errmsg'])."</em>".
							"<br>f1= ".display($FRM[$acc]['f1'])." &nbsp; [".display($FRM[$acc]['f1_value'])."] &nbsp; <em>".display($FRM[$acc]['f1_errmsg'])."</em>".
							"<br>f2= ".display($FRM[$acc]['f2'])." &nbsp; [".display($FRM[$acc]['f2_value'])."] &nbsp; <em>".display($FRM[$acc]['f2_errmsg'])."</em>".
							"<br>f3= ".display($FRM[$acc]['f3'])." &nbsp; [".display($FRM[$acc]['f3_value'])."] &nbsp; <em>".display($FRM[$acc]['f3_errmsg'])."</em>".
							"<br>f4= ".display($FRM[$acc]['f4'])." &nbsp; [".display($FRM[$acc]['f4_value'])."] &nbsp; <em>".display($FRM[$acc]['f4_errmsg'])."</em>".
							"<br>f5= ".display($FRM[$acc]['f5'])." &nbsp; [".display($FRM[$acc]['f5_value'])."] &nbsp; <em>".display($FRM[$acc]['f5_errmsg'])."</em>".
							"<br>f6= ".display($FRM[$acc]['f6'])." &nbsp; [".display($FRM[$acc]['f6_value'])."] &nbsp; <em>".display($FRM[$acc]['f6_errmsg'])."</em>".
							"<br>f7= ".display($FRM[$acc]['f7'])." &nbsp; [".display($FRM[$acc]['f7_value'])."] &nbsp; <em>".display($FRM[$acc]['f7_errmsg'])."</em>".
							"<br>f8= ".display($FRM[$acc]['f8'])." &nbsp; [".display($FRM[$acc]['f8_value'])."] &nbsp; <em>".display($FRM[$acc]['f8_errmsg'])."</em>".
							"<br>f9= ".display($FRM[$acc]['f9'])." &nbsp; [".display($FRM[$acc]['f9_value'])."] &nbsp; <em>".display($FRM[$acc]['f9_errmsg'])."</em>".
							"<br><br>".sprintf(___("Erstellt am: %s von %s"),$created_date,$author).
							"<br>".sprintf(___("Bearbeitet am: %s von %s"),$updated_date,$editor);
	$_MAIN_OUTPUT.= "<br><br>".___("Anmeldungen über dieses Formular werden in die folgenden Gruppen eingeordnet:")."<br>";

	$GRP=$ADDRESS->getGroup(0,0,$FRM[$acc]['id']);
	$acg=count($GRP);
	for ($accg=0;$accg<$acg;$accg++) {
		$_MAIN_OUTPUT.= "".display($GRP[$accg]['name'])."<br>";
	}

	$_MAIN_OUTPUT.= "</font>";
	$_MAIN_OUTPUT.= "</div>";
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= display($FRM[$acc]['descr']);
	$_MAIN_OUTPUT.= "</td>";

	$_MAIN_OUTPUT.= "<td>";

	for ($accg=0;$accg<$acg;$accg++) {
		$_MAIN_OUTPUT.= "".display($GRP[$accg]['name']).", ";
	}

	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= "<a href=\"".$tm_URL."/".$aktivURLPara_."\" title=\"".___("aktivieren/de-aktivieren")."\">";
	if ($FRM[$acc]['aktiv']==1) {
		$_MAIN_OUTPUT.=  tm_icon("tick.png",___("Aktiv"));
	} else {
		$_MAIN_OUTPUT.=  tm_icon("cancel.png",___("Inaktiv"));
	}
	$_MAIN_OUTPUT.= "</a>";
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	//link zur dynamischen onlineversion!
	$_MAIN_OUTPUT.= "&nbsp;&nbsp;<a href=\"".$tm_URL_FE."/subscribe.php?fid=".$FRM[$acc]['id']."\" target=\"_preview\" title=\"".sprintf(___("Dynamische Onlineversion anzeigen: %s"),"subscribe.php?fid=".$FRM[$acc]['id'])."\">".tm_icon("eye.png",___("Online"))."</a>";
	//link zum template
	if (file_exists($tm_formpath."/Form_".$FRM[$acc]['id'].".html")) {
		$_MAIN_OUTPUT.= "&nbsp;&nbsp;<a href=\"".$tm_URL_FE."/".$tm_formdir."/Form_".$FRM[$acc]['id'].".html\" target=\"_preview\" title=\"".sprintf(___("Template anzeigen: %s"),$tm_formdir."/Form_".$FRM[$acc]['id'].".html")."\">".tm_icon("page_white_code.png",___("Template"))."</a>";
	}
	//link zur geparsten Version
	if (file_exists($tm_formpath."/Form_".$FRM[$acc]['id']."_p.html")) {
		$_MAIN_OUTPUT.= "&nbsp;&nbsp;<a href=\"".$tm_URL_FE."/".$tm_formdir."/Form_".$FRM[$acc]['id']."_p.html\" target=\"_preview\" title=\"".sprintf(___("Statische Onlineversion anzeigen: %s"),$tm_formdir."/Form_".$FRM[$acc]['id']."_p.html")."\">".tm_icon("application_form_magnify.png",___("Online"))."</a>";
	}
	$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$tm_URL."/".$editURLPara_."\" title=\"".___("Formular bearbeiten")."\">".tm_icon("pencil.png",___("Bearbeiten"))."</a>";
	$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$tm_URL."/".$copyURLPara_."\" onclick=\"return confirmLink(this, '".___("Formular kopieren")."')\" title=\"".___("Formular kopieren")."\">".tm_icon("add.png",___("Kopieren"))."</a>";
	$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$tm_URL."/".$statURLPara_."\" title=\"".___("Statistik anzeigen")."\">".tm_icon("chart_pie.png",___("Statistik"))."</a>";
	$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$tm_URL."/".$delURLPara_."\" onclick=\"return confirmLink(this, '".sprintf(___("Formular %s löschen"),display($FRM[$acc]['name']))."')\" title=\"".___("Formular löschen")."\">".tm_icon("cross.png",___("Löschen"))."</a>";
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "</tr>";
}

$_MAIN_OUTPUT.= "</tbody></table>";

include($tm_includepath."/form_list_legende.inc.php");
?>