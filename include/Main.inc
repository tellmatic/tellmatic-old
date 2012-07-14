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

$_MAIN_DESCR=___("Bitte aus dem Men&uuml; w&auml;hlen.")."<br>";
$_MAIN_MESSAGE="";
$_MAIN_OUTPUT="";
$_MAIN_HELP="";

if (file_exists($mnl_path."/install.php")) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".___("ACHTUNG! /install.php existiert! Die Datei install.php bitte nach erfolgreicher Installation verschieben oder l&aouml;schen!")."</b></font>";
}

if (is_writeable($mnl_includepath)) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("ACHTUNG! %s ist nicht Schreibgesch&uuml;tzt"),$mnl_includepath)."</b></font>";
	if (@chmod ($mnl_includepath, 0755)) {
		$_MAIN_MESSAGE.="<br><font size=2 color=green>".sprintf(___("Rechte f&uuml;r %s wurden ge&auml;ndert!"),$mnl_includepath)."</font>";
	} else {
		$_MAIN_MESSAGE.="<br><font size=2 color=blue>".sprintf(___("Rechte f&uuml;r %s konnten nicht ge&auml;ndert werden! Bitte &auml;ndern Sie diese manuell."),$mnl_includepath)."</font>";
	}
	if (@chmod ($mnl_includepath."/mnl_config.inc", 0755)) {
		$_MAIN_MESSAGE.="<br><font size=2 color=green>".___("Rechte f&uuml;r mnl_config.inc wurden ge&auml;ndert!")."</font>";
	} else {
		$_MAIN_MESSAGE.="<br><font size=2 color=blue>".___("Rechte f&uuml;r mnl_config.inc konnten nicht ge&auml;ndert werden! Bitte &auml;ndern Sie diese manuell.")."</font>";
	}
}
if (!is_writeable($mnl_datapath)) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("Keine Schreibrechte f&uuml;r %s"),$mnl_datapath)."</b></font>";
}
if (!is_writeable($mnl_nlpath)) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("Keine Schreibrechte f&uuml;r %s"),$mnl_nlpath)."</b></font>";
}
if (!is_writeable($mnl_nlattachpath)) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("Keine Schreibrechte f&uuml;r %s"),$mnl_nlattachpath)."</b></font>";
}
if (!is_writeable($mnl_nlimgpath)) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("Keine Schreibrechte f&uuml;r %s"),$mnl_nlimgpath)."</b></font>";
}
if (!is_writeable($mnl_logpath)) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("Keine Schreibrechte f&uuml;r %s"),$mnl_logpath)."</b></font>";
}
if (!is_writeable($mnl_formpath)) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("Keine Schreibrechte f&uuml;r %s"),$mnl_formpath)."</b></font>";
}

if (!file_exists($mnl_includepath."/.htaccess")) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("ACHTUNG! %s ist nicht Passwortgesch&uuml;tzt"),$mnl_includepath)."</b></font>";
}
if (!file_exists($mnl_datapath."/.htaccess")) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("ACHTUNG! %s ist nicht Passwortgesch&uuml;tzt"),$mnl_datapath)."</b></font>";
}
if (!file_exists($mnl_logpath."/.htaccess")) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("ACHTUNG! %s ist nicht Passwortgesch&uuml;tzt"),$mnl_logpath)."</b></font>";
}


include_once ($mnl_includepath."/help_section.inc");
include_once ($mnl_includepath."/".$action.".inc");

$_MAIN_DESCR="<img src=\"".$mnl_iconURL."/help.png\" border=\"0\" onmouseover=\"javascript:switchSection('main_help');\">&nbsp;&nbsp;".$_MAIN_DESCR;

if (!empty($_ERROR['html'])) {
	$_MAIN_MESSAGE.="<hr noshade><br>".$_ERROR['html']."<br><hr noshade><br>";
}

$pwchanged=getVar("pwchanged");
$cryptpw=getVar("cryptpw");
if ($pwchanged==1) {
	$_MAIN_MESSAGE.="<br>".___("Passwort wurde gespeichert und ist ab sofort g&uuml;ltig!")."
										<br>".___("Achtung! Passwort muss in include/.htpasswd manuell angepasst werden.")."
										<br>crypt: <font color=red>".$cryptpw."</font>
										";
}

if (!empty($_MAIN_MESSAGE)) {
	/*
	$_MAIN_MESSAGE.="<br>";
	$_MAIN_MESSAGE="<a href=\"javascript:switchSection('div_debug');\"><img src=\"".$mnl_iconURL."/information.png\" border=\"0\"></a>".$_MAIN_MESSAGE;
	$_MAIN_MESSAGE.="<br>";
	$_MAIN_MESSAGE.="<br>";
	*/
	$_MAIN_MESSAGE="<font size=-1>
			<a href=\"javascript:switchSection('main_info')\">
			<img src=\"".$mnl_iconURL."/exclamation.png\" border=\"0\">
			(".___("Informationen ausblenden").")</a>
			</font><br><br>".$_MAIN_MESSAGE;

	//;setInterval(\"fadein('main_detail')\",25);
	$_MAIN_MESSAGE.="<br><br>";
}

$_MAIN_OUTPUT.= '
<script type="text/javascript">
	<!--
	checkForm();
	-->
</script>
';


//new Template
$_Tpl_Main=new mTemplate();
$_Tpl_Main->setTemplatePath($mnl_tplpath);
$_Tpl_Main->setParseValue("_MAIN_DESCR", $_MAIN_DESCR);
$_Tpl_Main->setParseValue("_MAIN_MESSAGE", $_MAIN_MESSAGE);
$_Tpl_Main->setParseValue("_MAIN_HELP", $_MAIN_HELP);
$_Tpl_Main->setParseValue("_MAIN_OUTPUT", $_MAIN_OUTPUT);
$_MAIN=$_Tpl_Main->renderTemplate("Main.html")."\n";
?>