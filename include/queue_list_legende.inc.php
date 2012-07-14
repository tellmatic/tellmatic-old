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
$_MAIN_OUTPUT.="<br><b><a href=\"javascript:switchSection('legende')\" title=\"".___("Legende / Status ein-ausblenden")."\">".tm_icon("rainbow.png",___("Legende / Status"))."&nbsp;".___("Legende / Status")."</a></b>";
$_MAIN_OUTPUT.= "<div id=\"legende\" class=\"legende\">";

$_MAIN_OUTPUT.= "<h3>".___("Legende")."</h3>";
$_MAIN_OUTPUT.= "<strong>".___("Eigenschaften")."</strong><br>";
$_MAIN_OUTPUT.= tm_icon("ruby.png",___("Blacklist prüfen"))."&nbsp;".___("Blacklist prüfen")."<br>";
$_MAIN_OUTPUT.= "<br><strong>".___("Aktionen")."</strong><br>";
$_MAIN_OUTPUT.= tm_icon("script.png",___("Logfile anzeigen")).tm_icon("script_lightning.png",___("Logfile anzeigen"))."&nbsp;".___("Logfile anzeigen")."<br>";
$_MAIN_OUTPUT.= tm_icon("script_delete.png",___("Logfile loeschen"))."&nbsp;".___("Logfile lÖschen")."<br>";
$_MAIN_OUTPUT.= tm_icon("email_go.png",___("Diesen Eintrag versenden"))."&nbsp;".___("Diesen Eintrag versenden")."<br>";
$_MAIN_OUTPUT.= tm_icon("control_stop.png",___("Anhalten"))."&nbsp;".___("Anhalten")."<br>";
$_MAIN_OUTPUT.= tm_icon("control_play.png",___("Fortfahren"))."&nbsp;".___("Fortfahren")."<br>";
$_MAIN_OUTPUT.= tm_icon("cross.png",___("Löschen"))."&nbsp;".___("Q löschen")."<br>";
$_MAIN_OUTPUT.= tm_icon("bullet_delete.png",___("Q komplett Löschen"),"","","","cross.png")."&nbsp;".___("Q Komplett löschen, auch Historie")."<br>";
$_MAIN_OUTPUT.= tm_icon("arrow_refresh.png",___("Ansicht aktualisieren"))."&nbsp;".___("Ansicht aktualisieren")."<br>";
$_MAIN_OUTPUT.= "<br><strong>".___("Status")."</strong><br>";

$sc=count($STATUS['q']['status']);
for ($scc=1; $scc<=$sc; $scc++)//0
{
	$_MAIN_OUTPUT.= tm_icon($STATUS['q']['statimg'][$scc], display($STATUS['q']['descr'][$scc]))."&nbsp;".display($STATUS['q']['descr'][$scc])."<br>";
}

$_MAIN_OUTPUT.= "</div><br><br>";
if ($user_is_expert) $_MAIN_OUTPUT.= "
<script type=\"text/javascript\">
	switchSection('legende');
</script>";
?>