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

//ERRORHANDLING
// we will do our own error handling

error_reporting(1);
ini_set('display_errors', 1);
error_reporting(E_ALL);

function userErrorHandler ($errno, $errmsg, $filename, $linenum, $vars) {
	global $tm_logpath,$_ERROR;
	if (!isset($_ERROR)) {
		$_ERROR=Array();
		$_ERROR['text']="";
		$_ERROR['html']="";
	}
    $err_date = date("Y-m-d H:i:s (T)");
    /*

		value	 constant
		1	E_ERROR
		2	E_WARNING
		4	E_PARSE
		8	E_NOTICE
		16	E_CORE_ERROR
		32	E_CORE_WARNING
		64	E_COMPILE_ERROR
		128	E_COMPILE_WARNING
		256	E_USER_ERROR
		512	E_USER_WARNING
		1024	E_USER_NOTICE
		6143	E_ALL
		2048	E_STRICT
		4096	E_RECOVERABLE_ERROR

    */

    $errortype = array (
                1   =>  "Error",
                2   =>  "Warning",
                4   =>  "Parsing Error",
                8   =>  "Notice",
                16  =>  "Core Error",
                32  =>  "Core Warning",
                64  =>  "Compile Error",
                128 =>  "Compile Warning",
                256 =>  "User Error",
                512 =>  "User Warning",
                1024=>  "User Notice"
                );
   $user_errors = array( E_ALL, E_USER_NOTICE, E_ERROR,  E_PARSE, E_USER_ERROR, E_USER_WARNING, E_NOTICE);//E_WARNING,
   $err="";
   $err_html="";
    if (in_array($errno, $user_errors)) {
	    $err .= "PHP Error: ";
	    $err .= "date: ".$err_date." |;| ";
		$err .= "error no:".$errno." |;| ";
		$err .= "error type".$errortype[$errno]." |;| ";
		$err .= "php_error: ".$errmsg." |;| ";
		$err .= "file:".$filename." |;| ";
		$err .= "line ".$linenum." |;| ";
		$err .="\n";
		$_ERROR['text'].=$err;

	  $err_html .= "\n<br><font size=-1 color=red><b>PHP Error!</b>";
	  $err_html .= "\n<br>date: ".$err_date."";
		$err_html .= "\n<br>error no:".$errno."";
		$err_html .= "\n<br>error type".$errortype[$errno]."";
		$err_html .= "\n<br>php_error: ".$errmsg."";
		$err_html .= "\n<br>file:".$filename."";
		$err_html .= "\n<br>line ".$linenum."";
		$err_html .="</font><br>\n";
		$_ERROR['html'].=$err_html;
     }
	//Error in Datei loggen
	error_log($_ERROR['text'], 3, $tm_logpath."/tellmatic_php_error.log");
}
?>