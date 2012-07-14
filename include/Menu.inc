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

$_MENU="";
//new Template
$_Tpl_Menu=new mTemplate();
$_Tpl_Menu->setTemplatePath($mnl_tplpath);
$_Tpl_Menu->setParseValue("_MENU", $_MENU);
$_MENU.="<div id=\"ms0\" class=\"menu_head\">Tellmatic</div>";
$_MENU.="<a class=\"menu_entry\" href=\"javascript:switchSection('main_info')\" title=\"Aktuelle Meldungen ein-/ausblenden\"><img src=\"".$mnl_iconURL."/information.png\" border=\"0\">&nbsp;".date("Y-m-d H:i:s")."</a>";
$_MENU.="<div id=\"mf\" class=\"menu_foot\">&nbsp;</div>";

$_MENU.=$_Tpl_Menu->renderTemplate("Menu.html");
?>