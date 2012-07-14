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
$_MAIN_OUTPUT.= "<strong>".___("Eigenschaften")."</strong><br>";
$_MAIN_OUTPUT.= tm_icon("page_white_lightning.png",___("Standardgruppe"))."&nbsp;".___("Standardgruppe (kann nicht de-aktiviert und gelöscht werden)")."<br>";
$_MAIN_OUTPUT.= tm_icon("cup.png",___("Gruppe ist öffentlich"))."&nbsp;".___("Gruppe ist öffentlich.")."<br>";
$_MAIN_OUTPUT.= "<br><strong>".___("Aktionen")."</strong><br>";
$_MAIN_OUTPUT.= tm_icon("tick.png",___("Gruppe ist Aktiv"))."&nbsp;";
$_MAIN_OUTPUT.= tm_icon("cancel.png",___("Gruppe ist Inaktiv"))."&nbsp;".___("Gruppe ist Aktiv/Inaktiv (Klick=Deaktivieren/Aktivieren)")."<br>";
$_MAIN_OUTPUT.= tm_icon("pencil.png",___("Bearbeiten"))."&nbsp;".___("Bearbeiten")."<br>";
$_MAIN_OUTPUT.= tm_icon("vcard_add.png",___("Adresse in dieser Gruppe erstellen"))."&nbsp;".___("Adresse in dieser Gruppe erstellen")."<br>";
$_MAIN_OUTPUT.= tm_icon("group_go.png",___("Adressen dieser Gruppe anzeigen"))."&nbsp;".___("Adressen dieser Gruppe anzeigen")."<br>";
$_MAIN_OUTPUT.= tm_icon("chart_pie.png",___("Statistik anzeigen"))."&nbsp;".___("Statistik anzeigen")."<br>";
$_MAIN_OUTPUT.= tm_icon("page_white_go.png",___("Diese Gruppe als Standardgruppe definieren"))."&nbsp;".___("Diese Gruppe als Standardgruppe definieren")."<br>";
$_MAIN_OUTPUT.= tm_icon("cross.png",___("Gruppe löschen und Adressen der Standardgruppe zuordnen"))."&nbsp;".___("Gruppe löschen und Adressen der Standardgruppe zuordnen")."<br>";
$_MAIN_OUTPUT.= tm_icon("bomb.png",___("Gruppe löschen und Adressen der Gruppe löschen"))."&nbsp;".___("Gruppe löschen und Adressen der Gruppe löschen (Adressen werden komplett gelöscht und auch aus allen anderen Gruppen entfernt!)")."<br>";
$_MAIN_OUTPUT.= tm_icon("hourglass_go.png",___("Q für diese Gruppe anzeigen"))."&nbsp;".___("Q für diese Gruppe anzeigen")."<br>";
$_MAIN_OUTPUT.= tm_icon("arrow_switch.png",___("Empfängerliste aktualisieren"),"","","","email_go.png")."&nbsp;".___("Adressen nachfassen / Empfängerliste aktualisieren")."<br>";
$_MAIN_OUTPUT.= tm_icon("script.png",___("Logbuch anzeigen"))."&nbsp;".___("Logbuch anzeigen")."<br>";
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