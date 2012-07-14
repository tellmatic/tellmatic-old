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

if (!isset($mnl_config)) {
    $mnl_config=false;
}

if (!$mnl_config) {

	//siteid //achtung, siteid aendern heisst komplett neuer datenstamm... es muessen auch user angelegt werden.... oehm... nicht aendern!!!
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
	
	//pfad
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
	
	$mnl_docpath=$mnl_docroot."/".$mnl_dir."/".$mnl_docdir;
	
	$mnl_URL=$mnl_Domain."/".$mnl_dir;
	$mnl_imgURL=$mnl_URL."/".$mnl_imgdir;
	$mnl_iconURL=$mnl_URL."/".$mnl_icondir;
	
	//includes
	$mnl_path=$mnl_docroot."/".$mnl_dir;
	$mnl_includepath=$mnl_path."/".$mnl_includedir;
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
	
	//funktionen
	require_once ($mnl_includepath."/Functions.inc");
	

	// define constants for phpgettext
	define("PROJECT_DIR", $mnl_path);
	define("LOCALE_DIR", PROJECT_DIR .'/locale');
	define("DEFAULT_LOCALE", 'unknown');//de
	//phpgettext	
	require_once ($mnl_includepath."/gettext/gettext.inc");
	require_once($mnl_includepath."/gettext/streams.php");
	require_once($mnl_includepath."/gettext/gettext.php");

	//gettext!
	$LANGUAGES=Array(	'lang' => Array('de','en','es','fr','it',),
										'text' => Array('Deutsch','English','Espanol (not translated yet)','France (not translated yet)','Italiano (not translated yet)',),
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


	//STATUSCODES
	//statuscodes der adressen und bilder dazu
	//$STATUS['adr']['status'][0]="--";
	 
	//achtung!!! wenn neuer status dann auch beim versenden beachten......... und evtll. anfuegen an if abfrage, send.inc
	$STATUS['adr']['status'][1]=___("Neu");
	$STATUS['adr']['status'][2]=___("OK");
	$STATUS['adr']['status'][3]=___("Bestaetigt");
	$STATUS['adr']['status'][4]=___("Angezeigt");
	$STATUS['adr']['status'][5]=___("Warten");
	$STATUS['adr']['status'][6]="6";
	$STATUS['adr']['status'][7]="7";
	$STATUS['adr']['status'][8]=___("Fehler C");
	$STATUS['adr']['status'][9]=___("Fehler A");
	$STATUS['adr']['status'][10]=___("Fehler S");
	$STATUS['adr']['status'][11]=___("Abgemeldet");
	$STATUS['adr']['status'][12]=___("Touch");
	
	
	$STATUS['adr']['descr'][1]=___("Neuanmeldung");
	$STATUS['adr']['descr'][2]=___("manuell Eingetragen, Syntax Gepr&uuml;ft, Senden OK");
	$STATUS['adr']['descr'][3]=___("Best&auml;tigt, Double-Opt-In");
	$STATUS['adr']['descr'][4]=___("Rechecked, NL/Blindimage angezeigt");
	$STATUS['adr']['descr'][5]=___("Warten auf Best&auml;tigung (Double-Opt-IN)");
	$STATUS['adr']['descr'][6]=___("undefiniert");
	$STATUS['adr']['descr'][7]=___("undefiniert");
	$STATUS['adr']['descr'][8]=___("Fehler beim versenden, Status/Aktiv wurde ge&auml;ndert vor dem versenden!");
	$STATUS['adr']['descr'][9]=___("Fehlerhafte Adresse o. Rueckl&auml;ufer");
	$STATUS['adr']['descr'][10]=___("Fehler beim versenden, neuer Versuch");
	$STATUS['adr']['descr'][11]=___("Abgemeldet");
	$STATUS['adr']['descr'][12]=___("1st-Touch-Opt-In");
	 
	$STATUS['adr']['statimg'][0]="bullet_black.png";
	$STATUS['adr']['statimg'][1]="new.png";
	$STATUS['adr']['statimg'][2]="bullet_green.png";
	$STATUS['adr']['statimg'][3]="bullet_feed.png";
	$STATUS['adr']['statimg'][4]="bullet_purple.png";
	$STATUS['adr']['statimg'][5]="bullet_yellow.png";
	$STATUS['adr']['statimg'][6]="bullet_black.png";
	$STATUS['adr']['statimg'][7]="bullet_black.png";
	$STATUS['adr']['statimg'][8]="page_error.png";
	$STATUS['adr']['statimg'][9]="bullet_error.png";
	$STATUS['adr']['statimg'][10]="transmit_error.png";
	$STATUS['adr']['statimg'][11]="user_red.png";//bullet_delete
	$STATUS['adr']['statimg'][12]="user_add.png";//bullet_delete
	
	 //statuscodes der newsletter und bilder dazu
	$STATUS['nl']['status'][1]=___("Neu");
	$STATUS['nl']['status'][2]=___("Queued");
	$STATUS['nl']['status'][3]=___("Versand");
	$STATUS['nl']['status'][4]=___("Gesendet");
	$STATUS['nl']['status'][5]=___("Archiv");
	$STATUS['nl']['status'][6]=___("Warten");
	
	$STATUS['nl']['descr'][1]=___("Keine Versandauftr&auml;ge oder Historie f. dieses Newsletter");
	$STATUS['nl']['descr'][2]=___("In der Warteschlange");
	$STATUS['nl']['descr'][3]=___("Versand gestartet");
	$STATUS['nl']['descr'][4]=___("Versendet");
	$STATUS['nl']['descr'][5]=___("Archiviert - Qs wurden gel&ouml;scht");
	$STATUS['nl']['descr'][6]=___("Versand vorbereitet, Warten auf Versand (terminiert)");
	
	$STATUS['nl']['statimg'][1]="new.png";
	$STATUS['nl']['statimg'][2]="clock_orange.png";
	$STATUS['nl']['statimg'][3]="clock_play.png";
	$STATUS['nl']['statimg'][4]="feed_green.png";
	$STATUS['nl']['statimg'][5]="feed_disk_blue.png";
	$STATUS['nl']['statimg'][6]="clock.png";
	
	//statuscodes der Q und bilder dazu
	$STATUS['q']['status'][1]=___("Neu");
	$STATUS['q']['status'][2]=___("Gestartet");
	$STATUS['q']['status'][3]=___("Running");
	$STATUS['q']['status'][4]=___("Fertig");
	$STATUS['q']['status'][5]=___("Angehalten");
	 
	$STATUS['q']['descr'][1]="";
	$STATUS['q']['descr'][2]=___("Wird versendet");
	$STATUS['q']['descr'][3]=___("In Arbeit");
	$STATUS['q']['descr'][4]=___("Versendet");
	$STATUS['q']['descr'][5]=___("Angehalten");
	
	$STATUS['q']['statimg'][1]="new.png";
	$STATUS['q']['statimg'][2]="clock_orange.png";
	$STATUS['q']['statimg'][3]="clock_play.png";
	$STATUS['q']['statimg'][4]="feed_green.png";//bullet_feed
	$STATUS['q']['statimg'][5]="stop.png";
	
	//statuscodes der History und bilder dazu
	$STATUS['h']['status'][1]=___("Neu");
	$STATUS['h']['status'][2]=___("Fertig");
	$STATUS['h']['status'][3]=___("View");
	$STATUS['h']['status'][4]=___("Fehler");//
	$STATUS['h']['status'][5]=___("Versand");//wird in diesem moment versendet!!!
	$STATUS['h']['status'][6]=___("Abbruch");//
	 
	$STATUS['h']['descr'][1]=___("Warten auf Versand");
	$STATUS['h']['descr'][2]=___("Versendet, OK");
	$STATUS['h']['descr'][3]=___("Versendet, angezeigt");
	$STATUS['h']['descr'][4]=___("Versendet, Fehler");
	$STATUS['h']['descr'][5]=___("Wird in diesem Moment versendet!!!");
	$STATUS['h']['descr'][6]=___("Abgebrochen, Q gel&ouml;scht");

	$STATUS['h']['statimg'][1]="new.png";
	$STATUS['h']['statimg'][2]="bullet_green.png";
	$STATUS['h']['statimg'][3]="bullet_feed.png";
	$STATUS['h']['statimg'][4]="bullet_error.png";
	$STATUS['h']['statimg'][5]="bullet_feed.png";
	$STATUS['h']['statimg'][6]="bullet_red.png";

//////////////////////////////////	

	$ApplicationName="tellmatic";
	$ApplicationVersion="1.0.3 mNL";
	$ApplicationDescr=___("the newsletter machine");
	$ApplicationUrl="www.tellmatic.de";
	$ApplicationText=$ApplicationName." v".$ApplicationVersion." - ".$ApplicationDescr." (".$ApplicationUrl.")";
	
	//compress output
	m_obstart();

	$mnl_config=true;
	
}
?>