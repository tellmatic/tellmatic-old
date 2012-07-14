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

$helpfilename="".$action.".html";
$helpfile=TM_DOCPATH."/".$LOGIN->USER['lang']."/".$helpfilename;

if (file_exists($helpfile)) {
	//new Template
	$_Tpl_HelpS=new tm_Template();
	$_Tpl_HelpS->setTemplatePath(TM_DOCPATH."/".$LOGIN->USER['lang']);
	$H_TEXT=$_Tpl_HelpS->renderTemplate($helpfilename);
	$_Tpl_HelpS->setParseValue("H_TEXT", $H_TEXT);
	$_MAIN_HELP=$_Tpl_HelpS->renderTemplate("help.html");
}


?>