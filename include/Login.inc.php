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

$LOGIN=new tm_CFG();

//Session vorbereiten
session_save_path($tm_tmppath);

/***********************************************************/
//form field names
/***********************************************************/
$InputName_User="user_name";
$InputName_Pass="user_pw";

/***********************************************************/
//false by default
/***********************************************************/
$logged_in=FALSE;
$user_is_expert=FALSE;
$user_is_admin=FALSE;
$user_is_manager=FALSE;

/***********************************************************/
/***********************************************************/
//check login
//log_in[0]: bool: true | false
//log_in[1]: message
/***********************************************************/
$log_in = include(TM_INCLUDEPATH."/Login_guard_ret.inc.php");
$logged_in=$log_in[0];
$_MAIN_MESSAGE.=$log_in[1];

if (DEBUG) $_MAIN_OUTPUT.="\n session id : ".session_id()."<br>\n";
if (DEBUG) {
	if (isset($_COOKIE[session_name()])) {
		$_MAIN_MESSAGE.="\n cookie: ".$_COOKIE[session_name()]."<br>\n";
	} else {
		$_MAIN_MESSAGE.="\n _COOKIE[sessionname], sessionname: ".session_name()." not set yet<br>\n";
	}
}
if (DEBUG) $_MAIN_MESSAGE.="\n old session id: ".session_id()."<br>\n";

/***********************************************************/
//neue sessionid
/***********************************************************/
session_regenerate_id();
if (DEBUG) $_MAIN_MESSAGE.="\n new session id: ".session_id()."<br>\n";

/***********************************************************/
//set cookie
/***********************************************************/
setcookie(session_name(), session_id(), time()+(TM_SESSION_TIMEOUT*10), TM_DIR."/admin", str_replace("https://","",str_replace("http://","",TM_DOMAIN)) );

/***********************************************************/
//expert & admin
/***********************************************************/
if ($logged_in) {
	if ($LOGIN->USER['expert']==1) {
		$user_is_expert=TRUE;
	}
	if ($LOGIN->USER['admin']==1) {
		$user_is_admin=TRUE;
	}
	if ($LOGIN->USER['manager']==1) {
		$user_is_manager=TRUE;
	}
}

/***********************************************************/
//login screen
/***********************************************************/
if (!$logged_in && $action!="logout") {
	$_MAIN_DESCR=___("Bitte melden Sie sich mit Ihrem Benutzernamen und Passwort an.")."<br>";
	require_once (TM_INCLUDEPATH."/Login_form.inc.php");
}
?>