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
if (function_exists('memory_get_usage')) {
	$_FOOT.= "<br>".sprintf(___("Benutzer Speicher: %s Byte"),memory_get_usage());
}
$_FOOT.= "<br>".sprintf(___("Bearbeitungszeit: %s Sekunden"),$T->Result());
$_FOOT.= "<br>".sprintf(___("Max. Upload: %s Byte"),get_cfg_var("upload_max_filesize"));
$_FOOT.= "<br>".sprintf(___("Speicherlimit: %s"),get_cfg_var("memory_limit"));
$_FOOT.= "<br>".sprintf(___("Max. POST Data: %s"),get_cfg_var("post_max_size"));
$_FOOT.= "<br>".sprintf(___("Max. Ausf&uuml;hrungszeit: %s Sekunden"),get_cfg_var("max_execution_time"));
$_FOOT.= "<br>".sprintf(___("%s Mails pro Durchlauf"),$max_mails_atonce);
$real_path=realpath("./index.php");
$path_info=pathinfo($real_path);
$doc_root=$_SERVER["DOCUMENT_ROOT"];
$host=$_SERVER["HTTP_HOST"];
$self=$_SERVER["PHP_SELF"];
$pathinfo=pathinfo($self);
$_FOOT.= "<br>mnl_Domain=: ".$host;
$_FOOT.= "<br>mnl_docroot=: ".$doc_root;
$_FOOT.= "<br>mnl_dir=: ".$pathinfo['dirname'];
$_FOOT.= "<br><br><a href=\"javascript:switchSection('div_debug');\">(X) ".___("Fenster schliessen")."</a>";
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