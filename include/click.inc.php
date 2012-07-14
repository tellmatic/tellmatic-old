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

//aufruf: click.php?h_id=&nl_id=&a_id=

$h_id=getVar("h_id");
$nl_id=getVar("nl_id");
$a_id=getVar("a_id");

if (checkid($nl_id)) {
	$NEWSLETTER=new tm_NL();
	//nl click counter ++
	$NEWSLETTER->addClick($nl_id);
	//Link holen
	$NL=$NEWSLETTER->getNL($nl_id);
	//nur wenn nl aktiv ist!
	if ($NL[0]['aktiv']==1) {
		if (checkid($h_id)) {
			$QUEUE=new tm_Q();
			//nur der erste aufruf wird mit der ip versehen! ansonsten wuerde diese jedesmal ueberschrieben wenn der leser oder ein anderer das nl anschaut.
			$H=$QUEUE->getH($h_id);
			if (empty($H[0]['ip']) || $H[0]['ip']=='0.0.0.0') {
				$QUEUE->setHIP($H[0]['id'], getIP());	//save ip
			}
			if ($H[0]['status']!=7) { //7:unsubscribed
				$QUEUE->setHStatus($h_id,3);	//view
			}
		}
		if (checkid($a_id)) {
			$ADDRESS=new tm_ADR();
			$ADR=$ADDRESS->getAdr($a_id);
			//only set view status if not waiting status or unsubscribed // !5 && !11
			if ($ADR[0]['status']!=5 && $ADR[0]['status']!=11) {
				$ADDRESS->setStatus($a_id,4);	//view
			}
			//adr click counter ++
			$ADDRESS->addClick($a_id);	//click
			//save memo
			$created=date("Y-m-d H:i:s");
			$memo="\n".$created.": clicked (".$NL[0]['subject'].") ".$NL[0]['link'];
			$ADDRESS->addMemo($a_id,$memo);
		}
		//header...
		header("Location: ".$NL[0]['link'].""); /* Browser umleiten */
		exit;
	} else {
		//wenn inaktiv!
		//header("Location: ".TM_DOMAIN.""); /* Browser umleiten */
		//oder: ;)
		header("HTTP/1.0 404 Not Found");
		exit;
	}
}

header("HTTP/1.0 404 Not Found");
exit;
?>