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

$_MAIN_DESCR=___("Newsletter zur Warteschlange (Q) hinzufügen");
$_MAIN_MESSAGE.="";

require_once (TM_INCLUDEPATH."/queue_vars.inc.php");

$q_id=0;
$nl_id=getVar("nl_id");
$created=date("Y-m-d H:i:s");
$author=$LOGIN->USER['name'];
$status=1;

$InputName_NL="nl_id";
$$InputName_NL=getVar($InputName_NL);

$InputName_Host="host_id";
$$InputName_Host=getVar($InputName_Host);

$InputName_SendAt="send_at_date";
$$InputName_SendAt=getVar($InputName_SendAt);
if (empty($$InputName_SendAt)) {
	$$InputName_SendAt=date("Y-m-d");
}

$InputName_SendAtTimeH="send_at_h";
$$InputName_SendAtTimeH=getVar($InputName_SendAtTimeH);
if ($$InputName_SendAtTimeH=="") {
	$$InputName_SendAtTimeH=date("H");
}
$InputName_SendAtTimeM="send_at_m";
$$InputName_SendAtTimeM=getVar($InputName_SendAtTimeM);
if ($$InputName_SendAtTimeM=="") {
	$$InputName_SendAtTimeM=date("i");
}

$InputName_Group="adr_grp";
pt_register("POST","adr_grp");
if (!isset($adr_grp)) {
	$adr_grp=Array();
}

$InputName_Send="send_now";
$$InputName_Send=getVar($InputName_Send);

$InputName_Autogen="autogen";
$$InputName_Autogen=getVar($InputName_Autogen);

$InputName_Blacklist="check_blacklist";
$$InputName_Blacklist=getVar($InputName_Blacklist);

$InputName_Proof="proof";
$$InputName_Proof=getVar($InputName_Proof);


$check=true;
//abgeschickt?
if ($set=="save") {
	if (!empty($nl_id)) {
		$HOST=$HOSTS->getHost($host_id,Array("aktiv"=>1,"type"=>"smtp"));
		//SMTP Server ausgewaehlt?
		if (count($HOST)==1) {
			$gc=count($adr_grp);
			//sind ueberhaupt gruppen gewaehlt???
			if ($gc>0) {
				$QUEUE=new tm_Q();
				$ADDRESS=new tm_ADR();
				
				$_MAIN_MESSAGE.="<br>".sprintf(___("Ausgewählter Mail-Server: %s"),$HOST[0]['name']);
				if ($check_blacklist==1) {
					$_MAIN_MESSAGE.= "<br>".tm_icon("ruby.png",___("Blacklist"))."&nbsp;".___("Blacklist Überprüfung aktiv");
				}
				//nur q eintraege hinzufügen die noch nicht vorhanden sind oder status gesendet haben
				//status gesendet=4,
				//NICHT:    neu=1, gestartet/wait=2, running=3
				//fuer jede gruppe im array adr_grp!
				for ($gcc=0;$gcc<$gc;$gcc++) {
					$group_add=false;
					$grp_id=$adr_grp[$gcc];
					$GRP=$ADDRESS->getGroup($grp_id);
					//function getQ($id=0,$offset=0,$limit=0,$nl_id=0,$grp_id=0,$status=0)
					$Qnew=$QUEUE->getQ(0,0,0,$nl_id,$grp_id,1);
					$qc_new=count($Qnew);
					if ($qc_new!=0) { //gefunden ? nicht hinzufügen
						unset($adr_grp[$gcc]);
						$_MAIN_MESSAGE.="<br><font color=\"red\">".sprintf(___("Für die Gruppe %s existieren bereits %s neue Einträge. Nicht hinzugefügt!"),"'<b>".display($GRP[0]['name'])."</b>'","<b>".$qc_new."</b>")."</font>";
					} else {//qnew!=0
						$Qwait=$QUEUE->getQ(0,0,0,$nl_id,$grp_id,2);
						$qc_wait=count($Qwait);
						if ($qc_wait!=0) { //
							unset($adr_grp[$gcc]);
							$_MAIN_MESSAGE.="<br><font color=\"red\">".sprintf(___("Für die Gruppe %s existieren bereits %s gestartete/wartende Einträge. Nicht hinzugefügt!"),"'<b>".display($GRP[0]['name'])."</b>'","<b>".$qc_wait."</b>")."</font>";
						} else {//qwait!=0
							$Qrun=$QUEUE->getQ(0,0,0,$nl_id,$grp_id,3);
							$qc_run=count($Qrun);
							if ($qc_run!=0) { //
								unset($adr_grp[$gcc]);
								$_MAIN_MESSAGE.="<br><font color=\"red\">".sprintf(___("Für die Gruppe %s existieren bereits %s laufende Einträge. Nicht hinzugefügt!"),"'<b>".display($GRP[0]['name'])."</b>'","<b>".$qc_run."</b>")."</font>";
							} else {
								
								//ok, hier auch status 5 checken, angehaltene q's

								//ok, die gruppe enthaelt brauchbare daten
								$group_add=true;
							}//qrun!=0
						}//qwait!=0
					}//$qnew=0
					//natuerlich macht es nur sinn die gruppe in die q aufzunehmen und fuer den versand vorzubereiten wenn diese gruppe auch ein paar aressen enthaelt, also aktive adressen die nihct unsubscribed sind etc.
					//das wird zwar beim versand und erstellen der sendeliste auch geprueft, jedoch koennen die zeiten zu denen beide listen angelegt werden variieren. --> manuelles anlegen der history
					//wir wollen aber wirklich nur gruppen aufnehmen ind enen taugliche adressen existieren.
					//Adr status=1 oder 2 oder 3 oder 4, 10 oder 12
					//und nur aktive
					//neue methode countValidADR(group_id)
					$ac=$ADDRESS->countValidADR($grp_id);
					//keine benutzbaren adressen gefunden
					if ($ac==0) {
						unset($adr_grp[$gcc]);
						$_MAIN_MESSAGE.="<br><font color=\"red\">".sprintf(___("In der  Gruppe %s existieren keine gültigen Adressen. Nicht hinzugefügt!"),"'<b>".display($GRP[0]['name'])."</b>'")."</font>";
					} elseif ($group_add) {
						$_MAIN_MESSAGE.="<br><font color=\"#006600\">".sprintf(___("In der  Gruppe %s existieren %s gültige Adressen. Gruppe hinzugefügt!"),"'<b>".display($GRP[0]['name'])."</b>'","<b>".$ac."</b>")."</font>";
					}//if ac
				}//for gcc
				//array neu indizieren, indexe neu erstellen.....
				$adr_grp= array_values($adr_grp);
				//neu zaehlen...
				$gc=count($adr_grp);
				//sind jetzt ueberhaupt noch gruppen gewaehlt???
				if ($gc>0) {
					$send_at=$send_at_date." ".$send_at_h.":".$send_at_m.":00";
					$new_q_arr=$QUEUE->addQ(Array(
							"created"=>$created,
							"author"=>$author,
							"status"=>$status,
							"nl_id"=>$nl_id,
							"host_id"=>$host_id,
							"send_at"=>$send_at,
							"check_blacklist"=>$check_blacklist,
							"proof"=>$proof,
							"autogen"=>$autogen,
							"touch"=>0
							),
							$adr_grp);
							//						
						//nl auf status queued setzen =2/6=terminiert
						$NEWSLETTER=new tm_NL();
						$NEWSLETTER->setStatus($nl_id,6);//war 2, ist 6 fuer terminierten versand!!
						$_MAIN_MESSAGE.="<br>".___("Neuer Eintrag wurde erstellt.");
						$action="queue_list";
						if ($send_now==1) {
							require_once (TM_INCLUDEPATH."/queue_send.inc.php");
						}
						#require_once (TM_INCLUDEPATH."/nl_list.inc.php");
						//show q list instead
						require_once (TM_INCLUDEPATH."/queue_list.inc.php");
				} else {// $gc>0
					$_MAIN_MESSAGE.="<br>".___("Keine Gruppe(n) gewählt. Nichts hinzugefügt");
					require_once (TM_INCLUDEPATH."/queue_form.inc.php");
					require_once (TM_INCLUDEPATH."/queue_form_show.inc.php");
				}
			} else {
				require_once (TM_INCLUDEPATH."/queue_form.inc.php");
				require_once (TM_INCLUDEPATH."/queue_form_show.inc.php");
			}
		} else { //$host_c==1
				$_MAIN_MESSAGE.="<br>".___("Kein Mail-Server gewählt. Nichts hinzugefügt");
				require_once (TM_INCLUDEPATH."/queue_form.inc.php");
				require_once (TM_INCLUDEPATH."/queue_form_show.inc.php");
		}
	} else {
				$_MAIN_MESSAGE.="<br>".___("Kein Newsletter gewählt. Nichts hinzugefügt");
				require_once (TM_INCLUDEPATH."/queue_form.inc.php");
				require_once (TM_INCLUDEPATH."/queue_form_show.inc.php");
	}
} else {//set==save
	require_once (TM_INCLUDEPATH."/queue_form.inc.php");
	require_once (TM_INCLUDEPATH."/queue_form_show.inc.php");
}
			#$_MAIN_MESSAGE.="<br>send_now: ".$send_now;
?>