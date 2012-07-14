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

$HOST_T=$HOSTS->getHost($h_id);
$Mailer=new tm_Mail();

$host_test=FALSE;
$Error="";

$_MAIN_OUTPUT.="<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" width=\"100%\">";
$_MAIN_OUTPUT.= "<thead>".
						"<tr>".
						"<td><b>".display($HOST_T[0]['name'])."</b>".
						"</td>".
						"</tr>".
						"</thead>".
						"<tbody>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td>";
$_MAIN_OUTPUT.= "<font size=\"-1\">".display($HOST_T[0]['host'])."</font>";
$_MAIN_OUTPUT.= "<br>ID: ".$HOST_T[0]['id']." ";
if (!DEMO) {
	$_MAIN_OUTPUT.= "<br>".___("Host").": ".$HOST_T[0]['host']." ";
} else {
	$_MAIN_OUTPUT.= "<br>".___("Host").": mail.my-domain.tld ";
}
$_MAIN_OUTPUT.= "<br>".___("Type").": ".$HOST_T[0]['type']." ";
$_MAIN_OUTPUT.= "<br>".___("Port").": ".$HOST_T[0]['port']." ";
$_MAIN_OUTPUT.= "<br>".___("Options").": ".$HOST_T[0]['options']." ";
$_MAIN_OUTPUT.= "<br>".___("SMTP-Auth").": ".$HOST_T[0]['smtp_auth']." ";
if (!DEMO) {
	$_MAIN_OUTPUT.= "<br>".___("User").": ".$HOST_T[0]['user']." ";
} else {
	$_MAIN_OUTPUT.= "<br>".___("User").": my-username ";
}
if ($HOST_T[0]['aktiv']==1) {
	$_MAIN_OUTPUT.=  "<br>".tm_icon("tick.png",___("Aktiv"))."&nbsp;";
	$_MAIN_OUTPUT.=  ___("(aktiv)");
} else {
	$_MAIN_OUTPUT.=  "<br>".tm_icon("cancel.png",___("Inaktiv"))."&nbsp;";
	$_MAIN_OUTPUT.=  ___("(inaktiv)");
}
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td>";
if (!DEMO) {
	$_MAIN_OUTPUT .= "<br>".sprintf(___("Verbindung zum Server %s wird aufgebaut..."),$HOST_T[0]['name']." (".$HOST_T[0]['host'].":".$HOST_T[0]['port']."/".$HOST_T[0]['type'].")");
} else {
	$_MAIN_OUTPUT .= "<br>".sprintf(___("Verbindung zum Server %s wird aufgebaut..."),$HOST_T[0]['name']." (mail.my-domain.tld:".$HOST_T[0]['port']."/".$HOST_T[0]['type'].")");
}
//POP3 IMAP testen
if ($HOST_T[0]['type']=="imap" || $HOST_T[0]['type']=="pop3")	{
	if (!DEMO) {
	$Mailer->Connect($HOST_T[0]['host'], $HOST_T[0]['user'], $HOST_T[0]['pass'],$HOST_T[0]['type'],$HOST_T[0]['port'],$HOST_T[0]['options']);
	if (!empty($Mailer->Error)) {
		$Error=$Mailer->Error;
		$host_test=FALSE;
	} else {
		$host_test=TRUE;
		$Error="".sprintf(___("Gesamt: %s Mails"),$Mailer->count_msg);
	}
	}//demo
	if (DEMO) $host_test=TRUE;
}//type==pop3/imap

//SMTP testen
if ($HOST_T[0]['type']=="smtp")	{
	if (!DEMO) {
	//include necessary smtp-classes
	require_once(TM_INCLUDEPATH."/Class_SMTP.inc.php");
	//create e-mail object
	$email_obj=new smtp_message_class;//use SMTP!

	$email_obj->default_charset=$encoding;
	$email_obj->authentication_mechanism=$HOST_T[0]['smtp_auth'];
	$email_obj->localhost=$HOST_T[0]['smtp_domain'];
	$email_obj->smtp_host=$HOST_T[0]['host'];
	$email_obj->smtp_user=$HOST_T[0]['user'];
	$email_obj->smtp_port=$HOST_T[0]['port'];
	$email_obj->smtp_realm="";
	$email_obj->smtp_workstation="";
	$email_obj->smtp_password=$HOST_T[0]['pass'];
		$email_obj->ssl=$HOST_T[0]['smtp_ssl'];
	$email_obj->smtp_pop3_auth_host="";
	$email_obj->smtp_debug=0;
		if (DEBUG_SMTP) 	$email_obj->smtp_debug=1;
	$email_obj->smtp_html_debug=0;
	$email_obj->SetBulkMail=1;
	$email_obj->mailer=$ApplicationText;
	$email_obj->SetEncodedEmailHeader("To",$LOGIN->USER['email'],$LOGIN->USER['name']);
		$email_obj->SetEncodedEmailHeader("From",$HOST_T[0]['sender_email'],$HOST_T[0]['sender_name']);
		$email_obj->SetEncodedEmailHeader("Reply-To",$HOST_T[0]['reply_to'],$HOST_T[0]['sender_name']);
		$email_obj->SetHeader("Return-Path",$HOST_T[0]['return_mail']);
		$email_obj->SetEncodedEmailHeader("Errors-To",$HOST_T[0]['return_mail'],$HOST_T[0]['sender_name']);
		$email_obj->SetEncodedHeader("Subject","Testing Tellmatic SMTP-Server ".$HOST_T[0]['name']);
		$email_obj->maximum_piped_recipients=$HOST_T[0]['smtp_max_piped_rcpt'];//sends only XX rcpt to before waiting for ok from server!
	$TestMessage="Hello,\n\n";
	$TestMessage.="This is ".$ApplicationText.".\n\n";
	$TestMessage.="If you can read this message, testing SMTP-Server '".$HOST_T[0]['name']."' was successfull.\n\n";
	$TestMessage.="Thank you for using ".$ApplicationText.".\nv.";
	$email_obj->AddQuotedPrintableTextPart($TestMessage);	

	$smtp_err=$email_obj->Send();
	$Error=$smtp_err;
	#$Error.=$email_obj->debug_msg;
	
	if (!empty($smtp_err)) {
		$host_test=FALSE;
		#$Error.=$email_obj->debug_msg;
	} else {
			$Error.=sprintf(___("Eine Testmail wurde an die E-Mail-Adresse %s %s gesendet."),$LOGIN->USER['name'],$LOGIN->USER['email']);
			$host_test=TRUE;
		}
	}//demo
	if (DEMO) {
		$Error.=sprintf(___("Eine Testmail wurde an die E-Mail-Adresse %s %s gesendet."),$LOGIN->USER['name'],$LOGIN->USER['email']);
		$host_test=TRUE;
	}
}//type==smtp
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td>";
$_MAIN_OUTPUT .= "".display($Error)."";
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td>";
if (!$host_test)  {
	$_MAIN_OUTPUT.=  "".tm_icon("cancel.png",___("Fehler"))."&nbsp;";
	$_MAIN_OUTPUT .= "<b>".___("Der Test war nicht erfolgreich.")."</b>";
}
if ($host_test)  {
	$_MAIN_OUTPUT.=  "".tm_icon("tick.png",___("OK"))."&nbsp;";
	$_MAIN_OUTPUT .= "<b>".___("Der Test war erfolgreich.")."</b>";
}
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td>";
$_MAIN_OUTPUT.= "&nbsp;";
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "</tbody></table>";
?>