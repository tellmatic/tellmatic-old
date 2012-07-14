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

if (file_exists($tm_path."/install.php")) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".___("ACHTUNG! /install.php existiert! Die Datei install.php bitte nach erfolgreicher Installation verschieben oder löschen!")."</b></font>";
}

if (is_writeable($tm_includepath."/tm_config.inc.php")) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".___("tm_config.inc ist nicht schreibgeschützt!")." </b></font>";
	if (@chmod ($tm_includepath."/tm_config.inc.php", 0755)) {
		$_MAIN_MESSAGE.="<br><font size=2 color=green>".___("Rechte für tm_config.inc wurden geändert!")."</font>";
	} else {
		$_MAIN_MESSAGE.="<br><font size=2 color=red>".___("Rechte für tm_config.inc konnten nicht geändert werden! Bitte ändern Sie diese manuell.")."</font>";
	}
}

if (!is_writeable($tm_path."/admin/tmp")) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("Keine Schreibrechte für %s"),$tm_path."/admin/tmp")."</b></font>";
}
if (!is_writeable($tm_datapath)) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("Keine Schreibrechte für %s"),$tm_datapath)."</b></font>";
}
if (!is_writeable($tm_nlpath)) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("Keine Schreibrechte für %s"),$tm_nlpath)."</b></font>";
}
if (!is_writeable($tm_nlattachpath)) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("Keine Schreibrechte für %s"),$tm_nlattachpath)."</b></font>";
}
if (!is_writeable($tm_nlimgpath)) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("Keine Schreibrechte für %s"),$tm_nlimgpath)."</b></font>";
}
if (!is_writeable($tm_logpath)) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("Keine Schreibrechte für %s"),$tm_logpath)."</b></font>";
}
if (!is_writeable($tm_formpath)) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("Keine Schreibrechte für %s"),$tm_formpath)."</b></font>";
}
if (!is_writeable($tm_tmppath)) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("Keine Schreibrechte für %s"),$tm_tmppath)."</b></font>";
}
if (!is_writeable($tm_reportpath)) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("Keine Schreibrechte für %s"),$tm_reportpath)."</b></font>";
}

if (!file_exists($tm_path."/admin/tmp/.htaccess")) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("ACHTUNG! %s ist nicht Passwortgeschützt"),$tm_path."/admin/tmp/")."</b></font>";
}
if (!file_exists($tm_includepath."/.htaccess")) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("ACHTUNG! %s ist nicht Passwortgeschützt"),$tm_includepath)."</b></font>";
}
if (!file_exists($tm_datapath."/.htaccess")) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("ACHTUNG! %s ist nicht Passwortgeschützt"),$tm_datapath)."</b></font>";
}
if (!file_exists($tm_logpath."/.htaccess")) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("ACHTUNG! %s ist nicht Passwortgeschützt"),$tm_logpath)."</b></font>";
}
if (!file_exists($tm_tmppath."/.htaccess")) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("ACHTUNG! %s ist nicht Passwortgeschützt"),$tm_tmppath)."</b></font>";
}
if (!file_exists($tm_reportpath."/.htaccess")) {
	$_MAIN_MESSAGE.="<br><font size=2 color=red><b>".sprintf(___("ACHTUNG! %s ist nicht Passwortgeschützt"),$tm_reportpath)."</b></font>";
}

if ($logged_in) {
	$_MAIN_DESCR=___("Bitte aus dem Menü wählen.");
	require_once ($tm_includepath."/help_section.inc.php");

	switch ($action) {
		//default:
		default : require_once ($tm_includepath."/Welcome.inc.php"); break;
		case 'Welcome' : require_once ($tm_includepath."/Welcome.inc.php"); break;
		//admin
		case 'adm_set' : if ($user_is_admin) require_once ($tm_includepath."/adm_set.inc.php"); break;
		case 'adm_user_list' :  if ($user_is_admin) require_once ($tm_includepath."/adm_user_list.inc.php"); break;
		case 'adm_user_edit' :  if ($user_is_admin) require_once ($tm_includepath."/adm_user_edit.inc.php"); break;
		case 'adm_user_new' :  if ($user_is_admin) require_once ($tm_includepath."/adm_user_new.inc.php"); break;
		//user
		case 'user' : require_once ($tm_includepath."/user.inc.php"); break;
		//verwaltung
		case 'bounce' : if ($user_is_manager) require_once ($tm_includepath."/bounce.inc.php"); break;
		case 'adr_clean' : if ($user_is_manager) require_once ($tm_includepath."/adr_clean.inc.php"); break;
		//newsletter
		case 'nl_grp_list' : require_once ($tm_includepath."/nl_grp_list.inc.php"); break;
		case 'nl_grp_new' : require_once ($tm_includepath."/nl_grp_new.inc.php"); break;
		case 'nl_grp_edit' : require_once ($tm_includepath."/nl_grp_edit.inc.php"); break;
		case 'nl_list' : require_once ($tm_includepath."/nl_list.inc.php"); break;
		case 'nl_new' : require_once ($tm_includepath."/nl_new.inc.php"); break;
		case 'nl_edit' : require_once ($tm_includepath."/nl_edit.inc.php"); break;
		case 'queue_new' : require_once ($tm_includepath."/queue_new.inc.php"); break;
		case 'queue_list' : require_once ($tm_includepath."/queue_list.inc.php"); break;
		case 'queue_send' : require_once ($tm_includepath."/queue_send.inc.php"); break;
		//adressen
		case 'adr_grp_list' : require_once ($tm_includepath."/adr_grp_list.inc.php"); break;
		case 'adr_grp_new' : require_once ($tm_includepath."/adr_grp_new.inc.php"); break;
		case 'adr_grp_edit' : require_once ($tm_includepath."/adr_grp_edit.inc.php"); break;
		case 'adr_list' : require_once ($tm_includepath."/adr_list.inc.php"); break;
		case 'adr_new' : require_once ($tm_includepath."/adr_new.inc.php"); break;
		case 'adr_edit' : require_once ($tm_includepath."/adr_edit.inc.php"); break;
		case 'adr_import' : if ($user_is_manager) require_once ($tm_includepath."/adr_import.inc.php"); break;
		case 'adr_export' : if ($user_is_manager) require_once ($tm_includepath."/adr_export.inc.php"); break;
		//formulare
		case 'form_list' : require_once ($tm_includepath."/form_list.inc.php"); break;
		case 'form_new' : require_once ($tm_includepath."/form_new.inc.php"); break;
		case 'form_edit' : require_once ($tm_includepath."/form_edit.inc.php"); break;
		//tools
		case 'filemanager' : require_once ($tm_includepath."/filemanager.inc.php"); break;
		//status + statistik
		case 'status' : require_once ($tm_includepath."/status.inc.php"); break;
		case 'status_top_x' : require_once ($tm_includepath."/status_top_x.inc.php"); break;
		case 'status_map' : require_once ($tm_includepath."/status_map.inc.php"); break;
		case 'statistic' : require_once ($tm_includepath."/statistic.inc.php"); break;
	}//switch act

	$_MAIN_DESCR.=" (".TM_SITEID.")";
	//icon hilfe
	$_MAIN_DESCR="<img src=\"".$tm_iconURL."/help.png\" border=\"0\" onclick=\"javascript:switchSection('main_help');\" alt=\"".___("Hilfe")."\">&nbsp;&nbsp;".$_MAIN_DESCR;
	//expertmode, hilfe ausblenden
	if ($user_is_expert) $_MAIN_OUTPUT.= "
	<script type=\"text/javascript\">
		switchSection('main_help');
	</script>";

	//PHP Fehler
	if (!empty($_ERROR['html'])) {
		$_MAIN_MESSAGE.="<hr noshade><br>".$_ERROR['html']."<br><hr noshade><br>";
	}

	if (DEBUG) $_MAIN_MESSAGE.="<br>available_mem=$available_mem Byte";
	if (DEBUG) $_MAIN_MESSAGE.="<br>adr_row_limit=$adr_row_limit";

	$pwchanged=getVar("pwchanged");
	$usr_message=getVar("usr_message",1,"");
	$_MAIN_MESSAGE.=$usr_message;
	if ($pwchanged==1) {
		#$cryptpw=getVar("cryptpw");
		$check=getVar("check");
		if ($check==1) {
			$_MAIN_MESSAGE.="<br>".___("Passwort wurde gespeichert und ist ab sofort gültig.");
		}//check
	}//pwchanged
}//logged in



if (!empty($_MAIN_MESSAGE)) {
	$_MAIN_MESSAGE="<font size=-1>".
			"<a href=\"javascript:switchSection('main_info')\">".
			"<img src=\"".$tm_iconURL."/exclamation.png\" border=\"0\"  alt=\"".___("Hinweise")."\">".
			"(".___("Informationen ausblenden").")</a>".
			"</font><br><br>".$_MAIN_MESSAGE;
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
$_Tpl_Main=new tm_Template();
$_Tpl_Main->setTemplatePath($tm_tplpath."/".$Style);
$_Tpl_Main->setParseValue("_MAIN_DESCR", $_MAIN_DESCR);
$_Tpl_Main->setParseValue("_MAIN_MESSAGE", $_MAIN_MESSAGE);
$_Tpl_Main->setParseValue("_MAIN_HELP", $_MAIN_HELP);
$_Tpl_Main->setParseValue("_MAIN_OUTPUT", $_MAIN_OUTPUT);
$_MAIN=$_Tpl_Main->renderTemplate("Main.html")."\n";
$_MAIN.= "<br><br><center>&copy;-left 2007 <a href=\"http://www.tellmatic.org\" target=\"blank\">".$ApplicationText."</a></center><br><br>";
?>