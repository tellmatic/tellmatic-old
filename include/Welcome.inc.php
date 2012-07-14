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

$_HELLO=___("Hallo");
$_USER_NAME=$LOGIN->USER['name'];

$_WELCOME=sprintf(___("Willkommen bei %s"),TM_APPTEXT);
$_LOGGED_IN_AS=sprintf(___("Angemeldet als: %s"),"<b>".$_USER_NAME."</b>");

$_MAIN_HELP.=$_WELCOME."<br>".$_LOGGED_IN_AS;

$_LANG_CODE=$LOGIN->USER['lang'];
$_LANG_IMG_URL=$tm_imgURL."/flags/".$_LANG_CODE.".png";
if ($LOGIN->USER['lang']=="en") {
	$_LANG_IMG_URL=$tm_imgURL."/flags/gb.png";
}
$_LANG_IMG="<img src=\"".$_LANG_IMG_URL."\" border=\"0\" alt=\"".$_LANG_CODE."\" title=\"".$_LANG_CODE."\">";
$_LANG_SELECTED=___("Gewählte Sprache:");
$_LANG_SUPPORTED=___("Verfügbare Sprachen:");
foreach ($LANGUAGES['text'] as $lg) {
	$_LANG_SUPPORTED.="&nbsp;".$lg.",";
}

$_STYLE=___("Layout / Style").": <b>".$LOGIN->USER['style']."</b>";

//get version and messages

if ($C[0]['check_version']==1) {
	$t_new_version=getCurrentVersion();
	$t_messages=getMessages();
}

//new Template
$_Tpl_Welcome=new tm_Template();
$_Tpl_Welcome->setTemplatePath(TM_TPLPATH);

//set parse values
$_Tpl_Welcome->setParseValue("_URL", $tm_URL);
$_Tpl_Welcome->setParseValue("_LOGGED_IN_AS", $_LOGGED_IN_AS);
$_Tpl_Welcome->setParseValue("_WELCOME", $_WELCOME);
$_Tpl_Welcome->setParseValue("_HELLO", $_HELLO);
$_Tpl_Welcome->setParseValue("_USER_NAME", $_USER_NAME);
$_Tpl_Welcome->setParseValue("_STYLE", $_STYLE);
$_Tpl_Welcome->setParseValue("_LANG_IMG", $_LANG_IMG);
$_Tpl_Welcome->setParseValue("_LANG_IMG_URL", $_LANG_IMG_URL);
$_Tpl_Welcome->setParseValue("_LANG_CODE", $_LANG_CODE);
$_Tpl_Welcome->setParseValue("_LANG_SUPPORTED", $_LANG_SUPPORTED);
$_Tpl_Welcome->setParseValue("_LANG_SELECTED", $_LANG_SELECTED);

if ($C[0]['check_version']==1) {
	$_Tpl_Welcome->setParseValue("_VERSION_INFO", sprintf(___("Aktuell verfügbare Version: %s"),$t_new_version));
	$_Tpl_Welcome->setParseValue("_T_MESSAGES", $t_messages);
} else {
	$_Tpl_Welcome->setParseValue("_VERSION_INFO","");
	$_Tpl_Welcome->setParseValue("_T_MESSAGES","");
}
//parse
$_MAIN_OUTPUT.=$_Tpl_Welcome->renderTemplate("Welcome.html");
?>
