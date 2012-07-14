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
$_MAIN_OUTPUT.="<br><b><a href=\"javascript:switchSection('legende')\"><img src=\"".$mnl_iconURL."/rainbow.png\" border=\"0\">&nbsp;".___("Legende / Status")."</a></b>";
$_MAIN_OUTPUT.= "<div id=\"legende\" class=\"legende\">";

$_MAIN_OUTPUT.= "<h3>".___("Legende")."</h3>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/script.png\" border=\"0\" title=\"".___("Logfile anzeigen")."\" alt=\"".___("Logfile anzeigen")."\"> <img src=\"".$mnl_iconURL."/script_lightning.png\" border=\"0\" title=\"".___("Logfile anzeigen")."\" alt=\"".___("Logfile anzeigen")."\">&nbsp;".___("Logfile anzeigen")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/script_delete.png\" border=\"0\" title=\"".___("Logfile loeschen")."\" alt=\"".___("Logfile loeschen")."\">&nbsp;".___("Logfile l&ouml;schen")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/email_go.png\" border=\"0\" title=\"".___("Diesen Eintrag versenden")."\" alt=\"".___("Diesen Eintrag versenden")."\">&nbsp;".___("Diesen Eintrag versenden")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/control_stop.png\" border=\"0\" title=\"".___("Anhalten")."\" alt=\"".___("Anhalten")."\">&nbsp;".___("Anhalten")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/control_play.png\" border=\"0\" title=\"".___("Fortfahren")."\" alt=\"".___("Fortfahren")."\">&nbsp;".___("Fortfahren")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/cross.png\" border=\"0\" title=\"".___("Loeschen")."\" alt=\"".___("Loeschen")."\">&nbsp;".___("Q l&ouml;schen")."<br>";

$_MAIN_OUTPUT.= "<h3>".___("Status")."</h3>";

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