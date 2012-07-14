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

$_MAIN_DESCR="Newsletter versenden";
$_MAIN_MESSAGE.="";

$set=getVar("set");
$val=getVar("val");
$doit=getVar("doit");//wird per js an url angefuegt!!! confirm()

$QUEUE=new mnlQ();
$NEWSLETTER=new mnlNL();
$ADDRESS=new mnlADR();

//wenn nl id dann queue ids fuer diesen newsletter ermitteln
if (!empty($nl_id)) {
	//damit wir es in queue_new includen koennen.....dort setzen wird diese werte
	$nl_id=getVar("nl_id");
}
if (!empty($q_id)) {
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

$_MAIN_MESSAGE.="<br>Empfaengerliste wird generiert.";

for ($qcc=0;$qcc<$qc;$qcc++) {
	//queue eintraege auslesen
	$Q=$QUEUE->getQ($q_arr[$qcc]);//liefert je 1 eintrag $Q[0][]
	//wenn status ok, also neu (oder evtl. auch gesendet)
	//dann neu eintrag in sendeliste/history, q_id, nl_id, grp_id, adr_id
	if ($Q[0]['status']==1) {
		$NL=$NEWSLETTER->getNL($Q[0]['nl_id'],0,0,0,0);
		//wenn das Newsletter auch wirklich aktiv ist......
		if ($NL[0]['aktiv']==1) {
			$_MAIN_MESSAGE.="<br>&nbsp;&nbsp;".$NL[0]['subject'];
			$GRP=$ADDRESS->getGroup($Q[0]['grp_id']);
			$ADR=$ADDRESS->getAdr(0,0,0,$Q[0]['grp_id']);
			$ac=count($ADR);//anzahl adressen
			$ac_ok=0;//anzahl adressen die eingetragen werden/wurden
			$ac_fail=0;//anzahl adressen die nicht eingetragen werden/wurden
			$ac_double=0;//anzahl adr die bereits fuer dieses newsletter in der sendeliste vorhanden sind mit status =1 , neu
			$created=date("Y-m-d H:i:s");
			$status=1;//neu

			for ($acc=0;$acc<$ac;$acc++) {
				//wenn adresse nicht inaktiv und nicht unsubscribed und nicht fehlerhaft etc, dann in history aufnehmen
				//status=1 //neu
				if ($ADR[$acc]['aktiv']==1 && $ADR[$acc]['errors']<=$max_mails_retry) {
					if ($ADR[$acc]['status']==1 || $ADR[$acc]['status']==2 || $ADR[$acc]['status']==3 || $ADR[$acc]['status']==4 || $ADR[$acc]['status']==10 || $ADR[$acc]['status']==12) {
						//pruefen ob adresse schon in history vorhanden mit status neu=1, wenn ja , nicht hinzufuegen, den rest schon, auch wenn bereits gesendet!
						$Hnew=$QUEUE->getH(0,0,0,0,$Q[0]['nl_id'],0,$ADR[$acc]['id'],1);
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
			}//for, adressen
			$_MAIN_MESSAGE.="<br>&nbsp;&nbsp;&nbsp;&nbsp;
				Es wurden ".$ac_ok." Adressen aus der Gruppe ".$GRP[0]['name']." eingetragen";
			$_MAIN_MESSAGE.="<br>&nbsp;&nbsp;&nbsp;&nbsp;
				".$ac_fail." Adressen wurden uebersprungen (inaktiv, abgemeldet, fehlerhaft).";
			$_MAIN_MESSAGE.="<br>&nbsp;&nbsp;&nbsp;&nbsp;
				".$ac_double." Adressen wurden uebersprungen (bereits eingetragen).";
			//status der Q und NL auf gestartet setzen!
			$NEWSLETTER->setStatus($Q[0]['nl_id'],6);
			$QUEUE->setStatus($q_arr[$qcc],2);
		}//newsletter aktiv
	}//q status=1
	
}//for qcc, queues
$_MAIN_MESSAGE.="<br>Der Versand wurde gestartet!";
$action="nl_list";
include_once ($mnl_includepath."/nl_list.inc");
?>
