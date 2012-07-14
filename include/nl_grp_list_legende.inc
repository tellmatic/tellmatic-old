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

//Legende
$_MAIN_OUTPUT.="<br><b><a href=\"javascript:switchSection('legende')\"><img src=\"".$mnl_iconURL."/rainbow.png\" border=\"0\">&nbsp;Legende / Status</a></b>";
$_MAIN_OUTPUT.= "<div id=\"legende\" class=\"legende\">";

$_MAIN_OUTPUT.= "<h3>Legende</h3>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/page_white_lightning.png\" border=\"0\" title=\"Standardgruppe\" alt=\"Standardgruppe\">  Standardgruppe (kann nicht de-aktiviert und geloescht werden)<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/tick.png\" border=\"0\" title=\"Aktiv\" alt=\"Aktiv\">";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/cancel.png\" border=\"0\" title=\"Inaktiv\" alt=\"Inaktiv\">  Gruppe ist Aktiv/Inaktiv (Click=Deaktivieren/Aktivieren)<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/pencil.png\" border=\"0\" title=\"Bearbeiten\" alt=\"Bearbeiten\">  Bearbeiten<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/newspaper_add.png\" border=\"0\" title=\"Newsletter in dieser Gruppe erstellen\" alt=\"Newsletter in dieser Gruppe erstellen\">  Newsletter in dieser Gruppe erstellen<br>";	
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/newspaper_go.png\" border=\"0\" title=\"Newsletter dieser Gruppe anzeigen\" alt=\"Newsletter dieser Gruppe anzeigen\">  Newsletter dieser Gruppe anzeigen, Anzahl der Newsletter in dieser Gruppe<br>";
//$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/chart_pie.png\" border=\"0\" title=\"Statistik\" alt=\"Statistik\">  Statistik anzeigen<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/page_white_go.png\" border=\"0\" title=\"als Standardgruppe\" alt=\"als Standardgruppe\">  Diese Gruppe als Standardgruppe definieren<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/cross.png\" border=\"0\" title=\"Loeschen\" alt=\"Loeschen\">  Gruppe loeschen und Newsletter der Standardgruppe zuordnen<br>";

$_MAIN_OUTPUT.= "</div><br><br>";
$_MAIN_OUTPUT.= "<script type=\"text/javascript\">
<!--	
switchSection('legende'); 
-->
</script>";

?>