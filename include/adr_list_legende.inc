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
$_MAIN_OUTPUT.="<br><b><a href=\"javascript:switchSection('legende')\"><img src=\"".$mnl_iconURL."/rainbow.png\" border=\"0\">&nbsp;".___("Legende / Status")."</a></b>";
$_MAIN_OUTPUT.= "<div id=\"legende\" class=\"legende\">";

$_MAIN_OUTPUT.= "<h3>".___("Legende")."</h3>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/tick.png\" border=\"0\" title=\"".___("Aktiv")."\" alt=\"".___("Aktiv")."\">";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/cancel.png\" border=\"0\"  title=\"".___("Inaktiv")."\" alt=\"".___("Inaktiv")."\">&nbsp;".___("Adresse ist Aktiv/Inaktiv (Klick=Deaktivieren/Aktivieren)")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/pencil.png\" border=\"0\"  title=\"".___("Bearbeiten")."\" alt=\"".___("Bearbeiten")."\">&nbsp;".___("Bearbeiten")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/chart_pie.png\" border=\"0\"  title=\"".___("Statistik")."\" alt=\"".___("Statistik")."\">&nbsp;".___("Statistik anzeigen")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/cross.png\" border=\"0\"  title=\"".___("Loeschen")."\" alt=\"".___("Loeschen")."\">&nbsp;".___("Adresse loeschen")."<br>";

$_MAIN_OUTPUT.= "<h3>".___("Status")."</h3>";

$sc=count($STATUS['adr']['status']);
for ($scc=1; $scc<=$sc; $scc++)//0
{
	$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/".$STATUS['adr']['statimg'][$scc]."\" border=\"0\"   title=\"".$STATUS['adr']['descr'][$scc]."\" alt=\"".$STATUS['adr']['descr'][$scc]."\">";
	$_MAIN_OUTPUT.= "  ".$STATUS['adr']['status'][$scc]."  (".$STATUS['adr']['descr'][$scc].")<br>";
}

$_MAIN_OUTPUT.= "</div><br><br>";
if ($user_is_expert) $_MAIN_OUTPUT.= "
<script type=\"text/javascript\">
	switchSection('legende');
</script>";
?>