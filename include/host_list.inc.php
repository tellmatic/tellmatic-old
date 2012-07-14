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

$_MAIN_DESCR=___("Mailserver verwalten");
$_MAIN_MESSAGE.="";
$_MAIN_OUTPUT="";
$HOSTS=new tm_HOST();

$h_id=getVar("h_id");
$set=getVar("set");
$val=getVar("val");
$doit=getVar("doit");//wird per js an url angefuegt!!! confirm()

if ($set=="aktiv") {
	if (!DEMO) $HOSTS->setAktiv($h_id,$val);
	if ($val==1) {
		$_MAIN_MESSAGE.="<br>".___("Server wurde aktiviert.");
	} else  {
		$_MAIN_MESSAGE.="<br>".___("Server wurde de-aktiviert.");
	}
}
if ($set=="delete" && $doit==1) {
	if (!DEMO) $HOSTS->delHost($h_id);
	$_MAIN_MESSAGE.="<br>".___("Server wurde gelöscht.");
}

if ($set=="test") {
	$_MAIN_MESSAGE.="<br>".___("Server wird getestet.");
	require_once(TM_INCLUDEPATH."/host_test.inc.php");
}

$editURLPara=$mSTDURL;

$testURLPara=$mSTDURL;
$testURLPara->addParam("set","test");

$aktivURLPara=$mSTDURL;
$aktivURLPara->addParam("set","aktiv");

$delURLPara=$mSTDURL;
$delURLPara->addParam("set","delete");

$statURLPara=$mSTDURL;
$statURLPara->addParam("act","statistic");
$statURLPara->addParam("set","user");

$_MAIN_OUTPUT.="<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" width=\"100%\">";
$_MAIN_OUTPUT.= "<thead>".
						"<tr>".
						"<td><b>&nbsp;</b>".
						"</td>".
						"<td><b>".___("Name")."</b>".
						"</td>".
						"<td><b>".___("Host/Port")."</b>".
						"</td>".
						"<td><b>".___("Type")."</b>".
						"</td>".
						"<td><b>".___("Options/SMTP-Auth")."</b>".
						"</td>".
						"<td><b>".___("Benutzer")."</b>".
						"</td>".
						"<td><b>".___("Aktiv")."</b>".
						"</td>".
						"<td>...</td>".
						"</tr>".
						"</thead>".
						"<tbody>";

$HOST=$HOSTS->getHost();
$hc=count($HOST);

for ($hcc=0;$hcc<$hc;$hcc++) {
	if ($hcc%2==0) {$bgcolor=$row_bgcolor;} else {$bgcolor=$row_bgcolor2;}
	if ($HOST[$hcc]['aktiv']!=1) {
		$bgcolor=$row_bgcolor_inactive;
		$new_aktiv=1;
	} else {
		$new_aktiv=0;
	}

	$editURLPara->addParam("act","host_edit");
	$editURLPara->addParam("h_id",$HOST[$hcc]['id']);
	$editURLPara_=$editURLPara->getAllParams();

	$testURLPara->addParam("act","host_list");
	$testURLPara->addParam("h_id",$HOST[$hcc]['id']);
	$testURLPara_=$testURLPara->getAllParams();

	$aktivURLPara->addParam("act","host_list");
	$aktivURLPara->addParam("h_id",$HOST[$hcc]['id']);
	$aktivURLPara->addParam("val",$new_aktiv);
	$aktivURLPara_=$aktivURLPara->getAllParams();

	$delURLPara->addParam("act","host_list");
	$delURLPara->addParam("h_id",$HOST[$hcc]['id']);
	$delURLPara_=$delURLPara->getAllParams();

#	$statURLPara->addParam("adr_grp_id",$USER[$ucc]['id']);
#	$statURLPara_=$statURLPara->getAllParams();

	$_MAIN_OUTPUT.= "<tr id=\"row_".$hcc."\"  bgcolor=\"".$bgcolor."\" onmouseover=\"setBGColor('row_".$hcc."','".$row_bgcolor_hilite."');\" onmouseout=\"setBGColor('row_".$hcc."','".$bgcolor."');\">";
	$_MAIN_OUTPUT.= "<td onmousemove=\"showToolTip('tt_host_list_".$HOST[$hcc]['id']."')\" onmouseout=\"hideToolTip();\">";

	if ($HOST[$hcc]['type']=="smtp") {
		$_MAIN_OUTPUT.=  tm_icon("server_compressed.png",___("SMTP"))."&nbsp;";
	}
	if ($HOST[$hcc]['type']=="pop3") {
		$_MAIN_OUTPUT.=  tm_icon("server_uncompressed.png",___("POP3"))."&nbsp;";
	}
	if ($HOST[$hcc]['type']=="imap") {
		$_MAIN_OUTPUT.=  tm_icon("server_database.png",___("IMAP"))."&nbsp;";
	}

	//wenn standardgruppe, dann icon anzeigen
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td onmousemove=\"showToolTip('tt_user_list_".$HOST[$hcc]['id']."')\" onmouseout=\"hideToolTip();\">";
	$_MAIN_OUTPUT.= "<a href=\"".$tm_URL."/".$editURLPara_."\"  title=\"".___("Server bearbeiten")."\">".display($HOST[$hcc]['name'])."</a>";
	$_MAIN_OUTPUT.= "<div id=\"tt_user_list_".$HOST[$hcc]['id']."\" class=\"tooltip\">";
	$_MAIN_OUTPUT.="<b>".display($HOST[$hcc]['name'])."</b>";
	$_MAIN_OUTPUT.= "<br><font size=\"-1\">".display($HOST[$hcc]['host'])."</font>";
	$_MAIN_OUTPUT.= "<br>ID: ".$HOST[$hcc]['id']." ";
	$_MAIN_OUTPUT.= "<br>".___("Host").": ".$HOST[$hcc]['host']." ";
	$_MAIN_OUTPUT.= "<br>".___("Type").": ".$HOST[$hcc]['type']." ";
	$_MAIN_OUTPUT.= "<br>".___("Port").": ".$HOST[$hcc]['port']." ";
	$_MAIN_OUTPUT.= "<br>".___("Options").": ".$HOST[$hcc]['options']." ";
	$_MAIN_OUTPUT.= "<br>".___("SMTP-Auth").": ".$HOST[$hcc]['smtp_auth']." ";
	$_MAIN_OUTPUT.= "<br>".___("SMTP-Domain").": ".$HOST[$hcc]['smtp_domain']." ";
	$_MAIN_OUTPUT.= "<br>".___("User").": ".$HOST[$hcc]['user']." ";

	if ($HOST[$hcc]['aktiv']==1) {
		$_MAIN_OUTPUT.=  "<br>".tm_icon("tick.png",___("Aktiv"))."&nbsp;";
		$_MAIN_OUTPUT.=  ___("(aktiv)");
	} else {
		$_MAIN_OUTPUT.=  "<br>".tm_icon("cancel.png",___("Inaktiv"))."&nbsp;";
		$_MAIN_OUTPUT.=  ___("(inaktiv)");
	}

	$_MAIN_OUTPUT.= "</div>";
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= display($HOST[$hcc]['host']).":".display($HOST[$hcc]['port']);
	if ($HOST[$hcc]['type']=="smtp") {
		$_MAIN_OUTPUT.= "<br>".display($HOST[$hcc]['smtp_domain']);
	}
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= display($HOST[$hcc]['type']);
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= display($HOST[$hcc]['options']);
	$_MAIN_OUTPUT.= display($HOST[$hcc]['smtp_auth']);
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= display($HOST[$hcc]['user']);
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= "<a href=\"".$tm_URL."/".$aktivURLPara_."\" title=\"".___("aktivieren/de-aktivieren")."\">";
	if ($HOST[$hcc]['aktiv']==1) {
		//aktiv
		$_MAIN_OUTPUT.=  tm_icon("tick.png",___("Aktiv"))."&nbsp;";
	} else {
		//inaktiv
		$_MAIN_OUTPUT.=  tm_icon("cancel.png",___("Inaktiv"))."&nbsp;";
	}
	$_MAIN_OUTPUT.= "</a>";

	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$tm_URL."/".$testURLPara_."\" title=\"".___("Server testen")."\">".tm_icon("server_connect.png",___("Server testen"))."</a>";
	$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$tm_URL."/".$editURLPara_."\" title=\"".___("Server bearbeiten")."\">".tm_icon("pencil.png",___("Server bearbeiten"))."</a>";
	#$_MAIN_OUTPUT.=  "&nbsp;<a href=\"".$tm_URL."/".$statURLPara_."\" title=\"".___("Statistik anzeigen")."\">".tm_icon("chart_pie.png",___("Statistik anzeigen"))."</a>";
	//loeschen
	$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$tm_URL."/".$delURLPara_."\" onclick=\"return confirmLink(this, '".sprintf(___("Server %s löschen?"),display($HOST[$hcc]['name']))."')\" title=\"".___("Server löschen")."\">".tm_icon("cross.png",___("Server löschen"))."</a>";
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "</tr>";
}

$_MAIN_OUTPUT.= "</tbody></table>";

include(TM_INCLUDEPATH."/host_list_legende.inc.php");
?>