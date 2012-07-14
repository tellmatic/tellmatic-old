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

//wenn nl id dann queue ids fuer diesen newsletter ermitteln
if (!isset($nl_id)) {
	//damit wir es in queue_new includen koennen.....dort setzen wird diese werte
	$nl_id=getVar("nl_id");
}
if (!isset($q_id)) {
	$q_id=getVar("q_id");
}

if ($nl_id>0) {
	$q_arr=$QUEUE->getQID($nl_id);//nl_id
} else {
	//wenn keine nl_id aber q_id dann erster array eintrag in qliste = diese id
		if ($q_id>0) {
			$q_arr[0]=$q_id;
		}
}

$qc=count($q_arr);//wieviel q eintraege gibt es?

$_MAIN_MESSAGE.="<br>".___("Empfängerliste wird generiert.");

$ac_total=0;//zaehler fuer adressen gesamt, auch fehlerhafte, und doppelte, dient nur als gesamtzaehler
$ac_total_ok=0;//gesamtanzahl adressen die eingetragen werden/wurden
$ac_total_fail=0;//gesamtanzahl adressen die nicht eingetragen werden/wurden
$ac_total_double=0;//gesamtanzahl adr die bereits fuer dieses newsletter in der sendeliste vorhanden sind mit status =1 , neu

for ($qcc=0;$qcc<$qc;$qcc++) {
	//queue eintraege auslesen
	$Q=$QUEUE->getQ($q_arr[$qcc]);//liefert je 1 eintrag $Q[0][]
	//wenn status ok, also neu (oder evtl. auch gesendet)
	//dann neu eintrag in sendeliste/history, q_id, nl_id, grp_id, adr_id
	if ($Q[0]['status']==1) {
		$NL=$NEWSLETTER->getNL($Q[0]['nl_id'],0,0,0,0);
		//wenn das Newsletter auch wirklich aktiv ist......
		if ($NL[0]['aktiv']==1) {
			$GRP=$ADDRESS->getGroup($Q[0]['grp_id']);
			$_MAIN_MESSAGE.="<br>&nbsp;&nbsp;'<b><em>".display($NL[0]['subject'])."</em></b>'";
			$_MAIN_MESSAGE.="&nbsp;&nbsp;==&gt;&nbsp;&nbsp;'<b>".display($GRP[0]['name'])."</b>'";
			//auslesen in haeppchen aufteilen, limitieren auf xxxx adr pro durchlauf :)
			$q_limit=$adr_row_limit*2;
			//	function countADR($group_id=0,$search=Array()) {
			$q_total=$ADDRESS->countADR($Q[0]['grp_id']);;//gesamtzahl der adressen
			//loop 1 , limit + offset

			$ac_ok=0;//anzahl adressen die eingetragen werden/wurden
			$ac_fail=0;//anzahl adressen die nicht eingetragen werden/wurden
			$ac_double=0;//anzahl adr die bereits fuer dieses newsletter in der sendeliste vorhanden sind mit status =1 , neu

			for ($q_offset=$usr_offset; $q_offset <= $q_total; $q_offset+=$q_limit) {//war $q_offset=0
				//						^^ usr_offset addieren
				//loop, mit speicherabhaengigen offset und limit damit der array fuer adressen nicht zu gross wird, zusaetzlich usr_limit fuer haeppchenweises einlesen der adressen, wegen max_exec_time fuer php :P
				//function getAdr($id=0,$offset=0,$limit=0,$group_id=0,$search=Array(),$sortIndex="",$sortType=0,$Details=1) {
				#$ADR=$ADDRESS->getAdr(0,0,0,$Q[0]['grp_id']);
				//problem ist und bleibt die execution time, bei 30sek wird laut berichten nur bis zum 25.000 datensatz eingetragen und dann bricht php ab... versandauftrag ist unvollstaendig
				//loesung: user limit und offset im formular zur verfuegung stellen, vorgaben je nach php memory....bei 8mb und 30sekunden max 20k adressen
				//abbruch wenn  per exec time von 30 sek 20k limit ueberschritten wird.

				//hier pruefung ob usr_limit beim aktuellen durchlauf ueberschritten wuerde, wenn ja brechen wir ab
				//jetzt adressen holen:
				$ADR=$ADDRESS->getAdr(0,$q_offset,$q_limit,$Q[0]['grp_id'],Array(),"",0,0);//No Details
				if (DEBUG && function_exists('memory_get_usage')) {
						$_MAIN_MESSAGE.="<br>".sprintf(___("Benutzer Speicher: %s MB"),number_format((memory_get_usage()/1024/1024), 2, ',', ''));
				}
				$ac=count($ADR);//anzahl adressen
				$created=date("Y-m-d H:i:s");
				$status=1;//neu

				for ($acc=0;$acc<$ac;$acc++) {
					$ac_total++;
					//^^ zaehler
					// wenn adresse nicht inaktiv und nicht unsubscribed und nicht fehlerhaft etc, dann in history aufnehmen
					// status=1 //neu
					if ($ADR[$acc]['aktiv']==1 && $ADR[$acc]['errors']<=$max_mails_retry) {
						if ($ADR[$acc]['status']==1 || $ADR[$acc]['status']==2 || $ADR[$acc]['status']==3 || $ADR[$acc]['status']==4 || $ADR[$acc]['status']==10 || $ADR[$acc]['status']==12) {
							// 3 - create q, queue_send.inc: optimierung, preselect adr_id aus adr die noch keinen eintrag haben mit status 1 etc  und ok sind, diese liste dann im bulk mode eintragen
							// hier leider sehr inperformant:
							// pruefen ob adresse schon in history vorhanden mit status neu=1, wenn ja , nicht hinzufügen den rest schon, auch wenn bereits gesendet!
							$Hnew=$QUEUE->getH(0,0,0,0,$Q[0]['nl_id'],0,$ADR[$acc]['id'],1);
							//kann ggf beschleunigt werden indem man vorher selectoert, s.o. und dann dieses im bulk einfuegt.
							//getH($id=0,$offset=0,$limit=0,$q_id=0,$nl_id=0,$grp_id=0,$adr_id=0,$status=0)
							$hc_new=count($Hnew);
							if ($hc_new==0) {
												$QUEUE->addH(ARRAY(
													"created"=>$created,
													"status"=>$status,
													"q_id"=>$Q[0]['id'],
													"grp_id"=>$Q[0]['grp_id'],
													"nl_id"=>$Q[0]['nl_id'],
													"adr_id"=>$ADR[$acc]['id']
												));
												$ac_ok++;
							} else {
								$ac_double++;
							}
						} else {//adr status
							$ac_fail++;
						}
					} else {//adr_aktiv
							$ac_fail++;
					}//adr aktiv
				}//for, adressen $acc
			}//q_offset
			$ac_total_ok+=$ac_ok;
			$ac_total_double+=$ac_double;
			$ac_total_fail+=$ac_fail;

			$_MAIN_MESSAGE.="<br>&nbsp;&nbsp;&nbsp;&nbsp;".
				sprintf(___("%s Adressen Gesamt in Gruppe %s"),"<b>".$q_total."</b>","'<b>".display($GRP[0]['name'])."</b>'");
			$_MAIN_MESSAGE.="<br>&nbsp;&nbsp;&nbsp;&nbsp;".
				sprintf(___("Es wurden %s Adressen aus der Gruppe %s eingetragen"),"<b>".$ac_ok."</b>","'<b>".display($GRP[0]['name'])."</b>'");
			$_MAIN_MESSAGE.="<br>&nbsp;&nbsp;&nbsp;&nbsp;".
				sprintf(___("%s Adressen wurden übersprungen (inaktiv, fehler)."),"<b>".$ac_fail."</b>");
			$_MAIN_MESSAGE.="<br>&nbsp;&nbsp;&nbsp;&nbsp;".
				sprintf(___("%s Adressen wurden übersprungen (bereits eingetragen)."),"<b>".$ac_double."</b>");
			//status der Q und NL auf gestartet setzen!
			$NEWSLETTER->setStatus($Q[0]['nl_id'],6);
			$QUEUE->setStatus($q_arr[$qcc],2);
		}//newsletter aktiv
	}//q status=1

}//for qcc, queues
$_MAIN_MESSAGE.="<br>";
$_MAIN_MESSAGE.="<br>".sprintf(___("Es wurden insgesamt %s Adressen dursucht."),"<b>".$ac_total."</b>");
$_MAIN_MESSAGE.="<br>".sprintf(___("%s Adressen wurden übersprungen (inaktiv, fehler)."),"<b>".$ac_total_fail."</b>");
$_MAIN_MESSAGE.="<br>".sprintf(___("%s Adressen wurden übersprungen (bereits eingetragen)."),"<b>".$ac_total_double."</b>");
$_MAIN_MESSAGE.="<br>".sprintf(___("Es wurden %s gültige Adressen für den Versand vorbereitet."),"<b>".$ac_total_ok."</b>");	

$_MAIN_MESSAGE.="<br><br>".___("Der Versand wurde gestartet!");
$action="nl_list";
#require_once (TM_INCLUDEPATH."/nl_list.inc.php");
//show q list instead
require_once (TM_INCLUDEPATH."/queue_list.inc.php");

?>