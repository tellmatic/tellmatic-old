<?php
/*
 * qmail_mail.php
 *
 * @(#) $Header: /cvsroot/tellmatic/tellmatic/include/mimemessage/qmail_mail.php,v 1.1 2007/11/29 23:50:53 mcms09 Exp $
 *
 *
 */

	require_once("email_message.php");
	require_once("qmail_message.php");

	$message_object=new qmail_message_class;

Function qmail_mail($to,$subject,$message,$additional_headers="",$additional_parameters="")
{
	global $message_object;

	return($message_object->Mail($to,$subject,$message,$additional_headers,$additional_parameters));
}

?>