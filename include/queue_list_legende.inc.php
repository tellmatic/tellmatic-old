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
$_MAIN_OUTPUT.= tm_icon("script.png",___("Logfile anzeigen")).tm_icon("script_lightning.png",___("Logfile anzeigen"))."&nbsp;".___("Logfile anzeigen")."<br>";
$_MAIN_OUTPUT.= tm_icon("script_delete.png",___("Logfile loeschen"))."&nbsp;".___("Logfile lÖschen")."<br>";
$_MAIN_OUTPUT.= tm_icon("email_go.png",___("Diesen Eintrag versenden"))."&nbsp;".___("Diesen Eintrag versenden")."<br>";
$_MAIN_OUTPUT.= tm_icon("control_stop.png",___("Anhalten"))."&nbsp;".___("Anhalten")."<br>";
$_MAIN_OUTPUT.= tm_icon("control_play.png",___("Fortfahren"))."&nbsp;".___("Fortfahren")."<br>";
$_MAIN_OUTPUT.= tm_icon("cross.png",___("Löschen"))."&nbsp;".___("Q löschen")."<br>";
$_MAIN_OUTPUT.= tm_icon("arrow_refresh.png",___("Ansicht aktualisieren"))."&nbsp;".___("Ansicht aktualisieren")."<br>";

$_MAIN_OUTPUT.= "<h3>".___("Status")."</h3>";

$sc=count($STATUS['q']['status']);
for ($scc=1; $scc<=$sc; $scc++)//0
{
	$_MAIN_OUTPUT.= "<img src=\"".$tm_iconURL."/".$STATUS['q']['statimg'][$scc]."\" border=\"0\"  title=\"".$STATUS['q']['descr'][$scc]."\" alt=\"".$STATUS['q']['descr'][$scc]."\">";
	$_MAIN_OUTPUT.= "  ".$STATUS['q']['status'][$scc]."  (".$STATUS['q']['descr'][$scc].")<br>";
}

$_MAIN_OUTPUT.= "</div><br><br>";
if ($user_is_expert) $_MAIN_OUTPUT.= "
<script type=\"text/javascript\">
	switchSection('legende');
</script>";
?>