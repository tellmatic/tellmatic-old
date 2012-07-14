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
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/script.png\" border=\"0\" title=\"Logfile anzeigen\" alt=\"Logfile anzeigen\"> <img src=\"".$mnl_iconURL."/script_lightning.png\" border=\"0\" title=\"Logfile anzeigen\" alt=\"Logfile anzeigen\">  Logfile anzeigen<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/script_delete.png\" border=\"0\" title=\"Logfile loeschen\" alt=\"Logfile loeschen\"> Logfile loeschen<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/email_go.png\" border=\"0\" title=\"Diesen Eintrag versenden\" alt=\"Diesen Eintrag versenden\">  Diesen Eintrag versenden<br>";
//$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/chart_pie.png\" border=\"0\" title=\"Statistik anzeigen\" alt=\"Statistik anzeigen\">  Statistik anzeigen<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/control_stop.png\" border=\"0\" title=\"Anhalten\" alt=\"Anhalten\"> Anhalten<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/control_play.png\" border=\"0\" title=\"Fortfahren\" alt=\"Fortfahren\"> Fortfahren<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/cross.png\" border=\"0\" title=\"Loeschen\" alt=\"Loeschen\">  Q loeschen<br>";

$_MAIN_OUTPUT.= "<h3>Status</h3>";

$sc=count($STATUS['q']['status']);
for ($scc=1; $scc<=$sc; $scc++)//0
{
	$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/".$STATUS['q']['statimg'][$scc]."\" border=\"0\"  title=\"".$STATUS['q']['descr'][$scc]."\" alt=\"".$STATUS['q']['descr'][$scc]."\">";
	$_MAIN_OUTPUT.= "  ".$STATUS['q']['status'][$scc]."  (".$STATUS['q']['descr'][$scc].")<br>";
}

$_MAIN_OUTPUT.= "</div><br><br>";
$_MAIN_OUTPUT.= "<script type=\"text/javascript\">
<!--	
switchSection('legende'); 
-->
</script>";

?>