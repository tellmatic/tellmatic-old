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
/* Besuchen Sie die Homepage für Updates und weitere Infos                     */
/********************************************************************************/

$_MAIN_DESCR=___("Bitte aus dem Menü wählen.")."<br>";
$_MAIN_MESSAGE="";
$_MAIN_OUTPUT="";
$_MAIN_HELP="";

if (file_exists($mnl_path."/install.php")) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".___("ACHTUNG! /install.php existiert! Die Datei install.php bitte nach erfolgreicher Installation verschieben oder löschen!")."</b></font>";
}

if (is_writeable($mnl_includepath)) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("ACHTUNG! %s ist nicht Schreibgeschützt"),$mnl_includepath)."</b></font>";
	if (@chmod ($mnl_includepath, 0755)) {
		$_MAIN_MESSAGE.="<br><font size=2 color=green>".sprintf(___("Rechte für %s wurden geändert!"),$mnl_includepath)."</font>";
	} else {
		$_MAIN_MESSAGE.="<br><font size=2 color=blue>".sprintf(___("Rechte für %s konnten nicht geändert werden! Bitte ändern Sie diese manuell."),$mnl_includepath)."</font>";
	}
	if (@chmod ($mnl_includepath."/mnl_config.inc", 0755)) {
		$_MAIN_MESSAGE.="<br><font size=2 color=green>".___("Rechte für mnl_config.inc wurden geändert!")."</font>";
	} else {
		$_MAIN_MESSAGE.="<br><font size=2 color=blue>".___("Rechte für mnl_config.inc konnten nicht geändert werden! Bitte ändern Sie diese manuell.")."</font>";
	}
}
if (!is_writeable($mnl_tmppath)) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("Keine Schreibrechte für %s"),$mnl_datapath)."</b></font>";
}

if (!is_writeable($mnl_datapath)) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("Keine Schreibrechte für %s"),$mnl_datapath)."</b></font>";
}
if (!is_writeable($mnl_nlpath)) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("Keine Schreibrechte für %s"),$mnl_nlpath)."</b></font>";
}
if (!is_writeable($mnl_nlattachpath)) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("Keine Schreibrechte für %s"),$mnl_nlattachpath)."</b></font>";
}
if (!is_writeable($mnl_nlimgpath)) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("Keine Schreibrechte für %s"),$mnl_nlimgpath)."</b></font>";
}
if (!is_writeable($mnl_logpath)) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("Keine Schreibrechte für %s"),$mnl_logpath)."</b></font>";
}
if (!is_writeable($mnl_formpath)) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("Keine Schreibrechte für %s"),$mnl_formpath)."</b></font>";
}

if (!file_exists($mnl_includepath."/.htaccess")) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("ACHTUNG! %s ist nicht Passwortgeschützt"),$mnl_includepath)."</b></font>";
}
if (!file_exists($mnl_datapath."/.htaccess")) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("ACHTUNG! %s ist nicht Passwortgeschützt"),$mnl_datapath)."</b></font>";
}
if (!file_exists($mnl_logpath."/.htaccess")) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("ACHTUNG! %s ist nicht Passwortgeschützt"),$mnl_logpath)."</b></font>";
}


include_once ($mnl_includepath."/help_section.inc");
include_once ($mnl_includepath."/".$action.".inc");

$_MAIN_DESCR="<img src=\"".$mnl_iconURL."/help.png\" border=\"0\" onclick=\"javascript:switchSection('main_help');\">&nbsp;&nbsp;".$_MAIN_DESCR;

if ($user_is_expert) $_MAIN_OUTPUT.= "
<script type=\"text/javascript\">
	switchSection('main_help');
</script>";

if (!empty($_ERROR['html'])) {
	$_MAIN_MESSAGE.="<hr noshade><br>".$_ERROR['html']."<br><hr noshade><br>";
}

$pwchanged=getVar("pwchanged");
$cryptpw=getVar("cryptpw");
if ($pwchanged==1) {
	$_MAIN_MESSAGE.="<br>".___("Passwort wurde gespeichert und ist ab sofort gültig.").
										"<br>".___("Achtung! Passwort muss in include/.htpasswd manuell angepasst werden.").
										"<br>crypt: <font color=red>".$cryptpw."</font>";
}

if (!empty($_MAIN_MESSAGE)) {
	$_MAIN_MESSAGE="<font size=-1>".
			"<a href=\"javascript:switchSection('main_info')\">".
			"<img src=\"".$mnl_iconURL."/exclamation.png\" border=\"0\">".
			"(".___("Informationen ausblenden").")</a>".
			"</font><br><br>".$_MAIN_MESSAGE;

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