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

$_MAIN_DESCR=___("Newsletter verwalten");
$_MAIN_MESSAGE.="";

$NEWSLETTER=new mnlNL();
$QUEUE=new mnlQ();

$nl_grp_id=getVar("nl_grp_id");

$nl_id=getVar("nl_id");
$set=getVar("set");
$val=getVar("val");
$doit=getVar("doit");//wird per js an url angefuegt!!! confirm()

if ($set=="aktiv") {
	$NEWSLETTER->setAktiv($nl_id,$val);
	if ($val==1) { 
		$_MAIN_MESSAGE.="<br>".___("Eintrag wurde aktiviert.");
	} else  {
		$_MAIN_MESSAGE.="<br>".___("Eintrag wurde de-aktiviert.");
	}
}
if ($set=="delete" && $doit==1) {
	$NEWSLETTER->delNL($nl_id);
	$_MAIN_MESSAGE.="<br>".___("Eintrag wurde gel&ouml;scht.");
}

if ($set=="delete_img" && $doit==1) {
	$NL=$NEWSLETTER->getNL($nl_id);
	if (@unlink($mnl_nlimgpath."/nl_".date_convert_to_string($NL[0]['created'])."_1.jpg")) {
		$_MAIN_MESSAGE.="<br>".___("Bild wurde gel&ouml;scht.");
	} else {
		$_MAIN_MESSAGE.="<br>".___("Bild konnte nicht gel&ouml;scht werden.");
	}
}

if ($set=="delete_html" && $doit==1) {
	$NL=$NEWSLETTER->getNL($nl_id);
	if (@unlink($mnl_nlpath."/nl_".date_convert_to_string($NL[0]['created']).".html")) {
		$_MAIN_MESSAGE.="<br>".___("HTML Datei wurde gel&ouml;scht.");
	} else {
		$_MAIN_MESSAGE.="<br>".___("HTML Datei konnte nicht gel&ouml;scht werden.");
	}
}

if ($set=="delete_attm" && $doit==1) {
	$NL=$NEWSLETTER->getNL($nl_id);
	if (@unlink($mnl_nlattachpath."/a".date_convert_to_string($NL[0]['created'])."_1.".$NL[0]['attm'])) {
		$_MAIN_MESSAGE.="<br>".___("Anhang wurde gel&ouml;scht.");
	} else {
		$_MAIN_MESSAGE.="<br>".___("Anhang konnte nicht gel&ouml;scht werden.");
	}
}

if ($set=="queue_delete" && $doit==1) {
	$QDel=$QUEUE->getQID($nl_id);
	$qdc=count($QDel);
	for ($qdcc=0;$qdcc<$qdc;$qdcc++) {
		$QUEUE->delQ($QDel[$qdcc]);
	}
	$NEWSLETTER->setStatus($nl_id,1);
	$_MAIN_MESSAGE.="<br>".sprintf(___("%s Queues fuer diese Newsletter wurden geloescht."),$qdc);
}
if ($set=="copy" && $doit==1) {
	$NEWSLETTER->copyNL($nl_id,0);//,0 = without files
	$_MAIN_MESSAGE.="<br>".___("Eintrag wurde kopiert.");
}
if ($set=="copyall" && $doit==1) {
	$NEWSLETTER->copyNL($nl_id,1);//,1 = with files
	$_MAIN_MESSAGE.="<br>".___("Eintrag und dazugeh&ouml;rige Dateien wurde kopiert.");
}

$offset=getVar("offset");
if (empty($offset) || $offset<0) {
	$offset=0;
}
$limit=getVar("limit");
if (empty($limit) || $limit<10) {
	$limit=5;
}

//sortierindex, name des arraykeys!
$sortIndex=getVar("si");
if (empty($sortIndex)) {
	$sortIndex="id";
}
//art der sortierung, asc, desc
$sortType=getVar("st",1,1);//varname, addslashes, default_if_not_set
if ($sortType!=0 && $sortType!=1) {
	$sortType=1;
}

if ($nl_grp_id!=0)
{
	$NL=$NEWSLETTER->getNL(0,$offset,$limit,$nl_grp_id,0,$sortIndex,$sortType);//
	//getNL($id=0,$offset=0,$limit=0,$group_id=0,$return_content=0,$sortIndex="",$sortType=0)
	$nl_grp=$NEWSLETTER->getGroup($nl_grp_id);
	$_MAIN_MESSAGE.="<br>".sprintf(___("Gew&auml;hlte Gruppe: %s"),"<b>".$nl_grp[0]['name']."</b>");
} else {
	$NL=$NEWSLETTER->getNL(0,$offset,$limit,0,0,$sortIndex,$sortType);//
	//getNL($id=0,$offset=0,$limit=0,$group_id=0,$return_content=0,$sortIndex="",$sortType=0)
}

$nc=count($NL);
$entrys=$nc; // fuer pager.inc!!!
$entrys_total=$NEWSLETTER->countNL($nl_grp_id);

$NL=sort_array($NL,$sortIndex,$sortType);

$mSTDURL->addParam("act","nl_list");

$firstURLPara=$mSTDURL;
$firstURLPara->addParam("nl_grp_id",$nl_grp_id);
$firstURLPara->addParam("offset",0);
$firstURLPara->addParam("limit",$limit);
$firstURLPara->addParam("st",$sortType);
$firstURLPara->addParam("si",$sortIndex);
$firstURLPara_=$firstURLPara->getAllParams();

$nextURLPara=$mSTDURL;
$nextURLPara->addParam("nl_grp_id",$nl_grp_id);
$nextURLPara->addParam("offset",($offset+$limit));
$nextURLPara->addParam("limit",$limit);
$nextURLPara->addParam("st",$sortType);
$nextURLPara->addParam("si",$sortIndex);
$nextURLPara_=$nextURLPara->getAllParams();

$prevURLPara=$mSTDURL;
$prevURLPara->addParam("nl_grp_id",$nl_grp_id);
$prevURLPara->addParam("offset",($offset-$limit));
$prevURLPara->addParam("limit",$limit);
$prevURLPara->addParam("st",$sortType);
$prevURLPara->addParam("si",$sortIndex);
$prevURLPara_=$prevURLPara->getAllParams();

$sortURLPara=$mSTDURL;
$sortURLPara->addParam("nl_grp_id","$nl_grp_id");
$sortURLPara_=$sortURLPara->getAllParams();

$editURLPara=$mSTDURL;
$editURLPara->addParam("act","nl_edit");
$editURLPara->addParam("nl_grp_id","$nl_grp_id");

$addqURLPara=$mSTDURL;
$addqURLPara->addParam("act","queue_new");

$delqURLPara=$mSTDURL;
$delqURLPara->addParam("act","nl_list");
$delqURLPara->addParam("set","queue_delete");

$showqURLPara=$mSTDURL;
$showqURLPara->addParam("act","queue_list");

$aktivURLPara=$mSTDURL;
$aktivURLPara->addParam("nl_grp_id",$nl_grp_id);
$aktivURLPara->addParam("act","nl_list");
$aktivURLPara->addParam("set","aktiv");

$sendURLPara=$mSTDURL;
$sendURLPara->addParam("act","queue_send");
$sendURLPara->addParam("set","nl");


$delURLPara=$mSTDURL;
$delURLPara->addParam("nl_grp_id",$nl_grp_id);
$delURLPara->addParam("act","nl_list");
$delURLPara->addParam("set","delete");

$delimgURLPara=$mSTDURL;
$delimgURLPara->addParam("nl_grp_id",$nl_grp_id);
$delimgURLPara->addParam("act","nl_list");
$delimgURLPara->addParam("set","delete_img");

$delhtmlURLPara=$mSTDURL;
$delhtmlURLPara->addParam("nl_grp_id",$nl_grp_id);
$delhtmlURLPara->addParam("act","nl_list");
$delhtmlURLPara->addParam("set","delete_html");

$delattmURLPara=$mSTDURL;
$delattmURLPara->addParam("nl_grp_id",$nl_grp_id);
$delattmURLPara->addParam("act","nl_list");
$delattmURLPara->addParam("set","delete_attm");



$copyURLPara=$mSTDURL;
$copyURLPara->addParam("nl_grp_id",$nl_grp_id);
$copyURLPara->addParam("act","nl_list");
$copyURLPara->addParam("set","copy");

$copyallURLPara=$mSTDURL;
$copyallURLPara->addParam("nl_grp_id",$nl_grp_id);
$copyallURLPara->addParam("act","nl_list");
$copyallURLPara->addParam("set","copyall");

$statURLPara=$mSTDURL;
$statURLPara->addParam("act","statistic");
$statURLPara->addParam("set","nl");

$_MAIN_OUTPUT="";

include($mnl_includepath."/pager.inc");
				
$_MAIN_OUTPUT.="<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" width=100%>";
$_MAIN_OUTPUT.= "<thead>".
						"<tr>".
						"<td><b>".___("Datum")."</b>".
						"<a href=\"".$mnl_URL."/".$sortURLPara_."&si=created&st=0\">".$img_arrowup."</a>".
						"<a href=\"".$mnl_URL."/".$sortURLPara_."&si=created&st=1\">".$img_arrowdown."</a>".
						"</td>".
						"<td><b>".___("Titel")."</b>".
						"<a href=\"".$mnl_URL."/".$sortURLPara_."&si=subject&st=0\">".$img_arrowup."</a>".
						"<a href=\"".$mnl_URL."/".$sortURLPara_."&si=subject&st=1\">".$img_arrowdown."</a>".
						"</td>".
						"<td><b>".___("Status")."</b>".
						"<a href=\"".$mnl_URL."/".$sortURLPara_."&si=status&st=0\">".$img_arrowup."</a>".
						"<a href=\"".$mnl_URL."/".$sortURLPara_."&si=status&st=1\">".$img_arrowdown."</a>".
						"</td>".
						"<td><b>".___("Gruppe")."</b>".
						"<a href=\"".$mnl_URL."/".$sortURLPara_."&si=grp_id&st=0\">".$img_arrowup."</a>".
						"<a href=\"".$mnl_URL."/".$sortURLPara_."&si=grp_id&st=1\">".$img_arrowdown."</a>".
						"</td>".
						"<td>...</td>".
						"</tr>".
						"</thead>".
						"<tbody>";

for ($ncc=0;$ncc<$nc;$ncc++) {
	
	if ($ncc%2==0) {$bgcolor=$row_bgcolor;} else {$bgcolor=$row_bgcolor2;}
	if ($NL[$ncc]['aktiv']!=1) {
		$bgcolor=$row_bgcolor_inactive;
		$new_aktiv=1;
	} else {
		$new_aktiv=0;
	}

	$created_date=$NL[$ncc]['created'];
	$updated_date=$NL[$ncc]['updated'];
	
	$author=$NL[$ncc]['author'];
	$editor=$NL[$ncc]['editor'];	
	
	$editURLPara->addParam("nl_id",$NL[$ncc]['id']);
	$editURLPara_=$editURLPara->getAllParams();

	$addqURLPara->addParam("nl_id",$NL[$ncc]['id']);
	$addqURLPara_=$addqURLPara->getAllParams();

	$delqURLPara->addParam("nl_id",$NL[$ncc]['id']);
	$delqURLPara_=$delqURLPara->getAllParams();

	$showqURLPara->addParam("nl_id",$NL[$ncc]['id']);
	$showqURLPara_=$showqURLPara->getAllParams();

	$sendURLPara->addParam("nl_id",$NL[$ncc]['id']);
	$sendURLPara_=$sendURLPara->getAllParams();

	$aktivURLPara->addParam("nl_id",$NL[$ncc]['id']);
	$aktivURLPara->addParam("val",$new_aktiv);
	$aktivURLPara_=$aktivURLPara->getAllParams();

	$delURLPara->addParam("nl_id",$NL[$ncc]['id']);
	$delURLPara_=$delURLPara->getAllParams();

	$delimgURLPara->addParam("nl_id",$NL[$ncc]['id']);
	$delimgURLPara_=$delimgURLPara->getAllParams();

	$delhtmlURLPara->addParam("nl_id",$NL[$ncc]['id']);
	$delhtmlURLPara_=$delhtmlURLPara->getAllParams();

	$delattmURLPara->addParam("nl_id",$NL[$ncc]['id']);
	$delattmURLPara_=$delattmURLPara->getAllParams();

	$copyURLPara->addParam("nl_id",$NL[$ncc]['id']);
	$copyURLPara_=$copyURLPara->getAllParams();

	$copyallURLPara->addParam("nl_id",$NL[$ncc]['id']);
	$copyallURLPara_=$copyallURLPara->getAllParams();
	
	$statURLPara->addParam("nl_id",$NL[$ncc]['id']);
	$statURLPara_=$statURLPara->getAllParams();

	$hc=$QUEUE->countH(0,$NL[$ncc]['id']);
	$hc_new=$QUEUE->countH(0,$NL[$ncc]['id'],0,0,1);
	$hc_ok=$QUEUE->countH(0,$NL[$ncc]['id'],0,0,2);
	$hc_view=$QUEUE->countH(0,$NL[$ncc]['id'],0,0,3);
	$hc_fail=$QUEUE->countH(0,$NL[$ncc]['id'],0,0,4);

	//gibt es ueberhaupt q eintraege fuer das nl? zum anzeigen
	$Q=$QUEUE->getQID($NL[$ncc]['id']);
	$qc=count($Q);
	//gibt es zu versendende eintraege in der q? status=1, neu
	$Qnew=$QUEUE->getQID($NL[$ncc]['id'],0,1);
	$qc_new=count($Qnew);

	$_MAIN_OUTPUT.= "<tr id=\"row_".$ncc."\" bgcolor=\"".$bgcolor."\" onmouseover=\"setBGColor('row_".$ncc."','".$row_bgcolor_hilite."');\" onmouseout=\"setBGColor('row_".$ncc."','".$bgcolor."');\">";

	$_MAIN_OUTPUT.= "<td onmousemove=\"showToolTip('tt_nl_list_".$NL[$ncc]['id']."')\" onmouseout=\"hideToolTip();\">";
	if ($NL[$ncc]['massmail']==1) {
		$_MAIN_OUTPUT.=  "<img src=\"".$mnl_iconURL."/lorry.png\" border=\"0\" title=\"".___("Massenmailing")."\">";
	} else {
		$_MAIN_OUTPUT.=  "<img src=\"".$mnl_iconURL."/user_suit.png\" border=\"0\" title=\"".___("personalisierter Newsletter")."\">";
	}
	$_MAIN_OUTPUT.= $created_date;
	
	$_MAIN_OUTPUT.= "</td>";

	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= "<a href=\"".$mnl_URL."/".$editURLPara_."\" title=\"".___("Newsletter bearbeiten")."\" >".$NL[$ncc]['subject']."</a>";

	$_MAIN_OUTPUT.= "<div id=\"tt_nl_list_".$NL[$ncc]['id']."\" class=\"tooltip\">";
	$_MAIN_OUTPUT.= "ID: ".$NL[$ncc]['id']." ";
	if ($NL[$ncc]['aktiv']==1) {
		$_MAIN_OUTPUT.=  "<img src=\"".$mnl_iconURL."/tick.png\" border=\"0\">";
		$_MAIN_OUTPUT.=  ___("(aktiv)");
	} else {
		$_MAIN_OUTPUT.=  "<img src=\"".$mnl_iconURL."/cancel.png\" border=\"0\">";
		$_MAIN_OUTPUT.=  ___("(inaktiv)");
	}
	if ($NL[$ncc]['massmail']==1) {
		$_MAIN_OUTPUT.=  "<br><img src=\"".$mnl_iconURL."/lorry.png\" border=\"0\" title=\"".___("Massenmailing")."\">".___("Massenmailing");
	} else {
		$_MAIN_OUTPUT.=  "<br><img src=\"".$mnl_iconURL."/user_suit.png\" border=\"0\" title=\"".___("personalisierter Newsletter")."\">".___("personalisierter Newsletter");
	}

	$_MAIN_OUTPUT.= "<br><img src=\"".$mnl_iconURL."/".$STATUS['nl']['statimg'][$NL[$ncc]['status']]."\" border=\"0\">&nbsp;".$STATUS['nl']['status'][$NL[$ncc]['status']];
	$_MAIN_OUTPUT.= "<br><b>".$NL[$ncc]['subject']."</b>".
							"<br>".sprintf(___("Erstellt am: %s von %s"),$created_date,$author).
							"<br>".sprintf(___("Bearbeitet am: %s von %s"),$updated_date,$editor);
	$_MAIN_OUTPUT.= "<br>".___("Gruppe:")." ";

	$GRP=$NEWSLETTER->getGroup($NL[$ncc]['grp_id'],0);
	if (isset($GRP[0]['name'])) {
		$_MAIN_OUTPUT.= $GRP[0]['name'];
	}
	if ($hc>0) {
		$_MAIN_OUTPUT.= "<br>".sprintf(___("Link: %s"),$NL[$ncc]['link']).
					"<br>".sprintf(___("Views: %s"),$NL[$ncc]['views']).
					"<br>".sprintf(___("Clicks: %s"),$NL[$ncc]['clicks']).
					"<br>".___("Versand an:")."<ul>".
					sprintf(___("insgesamt %s Adressen"),$hc)."<br>".
					sprintf(___("Wartend: %s"),$hc_new)."<br>".
					sprintf(___("Gesendet: %s"),$hc_ok)."<br>".
					sprintf(___("Fehler: %s"),$hc_fail)."<br>".
					sprintf(___("Angezeigt: %s"),$hc_view).
					"</ul>";
	}
	$_MAIN_OUTPUT.= "</div>";
	$_MAIN_OUTPUT.= "</td>";

	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/".$STATUS['nl']['statimg'][$NL[$ncc]['status']]."\" border=\"0\"  title=\"".$STATUS['nl']['descr'][$NL[$ncc]['status']]."\">&nbsp;".$STATUS['nl']['status'][$NL[$ncc]['status']];
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	if (isset($GRP[0]['name'])) {
		$_MAIN_OUTPUT.= $GRP[0]['name'];
	}
	$_MAIN_OUTPUT.= "</td>";

	$_MAIN_OUTPUT.= "<td>";
	//link fuer aktionen / bearbeiten menue:
	$_MAIN_OUTPUT.= "<a  class=\"list_edit_entry_head\" href=\"javascript:switchSection('list_edit_".$ncc."')\" title=\"".___("Bearbeiten / Aktionen anzeigen")."\"><img src=\"".$mnl_iconURL."/wrench_orange.png\" border=\"0\">...</a>";
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "</tr>";

	$_MAIN_OUTPUT.= "<tr onmouseover=\"setBGColor('row_".$ncc."','".$row_bgcolor_hilite."');\" onmouseout=\"setBGColor('row_".$ncc."','".$bgcolor."');\">";
	$_MAIN_OUTPUT.= "<td colspan=5>";

	//div fuer aktionen etc
		$_MAIN_OUTPUT.= "<div id=\"list_edit_".$ncc."\" class=\"list_edit\">";
		$_MAIN_OUTPUT.= "<font size=-1>";
		//
		//q hinzufuegen
		if ($NL[$ncc]['aktiv']==1) {
			if (file_exists($mnl_nlpath."/nl_".date_convert_to_string($NL[$ncc]['created'])."_n.html")) {
				$_MAIN_OUTPUT.= "<a  class=\"list_edit_entry\" href=\"".$mnl_URL."/".$addqURLPara_."\" title=\"".___("Neue Q")."\"><img src=\"".$mnl_iconURL."/hourglass_add.png\" border=\"0\">&nbsp;".___("Versandauftrag anlegen")."</a>";
			}
		}
		//queued? queuelist button anzeigen // status >1
		if ($qc>0 && ($NL[$ncc]['status']==2 || $NL[$ncc]['status']==3 || $NL[$ncc]['status']==4  || $NL[$ncc]['status']==6)) {
			$_MAIN_OUTPUT.= "<a class=\"list_edit_entry\" href=\"".$mnl_URL."/".$delqURLPara_."\"  onclick=\"return confirmLink(this, '".___("Alle Q-Eintraege fuer diesen Newsletter loeschen? Achtung es werden auch laufende Sendeauftraege geloescht!")."')\" title=\"".___("Q fuer dieses Newsletter loeschen")."\"><img src=\"".$mnl_iconURL."/hourglass_delete.png\" border=\"0\">&nbsp;".___("Versandauftr&auml;ge l&ouml;schen")."</a>";
			$_MAIN_OUTPUT.= "<a class=\"list_edit_entry\" href=\"".$mnl_URL."/".$showqURLPara_."\" title=\"".___("Q fuer dieses Newsletter anzeigen")."\"><img src=\"".$mnl_iconURL."/hourglass_go.png\" border=\"0\">&nbsp;".___("Versandauftr&auml;ge anzeigen")."</a>";
		}
		//queued? senden button anzeigen // status =2 oder 3 oder 4
		//	if (($NL[$ncc]['status']==2  || $NL[$ncc]['status']==3 || $NL[$ncc]['status']==4) && $NL[$ncc]['aktiv']==1) {
		if ($qc_new>0 && $NL[$ncc]['aktiv']==1) {
			$_MAIN_OUTPUT.= "<a class=\"list_edit_entry\" href=\"".$mnl_URL."/".$sendURLPara_."\" title=\"".___("Newsletter versenden")."\"><img src=\"".$mnl_iconURL."/email_go.png\" border=\"0\">&nbsp;".___("Versand starten")."</a>";
		}
		//

		//
		//link zum Template!
		if (file_exists($mnl_nlpath."/nl_".date_convert_to_string($NL[$ncc]['created'])."_n.html")) {
			$_MAIN_OUTPUT.= "<a class=\"list_edit_entry\" href=\"".$mnl_URL."/".$mnl_nldir."/nl_".date_convert_to_string($NL[$ncc]['created'])."_n.html\" target=\"_preview\" title=\"".___("Template des Newsletter anzeigen: ").$mnl_nldir."/nl_".date_convert_to_string($NL[$ncc]['created'])."_n.html\"><img src=\"".$mnl_iconURL."/eye.png\" border=\"0\">&nbsp;".___("Template anzeigen")."</a>";
		}
		//link zur geparsten onlineversion!
		if (file_exists($mnl_nlpath."/nl_".date_convert_to_string($NL[$ncc]['created'])."_p.html")) {
			$_MAIN_OUTPUT.= "<a class=\"list_edit_entry\" href=\"".$mnl_URL."/".$mnl_nldir."/nl_".date_convert_to_string($NL[$ncc]['created'])."_p.html\" target=\"_preview\" title=\"".___("Onlineversion des Newsletter anzeigen: ").$mnl_nldir."/nl_".date_convert_to_string($NL[$ncc]['created'])."_n.html\"><img src=\"".$mnl_iconURL."/world_go.png\" border=\"0\">&nbsp;".___("Onlineversion anzeigen")."</a>";
		}
		//link zum bild
		if (file_exists($mnl_nlimgpath."/nl_".date_convert_to_string($NL[$ncc]['created'])."_1.jpg")) {
			$_MAIN_OUTPUT.= "<a class=\"list_edit_entry\" href=\"".$mnl_URL."/".$mnl_nlimgdir."/nl_".date_convert_to_string($NL[$ncc]['created'])."_1.jpg\" target=\"_preview\" title=\"".___("Bild fuer diesen Newsletter anzeigen: ").$mnl_nlimgdir."/nl_".date_convert_to_string($NL[$ncc]['created'])."_1.jpg\"><img src=\"".$mnl_iconURL."/photo.png\" border=\"0\">&nbsp;".___("Bild anzeigen")."</a>";
			$_MAIN_OUTPUT.= "<a class=\"list_edit_entry\" href=\"".$mnl_URL."/".$delimgURLPara_."\"  onclick=\"return confirmLink(this, '".___("Bild loeschen").": ".$mnl_nlimgdir."/nl_".date_convert_to_string($NL[$ncc]['created'])."_1.jpg')\" title=\"".___("Bild loeschen")."\"><img src=\"".$mnl_iconURL."/photo_delete.png\" border=\"0\">&nbsp;".___("Bild l&ouml;schen")."</a>";
		}
		//link zur html datei!
		if (file_exists($mnl_nlpath."/nl_".date_convert_to_string($NL[$ncc]['created']).".html")) {
			$_MAIN_OUTPUT.= "<a class=\"list_edit_entry\" href=\"".$mnl_URL."/".$mnl_nldir."/nl_".date_convert_to_string($NL[$ncc]['created']).".html\" target=\"_preview\" title=\"".___("HTML-Datei anzeigen").": ".$mnl_nldir."/nl_".date_convert_to_string($NL[$ncc]['created']).".html\"><img src=\"".$mnl_iconURL."/page_white_world.png\" border=\"0\">&nbsp;".___("HTML-Datei anzeigen")."</a>";
			$_MAIN_OUTPUT.= "<a class=\"list_edit_entry\" href=\"".$mnl_URL."/".$delhtmlURLPara_."\"  onclick=\"return confirmLink(this, 'HTML Datei loeschen: ".$mnl_nldir."/nl_".date_convert_to_string($NL[$ncc]['created']).".html')\" title=\"".___("HTML Datei loeschen")."\"><img src=\"".$mnl_iconURL."/page_white_delete.png\" border=\"0\">&nbsp;".___("HTML-Datei l&ouml;schen")."</a>";
		}
		//link zum attachement!
		if (file_exists($mnl_nlattachpath."/a".date_convert_to_string($NL[$ncc]['created'])."_1.".$NL[$ncc]['attm'])) {
			$_MAIN_OUTPUT.= "<a class=\"list_edit_entry\" href=\"".$mnl_URL."/".$mnl_nlattachdir."/a".date_convert_to_string($NL[$ncc]['created'])."_1.".$NL[$ncc]['attm']."\" target=\"_preview\" title=\"".___("Anhang fuer diesen Newsletter laden").": ".$mnl_nlattachdir."/a".date_convert_to_string($NL[$ncc]['created'])."_1.".$NL[$ncc]['attm']."\"><img src=\"".$mnl_iconURL."/attach.png\" border=\"0\">&nbsp;".___("Anhang anzeigen")."</a>";
			$_MAIN_OUTPUT.= "<a class=\"list_edit_entry\" href=\"".$mnl_URL."/".$delattmURLPara_."\"  onclick=\"return confirmLink(this, '".___("Anhang loeschen").": a".date_convert_to_string($NL[$ncc]['created'])."_1.".$NL[$ncc]['attm']."')\" title=\"".___("Anhang loeschen")."\"><img src=\"".$mnl_iconURL."/link_break.png\" border=\"0\">&nbsp;".___("Anhang l&ouml;schen")."</a>";
		}
		//link zum link
		if (!empty($NL[$ncc]['link'])) {
			$_MAIN_OUTPUT.= "<a class=\"list_edit_entry\" href=\"".$NL[$ncc]['link']."\" target=\"_link\" title=\"".$NL[$ncc]['link']."\"><img src=\"".$mnl_iconURL."/page_white_link.png\" border=\"0\">&nbsp;".___("Link anzeigen")."</a>";
		}
		//aktiv
		$_MAIN_OUTPUT.= "<a class=\"list_edit_entry\" href=\"".$mnl_URL."/".$aktivURLPara_."\" title=\"".___("aktivieren/de-aktivieren")."\">";
		if ($NL[$ncc]['aktiv']==1) {
			$_MAIN_OUTPUT.=  "<img src=\"".$mnl_iconURL."/tick.png\" border=\"0\">&nbsp;".___("Deaktivieren");
		} else {
			$_MAIN_OUTPUT.=  "<img src=\"".$mnl_iconURL."/cancel.png\" border=\"0\">&nbsp;".___("Aktivieren");
		}
		$_MAIN_OUTPUT.= "</a>";
		//...
		$_MAIN_OUTPUT.= "<a class=\"list_edit_entry\" href=\"".$mnl_URL."/".$delURLPara_."\" onclick=\"return confirmLink(this, '".___("Newsletter loeschen")."')\" title=\"".___("Newsletter loeschen")."\"><img src=\"".$mnl_iconURL."/cross.png\" border=\"0\">&nbsp;".___("L&ouml;schen")."</a>";
		if ($NL[$ncc]['status']==4) {
			$_MAIN_OUTPUT.= "<a class=\"list_edit_entry\" href=\"".$mnl_URL."/".$editURLPara_."\" onclick=\"return confirmLink(this, '".___("Der Newsletter wurde bereits versendet, wollen Sie ihn wirklich bearbeiten? Es wird empfohlen eine Kopie zu erstellen und diese zu bearbeiten.")."')\" title=\"".___("Newsletter bearbeiten")."\"><img src=\"".$mnl_iconURL."/pencil.png\" border=\"0\">&nbsp;".___("Bearbeiten")."</a>";
		} else {
			if ($NL[$ncc]['status']!=3) {
				$_MAIN_OUTPUT.= "<a class=\"list_edit_entry\" href=\"".$mnl_URL."/".$editURLPara_."\" title=\"".___("Newsletter bearbeiten")."\"><img src=\"".$mnl_iconURL."/pencil.png\" border=\"0\">&nbsp;".___("Bearbeiten")."</a>";
			}
		}
		$_MAIN_OUTPUT.= "<a class=\"list_edit_entry\" href=\"".$mnl_URL."/".$copyURLPara_."\" onclick=\"return confirmLink(this, '".___("Newsletter kopieren")."')\" title=\"".___("Newsletter kopieren")."\"><img src=\"".$mnl_iconURL."/bullet_add.png\" border=\"0\">&nbsp;".___("Kopieren")."</a>";
		$_MAIN_OUTPUT.= "<a class=\"list_edit_entry\" href=\"".$mnl_URL."/".$copyallURLPara_."\" onclick=\"return confirmLink(this, '".___("Newsletter und Dateien kopieren")."')\" title=\"".___("Newsletter und Dateien kopieren")."\"><img src=\"".$mnl_iconURL."/add.png\" border=\"0\">&nbsp;".___("Kopieren(+Dateien)")."</a>";
		if ($NL[$ncc]['status']>2) {
			$_MAIN_OUTPUT.= "<a class=\"list_edit_entry\" href=\"".$mnl_URL."/".$statURLPara_."\" title=\"".___("Statistik anzeigen")."\"><img src=\"".$mnl_iconURL."/chart_pie.png\" border=\"0\">&nbsp;".___("Statistik")."</a>";
		}

		$_MAIN_OUTPUT.= "</font><br>";
		$_MAIN_OUTPUT.= "</div>";
		$_MAIN_OUTPUT.= "<script type=\"text/javascript\">switchSection('list_edit_".$ncc."');</script>";

		$_MAIN_OUTPUT.= "</td>";
		$_MAIN_OUTPUT.= "</tr>";


}//for

$_MAIN_OUTPUT.= "</tbody></table>";

include($mnl_includepath."/pager.inc");
include($mnl_includepath."/nl_list_legende.inc");
?>