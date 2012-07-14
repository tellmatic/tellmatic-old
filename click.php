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

include("./include/mnl_config.inc");

//aufruf: click.php?h_id=&nl_id=&a_id=

$h_id=getVar("h_id");
$nl_id=getVar("nl_id");
$a_id=getVar("a_id");

if (checkid($nl_id)) {
	$NEWSLETTER=new mnlNL();
	//nl click counter ++
	$NEWSLETTER->addClick($nl_id);
	//Link holen
	$NL=$NEWSLETTER->getNL($nl_id);
	//nur wenn nl aktiv ist!
	if ($NL[0]['aktiv']==1) {
		if (checkid($h_id)) {
			$QUEUE=new mnlQ();
			$QUEUE->setHStatus($h_id,3);	//view
		}
		if (checkid($a_id)) {
			$ADDRESS=new mnlAdr();
			$ADDRESS->setStatus($a_id,4);	//click
			//adr click counter ++
			$ADDRESS->addClick($a_id,4);	//click
		}
		//header...
		header("Location: ".$NL[0]['link'].""); /* Browser umleiten */
	} else {
		//wenn inaktiv!
		//header("Location: ".$mnl_Domain.""); /* Browser umleiten */
		//oder: ;)
		header("HTTP/1.0 404 Not Found");
		exit;
	}
}

header("HTTP/1.0 404 Not Found");
exit;



?>