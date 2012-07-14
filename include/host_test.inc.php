<?php
/********************************************************************************/
/* this file is part of: / diese Datei ist ein Teil von:                        */
/* tellmatic, the newslettermachine                                             */
/* tellmatic, die Newslettermaschine                                            */
/* 2006/11 by Volker Augustin, multi.art.studio Hanau                            */
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

		$TestMessage="Hello,\n\n";
		$TestMessage.="This is ".TM_APPTEXT.".\n\n";
		$TestMessage.="If you can read this message, testing the SMTP-Server '".$HOST_T[0]['name']."' was successfull.\n\n";
		$TestMessage.="Thank you for using ".TM_APPTEXT.".\nv.";

		//new: !!!use sendmail_smtp!!! see Functions.inc
		#function SendMail_smtp($from_address,$from_name,$to_address,$to_name,$subject,$text,$html,$AttmFiles=Array(),$HOST=Array()) {}
		$subject_t="Testing Tellmatic SMTP-Server ".$HOST_T[0]['name'];
		$smtp_err=SendMail_smtp($HOST_T[0]['sender_email'],$HOST_T[0]['sender_name'],$LOGIN->USER['email'],$LOGIN->USER['name'],$subject_t,$TestMessage,$TestMessage,$AttmFiles=Array(),$HOST_T);

		
		if (!$smtp_err[0]) {
			$host_test=FALSE;
			$Error.=$smtp_err[1];#$email_obj->debug_msg;
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