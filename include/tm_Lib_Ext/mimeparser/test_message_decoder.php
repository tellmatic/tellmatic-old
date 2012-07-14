<?php
/*
 * test_message_decoder.php
 *
 * @(#) $Header: /home/mlemos/cvsroot/mimeparser/test_message_decoder.php,v 1.10 2009/10/25 23:08:34 mlemos Exp $
 *
 */

	require_once('rfc822_addresses.php');
	require_once('mime_parser.php');

	$message_file=((IsSet($_SERVER['argv']) && count($_SERVER['argv'])>1) ? $_SERVER['argv'][1] : 'test/sample/message.eml');
	$mime=new mime_parser_class;
	
	/*
	 * Set to 0 for parsing a single message file
	 * Set to 1 for parsing multiple messages in a single file in the mbox format
	 */
	$mime->mbox = 0;
	
	/*
	 * Set to 0 for not decoding the message bodies
	 */
	$mime->decode_bodies = 1;

	/*
	 * Set to 0 to make syntax errors make the decoding fail
	 */
	$mime->ignore_syntax_errors = 1;

	/*
	 * Set to 0 to avoid keeping track of the lines of the message data
	 */
	$mime->track_lines = 1;

	$parameters=array(
		'File'=>$message_file,
		
		/* Read a message from a string instead of a file */
		/* 'Data'=>'My message data string',              */

		/* Save the message body parts to a directory     */
		/* 'SaveBody'=>'/tmp',                            */

		/* Do not retrieve or save message body parts     */
		'SkipBody'=>1,
	);

/*
 * The following lines are for testing purposes.
 * Remove these lines when adapting this example to real applications.
 */
	if(defined('__TEST'))
	{
		if(IsSet($__test_options['parameters']))
			$parameters=$__test_options['parameters'];
		if(IsSet($__test_options['mbox']))
			$mime->mbox=$__test_options['mbox'];
		if(IsSet($__test_options['decode_bodies']))
			$mime->decode_bodies=$__test_options['decode_bodies'];
	}

	if(!$mime->Decode($parameters, $decoded))
	{
		echo 'MIME message decoding error: '.$mime->error.' at position '.$mime->error_position;
		if($mime->track_lines
		&& $mime->GetPositionLine($mime->error_position, $line, $column))
			echo ' line '.$line.' column '.$column;
		echo "\n";
	}
	else
	{
		echo 'MIME message decoding successful.'."\n";
		echo (count($decoded)==1 ? '1 message was found.' : count($decoded).' messages were found.'),"\n";
		for($message = 0; $message < count($decoded); $message++)
		{
			echo 'Message ',($message+1),':',"\n";
			var_dump($decoded[$message]);
			if($mime->decode_bodies)
			{
				if($mime->Analyze($decoded[$message], $results))
					var_dump($results);
				else
					echo 'MIME message analyse error: '.$mime->error."\n";
			}
		}
		for($warning = 0, Reset($mime->warnings); $warning < count($mime->warnings); Next($mime->warnings), $warning++)
		{
			$w = Key($mime->warnings);
			echo 'Warning: ', $mime->warnings[$w], ' at position ', $w;
			if($mime->track_lines
			&& $mime->GetPositionLine($w, $line, $column))
				echo ' line '.$line.' column '.$column;
			echo "\n";
		}
	}
?>