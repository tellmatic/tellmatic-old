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

$MESSAGE.="<br><br>";

if ($check && $checkDB) {

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
	define ("TM_TABLE_LNK", $tm_tablePrefix."lnk");
	define ("TM_TABLE_LNK_GRP", $tm_tablePrefix."lnk_grp");
	define ("TM_TABLE_LNK_GRP_REF", $tm_tablePrefix."lnk_grp_ref");
	define ("TM_TABLE_LNK_CLICK", $tm_tablePrefix."lnk_click");


/***********************************************************/
//add user
/***********************************************************/
	if (!DEMO) {
		$pass_hash=md5(TM_SITEID.$name.$pass);
		$CONFIG=new tm_CFG();
		$CONFIG->addUSER(Array(
					"siteid"=>TM_SITEID,
					"name"=>$name,
					"passwd"=>$pass_hash,
					"crypt"=>crypt($pass,CRYPT_EXT_DES),
					"email"=>$email,
					"aktiv"=>1,
					"admin"=>1,
					"manager" =>1,
					"style"=>"default",
					"lang"=>$lang,
					"startpage"=>"Welcome",
					"expert"=>0
					));
	}//demo
	$MESSAGE.="<br>".sprintf(___("Benutzer '%s' wurde angelegt."),$name);

/***********************************************************/
//add config
/***********************************************************/
	if (!DEMO) {
		//insert config	
		$CONFIG->addCFG(Array(
				"siteid"=>TM_SITEID,
				"name"=>"Tellmatic_0",
				"lang"=>$lang,
				"style"=>"default",
				"notify_mail"=>$email,
				"notify_subscribe"=>0,
				"notify_unsubscribe"=>0,
				"max_mails_retry"=>5,
				"emailcheck_intern"=>2,
				"emailcheck_subscribe"=>2,
				"emailcheck_sendit"=>1,
				"emailcheck_checkit"=>3,
				"check_version"=>1,
				"rcpt_name"=>"Newsletter",
				"track_image"=>'_blank',
				"unsubscribe_use_captcha"=>0,
				"unsubscribe_digits_captcha"=>4,
				"unsubscribe_sendmail"=>1,
				"unsubscribe_action"=>"unsubscribe",
				"unsubscribe_host"=>1,
				"checkit_limit"=>25,
				"checkit_from_email"=>'',
				"checkit_adr_reset_error"=>1,
				"checkit_adr_reset_status"=>1,
				"bounceit_limit"=>10,
				"bounceit_host"=>0,
				"bounceit_action"=>'auto',
				"bounceit_search"=>'header',
				"bounceit_filter_to"=>0,
				"bounceit_filter_to_email"=>'',
				"proof"=>1,
				"proof_url"=>'http://proof.tellmatic.org',
				"proof_trigger"=>10,
				"proof_pc"=>10,
				));
		//add mailservers, use default settings for config and create smtp/pop3 host entries...
				$HOSTS=new tm_HOST();
				//add smtp host
				$Add_Host=$HOSTS->addHost(Array(
							"siteid"=>TM_SITEID,
							"name"=>"default smtp",
							"aktiv"=>1,
							"host"=>$smtp_host,
							"port"=>$smtp_port,
							"options"=>"novalidate-cert",
							"smtp_auth"=>$smtp_auth,
							"smtp_domain"=>$smtp_domain,
							"smtp_ssl"=>0,
							"smtp_max_piped_rcpt"=>1,
							"type"=>"smtp",
							"user"=>$smtp_user,
							"pass"=>$smtp_pass,
							"max_mails_atonce"=>25,
							"max_mails_bcc"=>1,
							"sender_name"=>"Tellmatic",
							"sender_email"=>$email,
							"return_mail"=>$email,
							"reply_to"=>$email,
							"delay"=>100000,
					));
				//make default smtp host!
				$HOSTS->setHostStd($Add_Host[1]);
				//add pop3 host
				$HOSTS->addHost(Array(
							"siteid"=>TM_SITEID,
							"name"=>"default pop3",
							"aktiv"=>1,
							"host"=>$smtp_host,
							"port"=>110,
							"options"=>"novalidate-cert",
							"smtp_auth"=>"",
							"smtp_domain"=>"",
							"smtp_ssl"=>0,
							"smtp_max_piped_rcpt"=>1,
							"type"=>"pop3",
							"user"=>$smtp_user,
							"pass"=>$smtp_pass,
							"max_mails_atonce"=>25,
							"max_mails_bcc"=>1,
							"sender_name"=>"Tellmatic",
							"sender_email"=>$email,
							"return_mail"=>$email,
							"reply_to"=>$email,
							"delay"=>100000,
							));
	}
	$MESSAGE.="<br>".___("Einstellungen wurden gespeichert.");
	
	

/***********************************************************/
//create configfile
/***********************************************************/
	$tm_config='<?php'."\n".
						'//domain'."\n".
						'if (isset($_SERVER[\'HTTPS\'])) {'."\n".
							'$protocol = $_SERVER[\'HTTPS\'] ? "https://" : "http://";'."\n".
						'} else {'."\n".
							'$protocol = "http://";'."\n".
						'}'."\n".
						'define("TM_DOMAIN",$protocol.\''.TM_DOMAINNAME.'\');'."\n".
						'//absoluter pfad , docroot'."\n".
						'define("TM_DOCROOT",\''.TM_DOCROOT.'\');'."\n".
						'//script verzeichnis'."\n".
						'define("TM_DIR",\''.TM_DIR.'\');'."\n".
						'//table prefix'."\n".
						'$tm_tablePrefix=\''.$tm_tablePrefix_cfg.'\';'."\n".
						'//database'."\n".
						'$tm["DB"]["Name"]=\''.$db_name.'\';'."\n".
						'$tm["DB"]["Host"]=\''.$db_host.'\';'."\n".
						'$tm["DB"]["Port"]=\''.$db_port.'\';'."\n".
						'$tm["DB"]["Socket"]=\''.$db_socket.'\';'."\n".
						'$tm["DB"]["User"]=\''.$db_user.'\';'."\n".
						'$tm["DB"]["Pass"]=\''.$db_pass.'\';'."\n".
						'/////////////////////////////////'."\n".
						'include (TM_DOCROOT."/".TM_DIR."/include/tm_lib.inc.php");'."\n".
						'/////////////////////////////////'."\n".
						'?>';

/***********************************************************/
//create htaccess files
/***********************************************************/
$tm_htaccess='AuthType Basic'."\n".
		'AuthName "Tellmatic"'."\n".
		'AuthUserFile '.TM_INCLUDEPATH.'/.htpasswd'."\n".
		'require valid-user'."\n";

/***********************************************************/
//create initial .htpasswd files
/***********************************************************/
	$tm_htpasswd=$name.":".crypt($pass);

/***********************************************************/
//write config & htaccess & htpasswd
/***********************************************************/
	if (!DEMO) write_file(TM_INCLUDEPATH,"tm_config.inc.php",$tm_config);
	$MESSAGE.="<br>".___("Konfigurationsdatei wurde gespeichert.");
	if (DEBUG) $MESSAGE.="<pre>".htmlentities($tm_config)."</pre>";
	if (!DEMO) write_file(TM_INCLUDEPATH,".htpasswd",$tm_htpasswd);
	$MESSAGE.="<br>".___(".htpasswd Datei wurden erstellt.");
	if (DEBUG) $MESSAGE.="<pre>".htmlentities($tm_htpasswd)."</pre>";
	#not used yet: if (!DEMO) write_file(TM_PATH."/admin/tmp/",".htaccess",$tm_htaccess);
	if (!DEMO) write_file(TM_INCLUDEPATH,".htaccess",$tm_htaccess);
	if (!DEMO) write_file($tm_datapath,".htaccess",$tm_htaccess);
	if (!DEMO) write_file(TM_TPLPATH,".htaccess",$tm_htaccess);
	if (!DEMO) write_file($tm_formpath,".htaccess",$tm_htaccess);
	if (!DEMO) write_file($tm_logpath,".htaccess",$tm_htaccess);
	if (!DEMO) write_file($tm_tmppath,".htaccess",$tm_htaccess);
	if (!DEMO) write_file($tm_reportpath,".htaccess",$tm_htaccess);
	$MESSAGE.="<br>".___(".htaccess Dateien wurden erstellt.");
	if (DEBUG) $MESSAGE.="<pre>".htmlentities($tm_htaccess)."</pre>";
}//if check && checkDB
?>