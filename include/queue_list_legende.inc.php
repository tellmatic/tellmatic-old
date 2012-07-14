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
$_MAIN_OUTPUT.= tm_icon("arrow_refresh.png",___("Ansicht aktualisieren"))."&nbsp;".___("Ansicht aktualisieren")."<br>";
$_MAIN_OUTPUT.= "<strong>".___("Eigenschaften")."</strong><br>";
$_MAIN_OUTPUT.= tm_icon("ruby.png",___("Blacklist prüfen"))."&nbsp;".___("Blacklist prüfen")."<br>";
$_MAIN_OUTPUT.= tm_icon("bullet_green.png",___("Empfängerliste automatisch erstellen / aktualisieren  und Q starten"),"","","","cog.png")."&nbsp;";
$_MAIN_OUTPUT.= tm_icon("bullet_yellow.png",___("Empfängerliste automatisch erstellen / aktualisieren  und Q starten"),"","","","cog.png")."&nbsp;";
$_MAIN_OUTPUT.= tm_icon("bullet_black.png",___("Empfängerliste automatisch erstellen / aktualisieren  und Q starten"),"","","","cog.png")."&nbsp;".___("Empfängerliste automatisch erstellen/aktualisieren und Q starten (geplant, aktiv, beendet)")."<br>";
$_MAIN_OUTPUT.= "<br><strong>".___("Aktionen")."</strong><br>";
$_MAIN_OUTPUT.= tm_icon("arrow_switch.png",___("Empfängerliste aktualisieren"),"","","","email_go.png")."&nbsp;".___("Adressen nachfassen / Empfängerliste aktualisieren")."<br>";
$_MAIN_OUTPUT.= tm_icon("script.png",___("Logfile anzeigen")).tm_icon("script_lightning.png",___("Logfile anzeigen"))."&nbsp;".___("Logfile anzeigen")."<br>";
$_MAIN_OUTPUT.= tm_icon("script_delete.png",___("Logfile loeschen"))."&nbsp;".___("Logfile löschen")."<br>";
$_MAIN_OUTPUT.= tm_icon("bullet_star.png",___("Diesen Eintrag versenden"),"","","","email_go.png")."&nbsp;".___("Diesen Eintrag versenden")."<br>";
$_MAIN_OUTPUT.= tm_icon("control_stop.png",___("Anhalten"))."&nbsp;".___("Anhalten")."<br>";
$_MAIN_OUTPUT.= tm_icon("control_play.png",___("Fortfahren"))."&nbsp;".___("Fortfahren")."<br>";
$_MAIN_OUTPUT.= tm_icon("cross.png",___("Löschen"))."&nbsp;".___("Q löschen")."<br>";
$_MAIN_OUTPUT.= tm_icon("bullet_delete.png",___("Q komplett Löschen"),"","","","cross.png")."&nbsp;".___("Q Komplett löschen, auch Historie")."<br>";
$_MAIN_OUTPUT.= tm_icon("script.png",___("Logbuch anzeigen"))."&nbsp;".___("Logbuch anzeigen")."<br>";

$_MAIN_OUTPUT.= "<br><strong>".___("Status")."</strong><br>";
$sc=count($STATUS['q']['status']);
for ($scc=1; $scc<=$sc; $scc++)//0
{
	$_MAIN_OUTPUT.= tm_icon($STATUS['q']['statimg'][$scc], display($STATUS['q']['descr'][$scc]))."&nbsp;".display($STATUS['q']['descr'][$scc])."<br>";
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