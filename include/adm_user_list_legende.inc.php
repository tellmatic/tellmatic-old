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
$_MAIN_OUTPUT.= "<img src=\"".$tm_iconURL."/star.png\" border=\"0\" title=\"".___("Ihr Benutzer")."\" alt=\"".___("Ihr Benutzer")."\">&nbsp;".___("Ihr Benutzer")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$tm_iconURL."/user_gray.png\" border=\"0\" title=\"".___("Administrator")."\" alt=\"".___("Administrator")."\">&nbsp;".___("Administrator: Einstellungen ändern, Benutzer verwalten")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$tm_iconURL."/user_red.png\" border=\"0\" title=\"".___("Verwalter")."\" alt=\"".___("Verwalter")."\">&nbsp;".___("Verwalter: Daten Importieren/Exportieren, Bouncemanagement und Bereinigen")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$tm_iconURL."/tux.png\" border=\"0\" title=\"".___("Erfahrener Benutzer")."\" alt=\"".___("Erfahrener Benutzer")."\">&nbsp;".___("Erfahrener Benutzer, Hilfen ausblenden etc.")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$tm_iconURL."/tick.png\" border=\"0\" title=\"".___("Benutzer ist Aktiv")."\" alt=\"".___("Benutzer ist Aktiv")."\">";
$_MAIN_OUTPUT.= "<img src=\"".$tm_iconURL."/cancel.png\" border=\"0\" title=\"".___("Benutzer ist Inaktiv")."\" alt=\"".___("Benutzer ist Inaktiv")."\">&nbsp;".___("Benutzer ist Aktiv/Inaktiv (Klick=Deaktivieren/Aktivieren)")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$tm_iconURL."/pencil.png\" border=\"0\" title=\"".___("Bearbeiten")."\" alt=\"".___("Bearbeiten")."\">&nbsp;".___("Bearbeiten")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$tm_iconURL."/chart_pie.png\" border=\"0\" title=\"".___("Statistik anzeigen")."\" alt=\"".___("Statistik anzeigen")."\">&nbsp;".___("Statistik anzeigen")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$tm_iconURL."/cross.png\" border=\"0\" title=\"".___("Benutzer löschen")."\" alt=\"".___("Benutzer löschen")."\">&nbsp;".___("Benutzer löschen")."<br>";
$_MAIN_OUTPUT.= "</div><br><br>";
if ($user_is_expert) $_MAIN_OUTPUT.= "
<script type=\"text/javascript\">
	switchSection('legende');
</script>";

?>