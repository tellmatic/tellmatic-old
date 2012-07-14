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

/**functions**/

function ___($s) {
	return _($s);
}

function date_convert_to_string($date) {
	//ersetzt leerzeichen etc, damit wir das datum in den dateinamen einbauen koennen...
	$date=str_replace(".","",$date);
	$date=str_replace("-","",$date);
	$date=str_replace(":","",$date);
	$date=str_replace("_","",$date);
	$date=str_replace(" ","",$date);
	return $date;
}


function mk_microtime($timestamp,$Y=0,$M=4,$D=6,$H=8,$I=10,$S=12) {
	$Year=substr($timestamp,$Y,4);
	$Month=substr($timestamp,$M,2);
	$Day=substr($timestamp,$D,2);
	$Hour=substr($timestamp,$H,2);
	$Minute=substr($timestamp,$I,2);
	$Second=substr($timestamp,$S,2);
	//echo "$Hour,$Minute,$Second,$Month,$Day,$Year   ";
   return mktime($Hour,$Minute,$Second,$Month,$Day,$Year);
}

function sort_array($ARR,$sf="",$sfs=0) {
//3 parameter, mdim-Array zb $ARR[$i]['name'], Sortierindex zB.'name', sfs=1 desc, =0 asc
	$fcc=count($ARR);
	if (empty($sf) || $fcc<1) {
		return $ARR;
	}
	foreach ($ARR as $field) {  
		$sort[]=$field[$sf];
	} 
	//sfs: sort file desc: 1, else asc: 0
	if ($sfs==1) {
		@array_multisort($sort, SORT_DESC, $ARR, SORT_DESC);
	} else {
		@array_multisort($sort, SORT_ASC, $ARR, SORT_ASC);
	}
	return $ARR;
}




function utrim($source){
 $temp = ltrim($source);
 $temp = rtrim($temp);
 $temp = trim($temp);

 return $temp;
}


function write_file($file_path,$file_name,$file_content="") {
	$fp = fopen($file_path."/".$file_name,"w");  
	if (!$fp) {  
			return false; 
	} else {  
		fputs($fp,$file_content,strlen($file_content));  
	} 
	fclose($fp);  
	chmod ($file_path."/".$file_name, 0664);
}	


function update_file($file_path,$file_name,$file_content="") {
	$fp = fopen($file_path."/".$file_name,"a");  
	if (!$fp) {  
			return false; 
	} else {  
		fputs($fp,$file_content,strlen($file_content));  
	} 
	fclose($fp);  
	chmod ($file_path."/".$file_name, 0664);
}	


function getVar($Var,$slashes=1,$default="") {
    //this function gets variables from post or get, post has higher priority!
    global $_GET,$_POST;
    if (isset($_POST[$Var]) && !is_array($_POST[$Var])) {
      	//$Return = (get_magic_quotes_gpc()) ? $_POST[$Var] : addslashes($_POST[$Var]);
	     $Return = $_POST[$Var];
    } else {
        if (isset($_GET[$Var])) { //&& !is_array($_POST[$Var])
	   		//$Return = (get_magic_quotes_gpc()) ? $_GET[$Var] : addslashes($_GET[$Var]);
			$Return = $_GET[$Var];
        } else {
			$Return=$default;
		}
    }
    if ($slashes==1)   {
		$Return = addslashes($Return);
	}
	return $Return;
}//getVar()



//Liste von e-Mails checken
function checkEmailList($eMailList,$debug=0) {
	if (!empty($eMailList)) {
		$Return=true;
		//zerlege string fwd in bestandteile durch komma getrennt
		$eMailListArray=explode(",",$eMailList);
		$Count=count($eMailListArray);
		$Message="";
		$Message.="<br>Pruefe Adressen: ($Count)<br>";

		for ($Counter=0;$Counter<$Count;$Counter++) {
			//pruefe einzelne adresse
			$Message.=$Counter.".:".$eMailListArray[$Counter];
			//wird einmal falsches ergebnis ausgegeben, false setzen
			if (!checkemailadr($eMailListArray[$Counter])) {
				$Return=false;
				$Message.="...........<b>Fehler</b>";
			} else {
				$Message.="...........OK";
			}
			$Message.="<br>";
		}
		if ($debug==1) {
			echo $Message;
		}
	} else {
		//wenn leer ok
		$Return=true;
	}//!empty
	return $Return;	
}

function m_obstart() {
$encode = getenv("http_ACCEPT_ENCODING");
if(ereg("gzip",$encode)) {
	//ob_start("ob_gzhandler");
	ob_start("zlib.output_handler");
	} else {
		ob_start();
	}
} 

function makeRandomPassword($length) {
  $salt = "abchefghjkmnpqrstuvwxyz0123456789-/_";
  srand((double)microtime()*1000000); 
  	$i = 0;
  	$pass="";
  	while ($i <= $length) {
    		$num = rand() % 33;
    		$tmp = substr($salt, $num, 1);
    		$pass = $pass . $tmp;
    		$i++;
  	}
  	return $pass;
}


//pruefen auf gueltiges flag 1 oder 0 fuer db
function check_flag($value) {
	$return=false;
	if (isset($value) && is_numeric($value)) {
		$value=intval($value);
		if (($value==0 || $value==1) ) {
			$return=true;
		}
	}
	return $return;
}

//pruefen auf gueltige dbid, >0, numerisch und nicht "" etc.
function check_dbid($value) {
	$return=false;
	if (isset($value) && is_numeric($value)) {
		if (($value>=0) && $value!="") {
			$return=true;
//			$return=$value;
		}
	}
	return $return;
}

function checkset_int($int,$default=0) {
	if (!isset($int) || empty($int) || $int=='') {
		return $default;
	} else {
		return $int;
	}
}

function unify_array($words) {
		$wcount=count($words); 
		$wcc=0; 
		$W=Array();; 
		for ($wc=0;$wc<$wcount;$wc++) { 
			$found=0; 
			for ($wcc_=0;$wcc_<$wcc;$wcc_++) { 
				if ($W[$wcc_]!=$words[$wc]) { 
					if ($found!=1) {$found=0;} 
				} else { 
					$found=1; 
				} 
			} 
			if ($found==0) { 
				$W[$wcc]=$words[$wc]; 
				$wcc++; 
			} 
		} 
		return $W;
}


function is_in($search, $array) {
   $found = false;
   foreach ($array as $element) {
       if (strtolower($search) == strtolower($element)) {$found = true;}
   }
   return $found;   
}


function checkid($id) {
	if (!empty($id) && is_numeric($id)) { // &&$id>0
		return TRUE;
	} else {
		return FALSE;
	}

}


//2003-10-23
function pt_register()
{
    $num_args = func_num_args();
    $vars = array();
    if ($num_args >= 2) {
        $method = strtoupper(func_get_arg(0));
        if (($method != 'SESSION') && ($method != 'GET') && ($method != 'POST') && ($method != 'SERVER') && ($method != 'COOKIE') && ($method != 'ENV')) {
            die('The first argument of pt_register must be one of the following: GET, POST, SESSION, SERVER, COOKIE, or ENV');
        }
//        $varname = "HTTP_{$method}_VARS";
			//30012007:
			$varname = '_'.$method;
        global ${$varname};
        for ($i = 1; $i < $num_args; $i++) {
            $parameter = func_get_arg($i);
            if (isset(${$varname}[$parameter])) {
                global $$parameter;
                //${$varname}[$parameter] = (get_magic_quotes_gpc()) ? ${$varname}[$parameter] : addslashes(${$varname}[$parameter]);
				$$parameter = ${$varname}[$parameter];
            }
        }
    } else {
        die('You must specify at least two arguments');
    }
}
// register a GET var
//pt_register('GET', 'user_id', 'password');
// register a server var
//pt_register('SERVER', 'PHP_SELF');
// register some POST vars
//pt_register('POST', 'submit', 'field1', 'field2', 'field3');



function hexColor($color) {
  $HEX=dechex(($color[0]<<16)|($color[1]<<8)|$color[2]);

  if (strlen($HEX) < 6) {
  	$hlen=(6-strlen($HEX));
  	for ($h=0;$h<$hlen;$h++) {
  		$HEX .="0";
  	}
  }

  return $HEX;
}


//2003-08-13
function clear_text($x) {
	$x=strip_htmltags($x);
	$x=strip_tags($x);
	$x=strip_specialchar($x);
	$x=trim($x);
	return $x;
}

//2003-07-14
function strip_htmltags($html) { 
   $pos1 = false; 
   $pos2 = false; 
   do { 
       if ($pos1 !== false && $pos2 !== false) { 
           $first = NULL; 
           $second = NULL; 
           if ($pos1 > 0) 
                $first = substr($html, 0, $pos1); 
           if ($pos2 < strlen($html) - 1) 
               $second = substr($html, $pos2); 
          $html = $first . $second; 
       } 
      preg_match("/<script[^>]*>/i", $html, $matches); 
      $str1 =& $matches[0]; 
      preg_match("/<\/script>/i", $html, $matches); 
      $str2 =& $matches[0]; 
      $pos1 = strpos($html, $str1); 
     $pos2 = strpos($html, $str2); 
      if ($pos2 !== false) 
          $pos2 += strlen($str2); 
   } while ($pos1 !== false && $pos2 !== false); 
   return $html; 
}




function SendMail($From,$FromName,$To,$ToName,$Subject,$Text,$Html,$AttmFiles){
	global $use_SMTPmail;
	$return=false;

	//Name darf nicht = email sein und auch kein komma enthalten, plaintext!
	$ToName=str_replace($To,"",$ToName);
	$ToName=clear_text($ToName);
	$ToName=str_replace(",","",$ToName);

/*
if (empty($Text))
{
	$Text=strip_htmltags($Html);
	$Text=strip_tags($Text);
}
*/
	if ($use_SMTPmail) {
	 	if (SendMail_smtp($From,$FromName,$To,$ToName,$Subject,$Text,$Html,$AttmFiles)) {
	 		$return=true;
	 	}
	 } else {
	 	if (SendMail_mail($From,$FromName,$To,$ToName,$Subject,$Text,$Html,$AttmFiles)) {
	 		$return=true;
	 	}
 	}
 	return $return;
}


function SendMail_smtp($From,$FromName,$To,$ToName,$Subject,$Text,$Html,$AttmFiles) {
	global $AbsPath;
	
	global $SMTPHost;
	global $SMTPUser;
	global $SMTPPasswd;
	global $SMTPPopB4SMTP;
	global $SMTPDomain;
	global $ApplicationText;
	$return=false;
	
	
	//using http://www.phpclasses.org/trackback/browse/package/9.html http://www.phpclasses.org/browse/package/14.html http://www.phpclasses.org/trackback/browse/package/14.html
	//Class: MIME E-mail message composing and sending
	//thx to Manuel Lemos <mlemos at acm dot org>
	//look at: http://freshmeat.net/projects/mimemessageclass/
	//i believe its great work done!!! :)
	//i put all classes togehter in one big file ,-) to include in the cms
	require_once("Class_SMTP.inc");

	$from_name=$FromName;
	$from_address=$From;
	$reply_name=$from_name;
	$reply_address=$from_address;
	$reply_address=$from_address;
	$error_delivery_name=$from_name;
	$error_delivery_address=$from_address;
	$to_name=$ToName;
	$to_address=$To;
	$subject=$Subject;
	$message=$Html;
	$email_message=new smtp_message_class;
	$email_message->authentication_mechanism="LOGIN";
	/* This computer address */
	$email_message->localhost=$SMTPDomain;

	/* SMTP server address, probably your ISP address */
	$email_message->smtp_host=$SMTPHost;

	/* authentication user name */
	$email_message->smtp_user=$SMTPUser;

	/* authentication realm or Windows domain when using NTLM authentication */
	$email_message->smtp_realm="";

	/* authentication workstation name when using NTLM authentication */
	$email_message->smtp_workstation="";

	/* authentication password */
	$email_message->smtp_password=$SMTPPasswd;

	/* if you need POP3 authetntication before SMTP delivery,
	 * specify the host name here. The smtp_user and smtp_password above
	 * should set to the POP3 user and password*/
	 
	$email_message->smtp_pop3_auth_host="";
	if ($SMTPPopB4SMTP==1)
	{
		$email_message->smtp_pop3_auth_host=$SMTPHost;
	}

	/* Output dialog with SMTP server */
	$email_message->smtp_debug=0;

	/* if smtp_debug is 1,
	 * set this to 1 to make the debug output appear in HTML */
	$email_message->mailer=$ApplicationText." using smtp";
	$email_message->smtp_html_debug=1;

	$email_message->SetEncodedEmailHeader("To",$to_address,$to_name);
	$email_message->SetEncodedEmailHeader("From",$from_address,$from_name);
	$email_message->SetEncodedEmailHeader("Reply-To",$reply_address,$reply_name);
	$email_message->SetHeader("Return-Path",$error_delivery_address);
	$email_message->SetEncodedEmailHeader("Errors-To",$error_delivery_address,$error_delivery_name);
	$email_message->SetEncodedHeader("Subject",$subject);
	$email_message->AddQuotedPrintableHtmlPart($message);
	//$email_message->WrapText($message)
	$email_message->AddQuotedPrintableTextPart($Text);
	//$email_message->WrapText($Text)

//attachements
//filenames stored in Array $AttmFiles
	
if($AttmFiles){
 foreach($AttmFiles as $AttmFile){

	$attachment=array(
		"FileName"=>$AbsPath."/".$AttmFile,
		"Content-Type"=>"automatic/name",
		"Disposition"=>"attachment"
	);
	$email_message->AddFilePart($attachment);
	}//for each
}//ifAttmFiles



	$error=$email_message->Send();
	for($recipient=0,Reset($email_message->invalid_recipients);$recipient<count($email_message->invalid_recipients);Next($email_message->invalid_recipients),$recipient++)
		echo "Invalid recipient: ",Key($email_message->invalid_recipients)," Error: ",$email_message->invalid_recipients[Key($email_message->invalid_recipients)],"\n";
	if(strcmp($error,"")) {
		echo "\n&nbsp;&nbsp; <b>Error <font color=\"#ff0000\">$error</font></b>\n";
	}
	
	if (empty($error)) {
		$return=true;
	}		
//	echo "....Done.\n  ";
	
	return $return;
}


function SendMail_mail($From,$FromName,$To,$ToName,$Subject,$Text,$Html,$AttmFiles){
	global 	$ApplicationText;
	/*
	$From      ... sender mail address like "my@address.com"
	$FromName  ... sender name like "My Name"
	$To        ... recipient mail address like "your@address.com"
	$ToName    ... recipients name like "Your Name"
	$Subject   ... subject of the mail like "This is my first testmail"
	$Text      ... text version of the mail
	$Html      ... html version of the mail
	$AttmFiles ... array containing the filenames to attach like array("file1","file2")

	$TEXT="This is the first test\n in text format\n.";
	$HTML="<font color=red>This is the first test in html format.</font>";
	$ATTM=array("/home/myself/test/go.jpg",
						"/home/myself/test/SomeDoc.pdf");

	SendMail(
	"my@address.com","PHP Apache Webmailer", //sender
	"your@address.com","Recipients Name",    //recipient
	"Testmail",                               //subject
	$TEXT,$HTML,$ATTM);                      //body and attachment(s)
	*/

//Name darf nicht = email sein und auch kein komma enthalten, plaintext!
	$ToName=str_replace($To,"",$ToName);
	$ToName=clear_text($ToName);
	$ToName=str_replace(",","",$ToName);
	
	$OB="----=_OuterBoundary_000".md5(rand());
	$IB="----=_InnerBoundery_001".md5(rand());

	//$Html=$Html?$Html:preg_replace("/\n/","<br>",$Text);
	// or die("neither text nor html part present.");
	//$Text=$Text?$Text:"Diese Mail ist nur im HTML-Format verfuegbar, bitte aktivieren Sie die HTML-Ansicht oder benutzen Sie ein HTML-faehiges Mailprogramm.\n\r
	//This mail uses HTML, please activate HTML in your Mail-Client";

	$headers  = "MIME-Version: 1.0\r\n";
	$headers .="Return-Path: <".$From.">\r\n";
	$headers .= "From: ".$FromName." <".$From.">\r\n";
	$headers .="To: ".$ToName." <".$To.">\r\n";
	//$headers .="To: <".$To.">\r\n";
	// <".$To.">\n";
//	$headers .="Bcc: mcms@multiartstudio.com\r\n"; 
	$headers .="Reply-To: ".$FromName." <".$From.">\r\n"; 
//	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";// war zweimal definiert, muss aber multipart/mixed sein
	$headers .= "X-Mailer: ".$ApplicationText."\r\n";
//	$headers .="Content-Type: multipart/mixed;\n\tboundary=\"".$OB."\"\r\n";
	$headers .="Content-Type: multipart/mixed;\n\t";
	$headers.="boundary=\"".$OB."\"\r\n";

	//Messages start with text/html alternatives in OB
	$Msg ="This is a multi-part message in MIME format.\n";
	$Msg.="\n--".$OB."\n";
	$Msg.="Content-Type: multipart/alternative;\n\tboundary=\"".$IB."\"\n\n";

	//plaintext section 
	$Msg.="\n--".$IB."\n";
	$Msg.="Content-Type: text/plain;\n\tcharset=\"iso-8859-1\"\n";
	$Msg.="Content-Transfer-Encoding: quoted-printable\n\n";
	// plaintext goes here
	$Msg.=$Text."\n\n";
	// html section 
	$Msg.="\n--".$IB."\n";
	$Msg.="Content-Type: text/html;\n\tcharset=\"iso-8859-1\"\n";
	$Msg.="Content-Transfer-Encoding: base64\n\n";
	// html goes here 
	$Msg.=chunk_split(base64_encode($Html))."\n\n";

	// end of IB
	$Msg.="\n--".$IB."--\n";

	// attachments
	if($AttmFiles){
	 foreach($AttmFiles as $AttmFile){
		$patharray = explode ("/", $AttmFile); 
		$FileName=$patharray[count($patharray)-1];
		$Msg.= "\n--".$OB."\n";
		$Msg.="Content-Type: application/octetstream;\n\tname=\"".$FileName."\"\n";
		$Msg.="Content-Transfer-Encoding: base64\n";
		$Msg.="Content-Disposition: attachment;\n\tfilename=\"".$FileName."\"\n\n";

	 //file goes here
		$fd=fopen ($AttmFile, "r");
		$FileContent=fread($fd,filesize($AttmFile));
		fclose ($fd);
		$FileContent=chunk_split(base64_encode($FileContent));
		$Msg.=$FileContent;
		$Msg.="\n\n";
	 }
	}

//message ends
	$Msg.="\n--".$OB."--\n";
	 ini_set('sendmail_from', $From);
	if (mail($To,$Subject,$Msg,$headers)) { 
		//send syslog message
		syslog(LOG_INFO,"mCMS: Mail sent from $From  to $ToName <$To> ");
		ini_restore('sendmail_from');	
		return true;
	} else {
		ini_restore('sendmail_from');
		return false;
	}
}
//SendMail END


function strip_specialchar($x) {
	$x=trim($x);
	//$x=str_replace ( ".", "", $x); 
	$x=str_replace ( "\\", "", $x); 
	//$x=str_replace ( "+", "", $x); 
	$x=str_replace ( "*", "", $x); 
//	$x=str_replace ( "?", "", $x); 
//	$x=str_replace ( "[", "", $x); 
	$x=str_replace ( "^", "", $x); 
//	$x=str_replace ( "]", "", $x); 
	$x=str_replace ( "$", "", $x); 
//	$x=str_replace ( "(", "", $x); 
//	$x=str_replace ( ")", "", $x); 
//	$x=str_replace ( "{", "", $x); 
//	$x=str_replace ( "}", "", $x); 
//	$x=str_replace ( "=", "", $x); 
	$x=str_replace ( "!", "", $x); 
	//$x=str_replace ( "<", "", $x); 
	//$x=str_replace ( ">", "", $x); 
	$x=str_replace ( "|", "", $x); 
	//$x=str_replace ( ":", "", $x); 
//	$x=str_replace ( "&", "", $x); 
	$x=str_replace ( "\"", "", $x); 
	$x=str_replace ( "%", "", $x); 
	//$x=str_replace ( "=", "", $x); 
	//$x=str_replace ( "/", "", $x); 
	$x=str_replace ( "'", "", $x); 
	$x=str_replace ( "´", "", $x); 
	$x=str_replace ( "`", "", $x); 
	$x=str_replace ( "~", "", $x); 
	return $x;
}


function make_seed() {
    list($usec, $sec) = explode(' ', microtime());
    return (float) $sec + ((float) $usec * 100000);
}




 
 
function configure_me() { 
	return true; 
} 
 
 




function checkemailadr($email,$level=2) {  
	$Return=true;//ok, weil mit level=0 oder >3 pruefung ausgeschaltet werden kann.....
	//default level ist 2, mx dns und sytax!
	
	if ($level>=1) {
		//syntax
		//$regex="([-!#\$%&'*+./0-9=?A-Z^_`a-z{|}~])+@([-!#\$%&'*+/0-9=?A-Z^_`a-z{|}~]+\\.)+[a-zA-Z]{2,6}";
		// ^^^^^^^^^ findet auch adresen innerhalb des textes!
		
		$regex="^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-z]{2,4}$";
		//if(ereg ("<($regex)>", $email, $email_V))
		//if (eregi("^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-z]{2,4}$", $email, $check)) {  
		if (eregi("$regex", $email, $check)) {  
			$Return=true;
		} else {
			$Return=false;
			return $Return;//und weg
		}
	}
	
	if ($level>=2) {
		//split array
		list($userName, $mailDomain) = split("@", $email);
		//mx
		$mx=getmxrr($mailDomain,$mxhosts);//print_r($mxhosts);
		if($mx==1) {  
		//if(getmxrr(substr(strstr($check[0], '@'), 1), $validate_email_temp)) {  
			$Return=true;
		} else {
			$Return=false;
			return $Return;
		}
		//dns
		$dns=checkdnsrr($mailDomain, "MX");
		//checkdnsrr(substr(strstr($check[0], '@'), 1),"ANY")
		if ($dns==1) {
			$Return=true;
		} else {
			$Return=false;
			return $Return;
		}
	}
		
	//validate()
	//fragt mx ab, wenn domain aber noch kein dns eintrag hat, weil gerade erzeugt......schlaegt der check fehl.... 
	if ($level==3) {
		$validate=validate_email($email);
		$Return=$validate[0];
	}
	return $Return;
}   

function validate_email($email) {
	global $HTTP_HOST, $SMTPDomain;
	$Return=Array(0=>true, 1=>"OK");
	list($userName, $mailDomain) = split("@", $email);
	$mx=getmxrr($mailDomain,$mxhosts);
	//mxhosts=array()
	//print_r($mxhosts);
	$hc=count($mxhosts);
	if ($hc>0) {
		//wir preuefen nur m al den ersten mx
		$host=$mxhosts[0];
		$Connect = fsockopen ( $host, 25 );
		if ($Connect) {
	        //aol hack
	        /*
	        do {
					 $Out = fgets ( $Connect, 1024 ); 
				} while (ereg("^220",$Out));
	        */
	        if (ereg("^220", $Out = fgets($Connect, 1024))) {
	        //aol: if (ereg("^220", $Out)) {
  	           //echo "<br>".$Out."<br>";
	           fputs ($Connect, "HELO ".$SMTPDomain."\r\n");
	           $Out = fgets ( $Connect, 1024 );
  	           //echo "<br>".$Out."<br>";
	           fputs ($Connect, "MAIL FROM: <{$email}>\r\n");
	           $From = fgets ( $Connect, 1024 );
	           fputs ($Connect, "RCPT TO: <{$email}>\r\n");
	           $To = fgets ($Connect, 1024);
	           //echo "<br>".$To."<br>";
	           //echo "<br>".$From."<br>";
	           fputs ($Connect, "QUIT\r\n");
	           fclose($Connect);
	           if (!ereg ("^250", $From) || !ereg ( "^250", $To )) {
	               $Return[0]=false;
	               $Return[1]="Server rejected address";
						return $Return;
	           }
	        } else {
	            $Return[0] = false;
	            $Return[1] = "No response from server";
	            return $Return;
           }
	   }  else {
	       $Return[0]=false;
	       $Return[1]="Can not connect E-Mail server.";
	       return $Return;
	   } 
	} else {
		//kein mx host gefunden $hc=0
	        $Return[0]=false;
	        $Return[1]="Can not find MXHosts.";
	        return $Return;
	}
	return $Return;
}





function checkinput($input) {  
	if (eregi("^[0-9a-z]", $input, $check)) {  
		return true;  
	}  else {
		return false;
	}
}

  
 
function get_file_ext( $filename ) { 
	ereg( ".*\.([a-zA-z0-9]{0,5})$", $filename, $regs ); 
	return( $regs[1] ); 
} 
 
function unhtmlentities ($string) 
{ 
	$trans_tbl = get_html_translation_table (HTML_ENTITIES); 
	$trans_tbl = array_flip ($trans_tbl); 
	return strtr ($string, $trans_tbl); 
} 

/* function gen_rec_files_array ($path,$selected="",$recpath="",$extension="",$addcompletepath=0)
// erzeugt array mit einer liste der datein im angegebenen verzeichnis mit unterverzeichnissen
// * path: ist der gewuenschte pfad ab dem  angezeigt werden soll
// * selected: enthaelt den ausgewaehlten wert
// * extension: filter , z.Bsp.. 'jpg' etc...
// * addcomletepath: wenn 1,  fuegt den absoluten Pfad hinzu
// * recpath: recursive hilfsvariable : intern fuer recursives durchsuchen
// Verwendung z.Bsp edit_ConfigLayout, edit_Gallery_Image_Item.inc etc. und ueberall dort wo Dateien innerhalb eines Pfades als Selectfeld auszuwaehlen sind
*/
function gen_rec_files_array ($path,$selected="",$recpath="",$extension="",$addcompletepath=0) { 
	global $Domain,$StdDir,$nowDir,$includefile,$upl,$PHP_SELF,$dir2;
	global $FileARRAY;
//	$ac=count($FileARRAY);
	if (is_dir($path)) { 
		chdir($path); 
		$handle=opendir('.');
		$ac=0;//voa 17072005
		while (($file = readdir($handle))!==false) { 
			$rec=""; 
			if (($file != ".") && ($file != "..")) { 
				if (is_file($file) or is_dir($file)) { 
					if (!empty($recpath)) { 
						$rec=$recpath; 
					} 
					$rec.="/".$file;					 
					if (is_file($file)) {
						if (!empty($extension) && $extension!='') {
							if (preg_match ("/".$extension."/i", $rec)) { 
								if ($addcompletepath==1) {
									//$FileARRAY[$ac]['filename']=$path."/".$recpath."/".$rec;
									$FileARRAY[]['filename']=$path."/".$recpath."/".$rec;

								} else {

									//$FileARRAY[$ac]['filename']=$rec;
									$FileARRAY[]['filename']=$rec;

								}
							}
						} else {
							if ($addcompletepath==1) {
									//$FileARRAY[$ac]['filename']=$path."/".$recpath."/".$rec;
									$FileARRAY[]['filename']=$path."/".$recpath."/".$rec;
									
							} else {
									//$FileARRAY[$ac]['filename']=$rec;
									$FileARRAY[]['filename']=$rec;

							}
						}
					}
					$ac++;
					gen_rec_files_array ($path."/".$file,$selected,$rec,$extension,$addcompletepath);					
					chdir($path);
				}
			}
		}
		@closedir($handle);
	}
}

?>
