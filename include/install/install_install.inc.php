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
	define ("TM_TABLE_FRM", $tm_tablePrefix."frm");
	define ("TM_TABLE_FRM_GRP_REF", $tm_tablePrefix."frm_grp_ref");
	define ("TM_TABLE_FRM_S", $tm_tablePrefix."frm_s");

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
					"lang"=>"en",
					"expert"=>0
					));
	}//demo
	$MESSAGE.="<br>".sprintf(___("Benutzer '%s' wurde angelegt."),$name);

/***********************************************************/
//add config
/***********************************************************/
	if (!DEMO) {
		$CONFIG->addCFG(Array(
				"siteid"=>TM_SITEID,
				"name"=>"Tellmatic_0",
				"sender_name"=>"Tellmatic",
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
				"emailcheck_subscribe"=>2,
				"check_version"=>1,
				"track_image"=>'_blank'
				));
	}
	$MESSAGE.="<br>".___("Einstellungen wurden gespeichert.");

/***********************************************************/
//create configfile
/***********************************************************/
	$tm_config='<?php
//domain
$tm_Domain=\''.$tm_Domain.'\';
//absoluter pfad , docroot
$tm_docroot=\''.$tm_docroot.'\';
//script verzeichnis
$tm_dir=\''.$tm_dir.'\';
//table prefix
$tm_tablePrefix=\''.$tm_tablePrefix_cfg.'\';
//database
$tm["DB"]["Name"]=\''.$db_name.'\';
$tm["DB"]["Host"]=\''.$db_host.'\';
$tm["DB"]["Port"]=\''.$db_port.'\';
$tm["DB"]["User"]=\''.$db_user.'\';
$tm["DB"]["Pass"]=\''.$db_pass.'\';

/////////////////////////////////
include ($tm_docroot."/".$tm_dir."/include/tm_lib.inc.php");
/////////////////////////////////
?>';

/***********************************************************/
//create htaccess files
/***********************************************************/
$tm_htaccess='
AuthType Basic
AuthName "Tellmatic"
AuthUserFile '.$tm_includepath.'/.htpasswd
require valid-user
';

/***********************************************************/
//create initial .htpasswd files
/***********************************************************/
	$tm_htpasswd=$name.":".crypt($pass);

/***********************************************************/
//write config & htaccess & htpasswd
/***********************************************************/
	if (!DEMO) write_file($tm_includepath,"tm_config.inc.php",$tm_config);
	$MESSAGE.="<br>".___("Konfigurationsdatei wurde gespeichert.");
	if (DEBUG) $MESSAGE.="<pre>".htmlentities($tm_config)."</pre>";
	if (!DEMO) write_file($tm_includepath,".htpasswd",$tm_htpasswd);
	$MESSAGE.="<br>".___(".htpasswd Datei wurden erstellt.");
	if (DEBUG) $MESSAGE.="<pre>".htmlentities($tm_htpasswd)."</pre>";
	if (!DEMO) write_file($tm_path."/admin/tmp/",".htaccess",$tm_htaccess);
	if (!DEMO) write_file($tm_includepath,".htaccess",$tm_htaccess);
	if (!DEMO) write_file($tm_datapath,".htaccess",$tm_htaccess);
	if (!DEMO) write_file($tm_nlattachpath,".htaccess",$tm_htaccess);
	if (!DEMO) write_file($tm_tplpath,".htaccess",$tm_htaccess);
	if (!DEMO) write_file($tm_formpath,".htaccess",$tm_htaccess);
	if (!DEMO) write_file($tm_logpath,".htaccess",$tm_htaccess);
	if (!DEMO) write_file($tm_tmppath,".htaccess",$tm_htaccess);
	if (!DEMO) write_file($tm_reportpath,".htaccess",$tm_htaccess);
	$MESSAGE.="<br>".___(".htaccess Dateien wurden erstellt.");
	if (DEBUG) $MESSAGE.="<pre>".htmlentities($tm_htaccess)."</pre>";
}//if check && checkDB
?>