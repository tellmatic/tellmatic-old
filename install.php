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


?>
<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF8">
<meta name="author" content="Volker">
<meta name="Publisher" content="multi.art.studio Hanau">
<meta name="Copyright" content="2007">
<meta name="Page-topic" content="Newsletter">
<meta name="Audience" content="all">
<meta name="Content-language" content="DE">
<link rel="shortcut icon" href="img/favicon.ico">
<title>Tellmatic Newsletter - Installation</title>
<!--link rel="stylesheet" type="text/css" media="all" href="css/default/mnl.css" title="mnl" /-->
<style type="text/css">
@import url(css/default/mnl.css);
@import url(css/default/mnl_head.css);
@import url(css/default/mnl_menu.css);
@import url(css/default/mnl_main.css);
@import url(css/default/mnl_form.css);
</style>
<div id="head" class="head">&nbsp;</div>
<div id="logo" class="logo">&nbsp;</div>
<?php

//Daten ermitteln
$MESSAGE="";
$mnl_docroot=$_SERVER["DOCUMENT_ROOT"];
$mnl_Domain="http://".$_SERVER["HTTP_HOST"];
$self=$_SERVER["PHP_SELF"];
$pathinfo=pathinfo($self);
$mnl_dir=$pathinfo['dirname'];

//ersten slash killen!!! sonst klappt das nich mit php_self, da doppelslash und das raffen manche browser nich!
if (substr($mnl_dir, 0,1)=="/") {
	$mnl_dir=substr($mnl_dir, 1,strlen($mnl_dir));
}

$mnl_includedir="include";
$mnl_path=$mnl_docroot."/".$mnl_dir;
$mnl_includepath=$mnl_path."/".$mnl_includedir;
require_once ($mnl_includepath."/Errorhandling.inc");
require_once ($mnl_includepath."/Class_mSimpleForm.inc");
require_once ($mnl_includepath."/Functions.inc");
define("MNL_SITEID","mnl");

$set=getVar("set");
$check=false;

$mnl_tablePrefix="";

//formularfelder:
$InputName_DBTablePrefix="tablePrefix";
$$InputName_DBTablePrefix=getVar($InputName_DBTablePrefix);
$mnl_tablePrefix_cfg=$$InputName_DBTablePrefix;
if (!empty($$InputName_DBTablePrefix)) {
	$mnl_tablePrefix=$$InputName_DBTablePrefix."_";
}



$InputName_Submit="submit";
$InputName_Reset="reset";

$InputName_Name="name";//name
$$InputName_Name=getVar($InputName_Name);
if (empty($$InputName_Name)) {
	$$InputName_Name="admin";
}

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

$check=true;

if (version_compare(phpversion(), "5.0", ">=")) { 
	$MESSAGE.="<br><font size=2 color=red><b>ACHTUNG! Sie benutzen PHP5. Weitere Details finden Sie den den Dateien README und INSTALL.
							<br>You are using PHP5. More Details you can find in the README and INSTALL files.</b></font><br>";
	//no error
}

if (!function_exists('imap_open')) {
	$MESSAGE.="<br><font size=2 color=red><b>ACHTUNG! Die Funktion imap_open() existiert nicht. Weitere Details finden Sie den den Dateien README und INSTALL.
							<br>The imap_open() function does not exist. More Details you can find in the README and INSTALL files.</b></font><br>";
	//no error
}

if (!is_writeable($mnl_path)) {
	$MESSAGE.="<br><font size=2 color=red><b>ACHTUNG! $mnl_path ist Schreibgeschuetzt. Weitere Details finden Sie den den Dateien README und INSTALL 
							<br>$mnl_path ist write protected. More Details you can find in the README and INSTALL files.</b></font><br>";
	$check=false;
}

if (!is_writeable($mnl_includepath)) {
	$MESSAGE.="<br><font size=2 color=red><b>ACHTUNG! $mnl_includepath ist Schreibgeschuetzt. Weitere Details finden Sie den den Dateien README und INSTALL 
							<br>$mnl_includepath ist write protected. More Details you can find in the README and INSTALL files.</b></font><br>";
	$check=false;
}

if ($set=="save" && $check) {
	//$check=true;
	//checkinput
	if (empty($name)) {$check=false;$MESSAGE.="<br>Bitte Benutzernamen angeben";}
	if (empty($pass)) {$check=false;$MESSAGE.="<br>Kein Passwort angegeben";}
	if ($pass!=$pass2) {$check=false;$MESSAGE.="<br>Bitte 2x das gleiche Passwort angeben";}
	if (empty($email)) {$check=false;$MESSAGE.="<br>e-Mail sollte nicht leer sein.";}
	if (!checkemailadr($email,2)) {$check=false;$MESSAGE.="<br>e-Mail hat ein falsches Format oder Domain ist nicht gueltig.";}
	if (empty($db_host) || empty($db_port) || empty($db_name) || empty($db_user) || empty($db_pass)) {$check=false;$MESSAGE.="<br>Daten fuer den Zugriff auf die Datenbank sind nicht vollstaendig.";}
	if (empty($smtp_host) || empty($smtp_domain) || empty($smtp_user) || empty($smtp_pass)) {$check=false;$MESSAGE.="<br>Daten fuer den Zugriff auf den SMTP-Server sind nicht vollstaendig.";}

	if ($check) {
	
		//create directories!
		mkdir($mnl_path.'/files', 0777);
		mkdir($mnl_path.'/files/log', 0777);
		mkdir($mnl_path.'/files/import_export', 0777);		
		mkdir($mnl_path.'/files/forms', 0777);
		mkdir($mnl_path.'/files/newsletter', 0777);
		mkdir($mnl_path.'/files/newsletter/images', 0777);
		mkdir($mnl_path.'/files/attachements', 0777);
	
		//database
		//wir setzen db variablen und testen connection zur db!
		$MNL["DB"]["Name"]=$db_name;
		$MNL["DB"]["Host"]=$db_host;
		$MNL["DB"]["Port"]=$db_port;
		$MNL["DB"]["User"]=$db_user;
		$MNL["DB"]["Pass"]=$db_pass;
		include_once ($mnl_includepath."/Classes.inc");

		//$sql=stripslashes(file_get_contents($mnl_includepath."/mnl.sql"));
$sql[0]['name']=" adr Adressen ";
$sql[0]['sql']="
CREATE TABLE ".$mnl_tablePrefix."adr (
  id int(11) NOT NULL auto_increment,
  email varchar(255) NOT NULL default '',
  aktiv tinyint(4) NOT NULL default '1',
  siteid varchar(64) NOT NULL default '',
  created datetime default NULL,
  updated datetime default NULL,
  author varchar(64) default NULL,
  editor varchar(64) default NULL,
  status tinyint(4) NOT NULL default '0',
  errors smallint(6) default '0',
  code varchar(32) default '0',
  clicks smallint(6) default '0',
  views smallint(6) default '0',
  newsletter smallint(6) default '0',
  PRIMARY KEY  (id),
  KEY email (email),
  KEY aktiv (aktiv),
  KEY siteid (siteid),
  KEY status (status),
  KEY code (code)
) TYPE=MyISAM
";

$sql[1]['name']=" adr_details Adressdetails ";
$sql[1]['sql']="
CREATE TABLE ".$mnl_tablePrefix."adr_details (
  id int(11) NOT NULL auto_increment,
  adr_id int(11) NOT NULL default '0',
  siteid varchar(64) NOT NULL default '',
  f0 varchar(128) default NULL,
  f1 varchar(128) default NULL,
  f2 varchar(128) default NULL,
  f3 varchar(128) default NULL,
  f4 varchar(128) default NULL,
  f5 varchar(128) default NULL,
  f6 varchar(128) default NULL,
  f7 varchar(128) default NULL,
  f8 varchar(128) default NULL,
  f9 varchar(128) default NULL,
  PRIMARY KEY  (id),
  KEY adr_id (adr_id),
  KEY siteid (siteid),
  KEY adr_id_2 (adr_id,siteid)
) TYPE=MyISAM
";

$sql[2]['name']=" adr_grp Adressgruppen ";
$sql[2]['sql']="
CREATE TABLE ".$mnl_tablePrefix."adr_grp (
  id int(11) NOT NULL auto_increment,
  name varchar(128) NOT NULL default '',
  descr mediumtext,
  aktiv tinyint(4) NOT NULL default '0',
  siteid varchar(64) NOT NULL default '',
  standard tinyint(4) NOT NULL default '0',
  color VARCHAR( 10 ) DEFAULT '#ffffff',
  PRIMARY KEY  (id),
  KEY name (name),
  KEY aktiv (aktiv),
  KEY siteid (siteid),
  KEY standard (standard)
) TYPE=MyISAM
";

$sql[3]['name']=" adr_grp_ref Adress-Gruppen REF";
$sql[3]['sql']="
CREATE TABLE ".$mnl_tablePrefix."adr_grp_ref (
  id int(11) NOT NULL auto_increment,
  adr_id int(11) NOT NULL default '0',
  grp_id int(11) NOT NULL default '0',
  siteid varchar(64) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY adr_id (adr_id),
  KEY grp_id (grp_id),
  KEY siteid (siteid)
) TYPE=MyISAM
";

$sql[4]['name']=" config Einstellungen  ";
$sql[4]['sql']="
CREATE TABLE ".$mnl_tablePrefix."config (
  id int(11) NOT NULL auto_increment,
  name varchar(255) NOT NULL default '',
  smtp_host varchar(255) NOT NULL default '',
  smtp_domain varchar(255) NOT NULL default '',
  smtp_user varchar(255) NOT NULL default '',
  smtp_pass varchar(255) NOT NULL default '',
  sender_name varchar(255) NOT NULL default '',
  sender_email varchar(255) NOT NULL default '',
  siteid varchar(64) NOT NULL default '',
  notify_mail varchar(128) default NULL,
  return_mail varchar(128) default NULL,
  notify_subscribe tinyint(4) NOT NULL default '1',
  notify_unsubscribe tinyint(4) NOT NULL default '1',
  emailcheck_intern tinyint(4) NOT NULL default '2',
  emailcheck_subscribe tinyint(4) NOT NULL default '2',
  max_mails_atonce smallint(4) NOT NULL default '25',
  max_mails_bcc smallint(4) NOT NULL default '50',
  max_mails_retry tinyint(4) NOT NULL default '5',
  PRIMARY KEY  (id),
  KEY siteid (siteid)
) TYPE=MyISAM
";

$sql[5]['name']=" frm Formulare ";
$sql[5]['sql']="
CREATE TABLE ".$mnl_tablePrefix."frm (
  id int(11) NOT NULL auto_increment,
  name varchar(64) NOT NULL default '',
  descr varchar(255) NOT NULL default '',
  siteid varchar(64) NOT NULL default '',
  aktiv tinyint(4) NOT NULL default '1',
  created datetime default NULL,
  updated datetime default NULL,
  author varchar(64) default NULL,
  editor varchar(64) default NULL,
  double_optin smallint(6) default '0',
  subscriptions int(11) NOT NULL default '0',
  f0 varchar(128) default NULL,
  f1 varchar(128) default NULL,
  f2 varchar(128) default NULL,
  f3 varchar(128) default NULL,
  f4 varchar(128) default NULL,
  f5 varchar(128) default NULL,
  f6 varchar(128) default NULL,
  f7 varchar(128) default NULL,
  f8 varchar(128) default NULL,
  f9 varchar(128) default NULL,
  f0_type varchar(24) default 'text',
  f1_type varchar(24) default 'text',
  f2_type varchar(24) default 'text',
  f3_type varchar(24) default 'text',
  f4_type varchar(24) default 'text',
  f5_type varchar(24) default 'text',
  f6_type varchar(24) default 'text',
  f7_type varchar(24) default 'text',
  f8_type varchar(24) default 'text',
  f9_type varchar(24) default 'text',
  f0_required smallint(6) default '0',
  f1_required smallint(6) default '0',
  f2_required smallint(6) default '0',
  f3_required smallint(6) default '0',
  f4_required smallint(6) default '0',
  f5_required smallint(6) default '0',
  f6_required smallint(6) default '0',
  f7_required smallint(6) default '0',
  f8_required smallint(6) default '0',
  f9_required smallint(6) default '0',
  f0_value text,
  f1_value text,
  f2_value text,
  f3_value text,
  f4_value text,
  f5_value text,
  f6_value text,
  f7_value text,
  f8_value text,
  f9_value text,
  PRIMARY KEY  (id),
  KEY name (name),
  KEY siteid (siteid),
  KEY aktiv (aktiv)
) TYPE=MyISAM
";

$sql[6]['name']=" frm_grp_ref Formular-Gruppen REF ";
$sql[6]['sql']="
CREATE TABLE ".$mnl_tablePrefix."frm_grp_ref (
  id int(11) NOT NULL auto_increment,
  frm_id int(11) NOT NULL default '0',
  grp_id int(11) NOT NULL default '0',
  siteid varchar(64) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY frm_id (frm_id),
  KEY grp_id (grp_id),
  KEY siteid (siteid)
) TYPE=MyISAM
";

$sql[7]['name']=" log ";
$sql[7]['sql']="
CREATE TABLE ".$mnl_tablePrefix."log (
  id bigint(20) NOT NULL auto_increment,
  user varchar(64) NOT NULL default '',
  action varchar(255) NOT NULL default '',
  siteid varchar(64) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY user (user,siteid)
) TYPE=MyISAM
";

$sql[8]['name']=" nl NL ";
$sql[8]['sql']="
CREATE TABLE ".$mnl_tablePrefix."nl (
  id int(11) NOT NULL auto_increment,
  subject varchar(255) NOT NULL default '',
  aktiv tinyint(4) NOT NULL default '0',
  body longtext,
  link tinytext,
  created datetime default NULL,
  updated datetime default NULL,
  status tinyint(4) default '0',
  massmail tinyint(4) NOT NULL default '0',
  clicks smallint(6) default '0',
  views smallint(6) default '0',
  author varchar(128) default NULL,
  editor varchar(64) default NULL,
  grp_id int(11) NOT NULL default '0',
  attm varchar(255) default NULL,
  siteid varchar(64) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY aktiv (aktiv),
  KEY nl_subject (subject),
  KEY grp_id (grp_id),
  KEY siteid (siteid),
  KEY status (status)
) TYPE=MyISAM
";

$sql[9]['name']=" nl_grp NL Gruppen ";
$sql[9]['sql']="
CREATE TABLE ".$mnl_tablePrefix."nl_grp (
  id int(11) NOT NULL auto_increment,
  name varchar(128) NOT NULL default '',
  descr mediumtext NOT NULL,
  aktiv tinyint(4) NOT NULL default '0',
  siteid varchar(64) NOT NULL default '',
  standard tinyint(4) NOT NULL default '0',
  color VARCHAR( 10 ) DEFAULT '#ffffff',
  PRIMARY KEY  (id),
  KEY name (name),
  KEY aktiv (aktiv),
  KEY siteid (siteid),
  KEY standard (standard)
) TYPE=MyISAM
";

$sql[10]['name']=" nl_h History ";
$sql[10]['sql']="
CREATE TABLE ".$mnl_tablePrefix."nl_h (
  id bigint(20) NOT NULL auto_increment,
  q_id int(11) NOT NULL default '0',
  nl_id int(11) NOT NULL default '0',
  grp_id int(11) NOT NULL default '0',
  adr_id int(11) NOT NULL default '0',
  status smallint(6) default NULL,
  created datetime default NULL,
  errors smallint(6) default '0',
  sent datetime default NULL,
  siteid varchar(64) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY siteid (siteid),
  KEY status (status),
  KEY adr_id (adr_id),
  KEY grp_id (grp_id),
  KEY nl_id (nl_id),
  KEY q_id (q_id)
) TYPE=MyISAM
";

$sql[11]['name']=" nl_q - Queue ";
$sql[11]['sql']="
CREATE TABLE ".$mnl_tablePrefix."nl_q (
  id int(11) NOT NULL auto_increment,
  nl_id int(11) NOT NULL default '0',
  grp_id int(11) NOT NULL default '0',
  status smallint(6) NOT NULL default '0',
  created datetime default NULL,
  send_at datetime default NULL,
  sent datetime default NULL,
  author varchar(64) default NULL,
  siteid varchar(64) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY nl_id (nl_id,grp_id,status),
  KEY siteid (siteid)
) TYPE=MyISAM
";

$sql[12]['name']=" user - Benutzer ";
$sql[12]['sql']="
CREATE TABLE ".$mnl_tablePrefix."user (
  id int(11) NOT NULL auto_increment,
  name varchar(64) NOT NULL default '',
  passwd varchar(64) NOT NULL default '',
  aktiv smallint(6) NOT NULL default '1',
  admin smallint(6) NOT NULL default '0',
  style varchar(64) NOT NULL default 'default',
  lang VARCHAR( 8 ) NOT NULL DEFAULT 'de',
  siteid varchar(64) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY name (name,passwd,aktiv,siteid),
  KEY lang (lang)
) TYPE=MyISAM
";

$sql[13]['name']=" frm_s - Formulare, subscriptions ";
$sql[13]['sql']="
CREATE TABLE ".$mnl_tablePrefix."frm_s (
  id int(11) NOT NULL auto_increment,
  frm_id int(11) NOT NULL default '0',
  adr_id int(11) NOT NULL default '0',
  created datetime default NULL,
  siteid varchar(128) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY frm_id (frm_id,adr_id,siteid)
) TYPE=MyISAM
";

/*

    if(!@mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS)) {
        echo "Es konnte keine Verbindung aufgebaut werden";
    }

    echo "Verbindung wurde aufgebaut<br />\n";

    if(!mysql_select_db(MYSQL_DATABASE)) {
        echo "Konnte Datenbank nicht benutzen.<br />\n";
        echo "Der Grund daf�r: ".mysql_error()."\n";
    }

    echo "Die Datenbank wurde ausgew�hlt";

    // Hier kann man jetzt MySQL-Querys senden
    $sqls = array("tu was", "mach dies", "und das");
    foreach($sqls as $sql) {
        $result = mysql_query($sql) OR die(mysql_error());
    }

*/
		$checkDB=false;
		$DB=new ConnectDB();
		$sc=count($sql);
		for ($scc=0;$scc<$sc;$scc++) {
			if ($DB->Query($sql[$scc]['sql'])) {
				$MESSAGE.="<br>...Datenbanktabelle ".$mnl_tablePrefix.$sql[$scc]['name']." wurde erstellt.";
				$checkDB=true;
				//$MESSAGE.="<pre>".$sql."</pre>";
			} else {
				$MESSAGE.="<br>...Ein Fehler beim Erstellen der Datenbanktabelle ".$mnl_tablePrefix.$sql[$scc]['name']." ist aufgetreten :-(<br><pre>".$sql[$scc]['sql']."</pre>";
				$checkDB=false;
				$check=false;
			}
		}
		if ($checkDB) {

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

		
			$CONFIG=new mnlCFG();
			$CONFIG->addUSER(Array(
				"siteid"=>MNL_SITEID,
				"name"=>$name,
				"passwd"=>$pass,
				"aktiv"=>1,
				"admin"=>1,
				"style"=>"default",
				"lang"=>"de"
				));
			$MESSAGE.="<br>...Benutzer '$name' wurde angelegt.";
			$CONFIG->addCFG(Array(
				"siteid"=>MNL_SITEID,
				"name"=>"mNL_0",
				"sender_name"=>"mNL Newsletter",
				"sender_email"=>$email,
				"return_mail"=>$email,
				"notify_mail"=>$email,
				"notify_subscribe"=>0,
				"notify_unsubscribe"=>0,
				"max_mails_atonce"=>25,
				"max_mails_bcc"=>50,
				"max_mails_retry"=>5,
				"smtp_host"=>$smtp_host,
				"smtp_domain"=>$smtp_domain,
				"smtp_user"=>$smtp_user,
				"smtp_pass"=>$smtp_pass,
				"emailcheck_intern"=>2,
				"emailcheck_subscribe"=>2
				));
				$MESSAGE.="<br>...Grundeinstellungen wurden gespeichert.";
				//config schreiben ---> per template
				$mnl_config='<?php
//domain
$mnl_Domain="'.$mnl_Domain.'";
//absoluter pfad , docroot
$mnl_docroot="'.$mnl_docroot.'";
//script verzeichnis
$mnl_dir="'.$mnl_dir.'";
//table prefix
$mnl_tablePrefix="'.$mnl_tablePrefix_cfg.'";
//database
$MNL["DB"]["Name"]="'.$db_name.'";
$MNL["DB"]["Host"]="'.$db_host.'";
$MNL["DB"]["Port"]="'.$db_port.'";
$MNL["DB"]["User"]="'.$db_user.'";
$MNL["DB"]["Pass"]="'.$db_pass.'";

/////////////////////////////////
include ($mnl_docroot."/".$mnl_dir."/include/mnl_lib.inc");
/////////////////////////////////
?>';

			$mnl_htaccess='
AuthType Basic
AuthName "Newsletter"
AuthUserFile '.$mnl_includepath.'/.htpasswd
require valid-user
';

			$mnl_htpasswd=$name.":".crypt($pass);


			write_file($mnl_includepath,"mnl_config.inc",$mnl_config);
			$MESSAGE.="<br>...Konfigurationsdatei wurde gespeichert.";

			write_file($mnl_includepath,".htpasswd",$mnl_htpasswd);
			$MESSAGE.="<br>.htpasswd Datei wurden geschrieben.";

			write_file($mnl_includepath,".htaccess",$mnl_htaccess);
			write_file($mnl_path."/files/import_export",".htaccess",$mnl_htaccess);
			write_file($mnl_path."/files/attachements",".htaccess",$mnl_htaccess);
			write_file($mnl_path."/tpl",".htaccess",$mnl_htaccess);
			write_file($mnl_path."/files/forms",".htaccess",$mnl_htaccess);
			write_file($mnl_path."/files/log",".htaccess",$mnl_htaccess);

			$MESSAGE.="<br>.htaccess Dateien wurden geschrieben.";

			
			$MESSAGE.= "Herzlichen Glueckwunsch,<br>
					<br>Die Installation der Tellmatic Newslettermaschine auf ".$mnl_Domain."/".$mnl_dir." war erfogreich.<br>
					<br>Besuchen Sie <br>".$mnl_Domain."/".$mnl_dir."/index.php<br>
					und melden sich mit Ihrem Benutzernamen und Passwort an.<br>";
					
			$MESSAGE_TEXT=str_replace("<br>","\n",$MESSAGE);
			@mail($email,
					"Tellmatic Installation",
					$MESSAGE_TEXT,
					"from:".$email."\r\n"
					);
		}//checkDB

	}//if check
}//set = save





//formular anzeigen
if ($set!="save" || !$check) {

	//Form
	$Form=new mSimpleForm();
	$FormularName="install";
	//make new Form
	$Form->new_Form($FormularName,$_SERVER["PHP_SELF"],"post","_self");
	//$this->set_FormStyle($FormularName,"font-size:10pt;font-color=red;");
	////$Form->set_FormStyleClass($FormularName,"mForm");
	//add a Description
	$Form->set_FormDesc($FormularName,"mNL Installation");
	$Form->new_Input($FormularName,"set", "hidden", "save");
	//////////////////
	//add inputfields and buttons....
	//////////////////
	//name
	$Form->new_Input($FormularName,$InputName_Name,"text", $$InputName_Name);
	$Form->set_InputStyleClass($FormularName,$InputName_Name,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_Name,40,40);
	$Form->set_InputDesc($FormularName,$InputName_Name,"Benutzername");
	$Form->set_InputReadonly($FormularName,$InputName_Name,false);
	$Form->set_InputOrder($FormularName,$InputName_Name,1);
	$Form->set_InputLabel($FormularName,$InputName_Name,"Benutzername:<br>");

	//pass
	$Form->new_Input($FormularName,$InputName_Pass,"password", $$InputName_Pass);
	$Form->set_InputStyleClass($FormularName,$InputName_Pass,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_Pass,40,40);
	$Form->set_InputDesc($FormularName,$InputName_Pass,"Passwort");
	$Form->set_InputReadonly($FormularName,$InputName_Pass,false);
	$Form->set_InputOrder($FormularName,$InputName_Pass,2);
	$Form->set_InputLabel($FormularName,$InputName_Pass,"Passwort:<br>");

	//pass2
	$Form->new_Input($FormularName,$InputName_Pass2,"password", $$InputName_Pass2);
	$Form->set_InputStyleClass($FormularName,$InputName_Pass2,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_Pass2,40,40);
	$Form->set_InputDesc($FormularName,$InputName_Pass2,"Passwort");
	$Form->set_InputReadonly($FormularName,$InputName_Pass2,false);
	$Form->set_InputOrder($FormularName,$InputName_Pass2,3);
	$Form->set_InputLabel($FormularName,$InputName_Pass2,"Passwort wiederholen:<br>");

	//email
	$Form->new_Input($FormularName,$InputName_EMail,"text", $$InputName_EMail);
	$Form->set_InputStyleClass($FormularName,$InputName_EMail,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_EMail,40,40);
	$Form->set_InputDesc($FormularName,$InputName_EMail,"e-Mail");
	$Form->set_InputReadonly($FormularName,$InputName_EMail,false);
	$Form->set_InputOrder($FormularName,$InputName_EMail,4);
	$Form->set_InputLabel($FormularName,$InputName_EMail,"e-Mail:<br>");


	//dbs
	$Form->new_Input($FormularName,$InputName_DBHost,"text", $$InputName_DBHost);
	$Form->set_InputStyleClass($FormularName,$InputName_DBHost,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_DBHost,40,40);
	$Form->set_InputDesc($FormularName,$InputName_DBHost,"DB-Host");
	$Form->set_InputReadonly($FormularName,$InputName_DBHost,false);
	$Form->set_InputOrder($FormularName,$InputName_DBHost,5);
	$Form->set_InputLabel($FormularName,$InputName_DBHost,"DB-Host:<br>");

	//dbs
	$Form->new_Input($FormularName,$InputName_DBPort,"text", $$InputName_DBPort);
	$Form->set_InputStyleClass($FormularName,$InputName_DBPort,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_DBPort,40,40);
	$Form->set_InputDesc($FormularName,$InputName_DBPort,"DB-Port");
	$Form->set_InputReadonly($FormularName,$InputName_DBPort,false);
	$Form->set_InputOrder($FormularName,$InputName_DBPort,6);
	$Form->set_InputLabel($FormularName,$InputName_DBPort,"DB-Port:<br>");

	//dbs
	$Form->new_Input($FormularName,$InputName_DBName,"text", $$InputName_DBName);
	$Form->set_InputStyleClass($FormularName,$InputName_DBName,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_DBName,40,40);
	$Form->set_InputDesc($FormularName,$InputName_DBName,"DB-Name");
	$Form->set_InputReadonly($FormularName,$InputName_DBName,false);
	$Form->set_InputOrder($FormularName,$InputName_DBName,7);
	$Form->set_InputLabel($FormularName,$InputName_DBName,"DB-Name:<br>");

	//dbs
	$Form->new_Input($FormularName,$InputName_DBUser,"text", $$InputName_DBUser);
	$Form->set_InputStyleClass($FormularName,$InputName_DBUser,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_DBUser,40,40);
	$Form->set_InputDesc($FormularName,$InputName_DBUser,"DB-User");
	$Form->set_InputReadonly($FormularName,$InputName_DBUser,false);
	$Form->set_InputOrder($FormularName,$InputName_DBUser,8);
	$Form->set_InputLabel($FormularName,$InputName_DBUser,"DB-User:<br>");

	//dbs
	$Form->new_Input($FormularName,$InputName_DBPass,"password", $$InputName_DBPass);
	$Form->set_InputStyleClass($FormularName,$InputName_DBPass,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_DBPass,40,40);
	$Form->set_InputDesc($FormularName,$InputName_DBPass,"DB-Pass");
	$Form->set_InputReadonly($FormularName,$InputName_DBPass,false);
	$Form->set_InputOrder($FormularName,$InputName_DBPass,9);
	$Form->set_InputLabel($FormularName,$InputName_DBPass,"DB-Pass:<br>");

	//DBTablePrefix
	$Form->new_Input($FormularName,$InputName_DBTablePrefix,"text", $$InputName_DBTablePrefix);
	$Form->set_InputStyleClass($FormularName,$InputName_DBTablePrefix,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_DBTablePrefix,40,40);
	$Form->set_InputDesc($FormularName,$InputName_DBTablePrefix,"Tabellen Prefix");
	$Form->set_InputReadonly($FormularName,$InputName_DBTablePrefix,false);
	$Form->set_InputOrder($FormularName,$InputName_DBTablePrefix,10);
	$Form->set_InputLabel($FormularName,$InputName_DBTablePrefix,"Tabellen Prefix:<br>");

	//smtp
	$Form->new_Input($FormularName,$InputName_SMTPHost,"text", $$InputName_SMTPHost);
	$Form->set_InputStyleClass($FormularName,$InputName_SMTPHost,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_SMTPHost,40,40);
	$Form->set_InputDesc($FormularName,$InputName_SMTPHost,"SMTP Hostname / IP");
	$Form->set_InputReadonly($FormularName,$InputName_SMTPHost,false);
	$Form->set_InputOrder($FormularName,$InputName_SMTPHost,11);
	$Form->set_InputLabel($FormularName,$InputName_SMTPHost,"SMTP Hostname / IP:<br>");

	//smtp
	$Form->new_Input($FormularName,$InputName_SMTPUser,"text", $$InputName_SMTPUser);
	$Form->set_InputStyleClass($FormularName,$InputName_SMTPUser,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_SMTPUser,40,40);
	$Form->set_InputDesc($FormularName,$InputName_SMTPUser,"SMTP Username");
	$Form->set_InputReadonly($FormularName,$InputName_SMTPUser,false);
	$Form->set_InputOrder($FormularName,$InputName_SMTPUser,12);
	$Form->set_InputLabel($FormularName,$InputName_SMTPUser,"SMTP Username:<br>");

	//smtp
	$Form->new_Input($FormularName,$InputName_SMTPPass,"password", $$InputName_SMTPPass);
	$Form->set_InputStyleClass($FormularName,$InputName_SMTPPass,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_SMTPPass,40,40);
	$Form->set_InputDesc($FormularName,$InputName_SMTPPass,"SMTP Passwort");
	$Form->set_InputReadonly($FormularName,$InputName_SMTPPass,false);
	$Form->set_InputOrder($FormularName,$InputName_SMTPPass,13);
	$Form->set_InputLabel($FormularName,$InputName_SMTPPass,"SMTP Passwort:<br>");

	//smtp
	$Form->new_Input($FormularName,$InputName_SMTPDomain,"text", $$InputName_SMTPDomain);
	$Form->set_InputStyleClass($FormularName,$InputName_SMTPDomain,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_SMTPDomain,40,40);
	$Form->set_InputDesc($FormularName,$InputName_SMTPDomain,"SMTP Domain");
	$Form->set_InputReadonly($FormularName,$InputName_SMTPDomain,false);
	$Form->set_InputOrder($FormularName,$InputName_SMTPDomain,14);
	$Form->set_InputLabel($FormularName,$InputName_SMTPDomain,"SMTP Domain:<br>");

	//submit button
	$Form->new_Input($FormularName,$InputName_Submit,"submit","Installieren");
	$Form->set_InputStyleClass($FormularName,$InputName_Submit,"mFormSubmit","mFormSubmitFocus");
	$Form->set_InputDesc($FormularName,$InputName_Submit,"");
	$Form->set_InputReadonly($FormularName,$InputName_Submit,false);
	$Form->set_InputOrder($FormularName,$InputName_Submit,998);
	$Form->set_InputLabel($FormularName,$InputName_Submit,"");

/*
	//a reset button
	$Form->new_Input($FormularName,$InputName_Reset,"reset","Reset");
	$Form->set_InputStyleClass($FormularName,$InputName_Reset,"mFormReset","mFormResetFocus");
	$Form->set_InputDesc($FormularName,$InputName_Reset,"Reset");
	$Form->set_InputReadonly($FormularName,$InputName_Reset,false);
	$Form->set_InputOrder($FormularName,$InputName_Reset,999);
	$Form->set_InputLabel($FormularName,$InputName_Reset,"");
*/


$MESSAGE.=$Form->get_Form($FormularName);
}


$MESSAGE.="<br><br><a href=\"README\" target=\"_blank\">README</a>&nbsp;-&nbsp;<a href=\"INSTALL\" target=\"_blank\">INSTALL</a>";
$MESSAGE.="<br><br>INFOS:<br><br>DocRoot: ".$mnl_docroot;
$MESSAGE.="<br>Verzeichnis: ".$mnl_dir;
$MESSAGE.="<br>Installationspfad: ".$mnl_path;


echo "<div id=\"main\" class=\"main\">".$MESSAGE."</div>";
?>


</body>
</html>