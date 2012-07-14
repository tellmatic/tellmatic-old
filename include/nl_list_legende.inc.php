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

//Legende
$_MAIN_OUTPUT.="<br><b><a href=\"#\" title=\"".___("Legende / Status ein-ausblenden")."\" id=\"toggle_legende\">".tm_icon("rainbow.png",___("Legende / Status"))."&nbsp;".___("Legende / Status")."</a></b>";
$_MAIN_OUTPUT.= "<div id=\"legende\" class=\"legende\">";

$_MAIN_OUTPUT.= "<h3>".___("Legende")."</h3>";
$_MAIN_OUTPUT.= "<strong>".___("Eigenschaften")."</strong><br>";
$_MAIN_OUTPUT.= tm_icon("textfield_rename.png",___("Vorlage"))."&nbsp;".___("Dieses NL ist eine Vorlage für neue NL und kann nicht versendet werden.")."<br>";
$_MAIN_OUTPUT.= tm_icon("lorry.png",___("Massenmailing"))."&nbsp;".___("Massenmailing (per BCC:, kein feedback)")."<br>";
$_MAIN_OUTPUT.= tm_icon("user_suit.png",___("personalisierter Newsletter"))."&nbsp;".___("personalisierter Newsletter")." / ";
$_MAIN_OUTPUT.= tm_icon("bullet_star.png",___("personalisierter Newsletter"),"","","","user_suit.png")."&nbsp;".___("personalisiertes Tracking")."<br>";
$_MAIN_OUTPUT.= tm_icon("page_white_office.png",___("TEXT/HTML"))."&nbsp;".___("TEXT/HTML")." | ";
$_MAIN_OUTPUT.= tm_icon("page_white_h.png",___("HTML"))."&nbsp;".___("HTML")." | ";
$_MAIN_OUTPUT.= tm_icon("page_white_text.png",___("TEXT"))."&nbsp;".___("TEXT")."<br>";
$_MAIN_OUTPUT.= "<br><strong>".___("Aktionen")."</strong><br>";
$_MAIN_OUTPUT.= tm_icon("hourglass_add.png",___("Queue-Eintrag hinzufügen, zum Versenden vorbereiten"))."&nbsp;".___("Queue-Eintrag hinzufügen, zum Versenden vorbereiten")."<br>";
$_MAIN_OUTPUT.= tm_icon("hourglass_delete.png",___("Alle Queue-Einträge löschen"))."&nbsp;".___("Alle Queue-Einträge für diesen Newsletter löschen")."<br>";
$_MAIN_OUTPUT.= tm_icon("hourglass_go.png",___("Queue-Einträge für Newsletter anzeigen"))."&nbsp;".___("Queue-Einträge für Newsletter anzeigen")."<br>";
$_MAIN_OUTPUT.= tm_icon("bullet_star.png",___("Versenden"),"","","","email_go.png")."&nbsp;".___("Versenden")."<br>";
//link zur geparsten onlineversion!
$_MAIN_OUTPUT.= tm_icon("eye.png",___("Online"))."&nbsp;".___("Onlineversion des Newsletter anzeigen")."<br>";
//link zum testpart template!
$_MAIN_OUTPUT.= tm_icon("page_white.png",___("Text"))."&nbsp;".___("PlainText Version anzeigen")."<br>";
//link zum link
$_MAIN_OUTPUT.= tm_icon("world_go.png",___("Link öffnen"))."&nbsp;".___("Link öffnen")."<br>";
//link zum bild
$_MAIN_OUTPUT.= tm_icon("photo.png",___("Bild anzeigen"))."&nbsp;".___("verknüpftes Bild anzeigen")."<br>";
$_MAIN_OUTPUT.= tm_icon("photo_delete.png",___("Bild löschen"))."&nbsp;".___("verknüpftes Bild löschen")."<br>";
//link zur html datei!
$_MAIN_OUTPUT.= tm_icon("page_white_world.png",___("HTML-Datei anzeigen"))."&nbsp;".___("verknüpfte HTML Datei anzeigen")."<br>";
$_MAIN_OUTPUT.= tm_icon("page_white_delete.png",___("HTML-Datei löschen"))."&nbsp;".___("verknüpfte HTML-Datei löschen")."<br>";
//link zum link
$_MAIN_OUTPUT.= tm_icon("page_white_link.png",___("Link"))."&nbsp;".___("verknüpften Link anzeigen")."<br>";
$_MAIN_OUTPUT.= tm_icon("tick.png",___("Aktiv"));
$_MAIN_OUTPUT.= tm_icon("cancel.png",___("Inaktiv"))."&nbsp;".___("Newsletter ist Aktiv/Inaktiv (Klick=Deaktivieren/Aktivieren)")."<br>";
$_MAIN_OUTPUT.= tm_icon("cross.png",___("Löschen"))."&nbsp;".___("Newsletter löschen")."<br>";
$_MAIN_OUTPUT.= tm_icon("pencil.png",___("Bearbeiten"))."&nbsp;".___("Newsletter bearbeiten")."<br>";
$_MAIN_OUTPUT.= tm_icon("bullet_add.png",___("Newsletter kopieren"))."&nbsp;".___("Newsletter kopieren (ohne Dateien)")."<br>";
$_MAIN_OUTPUT.= tm_icon("add.png",___("Newsletter und Dateien kopieren"))."&nbsp;".___("Newsletter und Dateien kopieren")."<br>";
$_MAIN_OUTPUT.= tm_icon("chart_pie.png",___("Statistik"))."&nbsp;".___("Statistik anzeigen")."<br>";
$_MAIN_OUTPUT.= tm_icon("chart_bar_delete.png",___("Historie löschen"))."&nbsp;".___("Historie löschen")."<br>";
$_MAIN_OUTPUT.= tm_icon("arrow_switch.png",___("Adressen nachfassen / Empfängerliste aktualisieren"),"","","","email_go.png")."&nbsp;".___("Adressen nachfassen / Empfängerliste aktualisieren")."<br>";
$_MAIN_OUTPUT.= tm_icon("script.png",___("Logbuch anzeigen"))."&nbsp;".___("Logbuch anzeigen")."<br>";

$_MAIN_OUTPUT.= "<br><strong>".___("Status")."</strong><br>";
$sc=count($STATUS['nl']['status']);
for ($scc=1; $scc<=$sc; $scc++)//0
{
	$_MAIN_OUTPUT.= "<span style=\"width:24px;background-color:".$STATUS['nl']['color'][$scc].";\">&nbsp;&nbsp;</span>&nbsp;";
	$_MAIN_OUTPUT.= tm_icon($STATUS['nl']['statimg'][$scc],$STATUS['nl']['descr'][$scc]);
	$_MAIN_OUTPUT.= "  ".$STATUS['nl']['status'][$scc]."  (".$STATUS['nl']['descr'][$scc].")<br>";
}
$_MAIN_OUTPUT.= "</div><br><br>";
$_MAIN_OUTPUT.= "<script type=\"text/javascript\">";
if ($user_is_expert) {
	$_MAIN_OUTPUT.= "
		//switchSection('legende');
		toggleSlide('toggle_legende','legende',1);
		";
} else {
	$_MAIN_OUTPUT.= "
		toggleSlide('toggle_legende','legende',0);
		";
}
$_MAIN_OUTPUT.= "</script>";
?>