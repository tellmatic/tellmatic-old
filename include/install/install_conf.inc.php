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

define("DEBUG",FALSE);
define("DEBUG_SMTP",FALSE);
define("DEBUG_SQL",FALSE);
define("DEMO",FALSE);
define ("TM_LOG",FALSE);
define ("DEBUG_LANG", FALSE);//printout useful infos
define ("DEBUG_LANG_LEVEL", 2);// 1: mark only words, 2: only list 3: both
/***********************************************************/
//guess path
/***********************************************************/
#so aber gehts auch mit docroot.....
define("TM_DOCROOT",realpath($_SERVER["DOCUMENT_ROOT"]));
$protocol = isset($_SERVER['HTTPS']) ? "https://" : "http://";
define("TM_DOMAIN",$protocol.$_SERVER["HTTP_HOST"]);
define("TM_DOMAINNAME",$_SERVER["HTTP_HOST"]);
$self=$_SERVER["PHP_SELF"];
$pathinfo=pathinfo($self);
$tm_dir_tmp=$pathinfo['dirname'];
//ersten slash killen!!! sonst klappt das nich mit php_self, da doppelslash und das raffen manche browser nich!
if (substr($tm_dir_tmp, 0,1)=="/") {
	$tm_dir_tmp=substr($tm_dir_tmp, 1,strlen($tm_dir_tmp));
}
if (empty($tm_dir_tmp)) {
	$tm_dir_tmp=".";
}
define("TM_DIR",$tm_dir_tmp);

/***********************************************************/
//directories
/***********************************************************/
define("TM_INCLUDEDIR","include");
define("TM_TPLDIR","tpl");
define("TM_IMGDIR","img");
define("TM_ICONDIR",TM_IMGDIR."/icons");
define("TM_DOCDIR","doc");

$tm_tmpdir="files/tmp";
$tm_logdir="files/log";
$tm_nldir="files/newsletter";
$tm_nlimgdir="files/newsletter/images";
$tm_nlattachdir="files/attachements";
$tm_formdir="files/forms";
$tm_datadir="files/import_export";
$tm_logdir="files/log";

$tm_reportdir="files/reports";

/***********************************************************/
//Paths
/***********************************************************/
define("TM_PATH",TM_DOCROOT."/".TM_DIR);
define("TM_INCLUDEPATH",TM_PATH."/".TM_INCLUDEDIR);
define("TM_TPLPATH",TM_PATH."/".TM_TPLDIR);
define("TM_IMGPATH",TM_PATH."/".TM_IMGDIR);
define("TM_ICONPATH",TM_PATH."/".TM_ICONDIR);
define("TM_DOCPATH",TM_PATH."/".TM_DOCDIR);

$tm_tmppath=TM_PATH."/".$tm_tmpdir;
$tm_logpath=TM_PATH."/".$tm_logdir;
$tm_nlpath=TM_PATH."/".$tm_nldir;
$tm_nlimgpath=TM_PATH."/".$tm_nlimgdir;
$tm_nlattachpath=TM_PATH."/".$tm_nlattachdir;
$tm_formpath=TM_PATH."/".$tm_formdir;
$tm_datapath=TM_PATH."/".$tm_datadir;
$tm_reportpath=TM_PATH."/".$tm_reportdir;

/***********************************************************/
//URLs
/***********************************************************/
$tm_URL=TM_DOMAIN."/".TM_DIR;
$tm_imgURL=$tm_URL."/".TM_IMGDIR;
$tm_iconURL=$tm_URL."/".TM_ICONDIR;


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
require_once ("./include/tm_version.inc.php");

/***********************************************************/
//default siteid
/***********************************************************/
define("TM_SITEID","tellmatic");

/***********************************************************/
//array mit verfuegbaren sprachen
/***********************************************************/

	$LANGUAGES=Array(	'lang' => Array('de','en','es','fr','it','nl','pt'),
										'text' => Array('Deutsch','English','Espana','France','Italiano','Dutch','Portuguese (BR)'),
									);
	$supported_locales = $LANGUAGES['lang'];//array('en', 'de');
	//^^^ lang array aus tm_lib kopiert, hardcoded!

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
$InputName_DBSocket="db_socket";
$$InputName_DBSocket=getVar($InputName_DBSocket);

$InputName_DBType="db_type";
$$InputName_DBType=getVar($InputName_DBType);

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

$InputName_SMTPPort="smtp_port";
$$InputName_SMTPPort=getVar($InputName_SMTPPort);
if (empty($$InputName_SMTPPort)) {
	$$InputName_SMTPPort=25;
}

$InputName_SMTPUser="smtp_user";
$$InputName_SMTPUser=getVar($InputName_SMTPUser);

$InputName_SMTPPass="smtp_pass";
$$InputName_SMTPPass=getVar($InputName_SMTPPass);

$InputName_SMTPDomain="smtp_domain";
$$InputName_SMTPDomain=getVar($InputName_SMTPDomain);

$InputName_SMTPAuth="smtp_auth";
$$InputName_SMTPAuth=getVar($InputName_SMTPAuth);

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

	if (DEBUG) $debug_translated=Array();
	if (DEBUG) $debug_not_translated=Array();
	if (DEBUG) $debug_same_translated=Array();

?>