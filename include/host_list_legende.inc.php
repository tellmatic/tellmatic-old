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
$_MAIN_OUTPUT.= tm_icon("server_compressed.png",___("SMTP"));
$_MAIN_OUTPUT.= tm_icon("server_uncompressed.png",___("POP3"));
$_MAIN_OUTPUT.= tm_icon("server_database.png",___("IMAP4"))."&nbsp;".___("Mail-Server ist vom Typ SMTP/POP3/IMAP)")."<br>";
$_MAIN_OUTPUT.= tm_icon("lock.png",___("SSL"))."&nbsp;".___("Mail-Server benutzt SSL (SMTP)")."<br>";
$_MAIN_OUTPUT.= tm_icon("lightning.png",___("Standard SMTP Host"),"","","","server_compressed.png")."&nbsp;".___("Standard SMTP Host (kann nicht de-aktiviert und gelöscht werden)")."<br>";
$_MAIN_OUTPUT.= "<br><strong>".___("Aktionen")."</strong><br>";
$_MAIN_OUTPUT.= tm_icon("tick.png",___("Mail-Server ist Aktiv"));
$_MAIN_OUTPUT.= tm_icon("cancel.png",___("Mail-Server ist Inaktiv"))."&nbsp;".___("Mail-Server ist Aktiv/Inaktiv (Klick=Deaktivieren/Aktivieren)")."<br>";
$_MAIN_OUTPUT.= tm_icon("arrow_right.png",___("Standard SMTP Host"),"","","","server_compressed.png")."&nbsp;".___("Diesen SMTP-Host als standard SMTP-Host festlegen")."<br>";
$_MAIN_OUTPUT.= tm_icon("server_connect.png",___("Server testen"))."&nbsp;".___("Server testen")."<br>";
$_MAIN_OUTPUT.= tm_icon("pencil.png",___("Bearbeiten"))."&nbsp;".___("Bearbeiten")."<br>";
#$_MAIN_OUTPUT.= tm_icon("chart_pie.png",___("Statistik anzeigen"))."&nbsp;".___("Statistik anzeigen")."<br>";
$_MAIN_OUTPUT.= tm_icon("cross.png",___("Mail-Server löschen"))."&nbsp;".___("Mail-Server löschen")."<br>";
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