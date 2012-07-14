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
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/page_white_lightning.png\" border=\"0\" title=\"".___("Standardgruppe")."\" alt=\"Standardgruppe\">&nbsp;".___("Standardgruppe (kann nicht de-aktiviert und gelÖscht werden)")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/tick.png\" border=\"0\" title=\"".___("Gruppe ist Aktiv")."\" alt=\"".___("Gruppe ist Aktiv")."\">";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/cancel.png\" border=\"0\" title=\"".___("Gruppe ist Inaktiv")."\" alt=\"".___("Gruppe ist Inaktiv")."\">&nbsp;".___("Gruppe ist Aktiv/Inaktiv (Klick=Deaktivieren/Aktivieren)")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/pencil.png\" border=\"0\" title=\"".___("Bearbeiten")."\" alt=\"".___("Bearbeiten")."\">&nbsp;".___("Bearbeiten")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/vcard_add.png\" border=\"0\" title=\"".___("Adresse in dieser Gruppe erstellen")."\" alt=\"".___("Adresse in dieser Gruppe erstellen")."\">&nbsp;".___("Adresse in dieser Gruppe erstellen")."<br>";	
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/group_go.png\" border=\"0\" title=\"".___("Adressen dieser Gruppe anzeigen")."\" alt=\"".___("Adressen dieser Gruppe anzeigen")."\"> &nbsp;".___("Adressen dieser Gruppe anzeigen, Anzahl der Adressen in dieser Gruppe")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/chart_pie.png\" border=\"0\" title=\"".___("Statistik anzeigen")."\" alt=\"".___("Statistik anzeigen")."\">&nbsp;".___("Statistik anzeigen")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/page_white_go.png\" border=\"0\" title=\"".___("Diese Gruppe als Standardgruppe definieren")."\" alt=\"".___("Diese Gruppe als Standardgruppe definieren")."\">&nbsp;".___("Diese Gruppe als Standardgruppe definieren")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/cross.png\" border=\"0\" title=\"".___("Gruppe loeschen und Adressen der Standardgruppe zuordnen")."\" alt=\"".___("Gruppe loeschen und Adressen der Standardgruppe zuordnen")."\">&nbsp;".___("Gruppe lÖschen und Adressen der Standardgruppe zuordnen")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/bomb.png\" border=\"0\" title=\"".___("Gruppe loeschen und Adressen der Gruppe loeschen")."\" alt=\"".___("Gruppe loeschen und Adressen der Gruppe loeschen")."\">".___("Gruppe lÖschen und Adressen der Gruppe lÖschen (Adressen werden komplett gelÖscht und auch aus allen anderen Gruppen entfernt!)")."<br>";
$_MAIN_OUTPUT.= "</div><br><br>";
$_MAIN_OUTPUT.= "</div><br><br>";
if ($user_is_expert) $_MAIN_OUTPUT.= "
<script type=\"text/javascript\">
	switchSection('legende');
</script>";

?>