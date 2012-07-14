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

$_MAIN_DESCR="Newsletter zur Warteschlange (Q) hinzufuegen";
$_MAIN_MESSAGE.="";

$set=getVar("set");
$q_id=0;
$nl_id=getVar("nl_id");
$created=date("Y-m-d H:i:s");
$author=$_SERVER['PHP_AUTH_USER'];
$status=1;
//field names for query

$InputName_NL="nl_id";//range from
$$InputName_NL=getVar($InputName_NL);

$InputName_SendAt="send_at_date";//range from
$$InputName_SendAt=getVar($InputName_SendAt);
if (empty($$InputName_SendAt)) {
	$$InputName_SendAt=date("Y-m-d");
}

$InputName_SendAtTimeH="send_at_h";//range from
$$InputName_SendAtTimeH=getVar($InputName_SendAtTimeH);
if (empty($$InputName_SendAtTimeH)) {
	$$InputName_SendAtTimeH=date("H");
}
$InputName_SendAtTimeM="send_at_m";//range from
$$InputName_SendAtTimeM=getVar($InputName_SendAtTimeM);
if (empty($$InputName_SendAtTimeM)) {
	$$InputName_SendAtTimeM=date("i");
}



$InputName_Group="adr_grp";//range from
pt_register("POST","adr_grp");
if (!isset($adr_grp)) {
	$adr_grp=Array();
}

$InputName_Send="send_now";//range from
$$InputName_Send=getVar($InputName_Send);


$check=true;
if ($set=="save") {

	$gc=count($adr_grp);
	//sind ueberhaupt gruppen gewaehlt???
	if ($gc>0) {
		$QUEUE=new mnlQ();
		$ADDRESS=new mnlADR();
		//nur q eintraege hinzufuegen die noch nicht vorhanden sind oder status gesendet haben
		//status gesendet=4, 
		//NICHT:    neu=1, gestartet/wait=2, running=3
		//fuer jede gruppe im array adr_grp!
		for ($gcc=0;$gcc<$gc;$gcc++) {
		
			$grp_id=$adr_grp[$gcc];
			$GRP=$ADDRESS->getGroup($grp_id);
					
			$Qnew=$QUEUE->getQ(0,0,0,$nl_id,$grp_id,1);
			$qc_new=count($Qnew);
			if ($qc_new!=0) { //gefunden ? nicht hinzufuegen
				unset($adr_grp[$gcc]);
				$_MAIN_MESSAGE.="<br>Fuer die Gruppe ".$GRP[0]['name']." existieren bereits ".$qc_new." neue Eintraege. Nicht hinzugefuegt!";
			} else {//qnew!=0
				$Qwait=$QUEUE->getQ(0,0,0,$nl_id,$grp_id,2);
				$qc_wait=count($Qwait);
				if ($qc_wait!=0) { //
					unset($adr_grp[$gcc]);
					$_MAIN_MESSAGE.="<br>Fuer die Gruppe ".$GRP[0]['name']." existieren bereits ".$qc_wait." gestartete/wartende Eintraege. Nicht hinzugefuegt!";
				} else {//qwait!=0		
					$Qrun=$QUEUE->getQ(0,0,0,$nl_id,$grp_id,3);
					$qc_run=count($Qrun);
					if ($qc_run!=0) { //
						unset($adr_grp[$gcc]);
						$_MAIN_MESSAGE.="<br>Fuer die Gruppe ".$GRP[0]['name']." existieren bereits ".$qc_run." laufende Eintraege. Nicht hinzugefuegt!";
					}//qrun!=0
				}
			}//$qnew=0		

			//natuerlich macht es nur sinn die gruppe in die q aufzunehmen und fuer den versand vorzubereiten wenn diese gruppe auch ein paar aressen enthaelt, also aktive adressen die nihct unsubscribed sind etc.
			//das wird zwar beim versand und erstellen der sendeliste auch geprueft, jedoch koennen die zeiten zu denen beide listen angelegt werden variieren. --> manuelles anlegen der history
			//wir wollen aber wirklich nur gruppen aufnehmen ind enen taugliche adressen existieren.
			//Adr status=1 oder 2 oder 3 oder 4
			//und nur aktive
			$search['aktiv']=1;			
			$ac=0;//gefundene adressen insgesamt
			for ($stat=1; $stat<=4;$stat++) {
				$search['status']=$stat;
				$ac +=$ADDRESS->countADR($grp_id,$search);
			}
			//und status 10!
			$search['status']=10;
			$ac +=$ADDRESS->countADR($grp_id,$search);
			//und status 12!
			$search['status']=12;
			$ac +=$ADDRESS->countADR($grp_id,$search);
			

			//keine benutzbaren adressen gefunden 
			if ($ac==0) {
				unset($adr_grp[$gcc]);
				$_MAIN_MESSAGE.="<br>In der  Gruppe ".$GRP[0]['name']." existieren keine gueltigen Adressen. Nicht hinzugefuegt!";
			} else {
				$_MAIN_MESSAGE.="<br>In der  Gruppe ".$GRP[0]['name']." existieren $ac gueltige Adressen. Gruppe hinzugefuegt!";
			}
			//
		}//for gcc
						
		//array neu indizieren, indexe neu erstellen.....
		$adr_grp= array_values($adr_grp);
		
		//neu zaehlen...
		$gc=count($adr_grp);
		//sind ueberhaupt noch gruppen gewaehlt???
		if ($gc>0) {
		
			
		
			$send_at=$send_at_date." ".$send_at_h.":".$send_at_m.":00";
			$QUEUE->addQ(Array(
					"created"=>$created,
					"author"=>$author, 
					"status"=>$status, 
					"nl_id"=>$nl_id,
					"send_at"=>$send_at
					),
					$adr_grp);
			//nl auf status queued setzen =2/6=terminiert
			$NEWSLETTER=new mnlNL();
			$NEWSLETTER->setStatus($nl_id,6);//war 2, ist 6 fuer terminierten versand!!
			$_MAIN_MESSAGE.="<br>Neuer Eintrag wurde erstellt.";
			$action="queue_list";
			if ($send_now==1) {
				include_once ($mnl_includepath."/queue_send.inc");				
			}
			include_once ($mnl_includepath."/nl_list.inc");
		} else {// $gc>0
			$_MAIN_MESSAGE.="<br>Keine Gruppe(n) gewaehlt. Nichts hinzugefuegt";
			include_once ($mnl_includepath."/queue_form.inc");
		}
	} else {
		include_once ($mnl_includepath."/queue_form.inc");
	}//$gc>0
} else {
	include_once ($mnl_includepath."/queue_form.inc");
}
?>