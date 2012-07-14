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
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/lorry.png\" border=\"0\" title=\"Massenmailing\" alt=\"Massenmailing\">  Massenmailing (per BCC:, kein feedback)<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/user_suit.png\" border=\"0\" title=\"personalisiertes Newsletter\" alt=\"personalisiertes Newsletter\">  personalisiertes Newsletter<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/hourglass_add.png\" border=\"0\" title=\"Queue-Eintrag hinzufuegen, zum Versenden vorbereiten\" alt=\"Queue-Eintrag hinzufuegen, zum Versenden vorbereiten\">  Queue-Eintrag hinzufuegen, zum Versenden vorbereiten<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/hourglass_delete.png\" border=\"0\" title=\"Alle Queue-Eintraege loeschen\" alt=\"Alle Queue-Eintraege loeschen\">  Alle Queue-Eintraege fuer diesen Newsletter loeschen<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/hourglass_go.png\" border=\"0\" title=\"Queue-Eintraege fuer Newsletter anzeigen\" alt=\"Queue-Eintraege fuer Newsletter anzeigen\">  Queue-Eintraege fuer Newsletter anzeigen<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/email_go.png\" border=\"0\" title=\"Versenden\" alt=\"Versenden\">  Versenden<br>";

//link zur geparsten onlineversion!
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/eye.png\" border=\"0\" title=\"Online\" alt=\"Online\">  Onlineversion des Newsletter anzeigen<br>";
//link zum bild
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/photo.png\" border=\"0\" title=\"Bild\" alt=\"Bild\">  verknuepftes Bild anzeigen<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/photo_delete.png\" border=\"0\" title=\"Bild\" alt=\"Bild\">  verknuepftes Bild loeschen<br>";
//attachement
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/attach.png\" border=\"0\" title=\"Attachement anzeigen\" alt=\"Attachement\">  Attachement anzeigen<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/link_break.png\" border=\"0\" title=\"Attachement loeschen\" alt=\"Attachement\">  Attachement loeschen<br>";
//link zur html datei!
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/page_white_world.png\" border=\"0\" title=\"HTML\" alt=\"HTML\">  verknuepfte HTML Datei anzeigen<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/page_white_delete.png\" border=\"0\" title=\"HTML loeschen \" alt=\"HTML\">  verknuepfte HTML Datei loeschen<br>";
//link zum link
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/page_white_link.png\" border=\"0\" title=\"Link\" alt=\"Link\">  verknuepften Link anzeigen<br>";

$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/tick.png\" border=\"0\" title=\"Aktiv\" alt=\"Aktiv\">";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/cancel.png\" border=\"0\" title=\"Inaktiv\" alt=\"Inaktiv\">  Newsletter ist Aktiv/Inaktiv (Click=Deaktivieren/Aktivieren)<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/pencil.png\" border=\"0\" title=\"Bearbeiten\" alt=\"Bearbeiten\">  Bearbeiten<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/bullet_add.png\" border=\"0\" title=\"Newsletter kopieren\" alt=\"Newsletter kopieren\">  Newsletter kopieren (ohne Dateien)<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/add.png\" border=\"0\" title=\"Newsletter und Dateien kopieren\" alt=\"Newsletter und Dateien kopieren\">  Newsletter und Dateien kopieren<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/chart_pie.png\" border=\"0\" title=\"Statistik\" alt=\"Statistik\">  Statistik anzeigen<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/cross.png\" border=\"0\" title=\"Loeschen\" alt=\"Loeschen\">  Newsletter loeschen<br>";

$_MAIN_OUTPUT.= "<h3>Status</h3>";

$sc=count($STATUS['nl']['status']);
for ($scc=1; $scc<=$sc; $scc++)//0
{
	$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/".$STATUS['nl']['statimg'][$scc]."\" border=\"0\" title=\"".$STATUS['nl']['descr'][$scc]."\" alt=\"".$STATUS['nl']['descr'][$scc]."\">";
	$_MAIN_OUTPUT.= "  ".$STATUS['nl']['status'][$scc]."  (".$STATUS['nl']['descr'][$scc].")<br>";
}

$_MAIN_OUTPUT.= "</div><br><br>";
$_MAIN_OUTPUT.= "<script type=\"text/javascript\">
<!--	
switchSection('legende'); 
-->
</script>";

?>