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
$_MAIN_OUTPUT.="\n\n<!-- pager.inc.php -->\n\n";

// entrys = anzahl eintraege, muss in jeder liste an der stelle wo noetig vor pager.inc eingefuegt und definiert werden!
// dient der berechnung zur letzten seite... ;-) und anzeige anzahl eintraege!
$_MAIN_OUTPUT.= "<br><center>";
//1. seite zurueck
if ($offset>0) {
	$_MAIN_OUTPUT.= "<a href=\"".$tm_URL."/".$prevURLPara_."\" title=\"".___("Zurück")."\">.".tm_icon("resultset_previous.png",___("Zurück"))."</a>";
}
$_MAIN_OUTPUT.= "&nbsp;".sprintf(___("Eintrag %s bis %s von %s"),($offset+1),($offset+$entrys),$entrys_total);
//1 seite vor
if ($limit < ($entrys+1)) {
	$_MAIN_OUTPUT.= "<a href=\"".$tm_URL."/".$nextURLPara_."\" title=\"".___("Vor")."\">.".tm_icon("resultset_next.png",___("Vor"))."</a>";
}
$_MAIN_OUTPUT.= "</center><br>";
?>