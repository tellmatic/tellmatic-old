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
$_MAIN_OUTPUT.= tm_icon("page_white_lightning.png",___("Standardgruppe"))."&nbsp;".___("Standardgruppe (kann nicht de-aktiviert und gelöscht werden)")."<br>";
$_MAIN_OUTPUT.= tm_icon("tick.png",___("Aktiv"));
$_MAIN_OUTPUT.= tm_icon("cancel.png",___("Inaktiv"))."&nbsp;".___("Gruppe ist Aktiv/Inaktiv (Klick=Deaktivieren/Aktivieren)")."<br>";
$_MAIN_OUTPUT.= tm_icon("pencil.png",___("Bearbeiten"))."&nbsp;".___("Bearbeiten")."<br>";
$_MAIN_OUTPUT.= tm_icon("newspaper_add.png",___("Newsletter in dieser Gruppe erstellen"))."&nbsp;".___("Newsletter in dieser Gruppe erstellen")."<br>";	
$_MAIN_OUTPUT.= tm_icon("newspaper_go.png",___("Newsletter dieser Gruppe anzeigen"))."&nbsp;".___("Newsletter dieser Gruppe anzeigen, Anzahl der Newsletter in dieser Gruppe")."<br>";
$_MAIN_OUTPUT.= tm_icon("page_white_go.png",___("als Standardgruppe"))."&nbsp;".___("Diese Gruppe als Standardgruppe definieren")."<br>";
$_MAIN_OUTPUT.= tm_icon("cross.png",___("Löschen"))."&nbsp;".___("Gruppe löschen und Newsletter der Standardgruppe zuordnen")."<br>";

$_MAIN_OUTPUT.= "</div><br><br>";
if ($user_is_expert) $_MAIN_OUTPUT.= "
<script type=\"text/javascript\">
	switchSection('legende');
</script>";
?>