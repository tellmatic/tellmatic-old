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

if (!isset($mnl_config)) {
    $mnl_config=false;
}

if (!$mnl_config) {

	//uncomment the next line if your php is running as cgi and http authentication does not work:
	//list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) = explode(':' , base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
	/*
	and  create a textfile named '.htaccess' in your tellmatic install-directory:
	<IfModule mod_rewrite.c>
	RewriteEngine on
	RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization},L]
	</IfModule>
	*/
	// !! mod_rewrite must be enabled !!
	//not tested! source/from: http://www.besthostratings.com/articles/http-auth-php-cgi.html
	
		
	//siteid //achtung, siteid aendern heisst komplett neuer datenstamm... es muessen auch user angelegt werden.... oehm... nicht aendern!!!
	//$mnl_siteid="mnl";
	define("MNL_SITEID","mnl");

	///////////////////////////////
	//////////////STOP/////////////
	///////////////////////////////
	///////////////////////////////
	// ab hier nichts aendern!!! // DO NOT CHANGE
	///////////////////////////////
	///////////////////////////////
	//////////////STOP/////////////
	///////////////////////////////
	

	//hacks for php5
	if (version_compare(phpversion(), "5.0", ">=")) {   $usePhp5=true; } else {  $usePhp5=false; }
	define("PHP5",$usePhp5);
	if (PHP5) ini_set('zend.ze1_compatibility_mode', '1');


	if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {  $php_windows=true; } else {  $php_windows=false; }
	define("PHPWIN",$php_windows);
	@ini_set("max_execution_time","300");
	@ini_set("ignore_user_abort","1");

	//cache off
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Datum in der Vergangenheit
	
	//pfade
	// und weitere verzeichnisse unterhalb $mnl_dir
	//verzeichnis includefiles
	$mnl_includedir="include";
	//verzeichnis templates
	$mnl_tpldir="tpl";
	//verzeichnis fuer bilder:
	$mnl_imgdir="img";
	//verzeichnis fuer icons
	$mnl_icondir="img/icons";
	//verzeichnis fuer gespeicherte newsletter:
	$mnl_nldir="files/newsletter";
	//verzeichnis fuer gespeicherte newsletter-bilder unterhalb von $mnl_nldir:
	$mnl_nlimgdir="files/newsletter/images";
	//verzeichnis fuer attachements
	$mnl_nlattachdir="files/attachements";
	//verzeichnis fuer formular-templates
	$mnl_formdir="files/forms";
	//verzeichnis fuer import/export dateien
	$mnl_datadir="files/import_export";
	//verzeichnis fuer send logs
	$mnl_logdir="files/log";
	//verzeichnis fuer docs
	$mnl_docdir="doc";

	//filedir, filepath!
	
	//pfade
	$mnl_nlpath=$mnl_docroot."/".$mnl_dir."/".$mnl_nldir;
	//pfad verzeichnis fuer gespeicherte newsletter-bilder unterhalb von $mnl_nldir:
	$mnl_nlimgpath=$mnl_docroot."/".$mnl_dir."/".$mnl_nlimgdir;
	$mnl_nlattachpath=$mnl_docroot."/".$mnl_dir."/".$mnl_nlattachdir;
	//pfad verzeichnis fuer formular-templates
	$mnl_formpath=$mnl_docroot."/".$mnl_dir."/".$mnl_formdir;
	//pfad verzeichnis fuer import/export dateien
	$mnl_datapath=$mnl_docroot."/".$mnl_dir."/".$mnl_datadir;
	//pfad f. logfiles
	$mnl_logpath=$mnl_docroot."/".$mnl_dir."/".$mnl_logdir;
	//pfad zur docu
	$mnl_docpath=$mnl_docroot."/".$mnl_dir."/".$mnl_docdir;
	//pfad zu bildern, interne
	$mnl_imgpath=$mnl_docroot."/".$mnl_dir."/".$mnl_imgdir;
	//URLs
	$mnl_URL=$mnl_Domain."/".$mnl_dir;
	$mnl_imgURL=$mnl_URL."/".$mnl_imgdir;
	$mnl_iconURL=$mnl_URL."/".$mnl_icondir;
	
	//includes
	$mnl_path=$mnl_docroot."/".$mnl_dir;
	$mnl_includepath=$mnl_path."/".$mnl_includedir;

	//templates
	$mnl_tplpath=$mnl_path."/".$mnl_tpldir;
	 
	$row_bgcolor="#ffffff";
	$row_bgcolor2="#eeefee";
	$row_bgcolor_inactive="#ff9999";
	$row_bgcolor_hilite="#bbd6ff";
	 
	//
	$img_arrowup="<img src=\"".$mnl_iconURL."/bullet_arrow_up.png\" border=\"0\">";
	$img_arrowdown="<img src=\"".$mnl_iconURL."/bullet_arrow_down.png\" border=\"0\">";
	//
	$allowed_html_filetypes = "(htm|html|txt)";
	$allowed_image_filetypes = "(jpg|jpeg)";
	$allowed_csv_filetypes = "(csv|txt)";
	$max_upload_size=2048000;//2M
	//

	//DBS Tabellen, Namen und Prefix!
	if (!empty($mnl_tablePrefix)) {
		$mnl_tablePrefix.="_";
	}
	define ("mnlTABLE_CONFIG", $mnl_tablePrefix."config");
	define ("mnlTABLE_USER", $mnl_tablePrefix."user");
	define ("mnlTABLE_LOG", $mnl_tablePrefix."log");
	define ("mnlTABLE_NL", $mnl_tablePrefix."nl");
	define ("mnlTABLE_NL_GRP", $mnl_tablePrefix."nl_grp");
	define ("mnlTABLE_ADR", $mnl_tablePrefix."adr");
	define ("mnlTABLE_ADR_DETAILS", $mnl_tablePrefix."adr_details");
	define ("mnlTABLE_ADR_GRP", $mnl_tablePrefix."adr_grp");
	define ("mnlTABLE_ADR_GRP_REF", $mnl_tablePrefix."adr_grp_ref");
	define ("mnlTABLE_NL_Q", $mnl_tablePrefix."nl_q");
	define ("mnlTABLE_NL_H", $mnl_tablePrefix."nl_h");
	define ("mnlTABLE_FRM", $mnl_tablePrefix."frm");
	define ("mnlTABLE_FRM_GRP_REF", $mnl_tablePrefix."frm_grp_ref");
	define ("mnlTABLE_FRM_S", $mnl_tablePrefix."frm_s");

	//includes: funktionen, klassen
	//Errorhandler:
	require_once ($mnl_includepath."/Errorhandling.inc");
	//eigene errorhandler funktion
	set_error_handler("userErrorHandler");
	
	//eigene gettext emulation:
	define("DEFAULT_LOCALE", 'de');
	require_once($mnl_includepath."/GetText.inc");
	
	
	//funktionen
	require_once ($mnl_includepath."/Functions.inc");
	

	$LANGUAGES=Array(	'lang' => Array('de','en','it',),
										'text' => Array('Deutsch','English','Italiano',),
									);
	$supported_locales = $LANGUAGES['lang'];//array('en', 'de');

	//klassen
	require_once ($mnl_includepath."/Classes.inc");

	$encoding = 'UTF-8';
	header("Content-type: text/html; charset=$encoding");

	//config aus db holen
	$CONFIG=new mnlCFG();
	$C=$CONFIG->getCFG(MNL_SITEID);

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
		
	//eMail prueflevel!
	$EMAILCHECK['intern'][1]="Syntax";
	$EMAILCHECK['intern'][2]="Syntax + MX/DNS";
	$EMAILCHECK['intern'][3]="Syntax, MX/DNS + Validate";

	$EMAILCHECK['subscribe'][1]="Syntax";
	$EMAILCHECK['subscribe'][2]="Syntax + MX/DNS";
	$EMAILCHECK['subscribe'][3]="Syntax, MX/DNS + Validate";

	$ApplicationName="tellmatic";
	$ApplicationVersion="1.0.5 Tellmatic";
	$ApplicationDescr=___("Die Newsletter Maschine");
	$ApplicationUrl="www.tellmatic.org";
	$ApplicationText=$ApplicationName." v".$ApplicationVersion." - ".$ApplicationDescr." (".$ApplicationUrl.")";
	
	//compress output
	m_obstart();

	
	$mnl_config=true;
	
	
	
}
?>