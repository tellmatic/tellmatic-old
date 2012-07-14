<?php
/*
 * test_sendmail_mail.php
 *
 * @(#) $Header: /cvsroot/tellmatic/tellmatic/include/mimemessage/test_sendmail_mail.php,v 1.1 2007/11/29 23:50:53 mcms09 Exp $
 *
 *
 */

	require("sendmail_mail.php");

	/*
	 *  Change these variables to specify your test sender and recipient addresses
	 */
	$from="mlemos@acm.org";
	$to="mlemos@acm.org";

	$subject="Testing sendmail_mail function";
	$message="Hello,\n\nThis message is just to let you know that the sendmail_mail() function is working fine as expected.\n\n$from";
	$additional_headers="From: $from";
	$additional_parameters="-f ".$from;
	if(sendmail_mail($to,$subject,$message,$additional_headers,$additional_parameters))
		echo "Ok.";
	else
		echo "Error: ".$message_object->error."\n";

?>