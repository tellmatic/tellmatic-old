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

if (!isset($tm_config)) {
    $tm_config=false;
}

if (!$tm_config) {

	/***********************************************************/
	//Messages
	/***********************************************************/

	$MSG['subscribe']['update']='E-Mail-Adresse existiert bereits. Ihre Daten wurden aktualisiert.';
	$MSG['unsubscribe']['unsubscribe']='Sie wurden abgemeldet.';
	$MSG['unsubscribe']['error']='Fehler!';
	$MSG['unsubscribe']['invalid']='Ungültig!';
	$MSG['unsubscribe']['already_unsubscribed']='Sie sind nicht mehr angemeldet.';
	$MSG['unsubscribe']['invalid_email']='Ungültige E-Mail-Adresse';

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

	/***********************************************************/
	//siteid
	//siteid wird aber zukuenftig variabel sein, bzw default-siteid vergeben werden.
	/***********************************************************/
	//siteid //achtung, siteid aendern heisst komplett neuer datenstamm... es muessen auch user angelegt werden.... oehm... nicht aendern!!!
	define ("TM_SITEID","tellmatic");

	/***********************************************************/
	//demomode und debugmode
	/***********************************************************/
	define ("DEMO", FALSE);
	define ("DEBUG", FALSE);

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
			include ($tm_includepath."/PHP5_clone.inc.php");//$obj=clone $O;
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
	$tm_includedir="include";
	//verzeichnis templates
	$tm_tpldir="tpl";
	//verzeichnis fuer bilder:
	$tm_imgdir="img";
	//verzeichnis fuer icons
	$tm_icondir="img/icons";
	//verzeichnis fuer docs
	$tm_docdir="doc";

/***********************************************************/
//sitespezifische dirs....! fuer multicustomer
/***********************************************************/
	//verzeichnis fuer gespeicherte newsletter:
	$tm_nldir="files/newsletter";
	//verzeichnis fuer gespeicherte newsletter-bilder unterhalb von $tm_nldir:
	$tm_nlimgdir="files/newsletter/images";
	//verzeichnis fuer attachements
	$tm_nlattachdir="files/attachements";
	//verzeichnis fuer formular-templates
	$tm_formdir="files/forms";
	//verzeichnis fuer import/export dateien
	$tm_datadir="files/import_export";
	//verzeichnis fuer send logs
	$tm_logdir="files/log";
	//sessions, tmp
	$tm_tmpdir="files/tmp";
	//reports, statistic images
	$tm_reportdir="files/reports";

/***********************************************************/
//pfade
/***********************************************************/
	//filedir, filepath!
	$tm_path=$tm_docroot."/".$tm_dir;
	//includes
	$tm_includepath=$tm_path."/".$tm_includedir;
	//newsletter html files
	$tm_nlpath=$tm_path."/".$tm_nldir;
	//pfad verzeichnis fuer gespeicherte newsletter-bilder unterhalb von $tm_nldir:
	$tm_nlimgpath=$tm_path."/".$tm_nlimgdir;
	//attachements
	$tm_nlattachpath=$tm_path."/".$tm_nlattachdir;
	//pfad verzeichnis fuer formular-templates
	$tm_formpath=$tm_path."/".$tm_formdir;
	//pfad verzeichnis fuer import/export dateien
	$tm_datapath=$tm_path."/".$tm_datadir;
	//pfad f. logfiles
	$tm_logpath=$tm_path."/".$tm_logdir;
	//pfad zur docu
	$tm_docpath=$tm_path."/".$tm_docdir;
	//pfad zu bildern, interne
	$tm_imgpath=$tm_path."/".$tm_imgdir;
	//pfad zu reports
	$tm_reportpath=$tm_path."/".$tm_reportdir;
	//temp, sessions etc
	$tm_tmppath=$tm_path."/".$tm_tmpdir;
	//images
	$tm_imgpath=$tm_path."/".$tm_imgdir;
	//templates
	$tm_tplpath=$tm_path."/".$tm_tpldir;
	$tm_iconpath=$tm_path."/".$tm_icondir;

/***********************************************************/
//URLs
/***********************************************************/
	$tm_URL=$tm_Domain."/".$tm_dir."/admin";//backend, admin
	$tm_URL_FE=$tm_Domain."/".$tm_dir;//frontend!
	$tm_imgURL=$tm_URL_FE."/".$tm_imgdir;
	$tm_iconURL=$tm_URL_FE."/".$tm_icondir;

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
	define ("TM_TABLE_FRM", $tm_tablePrefix."frm");
	define ("TM_TABLE_FRM_GRP_REF", $tm_tablePrefix."frm_grp_ref");
	define ("TM_TABLE_FRM_S", $tm_tablePrefix."frm_s");

/***********************************************************/
//includes: funktionen, klassen
/***********************************************************/
/***********************************************************/
//funktionen
/***********************************************************/
	require_once ($tm_includepath."/Functions.inc.php");
	
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
	require_once ($tm_includepath."/Errorhandling.inc.php");
	//eigene errorhandler funktion
	set_error_handler("userErrorHandler");

/***********************************************************/
//eigene gettext emulation:
/***********************************************************/
	define("DEFAULT_LOCALE", 'de');
	require_once($tm_includepath."/GetText.inc.php");

/***********************************************************/
//htmlparser, convert html to text
/***********************************************************/
	require_once ($tm_includepath."/phphtmlparser/html2text.inc");

/***********************************************************/
//array mit verfuegbaren sprachen
/***********************************************************/

	$LANGUAGES=Array(	'lang' => Array('de','en','es','it'),
										'text' => Array('Deutsch','English','Espana','Italiano'),
									);
	$supported_locales = $LANGUAGES['lang'];//array('en', 'de');

/***********************************************************/
//klassen
/***********************************************************/

	require_once ($tm_includepath."/Classes.inc.php");

/***********************************************************/
//config aus db holen
/***********************************************************/
	$CONFIG=new tm_CFG();
	$C=$CONFIG->getCFG(TM_SITEID);

	$send_notification_subscribe=$C[0]['notify_subscribe'];
	$send_notification_unsubscribe=$C[0]['notify_unsubscribe'];
	$send_notification_email=$C[0]['notify_mail'];
	$From=$C[0]['sender_email'];
	$FromName=$C[0]['sender_name'];
	$ReturnPath=$C[0]['return_mail'];
	$max_mails_atonce=$C[0]['max_mails_atonce'];
	$max_mails_bcc=$C[0]['max_mails_bcc'];
	$max_mails_retry=$C[0]['max_mails_retry'];

	//eMail prueflevel!
	$EMailcheck_Intern=$C[0]['emailcheck_intern'];
	$EMailcheck_Subscribe=$C[0]['emailcheck_subscribe'];

/***********************************************************/
//SMTP/POP3 Config
//solange nur 1 mailserver f. pop3 und smtp
/***********************************************************/
	//MTA Hostname
	$SMTPHost=$C[0]['smtp_host'];
	//SMTP-Username
	$SMTPUser=$C[0]['smtp_user'];
	//SMTP-Passwort
	$SMTPPasswd=$C[0]['smtp_pass'];
	//Benutze POP before SMTP zur Authentifizierung? NEIN!
	$SMTPPopB4SMTP=false;
	//Absenderdomain, HELO
	$SMTPDomain=$C[0]['smtp_domain'];
	//
	$use_SMTPmail=true;//fuer smtp mail function!

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
//Tellmatic Name
/***********************************************************/
	$ApplicationName="tellmatic";
	$ApplicationVersion="1.0.7 Tellmatic";
	$ApplicationDescr=___("Die Newsletter Maschine");
	$ApplicationUrl="www.tellmatic.org";
	$ApplicationText=$ApplicationName." v".$ApplicationVersion." - ".$ApplicationDescr." (".$ApplicationUrl.")";

/***********************************************************/

/***********************************************************/
	if (DEBUG) $debug_translated=Array();
	if (DEBUG) $debug_not_translated=Array();
	if (DEBUG) $debug_same_translated=Array();

/***********************************************************/
//encoding
/***********************************************************/
	$encoding = "utf-8";

/***********************************************************/
//configured
/***********************************************************/
	$tm_config=true;
}
?>