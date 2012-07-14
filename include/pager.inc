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

// entrys = anzahl eintraege, muss in jeder liste an der stelle wo noetig vor pager.inc eingefuegt und definiert werden!
// dient der berechnung zur letzten seite... ;-) und anzeige anzahl eintraege!

$_MAIN_OUTPUT.= "<br><center>";

//an den anfang
//$_MAIN_OUTPUT.= "<!--a href=\"".$mnl_URL."/".$firstURLPara_."\" title=\"Anfang\"><img src=\"".$mnl_iconURL."/resultset_first.png\" border=\"0\"></a-->";

//1. seite zurueck
if ($offset>0) {
	$_MAIN_OUTPUT.= "<a href=\"".$mnl_URL."/".$prevURLPara_."\" title=\"".___("Zurueck")."\"><img src=\"".$mnl_iconURL."/resultset_previous.png\" border=\"0\"></a>";
}

//
//$_MAIN_OUTPUT.= "&nbsp;".($offset+1)." - ".($offset+$limit)."&nbsp;";
$_MAIN_OUTPUT.= "&nbsp;".sprintf(___("Eintrag %s bis %s von %s"),($offset+1),($offset+$entrys),$entrys_total);
//

//1 seite vor
if ($limit < ($entrys+1)) {
	$_MAIN_OUTPUT.= "<a href=\"".$mnl_URL."/".$nextURLPara_."\" title=\"".___("Vor")."\"><img src=\"".$mnl_iconURL."/resultset_next.png\" border=\"0\"></a>";
}
//ans ende
//$_MAIN_OUTPUT.= "<!--a href=\"".$mnl_URL."/".$lastURLPara_."\" title=\"Ende\"><img src=\"".$mnl_iconURL."/resultset_last.png\" border=\"0\"></a-->";

$_MAIN_OUTPUT.= "</center><br>";
?>