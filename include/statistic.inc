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

$_MAIN_DESCR=___("Statistik");

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//$_MAIN_MESSAGE.= "<img src=\"".$mnl_URL."/include/test_img.php\"></center>";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$set=getVar("set");

$nl_id=getVar("nl_id");
$adr_grp_id=getVar("adr_grp_id");
$adr_id=getVar("adr_id");
$frm_id=getVar("frm_id");

$FORMULAR=new mnlFRM();
$QUEUE=new mnlQ();
$ADDRESS=new mnlADR();
$NEWSLETTER=new mnlNL();


$_MAIN_MESSAGE.="";

/////////////////////////////////////
//Statistik fuer Newsletter
/////////////////////////////////////


if ($set=="nl") {
	//nl_id
	$N=$NEWSLETTER->getNL($nl_id);
	$_MAIN_OUTPUT.=sprintf(___("Statistik f&uuml;r Newsletter %s"),"<b>".$N[0]['subject']."</b>");

	//Q Status
	//countQ($nl_id=0,$grp_id=0,$status=0)
	$qc=$QUEUE->countQ($nl_id);
	$_MAIN_OUTPUT.="<br><br>".sprintf(___("%s Sendeauftr&auml;ge insgesamt:"),"<b>$qc</b>");
	$_MAIN_OUTPUT.="<br>&nbsp;&nbsp;&nbsp;".___("Auftragsstatus:");
	$qsc=count($STATUS['q']['status']);
	//countQ($nl_id=0,$grp_id=0,$status=0)
	for ($qscc=1; $qscc<=$qsc; $qscc++) {
		$qc=$QUEUE->countQ($nl_id,0,$qscc);
		if ($qc>0) {
			$_MAIN_OUTPUT.="<br>".
							"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$qc.
							"&nbsp;<img src=\"".$mnl_iconURL."/".$STATUS['q']['statimg'][$qscc]."\" border=\"0\">".
							"&nbsp;".$STATUS['q']['status'][$qscc].
							"&nbsp;(".$STATUS['q']['descr'][$qscc].")";	
		}
	}
	$_MAIN_OUTPUT.="<br>";
	//H Status
	$hc=$QUEUE->countH(0,$nl_id);
	//countH($q_id=0,$nl_id=0,$grp_id=0,$adr_id=0,$status=0)
	$_MAIN_OUTPUT.="<br>".sprintf(___("Versand an insgesamt %s Adressen:"),"<b>$hc</b>");
	$_MAIN_OUTPUT.="<br>&nbsp;&nbsp;&nbsp;".___("Versandstatus:");
	$hsc=count($STATUS['h']['status']);
	for ($hscc=1; $hscc<=$hsc; $hscc++) {
		$hc=$QUEUE->countH(0,$nl_id,0,0,$hscc);
		if ($hc>0) {
			$_MAIN_OUTPUT.="<br>".
							"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$hc.
							"&nbsp;<img src=\"".$mnl_iconURL."/".$STATUS['h']['statimg'][$hscc]."\" border=\"0\">".
							"&nbsp;".$STATUS['h']['status'][$hscc].
							"&nbsp;(".$STATUS['h']['descr'][$hscc].")";
		}
	}
	//Details, per Q, per Group, per Status
	$_MAIN_OUTPUT.="<br><br><b>".___("Details:")."</b>";
	/*
	zu jeder Q Status anzeigen
		Gruppen holen
			Gruppen anzeigen
				H Status fuer Gruppe!
	*/
	$Q=$QUEUE->getQ(0,0,0,$nl_id);
	//getQ($id=0,$offset=0,$limit=0,$nl_id=0,$grp_id=0,$status=0)
	$qc=count($Q);
	for ($qcc=0;$qcc<$qc;$qcc++) {
		$AG=$ADDRESS->getGroup($Q[$qcc]['grp_id']);
		$_MAIN_OUTPUT.="<br>".
							"<br>&nbsp;&nbsp;".
							sprintf(___("Versand an Gruppe %s"),"<b>".$AG[0]['name']."</b>");
		$_MAIN_OUTPUT.=":&nbsp;<img src=\"".$mnl_iconURL."/".$STATUS['q']['statimg'][$Q[$qcc]['status']]."\" border=\"0\">".
							"&nbsp;".$STATUS['q']['status'][$Q[$qcc]['status']].
							"&nbsp;(".$STATUS['q']['descr'][$Q[$qcc]['status']].")";
		//countH($q_id=0,$nl_id=0,$grp_id=0,$adr_id=0,$status=0)
		$hsc=count($STATUS['h']['status']);
		for ($hscc=1; $hscc<=$hsc; $hscc++) {
			$hc=$QUEUE->countH($Q[$qcc]['id'],$Q[$qcc]['nl_id'],$AG[0]['id'],0,$hscc);
			if ($hc>0) {
				$_MAIN_OUTPUT.="<br>".
								"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$hc.
								"&nbsp;<img src=\"".$mnl_iconURL."/".$STATUS['h']['statimg'][$hscc]."\" border=\"0\">".
								"&nbsp;".$STATUS['h']['status'][$hscc].
								"&nbsp;(".$STATUS['h']['descr'][$hscc].")";	
			}
		}
	}//for qcc
}//nl

/////////////////////////////////////
//Statistik fuer Adressgruppe
/////////////////////////////////////


if ($set=="adrg") {
	//adr_grp_id
	$AG=$ADDRESS->getGroup($adr_grp_id);
	$_MAIN_OUTPUT.=sprintf(___("Statistik f&uuml;r Adressgruppe %s"),"<b>".$AG[0]['name']."</b>");

	//Gesamtstatus, anzahl per adr-status
	$ac=$ADDRESS->countADR($adr_grp_id);
	$_MAIN_OUTPUT.="<br>".sprintf(___("Insgesamt %s Adressen:"),"<b>".$ac)."</b>";

	//per adr status:
	$asc=count($STATUS['adr']['status']);
		for ($ascc=1; $ascc<=$asc; $ascc++) {
			$search['status']=$ascc;
			$ac=$ADDRESS->countADR($adr_grp_id,$search);
			if ($ac>0) {
				$_MAIN_OUTPUT.="<br>".
								"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ac.
								"&nbsp;<img src=\"".$mnl_iconURL."/".$STATUS['adr']['statimg'][$ascc]."\" border=\"0\">".
								"&nbsp;".$STATUS['adr']['status'][$ascc].
								"&nbsp;(".$STATUS['adr']['descr'][$ascc].")	";	
			}
		}
	


	//Q Status
	
	$_MAIN_OUTPUT.="<br><br>&nbsp;&nbsp;".___("Versandstatus:");
	$Q=$QUEUE->getQ(0,0,0,0,$adr_grp_id);
	//getQ($id=0,$offset=0,$limit=0,$nl_id=0,$grp_id=0,$status=0)
	$qc=count($Q);
	for ($qcc=0;$qcc<$qc;$qcc++) {
		$NL=$NEWSLETTER->getNL($Q[$qcc]['nl_id']);
		$_MAIN_OUTPUT.="<br>&nbsp;&nbsp;&nbsp;&nbsp;".sprintf(___("Versand von %s"),"<b>".$NL[0]['subject']."</b>");
		$_MAIN_OUTPUT.=":&nbsp;<img src=\"".$mnl_iconURL."/".$STATUS['q']['statimg'][$Q[$qcc]['status']]."\" border=\"0\">".
							"&nbsp;".$STATUS['q']['status'][$Q[$qcc]['status']].
							"&nbsp;(".$STATUS['q']['descr'][$Q[$qcc]['status']].")";
		//countH($q_id=0,$nl_id=0,$grp_id=0,$adr_id=0,$status=0)
		$hsc=count($STATUS['h']['status']);
		for ($hscc=1; $hscc<=$hsc; $hscc++) {
			$hc=$QUEUE->countH($Q[$qcc]['id'],$Q[$qcc]['nl_id'],$AG[0]['id'],0,$hscc);
			if ($hc>0) {
				$_MAIN_OUTPUT.="<br>".
								"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$hc.
								"&nbsp;<img src=\"".$mnl_iconURL."/".$STATUS['h']['statimg'][$hscc]."\" border=\"0\">".
								"&nbsp;".$STATUS['h']['status'][$hscc].
								"&nbsp;(".$STATUS['h']['descr'][$hscc].")";	
			}
		}
	}//qcc	
	
}




/////////////////////////////////////
//Statistik fuer Adressen
/////////////////////////////////////
if ($set=="adr") {
	//nl_id
	$ADR=$ADDRESS->getADR($adr_id);
	$_MAIN_OUTPUT.=sprintf(___("Statistik fuer Adresse %s"),"<b>".$ADR[0]['email']."</b>");
	$_MAIN_OUTPUT.= "<br>ID: ".$ADR[0]['id']." / ".$ADR[0]['d_id']." ";
	if ($ADR[0]['aktiv']==1) {
		$_MAIN_OUTPUT.=  "<br><img src=\"".$mnl_iconURL."/tick.png\" border=\"0\">";
		$_MAIN_OUTPUT.=  ___("(aktiv)");
	} else {
		$_MAIN_OUTPUT.=  "<br><img src=\"".$mnl_iconURL."/cancel.png\" border=\"0\">";
		$_MAIN_OUTPUT.=  ___("(inaktiv)");
	}

	$_MAIN_OUTPUT.= "<ul>".___("Gespeicherte Daten:")."<ul>";
	$_MAIN_OUTPUT.= "f0: ".$ADR[0]['f0'];
	$_MAIN_OUTPUT.= "<br>f1: ".$ADR[0]['f1'];
	$_MAIN_OUTPUT.= "<br>f2: ".$ADR[0]['f2'];
	$_MAIN_OUTPUT.= "<br>f3: ".$ADR[0]['f3'];
	$_MAIN_OUTPUT.= "<br>f4: ".$ADR[0]['f4'];
	$_MAIN_OUTPUT.= "<br>f5: ".$ADR[0]['f5'];
	$_MAIN_OUTPUT.= "<br>f6: ".$ADR[0]['f6'];
	$_MAIN_OUTPUT.= "<br>f7: ".$ADR[0]['f7'];
	$_MAIN_OUTPUT.= "<br>f8: ".$ADR[0]['f8'];
	$_MAIN_OUTPUT.= "<br>f9: ".$ADR[0]['f9'];
	$_MAIN_OUTPUT.="</ul></ul>";
	/*
	$created_date=strftime("%d-%m-%Y",mk_microtime($ADR[0]['created']));
	$updated_date=strftime("%d-%m-%Y",mk_microtime($ADR[0]['updated']));
	*/
	$created_date=$ADR[0]['created'];
	$updated_date=$ADR[0]['updated'];

	$author=$ADR[0]['author'];
	$editor=$ADR[0]['editor'];
	
	if (is_numeric($author)) {
		$author="Form_".$author;
	}
	if (is_numeric($editor)) {
		$editor="Form_".$editor;
	}

	$_MAIN_OUTPUT.= " ".___("Status:")." <img src=\"".$mnl_iconURL."/".$STATUS['adr']['statimg'][$ADR[0]['status']]."\" border=\"0\">".$STATUS['adr']['status'][$ADR[0]['status']];
	$nlc=$QUEUE->countH(0,0,0,$ADR[0]['id'],0);
	$_MAIN_OUTPUT.= "<br>CODE: ".$ADR[0]['code']." &nbsp;".
							"<br>".sprintf(___("erstellt am: %s von: %s"),$created_date,$author).
							"<br>".sprintf(___("bearbeitet am: %s von %s"),$updated_date,$editor).
							"<br>".sprintf(___("Newsletter Aktuell: %s"),$nlc).
							"<br>".sprintf(___("Newsletter Gesamt: %s"),$ADR[0]['newsletter']).
							"<br>".sprintf(___("Views: %s"),$ADR[0]['views']).
							"<br>".sprintf(___("Clicks: %s"),$ADR[0]['clicks']).
							"<br>".sprintf(___("Sendefehler: %s"),$ADR[0]['errors'])." &nbsp;";



	//H Status
	//	function countH($q_id=0,$nl_id=0,$grp_id=0,$adr_id=0,$status=0) {	//countH($nl_id=0,$grp_id=0,$status=0)
	$hc=$QUEUE->countH(0,0,0,$adr_id,0);
	$_MAIN_OUTPUT.="<ul><b>$hc</b> ".___("Sendeauftr&auml;ge insgesamt:");
	$_MAIN_OUTPUT.="<br><ul>".___("Auftragsstatus:")."<ul>";
	$hsc=count($STATUS['h']['status']);
	//countQ($nl_id=0,$grp_id=0,$status=0)
	for ($hscc=1; $hscc<=$hsc; $hscc++) {
		$hc=$QUEUE->countH(0,0,0,$adr_id,$hscc);
		if ($hc>0) {
			$_MAIN_OUTPUT.="	&nbsp;".$hc.
							"&nbsp;<img src=\"".$mnl_iconURL."/".$STATUS['h']['statimg'][$hscc]."\" border=\"0\">".
							"&nbsp;".$STATUS['h']['status'][$hscc].
							"&nbsp;(".$STATUS['h']['descr'][$hscc].")<br>";	
		}
	}
	$_MAIN_OUTPUT.="</ul></ul></ul><br>";
	//function getH($id=0,$offset=0,$limit=0,$q_id=0,$nl_id=0,$grp_id=0,$adr_id=0,$status=0) {
	$_MAIN_OUTPUT.="<ul>".___("Versand-Details:")."<ul>";
	$H=$QUEUE->getH(0,0,0,0,0,0,$adr_id,0);
	$hc=count($H);
	for ($hcc=0;$hcc<$hc;$hcc++) {
		$NL=$NEWSLETTER->getNL($H[$hcc]['nl_id']);
		$G=$ADDRESS->getGroup($H[$hcc]['grp_id']);
		$Q=$QUEUE->getQ($H[$hcc]['q_id']);
		
			$_MAIN_OUTPUT.="<b>".$NL[0]['subject']."</b><ul>".
						___("an Adressgruppe")." <b>".$G[0]['name']."</b>:";

			$_MAIN_OUTPUT.="<br>&nbsp;<img src=\"".$mnl_iconURL."/".$STATUS['h']['statimg'][$H[$hcc]['status']]."\" border=\"0\">".
									"&nbsp;".$STATUS['h']['status'][$H[$hcc]['status']].
									"&nbsp;(".$STATUS['h']['descr'][$H[$hcc]['status']].")";
			//$_MAIN_OUTPUT.="<br>Erstellt am: ".strftime("%d-%m-%Y %H:%M:%S",mk_microtime($H[$hcc]['created']));
			$_MAIN_OUTPUT.="<br>".sprintf(___("Erstellt am: %s"),$H[$hcc]['created']);
			if (!empty($Q[0]['send_at'])) {
	
				$_MAIN_OUTPUT.="<br>".sprintf(___("Q Versand (start): %s"),$Q[0]['send_at']);
			}
			if (!empty($H[$hcc]['sent'])) {
				//$_MAIN_OUTPUT.="<br>Versendet: ".strftime("%d-%m-%Y %H:%M:%S",mk_microtime($H[$hcc]['sent']));
				$_MAIN_OUTPUT.="<br>".sprintf(___("Versendet: %s"),$H[$hcc]['sent']);
			}
			$_MAIN_OUTPUT.="</ul>";

		
	}
	$_MAIN_OUTPUT.="</ul></ul>";
}//adr

/////////////////////////////////////
//Statistik fuer Formulare
/////////////////////////////////////
if ($set=="form") {
	$_MAIN_OUTPUT.="<a href=\"http://www.tellmatic.de/?c=donate\" target=\"_blank\">".___("Diese Funktion ist leider noch nicht implementiert. Bitte unterst&uuml;tzen Sie die Entwicklung von Tellmatic.")."</a>";
}

$_MAIN_OUTPUT.= "<br><br><br><br>";
?>