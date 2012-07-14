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



$Bounces=Array();
$bcmatch=0;
for ($mcc=0;$mcc<$mc;$mcc++) {
	$Mail=$Mailer->getMail($mailno[$mcc]);
	$Mail=$Bounce->filterBounces($Mail,1,1);//$Messages , checkHeader=1, checkBody
	if (!empty($Mail[0]['bounce'])) {
		$Bounces = array_merge($Bounces,$Mail[0]['bounce']);
		$bcmatch++;
	}
	
}
$bctotal=count($Bounces);
$Bounces=unify_array($Bounces);
$bc=count($Bounces);

	$_MAIN_OUTPUT.="<br>Es wurden $mc Mails durchsucht. 
									<br>$bcmatch Mails ergaben einen Treffer. 
									<br>Es wurden aus $bctotal Adressen $bc (eindeutige) potentiell fehlerhafte Adressen erkannt.
									";
if ($bc) { //bc>0

	
	$_MAIN_OUTPUT.="<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" width=100%>";
	$_MAIN_OUTPUT.= "<thead>
							<tr>
							<td></td>
							<td>Adresse</td>
							<td>Details</td>
							</thead>
							<tbody>
							";
	for ($bcc=0;$bcc<$bc;$bcc++) {
	
		$search['email']=$Bounces[$bcc];
		$ADR=$ADDRESS->getAdr(0,0,0,0,$search);
	
		if ($bcc%2==0) {$bgcolor=$row_bgcolor;} else {$bgcolor=$row_bgcolor2;}
		$_MAIN_OUTPUT.= "<tr id=\"row2_".$bcc."\" bgcolor=\"".$bgcolor."\" onmousemove=\"showToolTip('tt_bouncemail_adr_list_".$bcc."')\" onmouseover=\"setBGColor('row2_".$bcc."','".$row_bgcolor_hilite."');\" onmouseout=\"setBGColor('row2_".$bcc."','".$bgcolor."');hideToolTip();\">";
		$_MAIN_OUTPUT.= "<td>";
		
		$Form->set_InputValue($FormularName,$InputName_Adr,$Bounces[$bcc]);
		if (isset($ADR[0]['id'])) {
			$Form->set_InputDefault($FormularName,$InputName_Adr,$Bounces[$bcc]);
		}
		$Form->render_Input($FormularName,$InputName_Adr);
		$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Adr]['html'];
	
		$_MAIN_OUTPUT.= "<div id=\"tt_bouncemail_adr_list_".$bcc."\" class=\"tooltip\">";
		$_MAIN_OUTPUT.= "".$Bounces[$bcc]."";
		if (isset($ADR[0]['id'])) {
			$_MAIN_OUTPUT.= "<br>ID: ".$ADR[0]['id']." / ".$ADR[0]['d_id']."&nbsp;&nbsp;<br>";
			if ($ADR[0]['aktiv']==1) {
				$_MAIN_OUTPUT.=  "<img src=\"".$mnl_iconURL."/tick.png\" border=\"0\" title=\"Aktiv\">";
	//			$_MAIN_OUTPUT.=  "(aktiv)";
			} else {
				$_MAIN_OUTPUT.=  "<img src=\"".$mnl_iconURL."/cancel.png\" border=\"0\" title=\"Inaktiv\">";
	//			$_MAIN_OUTPUT.=  "(inaktiv)";
			}
			$_MAIN_OUTPUT.= "<br><img src=\"".$mnl_iconURL."/".$STATUS['adr']['statimg'][$ADR[0]['status']]."\" border=\"0\" title=\"".$STATUS['adr']['status'][$ADR[0]['status']]."\">&nbsp;".$STATUS['adr']['status'][$ADR[0]['status']];
			$_MAIN_OUTPUT.= "<br>
								<br>Newsletter Gesamt: ".$ADR[0]['newsletter']." 
								<br>Views: ".$ADR[0]['views']."
								<br>Clicks: ".$ADR[0]['clicks']."
								<br>Sendefehler: ".$ADR[0]['errors']." &nbsp;
								";
		} else {
			$_MAIN_OUTPUT.= "<br>Unbekannt / nicht in der Datenbank";
		}
	
	
		$_MAIN_OUTPUT.= "</div>";
		$_MAIN_OUTPUT.= "</td>";
	
		$_MAIN_OUTPUT.= "<td>";
		$_MAIN_OUTPUT.= "<b>".$Bounces[$bcc]."</b>";
		$_MAIN_OUTPUT.= "</td>";
	
		$_MAIN_OUTPUT.= "<td>";
		
		if (isset($ADR[0]['id'])) {
			$_MAIN_OUTPUT.= "ID: ".$ADR[0]['id']." / ".$ADR[0]['d_id']."&nbsp;&nbsp;";
			if ($ADR[0]['aktiv']==1) {
				$_MAIN_OUTPUT.=  "<img src=\"".$mnl_iconURL."/tick.png\" border=\"0\" title=\"Aktiv\">";
	//			$_MAIN_OUTPUT.=  "(aktiv)";
			} else {
				$_MAIN_OUTPUT.=  "<img src=\"".$mnl_iconURL."/cancel.png\" border=\"0\" title=\"Inaktiv\">";
	//			$_MAIN_OUTPUT.=  "(inaktiv)";
			}
			$_MAIN_OUTPUT.= "&nbsp;<img src=\"".$mnl_iconURL."/".$STATUS['adr']['statimg'][$ADR[0]['status']]."\" border=\"0\" title=\"".$STATUS['adr']['status'][$ADR[0]['status']]."\">&nbsp;".$STATUS['adr']['status'][$ADR[0]['status']];
		} else {
			$_MAIN_OUTPUT.= "&nbsp;Unbekannt / nicht in der Datenbank";
		}
		$_MAIN_OUTPUT.= "</td>";
	
		$_MAIN_OUTPUT.= "</tr>";
	}
		$_MAIN_OUTPUT.= "<tr>";
		$_MAIN_OUTPUT.= "<td colspan=3>";
		$_MAIN_OUTPUT.= "<a href=\"javascript:checkAllForm('".$FormularName."');\" title=\"Markierung fuer alle angezeigten Adressen umkehren\">Alle auswaehlen / Markierung fuer alle angezeigten Adressen umkehren</a><br><br>";
	//	$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_ActionAdr]['html'];
		$_MAIN_OUTPUT.= "</td>";
		$_MAIN_OUTPUT.= "</tr>";
	
	$_MAIN_OUTPUT.= "</tbody></table><br>";
} //if bc


?>