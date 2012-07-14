a<?php
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

//Legende
$_MAIN_OUTPUT.="<br><b><a href=\"javascript:switchSection('legende')\"><img src=\"".$mnl_iconURL."/rainbow.png\" border=\"0\">&nbsp;".___("Legende / Status")."</a></b>";
$_MAIN_OUTPUT.= "<div id=\"legende\" class=\"legende\">";

$_MAIN_OUTPUT.= "<h3>".___("Legende")."</h3>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/lorry.png\" border=\"0\" title=\"".___("Massenmailing")."\" alt=\"".___("Massenmailing")."\">&nbsp;".___("Massenmailing (per BCC:, kein feedback)")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/user_suit.png\" border=\"0\" title=\"".___("personalisierter Newsletter")."\" alt=\"".___("personalisierter Newsletter")."\">&nbsp;".___("personalisierter Newsletter")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/page_white_office.png\" border=\"0\" title=\"".___("TEXT/HTML")."\" alt=\"".___("TEXT/HTML")."\">&nbsp;".___("TEXT/HTML")." | ";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/page_white_h.png\" border=\"0\" title=\"".___("HTML")."\" alt=\"".___("HTML")."\">&nbsp;".___("HTML")." | ";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/page_white_text.png\" border=\"0\" title=\"".___("TEXT")."\" alt=\"".___("TEXT")."\">&nbsp;".___("TEXT")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/hourglass_add.png\" border=\"0\" title=\"".___("Queue-Eintrag hinzufügen, zum Versenden vorbereiten")."\" alt=\"".___("Queue-Eintrag hinzufügen, zum Versenden vorbereiten")."\">&nbsp;".___("Queue-Eintrag hinzufügen, zum Versenden vorbereiten")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/hourglass_delete.png\" border=\"0\" title=\"".___("Alle Queue-Eintraege loeschen")."\" alt=\"".___("Alle Queue-Eintraege loeschen")."\">&nbsp;".___("Alle Queue-Einträge für diesen Newsletter lÖschen")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/hourglass_go.png\" border=\"0\" title=\"".___("Queue-Eintraege fuer Newsletter anzeigen")."\" alt=\"".___("Queue-Eintraege fuer Newsletter anzeigen")."\">&nbsp;".___("Queue-Eintraege für Newsletter anzeigen")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/email_go.png\" border=\"0\" title=\"".___("Versenden")."\" alt=\"".___("Versenden")."\">&nbsp;".___("Versenden")."<br>";

//link zur geparsten onlineversion!
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/eye.png\" border=\"0\" title=\"".___("Online")."\" alt=\"".___("Online")."\">&nbsp;".___("Onlineversion des Newsletter anzeigen")."<br>";
//link zum bild
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/photo.png\" border=\"0\" title=\"".___("Bild anzeigen")."\" alt=\"".___("Bild anzeigen")."\">&nbsp;".___("verknüpftes Bild anzeigen")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/photo_delete.png\" border=\"0\" title=\"".___("Bild loeschen")."\" alt=\"".___("Bild loeschen")."\">&nbsp;".___("verknüpftes Bild lÖschen")."<br>";
//attachement
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/attach.png\" border=\"0\" title=\"".___("Anhang anzeigen")."\" alt=\"".___("Anhang anzeigen")."\">&nbsp;".___("Anhang anzeigen")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/link_break.png\" border=\"0\" title=\"".___("Anhang loeschen")."\" alt=\"".___("Anhang loeschen")."\">&nbsp;".___("Anhang lÖschen")."<br>";
//link zur html datei!
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/page_white_world.png\" border=\"0\" title=\"".___("HTML-Datei anzeigen")."\" alt=\"".___("HTML-Datei anzeigen")."\">&nbsp;".___("verknüpfte HTML Datei anzeigen")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/page_white_delete.png\" border=\"0\" title=\"".___("HTML-Datei loeschen")."\" alt=\"".___("HTML-Datei loeschen")."\">&nbsp;".___("verknüpfte HTML-Datei lÖschen")."<br>";
//link zum link
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/page_white_link.png\" border=\"0\" title=\"".___("Link")."\" alt=\"".___("Link")."\">&nbsp;".___("verknüpften Link anzeigen")."<br>";

$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/tick.png\" border=\"0\" title=\"".___("Aktiv")."\" alt=\"".___("Aktiv")."\">";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/cancel.png\" border=\"0\" title=\"".___("Inaktiv")."\" alt=\"".___("Inaktiv")."\">&nbsp;".___("Newsletter ist Aktiv/Inaktiv (Klick=Deaktivieren/Aktivieren)")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/pencil.png\" border=\"0\" title=\"".___("Bearbeiten")."\" alt=\"".___("Bearbeiten")."\">&nbsp;".___("Bearbeiten")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/bullet_add.png\" border=\"0\" title=\"".___("Newsletter kopieren")."\" alt=\"".___("Newsletter kopieren")."\">&nbsp;".___("Newsletter kopieren (ohne Dateien)")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/add.png\" border=\"0\" title=\"".___("Newsletter und Dateien kopieren")."\" alt=\"".___("Newsletter und Dateien kopieren")."\">&nbsp;".___("Newsletter und Dateien kopieren")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/chart_pie.png\" border=\"0\" title=\"".___("Statistik")."\" alt=\"".___("Statistik")."\">&nbsp;".___("Statistik anzeigen")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/cross.png\" border=\"0\" title=\"".___("Loeschen")."\" alt=\"".___("Loeschen")."\">&nbsp;".___("Newsletter lÖschen")."<br>";

$_MAIN_OUTPUT.= "<h3>Status</h3>";

$sc=count($STATUS['nl']['status']);
for ($scc=1; $scc<=$sc; $scc++)//0
{
	$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/".$STATUS['nl']['statimg'][$scc]."\" border=\"0\" title=\"".$STATUS['nl']['descr'][$scc]."\" alt=\"".$STATUS['nl']['descr'][$scc]."\">";
	$_MAIN_OUTPUT.= "  ".$STATUS['nl']['status'][$scc]."  (".$STATUS['nl']['descr'][$scc].")<br>";
}

$_MAIN_OUTPUT.= "</div><br><br>";
$_MAIN_OUTPUT.= "</div><br><br>";
if ($user_is_expert) $_MAIN_OUTPUT.= "
<script type=\"text/javascript\">
	switchSection('legende');
</script>";

?>