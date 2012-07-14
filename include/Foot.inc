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

//DEBUG DATA!!!
$_FOOT="";
//$_FOOT.="<a href=\"javascript:switchSection('div_debug');\">&nbsp;i&nbsp;</a>";

$_FOOT.= "<div id=\"div_debug\" class=\"debug\">";
$_FOOT.= "<a href=\"javascript:switchSection('div_debug');\"><img src=\"".$mnl_iconURL."/information.png\" border=\"0\"></a>";
$_FOOT.= "<br>";
$_FOOT.= "<br>MEM used: ".memory_get_usage()." Byte";
$_FOOT.= "<br>Time to Process: ".$T->Result()." Sek";
$_FOOT.= "<br>Max. Upload: ".get_cfg_var("upload_max_filesize");
$_FOOT.= "<br>Max. Memory: ".get_cfg_var("memory_limit");
$_FOOT.= "<br>Max. POST Data: ".get_cfg_var("post_max_size");
$_FOOT.= "<br>Max. Time: ".get_cfg_var("max_execution_time")." Sek";
$_FOOT.= "<br>".$max_mails_atonce." Mails pro Durchlauf";
$real_path=realpath("./index.php");
$path_info=pathinfo($real_path);
$doc_root=$_SERVER["DOCUMENT_ROOT"];
$host=$_SERVER["HTTP_HOST"];
$self=$_SERVER["PHP_SELF"];
$pathinfo=pathinfo($self);
$_FOOT.= "<br>mnl_Domain=: ".$host;
$_FOOT.= "<br>mnl_docroot=: ".$doc_root;
$_FOOT.= "<br>mnl_dir=: ".$pathinfo['dirname'];
$_FOOT.= "<br><br><a href=\"javascript:switchSection('div_debug');\">(X) Fenster schliessen</a>";
$_FOOT.= "<br><font size=-3 color=\"#eeeeee\">&copy; volker augustin 2006/7</font>";
$_FOOT.= "</div>"; 
$_FOOT.= "<div>".$ApplicationText."&nbsp;<br>&copy;&nbsp;2007&nbsp;-&nbsp;Volker Augustin&nbsp;</div>"; 
echo "<div>".$ApplicationText."&nbsp;<br>&copy;&nbsp;2007&nbsp;-&nbsp;Volker Augustin&nbsp;</div>";

//new Template
$_Tpl_Foot=new mTemplate();
$_Tpl_Foot->setTemplatePath($mnl_tplpath);
$_Tpl_Foot->setParseValue("_FOOT", $_FOOT);
$_FOOT=$_Tpl_Foot->renderTemplate("Foot.html");
?>