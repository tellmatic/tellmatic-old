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
$_MAIN_OUTPUT.= tm_icon("user_green.png",___("Neuangemeldete Adressen sind aktiv"))."&nbsp;/&nbsp;<img src=\"".$tm_iconURL."/user_red.png\" border=\"0\" title=\"".___("Neuangemeldete Adressen sind inaktiv")."\" alt=\"".___("Neuangemeldete Adressen sind inaktiv")."\">&nbsp;".___("Neuangemeldete Adressen sind aktiv/deaktiviert")."<br>";
$_MAIN_OUTPUT.= tm_icon("sport_8ball.png",___("Captcha Spamschutz aktiviert"))."&nbsp;".___("Captcha Spamschutz aktiviert")."<br>";
$_MAIN_OUTPUT.= tm_icon("arrow_refresh.png",___("Double-Opt-In"))."&nbsp;".___("Double-Opt-In aktiviert")."<br>";
//link zur dynamischen onlineversion!
$_MAIN_OUTPUT.= tm_icon("eye.png",___("Online"))."&nbsp;".___("Dynamische Onlineversion anzeigen:")." subscribe.php?fid=[FORMULAR-ID]<br>";
//link zum template
$_MAIN_OUTPUT.= tm_icon("page_white_code.png",___("Template"))."&nbsp;".___("Template anzeigen:")." ".$tm_formdir."/Form_[FORMULAR-ID].html<br>";
//link zur geparsten Version
$_MAIN_OUTPUT.= tm_icon("tick.png",___("Aktiv"));
$_MAIN_OUTPUT.= tm_icon("cancel.png",___("Inaktiv"))."&nbsp;".___("Formular ist Aktiv/Inaktiv (Klick=Deaktivieren/Aktivieren)")."<br>";
$_MAIN_OUTPUT.= tm_icon("pencil.png",___("Bearbeiten"))."&nbsp;".___("Bearbeiten")."<br>";
$_MAIN_OUTPUT.= tm_icon("add.png",___("Kopieren"))."&nbsp;".___("Formular kopieren")."<br>";
$_MAIN_OUTPUT.= tm_icon("chart_pie.png",___("Statistik"))."&nbsp;".___("Statistik anzeigen")."<br>";
$_MAIN_OUTPUT.= tm_icon("cross.png",___("Löschen"))."&nbsp;".___("Formular löschen")."<br>";
$_MAIN_OUTPUT.= "</div><br><br>";
if ($user_is_expert) $_MAIN_OUTPUT.= "
<script type=\"text/javascript\">
	switchSection('legende');
</script>";


?>