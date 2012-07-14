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
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/arrow_refresh.png\" border=\"0\" title=\"".___("Double-Opt-In")."\" alt=\"".___("Double-Opt-In")."\">&nbsp;".___("Double-Opt-In aktiviert")."<br>";

//link zur dynamischen onlineversion!
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/eye.png\" border=\"0\" title=\"".___("Online")."\" alt=\"".___("Online")."\">&nbsp;".___("Dynamische Onlineversion anzeigen:")." subscribe.php?fid=[FORMULAR-ID]<br>";
//link zum template
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/page_white_code.png\" border=\"0\" title=\"".___("Template")."\" alt=\"".___("Template")."\">&nbsp;".___("Template anzeigen:")." ".$mnl_formdir."/Form_[FORMULAR-ID].html<br>";
//link zur geparsten Version
//$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/application_form_magnify.png\" border=\"0\">  statisches, geparstes Onlineformular anzeigen (TEST!): ".$mnl_formdir."/Form_[FORMULAR-ID]_p.html<br>";

$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/tick.png\" border=\"0\"  title=\"".___("Aktiv")."\" alt=\"".___("Aktiv")."\">";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/cancel.png\" border=\"0\" title=\"".___("Inaktiv")."\" alt=\"".___("Inaktiv")."\">&nbsp;".___("Formular ist Aktiv/Inaktiv (Klick=Deaktivieren/Aktivieren)")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/pencil.png\" border=\"0\" title=\"".___("Bearbeiten")."\" alt=\"".___("Bearbeiten")."\">&nbsp;".___("Bearbeiten")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/add.png\" border=\"0\" title=\"".___("Kopieren")."\" alt=\"".___("Kopieren")."\">&nbsp;".___("Formular kopieren")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/chart_pie.png\" border=\"0\" title=\"".___("Statistik")."\" alt=\"".___("Statistik")."\">&nbsp;".___("Statistik anzeigen")."<br>";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/cross.png\" border=\"0\" title=\"".___("Loeschen")."\" alt=\"".___("Loeschen")."\">&nbsp;".___("Formular l&oumlschen")."<br>";

$_MAIN_OUTPUT.= "</div><br><br>";
$_MAIN_OUTPUT.= "<script type=\"text/javascript\">
<!--	
//switchSection('legende'); 
-->
</script>";

?>