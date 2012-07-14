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

//

//
//$Mail=$Bounce->filterBounces($Mail,1,1);//$Messages , checkHeader=1, checkBody
/*
//$Bounce->checkHeader($Mail[]);
//$Bounce->checkBody($Mail[]);
*/
$Bounces=Array();
$bcmatch=0;



//hier uebergeben wir das mailarray an bounce und lassen uns die bounces filtern, aus body und header
/*
//tun wir aber bereits in getmail!!!
if ($filter_to==1) { // wenn 1 dann filtern wir die emails nach return-path im to feld! am besten aber schon in getMail.... ueber search-array
	$Mail=$Bounce->filterBounces($Mail,1,1,$bounce,$ReturnPath);//$Messages , checkHeader=1, checkBody, returnOnlyBounces..., filter to:
} else {
	$Mail=$Bounce->filterBounces($Mail,1,1,$bounce);//$Messages , checkHeader=1, checkBody, returnOnlyBounces..., filter to:
}
*/

$Mail=$Bounce->filterBounces($Mail,1,1,$bounce);//$Messages , checkHeader=1, checkBody, returnOnlyBounces..., filter to:

$mc=count($Mail);					

$_MAIN_OUTPUT .= "<br>Gesamt: ".$Mailer->count_msg." Mails";
//$_MAIN_OUTPUT .= "<br>Angezeigt werden max. $limit / $mc Mails.";

if ($mc>0) {
	//$_MAIN_OUTPUT .= "<br>Mail Nr. ".($offset+1)." bis Nr. ".($offset+$mc).".";
	
	$_MAIN_OUTPUT.="<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" width=100%>";
	$_MAIN_OUTPUT.= "<thead>
							<tr>
							<td style=\"width:80px;\">&nbsp;
							</td>
							<td style=\"width:240px;\"><b>Betreff / Text</b>
							</td>
							<td><b>Adressen</b>
							</td>
							</tr>
							</thead>
							<tbody>
							";
	for ($mcc=0;$mcc<$mc;$mcc++) {

		//hier zaehlen wir dann die bounces aus dem array bounce im mailarray.....
		if (!empty($Mail[$mcc]['bounce'])) {
			$Bounces = array_merge($Bounces,$Mail[$mcc]['bounce']);
			$bcmatch++;
		}

	/*alt:
		//bounce holen
		if (!empty($Mail[$mcc]['bounce'])) {
			$Mail=$Bounce->filterBounces($Mail,1,1);//$Messages , checkHeader=1, checkBody
			$Bounces = array_merge($Bounces,$Mail[$mcc]['bounce']);
			$bcmatch++;
		}
	*/			
		if ($mcc%2==0) {$bgcolor=$row_bgcolor;} else {$bgcolor=$row_bgcolor2;}
		$_MAIN_OUTPUT.= "<tr id=\"row_".$mcc."\" bgcolor=\"".$bgcolor."\" onmousemove=\"showToolTip('tt_bouncemail_list_".$mcc."')\" onmouseover=\"setBGColor('row_".$mcc."','".$row_bgcolor_hilite."');\" onmouseout=\"setBGColor('row_".$mcc."','".$bgcolor."');hideToolTip();\">";
		$_MAIN_OUTPUT.= "<td valign=\"top\">";
		if ($Mail[$mcc]['to']==$ReturnPath || $Mail[$mcc]['is_bouncemail']==1) {
			$Form->set_InputDefault($FormularName,$InputName_Mail,$Mail[$mcc]['no']);
		}
		$Form->set_InputValue($FormularName,$InputName_Mail,$Mail[$mcc]['no']);
		$Form->render_Input($FormularName,$InputName_Mail);
		$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Mail]['html'];
		$_MAIN_OUTPUT.= $Mail[$mcc]['no'].".";
		if ($Mail[$mcc]['to']==$ReturnPath) {
			$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/status_offline.png\" border=\"0\" title=\"Return Mail\">";
		}
		if ($Mail[$mcc]['is_bouncemail']==1) {
			$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/sport_soccer.png\" border=\"0\" title=\"Bounce Mail erkannt\">";
		}
		$_MAIN_OUTPUT.= "<div id=\"tt_bouncemail_list_".$mcc."\" class=\"tooltip\">";
		$_MAIN_OUTPUT.= "NR  <b>".$Mail[$mcc]['no']."</b>";
		$_MAIN_OUTPUT.= "<br><b>".$Mail[$mcc]['subject']."</b>";
		$_MAIN_OUTPUT.= "<br>Datum: <b>".$Mail[$mcc]['date']."</b>";
		$_MAIN_OUTPUT.= "<br>To: <b>".$Mail[$mcc]['to']."</b>";
		$_MAIN_OUTPUT.= "<br>From: <b>".$Mail[$mcc]['from']."</b>";
		$_MAIN_OUTPUT.= "<br>Groesse: <b>".$Mail[$mcc]['size']."</b>";
		$_MAIN_OUTPUT.= "</div>";
		$_MAIN_OUTPUT.= "</td>";
	
		$_MAIN_OUTPUT.= "<td valign=\"top\">";
		$_MAIN_OUTPUT.= "<div>";		
		$_MAIN_OUTPUT.= "<a href=\"javascript:switchSection('tt_bouncemail_text_".$mcc."')\" title=\"Text und Details anzeigen\"><img src=\"".$mnl_iconURL."/page.png\" border=\"0\"></a>";
		$_MAIN_OUTPUT.= "<font size=-1>";
		$_MAIN_OUTPUT.= "".$Mail[$mcc]['subject']."";
		$_MAIN_OUTPUT.= "</font>";
		$_MAIN_OUTPUT.= "</div>";

		//div fuer mailtext
		$_MAIN_OUTPUT.= "<div id=\"tt_bouncemail_text_".$mcc."\">";
		$_MAIN_OUTPUT.= "<br>".$Mail[$mcc]['date']."";
		$_MAIN_OUTPUT.= "<br>Von: ".$Mail[$mcc]['from']."";
		$_MAIN_OUTPUT.= "<br>An: ".$Mail[$mcc]['to']."";
		$_MAIN_OUTPUT.= "<br><br><font size=-2>".str_replace("\n","<br>",clear_text(substr(str_replace("<br>","\n",$Mail[$mcc]['body']),0,1024)))."...............</font>";
		$_MAIN_OUTPUT.= "</div>";

		$_MAIN_OUTPUT.= "<script type=\"text/javascript\">switchSection('tt_bouncemail_text_".$mcc."');</script>";
		$_MAIN_OUTPUT.= "</td>";
	
		$_MAIN_OUTPUT.= "<td valign=\"top\">";
		//wenn bounces .....
		if (count($Mail[$mcc]['bounce'])) {
			$_MAIN_OUTPUT.= "<div>";		
			$_MAIN_OUTPUT.= "<a href=\"javascript:switchSection('tt_bouncemail_adr_".$mcc."')\" title=\"Adressen anzeigen\"><img src=\"".$mnl_iconURL."/user_orange.png\" border=\"0\"></a>";
			$_MAIN_OUTPUT.= "</div>";
			//div fuer adressen
			$_MAIN_OUTPUT.= "<div id=\"tt_bouncemail_adr_".$mcc."\">";
			$_MAIN_OUTPUT.= "<font size=-1>";
			foreach ($Mail[$mcc]['bounce'] as $adr) {
				$_MAIN_OUTPUT.= $adr.", ";
			}
			$_MAIN_OUTPUT.= "</font>";
			$_MAIN_OUTPUT.= "</div>";
			$_MAIN_OUTPUT.= "<script type=\"text/javascript\">switchSection('tt_bouncemail_adr_".$mcc."');</script>";
		}
		$_MAIN_OUTPUT.= "&nbsp;</td>";

		$_MAIN_OUTPUT.= "</tr>";
	}
	
	$_MAIN_OUTPUT.= "<tr>";
	$_MAIN_OUTPUT.= "<td colspan=4>";
	$_MAIN_OUTPUT.= "<a href=\"javascript:checkAllForm('".$FormularName."');\" title=\"Markierung fuer alle angezeigten e-Mails umkehren\">Alle auswaehlen / Markierung fuer alle angezeigten e-Mails umkehren</a>";
	//$_MAIN_OUTPUT.= "<a href=\"javascript:checkByID('".$InputName_Mail."');\">alle auswaehlen</a><br>";
	//$_MAIN_OUTPUT.= "<a href=\"javascript:checkAll();\">alle auswaehlen</a><br>";
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "</tr>";
	
	
	$_MAIN_OUTPUT.= "</tbody></table><br>";
	
	$bctotal=count($Bounces);
	$Bounces=unify_array($Bounces);
	$bc=count($Bounces);		
	$_MAIN_OUTPUT.="<br>Es wurden $mc Mails durchsucht. 
								<br>$bcmatch Mails ergaben einen Treffer. 
								<br>Es wurden aus $bctotal Adressen $bc potentiell Fehlerhafte Adressen erkannt.
								";
	
}//mc>0

?>