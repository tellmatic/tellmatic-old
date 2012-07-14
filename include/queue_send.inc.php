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

$_MAIN_DESCR=___("Newsletter versenden");
$_MAIN_MESSAGE.="";

require_once (TM_INCLUDEPATH."/queue_vars.inc.php");

$QUEUE=new tm_Q();
$NEWSLETTER=new tm_NL();
$ADDRESS=new tm_ADR();
//q starten?
if (!isset($startq)) {
	$startq=getVar("startq");
}
//wenn nl id dann queue ids fuer diesen newsletter ermitteln
if (!isset($nl_id)) {
	//damit wir es in queue_new includen koennen.....dort setzen wird diese werte
	$nl_id=getVar("nl_id");
}
if (!isset($q_id)) {
	$q_id=getVar("q_id");
}
if (!isset($grp_id)) {
	$grp_id=getVar("grp_id");
}
//wenn neue q, nur neue q's checken
if (isset($new_q_arr[0])) {//0 weil min. 1 id
	$start_queue=true;
	$q_arr=$new_q_arr;
	if (DEBUG) $_MAIN_MESSAGE.="<br>Fall 1: neue queue<br>";
}
//keine neue q, wenn nl_id und keine q_id, q's aus nl holen
if (!isset($new_q_arr[0])) {
	if (check_dbid($nl_id) && !check_dbid($q_id)) {
		#$q_arr=$QUEUE->getQID($nl_id);//nl_id
		$q_arr=$QUEUE->getQ(0,0,0,$nl_id);//nl_id
		if (DEBUG) $_MAIN_MESSAGE.="<br>Fall 2: newsletter<br>";
	}
	//wenn keine neue q, und q_id, dann q[0] = q_id
	if (check_dbid($q_id)) {
		#$q_arr[0]=$q_id;
		$q_arr[0]['id']=$q_id;
		if (DEBUG) $_MAIN_MESSAGE.="<br>Fall 3: queue<br>";
	}
	if (check_dbid($grp_id)) {
		$q_arr=$QUEUE->getQ(0,0,0,0,$grp_id);//grp_id
		if (DEBUG) $_MAIN_MESSAGE.="<br>Fall 4: group<br>";
	}
}
$qc=count($q_arr);//wieviel q eintraege gibt es?
$_MAIN_MESSAGE.="<br>".___("Empfängerliste wird generiert.");
$ac_total_ok=0;//gesamtanzahl adressen die eingetragen werden/wurden
$ac_total_ok=0;//gesamtanzahl adressen die eingetragen werden/wurden

if (DEBUG) $_MAIN_MESSAGE.= "\nq_arr:\n";
if (DEBUG) $_MAIN_MESSAGE.=print_r($q_arr,TRUE);
$HQTimer=new Timer();//zeitmessung startet hier
for ($qcc=0;$qcc<$qc;$qcc++) {
	//queue eintraege auslesen
	if (DEBUG) $_MAIN_MESSAGE.= "\nqcc= ".$qcc."\n";
	if (DEBUG) $_MAIN_MESSAGE.= "q_arr[qcc]\n";
	if (DEBUG) $_MAIN_MESSAGE.=print_r($q_arr[$qcc],TRUE);
	$Q=$QUEUE->getQ($q_arr[$qcc]['id']);//liefert je 1 eintrag $Q[0][]
	if (DEBUG) $_MAIN_MESSAGE.= "\nq 0 id: ".$Q[0]['id']."\n";
	if (DEBUG) $_MAIN_MESSAGE.= "\nQ:\n";
	if (DEBUG) $_MAIN_MESSAGE.=print_r($Q,TRUE);
	$HOST=$HOSTS->getHost($Q[0]['host_id']);
	if (DEBUG) $_MAIN_MESSAGE.= "\nHOST:\n";
	if (DEBUG) $_MAIN_MESSAGE.=print_r($HOST,TRUE);
	$GRP=$ADDRESS->getGroup($Q[0]['grp_id']);
	if (DEBUG) $_MAIN_MESSAGE.= "\nGRP:\n";
	if (DEBUG) $_MAIN_MESSAGE.= print_r($GRP,TRUE);
	

//hier pruefung ob host, nl und gruppen ueberhaupt noch existieren...... sonst undefined index wenn ein spassvogel die hosts oder nl oder adrgrp etc loescht
	
	if ($qcc==0) $_MAIN_MESSAGE.="<br>".sprintf(___("Ausgewählter Mail-Server: %s"),$HOST[0]['name']);//nur erster durchlauf
	//wenn status ok, also neu 1, gestartet 2 oder angehalten 5
	//dann neu eintrag in sendeliste/history, q_id, nl_id, grp_id, adr_id
	if ($Q[0]['status']==1 || $Q[0]['status']==2 || $Q[0]['status']==5 ) {
		$NL=$NEWSLETTER->getNL($Q[0]['nl_id'],0,0,0,0);
		if (DEBUG) echo "\nNL:\n";
		if (DEBUG) print_r($NL);
		//wenn das Newsletter auch wirklich aktiv ist......
		if ($NL[0]['aktiv']==1) {
			$_MAIN_MESSAGE.="<br>&nbsp;&nbsp;'<b><em>".display($NL[0]['subject'])."</em></b>'";
			$_MAIN_MESSAGE.="&nbsp;&nbsp;==&gt;&nbsp;&nbsp;'<b>".display($GRP[0]['name'])."</b>'";
				$hc_fastinsert=$QUEUE->addHQ( Array ( 'nl_id' => $Q[0]['nl_id'],
																				'q_id' => $Q[0]['id'],
																				'grp_id' =>$Q[0]['grp_id'],
																				'host_id' =>$Q[0]['host_id'],
																				'status' => 1,
																				'created' => date("Y-m-d H:i:s")
																				)
																		);
				$hqtime=$HQTimer->MidResult();
				if (DEBUG) $_MAIN_MESSAGE.= "\nhc_fastinsert:\n";
				if (DEBUG) $_MAIN_MESSAGE.=print_r($hc_fastinsert,TRUE);
				if ($hc_fastinsert[0]) {
					if (DEBUG) $_MAIN_MESSAGE.="<br>num rows:".$hc_fastinsert[1]."<br>affected rows:".$hc_fastinsert[2];
					$_MAIN_MESSAGE.="<br>".sprintf(___("%s Einträge eingefügt."),$hc_fastinsert[2]);
					$_MAIN_MESSAGE.="<br>".sprintf(___("Benötigte Zeit: %s Sekunden"),number_format($hqtime,2,".",""));
					//status der Q und NL auf gestartet setzen!
					$NEWSLETTER->setStatus($Q[0]['nl_id'],6);
					//start q?
					if ($startq==1) $QUEUE->setStatus($Q[0]['id'],2);
					$ac_total_ok+=$hc_fastinsert[2];
				} else {
					$_MAIN_MESSAGE.="<br>".___("Fehler beim anlegen der Versandliste!");
				}
		} else {//newsletter aktiv
			$_MAIN_MESSAGE.="<br>".sprintf(___("Newsletter %s ist nicht aktiv."),"<b>".display($NL[0]['subject'])."</b>");
		}//newsletter aktiv
	} else {//q status=1
		#$_MAIN_MESSAGE.="<br>".("Dieser Versandauftrag wurde bereits bearbeitet.");
	}//q status=1
}//for qcc, queues
$hqtime_total=$HQTimer->Result();

$_MAIN_MESSAGE.="<br>";

$_MAIN_MESSAGE.="<br>".sprintf(___("Es wurden %s gültige Adressen für den Versand vorbereitet."),"<b>".$ac_total_ok."</b>");
$_MAIN_MESSAGE.="<br>".sprintf(___("Insgesamt benötigte Zeit: %s Sekunden"),number_format($hqtime_total,2,".",""));
$_MAIN_MESSAGE.="<br>".___("Der Versand wurde vorbereitet!");
//show q list instead
require_once (TM_INCLUDEPATH."/queue_list.inc.php");

?>