-- Tellmatic 1.0.8.7
--
-- Tabellenstruktur für Tabelle `adr`
--

CREATE TABLE IF NOT EXISTS `adr` (
  `id` int(11) NOT NULL auto_increment,
  `email` varchar(255) collate utf8_bin NOT NULL default '',
  `clean` tinyint(1) NOT NULL default '0',
  `aktiv` tinyint(1) NOT NULL default '1',
  `siteid` varchar(64) collate utf8_bin NOT NULL default '',
  `created` datetime default NULL,
  `updated` datetime default NULL,
  `author` varchar(64) collate utf8_bin default NULL,
  `editor` varchar(64) collate utf8_bin default NULL,
  `status` tinyint(1) NOT NULL default '0',
  `errors` smallint(1) default NULL,
  `code` varchar(32) collate utf8_bin default '0',
  `clicks` smallint(1) default '0',
  `views` smallint(1) default '0',
  `newsletter` smallint(1) default '0',
  `recheck` tinyint(1) default NULL COMMENT 'marked for email validation',
  PRIMARY KEY  (`id`),
  KEY `email` (`email`),
  KEY `aktiv` (`aktiv`),
  KEY `siteid` (`siteid`),
  KEY `status` (`status`),
  KEY `code` (`code`),
  KEY `adr_siteid_status` (`siteid`,`status`),
  KEY `adr_siteid_email` (`siteid`,`email`),
  KEY `adr_siteid_id` (`id`,`siteid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=999189 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `adr_details`
--

CREATE TABLE IF NOT EXISTS `adr_details` (
  `id` int(11) NOT NULL auto_increment,
  `adr_id` int(11) NOT NULL default '0',
  `memo` text collate utf8_bin,
  `siteid` varchar(64) collate utf8_bin NOT NULL default '',
  `f0` varchar(128) collate utf8_bin default NULL,
  `f1` varchar(128) collate utf8_bin default NULL,
  `f2` varchar(128) collate utf8_bin default NULL,
  `f3` varchar(128) collate utf8_bin default NULL,
  `f4` varchar(128) collate utf8_bin default NULL,
  `f5` varchar(128) collate utf8_bin default NULL,
  `f6` varchar(128) collate utf8_bin default NULL,
  `f7` varchar(128) collate utf8_bin default NULL,
  `f8` varchar(128) collate utf8_bin default NULL,
  `f9` varchar(128) collate utf8_bin default NULL,
  PRIMARY KEY  (`id`),
  KEY `adr_id` (`adr_id`),
  KEY `siteid` (`siteid`),
  KEY `adrd_siteid_adrid` (`adr_id`,`siteid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=999154 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `adr_grp`
--

CREATE TABLE IF NOT EXISTS `adr_grp` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) collate utf8_bin NOT NULL default '',
  `public` tinyint(1) NOT NULL default '0',
  `public_name` varchar(255) collate utf8_bin default NULL,
  `descr` mediumtext collate utf8_bin,
  `aktiv` tinyint(1) NOT NULL default '0',
  `siteid` varchar(64) collate utf8_bin NOT NULL default '',
  `standard` tinyint(1) NOT NULL default '0',
  `color` varchar(10) collate utf8_bin default '#ffffff',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `author` varchar(64) collate utf8_bin NOT NULL default '',
  `editor` varchar(64) collate utf8_bin NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `name` (`name`),
  KEY `aktiv` (`aktiv`),
  KEY `siteid` (`siteid`),
  KEY `standard` (`standard`),
  KEY `public` (`public`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=111 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `adr_grp_ref`
--

CREATE TABLE IF NOT EXISTS `adr_grp_ref` (
  `id` int(11) NOT NULL auto_increment,
  `adr_id` int(11) NOT NULL default '0',
  `grp_id` int(11) NOT NULL default '0',
  `siteid` varchar(64) collate utf8_bin NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `adr_id` (`adr_id`),
  KEY `grp_id` (`grp_id`),
  KEY `siteid` (`siteid`),
  KEY `grp_site_id` (`grp_id`,`siteid`),
  KEY `aref_adrid_siteid` (`adr_id`,`siteid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1178551 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `blacklist`
--

CREATE TABLE IF NOT EXISTS `blacklist` (
  `id` int(11) NOT NULL auto_increment,
  `type` enum('email','domain','expr') collate utf8_bin NOT NULL default 'email',
  `expr` varchar(255) collate utf8_bin NOT NULL default '',
  `aktiv` tinyint(1) NOT NULL default '1',
  `siteid` varchar(64) collate utf8_bin NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `type` (`type`),
  KEY `bl_ate` (`type`,`expr`,`aktiv`,`siteid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=104 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) collate utf8_bin NOT NULL default '',
  `siteid` varchar(64) collate utf8_bin NOT NULL default '',
  `notify_mail` varchar(128) collate utf8_bin default NULL,
  `notify_subscribe` tinyint(1) NOT NULL default '1',
  `notify_unsubscribe` tinyint(1) NOT NULL default '1',
  `emailcheck_intern` tinyint(1) NOT NULL default '2',
  `emailcheck_subscribe` tinyint(1) NOT NULL default '2',
  `emailcheck_sendit` tinyint(1) NOT NULL default '1' COMMENT 'emailpruefung beim senden',
  `emailcheck_checkit` tinyint(1) NOT NULL default '3' COMMENT 'emailpruefung bei aufruf von check_it.php',
  `max_mails_retry` tinyint(1) NOT NULL default '5',
  `check_version` tinyint(1) NOT NULL default '1',
  `track_image` varchar(255) collate utf8_bin NOT NULL default '',
  `rcpt_name` varchar(255) collate utf8_bin NOT NULL default 'Newsletter',
  `unsubscribe_use_captcha` tinyint(1) NOT NULL default '0',
  `unsubscribe_digits_captcha` tinyint(1) NOT NULL default '4',
  `unsubscribe_sendmail` smallint(6) NOT NULL default '1',
  `unsubscribe_action` enum('unsubscribe','delete') collate utf8_bin NOT NULL,
  `checkit_from_email` varchar(255) collate utf8_bin NOT NULL default '',
  `checkit_adr_reset_error` tinyint(1) NOT NULL default '1',
  `checkit_adr_reset_status` tinyint(1) NOT NULL default '1',
  `bounceit_host` int(11) NOT NULL default '0',
  `bounceit_search` enum('header','body','headerbody') collate utf8_bin NOT NULL default 'headerbody',
  `bounceit_action` enum('auto','error','unsubscribe','aktiv','delete') collate utf8_bin NOT NULL default 'auto',
  `bounceit_filter_to` tinyint(1) NOT NULL default '0',
  `bounceit_filter_to_email` varchar(255) collate utf8_bin NOT NULL default '',
  `checkit_limit` smallint(6) NOT NULL default '25',
  `bounceit_limit` smallint(6) NOT NULL default '10',
  PRIMARY KEY  (`id`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `frm`
--

CREATE TABLE IF NOT EXISTS `frm` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(64) collate utf8_bin NOT NULL default '',
  `action_url` varchar(255) collate utf8_bin NOT NULL default '',
  `descr` tinytext collate utf8_bin NOT NULL,
  `siteid` varchar(64) collate utf8_bin NOT NULL default '',
  `aktiv` tinyint(1) NOT NULL default '1',
  `created` datetime default NULL,
  `updated` datetime default NULL,
  `author` varchar(64) collate utf8_bin default NULL,
  `editor` varchar(64) collate utf8_bin default NULL,
  `double_optin` tinyint(1) NOT NULL default '0',
  `subscriptions` int(11) NOT NULL default '0',
  `use_captcha` tinyint(1) default '1',
  `digits_captcha` tinyint(1) NOT NULL default '4',
  `submit_value` varchar(255) collate utf8_bin NOT NULL default '',
  `reset_value` varchar(255) collate utf8_bin NOT NULL default '',
  `subscribe_aktiv` tinyint(1) NOT NULL default '1',
  `check_blacklist` tinyint(1) NOT NULL default '1',
  `force_pubgroup` smallint(1) NOT NULL default '0',
  `overwrite_pubgroup` smallint(1) NOT NULL default '0',
  `email` varchar(255) collate utf8_bin NOT NULL default '',
  `f0` varchar(128) collate utf8_bin default NULL,
  `f1` varchar(128) collate utf8_bin default NULL,
  `f2` varchar(128) collate utf8_bin default NULL,
  `f3` varchar(128) collate utf8_bin default NULL,
  `f4` varchar(128) collate utf8_bin default NULL,
  `f5` varchar(128) collate utf8_bin default NULL,
  `f6` varchar(128) collate utf8_bin default NULL,
  `f7` varchar(128) collate utf8_bin default NULL,
  `f8` varchar(128) collate utf8_bin default NULL,
  `f9` varchar(128) collate utf8_bin default NULL,
  `f0_type` varchar(24) collate utf8_bin default 'text',
  `f1_type` varchar(24) collate utf8_bin default 'text',
  `f2_type` varchar(24) collate utf8_bin default 'text',
  `f3_type` varchar(24) collate utf8_bin default 'text',
  `f4_type` varchar(24) collate utf8_bin default 'text',
  `f5_type` varchar(24) collate utf8_bin default 'text',
  `f6_type` varchar(24) collate utf8_bin default 'text',
  `f7_type` varchar(24) collate utf8_bin default 'text',
  `f8_type` varchar(24) collate utf8_bin default 'text',
  `f9_type` varchar(24) collate utf8_bin default 'text',
  `f0_required` tinyint(1) default '0',
  `f1_required` tinyint(1) default '0',
  `f2_required` tinyint(1) default '0',
  `f3_required` tinyint(1) default '0',
  `f4_required` tinyint(1) default '0',
  `f5_required` tinyint(1) default '0',
  `f6_required` tinyint(1) default '0',
  `f7_required` tinyint(1) default '0',
  `f8_required` tinyint(1) default '0',
  `f9_required` tinyint(1) default '0',
  `f0_value` text collate utf8_bin,
  `f1_value` text collate utf8_bin,
  `f2_value` text collate utf8_bin,
  `f3_value` text collate utf8_bin,
  `f4_value` text collate utf8_bin,
  `f5_value` text collate utf8_bin,
  `f6_value` text collate utf8_bin,
  `f7_value` text collate utf8_bin,
  `f8_value` text collate utf8_bin,
  `f9_value` text collate utf8_bin,
  `email_errmsg` varchar(255) collate utf8_bin NOT NULL default '',
  `captcha_errmsg` varchar(255) collate utf8_bin NOT NULL default '',
  `blacklist_errmsg` varchar(255) collate utf8_bin NOT NULL default '',
  `pubgroup_errmsg` varchar(255) collate utf8_bin NOT NULL default '""',
  `f0_errmsg` varchar(255) collate utf8_bin NOT NULL default '',
  `f1_errmsg` varchar(255) collate utf8_bin NOT NULL default '',
  `f2_errmsg` varchar(255) collate utf8_bin NOT NULL default '',
  `f3_errmsg` varchar(255) collate utf8_bin NOT NULL default '',
  `f4_errmsg` varchar(255) collate utf8_bin NOT NULL default '',
  `f5_errmsg` varchar(255) collate utf8_bin NOT NULL default '',
  `f6_errmsg` varchar(255) collate utf8_bin NOT NULL default '',
  `f7_errmsg` varchar(255) collate utf8_bin NOT NULL default '',
  `f8_errmsg` varchar(255) collate utf8_bin NOT NULL default '',
  `f9_errmsg` varchar(255) collate utf8_bin NOT NULL default '',
  `f0_expr` varchar(255) collate utf8_bin default NULL,
  `f1_expr` varchar(255) collate utf8_bin default NULL,
  `f2_expr` varchar(255) collate utf8_bin default NULL,
  `f3_expr` varchar(255) collate utf8_bin default NULL,
  `f4_expr` varchar(255) collate utf8_bin default NULL,
  `f5_expr` varchar(255) collate utf8_bin default NULL,
  `f6_expr` varchar(255) collate utf8_bin default NULL,
  `f7_expr` varchar(255) collate utf8_bin default NULL,
  `f8_expr` varchar(255) collate utf8_bin default NULL,
  `f9_expr` varchar(255) collate utf8_bin default NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`),
  KEY `siteid` (`siteid`),
  KEY `aktiv` (`aktiv`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=147 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `frm_grp_ref`
--

CREATE TABLE IF NOT EXISTS `frm_grp_ref` (
  `id` int(11) NOT NULL auto_increment,
  `frm_id` int(11) NOT NULL default '0',
  `grp_id` int(11) NOT NULL default '0',
  `public` tinyint(4) NOT NULL default '0',
  `siteid` varchar(64) collate utf8_bin NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `frm_id` (`frm_id`),
  KEY `grp_id` (`grp_id`),
  KEY `siteid` (`siteid`),
  KEY `grp_site_id` (`grp_id`,`siteid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=931 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `frm_s`
--

CREATE TABLE IF NOT EXISTS `frm_s` (
  `id` int(11) NOT NULL auto_increment,
  `created` datetime default NULL,
  `frm_id` int(11) NOT NULL default '0',
  `adr_id` int(11) NOT NULL default '0',
  `ip` varchar(16) collate utf8_bin NOT NULL default '0.0.0.0',
  `siteid` varchar(128) collate utf8_bin NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `frm_id` (`frm_id`,`adr_id`,`siteid`),
  KEY `frms_siteid_ip` (`siteid`,`ip`),
  KEY `frms_siteid_ip_frmid` (`siteid`,`ip`,`frm_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `hosts`
--

CREATE TABLE IF NOT EXISTS `hosts` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) collate utf8_bin NOT NULL default '',
  `aktiv` tinyint(1) NOT NULL default '1',
  `standard` tinyint(1) NOT NULL default '0',
  `host` varchar(255) collate utf8_bin NOT NULL default '',
  `port` smallint(6) NOT NULL default '0',
  `type` enum('smtp','pop3','imap') collate utf8_bin NOT NULL default 'smtp',
  `options` varchar(255) collate utf8_bin NOT NULL default '',
  `smtp_auth` varchar(32) collate utf8_bin NOT NULL default 'LOGIN',
  `smtp_domain` varchar(255) collate utf8_bin default NULL,
  `smtp_ssl` tinyint(1) NOT NULL default '0',
  `smtp_max_piped_rcpt` tinyint(8) NOT NULL default '1',
  `user` varchar(64) collate utf8_bin default NULL,
  `pass` varchar(64) collate utf8_bin default NULL,
  `max_mails_atonce` smallint(6) NOT NULL default '25',
  `max_mails_bcc` smallint(6) NOT NULL default '50',
  `sender_name` varchar(255) collate utf8_bin NOT NULL default '',
  `sender_email` varchar(255) collate utf8_bin NOT NULL default '',
  `return_mail` varchar(255) collate utf8_bin NOT NULL default '',
  `reply_to` varchar(255) collate utf8_bin NOT NULL default '',
  `siteid` varchar(64) collate utf8_bin NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `aktiv` (`aktiv`),
  KEY `siteid` (`siteid`),
  KEY `hosts_aktiv_siteid` (`aktiv`,`siteid`),
  KEY `smtp_auth` (`smtp_auth`),
  KEY `standard` (`standard`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `nl`
--

CREATE TABLE IF NOT EXISTS `nl` (
  `id` int(11) NOT NULL auto_increment,
  `subject` varchar(255) collate utf8_bin NOT NULL default '',
  `title` varchar(255) collate utf8_bin default NULL COMMENT 'title, text 1 f. webseite',
  `title_sub` varchar(255) collate utf8_bin default NULL COMMENT 'subtitle, text 2 f webseite',
  `aktiv` tinyint(1) NOT NULL default '0',
  `body` longtext collate utf8_bin,
  `body_text` longtext collate utf8_bin,
  `summary` longtext collate utf8_bin NOT NULL COMMENT 'zusammenfassung f. webseite',
  `link` tinytext collate utf8_bin,
  `created` datetime default NULL,
  `updated` datetime default NULL,
  `status` tinyint(1) default '0',
  `massmail` tinyint(1) NOT NULL default '0',
  `rcpt_name` varchar(255) collate utf8_bin NOT NULL default 'Newsletter',
  `clicks` smallint(1) default '0',
  `views` smallint(1) default '0',
  `author` varchar(128) collate utf8_bin default NULL,
  `editor` varchar(64) collate utf8_bin default NULL,
  `grp_id` int(11) NOT NULL default '0',
  `content_type` varchar(12) collate utf8_bin NOT NULL default 'html',
  `track_image` varchar(255) collate utf8_bin NOT NULL default '_global',
  `is_template` tinyint(1) NOT NULL,
  `siteid` varchar(64) collate utf8_bin NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `aktiv` (`aktiv`),
  KEY `nl_subject` (`subject`),
  KEY `grp_id` (`grp_id`),
  KEY `siteid` (`siteid`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=303 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `nl_attm`
--

CREATE TABLE IF NOT EXISTS `nl_attm` (
  `id` int(11) NOT NULL auto_increment,
  `nl_id` int(11) NOT NULL default '0',
  `file` varchar(255) collate utf8_bin NOT NULL default '',
  `siteid` varchar(64) collate utf8_bin NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `nl_id` (`nl_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=566 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `nl_grp`
--

CREATE TABLE IF NOT EXISTS `nl_grp` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) collate utf8_bin NOT NULL default '',
  `descr` mediumtext collate utf8_bin NOT NULL,
  `aktiv` tinyint(1) NOT NULL default '0',
  `siteid` varchar(64) collate utf8_bin NOT NULL default '',
  `standard` tinyint(1) NOT NULL default '0',
  `color` varchar(10) collate utf8_bin default '#ffffff',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `author` varchar(64) collate utf8_bin NOT NULL default '',
  `editor` varchar(64) collate utf8_bin NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `name` (`name`),
  KEY `aktiv` (`aktiv`),
  KEY `siteid` (`siteid`),
  KEY `standard` (`standard`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=39 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `nl_h`
--

CREATE TABLE IF NOT EXISTS `nl_h` (
  `id` int(11) NOT NULL auto_increment,
  `q_id` int(11) NOT NULL default '0',
  `nl_id` int(11) NOT NULL default '0',
  `grp_id` int(11) NOT NULL default '0',
  `adr_id` int(11) NOT NULL default '0',
  `host_id` int(11) NOT NULL default '0',
  `status` tinyint(1) default NULL,
  `created` datetime default NULL,
  `errors` smallint(1) default NULL,
  `sent` datetime default NULL,
  `ip` varchar(16) collate utf8_bin NOT NULL default '0.0.0.0',
  `siteid` varchar(64) collate utf8_bin NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `siteid` (`siteid`),
  KEY `status` (`status`),
  KEY `adr_id` (`adr_id`),
  KEY `grp_id` (`grp_id`),
  KEY `nl_id` (`nl_id`),
  KEY `q_id` (`q_id`),
  KEY `nlh_siteid_status` (`siteid`,`status`),
  KEY `h_nlid_adrid_stat` (`status`,`nl_id`,`adr_id`),
  KEY `nlh_siteid_ip` (`siteid`,`ip`),
  KEY `nlh_siteid_qid_ip` (`siteid`,`ip`,`q_id`),
  KEY `nlh_siteid_ip_grpid` (`siteid`,`ip`,`grp_id`),
  KEY `nlh_siteid_ip_qid_nlid` (`siteid`,`ip`,`q_id`,`nl_id`),
  KEY `host_id` (`host_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=871141 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `nl_q`
--

CREATE TABLE IF NOT EXISTS `nl_q` (
  `id` int(11) NOT NULL auto_increment,
  `nl_id` int(11) NOT NULL default '0',
  `grp_id` int(11) NOT NULL default '0',
  `host_id` int(11) NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '0',
  `created` datetime default NULL,
  `send_at` datetime default NULL,
  `check_blacklist` tinyint(4) NOT NULL default '1',
  `autogen` tinyint(1) NOT NULL default '0',
  `sent` datetime default NULL,
  `author` varchar(64) collate utf8_bin default NULL,
  `siteid` varchar(64) collate utf8_bin NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `nl_id` (`nl_id`,`grp_id`,`status`),
  KEY `siteid` (`siteid`),
  KEY `send_at` (`send_at`),
  KEY `host_id` (`host_id`),
  KEY `autostart` (`autogen`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1113 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(64) collate utf8_bin NOT NULL default '',
  `passwd` varchar(64) collate utf8_bin NOT NULL default '',
  `crypt` varchar(128) collate utf8_bin NOT NULL default '',
  `email` varchar(255) collate utf8_bin NOT NULL default '',
  `last_login` int(11) NOT NULL default '0',
  `aktiv` tinyint(1) NOT NULL default '1',
  `admin` tinyint(1) NOT NULL default '0',
  `manager` tinyint(1) NOT NULL default '0',
  `style` varchar(64) collate utf8_bin NOT NULL default 'default',
  `lang` varchar(8) collate utf8_bin NOT NULL default 'de',
  `expert` tinyint(1) default '0',
  `siteid` varchar(64) collate utf8_bin NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `name` (`name`,`passwd`,`aktiv`,`siteid`),
  KEY `lang` (`lang`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=31 ;
