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
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/page_white_lightning.png\" border=\"0\" title=\"".___("Standardgruppe")."\" alt=\"".___("Standardgruppe")."\">&nbsp;".___("Standardgruppe (kann nicht de-aktiviert und gel&ouml;scht werden)")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/tick.png\" border=\"0\" title=\"".___("Aktiv")."\" alt=\"".___("Aktiv")."\">";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/cancel.png\" border=\"0\" title=\"".___("Inaktiv")."\" alt=\"".___("Inaktiv")."\">&nbsp;".___("Gruppe ist Aktiv/Inaktiv (Klick=Deaktivieren/Aktivieren)")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/pencil.png\" border=\"0\" title=\"".___("Bearbeiten")."\" alt=\"".___("Bearbeiten")."\">&nbsp;".___("Bearbeiten")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/newspaper_add.png\" border=\"0\" title=\"".___("Newsletter in dieser Gruppe erstellen")."\" alt=\"".___("Newsletter in dieser Gruppe erstellen")."\">&nbsp;".___("Newsletter in dieser Gruppe erstellen")."<br>";	
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/newspaper_go.png\" border=\"0\" title=\"".___("Newsletter dieser Gruppe anzeigen")."\" alt=\"".___("Newsletter dieser Gruppe anzeigen")."\">&nbsp;".___("Newsletter dieser Gruppe anzeigen, Anzahl der Newsletter in dieser Gruppe")."<br>";
//$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/chart_pie.png\" border=\"0\" title=\"".___("Statistik")."\" alt=\"".___("Statistik")."\">&nbsp;".___("Statistik anzeigen")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/page_white_go.png\" border=\"0\" title=\"".___("als Standardgruppe")."\" alt=\"".___("als Standardgruppe")."\">&nbsp;".___("Diese Gruppe als Standardgruppe definieren")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/cross.png\" border=\"0\" title=\"".___("Loeschen")."\" alt=\"".___("Loeschen")."\">&nbsp;".___("Gruppe l&ouml;schen und Newsletter der Standardgruppe zuordnen")."<br>";

$_MAIN_OUTPUT.= "</div><br><br>";
$_MAIN_OUTPUT.= "<script type=\"text/javascript\">
<!--	
//switchSection('legende'); 
-->
</script>";
?>