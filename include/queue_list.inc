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

$_MAIN_DESCR="Newsletter Warteschlange (Q)";
$_MAIN_MESSAGE.="";

$QUEUE=new mnlQ();

$set=getVar("set");
$val=getVar("val");
$q_id=getVar("q_id");
$nl_id=getVar("nl_id");
$doit=getVar("doit");//wird per js an url angefuegt!!! confirm()

$ADDRESS=new mnlADR();
$NEWSLETTER=new mnlNL();



if (!empty($q_id)) {
	$Q=$QUEUE->getQ($q_id);
	$logfilename="q_".$Q[0]['id']."_".$Q[0]['grp_id']."_".date_convert_to_string($Q[0]['created']).".log.html";
}
if ($set=="stop" && $doit==1 && !empty($q_id)) {
	$QUEUE->setStatus($q_id,5);
	$LOG="<br>\n\n".date("d-m-Y H:i:s")." ---- Q ID $q_id wurde angehalten.\n\n<br>";
	update_file($mnl_logpath,$logfilename,$LOG);
}
if ($set=="continue" && $doit==1 && !empty($q_id)) {
	$QUEUE->setStatus($q_id,2);
	$LOG="<br>\n\n".date("d-m-Y H:i:s")." ---- Q ID $q_id wird fortgesetzt.\n\n<br>";
	update_file($mnl_logpath,$logfilename,$LOG);
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
	$QUEUE->delQ($q_id);
	$_MAIN_MESSAGE.="<br>Eintrag wurde geloescht.";
}

if ($set=="delete_log" && $doit==1) {
	$Q=$QUEUE->getQ($q_id);
	if (@unlink($mnl_logpath."/".$logfilename)) {
		$_MAIN_MESSAGE.="<br>Logfile wurde geloescht.";
	} else {
		$_MAIN_MESSAGE.="<br>Logfile konnte nicht geloescht werden.";
	}
}

//q f. liste holen
if ($nl_id>0) {
	$NL=$NEWSLETTER->getNL($nl_id);
	$_MAIN_MESSAGE.="<br>gewaehltes Newsletter: <b>".$NL[0]['subject']."</b>";
	$Q=$QUEUE->getQ(0,0,0,$nl_id);//id offset limit nl_id
} else {
	$Q=$QUEUE->getQ(0,0,0,0);//id offset limit nl_id
}
$qc=count($Q);

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

$_MAIN_OUTPUT="<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" width=100%>";
$_MAIN_OUTPUT.= "<thead>
						<tr>
						<td><b>Datum</b>
						</td>
						<td><b>Newsletter</b>
						</td>
						<td><b>Adressgruppe</b>
						</td>
						<td><b>Status</b>
						</td>
						<td>...</td>
						</tr>
						</thead>
						<tbody>
						";



for ($qcc=0;$qcc<$qc;$qcc++) {
	if ($qcc%2==0) {$bgcolor=$row_bgcolor;} else {$bgcolor=$row_bgcolor2;}

	//wenn q status=2 or 3 // run oder fertig
	//dann holen wir uns die daten fuer die q eintraege! vorher ist eh null... :)
	if ($Q[$qcc]['status']>1) {
		//wenn status > neu, also gestartet, versendet etc, dann summary anzeigen....
		/*
		countH($q_id=0,$nl_id=0,$grp_id=0,$adr_id=0,$status=0)
		*/
		$hc=$QUEUE->countH($Q[$qcc]['id']);
		$hc_new=$QUEUE->countH($Q[$qcc]['id'],0,0,0,1);
		$hc_ok=$QUEUE->countH($Q[$qcc]['id'],0,0,0,2);
		$hc_view=$QUEUE->countH($Q[$qcc]['id'],0,0,0,3);
		$hc_fail=$QUEUE->countH($Q[$qcc]['id'],0,0,0,4);
	}
	
	$GRP=$ADDRESS->getGroup($Q[$qcc]['grp_id']);
	$NL=$NEWSLETTER->getNL($Q[$qcc]['nl_id']);
	$send_at=$Q[$qcc]['send_at'];//ist datetime feld!!! deswegen keine umformatierung!
	//$created_date=strftime("%d-%m-%Y %H:%M:%S",mk_microtime($Q[$qcc]['created']));
	$created_date=$Q[$qcc]['created'];
	$sent_date="--";
	if (!empty($Q[$qcc]['sent'])) {
		//$sent_date=strftime("%d-%m-%Y %H:%M:%S",mk_microtime($Q[$qcc]['sent']));
		$sent_date=$Q[$qcc]['sent'];
	}
	
	$author=$Q[$qcc]['author'];

	$logfilename="q_".$Q[$qcc]['id']."_".$Q[$qcc]['grp_id']."_".date_convert_to_string($Q[$qcc]['created']).".log.html";
	$logfile=$mnl_logpath."/".$logfilename;
	$logfileURL=$mnl_URL."/".$mnl_logdir."/".$logfilename;
	
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
	// onmouseover="setPointer(this, 1, 'over', '#E5E5E5', '#CCFFCC', '#FFCC99');" onmouseout="setPointer(this, 1, 'out', '#E5E5E5', '#CCFFCC', '#FFCC99');" 
	
	$_MAIN_OUTPUT.= "<td onmousemove=\"showToolTip('tt_q_list_".$Q[$qcc]['id']."')\" onmouseout=\"hideToolTip();\">";
	//$_MAIN_OUTPUT.=$created_date;

	//wenn q running der fertig, history daten anzeigen
	if ($Q[$qcc]['status']>1) {
		// $_MAIN_OUTPUT .="<br>&nbsp; Q:".$hc." Wait:".$hc_new." Sent: ".$hc_ok." View:".$hc_view." Err:".$hc_fail;
	}

	//wenn status q ok, =1 , neu, und newsletter aktiv, dann einzelnen sendebutton anzeigen!
	if ($Q[$qcc]['status']==1 && $NL[0]['aktiv']==1) {
		$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$mnl_URL."/".$sendURLPara_."\" title=\"Newsletter an gewaehlte Gruppe versenden\"><img src=\"".$mnl_iconURL."/email_go.png\" border=\"0\"></a>";
	}
	//$_MAIN_OUTPUT.="&nbsp;(".$author.")";
	
	$_MAIN_OUTPUT.="Versand startet: <b>".$send_at."</b>";
	//wenn versendet
	if ($Q[$qcc]['status']==4) {
		//$_MAIN_OUTPUT.="<br>versendet: ".$sent_date."</b>";
		$_MAIN_OUTPUT.=" / <b>".$sent_date."</b>";
	}
	

	$_MAIN_OUTPUT.= "</td>";

	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= $NL[0]['subject'];
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	$_MAIN_OUTPUT.= $GRP[0]['name'];
	
	$_MAIN_OUTPUT.= "<div id=\"tt_q_list_".$Q[$qcc]['id']."\" class=\"tooltip\">";
	$_MAIN_OUTPUT.= "ID: ".$Q[$qcc]['id']." ";
	$_MAIN_OUTPUT.= "<br><img src=\"".$mnl_iconURL."/".$STATUS['q']['statimg'][$Q[$qcc]['status']]."\" border=\"0\">&nbsp;".$STATUS['q']['status'][$Q[$qcc]['status']];
	$_MAIN_OUTPUT.="<br><b>".$NL[0]['subject']."</b>";
	$_MAIN_OUTPUT.="<br><b>".$GRP[0]['name']."</b>";
	$_MAIN_OUTPUT.="<br>erstellt am: ".$created_date."</b>";
	$_MAIN_OUTPUT.="<br>Versand startet: <b>".$send_at."</b>";
	$_MAIN_OUTPUT.="<br>von: ".$author."</b>";
	if ($Q[$qcc]['status']>1) {
		$_MAIN_OUTPUT .="<br><ul>
								Adressen:".$hc." 
								<br>Wartend:".$hc_new." 
								<br>Gesendet: ".$hc_ok."
								<br>Fehler:".$hc_fail."
								<br>versendet am: ".$sent_date."
								<br>Angezeigt:".$hc_view."
								</ul>
								";
	}
	$_MAIN_OUTPUT.= "</div>";
	
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	if ($Q[$qcc]['status']==3) { 
		$_MAIN_OUTPUT.= "<blink>";
	}
	$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/".$STATUS['q']['statimg'][$Q[$qcc]['status']]."\" border=\"0\" title=\"".$STATUS['q']['descr'][$Q[$qcc]['status']]."\" alt=\"".$STATUS['q']['descr'][$Q[$qcc]['status']]."\">&nbsp;".$STATUS['q']['status'][$Q[$qcc]['status']];
	if ($Q[$qcc]['status']==3) { 
		$_MAIN_OUTPUT.= "</blink>";
	}



	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td>";
	if ($Q[$qcc]['status']==4) {
//		$_MAIN_OUTPUT.=  "&nbsp;<a href=\"".$mnl_URL."/".$statURLPara_."\" title=\"Statistik anzeigen\"><img src=\"".$mnl_iconURL."/chart_pie.png\" border=\"0\"></a>";
	}

//anhalten, weitermachen
	if ($Q[$qcc]['status']==5) {
		//angehalten, weitermachen
		$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$mnl_URL."/".$continueURLPara_."\" onclick=\"return confirmLink(this, 'Q ID: ".$Q[$qcc]['id']." starten ?')\" title=\"Q erneut starten und fortfahren\"><img src=\"".$mnl_iconURL."/control_play.png\" border=\"0\"></a>";
	}
	if ($Q[$qcc]['status']==2 || $Q[$qcc]['status']==3) { //gestartet oder running!
		//q laeuft, anhalten
		$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$mnl_URL."/".$stopURLPara_."\" onclick=\"return confirmLink(this, 'Q ID: ".$Q[$qcc]['id']." anhalten und Versand stoppen? ?')\" title=\"Q stoppen\"><img src=\"".$mnl_iconURL."/control_stop.png\" border=\"0\"></a>";
	}


	if (file_exists($logfile)) {
		if ($Q[$qcc]['status']==3) {
			$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$logfileURL."\" target=\"_blank\" title=\"Logfile anzeigen, nicht vollstaendig\"><img src=\"".$mnl_iconURL."/script_lightning.png\" border=\"0\"></a>";
		} else {		
			$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$logfileURL."\" target=\"_blank\" title=\"Logfile anzeigen\"><img src=\"".$mnl_iconURL."/script.png\" border=\"0\"></a>";
			$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$mnl_URL."/".$dellogURLPara_."\" onclick=\"return confirmLink(this, 'Logfile fuer Q ".$Q[$qcc]['id']." loeschen ?')\"  title=\"Logfile loeschen\"><img src=\"".$mnl_iconURL."/script_delete.png\" border=\"0\"></a>";
		}
	}

	//loeschen
	$_MAIN_OUTPUT.= "&nbsp;<a href=\"".$mnl_URL."/".$delURLPara_."\" onclick=\"return confirmLink(this, 'Q ID: ".$Q[$qcc]['id']." loeschen ?')\" title=\"Q loeschen\"><img src=\"".$mnl_iconURL."/cross.png\" border=\"0\"></a>";

	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "</tr>";
}

$_MAIN_OUTPUT.= "<tbody></table>";

include_once($mnl_includepath."/queue_list_legende.inc")
?>