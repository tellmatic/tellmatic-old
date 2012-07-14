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
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/tick.png\" border=\"0\" title=\"Gruppe ist Aktiv\" alt=\"Gruppe ist Aktiv\">";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/cancel.png\" border=\"0\" title=\"Gruppe ist Inaktiv\" alt=\"Gruppe ist Inaktiv\">  Gruppe ist Aktiv/Inaktiv (Click=Deaktivieren/Aktivieren)<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/pencil.png\" border=\"0\" title=\"Bearbeiten\" alt=\"Bearbeiten\">  Bearbeiten<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/vcard_add.png\" border=\"0\" title=\"Adresse in dieser Gruppe erstellen\" alt=\"Adresse in dieser Gruppe erstellen\">  Adresse in dieser Gruppe erstellen<br>";	
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/group_go.png\" border=\"0\" title=\"Adressen dieser Gruppe anzeigen\" alt=\"Adressen dieser Gruppe anzeigen\">  Adressen dieser Gruppe anzeigen, Anzahl der Adressen in dieser Gruppe<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/chart_pie.png\" border=\"0\" title=\"Statistik anzeigen\" alt=\"Statistik anzeigen\">  Statistik anzeigen<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/page_white_go.png\" border=\"0\" title=\"Diese Gruppe als Standardgruppe definieren\" alt=\"Diese Gruppe als Standardgruppe definieren\">  Diese Gruppe als Standardgruppe definieren<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/cross.png\" border=\"0\" title=\"Gruppe loeschen und Adressen der Standardgruppe zuordnen\" alt=\"Gruppe loeschen und Adressen der Standardgruppe zuordnen\">  Gruppe loeschen und Adressen der Standardgruppe zuordnen<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/bomb.png\" border=\"0\" title=\"Gruppe loeschen und Adressen der Gruppe loeschen\" alt=\"Gruppe loeschen und Adressen der Gruppe loeschen\">  Gruppe loeschen und Adressen der Gruppe loeschen (Adressen werden komplett geloescht und auch aus allen anderen Gruppen entfernt!)<br>";
$_MAIN_OUTPUT.= "</div><br><br>";
$_MAIN_OUTPUT.= "<script type=\"text/javascript\">
<!--	
switchSection('legende'); 
-->
</script>";

?>