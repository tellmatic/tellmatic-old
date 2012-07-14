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

$helpfilename="".$action.".html";
$helpfile=$mnl_docpath."/".$helpfilename;

if (file_exists($helpfile)) {
	//new Template
	$_Tpl_HelpS=new mTemplate();
	$_Tpl_HelpS->setTemplatePath($mnl_docpath);
	$H_TEXT=$_Tpl_HelpS->renderTemplate($helpfilename);

	$_Tpl_HelpS->setParseValue("H_TEXT", $H_TEXT);
	$_MAIN_HELP=$_Tpl_HelpS->renderTemplate("help.html");
}
?>