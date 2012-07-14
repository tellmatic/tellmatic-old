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

if ($check && $checkDB) {

/***********************************************************/
//database
/***********************************************************/
//wir setzen db variablen und testen connection zur db!
$tm["DB"]["Name"]=$db_name;
$tm["DB"]["Host"]=$db_host;
$tm["DB"]["Port"]=$db_port;
$tm["DB"]["User"]=$db_user;
$tm["DB"]["Pass"]=$db_pass;
//include_once ($tm_includepath."/Classes.inc.php");
require_once ("./include/Classes.inc.php");

/***********************************************************/
//sqls
/***********************************************************/
//$sql=stripslashes(file_get_contents($tm_includepath."/tellmatic.sql"));
$sql[0]['name']=___("Tabelle")." '".$tm_tablePrefix."adr' ".___("Adressen");
$sql[0]['sql']="
CREATE TABLE ".$tm_tablePrefix."adr (
  id int NOT NULL auto_increment,
  email varchar(255) collate utf8_bin NOT NULL default '',
  clean tinyint NOT NULL default '0',
  aktiv tinyint NOT NULL default '1',
  siteid varchar(64) collate utf8_bin NOT NULL default '',
  created datetime default NULL,
  updated datetime default NULL,
  author varchar(64) collate utf8_bin default NULL,
  editor varchar(64) collate utf8_bin default NULL,
  status tinyint NOT NULL default '0',
  errors tinyint default NULL,
  code varchar(32) collate utf8_bin default '0',
  clicks smallint default '0',
  views smallint default '0',
  newsletter smallint default '0',
  PRIMARY KEY  (id),
  KEY email (email),
  KEY aktiv (aktiv),
  KEY siteid (siteid),
  KEY `status` (`status`),
  KEY code (code),
  KEY adr_siteid_status (siteid,`status`),
  KEY adr_siteid_email (siteid,email),
  KEY adr_siteid_id (id,siteid)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
";

$sql[1]['name']=___("Tabelle")." '".$tm_tablePrefix."adr_details' ".___("Adressen - Details");
$sql[1]['sql']="
CREATE TABLE ".$tm_tablePrefix."adr_details (
  id int NOT NULL auto_increment,
  adr_id int NOT NULL default '0',
  memo text collate utf8_bin,
  siteid varchar(64) collate utf8_bin NOT NULL default '',
  f0 varchar(128) collate utf8_bin default NULL,
  f1 varchar(128) collate utf8_bin default NULL,
  f2 varchar(128) collate utf8_bin default NULL,
  f3 varchar(128) collate utf8_bin default NULL,
  f4 varchar(128) collate utf8_bin default NULL,
  f5 varchar(128) collate utf8_bin default NULL,
  f6 varchar(128) collate utf8_bin default NULL,
  f7 varchar(128) collate utf8_bin default NULL,
  f8 varchar(128) collate utf8_bin default NULL,
  f9 varchar(128) collate utf8_bin default NULL,
  PRIMARY KEY  (id),
  KEY adr_id (adr_id),
  KEY siteid (siteid),
  KEY adrd_siteid_adrid (adr_id,siteid)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
";

$sql[2]['name']=___("Tabelle")." '".$tm_tablePrefix."adr_grp' ".___("Adressen - Gruppen");
$sql[2]['sql']="
CREATE TABLE ".$tm_tablePrefix."adr_grp (
  id int NOT NULL auto_increment,
  name varchar(128) collate utf8_bin NOT NULL default '',
  descr mediumtext collate utf8_bin,
  aktiv tinyint NOT NULL default '0',
  siteid varchar(64) collate utf8_bin NOT NULL default '',
  standard tinyint NOT NULL default '0',
  color varchar(10) collate utf8_bin default '#ffffff',
  created datetime NOT NULL default '0000-00-00 00:00:00',
  updated datetime NOT NULL default '0000-00-00 00:00:00',
  author varchar(64) collate utf8_bin NOT NULL default '',
  editor varchar(64) collate utf8_bin NOT NULL default '',
  PRIMARY KEY  (id),
  KEY name (name),
  KEY aktiv (aktiv),
  KEY siteid (siteid),
  KEY standard (standard)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

";

$sql[3]['name']=___("Tabelle")." '".$tm_tablePrefix."adr_grp_ref' ".___("Adressen - Referenzen");
$sql[3]['sql']="
CREATE TABLE ".$tm_tablePrefix."adr_grp_ref (
  id int NOT NULL auto_increment,
  adr_id int NOT NULL default '0',
  grp_id int NOT NULL default '0',
  siteid varchar(64) collate utf8_bin NOT NULL default '',
  PRIMARY KEY  (id),
  KEY adr_id (adr_id),
  KEY grp_id (grp_id),
  KEY siteid (siteid),
  KEY grp_site_id (grp_id,siteid),
  KEY aref_adrid_siteid (adr_id,siteid)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
";

$sql[4]['name']=___("Tabelle")." '".$tm_tablePrefix."config' ".___("Einstellungen");
$sql[4]['sql']="
CREATE TABLE ".$tm_tablePrefix."config (
  id int NOT NULL auto_increment,
  name varchar(255) collate utf8_bin NOT NULL default '',
  smtp_host varchar(255) collate utf8_bin NOT NULL default '',
  smtp_domain varchar(255) collate utf8_bin NOT NULL default '',
  smtp_user varchar(255) collate utf8_bin NOT NULL default '',
  smtp_pass varchar(255) collate utf8_bin NOT NULL default '',
  sender_name varchar(255) collate utf8_bin NOT NULL default '',
  sender_email varchar(255) collate utf8_bin NOT NULL default '',
  return_mail varchar(128) collate utf8_bin NOT NULL default '',
  siteid varchar(64) collate utf8_bin NOT NULL default '',
  notify_mail varchar(128) collate utf8_bin default NULL,
  notify_subscribe tinyint NOT NULL default '1',
  notify_unsubscribe tinyint NOT NULL default '1',
  emailcheck_intern tinyint NOT NULL default '2',
  emailcheck_subscribe tinyint NOT NULL default '2',
  max_mails_atonce smallint NOT NULL default '25',
  max_mails_bcc smallint NOT NULL default '50',
  max_mails_retry tinyint NOT NULL default '5',
  check_version tinyint NOT NULL default '1',
  track_image varchar(255) collate utf8_bin NOT NULL default '',
  PRIMARY KEY  (id),
  KEY siteid (siteid)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
";

$sql[5]['name']=___("Tabelle")." '".$tm_tablePrefix."frm' ".___("Formulare");
$sql[5]['sql']="
CREATE TABLE ".$tm_tablePrefix."frm (
  id int NOT NULL auto_increment,
  name varchar(64) collate utf8_bin NOT NULL default '',
  descr varchar(255) collate utf8_bin NOT NULL default '',
  siteid varchar(64) collate utf8_bin NOT NULL default '',
  aktiv tinyint NOT NULL default '1',
  created datetime default NULL,
  updated datetime default NULL,
  author varchar(64) collate utf8_bin default NULL,
  editor varchar(64) collate utf8_bin default NULL,
  double_optin tinyint NOT NULL default '0',
  subscriptions int NOT NULL default '0',
  use_captcha tinyint default '1',
  digits_captcha tinyint NOT NULL default '4',
  submit_value varchar(255) collate utf8_bin NOT NULL default '',
  reset_value varchar(255) collate utf8_bin NOT NULL default '',
  subscribe_aktiv tinyint NOT NULL default '1',
  email varchar(255) collate utf8_bin NOT NULL default '',
  f0 varchar(128) collate utf8_bin default NULL,
  f1 varchar(128) collate utf8_bin default NULL,
  f2 varchar(128) collate utf8_bin default NULL,
  f3 varchar(128) collate utf8_bin default NULL,
  f4 varchar(128) collate utf8_bin default NULL,
  f5 varchar(128) collate utf8_bin default NULL,
  f6 varchar(128) collate utf8_bin default NULL,
  f7 varchar(128) collate utf8_bin default NULL,
  f8 varchar(128) collate utf8_bin default NULL,
  f9 varchar(128) collate utf8_bin default NULL,
  f0_type varchar(24) collate utf8_bin default 'text',
  f1_type varchar(24) collate utf8_bin default 'text',
  f2_type varchar(24) collate utf8_bin default 'text',
  f3_type varchar(24) collate utf8_bin default 'text',
  f4_type varchar(24) collate utf8_bin default 'text',
  f5_type varchar(24) collate utf8_bin default 'text',
  f6_type varchar(24) collate utf8_bin default 'text',
  f7_type varchar(24) collate utf8_bin default 'text',
  f8_type varchar(24) collate utf8_bin default 'text',
  f9_type varchar(24) collate utf8_bin default 'text',
  f0_required tinyint default '0',
  f1_required tinyint default '0',
  f2_required tinyint default '0',
  f3_required tinyint default '0',
  f4_required tinyint default '0',
  f5_required tinyint default '0',
  f6_required tinyint default '0',
  f7_required tinyint default '0',
  f8_required tinyint default '0',
  f9_required tinyint default '0',
  f0_value text collate utf8_bin,
  f1_value text collate utf8_bin,
  f2_value text collate utf8_bin,
  f3_value text collate utf8_bin,
  f4_value text collate utf8_bin,
  f5_value text collate utf8_bin,
  f6_value text collate utf8_bin,
  f7_value text collate utf8_bin,
  f8_value text collate utf8_bin,
  f9_value text collate utf8_bin,
  email_errmsg varchar(255) collate utf8_bin default '',
  captcha_errmsg varchar(255) collate utf8_bin default '',
  f0_errmsg varchar(255) collate utf8_bin default '',
  f1_errmsg varchar(255) collate utf8_bin default '',
  f2_errmsg varchar(255) collate utf8_bin default '',
  f3_errmsg varchar(255) collate utf8_bin default '',
  f4_errmsg varchar(255) collate utf8_bin default '',
  f5_errmsg varchar(255) collate utf8_bin default '',
  f6_errmsg varchar(255) collate utf8_bin default '',
  f7_errmsg varchar(255) collate utf8_bin default '',
  f8_errmsg varchar(255) collate utf8_bin default '',
  f9_errmsg varchar(255) collate utf8_bin default '',
  f0_expr varchar(255) collate utf8_bin default NULL,
  f1_expr varchar(255) collate utf8_bin default NULL,
  f2_expr varchar(255) collate utf8_bin default NULL,
  f3_expr varchar(255) collate utf8_bin default NULL,
  f4_expr varchar(255) collate utf8_bin default NULL,
  f5_expr varchar(255) collate utf8_bin default NULL,
  f6_expr varchar(255) collate utf8_bin default NULL,
  f7_expr varchar(255) collate utf8_bin default NULL,
  f8_expr varchar(255) collate utf8_bin default NULL,
  f9_expr varchar(255) collate utf8_bin default NULL,
  PRIMARY KEY  (id),
  KEY name (name),
  KEY siteid (siteid),
  KEY aktiv (aktiv)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
";

$sql[6]['name']=___("Tabelle")." '".$tm_tablePrefix."frm_grp_ref' ".___("Formulare - Referenzen");
$sql[6]['sql']="
CREATE TABLE ".$tm_tablePrefix."frm_grp_ref (
  id int NOT NULL auto_increment,
  frm_id int NOT NULL default '0',
  grp_id int NOT NULL default '0',
  siteid varchar(64) collate utf8_bin NOT NULL default '',
  PRIMARY KEY  (id),
  KEY frm_id (frm_id),
  KEY grp_id (grp_id),
  KEY siteid (siteid),
  KEY grp_site_id (grp_id,siteid)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

";

$sql[7]['name']=___("Tabelle")." '".$tm_tablePrefix."nl' ".___("Newsletter");
$sql[7]['sql']="
CREATE TABLE ".$tm_tablePrefix."nl (
  id int NOT NULL auto_increment,
  subject varchar(255) collate utf8_bin NOT NULL default '',
  aktiv tinyint NOT NULL default '0',
  body longtext collate utf8_bin,
  link tinytext collate utf8_bin,
  created datetime default NULL,
  updated datetime default NULL,
  status tinyint default '0',
  massmail tinyint NOT NULL default '0',
  clicks int default '0',
  views int default '0',
  author varchar(128) collate utf8_bin default NULL,
  editor varchar(64) collate utf8_bin default NULL,
  grp_id int NOT NULL default '0',
  content_type varchar(12) collate utf8_bin NOT NULL default 'html',
  attm varchar(255) collate utf8_bin default NULL,
  track_image varchar(255) collate utf8_bin NOT NULL default '_global',
  siteid varchar(64) collate utf8_bin NOT NULL default '',
  PRIMARY KEY  (id),
  KEY aktiv (aktiv),
  KEY nl_subject (`subject`),
  KEY grp_id (grp_id),
  KEY siteid (siteid),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
";

$sql[8]['name']=___("Tabelle")." '".$tm_tablePrefix."nl_grp' ".___("Newsleter - Gruppen");
$sql[8]['sql']="
CREATE TABLE ".$tm_tablePrefix."nl_grp (
  id int NOT NULL auto_increment,
  name varchar(128) collate utf8_bin NOT NULL default '',
  descr mediumtext collate utf8_bin NOT NULL,
  aktiv tinyint NOT NULL default '0',
  siteid varchar(64) collate utf8_bin NOT NULL default '',
  standard tinyint NOT NULL default '0',
  color varchar(10) collate utf8_bin default '#ffffff',
  created datetime NOT NULL default '0000-00-00 00:00:00',
  updated datetime NOT NULL default '0000-00-00 00:00:00',
  author varchar(64) collate utf8_bin NOT NULL default '',
  editor varchar(64) collate utf8_bin NOT NULL default '',
  PRIMARY KEY  (id),
  KEY name (name),
  KEY aktiv (aktiv),
  KEY siteid (siteid),
  KEY standard (standard)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
";

$sql[9]['name']=___("Tabelle")." '".$tm_tablePrefix."nl_h' History";
$sql[9]['sql']="
CREATE TABLE ".$tm_tablePrefix."nl_h (
  id int NOT NULL auto_increment,
  q_id int NOT NULL default '0',
  nl_id int NOT NULL default '0',
  grp_id int NOT NULL default '0',
  adr_id int NOT NULL default '0',
  status tinyint default NULL,
  created datetime default NULL,
  errors tinyint default NULL,
  sent datetime default NULL,
  ip varchar(16) collate utf8_bin NOT NULL default '0.0.0.0',
  siteid varchar(64) collate utf8_bin NOT NULL default '',
  PRIMARY KEY  (id),
  KEY siteid (siteid),
  KEY `status` (`status`),
  KEY adr_id (adr_id),
  KEY grp_id (grp_id),
  KEY nl_id (nl_id),
  KEY q_id (q_id),
  KEY nlh_siteid_status (siteid,`status`),
  KEY h_nlid_adrid_stat (`status`,nl_id,adr_id),
  KEY nlh_siteid_ip (siteid,ip),
  KEY nlh_siteid_qid_ip (siteid,ip,q_id),
  KEY nlh_siteid_ip_grpid (siteid,ip,grp_id),
  KEY nlh_siteid_ip_qid_nlid (siteid,ip,q_id,nl_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
";

$sql[10]['name']=___("Tabelle")." '".$tm_tablePrefix."nl_q' - Queue ";
$sql[10]['sql']="
CREATE TABLE ".$tm_tablePrefix."nl_q (
  id int NOT NULL auto_increment,
  nl_id int NOT NULL default '0',
  grp_id int NOT NULL default '0',
  status tinyint NOT NULL default '0',
  created datetime default NULL,
  send_at datetime default NULL,
  sent datetime default NULL,
  author varchar(64) collate utf8_bin default NULL,
  siteid varchar(64) collate utf8_bin NOT NULL default '',
  PRIMARY KEY  (id),
  KEY nl_id (nl_id,grp_id,`status`),
  KEY siteid (siteid),
  KEY send_at (send_at)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
";

$sql[11]['name']=___("Tabelle")." '".$tm_tablePrefix."user' - ".___("Benutzer");
$sql[11]['sql']="
CREATE TABLE ".$tm_tablePrefix."user (
  id int NOT NULL auto_increment,
  name varchar(64) collate utf8_bin NOT NULL default '',
  passwd varchar(128) collate utf8_bin NOT NULL default '',
  crypt varchar(128) collate utf8_bin NOT NULL default '',
  email varchar(255) collate utf8_bin NOT NULL default '',
  last_login int NOT NULL default '0',
  aktiv tinyint NOT NULL default '1',
  admin tinyint NOT NULL default '0',
  manager tinyint NOT NULL default '0',
  style varchar(64) collate utf8_bin NOT NULL default 'default',
  lang varchar(8) collate utf8_bin NOT NULL default 'de',
  expert tinyint default '0',
  siteid varchar(64) collate utf8_bin NOT NULL default '',
  PRIMARY KEY  (id),
  KEY name (name,passwd,aktiv,siteid),
  KEY lang (lang)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
";

$sql[12]['name']=___("Tabelle")." '".$tm_tablePrefix."frm_s' - ".___("Formulare - Anmeldungen");
$sql[12]['sql']="
CREATE TABLE ".$tm_tablePrefix."frm_s (
  id int NOT NULL auto_increment,
  created datetime default NULL,
  frm_id int NOT NULL default '0',
  adr_id int NOT NULL default '0',
  ip varchar(16) collate utf8_bin NOT NULL default '0.0.0.0',
  siteid varchar(128) collate utf8_bin NOT NULL default '',
  PRIMARY KEY  (id),
  KEY frm_id (frm_id,adr_id,siteid),
  KEY frms_siteid_ip (siteid,ip),
  KEY frms_siteid_ip_frmid (siteid,ip,frm_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
";

/***********************************************************/
//create tables etc
/***********************************************************/
	$checkDB=false;
	$DB=new tm_DB();
	$sc=count($sql);
	for ($scc=0;$scc<$sc;$scc++) {
		if (!DEMO && $DB->Query($sql[$scc]['sql'])) {
			$MESSAGE.="<br>".sprintf(___("Datenbank: %s wurde erstellt"),$sql[$scc]['name']);
			$checkDB=true;
			if (DEBUG) $MESSAGE.="<pre>".$sql[$scc]['sql']."</pre>";
		} else {//!demo && query
			if (DEMO) {
				$checkDB=true;
				$MESSAGE.="<br>".sprintf(___("Datenbank: %s wurde erstellt"),$sql[$scc]['name']);
				if (DEBUG) $MESSAGE.="<pre>".$sql[$scc]['sql']."</pre>";
			} else {//demo
				$MESSAGE.="<br>".___("Ein Fehler beim Erstellen der Datenbank ist aufgetreten")."<br>".$sql[$scc]['name']." :-(<br><pre>".$sql[$scc]['sql']."</pre>";
				if (DEBUG) $MESSAGE.="<pre>".$sql[$scc]['sql']."</pre>";
				$checkDB=false;
				$check=false;
			}//demo
		}//!demo && query
	}//for


}//check && checkDB
?>