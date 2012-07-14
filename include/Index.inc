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

$T=new Timer();

$LOGIN=new mnlCFG();
$action=getVar("act");
if ($action=="logout") {
	$LOGIN->Logout();
} else {
	$LOGIN->Login(0,"Tellmatic Login - ".___("Bitte geben Sie Ihren Benutzernamen und Passwort ein").":");
}

if (!isset($action) || empty($action)) {$action="Welcome";}

$LOGIN->getUser($LOGIN->LoggedInUsername);

//Sprache festlegen!
require_once ($mnl_includepath."/Lang.inc");

require_once ($mnl_includepath."/Header.inc");

//new Template
$_Tpl=new mTemplate();
//echo $TplDir_;
$_Tpl->setTemplatePath($mnl_tplpath);
 
$mSTDURL=new mURL();
$mSTDURL->addParam("act",$action);

$trans = get_html_translation_table(HTML_ENTITIES); 

include_once ($mnl_includepath."/Head.inc");
include_once ($mnl_includepath."/Menu.inc");
include_once ($mnl_includepath."/Main.inc");
include_once ($mnl_includepath."/Foot.inc");	

$_Tpl->setParseValue("_HEAD", $_HEAD);
$_Tpl->setParseValue("_MENU", $_MENU);
$_Tpl->setParseValue("_MAIN", $_MAIN);
$_Tpl->setParseValue("_FOOT", $_FOOT);

//RENDER PAGE
$_PAGE=$_Tpl->renderTemplate("Index.html");
echo $_PAGE;

//
require_once ($mnl_includepath."/Footer.inc");
?>