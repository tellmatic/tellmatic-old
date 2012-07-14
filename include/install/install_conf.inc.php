<?php
/********************************************************************************/
/* this file is part of: / diese Datei ist ein Teil von:                        	*/
/* tellmatic, the newslettermachine                                             	*/
/* tellmatic, die Newslettermaschine                                            */
/* 2006/7 by Volker Augustin, multi.art.studio Hanau                            */
/* Contact/Kontakt: info@tellmatic.org                                      */
/* Homepage: www.tellmatic.org                                                   */
/* leave this header in file!                                                   */
/* diesen Header nicht loeschen!                                                */
/* check Homepage for Updates and more Infos                                    */
/* Besuchen Sie die Homepage fuer Updates und weitere Infos                     */
/********************************************************************************/
/***********************************************************/
//guess path
/***********************************************************/
$tm_docroot=realpath(dirname(realpath(__FILE__))."/../../../");
$tm_Domain="http://".$_SERVER["HTTP_HOST"];
$self=$_SERVER["PHP_SELF"];
$pathinfo=pathinfo($self);
$tm_dir=$pathinfo['dirname'];
//ersten slash killen!!! sonst klappt das nich mit php_self, da doppelslash und das raffen manche browser nich!
if (substr($tm_dir, 0,1)=="/") {
	$tm_dir=substr($tm_dir, 1,strlen($tm_dir));
}
if (empty($tm_dir)) {
	$tm_dir=".";
}
/***********************************************************/
//directories
/***********************************************************/
$tm_includedir="include";
$tm_tmpdir="files/tmp";
$tm_logdir="files/log";
$tm_tpldir="tpl";
$tm_imgdir="img";
$tm_icondir="img/icons";
$tm_nldir="files/newsletter";
$tm_nlimgdir="files/newsletter/images";
$tm_nlattachdir="files/attachements";
$tm_formdir="files/forms";
$tm_datadir="files/import_export";
$tm_logdir="files/log";
$tm_docdir="doc";
$tm_reportdir="files/reports";

/***********************************************************/
//Paths
/***********************************************************/
$tm_path=$tm_docroot."/".$tm_dir;
$tm_includepath=$tm_path."/".$tm_includedir;
$tm_tmppath=$tm_path."/".$tm_tmpdir;
$tm_logpath=$tm_path."/".$tm_logdir;
$tm_tplpath=$tm_path."/".$tm_tpldir;
$tm_imgpath=$tm_path."/".$tm_imgdir;
$tm_iconpath=$tm_path."/".$tm_icondir;
$tm_nlpath=$tm_path."/".$tm_nldir;
$tm_nlimgpath=$tm_path."/".$tm_nlimgdir;
$tm_nlattachpath=$tm_path."/".$tm_nlattachdir;
$tm_formpath=$tm_path."/".$tm_formdir;
$tm_datapath=$tm_path."/".$tm_datadir;
$tm_docpath=$tm_path."/".$tm_docdir;
$tm_reportpath=$tm_path."/".$tm_reportdir;

/***********************************************************/
//URLs
/***********************************************************/
$tm_URL=$tm_Domain."/".$tm_dir;
$tm_imgURL=$tm_URL."/".$tm_imgdir;
$tm_iconURL=$tm_URL."/".$tm_icondir;

/***********************************************************/
//check if php runs on windows!
/***********************************************************/
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {  $php_windows=true; } else {  $php_windows=false; }
define("PHPWIN",$php_windows);

/***********************************************************/
//includes
/***********************************************************/
require_once ("./include/Errorhandling.inc.php");
require_once ("./include/Class_mSimpleForm.inc.php");
require_once ("./include/Functions.inc.php");
require_once ("./include/GetText.inc.php");

/***********************************************************/
//default siteid
/***********************************************************/
define("TM_SITEID","tellmatic");

/***********************************************************/

/***********************************************************/
$set=getVar("set");
$check=false;

/***********************************************************/

/***********************************************************/
$tm_tablePrefix="";
$InputName_DBTablePrefix="tablePrefix";
$$InputName_DBTablePrefix=getVar($InputName_DBTablePrefix);
$tm_tablePrefix_cfg=$tablePrefix;
if (!empty($tablePrefix)) {
	$tm_tablePrefix=$tablePrefix."_";
}
/***********************************************************/
//formularfelder:
/***********************************************************/
$InputName_Submit="submit";
$InputName_Reset="reset";

$InputName_Name="name";//name
$$InputName_Name=getVar($InputName_Name);
if (empty($$InputName_Name)) {
	$$InputName_Name="admin";
}

$InputName_Lang="lang";//sprache
$$InputName_Lang=getVar($InputName_Lang);

$InputName_EMail="email";//name
$$InputName_EMail=getVar($InputName_EMail);

$InputName_Pass="pass";//name
$$InputName_Pass=getVar($InputName_Pass);

$InputName_Pass2="pass2";//name
$$InputName_Pass2=getVar($InputName_Pass2);

$InputName_DBHost="db_host";
$$InputName_DBHost=getVar($InputName_DBHost);
if (empty($$InputName_DBHost)) {
	$$InputName_DBHost="127.0.0.1";
}

$InputName_DBPort="db_port";
$$InputName_DBPort=getVar($InputName_DBPort);
if (empty($$InputName_DBPort)) {
	$$InputName_DBPort="3306";
}

$InputName_DBName="db_name";
$$InputName_DBName=getVar($InputName_DBName);

$InputName_DBUser="db_user";
$$InputName_DBUser=getVar($InputName_DBUser);

$InputName_DBPass="db_pass";
$$InputName_DBPass=getVar($InputName_DBPass);

$InputName_SMTPHost="smtp_host";
$$InputName_SMTPHost=getVar($InputName_SMTPHost);
if (empty($$InputName_SMTPHost)) {
	$$InputName_SMTPHost="127.0.0.1";
}

$InputName_SMTPUser="smtp_user";
$$InputName_SMTPUser=getVar($InputName_SMTPUser);

$InputName_SMTPPass="smtp_pass";
$$InputName_SMTPPass=getVar($InputName_SMTPPass);

$InputName_SMTPDomain="smtp_domain";
$$InputName_SMTPDomain=getVar($InputName_SMTPDomain);

$InputName_License="license";

$InputName_Accept="accept";
$$InputName_Accept=getVar($InputName_Accept);

$InputName_Reg="reg";
$$InputName_Reg=getVar($InputName_Reg);
$InputName_RegMsg="regmsg";
$$InputName_RegMsg=getVar($InputName_RegMsg);
/***********************************************************/

/***********************************************************/
$set=getVar("set");
$check=false;

/***********************************************************/
//get infos
/***********************************************************/
$php_sapi=php_sapi_name();
$php_os=php_uname();//PHP_OS

$mem=calc_bytes(ini_get("memory_limit"));
$exec_time=ini_get("max_execution_time");

/***********************************************************/

/***********************************************************/
$created=date("Y-m-d H:i:s");

define("DEBUG",FALSE);
define("DEMO",FALSE);

	if (DEBUG) $debug_translated=Array();
	if (DEBUG) $debug_not_translated=Array();
	if (DEBUG) $debug_same_translated=Array();

?>