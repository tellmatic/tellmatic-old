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

$_MAIN_DESCR="Systemeinstellungen aendern";
$_MAIN_MESSAGE.="";

$set=getVar("set");
$cfg_id=getVar("cfg_id");

//field names for query
$InputName_Name="name";//name
$$InputName_Name=getVar($InputName_Name);

$InputName_SenderName="sender_name";//name
$$InputName_SenderName=getVar($InputName_SenderName);

$InputName_SenderEMail="sender_email";//name
$$InputName_SenderEMail=getVar($InputName_SenderEMail);

$InputName_ReturnMail="return_mail";
$$InputName_ReturnMail=getVar($InputName_ReturnMail);

$InputName_NotifySubscribe="notify_subscribe";
$$InputName_NotifySubscribe=getVar($InputName_NotifySubscribe);

$InputName_NotifyUnsubscribe="notify_unsubscribe";
$$InputName_NotifyUnsubscribe=getVar($InputName_NotifyUnsubscribe);

$InputName_NotifyMail="notify_mail";
$$InputName_NotifyMail=getVar($InputName_NotifyMail);

$InputName_MaxMails="max_mails";
$$InputName_MaxMails=getVar($InputName_MaxMails);

$InputName_MaxMailsBcc="max_mails_bcc";
$$InputName_MaxMailsBcc=getVar($InputName_MaxMailsBcc);

$InputName_MaxRetry="max_retry";
$$InputName_MaxRetry=getVar($InputName_MaxRetry);

$InputName_ECheckIntern="emailcheck_intern";
$$InputName_ECheckIntern=getVar($InputName_ECheckIntern);

$InputName_ECheckSubscribe="emailcheck_subscribe";
$$InputName_ECheckSubscribe=getVar($InputName_ECheckSubscribe);

$InputName_SMTPHost="smtp_host";
$$InputName_SMTPHost=getVar($InputName_SMTPHost);

$InputName_SMTPUser="smtp_user";
$$InputName_SMTPUser=getVar($InputName_SMTPUser);

$InputName_SMTPPass="smtp_pass";
$$InputName_SMTPPass=getVar($InputName_SMTPPass);

$InputName_SMTPDomain="smtp_domain";
$$InputName_SMTPDomain=getVar($InputName_SMTPDomain);


$CONFIG=new mnlCFG();

$check=true;
if ($set=="save") {
	//checkinput
	if (empty($sender_email)) {$check=false;$_MAIN_MESSAGE.="<br>Absender Adresse sollte nicht leer sein.";}
	if (!checkemailadr($sender_email,$EMailcheck_Intern)) {$check=false;$_MAIN_MESSAGE.="<br>Absender e-Mail hat ein falsches Format oder Domain ist nicht gueltig.";}
	if (empty($sender_name)) {$check=false;$_MAIN_MESSAGE.="<br>Absender Name sollte nicht leer sein.";}
	if (empty($return_mail)) {$check=false;$_MAIN_MESSAGE.="<br>e-Mail fuer Bounce Messages sollte nicht leer sein.";}
	if (!empty($return_mail) && !checkemailadr($return_mail,$EMailcheck_Intern)) {$check=false;$_MAIN_MESSAGE.="<br>e-Mail fuer Bounce Messages hat ein falsches Format oder Domain ist nicht gueltig.";}
	if (($notify_subscribe==1 || $notify_unsubscribe==1) && empty($notify_mail)) {$check=false;$_MAIN_MESSAGE.="<br>e-Mail fuer Benachrichtigungen sollte nicht leer sein.";}
	if (!empty($notify_mail) && !checkemailadr($notify_mail,$EMailcheck_Intern)) {$check=false;$_MAIN_MESSAGE.="<br>e-Mail fuer Benachrichtigungen bei An-/Abmeldungen hat ein falsches Format oder Domain ist nicht gueltig.";}

	//check smtp/pop3 connection .... and maybe give a warning message, dont fail :)
	//still to do , connect doesnt work here, need a testfunction........


	if ($check) {

		$CONFIG->updateCFG(Array(
				"siteid"=>$mnl_siteid,
				"name"=>$name,
				"sender_name"=>$sender_name,
				"sender_email"=>$sender_email,
				"return_mail"=>$return_mail,
				"notify_mail"=>$notify_mail,
				"notify_subscribe"=>$notify_subscribe,
				"notify_unsubscribe"=>$notify_unsubscribe,
				"max_mails_atonce"=>$max_mails,
				"max_mails_bcc"=>$max_mails_bcc,
				"max_mails_retry"=>$max_retry,
				"smtp_host"=>$smtp_host,
				"smtp_domain"=>$smtp_domain,
				"smtp_user"=>$smtp_user,
				"smtp_pass"=>$smtp_pass,
				"emailcheck_intern"=>$emailcheck_intern,
				"emailcheck_subscribe"=>$emailcheck_subscribe
				));
		$_MAIN_MESSAGE.="<br>Einstellungen wurden gespeichert und sind ab sofort gueltig!";
		$action="adm_set";
//
	} else {
		include_once ($mnl_includepath."/adm_set_form.inc");
	}
	
} else {	

	$C=$CONFIG->getCFG($mnl_siteid);
	$$InputName_Name=$C[0]['name'];//
	$$InputName_SenderName=$C[0]['sender_name'];//
	$$InputName_SenderEMail=$C[0]['sender_email'];//
	$$InputName_ReturnMail=$C[0]['return_mail'];//
	$$InputName_NotifySubscribe=$C[0]['notify_subscribe'];//
	$$InputName_NotifyUnsubscribe=$C[0]['notify_unsubscribe'];//
	$$InputName_NotifyMail=$C[0]['notify_mail'];//
	$$InputName_MaxMails=$C[0]['max_mails_atonce'];//
	$$InputName_MaxMailsBcc=$C[0]['max_mails_bcc'];//
	$$InputName_MaxRetry=$C[0]['max_mails_retry'];//
	$$InputName_SMTPHost=$C[0]['smtp_host'];//
	$$InputName_SMTPUser=$C[0]['smtp_user'];//
	$$InputName_SMTPPass=$C[0]['smtp_pass'];//
	$$InputName_SMTPDomain=$C[0]['smtp_domain'];//
	$$InputName_ECheckIntern=$C[0]['emailcheck_intern'];//
	$$InputName_ECheckSubscribe=$C[0]['emailcheck_subscribe'];//
	
	
	include_once ($mnl_includepath."/adm_set_form.inc");
	
	$_MAIN_OUTPUT.="<br><br><a href=\"javascript:switchSection('div_debug');\"><img src=\"".$mnl_iconURL."/information.png\" border=\"0\">&nbsp;Serverinfo</a>";
	
}
?>