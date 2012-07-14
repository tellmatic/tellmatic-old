#
# Tabellenstruktur für Tabelle `adr`
#

CREATE TABLE adr (
  id int(11) NOT NULL auto_increment,
  email varchar(255) NOT NULL default '',
  aktiv tinyint(4) NOT NULL default '1',
  siteid varchar(64) NOT NULL default '',
  created datetime default NULL,
  updated datetime default NULL,
  author varchar(64) default NULL,
  editor varchar(64) default NULL,
  status tinyint(4) NOT NULL default '0',
  errors smallint(6) default NULL,
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
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `adr_details`
#

CREATE TABLE adr_details (
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
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `adr_grp`
#

CREATE TABLE adr_grp (
  id int(11) NOT NULL auto_increment,
  name varchar(128) NOT NULL default '',
  descr mediumtext,
  aktiv tinyint(4) NOT NULL default '0',
  siteid varchar(64) NOT NULL default '',
  standard tinyint(4) NOT NULL default '0',
  color varchar(10) default '#ffffff',
  PRIMARY KEY  (id),
  KEY name (name),
  KEY aktiv (aktiv),
  KEY siteid (siteid),
  KEY standard (standard)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `adr_grp_ref`
#

CREATE TABLE adr_grp_ref (
  id int(11) NOT NULL auto_increment,
  adr_id int(11) NOT NULL default '0',
  grp_id int(11) NOT NULL default '0',
  siteid varchar(64) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY adr_id (adr_id),
  KEY grp_id (grp_id),
  KEY siteid (siteid)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `config`
#

CREATE TABLE config (
  id int(11) NOT NULL auto_increment,
  name varchar(255) NOT NULL default '',
  smtp_host varchar(255) NOT NULL default '',
  smtp_domain varchar(255) NOT NULL default '',
  smtp_user varchar(255) NOT NULL default '',
  smtp_pass varchar(255) NOT NULL default '',
  sender_name varchar(255) NOT NULL default '',
  sender_email varchar(255) NOT NULL default '',
  return_mail varchar(128) NOT NULL default '',
  siteid varchar(64) NOT NULL default '',
  notify_mail varchar(128) default NULL,
  notify_subscribe tinyint(4) NOT NULL default '1',
  notify_unsubscribe tinyint(4) NOT NULL default '1',
  emailcheck_intern tinyint(4) NOT NULL default '2',
  emailcheck_subscribe tinyint(4) NOT NULL default '2',
  max_mails_atonce smallint(4) NOT NULL default '25',
  max_mails_bcc smallint(6) NOT NULL default '50',
  max_mails_retry tinyint(4) NOT NULL default '5',
  PRIMARY KEY  (id),
  KEY siteid (siteid)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `frm`
#

CREATE TABLE frm (
  id int(11) NOT NULL auto_increment,
  name varchar(64) NOT NULL default '',
  descr varchar(255) NOT NULL default '',
  siteid varchar(64) NOT NULL default '',
  aktiv tinyint(4) NOT NULL default '1',
  created datetime default NULL,
  updated datetime default NULL,
  author varchar(64) default NULL,
  editor varchar(64) default NULL,
  double_optin smallint(6) NOT NULL default '0',
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
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `frm_grp_ref`
#

CREATE TABLE frm_grp_ref (
  id int(11) NOT NULL auto_increment,
  frm_id int(11) NOT NULL default '0',
  grp_id int(11) NOT NULL default '0',
  siteid varchar(64) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY frm_id (frm_id),
  KEY grp_id (grp_id),
  KEY siteid (siteid)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `frm_s`
#

CREATE TABLE frm_s (
  id int(11) NOT NULL auto_increment,
  created datetime default NULL,
  frm_id int(11) NOT NULL default '0',
  adr_id int(11) NOT NULL default '0',
  siteid varchar(128) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY frm_id (frm_id,adr_id,siteid)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `log`
#

CREATE TABLE log (
  id bigint(20) NOT NULL auto_increment,
  user varchar(64) NOT NULL default '',
  action varchar(255) NOT NULL default '',
  siteid varchar(64) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY user (user,siteid)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `nl`
#

CREATE TABLE nl (
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
  content_type varchar(12) NOT NULL default 'html',
  attm varchar(255) default NULL,
  siteid varchar(64) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY aktiv (aktiv),
  KEY nl_subject (subject),
  KEY grp_id (grp_id),
  KEY siteid (siteid),
  KEY status (status)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `nl_grp`
#

CREATE TABLE nl_grp (
  id int(11) NOT NULL auto_increment,
  name varchar(128) NOT NULL default '',
  descr mediumtext NOT NULL,
  aktiv tinyint(4) NOT NULL default '0',
  siteid varchar(64) NOT NULL default '',
  standard tinyint(4) NOT NULL default '0',
  color varchar(10) default '#ffffff',
  PRIMARY KEY  (id),
  KEY name (name),
  KEY aktiv (aktiv),
  KEY siteid (siteid),
  KEY standard (standard)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `nl_h`
#

CREATE TABLE nl_h (
  id bigint(20) NOT NULL auto_increment,
  q_id int(11) NOT NULL default '0',
  nl_id int(11) NOT NULL default '0',
  grp_id int(11) NOT NULL default '0',
  adr_id int(11) NOT NULL default '0',
  status smallint(6) default NULL,
  created datetime default NULL,
  errors smallint(6) default NULL,
  sent datetime default NULL,
  siteid varchar(64) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY siteid (siteid),
  KEY status (status),
  KEY adr_id (adr_id),
  KEY grp_id (grp_id),
  KEY nl_id (nl_id),
  KEY q_id (q_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `nl_q`
#

CREATE TABLE nl_q (
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
  KEY siteid (siteid),
  KEY send_at (send_at)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `user`
#

CREATE TABLE user (
  id int(11) NOT NULL auto_increment,
  name varchar(64) NOT NULL default '',
  passwd varchar(64) NOT NULL default '',
  aktiv smallint(6) NOT NULL default '1',
  admin smallint(6) NOT NULL default '0',
  style varchar(64) NOT NULL default 'default',
  lang varchar(8) NOT NULL default 'de',
  siteid varchar(64) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY name (name,passwd,aktiv,siteid),
  KEY lang (lang)
) TYPE=MyISAM;
    