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

$_SITEID=MNL_SITEID;
$_USER=$LOGIN->USER['name'];

//new Template
$_Tpl_Head=new mTemplate();
$_Tpl_Head->setTemplatePath($mnl_tplpath);
$_Tpl_Head->setParseValue("_SITEID", $_SITEID);
$_Tpl_Head->setParseValue("_USER", $_USER);
$_HEAD=$_Tpl_Head->renderTemplate("Head.html");
?>
