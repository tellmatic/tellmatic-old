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
/**/
/**/
/**/
/**/
/**/
/**/
/**/
/**/
/******************************DO NOT CHANGE:**********************************/
/**/
/**/
/**/
/**/
/**/
/**/
/**/
/**/
if (!isset($tm_config)) {
    $tm_config=false;
}

if (!$tm_config) {


	/***********************************************************/
	//
	//Dateformat for Newsletters to parse {DATE}
	/***********************************************************/
	define ("TM_NL_DATEFORMAT","d.m.Y");
	//en: Y-m-d
	//de: d.m.Y
	//see: www.php.net/date

	/***********************************************************/
	//siteid
	//siteid wird aber zukuenftig variabel sein, bzw default-siteid vergeben werden.
	/***********************************************************/
	//siteid //achtung, siteid aendern heisst komplett neuer datenstamm... es muessen auch user angelegt werden.... oehm... nicht aendern!!!
	define ("TM_SITEID","tellmatic");

	/***********************************************************/
	//demomode und debugmode
	/***********************************************************/
	define ("DEMO", FALSE);//use demo mode
	define ("DEBUG", FALSE);//printout useful infos
	define ("DEBUG_SQL", FALSE);//Warning! this will print out all sql queries!!!
	define ("DEBUG_SMTP", FALSE);//Warning! this will print out all smtp messages and communication with server

	/***********************************************************/
	//old httpd auth login +php-cgi
	/***********************************************************/
	//old login via http-auth via php had problems on misconfigured php-cgi installations
	//uncomment the next line if your php is running as cgi and http authentication does not work:


	#list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) = explode(':' , base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
	/*
	and  create a textfile named '.htaccess' in your tellmatic install-directory:
	<IfModule mod_rewrite.c>
	RewriteEngine on
	RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization},L]
	</IfModule>
	*/
	// !! mod_rewrite must be enabled !!
	//not tested! source/from: http://www.besthostratings.com/articles/http-auth-php-cgi.html

/***********************************************************/
//STOP
// ab hier nichts aendern!!! // DO NOT CHANGE
/***********************************************************/

/***********************************************************/
//hacks for php5
/***********************************************************/
	if (version_compare(phpversion(), "5.0", ">=")) {   $usePhp5=true; } else {  $usePhp5=false; }
	define("PHP5",$usePhp5);
	if (PHP5) ini_set('zend.ze1_compatibility_mode', '1');

	function getObjInstance($O) {
		if (PHP5) {
			include (TM_INCLUDEPATH."/PHP5_clone.inc.php");//$obj=clone $O;
			return $obj;
		} else {
			return $O;
		}
	}

/***********************************************************/
//check if php runs on windows!
/***********************************************************/
	if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {  $php_windows=true; } else {  $php_windows=false; }
	define("PHPWIN",$php_windows);

/***********************************************************/
//
/***********************************************************/
	$trans = get_html_translation_table(HTML_ENTITIES);


/***********************************************************/
//verzeichnisse
/***********************************************************/
	//includefiles
	define("TM_INCLUDEDIR","include");
	//verzeichnis templates
	define("TM_TPLDIR","tpl");
	//verzeichnis fuer bilder:
	define("TM_IMGDIR","img");
	//verzeichnis fuer icons
	define("TM_ICONDIR","img/icons");
	//verzeichnis fuer docs
	define("TM_DOCDIR","doc");
	//verzeichnis fuer files
	define("TM_FILEDIR","files");
/***********************************************************/
//pfade
/***********************************************************/
	//tmpath
	define("TM_PATH",TM_DOCROOT."/".TM_DIR);
	//includes
	define("TM_INCLUDEPATH",TM_PATH."/".TM_INCLUDEDIR);
	//pfad zur docu
	define("TM_DOCPATH",TM_PATH."/".TM_DOCDIR);
	//pfad zu bildern, interne
	define("TM_IMGPATH",TM_PATH."/".TM_IMGDIR);
	//icons intern
	define("TM_ICONPATH",TM_PATH."/".TM_ICONDIR);
	//templates intern
	define("TM_TPLPATH",TM_PATH."/".TM_TPLDIR);
	//files
	define("TM_FILEPATH",TM_PATH."/".TM_FILEDIR);

/***********************************************************/
//sitespezifische dirs....! fuer multicustomer
/***********************************************************/
	//verzeichnis fuer gespeicherte newsletter:
	$tm_nldir=TM_FILEDIR."/newsletter";
	//verzeichnis fuer gespeicherte newsletter-bilder unterhalb von $tm_nldir:
	$tm_nlimgdir=TM_FILEDIR."/newsletter/images";
	//verzeichnis fuer attachements
	$tm_nlattachdir=TM_FILEDIR."/attachements";
	//verzeichnis fuer formular-templates
	$tm_formdir=TM_FILEDIR."/forms";
	//verzeichnis fuer import/export dateien
	$tm_datadir=TM_FILEDIR."/import_export";
	//verzeichnis fuer send logs
	$tm_logdir=TM_FILEDIR."/log";
	//sessions, tmp
	$tm_tmpdir=TM_FILEDIR."/tmp";
	//reports, statistic images
	$tm_reportdir=TM_FILEDIR."/reports";

/***********************************************************/
//pfade
/***********************************************************/
	//newsletter html files
	$tm_nlpath=TM_PATH."/".$tm_nldir;
	//pfad verzeichnis fuer gespeicherte newsletter-bilder unterhalb von $tm_nldir:
	$tm_nlimgpath=TM_PATH."/".$tm_nlimgdir;
	//attachements
	$tm_nlattachpath=TM_PATH."/".$tm_nlattachdir;
	//pfad verzeichnis fuer formular-templates
	$tm_formpath=TM_PATH."/".$tm_formdir;
	//pfad verzeichnis fuer import/export dateien
	$tm_datapath=TM_PATH."/".$tm_datadir;
	//pfad f. logfiles
	$tm_logpath=TM_PATH."/".$tm_logdir;
	//pfad zu reports
	$tm_reportpath=TM_PATH."/".$tm_reportdir;
	//temp, sessions etc
	$tm_tmppath=TM_PATH."/".$tm_tmpdir;

/***********************************************************/
//URLs
/***********************************************************/
	$tm_URL=TM_DOMAIN."/".TM_DIR."/admin";//backend, admin
	$tm_URL_FE=TM_DOMAIN."/".TM_DIR;//frontend!
	$tm_imgURL=$tm_URL_FE."/".TM_IMGDIR;
	$tm_iconURL=$tm_URL_FE."/".TM_ICONDIR;
	/***********************************************************/
	//check if we should use 256 colors png icons instead, for internet exploder.....
	/***********************************************************/
	if (file_exists(TM_INCLUDEPATH."/256")) {
		define ("USE_256COL_ICONS",TRUE);
		$tm_iconURL.="/256";
	}else {
		define ("USE_256COL_ICONS",FALSE);
	}
/***********************************************************/
//Today
//todays date//used e.g. for saving status and statistic images and reports etc
/***********************************************************/
	define ("TM_TODAY",date("Y-m-d"));//todays date//used e.g. for saving status and statistic images and reports etc

/***********************************************************/
//tabellen
/***********************************************************/
	//DBS Tabellen, Namen und Prefix!
	if (!empty($tm_tablePrefix)) {
		$tm_tablePrefix.="_";
	}
	define ("TM_TABLE_CONFIG", $tm_tablePrefix."config");
	define ("TM_TABLE_USER", $tm_tablePrefix."user");
	define ("TM_TABLE_LOG", $tm_tablePrefix."log");
	define ("TM_TABLE_NL", $tm_tablePrefix."nl");
	define ("TM_TABLE_NL_GRP", $tm_tablePrefix."nl_grp");
	define ("TM_TABLE_ADR", $tm_tablePrefix."adr");
	define ("TM_TABLE_ADR_DETAILS", $tm_tablePrefix."adr_details");
	define ("TM_TABLE_ADR_GRP", $tm_tablePrefix."adr_grp");
	define ("TM_TABLE_ADR_GRP_REF", $tm_tablePrefix."adr_grp_ref");
	define ("TM_TABLE_NL_Q", $tm_tablePrefix."nl_q");
	define ("TM_TABLE_NL_H", $tm_tablePrefix."nl_h");
	define ("TM_TABLE_NL_ATTM", $tm_tablePrefix."nl_attm");
	define ("TM_TABLE_FRM", $tm_tablePrefix."frm");
	define ("TM_TABLE_FRM_GRP_REF", $tm_tablePrefix."frm_grp_ref");
	define ("TM_TABLE_FRM_S", $tm_tablePrefix."frm_s");
	define ("TM_TABLE_HOST", $tm_tablePrefix."hosts");
	define ("TM_TABLE_BLACKLIST", $tm_tablePrefix."blacklist");

/***********************************************************/
//includes: funktionen, klassen
/***********************************************************/
/***********************************************************/
//funktionen
/***********************************************************/
	require_once (TM_INCLUDEPATH."/Functions.inc.php");
	
/***********************************************************/
//handle magic quotes
/***********************************************************/
	//http://talks.php.net/show/php-best-practices/26
	if (get_magic_quotes_gpc()) {
		//http://www.php.net/manual/en/security.magicquotes.disabling.php#id2553906
	    $_GET = undoMagicQuotes($_GET);
	    $_POST = undoMagicQuotes($_POST);
	    $_COOKIE = undoMagicQuotes($_COOKIE);
	    $_REQUEST = undoMagicQuotes($_REQUEST);
	}

	//http://www.php.net/manual/en/function.htmlentities.php#77556
	foreach($_POST as $key => $val) {
	  // scrubbing the field NAME...
	  if(preg_match('/%/', urlencode($key))) die('XSS');//'FATAL::XSS hack attempt detected. Your IP has been logged.'
	}

/***********************************************************/
//Errorhandler:
/***********************************************************/
	require_once (TM_INCLUDEPATH."/Errorhandling.inc.php");
	//eigene errorhandler funktion
	set_error_handler("userErrorHandler");

/***********************************************************/
//eigene gettext emulation:
/***********************************************************/
	define("DEFAULT_LOCALE", 'de');
	require_once(TM_INCLUDEPATH."/GetText.inc.php");

/***********************************************************/
//htmlparser, convert html to text
/***********************************************************/
	require_once (TM_INCLUDEPATH."/phphtmlparser/html2text.inc");

/***********************************************************/
//array mit verfuegbaren sprachen
/***********************************************************/

	$LANGUAGES=Array(	'lang' => Array('de','en','es','it','nl','pt'),
										'text' => Array('Deutsch','English','Espana','Italiano','Dutch','Poruguese (BR)'),
									);
	$supported_locales = $LANGUAGES['lang'];//array('en', 'de');

/***********************************************************/
//klassen
/***********************************************************/

	require_once (TM_INCLUDEPATH."/Classes.inc.php");
	#require_once (TM_INCLUDEPATH."/phphtmlparser/html2text.inc");
	//wird bisher nur beim versenden in send_it.php benoetigt, und deshalb auch nur dort eingebunden!

/***********************************************************/
//config aus db holen
/***********************************************************/
	$CONFIG=new tm_CFG();
	$C=$CONFIG->getCFG(TM_SITEID);

	//eMail prueflevel!
	$EMailcheck_Intern=$C[0]['emailcheck_intern'];
	$EMailcheck_Subscribe=$C[0]['emailcheck_subscribe'];

/***********************************************************/
//SMTP/POP3 Config
//default, f. interne mails
/***********************************************************/
	$use_SMTPmail=true;//fuer interne smtp mail function! sendMail()
	//Benutze POP before SMTP zur Authentifizierung? NEIN!
	$SMTPPopB4SMTP=false;

/***********************************************************/
//mindestlänge für passwoerter
/***********************************************************/
	$minlength_pw=6;

/***********************************************************/
//eMail prueflevel!
/***********************************************************/
	$EMAILCHECK['intern'][0]="keine Prüfung";
	$EMAILCHECK['intern'][1]="Syntax";
	$EMAILCHECK['intern'][2]="Syntax + MX/DNS";
	$EMAILCHECK['intern'][3]="Syntax, MX/DNS + Validate";

	$EMAILCHECK['subscribe'][1]="Syntax";
	$EMAILCHECK['subscribe'][2]="Syntax + MX/DNS";
	$EMAILCHECK['subscribe'][3]="Syntax, MX/DNS + Validate";

/***********************************************************/
//Tellmatic Name/Version
/***********************************************************/
	require_once (TM_INCLUDEPATH."/tm_version.inc.php");

/***********************************************************/
/***********************************************************/
//Messages, f. subscribe/unsubscribe
/***********************************************************/

	require_once(TM_INCLUDEPATH."/Messages.inc.php");

/***********************************************************/
	if (DEBUG) $debug_translated=Array();
	if (DEBUG) $debug_not_translated=Array();
	if (DEBUG) $debug_same_translated=Array();

/***********************************************************/
//encoding
/***********************************************************/
	$encoding = "UTF-8";

/***********************************************************/
//configured
/***********************************************************/
	$tm_config=true;
}
?>