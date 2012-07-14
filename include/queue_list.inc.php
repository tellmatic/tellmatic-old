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

$_MAIN_DESCR=___("Newsletter Warteschlange (Q)");
$_MAIN_MESSAGE.="";

$QUEUE=new tm_Q();

$set=getVar("set");
$val=getVar("val");
$q_id=getVar("q_id");
$nl_id=getVar("nl_id");
$doit=getVar("doit");//wird per js an url angefuegt!!! confirm()

$ADDRESS=new tm_ADR();
$NEWSLETTER=new tm_NL();



if (!empty($q_id)) {
	$Q=$QUEUE->getQ($q_id);
	$logfilename="q_".$Q[0]['id']."_".$Q[0]['grp_id']."_".date_convert_to_string($Q[0]['created']).".log.html";
}
if ($set=="stop" && $doit==1 && !empty($q_id)) {
	$QUEUE->setStatus($q_id,5);
	$LOG="<br>\n\n".date("d-m-Y H:i:s")." ---- Q ID $q_id halted.\n\n<br>";
	update_file($tm_logpath,$logfilename,$LOG);
}
if ($set=="continue" && $doit==1 && !empty($q_id)) {
	$QUEUE->setStatus($q_id,2);
	$LOG="<br>\n\n".date("d-m-Y H:i:s")." ---- Q ID $q_id continues.\n\n<br>";
	update_file($tm_logpath,$logfilename,$LOG);
}


if ($set=="delete" && $doit==1 && !empty($q_id)) {
	//nl auf status queued setzen =2
	//Q holen
	$Q=$QUEUE->getQ($q_id);
	//und q fuer newsletter aus aktueller q holen
	//eintraege zaehlen, wieviele qs fuer newsletter dieser q
	$QNL=$QUEUE->getQ(0,0,0,$Q[0]['nl_id']);
	$nqc=count($QNL);
	if ($nqc>0) {
	}
	//wenn hoechstens 1 eintrag, dann status des nl auf archiv setzen, ...5=archiv
	//ansonsten weiter
	if ($nqc<=1) {
		$NEWSLETTER->setStatus($Q[0]['nl_id'],5);
	}
	//q loeschen
	if (!DEMO) $QUEUE->delQ($q_id);
	$_MAIN_MESSAGE.="<br>".___("Eintrag wurde gelöscht.");
}
if ($set=="delete_log" && $doit==1) {
	$Q=$QUEUE->getQ($q_id);
	if (!DEMO && @unlink($tm_logpath."/".$logfilename)) {
		$_MAIN_MESSAGE.="<br>".___("Logfile wurde gelöscht.");
	} else {
		$_MAIN_MESSAGE.="<br>".___("Logfile konnte nicht gelöscht werden.");
	}
}

//q f. liste holen
if ($nl_id>0) {
	$NL=$NEWSLETTER->getNL($nl_id);
	$_MAIN_MESSAGE.="<br>".sprintf(___("gewähltes Newsletter: %s")," <b>".display($NL[0]['subject'])."</b>");
	$Q=$QUEUE->getQ(0,0,0,$nl_id);//id offset limit nl_id
} else {
	$Q=$QUEUE->getQ(0,0,0,0);//id offset limit nl_id
}
$qc=count($Q);

$reloadURLPara=$mSTDURL;
$reloadURLPara->addParam("act","queue_list");
$reloadURLPara->addParam("nl_id",$nl_id);

$showhistURLPara=$mSTDURL;
$showhistURLPara->addParam("act","queue_list");

$sendURLPara=$mSTDURL;
$sendURLPara->addParam("act","queue_send");
$sendURLPara->addParam("set","q");

$delURLPara=$mSTDURL;
$delURLPara->addParam("act","queue_list");
$delURLPara->addParam("set","delete");
$delURLPara->addParam("nl_id",$nl_id);

$dellogURLPara=$mSTDURL;
$dellogURLPara->addParam("act","queue_list");
$dellogURLPara->addParam("set","delete_log");
$dellogURLPara->addParam("nl_id",$nl_id);

$stopURLPara=$mSTDURL;
$stopURLPara->addParam("act","queue_list");
$stopURLPara->addParam("set","stop");
$stopURLPara->addParam("nl_id",$nl_id);

$continueURLPara=$mSTDURL;
$continueURLPara->addParam("act","queue_list");
$continueURLPara->addParam("set","continue");
$continueURLPara->addParam("nl_id",$nl_id);

$statURLPara=$mSTDURL;
$statURLPara->addParam("act","statistic");
$statURLPara->addParam("set","queue");

$reloadURLPara_=$reloadURLPara->getAllParams();
$_MAIN_OUTPUT.= "<a href=\"".$tm_URL."/".$reloadURLPara_."\" title=\"".___("Anzeige aktualisieren")."\">".tm_icon("arrow_refresh.png",___("Anzeige aktualisieren"))."&nbsp;".___("Anzeige aktualisieren")."</a><br><br>";

$_MAIN_OUTPUT.="<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" width=\"100%\">";
$_MAIN_OUTPUT.= "<thead>".
						"<tr>".
						"<td><b>".___("Datum")."</b>".
						"</td>".
						"<td><b>".___("Newsletter")."</b>".
						"</td>".
						"<td><b>".___("Adressgruppe")."</b>".
						"</td>".
						"<td><b>".___("Status")."</b>".
						"</td>".
						"<td>...</td>".
						"</tr>".
						"</thead>".
						"<tbody>";



for ($qcc=0;$qcc<$qc;$qcc++) {
	if ($qcc%2==0) {$bgcolor=$row_bgcolor;} else {$bgcolor=$row_bgcolor2;}

	//wenn q status=2 or 3 // run oder fertig
	//dann holen wir uns die daten fuer die q eintraege! vorher ist eh null... :)
	if ($Q[$qcc]['status']>1) {
		//wenn status > neu, also gestartet, versendet etc, dann summary anzeigen....
		$hc=$QUEUE->countH($Q[$qcc]['id']);
		$hc_new=$QUEUE->countH($Q[$qcc]['id'],0,0,0,1);
		$hc_ok=$QUEUE->countH($Q[$qcc]['id'],0,0,0,2);
		$hc_view=$QUEUE->countH($Q[$qcc]['id'],0,0,0,3);
		$hc_fail=$QUEUE->countH($Q[$qcc]['id'],0,0,0,4);
	}

	$GRP=$ADDRESS->getGroup($Q[$qcc]['grp_id']);
	$NL=$NEWSLETTER->getNL($Q[$qcc]['nl_id']);
	$send_at=$Q[$qcc]['send_at'];//ist datetime feld!!! deswegen keine umformatierung!
	$created_date=$Q[$qcc]['created'];
	$sent_date="--";
	if (!empty($Q[$qcc]['sent'])) {
		$sent_date=$Q[$qcc]['sent'];
	}

	$author=$Q[$qcc]['author'];

	$logfilename="q_".$Q[$qcc]['id']."_".$Q[$qcc]['grp_id']."_".date_convert_to_string($Q[$qcc]['created']).".log.html";
	$logfile=$tm_logpath."/".$logfilename;
	$logfileURL=$tm_URL_FE."/".$tm_logdir."/".$logfilename;

	$sendURLPara->addParam("q_id",$Q[$qcc]['id']);
	$sendURLPara_=$sendURLPara->getAllParams();

	$showhistURLPara->addParam("q_id",$Q[$qcc]['id']);
	$showhistURLPara_=$showhistURLPara->getAllParams();

	$delURLPara->addParam("q_id",$Q[$qcc]['id']);
	$delURLPara_=$delURLPara->getAllParams();

	$dellogURLPara->addParam("q_id",$Q[$qcc]['id']);
	$dellogURLPara_=$dellogURLPara->getAllParams();

	$stopURLPara->addParam("q_id",$Q[$qcc]['id']);
	$stopURLPara_=$stopURLPara->getAllParams();

	$continueURLPara->addParam("q_id",$Q[$qcc]['id']);
	$continueURLPara_=$continueURLPara->getAllParams();

	$statURLPara->addParam("q_id",$Q[$qcc]['id']);
	$statURLPara_=$statURLPara->getAllParams();


	$_MAIN_OUTPUT.= "<tr id=\"row_".$qcc."\"  bgcolor=\"".$bgcolor."\"  onmouseover=\"setBGColor('row_".$qcc."','".$row_bgcolor_hilite."');\" onmouseout=\"setBGColor('row_".$qcc."','".$bgcolor."');\">";

	$_MAIN_OUTPUT.= "<td onmousemove=\"showToolTip('tt_q_list_".$Q[$qcc]['id']."')\" onmouseout=\"hideToolTip();\">";

	//wenn q running der fertig, history daten anzeigen
	if ($Q[$qcc]['status']>1) {
	}


	$_MAIN_OUTPUT.=sprintf(___("Versand startet: %s"),"<b>".$send_at."</b>");
	//wenn versendet
	if ($Q[$qcc]['status']==4) {
		$_MAIN_OUTPUT.=" / <b>".$sent_date."</b>";
	}


	$_MAIN_OUTPUT.= "</td>";

	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= display($NL[0]['subject']);
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= display($GRP[0]['name']);

	$_MAIN_OUTPUT.= "<div id=\"tt_q_list_".$Q[$qcc]['id']."\" class=\"tooltip\">";
	$_MAIN_OUTPUT.="<b>".display($NL[0]['subject'])."</b>";
	$_MAIN_OUTPUT.="<br>".sprintf(___("An Gruppe: %s"),"<b>".display($GRP[0]['name'])."</b>");
	$_MAIN_OUTPUT.= "<br>ID: ".$Q[$qcc]['id']." ";
	$_MAIN_OUTPUT.= "<br>".tm_icon($STATUS['q']['statimg'][$Q[$qcc]['status']],$STATUS['q']['status'][$Q[$qcc]['status']])."&nbsp;".$STATUS['q']['status'][$Q[$qcc]['status']];
	$_MAIN_OUTPUT.="<br>".sprintf(___("Erstellt am: %s"),"<b>".$created_date."</b>");
	$_MAIN_OUTPUT.="<br>".sprintf(___("Versand startet am/um: %s"),"<b>".$send_at."</b>");
	$_MAIN_OUTPUT.="<br>".sprintf(___("Erstellt von: %s"),"<b>".$Q[$qcc]['author']."</b>");
	if ($Q[$qcc]['status']>1) {
		$_MAIN_OUTPUT .="<br>".
								___("Adressen: ").$hc.
								"<br>".___("Wartend: ").$hc_new.
								"<br>".___("Gesendet: ").$hc_ok.
								"<br>".___("Fehler: ").$hc_fail.
								"<br>".___("versendet am: ").$sent_date.
								"<br>".___("Angezeigt: ").$hc_view.
								"";
	}
	$_MAIN_OUTPUT.= "</div>";

	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	if ($Q[$qcc]['status']==3) {
		$_MAIN_OUTPUT.= "<blink>";
	}
	$_MAIN_OUTPUT.= tm_icon($STATUS['q']['statimg'][$Q[$qcc]['status']],$STATUS['q']['descr'][$Q[$qcc]['status']])."&nbsp;".$STATUS['q']['status'][$Q[$qcc]['status']];
	if ($Q[$qcc]['status']==3) {
		$_MAIN_OUTPUT.= "</blink>";
	}



	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	//wenn status q ok, =1 , neu, und newsletter aktiv, dann einzelnen sendebutton anzeigen!
	if ($Q[$qcc]['status']==1 && $NL[0]['aktiv']==1) {
		$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$tm_URL."/".$sendURLPara_."\" title=\"".___("Newsletter an gewählte Gruppe versenden")."\">".tm_icon("email_go.png",___("Senden"))."</a>";
	}

	if ($Q[$qcc]['status']==4) {
	}

//anhalten, weitermachen
	if ($Q[$qcc]['status']==5) {
		//angehalten, weitermachen
		$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$tm_URL."/".$continueURLPara_."\" onclick=\"return confirmLink(this, '".sprintf(___("Q ID: %s starten ?"),$Q[$qcc]['id'])."')\" title=\"".___("Q erneut starten und fortfahren")."\">".tm_icon("control_play.png",___("Fortfahren"))."</a>";
	}
	if ($Q[$qcc]['status']==2 || $Q[$qcc]['status']==3) { //gestartet oder running!
		//q laeuft, anhalten
		$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$tm_URL."/".$stopURLPara_."\" onclick=\"return confirmLink(this, '".sprintf(___("Q ID: %s anhalten und Versand stoppen?"),$Q[$qcc]['id'])."')\" title=\"".___("Q stoppen")."\">".tm_icon("control_stop.png",___("Q stoppen"))."</a>";
	}


	if (file_exists($logfile)) {
		if ($Q[$qcc]['status']==3) {
			$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$logfileURL."\" target=\"_blank\" title=\"".___("Logfile anzeigen (nicht vollständig)")."\">".tm_icon("script_lightning.png",___("Logfile anzeigen"))."</a>";
		} else {
			$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$logfileURL."\" target=\"_blank\" title=\"".___("Logfile anzeigen")."\">".tm_icon("script.png",___("Logfile anzeigen"))."</a>";
			$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$tm_URL."/".$dellogURLPara_."\" onclick=\"return confirmLink(this, '".sprintf(___("Logfile fuer Q %s löschen?"),$Q[$qcc]['id'])."')\"  title=\"".___("Logfile löschen")."\">".tm_icon("script_delete.png",___("Logfile löschen"))."</a>";
		}
	}

	//loeschen
	$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$tm_URL."/".$delURLPara_."\" onclick=\"return confirmLink(this, '".sprintf(___("Q ID: %s löschen?"),$Q[$qcc]['id'])."')\" title=\"".___("Q löschen")."\">".tm_icon("cross.png",___("Q löschen"))."</a>";

	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "</tr>";
}

$_MAIN_OUTPUT.= "</tbody></table>";

include_once(TM_INCLUDEPATH."/queue_list_legende.inc.php")
?>