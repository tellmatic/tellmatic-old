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

//using http://www.phpclasses.org/trackback/browse/package/9.html http://www.phpclasses.org/browse/package/14.html http://www.phpclasses.org/trackback/browse/package/14.html
//Class: MIME E-mail message composing and sending
//thx to Manuel Lemos <mlemos at acm dot org>
//look at: http://freshmeat.net/projects/mimemessageclass/
//i believe its great work done!!! :)
//i put all classes togehter in one big file ,-) to include in the cms
//BSD License http://www.opensource.org/licenses/bsd-license.html

/*
 * cram_md5_sasl_client.php
 *
 * @(#) $Id: Class_SMTP.inc.php,v 1.1.1.1 2007/11/21 22:58:32 mcms09 Exp $
 *
 */

define("SASL_CRAM_MD5_STATE_START",             0);
define("SASL_CRAM_MD5_STATE_RESPOND_CHALLENGE", 1);
define("SASL_CRAM_MD5_STATE_DONE",              2);

class cram_md5_sasl_client_class
{
	var $credentials=array();
	var $state=SASL_CRAM_MD5_STATE_START;

	Function Initialize(&$client)
	{
		return(1);
	}

	Function HMACMD5($key,$text)
	{
		$key=(strlen($key)<64 ? str_pad($key,64,"\0") : substr($key,0,64));
		return(md5((str_repeat("\x5c", 64)^$key).pack("H32", md5((str_repeat("\x36", 64)^$key).$text))));
	}

	Function Start(&$client, &$message, &$interactions)
	{
		if($this->state!=SASL_CRAM_MD5_STATE_START)
		{
			$client->error="CRAM-MD5 authentication state is not at the start";
			return(SASL_FAIL);
		}
		$this->credentials=array(
			"user"=>"",
			"password"=>""
		);
		$defaults=array();
		$status=$client->GetCredentials($this->credentials,$defaults,$interactions);
		if($status==SASL_CONTINUE)
			$this->state=SASL_CRAM_MD5_STATE_RESPOND_CHALLENGE;
		Unset($message);
		return($status);
	}

	Function Step(&$client, $response, &$message, &$interactions)
	{
		switch($this->state)
		{
			case SASL_CRAM_MD5_STATE_RESPOND_CHALLENGE:
				$message=$this->credentials["user"]." ".$this->HMACMD5($this->credentials["password"], $response);
				$this->state=SASL_CRAM_MD5_STATE_DONE;
				break;
			case SASL_CRAM_MD5_STATE_DONE:
				$client->error="CRAM-MD5 authentication was finished without success";
				return(SASL_FAIL);
			default:
				$client->error="invalid CRAM-MD5 authentication step state";
				return(SASL_FAIL);
		}
		return(SASL_CONTINUE);
	}
};












/*
* ntlm_sasl_client.php
*
* @(#) $Id: Class_SMTP.inc.php,v 1.1.1.1 2007/11/21 22:58:32 mcms09 Exp $
*
*/

define("SASL_NTLM_STATE_START",             0);
define("SASL_NTLM_STATE_IDENTIFY_DOMAIN",   1);
define("SASL_NTLM_STATE_RESPOND_CHALLENGE", 2);
define("SASL_NTLM_STATE_DONE",              3);

class ntlm_sasl_client_class
{
    var $credentials=array();
    var $state=SASL_NTLM_STATE_START;

    Function Initialize(&$client)
    {
        if(!function_exists($function="mcrypt_encrypt")
        || !function_exists($function="mhash"))
        {
            $extensions=array(
                "mcrypt_encrypt"=>"mcrypt",
                "mhash"=>"mhash"
            );
            $client->error="the extension ".$extensions[$function]." required by the NTLM SASL client class is not available in this PHP configuration";
            return(0);
        }
        return(1);
    }

    Function ASCIIToUnicode($ascii)
    {
        for($unicode="",$a=0;$a<strlen($ascii);$a++)
            $unicode.=substr($ascii,$a,1).chr(0);
        return($unicode);
    }

    Function TypeMsg1($domain,$workstation)
    {
        $domain_length=strlen($domain);
        $workstation_length=strlen($workstation);
        $workstation_offset=32;
        $domain_offset=$workstation_offset+$workstation_length;
        return(
            "NTLMSSP\0".
            "\x01\x00\x00\x00".
            "\x07\x32\x00\x00".
            pack("v",$domain_length).
            pack("v",$domain_length).
            pack("V",$domain_offset).
            pack("v",$workstation_length).
            pack("v",$workstation_length).
            pack("V",$workstation_offset).
            $workstation.
            $domain
        );
    }

    Function NTLMResponse($challenge,$password)
    {
        $unicode=$this->ASCIIToUnicode($password);
        $md4=mhash(MHASH_MD4,$unicode);
        $padded=$md4.str_repeat(chr(0),21-strlen($md4));
        $iv_size=mcrypt_get_iv_size(MCRYPT_DES,MCRYPT_MODE_ECB);
        $iv=mcrypt_create_iv($iv_size,MCRYPT_RAND);
        for($response="",$third=0;$third<21;$third+=7)
        {
            for($packed="",$p=$third;$p<$third+7;$p++)
                $packed.=str_pad(decbin(ord(substr($padded,$p,1))),8,"0",STR_PAD_LEFT);
            for($key="",$p=0;$p<strlen($packed);$p+=7)
            {
                $s=substr($packed,$p,7);
                $b=$s.((substr_count($s,"1") % 2) ? "0" : "1");
                $key.=chr(bindec($b));
            }
            $ciphertext=mcrypt_encrypt(MCRYPT_DES,$key,$challenge,MCRYPT_MODE_ECB,$iv);
            $response.=$ciphertext;
        }
        return $response;
    }

    Function TypeMsg3($ntlm_response,$user,$domain,$workstation)
    {
        $domain_unicode=$this->ASCIIToUnicode($domain);
        $domain_length=strlen($domain_unicode);
        $domain_offset=64;
        $user_unicode=$this->ASCIIToUnicode($user);
        $user_length=strlen($user_unicode);
        $user_offset=$domain_offset+$domain_length;
        $workstation_unicode=$this->ASCIIToUnicode($workstation);
        $workstation_length=strlen($workstation_unicode);
        $workstation_offset=$user_offset+$user_length;
        $lm="";
        $lm_length=strlen($lm);
        $lm_offset=$workstation_offset+$workstation_length;
        $ntlm=$ntlm_response;
        $ntlm_length=strlen($ntlm);
        $ntlm_offset=$lm_offset+$lm_length;
        $session="";
        $session_length=strlen($session);
        $session_offset=$ntlm_offset+$ntlm_length;
        return(
            "NTLMSSP\0".
            "\x03\x00\x00\x00".
            pack("v",$lm_length).
            pack("v",$lm_length).
            pack("V",$lm_offset).
            pack("v",$ntlm_length).
            pack("v",$ntlm_length).
            pack("V",$ntlm_offset).
            pack("v",$domain_length).
            pack("v",$domain_length).
            pack("V",$domain_offset).
            pack("v",$user_length).
            pack("v",$user_length).
            pack("V",$user_offset).
            pack("v",$workstation_length).
            pack("v",$workstation_length).
            pack("V",$workstation_offset).
            pack("v",$session_length).
            pack("v",$session_length).
            pack("V",$session_offset).
            "\x01\x02\x00\x00".
            $domain_unicode.
            $user_unicode.
            $workstation_unicode.
            $lm.
            $ntlm
        );
    }

    Function Start(&$client, &$message, &$interactions)
    {
        if($this->state!=SASL_NTLM_STATE_START)
        {
            $client->error="NTLM authentication state is not at the start";
            return(SASL_FAIL);
        }
        $this->credentials=array(
            "user"=>"",
            "password"=>"",
            "realm"=>"",
            "workstation"=>""
        );
        $defaults=array();
        $status=$client->GetCredentials($this->credentials,$defaults,$interactions);
        if($status==SASL_CONTINUE)
            $this->state=SASL_NTLM_STATE_IDENTIFY_DOMAIN;
        Unset($message);
        return($status);
    }

    Function Step(&$client, $response, &$message, &$interactions)
    {
        switch($this->state)
        {
            case SASL_NTLM_STATE_IDENTIFY_DOMAIN:
                $message=$this->TypeMsg1($this->credentials["realm"],$this->credentials["workstation"]);
                $this->state=SASL_NTLM_STATE_RESPOND_CHALLENGE;
                break;
            case SASL_NTLM_STATE_RESPOND_CHALLENGE:
                $ntlm_response=$this->NTLMResponse(substr($response,24,8),$this->credentials["password"]);
                $message=$this->TypeMsg3($ntlm_response,$this->credentials["user"],$this->credentials["realm"],$this->credentials["workstation"]);
                $this->state=SASL_NTLM_STATE_DONE;
                break;
            case SASL_NTLM_STATE_DONE:
                $client->error="NTLM authentication was finished without success";
                return(SASL_FAIL);
            default:
                $client->error="invalid NTLM authentication step state";
                return(SASL_FAIL);
        }
        return(SASL_CONTINUE);
    }
};


















/*
 * plain_sasl_client.php
 *
 * @(#) $Id: Class_SMTP.inc.php,v 1.1.1.1 2007/11/21 22:58:32 mcms09 Exp $
 *
 */

define("SASL_PLAIN_STATE_START",    0);
define("SASL_PLAIN_STATE_IDENTIFY", 1);
define("SASL_PLAIN_STATE_DONE",     2);

define("SASL_PLAIN_DEFAULT_MODE",            0);
define("SASL_PLAIN_EXIM_MODE",               1);
define("SASL_PLAIN_EXIM_DOCUMENTATION_MODE", 2);

class plain_sasl_client_class
{
	var $credentials=array();
	var $state=SASL_PLAIN_STATE_START;

	Function Initialize(&$client)
	{
		return(1);
	}

	Function Start(&$client, &$message, &$interactions)
	{
		if($this->state!=SASL_PLAIN_STATE_START)
		{
			$client->error="PLAIN authentication state is not at the start";
			return(SASL_FAIL);
		}
		$this->credentials=array(
			"user"=>"",
			"password"=>"",
			"realm"=>"",
			"mode"=>""
		);
		$defaults=array(
			"realm"=>"",
			"mode"=>""
		);
		$status=$client->GetCredentials($this->credentials,$defaults,$interactions);
		if($status==SASL_CONTINUE)
		{
			switch($this->credentials["mode"])
			{
				case SASL_PLAIN_EXIM_MODE:
					$message=$this->credentials["user"]."\0".$this->credentials["password"]."\0";
					break;
				case SASL_PLAIN_EXIM_DOCUMENTATION_MODE:
					$message="\0".$this->credentials["user"]."\0".$this->credentials["password"];
					break;
				default:
					$message=$this->credentials["user"]."\0".$this->credentials["user"].(strlen($this->credentials["realm"]) ? "@".$this->credentials["realm"] : "")."\0".$this->credentials["password"];
					break;
			}
			$this->state=SASL_PLAIN_STATE_DONE;
		}
		else
			Unset($message);
		return($status);
	}

	Function Step(&$client, $response, &$message, &$interactions)
	{
		switch($this->state)
		{
/*
			case SASL_PLAIN_STATE_IDENTIFY:
				switch($this->credentials["mode"])
				{
					case SASL_PLAIN_EXIM_MODE:
						$message=$this->credentials["user"]."\0".$this->credentials["password"]."\0";
						break;
					case SASL_PLAIN_EXIM_DOCUMENTATION_MODE:
						$message="\0".$this->credentials["user"]."\0".$this->credentials["password"];
						break;
					default:
						$message=$this->credentials["user"]."\0".$this->credentials["user"].(strlen($this->credentials["realm"]) ? "@".$this->credentials["realm"] : "")."\0".$this->credentials["password"];
						break;
				}
				var_dump($message);
				$this->state=SASL_PLAIN_STATE_DONE;
				break;
*/
			case SASL_PLAIN_STATE_DONE:
				$client->error="PLAIN authentication was finished without success";
				return(SASL_FAIL);
			default:
				$client->error="invalid PLAIN authentication step state";
				return(SASL_FAIL);
		}
		return(SASL_CONTINUE);
	}
};

























/*
 * login_sasl_client.php
 *
 * @(#) $Id: Class_SMTP.inc.php,v 1.1.1.1 2007/11/21 22:58:32 mcms09 Exp $
 *
 */

define("SASL_LOGIN_STATE_START",             0);
define("SASL_LOGIN_STATE_IDENTIFY_USER",     1);
define("SASL_LOGIN_STATE_IDENTIFY_PASSWORD", 2);
define("SASL_LOGIN_STATE_DONE",              3);

class login_sasl_client_class
{
	var $credentials=array();
	var $state=SASL_LOGIN_STATE_START;

	Function Initialize(&$client)
	{
		return(1);
	}

	Function Start(&$client, &$message, &$interactions)
	{
		if($this->state!=SASL_LOGIN_STATE_START)
		{
			$client->error="LOGIN authentication state is not at the start";
			return(SASL_FAIL);
		}
		$this->credentials=array(
			"user"=>"",
			"password"=>"",
			"realm"=>""
		);
		$defaults=array(
			"realm"=>""
		);
		$status=$client->GetCredentials($this->credentials,$defaults,$interactions);
		if($status==SASL_CONTINUE)
			$this->state=SASL_LOGIN_STATE_IDENTIFY_USER;
		Unset($message);
		return($status);
	}

	Function Step(&$client, $response, &$message, &$interactions)
	{
		switch($this->state)
		{
			case SASL_LOGIN_STATE_IDENTIFY_USER:
				$message=$this->credentials["user"].(strlen($this->credentials["realm"]) ? "@".$this->credentials["realm"] : "");
				$this->state=SASL_LOGIN_STATE_IDENTIFY_PASSWORD;
				break;
			case SASL_LOGIN_STATE_IDENTIFY_PASSWORD:
				$message=$this->credentials["password"];
				$this->state=SASL_LOGIN_STATE_DONE;
				break;
			case SASL_LOGIN_STATE_DONE:
				$client->error="LOGIN authentication was finished without success";
				break;
			default:
				$client->error="invalid LOGIN authentication step state";
				return(SASL_FAIL);
		}
		return(SASL_CONTINUE);
	}
};






































/*
 * sasl.php
 *
 * @(#) $Id: Class_SMTP.inc.php,v 1.1.1.1 2007/11/21 22:58:32 mcms09 Exp $
 *
 */

define("SASL_INTERACT", 2);
define("SASL_CONTINUE", 1);
define("SASL_OK",       0);
define("SASL_FAIL",    -1);
define("SASL_NOMECH",  -4);

class sasl_interact_class
{
	var $id;
	var $challenge;
	var $prompt;
	var $default_result;
	var $result;
};

/*
{metadocument}<?xml version="1.0" encoding="ISO-8859-1" ?>
<class>

	<package>net.manuellemos.sasl</package>

	<version>@(#) $Id: Class_SMTP.inc.php,v 1.1.1.1 2007/11/21 22:58:32 mcms09 Exp $</version>
	<copyright>Copyright © (C) Manuel Lemos 2004</copyright>
	<title>Simple Authentication and Security Layer client</title>
	<author>Manuel Lemos</author>
	<authoraddress>mlemos-at-acm.org</authoraddress>

	<documentation>
		<idiom>en</idiom>
		<purpose>Provide a common interface to plug-in driver classes that
			implement different mechanisms for authentication used by clients of
			standard protocols like SMTP, POP3, IMAP, HTTP, etc.. Currently the
			supported authentication mechanisms are: <tt>PLAIN</tt>,
			<tt>LOGIN</tt>, <tt>CRAM-MD5</tt> and <tt>NTML</tt> (Windows or
			Samba).</purpose>
		<usage>.</usage>
	</documentation>

{/metadocument}
*/

class sasl_client_class
{
	/* Public variables */

/*
{metadocument}
	<variable>
		<name>error</name>
		<type>STRING</type>
		<value></value>
		<documentation>
			<purpose>Store the message that is returned when an error
				occurs.</purpose>
			<usage>Check this variable to understand what happened when a call to
				any of the class functions has failed.<paragraphbreak />
				This class uses cumulative error handling. This means that if one
				class functions that may fail is called and this variable was
				already set to an error message due to a failure in a previous call
				to the same or other function, the function will also fail and does
				not do anything.<paragraphbreak />
				This allows programs using this class to safely call several
				functions that may fail and only check the failure condition after
				the last function call.<paragraphbreak />
				Just set this variable to an empty string to clear the error
				condition.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $error='';

/*
{metadocument}
	<variable>
		<name>mechanism</name>
		<type>STRING</type>
		<value></value>
		<documentation>
			<purpose>Store the name of the mechanism that was selected during the
				call to the <functionlink>Start</functionlink> function.</purpose>
			<usage>.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $mechanism;

	/* Private variables */

	var $driver;
	var $drivers=array(
		"CRAM-MD5" => array("cram_md5_sasl_client_class", "cram_md5_sasl_client.php" ),
		"LOGIN"    => array("login_sasl_client_class",    "login_sasl_client.php"    ),
		"NTLM"     => array("ntlm_sasl_client_class",     "ntlm_sasl_client.php"     ),
		"PLAIN"    => array("plain_sasl_client_class",    "plain_sasl_client.php"    ),
		"Basic"    => array("basic_sasl_client_class",    "basic_sasl_client.php"    )
	);
	var $credentials=array();

	/* Public functions */

/*
{metadocument}
	<function>
		<name>SetCredential</name>
		<type>VOID</type>
		<documentation>
			<purpose>Store the value of a credential that may be used by any of
			 the supported mechanisms to process the authentication messages and
			 responses.</purpose>
			<usage>.</usage>
			<returnvalue>.</returnvalue>
		</documentation>
		<argument>
			<name>key</name>
			<type>STRING</type>
			<documentation>
				<purpose>.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>value</name>
			<type>STRING</type>
			<documentation>
				<purpose>.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function SetCredential($key,$value)
	{
		$this->credentials[$key]=$value;
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

/*
{metadocument}
	<function>
		<name>GetCredentials</name>
		<type>INTEGER</type>
		<documentation>
			<purpose>Retrieve the values of one or more credentials to be used by
				the authentication mechanism classes.</purpose>
			<usage>.</usage>
			<returnvalue>.</returnvalue>
		</documentation>
		<argument>
			<name>credentials</name>
			<type>STRING</type>
			<documentation>
				<purpose>.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>defaults</name>
			<type>HASH</type>
			<documentation>
				<purpose>.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>interactions</name>
			<type>ARRAY</type>
			<documentation>
				<purpose>.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function GetCredentials(&$credentials,$defaults,&$interactions)
	{
		Reset($credentials);
		$end=(GetType($key=Key($credentials))!="string");
		for(;!$end;)
		{
			if(!IsSet($this->credentials[$key]))
			{
				if(IsSet($defaults[$key]))
					$credentials[$key]=$defaults[$key];
				else
				{
					$this->error="the requested credential ".$key." is not defined";
					return(SASL_NOMECH);
				}
			}
			else
				$credentials[$key]=$this->credentials[$key];
			Next($credentials);
			$end=(GetType($key=Key($credentials))!="string");
		}
		return(SASL_CONTINUE);
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

/*
{metadocument}
	<function>
		<name>Start</name>
		<type>INTEGER</type>
		<documentation>
			<purpose>Process the initial authentication step initializing the
				driver class that implements the first of the list of requested
				mechanisms that is supported by this SASL client library
				implementation.</purpose>
			<usage>.</usage>
			<returnvalue>.</returnvalue>
		</documentation>
		<argument>
			<name>mechanisms</name>
			<type>ARRAY</type>
			<documentation>
				<purpose>.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>message</name>
			<type>STRING</type>
			<documentation>
				<purpose>.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>interactions</name>
			<type>ARRAY</type>
			<documentation>
				<purpose>.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function Start($mechanisms, &$message, &$interactions)
	{
		if(strlen($this->error))
			return(SASL_FAIL);
		if(IsSet($this->driver))
			return($this->driver->Start($this,$message,$interactions));
		$no_mechanism_error="";
		for($m=0;$m<count($mechanisms);$m++)
		{
			$mechanism=$mechanisms[$m];
			if(IsSet($this->drivers[$mechanism]))
			{
				if(!class_exists($this->drivers[$mechanism][0]))
					require(dirname(__FILE__)."/".$this->drivers[$mechanism][1]);
				$this->driver=new $this->drivers[$mechanism][0];
				if($this->driver->Initialize($this))
				{
					$status=$this->driver->Start($this,$message,$interactions);
					switch($status)
					{
						case SASL_NOMECH:
							Unset($this->driver);
							if(strlen($no_mechanism_error)==0)
								$no_mechanism_error=$this->error;
							$this->error="";
							break;
						case SASL_CONTINUE:
							$this->mechanism=$mechanism;
							return($status);
						default:
							Unset($this->driver);
							$this->error="";
							return($status);
					}
				}
				else
				{
					Unset($this->driver);
					if(strlen($no_mechanism_error)==0)
						$no_mechanism_error=$this->error;
					$this->error="";
				}
			}
		}
		$this->error=(strlen($no_mechanism_error) ? $no_mechanism_error : "it was not requested any of the authentication mechanisms that are supported");
		return(SASL_NOMECH);
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

/*
{metadocument}
	<function>
		<name>Step</name>
		<type>INTEGER</type>
		<documentation>
			<purpose>Process the authentication steps after the initial until the
				authetication iteration dialog is complete.</purpose>
			<usage>.</usage>
			<returnvalue>.</returnvalue>
		</documentation>
		<argument>
			<name>response</name>
			<type>STRING</type>
			<documentation>
				<purpose>.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>message</name>
			<type>STRING</type>
			<documentation>
				<purpose>.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>interactions</name>
			<type>ARRAY</type>
			<documentation>
				<purpose>.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function Step($response, &$message, &$interactions)
	{
		if(strlen($this->error))
			return(SASL_FAIL);
		return($this->driver->Step($this,$response,$message,$interactions));
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

};

/*

{metadocument}
</class>
{/metadocument}

*/




























/*
 * email_message.php
 *
 * @(#) $Header: /cvsroot/tellmatic/tellmatic/include/Class_SMTP.inc.php,v 1.1.1.1 2007/11/21 22:58:32 mcms09 Exp $
 *
 *
 */

/*
{metadocument}<?xml version="1.0" encoding="ISO-8859-1"?>
<class>

	<package>net.manuellemos.mimemessage</package>

	<version>@(#) $Id: Class_SMTP.inc.php,v 1.1.1.1 2007/11/21 22:58:32 mcms09 Exp $</version>
	<copyright>Copyright © (C) Manuel Lemos 1999-2004</copyright>
	<title>MIME E-mail message composing and sending</title>
	<author>Manuel Lemos</author>
	<authoraddress>mlemos-at-acm.org</authoraddress>

	<documentation>
		<idiom>en</idiom>
		<purpose>Compose and send e-mail messages according to the MIME
			standards.</purpose>
		<translation>If you are interested in translating the documentation of
			this class to your own idiom, please <link>
				<data>contact the author</data>
				<url>mailto:<getclassproperty>authoraddress</getclassproperty></url>
			</link>.</translation>
		<support>Technical support for using this class may be obtained in the
			<tt>mimemessage-dev</tt> mailing list. Just go to the mailing list
			page to browse the list archives, learn how to to join and post
			support request messages:<paragraphbreak />
			<link>
				<data>http://groups-beta.google.com/group/mimemessage-dev</data>
				<url>http://groups-beta.google.com/group/mimemessage-dev</url>
			</link></support>
		<usage>To used this class just create a new object as follows, set any
			variables to configure its behavior and call the functions you need
			to compose and send your messages.<paragraphbreak />
			<tt>require('email_message.php');<br />
			<br />
			$message_object = new email_message_class;<br /></tt><paragraphbreak />
			<b>- Set the sender and recipients</b><paragraphbreak />
			You can set the message sender and one or more recipient addresses
			using the <functionlink>SetHeader</functionlink> or the
			<functionlink>SetEncodedEmailHeader</functionlink> functions
			specifying the addresses for the <tt>From</tt>, <tt>To</tt>,
			<tt>Cc</tt> and <tt>Bcc</tt> headers.<paragraphbreak />

			<b>- Formatting text messages</b><paragraphbreak />
			You can use the <functionlink>WrapText</functionlink> to assure that
			a text message does not have more than 75 columns by breaking the
			longer lines between words.<paragraphbreak />
			<paragraphbreak />
			If you are composing a reply to another text message, you can use the
			<functionlink>QuoteText</functionlink> function to conveniently mark
			the text quoted from the original message.<paragraphbreak />

			<b>- Add a plain text message body</b><paragraphbreak />
			If the text of the message that you want to send only contains ASCII
			characters (7 bits), use the
			<functionlink>AddPlainTextPart</functionlink> function to add the
			text to the message.<paragraphbreak />

			<b>- Add a text message with non-ASCII characters</b><paragraphbreak />
			If your message text may contains non-ASCII characters (8 bits or
			more), use the
			<functionlink>AddQuotedPrintableTextPart</functionlink> function
			to add the text to the message.<paragraphbreak />
			<paragraphbreak />
			If the text uses a character set other than
			<i>ISO-8859-1</i> (ISO Latin 1), set the
			<variablelink>default_charset</variablelink> variable to change the
			default character set.<paragraphbreak />

			<b>- Setting the error message bounce address</b><paragraphbreak />
			This class provides a means to specify the address where error
			messages should be bounced in case it is not possible to deliver a
			message. That can be done by setting the header <tt>Return-Path</tt>
			with the <functionlink>SetHeader</functionlink>
			function.<paragraphbreak />

			<b>- Request message receipt notification</b><paragraphbreak />
			If you would like to be receive an notification when a message that
			is sent is received, just use the
			<functionlink>SetHeader</functionlink> function with the
			<tt>Disposition-Notification-To</tt> header to specify the address to
			where you want to receive the notification message.<paragraphbreak />
			Keep in mind that this header just expresses that you want to get a
			receipt notification, but it may be denied or ignored by the
			recipient, which does not mean the message was not
			received.<paragraphbreak />

			<b>- Avoding temporary delivery failure warning messages</b><paragraphbreak />
			Sometimes it is not possible to deliver a message immediately due
			to a networking failure or some other problem. In that case, the mail
			transfer system usually leaves the message in a queue and keeps
			retrying to deliver the message until it succeeds or it has reached
			the limit number of days before it gives up. When it gives up the
			the message is bounced to the return-path address.<paragraphbreak />
			However some systems send a warning message to the original sender
			when it is not delivered after the first few hours. This may be an
			useful notification when the message is sent by a human but it maybe
			inconvinient when you are sending messages to many users like for
			instance newsletters or messages to subscribers of mailing lists.<paragraphbreak />
			If you want to hint the mail transfer system to not send temporary
			delivery failure warning messages, just use the
			<functionlink>SetHeader</functionlink> function to set the
			<tt>Precedence</tt> header to <tt>bulk</tt>.<paragraphbreak />
			Setting this header this way is a convention used by mailing list
			manager programs precisely for this purpose. It may also hint some
			mail receiving systems to not send auto-response messages, for
			instance when the recipient user is away on vaction. However, not all
			systems are aware of this convention and still send auto-response
			messages when you set this header.<paragraphbreak />

			<b>- Send the message</b><paragraphbreak />
			Once you have set the message sender, the recipients and added the
			message text, use the <functionlink>Send</functionlink> function
			to send the message. This class uses the PHP function <tt>mail()</tt>
			to send messages.<paragraphbreak />
			<paragraphbreak />
			If for some reason you need to use a different message delivery
			method, you may use one of the existing sub-classes that are
			specialized in delivering messages by connecting to an SMTP server or
			using directly the programs sendmail and qmail.<paragraphbreak />

			<b>- Add an HTML message body</b><paragraphbreak />
			If you want to send an HTML message you can use the
			<functionlink>AddHTMLPart</functionlink> function if it contains
			only ASCII characters. If it contains non-ASCII characters, you
			should the <functionlink>AddQuotedPrintableHTMLPart</functionlink>
			function instead.<paragraphbreak />

			<b>- Add alternative text body for HTML messages</b><paragraphbreak />
			Not every e-mail program can display HTML messages. Therefore, when
			you send an HTML message, you should also include an alternative text
			part to be displayed by programs that do not support HTML
			messages.<paragraphbreak />
			<paragraphbreak />
			This is achieved by composing <tt>multipart/alternative</tt>
			messages. This type of message is composed by creating the HTML
			message part with the <functionlink>CreateHTMLPart</functionlink> or
			the <functionlink>CreateQuotedPrintableHTMLPart</functionlink>
			functions, then create the alternative text part with the
			<functionlink>CreatePlainTextPart</functionlink> or the
			<functionlink>CreateQuotedPrintableTextPart</functionlink>
			functions, and finally use the
			<functionlink>AddAlternativeMultipart</functionlink> function to add
			an assembly of both message parts.<paragraphbreak />
			Note that the text part should be the first to be specified in the
			array of parts passed to the
			<functionlink>AddAlternativeMultipart</functionlink> function, or
			else it will not appear correctly.<paragraphbreak />
			Despite this procedure adds a little complexity to the process of
			sending HTML messages, it is the same procedure that is followed by
			e-mail programs that are used by most people to send HTML
			messages.<paragraphbreak />
			Therefore, you are strongly recommended to follow the same procedure
			because some of the modern spam filter programs discard HTML messages
			without an alternative plain text part, as it constitutes a pattern
			that identifies messages composed by some of the spam sending
			programs.<paragraphbreak />

			<b><link>
				<data>- Embed images in HTML messages</data>
				<anchor>embed-image</anchor>
			</link></b><paragraphbreak />
			One way to show an image in an HTML message is to use
			<tt>&lt;img&gt;</tt> tag with <tt>src</tt> attribute set to the
			remote site URL of the image that is meant to be displayed.
			However, since the message recipient user may not be online when
			they will check their e-mail, an image referenced this way may not
			appear.<paragraphbreak />
			Alternatively, an image file can be embedded in an HTML message using
			<tt>multipart/related</tt> message parts. This type of message part
			is composed by creating the image file part with the
			<functionlink>CreateFilePart</functionlink> function.<paragraphbreak />
			Then use the <functionlink>GetPartContentID</functionlink> function
			the image part identifier text. Prepend the string
			<stringvalue>cid:</stringvalue> to this identifier to form a special
			URL that should be used in the HTML part to reference the image part
			like this:<paragraphbreak />
			<tt>$image_tag = <stringvalue>&lt;img src="cid:</stringvalue> .
			$message_object->GetPartContentID($image_part) .
			<stringvalue>"></stringvalue> ;</tt><paragraphbreak />
			When you have composed the whole HTML document, create the HTML
			message part with the <functionlink>CreateHTMLPart</functionlink> or
			the <functionlink>CreateQuotedPrintableHTMLPart</functionlink>
			functions, and finally use the
			<functionlink>CreateRelatedMultipart</functionlink> function to
			create a message part that can be added to the message with the
			function <functionlink>AddAlternativeMultipart</functionlink> like
			HTML messages with alternative text parts described
			before.<paragraphbreak />
			Note that the HTML part must be the first listed in the parts array
			argument that is passed to the function
			<functionlink>CreateRelatedMultipart</functionlink>, or else the
			message may not appear correctly.<paragraphbreak />
			Note also that when you are composing an HTML message with embedded
			images and an alternative text part, first you need to create the
			<tt>multipart/alternative</tt> part with the HTML and the text parts
			using the <functionlink>CreateAlternativeMultipart</functionlink>
			function, and then you add the <tt>multipart/related</tt> part to
			the message with the
			<functionlink>AddRelatedMultipart</functionlink> function,
			passing an array of parts that lists first the
			<tt>multipart/alternative</tt> part and then the image part created
			before.<paragraphbreak />

			<b>- Attach files to messages</b><paragraphbreak />
			To send a message with attached files, it is necessary to compose a
			<tt>multipart/mixed</tt> message. This is a type of message made by a
			text or HTML part followed by one or more file
			parts.<paragraphbreak />
			If you add multiple parts to a message, this class implicitly turns
			it into a <tt>multipart/mixed</tt> message. Therefore you only need
			to use the function <functionlink>AddFilePart</functionlink> for each
			file that you want to attach and the class will automatically
			generate the message treating any parts added after the first as
			attachments.<paragraphbreak />

			<b>- Forward received messages</b><paragraphbreak />
			To forward an e-mail message received from somewhere, just use the
			function <functionlink>AddMessagePart</functionlink> passing the
			message complete with the original headers and body data. The message
			is forwarded as an attachment that most mail programs can
			display.<paragraphbreak />

			<b>- Sending messages to many recipients (mass or bulk mailing)</b><paragraphbreak />
			Sending messages to many recipients is an activity also known as
			mass or bulk mailing. There are several alternatives for mass
			mailing. One way consists on specifying all recipient addresses
			with the <tt>Bcc</tt> header, separating the addresses with commas
			(,), or using the
			<functionlink>SetMultipleEncodedEmailHeader</functionlink> function.
			This way you only need to send one message that is distributed to all
			recipients by your mail transfer system.<paragraphbreak />
			Unfortunately, many mail account providers like Hotmail, tend to
			consider messages sent this way as spam because the real recipients
			addresses are not visible in <tt>To</tt> of <tt>Cc</tt> headers.
			So, this method is no longer a good solution these
			days.<paragraphbreak />
			The alternative is to send a separate message to each recipient by
			iteratively setting the <tt>To</tt> header with each recipient
			address and calling the <functionlink>Send</functionlink> function.
			This way tends to take too much time and CPU as the number of
			recipients grow.<paragraphbreak />
			When sending messages to many recipients, call the
			<functionlink>SetBulkMail</functionlink> function to hint the class
			to optimize the way it works to make the delivery of the messages
			more efficient and eventually faster.<paragraphbreak />
			The actual optimizations that are performed depend on the delivery
			method that is used by this class or any of its subclasses
			specialized on the different delivery methods that are supported.
			Check the documentation of the subclass that you use to learn about
			the optimizations that are performed, if any.<paragraphbreak />
			If you intend to send messages with the same body to all recipients,
			the class can optimize the generation of the messages and reduce
			significantly the composition time if you set the
			<variablelink>cache_body</variablelink> variable to
			<tt><booleanvalue>1</booleanvalue></tt>.<paragraphbreak />
			If you really need to personalize the content of a message part with
			different text, HTML or file to each recipient, you should use the
			<functionlink>ReplacePart</functionlink> function to avoid as much
			as possible the overhead of composing a new message to each of the
			recipients of the mailing.<paragraphbreak />
			Other than that, take a look at the documentation of the this class
			sub-classes that may be used in your PHP environment, as these may
			provide more efficient delivery solutions for mass mailing.<paragraphbreak />

			<b>- Error handling</b><paragraphbreak />
			Most of the functions of this class that may fail, return an error
			message string that describes the error that has occurred. If there
			was no error, the functions return an empty string.<paragraphbreak />
			Verifying the return value of all the functions to determine
			whether there was an error is a tedious task to implement for most
			developers. To avoid this problem, this class supports <i>cumulative
			error checking</i>.<paragraphbreak />
			Cumulative error checking means that when an error occurs, the class
			stores the error message in the <variablelink>error</variablelink>
			variable. Then, when another function that may fail is called, it
			does nothing and immediately returns the same error
			message.<paragraphbreak />
			This way, the developers only need to check the return value of the
			last function that is called, which is usually the
			<functionlink>Send</functionlink> function.
		</usage>
	</documentation>

{/metadocument}
*/

class email_message_class
{
	/* Private variables */

	var $headers=array("To"=>"","Subject"=>"");
	var $body=-1;
	var $body_parts=0;
	var $parts=array();
	var $total_parts=0;
	var $free_parts=array();
	var $total_free_parts=0;
	var $delivery=array("State"=>"");
	var $next_token="";
	var $php_version=0;
	var $mailings=array();
	var $last_mailing=0;
	var $header_length_limit=512;
	var $auto_message_id=1;
	var $mailing_path="";
	var $body_cache=array();
	var $line_break="\n";
	var $line_length=75;
	var $email_address_pattern="([-!#\$%&'*+./0-9=?A-Z^_`a-z{|}~?])+@([-!#\$%&'*+/0-9=?A-Z^_`a-z{|}~?]+\\.)+[a-zA-Z]{2,6}";
	var $bulk_mail=0;

	/* Public variables */

/*
{metadocument}
	<variable>
		<name>email_regular_expression</name>
		<type>STRING</type>
		<value>^([-!#$%&amp;'*+./0-9=?A-Z^_`a-z{|}~?])+@([-!#$%&amp;'*+/0-9=?A-Z^_`a-z{|}~?]+\.)+[a-zA-Z]{2,6}$</value>
		<documentation>
			<purpose>Specify the regular expression that is used by the
				<functionlink>ValidateEmailAddress</functionlink> function to
				verify whether a given e-mail address may be valid.</purpose>
			<usage>Do not change this variable unless you have reason to believe
				that it is rejecting existing e-mail addresses that are known to be
				valid.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $email_regular_expression="^([-!#\$%&'*+./0-9=?A-Z^_`a-z{|}~?])+@([-!#\$%&'*+/0-9=?A-Z^_`a-z{|}~?]+\\.)+[a-zA-Z]{2,6}\$";

/*
{metadocument}
	<variable>
		<name>mailer</name>
		<type>STRING</type>
		<value>http://www.phpclasses.org/mimemessage $Revision: 1.1.1.1 $</value>
		<documentation>
			<purpose>Specify the base text that is used identify the name and the
				version of the class that is used to send the message by setting an
				implicit the <tt>X-Mailer</tt> message header. This is meant
				mostly to assist on the debugging of delivery problems.</purpose>
			<usage>Change this to set another mailer identification string or set
				it to an empty string to prevent that the <tt>X-Mailer</tt> header
				be added to the message.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $mailer='http://www.phpclasses.org/mimemessage $Revision: 1.1.1.1 $';

/*
{metadocument}
	<variable>
		<name>mailer_delivery</name>
		<type>STRING</type>
		<value>mail</value>
		<documentation>
			<purpose>Specify the text that is used to identify the mail
				delivery class or sub-class. This text is appended to the
				<tt>X-Mailer</tt> header text defined by the
				<variablelink>mailer</variablelink> variable.</purpose>
			<usage>This variable should only be redefined by the different mail
				delivery sub-classes.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $mailer_delivery='mail';

/*
{metadocument}
	<variable>
		<name>default_charset</name>
		<type>STRING</type>
		<value>ISO-8859-1</value>
		<documentation>
			<purpose>Specify the default character set to be assumed for the
				message headers and body text.</purpose>
			<usage>Change this variable to the correct character set name if it
				is different than the default.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $default_charset="ISO-8859-1";

/*
{metadocument}
	<variable>
		<name>line_quote_prefix</name>
		<type>STRING</type>
		<value>&gt; </value>
		<documentation>
			<purpose>Specify the default line quote prefix text used by the
				<functionlink>QuoteText</functionlink> function.</purpose>
			<usage>Change it only if you prefer to quote lines marking them with
				a different line prefix.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $line_quote_prefix="> ";

/*
{metadocument}
	<variable>
		<name>file_buffer_length</name>
		<type>INTEGER</type>
		<value>8000</value>
		<documentation>
			<purpose>Specify the length of the buffer that is used to read
				files in chunks of limited size.</purpose>
			<usage>The default value may be increased if you have plenty of
				memory and want to benefit from additional speed when processing
				the files that are used to compose messages.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $file_buffer_length=8000;

/*
{metadocument}
	<variable>
		<name>debug</name>
		<type>STRING</type>
		<value></value>
		<documentation>
			<purpose>Specify the name of a function that is called whenever an
				error occurs.</purpose>
			<usage>If you need to track the errors that may happen during the use
				of the class, set this variable to the name of a callback function.
				It should take only one argument that is the error message. When
				this variable is set to an empty string, no debug callback function
				is called.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $debug="";

/*
{metadocument}
	<variable>
		<name>cache_body</name>
		<type>BOOLEAN</type>
		<value>0</value>
		<documentation>
			<purpose>Specify whether the message bodies that are generated by the
				class before sending, should be cached in memory to be reused on
				the next message delivery.</purpose>
			<usage>Set this variable to <tt><booleanvalue>1</booleanvalue></tt>
				if you intend to send the a message with the same body to many
				recipients, so the class avoids the overhead of regenerating
				messages with the same content.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $cache_body=0;

/*
{metadocument}
	<variable>
		<name>error</name>
		<type>STRING</type>
		<value></value>
		<documentation>
			<purpose>Store the last error return by any function that may fail
				due to some error.</purpose>
			<usage>Do not change this variable value unless you intend to clear
				the error status by setting it to an empty string.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $error="";

	/* Private methods */

	Function Tokenize($string,$separator="")
	{
		if(!strcmp($separator,""))
		{
			$separator=$string;
			$string=$this->next_token;
		}
		for($character=0;$character<strlen($separator);$character++)
		{
			if(GetType($position=strpos($string,$separator[$character]))=="integer")
				$found=(IsSet($found) ? min($found,$position) : $position);
		}
		if(IsSet($found))
		{
			$this->next_token=substr($string,$found+1);
			return(substr($string,0,$found));
		}
		else
		{
			$this->next_token="";
			return($string);
		}
	}

	Function GetFilenameExtension($filename)
	{
		return(GetType($dot=strrpos($filename,"."))=="integer" ? substr($filename,$dot) : "");
	}

	Function OutputError($error)
	{
		if(strcmp($function=$this->debug,"")
		&& strcmp($error,""))
			$function($error);
		return($this->error=$error);
	}

	Function OutputPHPError($error, &$php_error_message)
	{
		if(IsSet($php_error_message)
		&& strlen($php_error_message))
			$error.=": ".$php_error_message;
		return($this->OutputError($error));
	}

	Function GetPHPVersion()
	{
		if($this->php_version==0)
		{
			$version=explode(".",function_exists("phpversion") ? phpversion() : "3.0.7");
			$this->php_version=$version[0]*1000000+$version[1]*1000+$version[2];
		}
		return($this->php_version);
	}

	Function GetRFC822Addresses($address,&$addresses)
	{
		if(function_exists("imap_rfc822_parse_adrlist"))
		{
			if(GetType($parsed_addresses=@imap_rfc822_parse_adrlist($address,$this->localhost))!="array")
				return("it was not specified a valid address list");
			for($entry=0;$entry<count($parsed_addresses);$entry++)
			{
				if(!IsSet($parsed_addresses[$entry]->host)
				|| $parsed_addresses[$entry]->host==".SYNTAX-ERROR.")
					return($parsed_addresses[$entry]->mailbox." .SYNTAX-ERROR.");
				$parsed_address=$parsed_addresses[$entry]->mailbox."@".$parsed_addresses[$entry]->host;
				if(IsSet($addresses[$parsed_address]))
					$addresses[$parsed_address]++;
				else
					$addresses[$parsed_address]=1;
			}
		}
		else
		{
			$length=strlen($address);
			for($position=0;$position<$length;)
			{
				$match=split($this->email_address_pattern,strtolower(substr($address,$position)),2);
				if(count($match)<2)
					break;
				$position+=strlen($match[0]);
				$next_position=$length-strlen($match[1]);
				$found=substr($address,$position,$next_position-$position);
				if(!strcmp($found,""))
					break;
				if(IsSet($addresses[$found]))
					$addresses[$found]++;
				else
					$addresses[$found]=1;
				$position=$next_position;
			}
		}
		return("");
	}

	Function FormatHeader($header_name,$header_value)
	{
		$length=strlen($header_value);
		for($header_data="",$header_line=$header_name.": ",$line_length=strlen($header_line),$position=0;$position<$length;)
		{
			for($space=$position,$line_length=strlen($header_line);$space<$length;)
			{
				if(GetType($next=strpos($header_value," ",$space+1))!="integer")
					$next=$length;
				if($next-$position+$line_length>$this->header_length_limit)
				{
					if($space==$position)
						$space=$next;
					break;
				}
				$space=$next;
			}
			$header_data.=$header_line.substr($header_value,$position,$space-$position);
			if($space<$length)
				$header_line="";
			$position=$space;
			if($position<$length)
				$header_data.=$this->line_break;
		}
		return($header_data);
	}

	Function GenerateMessageID($sender)
	{
		$micros=$this->Tokenize(microtime()," ");
		$seconds=$this->Tokenize("");
		$local=$this->Tokenize($sender,"@");
		$host=$this->Tokenize(" @");
		if($host[strlen($host)-1]=="-")
			$host=substr($host,0,strlen($host)-1);
		return($this->FormatHeader("Message-ID","<".strftime("%Y%m%d%H%M%S",$seconds).substr($micros,1,5).".".ereg_replace("[^A-Za-z]","-",$local)."@".$host.">"));
	}

	Function SendMail($to,$subject,&$body,&$headers,$return_path)
	{
		if(!function_exists("mail"))
			return($this->OutputError("the mail() function is not available in this PHP installation"));
		if(strlen($return_path))
		{
			if(!defined("PHP_OS"))
				return($this->OutputError("it is not possible to set the Return-Path header with your PHP version"));
			if(!strcmp(substr(PHP_OS,0,3),"WIN"))
				return($this->OutputError("it is not possible to set the Return-Path header directly from a PHP script on Windows"));
			if($this->GetPHPVersion()<4000005)
				return($this->OutputError("it is not possible to set the Return-Path header in PHP version older than 4.0.5"));
			if(function_exists("ini_get")
			&& ini_get("safe_mode"))
				return($this->OutputError("it is not possible to set the Return-Path header due to PHP safe mode restrictions"));
			$success=@mail($to,$subject,$body,$headers,"-f".$return_path);
		}
		else
			$success=@mail($to,$subject,$body,$headers);
		return($success ? "" : $this->OutputPHPError("it was not possible to send e-mail message", $php_errormsg));
	}

	Function StartSendingMessage()
	{
		if(strcmp($this->delivery["State"],""))
			return($this->OutputError("the message was already started to be sent"));
		$this->delivery=array("State"=>"SendingHeaders");
		return("");
	}

	Function SendMessageHeaders($headers)
	{
		if(strcmp($this->delivery["State"],"SendingHeaders"))
		{
			if(!strcmp($this->delivery["State"],""))
				return($this->OutputError("the message was not yet started to be sent"));
			else
				return($this->OutputError("the message headers were already sent"));
		}
		$this->delivery["Headers"]=$headers;
		$this->delivery["State"]="SendingBody";
		return("");
	}

	Function SendMessageBody(&$data)
	{
		if(strcmp($this->delivery["State"],"SendingBody"))
			return($this->OutputError("the message headers were not yet sent"));
		if(IsSet($this->delivery["Body"]))
			$this->delivery["Body"].=$data;
		else
			$this->delivery["Body"]=$data;
		return("");
	}

	Function EndSendingMessage()
	{
		if(strcmp($this->delivery["State"],"SendingBody"))
			return($this->OutputError("the message body data was not yet sent"));
		if(!IsSet($this->delivery["Headers"])
		|| count($this->delivery["Headers"])==0)
			return($this->OutputError("message has no headers"));
		$line_break=((defined("PHP_OS") && !strcmp(substr(PHP_OS,0,3),"WIN")) ? "\r\n" : $this->line_break);
		$headers=$this->delivery["Headers"];
		for($has=array(),$headers_text="",$header=0,Reset($headers);$header<count($headers);Next($headers),$header++)
		{
			$header_name=Key($headers);
			switch(strtolower($header_name))
			{
				case "to":
				case "subject":
					$has[strtolower($header_name)]=$headers[$header_name];
					break;
				case "from":
				case "return-path":
				case "message-id":
					$has[strtolower($header_name)]=$headers[$header_name];
				default:
					$header_line=$header_name.": ".$headers[$header_name];
					if(strlen($headers_text))
						$headers_text.=$this->line_break.$header_line;
					else
						$headers_text=$header_line;
			}
		}
		if(!IsSet($has["to"]))
			return($this->OutputError("it was not specified a valid To: header"));
		if(!IsSet($has["subject"]))
			return($this->OutputError("it was not specified a valid Subject: header"));
		if(!IsSet($has["message-id"])
		&& $this->auto_message_id)
		{
			$sender=(IsSet($has["return-path"]) ? $has["return-path"] : (IsSet($has["from"]) ? $has["from"] : $has["to"]));
			$header_line=$this->GenerateMessageID($sender);
			if(strlen($headers_text))
				$headers_text.=$this->line_break.$header_line;
			else
				$headers_text=$header_line;
		}
		if(strcmp($error=$this->SendMail($has["to"],$has["subject"],$this->delivery["Body"],$headers_text,IsSet($has["return-path"]) ? $has["return-path"] : ""),""))
			return($error);
		$this->delivery=array("State"=>"");
		return("");
	}

	Function StopSendingMessage()
	{
		$this->delivery=array("State"=>"");
		return("");
	}

	Function GetPartBoundary($part)
	{
		if(!IsSet($this->parts[$part]["BOUNDARY"]))
			$this->parts[$part]["BOUNDARY"]=md5(uniqid($part.time()));
	}

	Function GetPartHeaders(&$headers,$part)
	{
		if(!IsSet($this->parts[$part]["Content-Type"]))
			return($this->OutputError("it was added a part without Content-Type: defined"));
		$type=$this->Tokenize($full_type=strtolower($this->parts[$part]["Content-Type"]),"/");
		$sub_type=$this->Tokenize("");
		switch($type)
		{
			case "text":
			case "image":
			case "audio":
			case "video":
			case "application":
			case "message":
				$headers["Content-Type"]=$full_type.(IsSet($this->parts[$part]["CHARSET"]) ? "; charset=".$this->parts[$part]["CHARSET"] : "").(IsSet($this->parts[$part]["NAME"]) ? "; name=\"".$this->parts[$part]["NAME"]."\"" : "");
				if(IsSet($this->parts[$part]["Content-Transfer-Encoding"]))
					$headers["Content-Transfer-Encoding"]=$this->parts[$part]["Content-Transfer-Encoding"];
				if(IsSet($this->parts[$part]["DISPOSITION"])
				&& strlen($this->parts[$part]["DISPOSITION"]))
					$headers["Content-Disposition"]=$this->parts[$part]["DISPOSITION"].(IsSet($this->parts[$part]["NAME"]) ? "; filename=\"".$this->parts[$part]["NAME"]."\"" : "");
				break;
			case "multipart":
				switch($sub_type)
				{
					case "alternative":
					case "related":
					case "mixed":
					case "parallel":
						$this->GetPartBoundary($part);
						$headers["Content-Type"]=$full_type."; boundary=\"".$this->parts[$part]["BOUNDARY"]."\"";
						break;
					default:
						return($this->OutputError("multipart Content-Type sub_type $sub_type not yet supported"));
				}
				break;
			default:
				return($this->OutputError("Content-Type: $full_type not yet supported"));
		}
		if(IsSet($this->parts[$part]["Content-ID"]))
			$headers["Content-ID"]="<".$this->parts[$part]["Content-ID"].">";
		return("");
	}

	Function GetPartBody(&$body,$part)
	{
		if(!IsSet($this->parts[$part]["Content-Type"]))
			return($this->OutputError("it was added a part without Content-Type: defined"));
		$type=$this->Tokenize($full_type=strtolower($this->parts[$part]["Content-Type"]),"/");
		$sub_type=$this->Tokenize("");
		$body="";
		switch($type)
		{
			case "text":
			case "image":
			case "audio":
			case "video":
			case "application":
			case "message":
				if(IsSet($this->parts[$part]["FILENAME"]))
				{
					$size=@filesize($this->parts[$part]["FILENAME"]);
					if(!($file=@fopen($this->parts[$part]["FILENAME"],"rb")))
						return($this->OutputPHPError("could not open part file ".$this->parts[$part]["FILENAME"], $php_errormsg));
					while(!feof($file))
					{
						if(GetType($block=@fread($file,$this->file_buffer_length))!="string")
						{
							fclose($file);
							return($this->OutputPHPError("could not read part file", $php_errormsg));
						}
						$body.=$block;
					}
					fclose($file);
					if((GetType($size)!="integer"
					|| strlen($body)>$size)
					&& function_exists("get_magic_quotes_runtime")
					&& get_magic_quotes_runtime())
						$body=StripSlashes($body);
					if(GetType($size)=="integer"
					&& strlen($body)!=$size)
						return($this->OutputError("the length of the file that was read does not match the size of the part file ".$this->parts[$part]["FILENAME"]." due to possible data corruption"));
				}
				else
				{
					if(!IsSet($this->parts[$part]["DATA"]))
						return($this->OutputError("it was added a part without a body PART"));
					$body=$this->parts[$part]["DATA"];
				}
				$encoding=(IsSet($this->parts[$part]["Content-Transfer-Encoding"]) ? strtolower($this->parts[$part]["Content-Transfer-Encoding"]) : "");
				switch($encoding)
				{
					case "base64":
						$body=chunk_split(base64_encode($body));
						break;
					case "":
					case "quoted-printable":
					case "7bit":
						break;
					default:
						return($this->OutputError($encoding." is not yet a supported encoding type"));
				}
				break;
			case "multipart":
				switch($sub_type)
				{
					case "alternative":
					case "related":
					case "mixed":
					case "parallel":
						$this->GetPartBoundary($part);
						$boundary=$this->line_break."--".$this->parts[$part]["BOUNDARY"];
						$parts=count($this->parts[$part]["PARTS"]);
						for($multipart=0;$multipart<$parts;$multipart++)
						{
							$body.=$boundary.$this->line_break;
							$part_headers=array();
							$sub_part=$this->parts[$part]["PARTS"][$multipart];
							if(strlen($error=$this->GetPartHeaders($part_headers,$sub_part)))
								return($error);
							for($part_header=0,Reset($part_headers);$part_header<count($part_headers);$part_header++,Next($part_headers))
							{
								$header=Key($part_headers);
								$body.=$header.": ".$part_headers[$header].$this->line_break;
							}
							$body.=$this->line_break;
							if(strlen($error=$this->GetPartBody($part_body,$sub_part)))
								return($error);
							$body.=$part_body;
						}
						$body.=$boundary."--".$this->line_break;
						break;
					default:
						return($this->OutputError("multipart Content-Type sub_type $sub_type not yet supported"));
				}
				break;
			default:
				return($this->OutputError("Content-Type: $full_type not yet supported"));
		}
		return("");
	}

	/* Public functions */

/*
{metadocument}
	<function>
		<name>ValidateEmailAddress</name>
		<type>BOOLEAN</type>
		<documentation>
			<purpose>Determine whether a given e-mail address may be
				valid.</purpose>
			<usage>Just pass the e-mail <argumentlink>
					<function>ValidateEmailAddress</function>
					<argument>address</argument>
				</argumentlink> to be checked as function argument. This function
				uses the regular expression defined by the
				<variablelink>email_regular_expression</variablelink> variable to
				check the address.</usage>
			<returnvalue>The function returns
				<tt><booleanvalue>1</booleanvalue></tt> if the specified address
				may be valid.</returnvalue>
		</documentation>
		<argument>
			<name>address</name>
			<type>STRING</type>
			<documentation>
				<purpose>Specify the e-mail address to be validated.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function ValidateEmailAddress($address)
	{
		return(eregi($this->email_regular_expression,$address));
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

	Function QuotedPrintableEncode($text,$header_charset='',$break_lines=1)
	{
		$ln=strlen($text);
		$h=(strlen($header_charset)>0);
		if($h)
		{
			$s=array(
				'='=>1,
				'?'=>1,
				'_'=>1,
				'('=>1,
				')'=>1,
				'<'=>1,
				'>'=>1,
				'@'=>1,
				','=>1,
				';'=>1,
				'"'=>1,
				'\\'=>1,
/*
				'/'=>1,
				'['=>1,
				']'=>1,
				':'=>1,
				'.'=>1,
*/
			);
			$space=$break_lines=0;
			for($i=0;$i<$ln;$i++)
			{
				if(IsSet($s[$text[$i]]))
					break;
				if(strcmp($text[$i]," "))
				{
					$o=Ord($text[$i]);
					if($o<32
					|| $o>127)
							break;
				}
				else
					$space=$i+1;
			}
			if($i==$ln)
				return($text);
			if($space>0)
				return(substr($text,0,$space).($space<$ln ? $this->QuotedPrintableEncode(substr($text,$space),$header_charset,0) : ""));
		}
		for($w=$e='',$l=0,$i=0;$i<$ln;$i++)
		{
			$c=$text[$i];
			$o=Ord($c);
			$en=0;
			switch($o)
			{
				case 9:
				case 32:
					if(!$h)
					{
						$w=$c;
						$c='';
					}
					else
					{
						if($o==32)
							$c='_';
						else
							$en=1;
					}
					break;
				case 10:
				case 13:
					if(strlen($w))
					{
						if($break_lines
						&& $l+3>75)
						{
							$e.='='.$this->line_break;
							$l=0;
						}
						$e.=sprintf('=%02X',Ord($w));
						$l+=3;
						$w='';
					}
					$e.=$c;
					$l=0;
					continue 2;
				default:
					if($o>127
					|| $o<32
					|| !strcmp($c,'='))
						$en=1;
					elseif($h
					&& IsSet($s[$c]))
						$en=1;
					break;
			}
			if(strlen($w))
			{
				if($break_lines
				&& $l+1>75)
				{
					$e.='='.$this->line_break;
					$l=0;
				}
				$e.=$w;
				$l++;
				$w='';
			}
			if(strlen($c))
			{
				if($en)
				{
					$c=sprintf('=%02X',$o);
					$el=3;
				}
				else
					$el=1;
				if($break_lines
				&& $l+$el>75)
				{
					$e.='='.$this->line_break;
					$l=0;
				}
				$e.=$c;
				$l+=$el;
			}
		}
		if(strlen($w))
		{
			if($break_lines
			&& $l+3>75)
				$e.='='.$this->line_break;
			$e.=sprintf('=%02X',Ord($w));
		}
		if($h
		&& strcmp($text,$e))
			return('=?'.$header_charset.'?q?'.$e.'?=');
		else
			return($e);
	}

/*
{metadocument}
	<function>
		<name>WrapText</name>
		<type>STRING</type>
		<documentation>
			<purpose>Split a text in lines that do not exceed the length limit
				avoiding to break it in the middle of any words.</purpose>
			<usage>Just pass the <argumentlink>
					<function>WrapText</function>
					<argument>text</argument>
				</argumentlink> to be wrapped.</usage>
			<returnvalue>The wrapped text eventually broken in multiple lines
				that do not exceed the line length limit.</returnvalue>
		</documentation>
		<argument>
			<name>text</name>
			<type>STRING</type>
			<documentation>
				<purpose>Text to be wrapped.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>line_length</name>
			<type>INTEGER</type>
			<defaultvalue>0</defaultvalue>
			<documentation>
				<purpose>Line length limit. Pass a value different than
					<tt><integervalue>0</integervalue></tt> to use a line length
					limit other than the default of 75 characters.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>line_break</name>
			<type>STRING</type>
			<defaultvalue></defaultvalue>
			<documentation>
				<purpose>Character sequence that is used to break the lines longer
					than the length limit. Pass a non-empty to use a line breaking
					sequence other than the default
					<tt><stringvalue>&#10;</stringvalue></tt>.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>line_prefix</name>
			<type>STRING</type>
			<defaultvalue></defaultvalue>
			<documentation>
				<purpose>Character sequence that is used to insert in the beginning
					of all lines.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function WrapText($text,$line_length=0,$line_break="",$line_prefix="")
	{
		if(strlen($line_break)==0)
			$line_break=$this->line_break;
		if($line_length==0)
			$line_length=$this->line_length;
		$lines=explode("\n",str_replace("\r","\n",str_replace("\r\n","\n",$text)));
		for($wrapped="",$line=0;$line<count($lines);$line++)
		{
			if(strlen($text_line=$lines[$line]))
			{
				for(;strlen($text_line=$line_prefix.$text_line)>$line_length;)
				{
					if(GetType($cut=strrpos(substr($text_line,0,$line_length)," "))!="integer")
					{
						$wrapped.=substr($text_line,0,$line_length).$line_break;
						$cut=$line_length;
					}
					else
					{
						$wrapped.=substr($text_line,0,$cut).$line_break;
						$cut++;
					}
					$text_line=substr($text_line,$cut);
				}
			}
			$wrapped.=$text_line.$line_break;
		}
		return($wrapped);
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

/*
{metadocument}
	<function>
		<name>QuoteText</name>
		<type>STRING</type>
		<documentation>
			<purpose>Mark a text block to appear like in reply messages composed
				with common e-mail programs that include text from the original
				message being replied.</purpose>
			<usage>Just pass the <argumentlink>
					<function>QuoteText</function>
					<argument>text</argument>
				</argumentlink> to be marked as a quote.</usage>
			<returnvalue>The quoted text with all lines prefixed with a quote
				prefix mark.</returnvalue>
		</documentation>
		<argument>
			<name>text</name>
			<type>STRING</type>
			<documentation>
				<purpose>Text to be quoted.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>quote_prefix</name>
			<type>STRING</type>
			<defaultvalue></defaultvalue>
			<documentation>
				<purpose>Character sequence that is inserted in the beginning of
					all lines as a quote mark. Set to an empty string to tell the
					function to use the default specified by the
					<variablelink>line_quote_prefix</variablelink> variable.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function QuoteText($text,$quote_prefix="")
	{
		if(strlen($quote_prefix)==0)
			$quote_prefix=$this->line_quote_prefix;
		return($this->WrapText($text,$line_length=0,$line_break="",$quote_prefix));
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

/*
{metadocument}
	<function>
		<name>SetHeader</name>
		<type>STRING</type>
		<documentation>
			<purpose>Set the value of a message header.</purpose>
			<usage>Use this function to set the values of the headers of the
				message that may be needed. There are some message headers that are
				automatically set by the class when the message is sent. Others
				must be defined before sending. Here follows the list of the names
				of the headers that must be set before sending:<paragraphbreak />
				<paragraphbreak />
				<b>Message subject</b> - <tt>Subject</tt><paragraphbreak />
				<b>Sender address</b> - <tt>From</tt><paragraphbreak />
				<b>Recipient addresses</b> - <tt>To</tt>, <tt>Cc</tt> and
				<tt>Bcc</tt><paragraphbreak />
				Each of the recipient address headers may contain one or more
				addresses. Multiple addresses must be separated by a comma and a
				space.<paragraphbreak />
				<b>Return path address</b> - <tt>Return-Path</tt><paragraphbreak />
				Optional header to specify the address where the message should be
				bounced in case it is not possible to deliver it.<paragraphbreak />
				In reality this is a virtual header. This means that adding this
				header to a message will not do anything by itself. However, this
				class looks for this header to adjust the message delivery
				procedure in such way that the Message Transfer Agent (MTA) system
				is hinted to direct any bounced messages to the address specified
				by this header.<paragraphbreak />
				Note that under some systems there is no way to set the return path
				address programmatically. This is the case when using the PHP
				<tt>mail()</tt> function under Windows where the return path
				address should be set in the <tt>php.ini</tt> configuration
				file.<paragraphbreak />
				Keep in mind that even when it is possible to set the return path
				address, the systems of some e-mail account providers may ignore
				this address and send bounced messages to the sender address. This
				is a bug of those systems. There is nothing that can be done other
				than complain.</usage>
			<returnvalue>An error message in case there was an error or an empty
				string otherwise. This return value may be safely ignored if the
				function parameters are set correctly.</returnvalue>
		</documentation>
		<argument>
			<name>header</name>
			<type>STRING</type>
			<documentation>
				<purpose>Name of the header.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>value</name>
			<type>STRING</type>
			<documentation>
				<purpose>Text value for the header.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>encoding_charset</name>
			<type>STRING</type>
			<defaultvalue></defaultvalue>
			<documentation>
				<purpose>Character set used in the header value. If it is set to an
					empty string, it is assumed the character set defined by the
					<variablelink>default_charset</variablelink> variable.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function SetHeader($header,$value,$encoding_charset="")
	{
		if(strlen($this->error))
			return($this->error);
		$this->headers["$header"]=(!strcmp($encoding_charset,"") ? "$value" : $this->QuotedPrintableEncode($value,$encoding_charset));
		return("");
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

/*
{metadocument}
	<function>
		<name>SetEncodedHeader</name>
		<type>STRING</type>
		<documentation>
			<purpose>The same as the <functionlink>SetHeader</functionlink>
				function assuming the default character set specified by the
				<variablelink>default_charset</variablelink> variable.</purpose>
			<usage>See the <functionlink>SetHeader</functionlink> function.</usage>
			<returnvalue>An error message in case there was an error or an empty
				string otherwise. This return value may be safely ignored if the
				function parameters are set correctly.</returnvalue>
		</documentation>
		<argument>
			<name>header</name>
			<type>STRING</type>
			<documentation>
				<purpose>Name of the header.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>value</name>
			<type>STRING</type>
			<documentation>
				<purpose>Text value for the header.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function SetEncodedHeader($header,$value)
	{
		return($this->SetHeader($header,$value,$this->default_charset));
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

/*
{metadocument}
	<function>
		<name>SetEncodedEmailHeader</name>
		<type>STRING</type>
		<documentation>
			<purpose>Set the value of an header that is meant to represent the
				e-mail address of a person or entity with a known name. This is
				meant mostly to set the <tt>From</tt>, <tt>To</tt>, <tt>Cc</tt> and
				<tt>Bcc</tt> headers.</purpose>
			<usage>Use this function like the
				<functionlink>SetHeader</functionlink> specifying the e-mail
				<argumentlink>
					<function>SetEncodedEmailHeader</function>
					<argument>address</argument>
				</argumentlink> as header value and also specifying the
				<argumentlink>
					<function>SetEncodedEmailHeader</function>
					<argument>name</argument>
				</argumentlink> of the known person or entity.</usage>
			<returnvalue>An error message in case there was an error or an empty
				string otherwise. This return value may be safely ignored if the
				function parameters are set correctly.</returnvalue>
		</documentation>
		<argument>
			<name>header</name>
			<type>STRING</type>
			<documentation>
				<purpose>Name of the header.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>address</name>
			<type>STRING</type>
			<documentation>
				<purpose>E-mail address value.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>name</name>
			<type>STRING</type>
			<documentation>
				<purpose>Person or entity name associated with the specified e-mail
					address.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function SetEncodedEmailHeader($header,$address,$name)
	{
		return($this->SetHeader($header,$this->QuotedPrintableEncode($name,$this->default_charset).' <'.$address.'>'));
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

/*
{metadocument}
	<function>
		<name>SetMultipleEncodedEmailHeader</name>
		<type>STRING</type>
		<documentation>
			<purpose>Set the value of an header that is meant to represent a list
				of e-mail addresses of names of people or entities. This is meant
				mostly to set the <tt>To</tt>, <tt>Cc</tt> and <tt>Bcc</tt>
				headers.</purpose>
			<usage>Use this function specifying the <argumentlink>
					<function>SetMultipleEncodedEmailHeader</function>
					<argument>header</argument>
				</argumentlink> and all the <argumentlink>
					<function>SetMultipleEncodedEmailHeader</function>
					<argument>addresses</argument>
				</argumentlink> in an associative array that should have
				the email addresses as entry indexes and the name of the respective
				people or entities as entry values.</usage>
			<returnvalue>An error message in case there was an error or an empty
				string otherwise. This return value may be safely ignored if the
				function parameters are set correctly.</returnvalue>
			<example><pre>$message_object->SetMultipleEncodedEmailHeader('Bcc', array(
  'peter@gabriel.org' =&gt; 'Peter Gabriel',
  'paul@simon.net' =&gt; 'Paul Simon',
  'mary@chain.com' =&gt; 'Mary Chain'
);</pre></example>
		</documentation>
		<argument>
			<name>header</name>
			<type>STRING</type>
			<documentation>
				<purpose>Name of the header.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>addresses</name>
			<type>HASH</type>
			<documentation>
				<purpose>List of all email addresses and associated person or
					entity names.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function SetMultipleEncodedEmailHeader($header,$addresses)
	{
		Reset($addresses);
		$end=(GetType($address=Key($addresses))!="string");
		for($value="";!$end;)
		{
			if(strlen($value))
				$value.=", ";
			$value.=$this->QuotedPrintableEncode($addresses[$address],$this->default_charset).' <'.$address.'>';
			Next($addresses);
			$end=(GetType($address=Key($addresses))!="string");
		}
		return($this->SetHeader($header,$value));
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

/*
{metadocument}
	<function>
		<name>ResetMessage</name>
		<type>VOID</type>
		<documentation>
			<purpose>Restore the content of the message to the initial state when
				the class object is created, i.e. without any headers or body
				parts.</purpose>
			<usage>Use this function if you want to start composing a completely
				new message.</usage>
		</documentation>
		<do>
{/metadocument}
*/
	Function ResetMessage()
	{
		$this->headers=array();
		$this->body=-1;
		$this->body_parts=0;
		$this->parts=array();
		$this->total_parts=0;
		$this->free_parts=array();
		$this->total_free_parts=0;
		$this->delivery=array("State"=>"");
		$this->error="";
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

	Function CreatePart(&$definition,&$part)
	{
		$part=-1;
		if(strlen($this->error))
			return($this->error);
		if($this->total_free_parts)
		{
			$this->total_free_parts--;
			$part=$this->free_parts[$this->total_free_parts];
			Unset($this->free_parts[$this->total_free_parts]);
		}
		else
		{
			$part=$this->total_parts;
			$this->total_parts++;
		}
		$this->parts[$part]=$definition;
		return("");
	}

/*
{metadocument}
	<function>
		<name>AddPart</name>
		<type>STRING</type>
		<documentation>
			<purpose>Add a previously created part to the message.</purpose>
			<usage>Use any of the functions to create standalone message parts
				and then use this function to add them to the message.</usage>
			<returnvalue>An error message in case there was an error or an empty
				string otherwise. This return value may be safely ignored if the
				function parameters are set correctly.</returnvalue>
		</documentation>
		<argument>
			<name>part</name>
			<type>INTEGER</type>
			<documentation>
				<purpose>Number of the part as returned by the function that
					originally created it.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function AddPart($part)
	{
		if(strlen($this->error))
			return($this->error);
		switch($this->body_parts)
		{
			case 0;
				$this->body=$part;
				break;
			case 1:
				$parts=array(
					$this->body,
					$part
				);
				if(strlen($error=$this->CreateMixedMultipart($parts,$body)))
					return($error);
				$this->body=$body;
				break;
			default:
				$this->parts[$this->body]["PARTS"][]=$part;
				break;
		}
		$this->body_parts++;
		return("");
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

/*
{metadocument}
	<function>
		<name>ReplacePart</name>
		<type>STRING</type>
		<documentation>
			<purpose>Replace a message part already added to the message with a
				newly created part. The replaced part gets the definition of the
				replacing part. The replacing part is discarded and its part number
				becomes free for creation of a new part.</purpose>
			<usage>Use one of the functions to create message parts and then pass
				the returned part numbers to this function.</usage>
			<returnvalue>An error message in case there was an error or an empty
				string otherwise. This return value may be safely ignored if the
				function parameters are set correctly.</returnvalue>
		</documentation>
		<argument>
			<name>old_part</name>
			<type>INTEGER</type>
			<documentation>
				<purpose>Number of the previously added part.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>new_part</name>
			<type>INTEGER</type>
			<documentation>
				<purpose>Number of the replacing part.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function ReplacePart($old_part,$new_part)
	{
		if(strlen($this->error))
			return($this->error);
		if(!IsSet($this->parts[$old_part]))
			return($this->error="it was attempted to replace an invalid message part");
		if(IsSet($this->parts[$old_part]["FREE"]))
			return($this->error="it was attempted to replace a message part that is no longer valid");
		if(!IsSet($this->parts[$new_part]))
			return($this->error="it was attempted to use an invalid message replacecement part");
		if(IsSet($this->parts[$new_part]["FREE"]))
			return($this->error="it was attempted to use a message replacecement part that is no longer valid");
		$this->parts[$old_part]=$this->parts[$new_part];
		$this->parts[$new_part]=array("FREE"=>1);
		$this->free_parts[$this->total_free_parts]=$new_part;
		$this->total_free_parts++;
		return("");
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

	Function CreateAndAddPart(&$definition)
	{
		if(strlen($error=$this->CreatePart($definition,$part))
		|| strlen($error=$this->AddPart($part)))
			return($error);
		return("");
	}

/*
{metadocument}
	<function>
		<name>CreatePlainTextPart</name>
		<type>STRING</type>
		<documentation>
			<purpose>Create a plain text message part.</purpose>
			<usage>Pass an ASCII (7 bits) <argumentlink>
					<function>CreatePlainTextPart</function>
					<argument>text</argument>
				</argumentlink> string and get the created part number in the
				<argumentlink>
					<function>CreatePlainTextPart</function>
					<argument>part</argument>
				</argumentlink> that is returned by reference.</usage>
			<returnvalue>An error message in case there was an error or an empty
				string otherwise. This return value may be safely ignored if the
				function parameters are set correctly.</returnvalue>
		</documentation>
		<argument>
			<name>text</name>
			<type>STRING</type>
			<documentation>
				<purpose>Text of the message part to create.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>charset</name>
			<type>STRING</type>
			<documentation>
				<purpose>Character set used in the part text. If it is set to an
					empty string, it is assumed the character set defined by the
					<variablelink>default_charset</variablelink> variable.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>part</name>
			<type>INTEGER</type>
			<out />
			<documentation>
				<purpose>Number of the created part that is returned by reference.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function CreatePlainTextPart($text,$charset,&$part)
	{
		if(!strcmp($charset,""))
			$charset=$this->default_charset;
		$definition=array(
			"Content-Type"=>"text/plain",
			"DATA"=>$text
		);
		if(strcmp(strtoupper($charset),"ASCII"))
			$definition["CHARSET"]=$charset;
		return($this->CreatePart($definition,$part));
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

/*
{metadocument}
	<function>
		<name>AddPlainTextPart</name>
		<type>STRING</type>
		<documentation>
			<purpose>Add a plain text part to the message.</purpose>
			<usage>Pass an ASCII (7 bits) <argumentlink>
					<function>AddPlainTextPart</function>
					<argument>text</argument>
				</argumentlink> string.</usage>
			<returnvalue>An error message in case there was an error or an empty
				string otherwise. This return value may be safely ignored if the
				function parameters are set correctly.</returnvalue>
		</documentation>
		<argument>
			<name>text</name>
			<type>STRING</type>
			<documentation>
				<purpose>Text of the message part to add.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>charset</name>
			<type>STRING</type>
			<defaultvalue></defaultvalue>
			<documentation>
				<purpose>Character set used in the part text. If it is set to an
					empty string, it is assumed the character set defined by the
					<variablelink>default_charset</variablelink> variable.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function AddPlainTextPart($text,$charset="")
	{
		if(strlen($error=$this->CreatePlainTextPart($text,$charset,$part))
		|| strlen($error=$this->AddPart($part)))
			return($error);
		return("");
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

	Function CreateEncodedQuotedPrintableTextPart($text,$charset,&$part)
	{
		if(!strcmp($charset,""))
			$charset=$this->default_charset;
		$definition=array(
			"Content-Type"=>"text/plain",
			"Content-Transfer-Encoding"=>"quoted-printable",
			"CHARSET"=>$charset,
			"DATA"=>$text
		);
		return($this->CreatePart($definition,$part));
	}

	Function AddEncodedQuotedPrintableTextPart($text,$charset="")
	{
		if(strlen($error=$this->CreateEncodedQuotedPrintableTextPart($text,$charset,$part))
		|| strlen($error=$this->AddPart($part)))
			return($error);
		return("");
	}

/*
{metadocument}
	<function>
		<name>CreateQuotedPrintableTextPart</name>
		<type>STRING</type>
		<documentation>
			<purpose>Create a text message part that may contain non-ASCII
				characters (8 bits or more).</purpose>
			<usage>Pass a <argumentlink>
					<function>CreateQuotedPrintableTextPart</function>
					<argument>text</argument>
				</argumentlink> string and get the created part number in the
				<argumentlink>
					<function>CreateQuotedPrintableTextPart</function>
					<argument>part</argument>
				</argumentlink> that is returned by reference.</usage>
			<returnvalue>An error message in case there was an error or an empty
				string otherwise. This return value may be safely ignored if the
				function parameters are set correctly.</returnvalue>
		</documentation>
		<argument>
			<name>text</name>
			<type>STRING</type>
			<documentation>
				<purpose>Text of the message part to create.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>charset</name>
			<type>STRING</type>
			<documentation>
				<purpose>Character set used in the part text. If it is set to an
					empty string, it is assumed the character set defined by the
					<variablelink>default_charset</variablelink> variable.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>part</name>
			<type>INTEGER</type>
			<out />
			<documentation>
				<purpose>Number of the created part that is returned by reference.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function CreateQuotedPrintableTextPart($text,$charset,&$part)
	{
		return($this->CreateEncodedQuotedPrintableTextPart($this->QuotedPrintableEncode($text),$charset,$part));
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

/*
{metadocument}
	<function>
		<name>AddQuotedPrintableTextPart</name>
		<type>STRING</type>
		<documentation>
			<purpose>Add a text part to the message that may contain non-ASCII
				characters (8 bits or more).</purpose>
			<usage>Pass a <argumentlink>
					<function>AddQuotedPrintableTextPart</function>
					<argument>text</argument>
				</argumentlink> string.</usage>
			<returnvalue>An error message in case there was an error or an empty
				string otherwise. This return value may be safely ignored if the
				function parameters are set correctly.</returnvalue>
		</documentation>
		<argument>
			<name>text</name>
			<type>STRING</type>
			<documentation>
				<purpose>Text of the message part to create.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>charset</name>
			<type>STRING</type>
			<defaultvalue></defaultvalue>
			<documentation>
				<purpose>Character set used in the part text. If it is set to an
					empty string, it is assumed the character set defined by the
					<variablelink>default_charset</variablelink> variable.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function AddQuotedPrintableTextPart($text,$charset="")
	{
		return($this->AddEncodedQuotedPrintableTextPart($this->QuotedPrintableEncode($text),$charset));
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

/*
{metadocument}
	<function>
		<name>CreateHTMLPart</name>
		<type>STRING</type>
		<documentation>
			<purpose>Create an HTML message part only with ASCII characters (7 bit).</purpose>
			<usage>Pass an ASCII (7 bits) <argumentlink>
					<function>CreateHTMLPart</function>
					<argument>html</argument>
				</argumentlink> text string and get the created part number in the
				<argumentlink>
					<function>CreateHTMLPart</function>
					<argument>part</argument>
				</argumentlink> that is returned by reference.</usage>
			<returnvalue>An error message in case there was an error or an empty
				string otherwise. This return value may be safely ignored if the
				function parameters are set correctly.</returnvalue>
		</documentation>
		<argument>
			<name>html</name>
			<type>STRING</type>
			<documentation>
				<purpose>HTML of the message part to create.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>charset</name>
			<type>STRING</type>
			<documentation>
				<purpose>Character set used in the part text. If it is set to an
					empty string, it is assumed the character set defined by the
					<variablelink>default_charset</variablelink> variable.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>part</name>
			<type>INTEGER</type>
			<out />
			<documentation>
				<purpose>Number of the created part that is returned by reference.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function CreateHTMLPart($html,$charset,&$part)
	{
		if(!strcmp($charset,""))
			$charset=$this->default_charset;
		$definition=array(
			"Content-Type"=>"text/html",
			"CHARSET"=>$charset,
			"DATA"=>$html
		);
		return($this->CreatePart($definition,$part));
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

/*
{metadocument}
	<function>
		<name>AddHTMLPart</name>
		<type>STRING</type>
		<documentation>
			<purpose>Add an HTML part to the message only with ASCII characters.</purpose>
			<usage>Pass an <argumentlink>
					<function>AddHTMLPart</function>
					<argument>html</argument>
				</argumentlink> text string.</usage>
			<returnvalue>An error message in case there was an error or an empty
				string otherwise. This return value may be safely ignored if the
				function parameters are set correctly.</returnvalue>
		</documentation>
		<argument>
			<name>html</name>
			<type>STRING</type>
			<documentation>
				<purpose>HTML of the message part to create.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>charset</name>
			<type>STRING</type>
			<defaultvalue></defaultvalue>
			<documentation>
				<purpose>Character set used in the part text. If it is set to an
					empty string, it is assumed the character set defined by the
					<variablelink>default_charset</variablelink> variable.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function AddHTMLPart($html,$charset="")
	{
		if(strlen($error=$this->CreateHTMLPart($html,$charset,$part))
		|| strlen($error=$this->AddPart($part)))
			return($error);
		return("");
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

	Function CreateEncodedQuotedPrintableHTMLPart($html,$charset,&$part)
	{
		if(!strcmp($charset,""))
			$charset=$this->default_charset;
		$definition=array(
			"Content-Type"=>"text/html",
			"Content-Transfer-Encoding"=>"quoted-printable",
			"CHARSET"=>$charset,
			"DATA"=>$html
		);
		return($this->CreatePart($definition,$part));
	}

	Function AddEncodedQuotedPrintableHTMLPart($html,$charset="")
	{
		if(strlen($error=$this->CreateEncodedQuotedPrintableHTMLPart($html,$charset,$part))
		|| strlen($error=$this->AddPart($part)))
			return($error);
		return("");
	}

/*
{metadocument}
	<function>
		<name>CreateQuotedPrintableHTMLPart</name>
		<type>STRING</type>
		<documentation>
			<purpose>Create an HTML message part that may contain non-ASCII
				characters (8 bits or more).</purpose>
			<usage>Pass a <argumentlink>
					<function>CreateQuotedPrintableHTMLPart</function>
					<argument>html</argument>
				</argumentlink> text string and get the created part number in the
				<argumentlink>
					<function>CreateQuotedPrintableHTMLPart</function>
					<argument>part</argument>
				</argumentlink> that is returned by reference.</usage>
			<returnvalue>An error message in case there was an error or an empty
				string otherwise. This return value may be safely ignored if the
				function parameters are set correctly.</returnvalue>
		</documentation>
		<argument>
			<name>html</name>
			<type>STRING</type>
			<documentation>
				<purpose>HTML of the message part to create.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>charset</name>
			<type>STRING</type>
			<documentation>
				<purpose>Character set used in the part text. If it is set to an
					empty string, it is assumed the character set defined by the
					<variablelink>default_charset</variablelink> variable.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>part</name>
			<type>INTEGER</type>
			<out />
			<documentation>
				<purpose>Number of the created part that is returned by reference.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function CreateQuotedPrintableHTMLPart($html,$charset,&$part)
	{
		return($this->CreateEncodedQuotedPrintableHTMLPart($this->QuotedPrintableEncode($html),$charset,$part));
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/


/*
{metadocument}
	<function>
		<name>AddQuotedPrintableHTMLPart</name>
		<type>STRING</type>
		<documentation>
			<purpose>Add an HTML part to the message that may contain non-ASCII
				characters (8 bits or more).</purpose>
			<usage>Pass a <argumentlink>
					<function>AddQuotedPrintableHTMLPart</function>
					<argument>html</argument>
				</argumentlink> text string.</usage>
			<returnvalue>An error message in case there was an error or an empty
				string otherwise. This return value may be safely ignored if the
				function parameters are set correctly.</returnvalue>
		</documentation>
		<argument>
			<name>html</name>
			<type>STRING</type>
			<documentation>
				<purpose>HTML of the message part to create.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>charset</name>
			<type>STRING</type>
			<defaultvalue></defaultvalue>
			<documentation>
				<purpose>Character set used in the part text. If it is set to an
					empty string, it is assumed the character set defined by the
					<variablelink>default_charset</variablelink> variable.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function AddQuotedPrintableHTMLPart($html,$charset="")
	{
		return($this->AddEncodedQuotedPrintableHTMLPart($this->QuotedPrintableEncode($html),$charset));
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

	Function GetFileDefinition(&$file,&$definition,$require_name=1)
	{
		if(strlen($this->error))
			return($this->error);
		$name="";
		if(IsSet($file["FileName"]))
			$name=basename($file["FileName"]);
		else
		{
			if(!IsSet($file["Data"]))
				return($this->OutputError("it was not specified the file part file name"));
		}
		if(IsSet($file["Name"]))
			$name=$file["Name"];
		if($require_name
		&& strlen($name)==0)
			return($this->OutputError("it was not specified the file part name"));
		$encoding="base64";
		if(IsSet($file["Content-Type"]))
		{
			$content_type=$file["Content-Type"];
			$type=$this->Tokenize(strtolower($content_type),"/");
			$sub_type=$this->Tokenize("");
			switch($type)
			{
				case "text":
				case "image":
				case "audio":
				case "video":
				case "application":
					break;
				case "message":
					$encoding="7bit";
					break;
				case "automatic":
					switch($sub_type)
					{
						case "name":
							if(strlen($name)==0)
								return($this->OutputError("it is not possible to determine content type from the name"));
							switch(strtolower($this->GetFilenameExtension($name)))
							{
								case ".xls":
									$content_type="application/excel";
									break;
								case ".hqx":
									$content_type="application/macbinhex40";
									break;
								case ".doc":
								case ".dot":
								case ".wrd":
									$content_type="application/msword";
									break;
								case ".pdf":
									$content_type="application/pdf";
									break;
								case ".pgp":
									$content_type="application/pgp";
									break;
								case ".ps":
								case ".eps":
								case ".ai":
									$content_type="application/postscript";
									break;
								case ".ppt":
									$content_type="application/powerpoint";
									break;
								case ".rtf":
									$content_type="application/rtf";
									break;
								case ".tgz":
								case ".gtar":
									$content_type="application/x-gtar";
									break;
								case ".gz":
									$content_type="application/x-gzip";
									break;
								case ".php":
								case ".php3":
									$content_type="application/x-httpd-php";
									break;
								case ".js":
									$content_type="application/x-javascript";
									break;
								case ".ppd":
								case ".psd":
									$content_type="application/x-photoshop";
									break;
								case ".swf":
								case ".swc":
								case ".rf":
									$content_type="application/x-shockwave-flash";
									break;
								case ".tar":
									$content_type="application/x-tar";
									break;
								case ".zip":
									$content_type="application/zip";
									break;
								case ".mid":
								case ".midi":
								case ".kar":
									$content_type="audio/midi";
									break;
								case ".mp2":
								case ".mp3":
								case ".mpga":
									$content_type="audio/mpeg";
									break;
								case ".ra":
									$content_type="audio/x-realaudio";
									break;
								case ".wav":
									$content_type="audio/wav";
									break;
								case ".bmp":
									$content_type="image/bitmap";
									break;
								case ".gif":
									$content_type="image/gif";
									break;
								case ".iff":
									$content_type="image/iff";
									break;
								case ".jb2":
									$content_type="image/jb2";
									break;
								case ".jpg":
								case ".jpe":
								case ".jpeg":
									$content_type="image/jpeg";
									break;
								case ".jpx":
									$content_type="image/jpx";
									break;
								case ".png":
									$content_type="image/png";
									break;
								case ".tif":
								case ".tiff":
									$content_type="image/tiff";
									break;
								case ".wbmp":
									$content_type="image/vnd.wap.wbmp";
									break;
								case ".xbm":
									$content_type="image/xbm";
									break;
								case ".css":
									$content_type="text/css";
									break;
								case ".txt":
									$content_type="text/plain";
									break;
								case ".htm":
								case ".html":
									$content_type="text/html";
									break;
								case ".xml":
									$content_type="text/xml";
									break;
								case ".mpg":
								case ".mpe":
								case ".mpeg":
									$content_type="video/mpeg";
									break;
								case ".qt":
								case ".mov":
									$content_type="video/quicktime";
									break;
								case ".avi":
									$content_type="video/x-ms-video";
									break;
								case ".eml":
									$content_type="message/rfc822";
									$encoding="7bit";
									break;
								default:
									$content_type="application/octet-stream";
									break;
							}
							break;
						default:
							return($this->OutputError($content_type." is not a supported automatic content type detection method"));
					}
					break;
				default:
					return($this->OutputError($content_type." is not a supported file content type"));
			}
		}
		else
			$content_type="application/octet-stream";
		$definition=array(
			"Content-Type"=>$content_type,
			"Content-Transfer-Encoding"=>$encoding,
			"NAME"=>$name
		);
		if(IsSet($file["Disposition"]))
		{
			switch(strtolower($file["Disposition"]))
			{
				case "inline":
				case "attachment":
					break;
				default:
					return($this->OutputError($file["Disposition"]." is not a supported message part content disposition"));
			}
			$definition["DISPOSITION"]=$file["Disposition"];
		}
		if(IsSet($file["FileName"]))
			$definition["FILENAME"]=$file["FileName"];
		else
		{
			if(IsSet($file["Data"]))
				$definition["DATA"]=$file["Data"];
		}
		return("");
	}

/*
{metadocument}
	<function>
		<name>CreateFilePart</name>
		<type>STRING</type>
		<documentation>
			<purpose>Create a message part to be handled as a file.</purpose>
			<usage>Pass a <argumentlink>
					<function>CreateFilePart</function>
					<argument>file</argument>
				</argumentlink> definition associative array and get the created
				part number in the <argumentlink>
					<function>CreateFilePart</function>
					<argument>part</argument>
				</argumentlink> that is returned by reference.</usage>
			<returnvalue>An error message in case there was an error or an empty
				string otherwise. This return value may be safely ignored if the
				function parameters are set correctly.</returnvalue>
		</documentation>
		<argument>
			<name>file</name>
			<type>HASH</type>
			<documentation>
				<purpose>Associative array to specify parameters that describe the
					file part. Here follows the list of supported parameters that
					should be used as indexes of the array:<paragraphbreak />
					<tt>FileName</tt><paragraphbreak />
					Name of the file from which the part data will be read when the
					message is generated. It may be a remote URL as long as your PHP
					installation is configured to allow accessing remote files with
					the <tt>fopen()</tt> function.<paragraphbreak />
					<tt>Data</tt><paragraphbreak />
					String that specifies the data of the file. This should be used
					as alternative data source to <tt>FileName</tt> for passing data
					available in memory, like for instance files stored in a database
					that was queried dynamically and the file contents was fetched
					into a string variable.<paragraphbreak />
					<tt>Name</tt><paragraphbreak />
					Name of the file that will appear in the message. If this
					parameter is missing the base name of the <tt>FileName</tt>
					parameter is used, if present.<paragraphbreak />
					<tt>Content-Type</tt><paragraphbreak />
					Content type of the part: <tt>text/plain</tt> for text,
					<tt>text/html</tt> for HTML, <tt>image/gif</tt> for GIF images,
					etc..<paragraphbreak />
					There is one special type named <tt>automatic/name</tt> that may
					be used to tell the class to try to guess the content type from
					the file name. Many file types are recognized from the file name
					extension. If the file name extension is not recognized, the
					default for binary data <tt>application/octet-stream</tt> is
					assumed.<paragraphbreak />
					<tt>Disposition</tt><paragraphbreak />
					Information to whether this file part is meant to be used as a
					file <tt>attachment</tt> or as a part meant to be displayed
					<tt>inline</tt>, eventually integrated with another related
					part.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>part</name>
			<type>INTEGER</type>
			<out />
			<documentation>
				<purpose>Number of the created part that is returned by reference.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function CreateFilePart(&$file,&$part)
	{
		if(strlen($this->GetFileDefinition($file,$definition)))
			return($this->error);
		return($this->CreatePart($definition,$part));
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

/*
{metadocument}
	<function>
		<name>AddFilePart</name>
		<type>STRING</type>
		<documentation>
			<purpose>Add a message part to be handled as a file.</purpose>
			<usage>Pass a <argumentlink>
					<function>AddFilePart</function>
					<argument>file</argument>
				</argumentlink> definition associative array.</usage>
			<returnvalue>An error message in case there was an error or an empty
				string otherwise. This return value may be safely ignored if the
				function parameters are set correctly.</returnvalue>
		</documentation>
		<argument>
			<name>file</name>
			<type>HASH</type>
			<documentation>
				<purpose>Associative array to specify parameters that describe the
					file part. See the <argumentlink>
						<function>CreateFilePart</function>
						<argument>file</argument>
					</argumentlink> argument description of the
					<functionlink>CreateFilePart</functionlink> function for an
					explanation about the supported file parameters.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function AddFilePart(&$file)
	{
		if(strlen($error=$this->CreateFilePart($file,$part))
		|| strlen($error=$this->AddPart($part)))
			return($error);
		return("");
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

/*
{metadocument}
	<function>
		<name>CreateMessagePart</name>
		<type>STRING</type>
		<documentation>
			<purpose>Create a message part to encapsulate another message. This
				is usually meant to create an attachment that contains a message
				that was received and is being forwarded intact with the original
				the headers and body data.</purpose>
			<usage>This function should be used like the
				<functionlink>CreateFilePart</functionlink> function, passing the
				same parameters to the <argumentlink>
					<function>CreateMessagePart</function>
					<argument>message</argument>
				</argumentlink> argument.<paragraphbreak />
				The message to be encapsulated can be specified either as an
				existing file with the <tt>FileName</tt> parameter, or as string
				of data in memory with the <tt>Data</tt>
				parameter.<paragraphbreak />
				The <tt>Content-Type</tt> and <tt>Disposition</tt> file parameters
				do not need to be specified because they are overridden by this
				function.</usage>
			<returnvalue>An error message in case there was an error or an empty
				string otherwise. This return value may be safely ignored if the
				function parameters are set correctly.</returnvalue>
		</documentation>
		<argument>
			<name>message</name>
			<type>HASH</type>
			<documentation>
				<purpose>Associative array that specifies definition parameters of
					the message file part.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>part</name>
			<type>INTEGER</type>
			<out />
			<documentation>
				<purpose>Number of the created part that is returned by reference.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function CreateMessagePart(&$message,&$part)
	{
		$message["Content-Type"]="message/rfc822";
		$message["Disposition"]="inline";
		if(strlen($this->GetFileDefinition($message,$definition)))
			return($this->error);
		return($this->CreatePart($definition,$part));
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

/*
{metadocument}
	<function>
		<name>AddMessagePart</name>
		<type>STRING</type>
		<documentation>
			<purpose>Add a message part that encapsulates another message. This
				is usually meant to add an attachment that contains a message that
				was received and is being forwarded intact with the original the
				headers and body data.</purpose>
			<usage>This function should be used like the
				<functionlink>AddFilePart</functionlink> function, passing the
				same parameters to the <argumentlink>
					<function>AddMessagePart</function>
					<argument>message</argument>
				</argumentlink> argument. See the
				<functionlink>CreateFilePart</functionlink> function for more
				details.</usage>
			<returnvalue>An error message in case there was an error or an empty
				string otherwise. This return value may be safely ignored if the
				function parameters are set correctly.</returnvalue>
		</documentation>
		<argument>
			<name>message</name>
			<type>HASH</type>
			<documentation>
				<purpose>Associative array that specifies definition parameters of
					the message file part.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function AddMessagePart(&$message)
	{
		if(strlen($error=$this->CreateMessagePart($message,$part))
		|| strlen($error=$this->AddPart($part)))
			return($error);
		return("");
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

	Function CreateMultipart(&$parts,&$part,$type)
	{
		$definition=array(
			"Content-Type"=>"multipart/".$type,
			"PARTS"=>$parts
		);
		return($this->CreatePart($definition,$part));
	}

	Function AddMultipart(&$parts,$type)
	{
		if(strlen($error=$this->CreateMultipart($parts,$part,$type))
		|| strlen($error=$this->AddPart($part)))
			return($error);
		return("");
	}

/*
{metadocument}
	<function>
		<name>CreateAlternativeMultipart</name>
		<type>STRING</type>
		<documentation>
			<purpose>Create a message part composed of multiple parts that can be
				displayed by the recipient e-mail program in alternative
				formats.<paragraphbreak />
				This is usually meant to create HTML messages with an alternative
				text part to be displayed by programs that cannot display HTML
				messages.</purpose>
			<usage>Create all the alternative message parts that are going to be
				sent and pass their numbers to the <argumentlink>
					<function>CreateAlternativeMultipart</function>
					<argument>parts</argument>
				</argumentlink> array argument.<paragraphbreak />
				The least sophisticated part, usually the text part, should appear
				first in the parts array because the e-mail programs that support
				displaying more sophisticated message parts will pick the last part
				in the message that is supported.</usage>
			<returnvalue>An error message in case there was an error or an empty
				string otherwise. This return value may be safely ignored if the
				function parameters are set correctly.</returnvalue>
		</documentation>
		<argument>
			<name>parts</name>
			<type>ARRAY</type>
			<documentation>
				<purpose>Array with the numbers with all the alternative parts.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>part</name>
			<type>INTEGER</type>
			<out />
			<documentation>
				<purpose>Number of the created part that is returned by reference.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function CreateAlternativeMultipart(&$parts,&$part)
	{
		return($this->CreateMultiPart($parts,$part,"alternative"));
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

/*
{metadocument}
	<function>
		<name>AddAlternativeMultipart</name>
		<type>STRING</type>
		<documentation>
			<purpose>Add a message part composed of multiple parts that can be
				displayed by the recipient e-mail program in alternative
				formats.<paragraphbreak />
				This is usually meant to create HTML messages with an alternative
				text part to be displayed by programs that cannot display HTML
				messages.</purpose>
			<usage>Create all the alternative message parts that are going to be
				sent and pass their numbers to the <argumentlink>
					<function>AddAlternativeMultipart</function>
					<argument>parts</argument>
				</argumentlink> array argument.<paragraphbreak />
				The least sophisticated part, usually the text part, should appear
				first in the parts array because the e-mail programs that support
				displaying more sophisticated message parts will pick the last part
				in the message that is supported.</usage>
			<returnvalue>An error message in case there was an error or an empty
				string otherwise. This return value may be safely ignored if the
				function parameters are set correctly.</returnvalue>
		</documentation>
		<argument>
			<name>parts</name>
			<type>ARRAY</type>
			<documentation>
				<purpose>Array with the numbers with all the alternative parts.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function AddAlternativeMultipart(&$parts)
	{
		return($this->AddMultipart($parts,"alternative"));
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

/*
{metadocument}
	<function>
		<name>CreateRelatedMultipart</name>
		<type>STRING</type>
		<documentation>
			<purpose>Create a message part that groups several related
				parts.<paragraphbreak />
				This is usually meant to group an HTML message part with images or
				other types of files that should be embedded in the same message
				and be displayed as a single part by the recipient e-mail
				program.</purpose>
			<usage>Create all the related message parts that are going to be
				sent and pass their numbers to the <argumentlink>
					<function>CreateRelatedMultipart</function>
					<argument>parts</argument>
				</argumentlink> array argument.<paragraphbreak />
				When using this function to group an HTML message with embedded
				images or other related files, make sure that the HTML part number
				is the first listed in the <argumentlink>
					<function>CreateRelatedMultipart</function>
					<argument>parts</argument>
				</argumentlink> array argument, or else the message may not appear
				correctly.</usage>
			<returnvalue>An error message in case there was an error or an empty
				string otherwise. This return value may be safely ignored if the
				function parameters are set correctly.</returnvalue>
		</documentation>
		<argument>
			<name>parts</name>
			<type>ARRAY</type>
			<documentation>
				<purpose>Array with the numbers with all the related parts.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>part</name>
			<type>INTEGER</type>
			<out />
			<documentation>
				<purpose>Number of the created part that is returned by reference.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function CreateRelatedMultipart(&$parts,&$part)
	{
		return($this->CreateMultipart($parts,$part,"related"));
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

/*
{metadocument}
	<function>
		<name>AddRelatedMultipart</name>
		<type>STRING</type>
		<documentation>
			<purpose>Add a message part that groups several related
				parts.<paragraphbreak />
				This is usually meant to group an HTML message part with images or
				other types of files that should be embedded in the same message
				and be displayed as a single part by the recipient e-mail
				program.</purpose>
			<usage>Create all the related message parts that are going to be
				sent and pass their numbers to the <argumentlink>
					<function>AddRelatedMultipart</function>
					<argument>parts</argument>
				</argumentlink> array argument.<paragraphbreak />
				When using this function to group an HTML message with embedded
				images or other related files, make sure that the HTML part number
				is the first listed in the <argumentlink>
					<function>AddRelatedMultipart</function>
					<argument>parts</argument>
				</argumentlink> array argument, or else the message may not appear
				correctly.</usage>
			<returnvalue>An error message in case there was an error or an empty
				string otherwise. This return value may be safely ignored if the
				function parameters are set correctly.</returnvalue>
		</documentation>
		<argument>
			<name>parts</name>
			<type>ARRAY</type>
			<documentation>
				<purpose>Array with the numbers with all the related parts.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function AddRelatedMultipart(&$parts)
	{
		return($this->AddMultipart($parts,"related"));
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

/*
{metadocument}
	<function>
		<name>CreateMixedMultipart</name>
		<type>STRING</type>
		<documentation>
			<purpose>Create a message part that groups several independent
				parts.<paragraphbreak />
				Usually this is meant compose messages with one or more file
				attachments. However, it is not necessary to use this function as
				the class implicitly creates a <tt>multipart/mixed</tt> message
				when more than one part is added to the message.</purpose>
			<usage>Create all the independent message parts that are going to be
				sent and pass their numbers to the <argumentlink>
					<function>CreateMixedMultipart</function>
					<argument>parts</argument>
				</argumentlink> array argument.</usage>
			<returnvalue>An error message in case there was an error or an empty
				string otherwise. This return value may be safely ignored if the
				function parameters are set correctly.</returnvalue>
		</documentation>
		<argument>
			<name>parts</name>
			<type>ARRAY</type>
			<documentation>
				<purpose>Array with the numbers with all the related parts.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>part</name>
			<type>INTEGER</type>
			<out />
			<documentation>
				<purpose>Number of the created part that is returned by reference.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function CreateMixedMultipart(&$parts,&$part)
	{
		return($this->CreateMultipart($parts,$part,"mixed"));
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

/*
{metadocument}
	<function>
		<name>AddMixedMultipart</name>
		<type>STRING</type>
		<documentation>
			<purpose>Add a message part that groups several independent
				parts.<paragraphbreak />
				Usually this is meant compose messages with one or more file
				attachments. However, it is not necessary to use this function as
				the class implicitly creates a <tt>multipart/mixed</tt> message
				when more than one part is added to the message.</purpose>
			<usage>Create all the independent message parts that are going to be
				sent and pass their numbers to the <argumentlink>
					<function>AddMixedMultipart</function>
					<argument>parts</argument>
				</argumentlink> array argument.</usage>
			<returnvalue>An error message in case there was an error or an empty
				string otherwise. This return value may be safely ignored if the
				function parameters are set correctly.</returnvalue>
		</documentation>
		<argument>
			<name>parts</name>
			<type>ARRAY</type>
			<documentation>
				<purpose>Array with the numbers with all the related parts.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function AddMixedMultipart(&$parts)
	{
		return($this->AddMultipart($parts,"mixed"));
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

	Function CreateParallelMultipart(&$parts,&$part)
	{
		return($this->CreateMultipart($parts,$part,"paralell"));
	}

	Function AddParalellMultipart(&$parts)
	{
		return($this->AddMultipart($parts,"paralell"));
	}

/*
{metadocument}
	<function>
		<name>GetPartContentID</name>
		<type>STRING</type>
		<documentation>
			<purpose>Retrieve the content identifier associated to a given
				message part.</purpose>
			<usage>Create a message part and pass its number to the <argumentlink>
					<function>GetPartContentID</function>
					<argument>part</argument>
				</argumentlink> argument.<paragraphbreak />
				This function is usually meant to create an URL that can be used
				in an HTML message part to reference related parts like images, CSS
				(Cascaded Style Sheets), or any other type of files related to the
				HTML part that are embedded in the same message as part of a
				<tt>multipart/related</tt> composite part.<paragraphbreak />
				To use the part content identifier returned by this function you
				need to prepend the string <tt><stringvalue>cid:</stringvalue></tt>
				to form a special URL that can be used in the HTML document this
				part file.<paragraphbreak />
				You may read more about using this function in the class usage
				section about <link>
					<data>embedding images in HTML messages</data>
					<name>embed-image</name>
				</link>.</usage>
			<returnvalue>The content identifier text string.<paragraphbreak />
				If it is specified an invalid message part, this function returns
				an empty string.</returnvalue>
		</documentation>
		<argument>
			<name>part</name>
			<type>INTEGER</type>
			<documentation>
				<purpose>Number of the part as returned by the function that
					originally created it.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function GetPartContentID($part)
	{
		if(!IsSet($this->parts[$part]))
			return("");
		if(!IsSet($this->parts[$part]["Content-ID"]))
		{
			$extension=(IsSet($this->parts[$part]["NAME"]) ? $this->GetFilenameExtension($this->parts[$part]["NAME"]) : "");
			$this->parts[$part]["Content-ID"]=md5(uniqid($part.time())).$extension;
		}
		return($this->parts[$part]["Content-ID"]);
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

/*
{metadocument}
	<function>
		<name>GetDataURL</name>
		<type>STRING</type>
		<documentation>
			<purpose>Generate a <tt>data:</tt> URL according to the <link>
					<data>RFC 2397</data>
					<url>http://www.ietf.org/rfc/rfc2397.txt</url>
				</link> suitable for using in HTML messages to represent an image
				or other type of file on which the data is directly embedded in the
				HTML code instead of being fetched from a separate file or remote
				URL.<paragraphbreak />
				Note that not all e-mail programs are capable of displaying images
				or other types of files embedded in HTML messages this way.</purpose>
			<usage>Pass a <argumentlink>
					<function>GetDataURL</function>
					<argument>file</argument>
				</argumentlink> part definition array like for the
				<functionlink>CreateFilePart</functionlink> function.</usage>
			<returnvalue>The <tt>data:</tt> representing the described file or an
				empty string in case there was an error.</returnvalue>
		</documentation>
		<argument>
			<name>file</name>
			<type>HASH</type>
			<documentation>
				<purpose>File definition.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function GetDataURL($file)
	{
		if(strlen($this->GetFileDefinition($file,$definition,0)))
			return($this->error);
		if(IsSet($definition["FILENAME"]))
		{
			$size=@filesize($definition["FILENAME"]);
			if(!($file=@fopen($definition["FILENAME"],"rb")))
				return($this->OutputPHPError("could not open data file ".$definition["FILENAME"], $php_errormsg));
			for($body="";!feof($file);)
			{
				if(GetType($block=@fread($file,$this->file_buffer_length))!="string")
				{
					$this->OutputPHPError("could not read data file", $php_errormsg);
					fclose($file);
					return("");
				}
				$body.=$block;
			}
			fclose($file);
			if(GetType($size)=="integer"
			&& strlen($body)!=$size)
			{
				$this->OutputError("the length of the file that was read does not match the size of the part file ".$definition["FILENAME"]." due to possible data corruption");
				return("");
			}
			if(function_exists("ini_get")
			&& ini_get("magic_quotes_runtime"))
				$body=StripSlashes($body);
			$body=chunk_split(base64_encode($body));
		}
		else
		{
			if(!IsSet($definition["DATA"]))
			{
				$this->OutputError("it was not specified a file or data block");
				return("");
			}
			$body=chunk_split(base64_encode($definition["DATA"]));
		}
		return("data:".$definition["Content-Type"].";base64,".$body);
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

/*
{metadocument}
	<function>
		<name>Send</name>
		<type>STRING</type>
		<documentation>
			<purpose>Send a composed message.</purpose>
			<usage>Use this function after you have set the necessary message
				headers and added the message body parts.</usage>
			<returnvalue>An error message in case there was an error or an empty
				string otherwise. This return value may be safely ignored if the
				function parameters are set correctly.</returnvalue>
		</documentation>
		<do>
{/metadocument}
*/
	Function Send()
	{
		if(strlen($this->error))
			return($this->error);
		$headers=$this->headers;
		if(strcmp($this->mailer,""))
		{
			$headers["X-Mailer"]=$this->mailer;
			if(strlen($this->mailer_delivery))
				$headers["X-Mailer"].=' ('.$this->mailer_delivery.')';
		}
		$headers["MIME-Version"]="1.0";
		if($this->body_parts==0)
			return($this->OutputError("message has no body parts"));
		if(strlen($error=$this->GetPartHeaders($headers,$this->body)))
			return($error);
		if($this->cache_body
		&& IsSet($this->body_cache[$this->body]))
			$body=$this->body_cache[$this->body];
		else
		{
			if(strlen($error=$this->GetPartBody($body,$this->body)))
				return($error);
			if($this->cache_body)
				$this->body_cache[$this->body]=$body;
		}
		if(strcmp($error=$this->StartSendingMessage(),""))
			return($error);
		if(strlen($error=$this->SendMessageHeaders($headers))==0
		&& strlen($error=$this->SendMessageBody($body))==0)
			$error=$this->EndSendingMessage();
		$this->StopSendingMessage();
		return($error);
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

/*
{metadocument}
	<function>
		<name>Mail</name>
		<type>BOOLEAN</type>
		<documentation>
			<purpose>Emulate the PHP <tt>mail()</tt> function by composing and
				sending a message given the same arguments.<paragraphbreak />
				This is mostly meant to provide a solution for sending messages
				with alternative delivery methods provided by this class
				sub-classes. It uses the same arguments as the PHP <tt>mail()</tt>
				function. Developers willing to use this alternative do not need to
				change much their scripts that already use the <tt>mail()</tt>
				function.</purpose>
			<usage>Use this function passing the same arguments as to PHP
				<tt><link>
					<data>mail()</data>
					<url>http://www.php.net/manual/en/function.mail.php</url>
				</link></tt> function.</usage>
			<returnvalue>If this function succeeds, it returns
				<tt><booleanvalue>1</booleanvalue></tt>.</returnvalue>
		</documentation>
		<argument>
			<name>to</name>
			<type>STRING</type>
			<documentation>
				<purpose>Recipient e-mail address.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>subject</name>
			<type>STRING</type>
			<documentation>
				<purpose>Message subject.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>message</name>
			<type>STRING</type>
			<documentation>
				<purpose>Message body.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>additional_headers</name>
			<type>STRING</type>
			<defaultvalue></defaultvalue>
			<documentation>
				<purpose>Text string headers and the respective values. There
					should be one header and value per line with line breaks
					separating each line.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>additional_parameters</name>
			<type>STRING</type>
			<defaultvalue></defaultvalue>
			<documentation>
				<purpose>Text string with additional parameters. In the original
					PHP <tt>mail()</tt> function these were actual switches to be
					passed in the sendmail program invocation command line. This
					function only supports the <tt>-f</tt> switch followed by an
					e-mail address meant to specify the message bounce return path
					address.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function Mail($to, $subject, $message, $additional_headers="", $additional_parameters="")
	{
		$this->ResetMessage();
		$this->headers=array("To"=>$to,"Subject"=>$subject);
		$content_type="";
		while(strlen($additional_headers))
		{
			ereg("([^\r\n]+)(\r?\n)?(.*)\$",$additional_headers,$matches);
			$header=$matches[1];
			$additional_headers=$matches[3];
			if(!ereg("^([^:]+):[ \t]+(.+)\$",$header,$matches))
			{
				$this->error="invalid header \"$header\"";
				return(0);
			}
			if(strtolower($matches[1])=="content-type")
			{
				if(strlen($content_type))
				{
					$this->error="the content-type header was specified more than once.";
					return(0);
				}
				$content_type=$matches[2];
			}
			else
				$this->SetHeader($matches[1],$matches[2]);
		}
		if(strlen($additional_parameters))
		{
			if(ereg("^[ \t]*-f[ \t]*([^@]+@[^ \t]+)[ \t]*(.*)\$"/*"^[ \t]?-f([^@]@[^ \t]+)[ \t]?(.*)\$"*/,$additional_parameters,$matches))
			{
				if(!eregi($this->email_regular_expression,$matches[1]))
				{
					$this->error="it was specified an invalid e-mail address for the additional parameter -f";
					return(0);
				}
				if(strlen($matches[2]))
				{
					$this->error="it were specified some additional parameters after -f e-mail address parameter that are not supported";
					return(0);
				}
				$this->SetHeader("Return-Path",$matches[1]);
			}
			else
			{
				$this->error="the additional parameters that were specified are not supported";
				return(0);
			}
		}
		if(strlen($content_type)==0)
			$content_type="text/plain";
		$definition=array(
			"Content-Type"=>$content_type,
			"DATA"=>$message
		);
		$this->CreateAndAddPart($definition);
		$this->Send();
		return(strlen($this->error)==0);
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

	Function ChangeBulkMail($on)
	{
		return(1);
	}

/*
{metadocument}
	<function>
		<name>SetBulkMail</name>
		<type>BOOLEAN</type>
		<documentation>
			<purpose>Hint the class to adjust itself in order to send individual
				messages to many recipients more efficiently.</purpose>
			<usage>Call this function before starting sending messages to many
				recipients passing <booleanvalue>1</booleanvalue> to the
				<argumentlink>
					<function>SetBulkMail</function>
					<argument>on</argument>
				</argumentlink> argument. Then call this function again after the
				bulk mailing delivery has ended passing passing
				<booleanvalue>1</booleanvalue> to the <argumentlink>
					<function>SetBulkMail</function>
					<argument>on</argument>
				</argumentlink> argument.</usage>
			<returnvalue>If this function succeeds, it returns
				<tt><booleanvalue>1</booleanvalue></tt>.</returnvalue>
		</documentation>
		<argument>
			<name>on</name>
			<type>BOOLEAN</type>
			<documentation>
				<purpose>Boolean flag that indicates whether a bulk delivery is
					going to start if set to <booleanvalue>1</booleanvalue> or that
					the bulk delivery has ended if set to
					<booleanvalue>0</booleanvalue>.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function SetBulkMail($on)
	{
		if(strlen($this->error))
			return(0);
		if(!$this->bulk_mail==!$on)
			return(1);
		if(!$this->ChangeBulkMail($on))
			return(0);
		$this->bulk_mail=!!$on;
		return(1);
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

	Function OpenMailing(&$mailing,&$mailing_properties)
	{
		if(strlen($this->error))
			return($this->error);
		if(!IsSet($mailing_properties["Name"])
		|| strlen($mailing_properties["Name"])==0)
			return($this->OutputError("it was not specified a valid mailing Name"));
		if(!IsSet($mailing_properties["Return-Path"])
		|| strlen($mailing_properties["Return-Path"])==0)
			return($this->OutputError("it was not specified a valid mailing Return-Path"));
		$separator="";
		$directory_separator=(defined("DIRECTORY_SEPARATOR") ? DIRECTORY_SEPARATOR : ((defined("PHP_OS") && !strcmp(substr(PHP_OS,0,3),"WIN")) ? "\\" : "/"));
		$length=strlen($this->mailing_path);
		if($length)
		{
			if($this->mailing_path[$length-1]!=$directory_separator)
				$separator=$directory_separator;
		}
		$base_path=$this->mailing_path.$separator.$mailing_properties["Name"];
		if($this->body_parts==0)
			return($this->OutputError("message has no body parts"));
		$line_break="\n";
		$headers=$this->headers;
		if(strlen($this->mailer))
			$headers["X-Mailer"]=$this->mailer;
		$headers["MIME-Version"]="1.0";
		if(strlen($error=$this->GetPartHeaders($headers,$this->body)))
			return($error);
		if(!($header_file=@fopen($base_path.".h","wb")))
			return($this->OutputPHPError("could not open mailing headers file ".$base_path.".h", $php_errormsg));
		for($header=0,Reset($headers);$header<count($headers);Next($headers),$header++)
		{
			$header_name=Key($headers);
			if(!@fwrite($header_file,$header_name.": ".$headers[$header_name].$line_break))
			{
				fclose($header_file);
				return($this->OutputPHPError("could not write to the mailing headers file ".$base_path.".h", $php_errormsg));
			}
		}
		if(!@fflush($header_file))
		{
			fclose($header_file);
			@unlink($base_path.".h");
			return($this->OutputPHPError("could not write to the mailing headers file ".$base_path.".h", $php_errormsg));
		}
		fclose($header_file);
		if(strlen($error=$this->GetPartBody($body,$this->body)))
		{
			@unlink($base_path.".h");
			return($error);
		}
		if(!($body_file=@fopen($base_path.".b","wb")))
		{
			@unlink($base_path.".h");
			return($this->OutputPHPError("could not open mailing body file ".$base_path.".b", $php_errormsg));
		}
		if(!@fwrite($body_file,$body)
		|| !@fflush($body_file))
		{
			fclose($body_file);
			@unlink($base_path.".b");
			@unlink($base_path.".h");
			return($this->OutputPHPError("could not write to the mailing body file ".$base_path.".b", $php_errormsg));
		}
		fclose($body_file);
		if(!($envelope=@fopen($base_path.".e","wb")))
		{
			@unlink($base_path.".b");
			@unlink($base_path.".h");
			return($this->OutputPHPError("could not open mailing envelope file ".$base_path.".e", $php_errormsg));
		}
		if(!@fwrite($envelope,"F".$mailing_properties["Return-Path"].chr(0))
		|| !@fflush($envelope))
		{
			@fclose($envelope);
			@unlink($base_path.".e");
			@unlink($base_path.".b");
			@unlink($base_path.".h");
			return($this->OutputPHPError("could not write to the return path to the mailing envelope file ".$base_path.".e", $php_errormsg));
		}
		$mailing=++$this->last_mailing;
		$this->mailings[$mailing]=array(
			"Envelope"=>$envelope,
			"BasePath"=>$base_path
		);
		return("");
	}

	Function AddMailingRecipient($mailing,&$recipient_properties)
	{
		if(strlen($this->error))
			return($this->error);
		if(!IsSet($this->mailings[$mailing]))
			return($this->OutputError("it was not specified a valid mailing"));
		if(!IsSet($recipient_properties["Address"])
		|| strlen($recipient_properties["Address"])==0)
			return($this->OutputError("it was not specified a valid mailing recipient Address"));
		if(!@fwrite($this->mailings[$mailing]["Envelope"],"T".$recipient_properties["Address"].chr(0)))
			return($this->OutputPHPError("could not write recipient address to the mailing envelope file", $php_errormsg));
		return("");
	}

	Function EndMailing($mailing)
	{
		if(strlen($this->error))
			return($this->error);
		if(!IsSet($this->mailings[$mailing]))
			return($this->OutputError("it was not specified a valid mailing"));
		if(!IsSet($this->mailings[$mailing]["Envelope"]))
			return($this->OutputError("the mailing was already ended"));
		if(!@fwrite($this->mailings[$mailing]["Envelope"],chr(0))
		|| !@fflush($this->mailings[$mailing]["Envelope"]))
			return($this->OutputPHPError("could not end writing to the mailing envelope file", $php_errormsg));
		fclose($this->mailings[$mailing]["Envelope"]);
		Unset($this->mailings[$mailing]["Envelope"]);
		return("");
	}

	Function SendMailing($mailing)
	{
		if(strlen($this->error))
			return($this->error);
		if(!IsSet($this->mailings[$mailing]))
			return($this->OutputError("it was not specified a valid mailing"));
		if(IsSet($this->mailings[$mailing]["Envelope"]))
			return($this->OutputError("the mailing was not yet ended"));
		$this->ResetMessage();
		$base_path=$this->mailings[$mailing]["BasePath"];
		if(GetType($header_lines=@File($base_path.".h"))!="array")
			return($this->OutputPHPError("could not read the mailing headers file ".$base_path.".h", $php_errormsg));
		for($line=0;$line<count($header_lines);$line++)
		{
			$header_name=$this->Tokenize($header_lines[$line],": ");
			$this->headers[$header_name]=trim($this->Tokenize("\n"));
		}
		if(!($envelope_file=@fopen($base_path.".e","rb")))
			return($this->OutputPHPError("could not open the mailing envelope file ".$base_path.".e", $php_errormsg));
		for($bcc=$data="",$position=0;!feof($envelope_file) || strlen($data);)
		{
			if(GetType($break=strpos($data,chr(0),$position))!="integer")
			{
				if(GetType($chunk=@fread($envelope_file,$this->file_buffer_length))!="string")
				{
					fclose($envelope_file);
					return($this->OutputPHPError("could not read the mailing envelop file ".$base_path.".e", $php_errormsg));
				}
				$data=substr($data,$position).$chunk;
				$position=0;
				continue;
			}
			if($break==$position)
				break;
			switch($data[$position])
			{
				case "F":
					$this->headers["Return-Path"]=substr($data,$position+1,$break-$position-1);
					break;
				case "T":
					$bcc.=(strlen($bcc)==0 ? "" : ", ").substr($data,$position+1,$break-$position-1);
					break;
				default:
					return($this->OutputError("invalid mailing envelope file ".$base_path.".e"));
			}
			$position=$break+1;
		}
		fclose($envelope_file);
		if(strlen($bcc)==0)
			return($this->OutputError("the mailing envelop file ".$base_path.".e does not contain any recipients"));
		$this->headers["Bcc"]=$bcc;
		if(!($body_file=@fopen($base_path.".b","rb")))
			return($this->OutputPHPError("could not open the mailing body file ".$base_path.".b", $php_errormsg));
		for($data="";!feof($body_file);)
		{
			if(GetType($chunk=@fread($body_file,$this->file_buffer_length))!="string")
			{
				fclose($body_file);
				return($this->OutputPHPError("could not read the mailing body file ".$base_path.".b", $php_errormsg));
			}
			$data.=$chunk;
		}
		fclose($body_file);
		if(strlen($error=$this->StartSendingMessage()))
			return($error);
		if(strlen($error=$this->SendMessageHeaders($this->headers))==0
		&& strlen($error=$this->SendMessageBody($data))==0)
			$error=$this->EndSendingMessage();
		$this->StopSendingMessage();
		return($error);
	}
};

/*

{metadocument}
</class>
{/metadocument}

*/





















/*
 * smtp_message.php
 *
 * @(#) $Header: /cvsroot/tellmatic/tellmatic/include/Class_SMTP.inc.php,v 1.1.1.1 2007/11/21 22:58:32 mcms09 Exp $
 *
 *
 */

/*
{metadocument}<?xml version="1.0" encoding="ISO-8859-1"?>
<class>

	<package>net.manuellemos.mimemessage</package>

	<name>smtp_message_class</name>
	<version>@(#) $Id: Class_SMTP.inc.php,v 1.1.1.1 2007/11/21 22:58:32 mcms09 Exp $</version>
	<copyright>Copyright © (C) Manuel Lemos 1999-2004</copyright>
	<title>MIME E-mail message composing and sending via SMTP</title>
	<author>Manuel Lemos</author>
	<authoraddress>mlemos-at-acm.org</authoraddress>

	<documentation>
		<idiom>en</idiom>
		<purpose>Implement an alternative message delivery method via SMTP
			protocol, overriding the method of using the PHP <tt>mail()</tt>
			function implemented by the base class.</purpose>
		<usage>This class should be used exactly the same way as the base
			class for composing and sending messages. Just create a new object of
			this class as follows and set only the necessary variables to
			configure details of the SMTP delivery.<paragraphbreak />
			<tt>require('email_message.php');<br />
			require('smtp.php');<br />
			require('smtp_message.php');<br />
			<br />
			$message_object = new smtp_message_class;<br /></tt><paragraphbreak />
			<b>- Requirements</b><paragraphbreak />
			You need the <link>
				<data>SMTP E-mail sending class</data>
				<url>http://freshmeat.net/projects/smtpclass/</url>
			</link> to perform the actual message delivery via the SMTP
			protocol.<paragraphbreak />
			<b>- SMTP connection</b><paragraphbreak />
			Before sending a message by relaying it to a given SMTP server you
			need set the <variablelink>smtp_host</variablelink> variable to that
			server address. The <variablelink>localhost</variablelink> variable
			needs to be set to the sending computer address.<paragraphbreak />
			You may also adjust the time the class will wait for establishing
			a connection by changing the <variablelink>timeout</variablelink>
			variable.<paragraphbreak />
			<b>- Authentication</b><paragraphbreak />
			Most servers only allow relaying messages sent by authorized
			users. If the SMTP server that you want to use requires
			authentication, you need to set the variables
			<variablelink>smtp_user</variablelink>,
			<variablelink>smtp_realm</variablelink> and
			<variablelink>smtp_password</variablelink>.<paragraphbreak />
			The way these values need to be set depends on the server. Usually
			the realm value is empty and only the user and password need to be
			set. If the server requires authentication via <tt>NTLM</tt>
			mechanism (Windows or Samba), you need to set the
			<variablelink>smtp_realm</variablelink> to the Windows domain name
			and also set the variable
			<variablelink>smtp_workstation</variablelink> to the user workstation
			name.<paragraphbreak />
			Some servers require that the authentication be done on a separate
			server using the POP3 protocol before connecting to the SMTP server.
			In this case you need to specify the address of the POP3 server
			setting the <variablelink>smtp_pop3_auth_host</variablelink>
			variable.<paragraphbreak />
			<b>- Sending urgent messages with direct delivery</b><paragraphbreak />
			If you need to send urgent messages or obtain immediate confirmation
			that a message is accepted by the recipient SMTP server, you can use
			the direct delivery mode setting the
			<variablelink>direct_delivery</variablelink> variable to
			<tt><booleanvalue>1</booleanvalue></tt>. This mode can be used to
			send a message to only one recipient.<paragraphbreak />
			To use this mode, it is necessary to have a way to determine the
			recipient domain SMTP server address. The class uses the PHP
			<tt>getmxrr()</tt> function, but on some systems like for instance
			under Windows, this function does not work. In this case you may
			specify an equivalent alternative by setting the
			<variablelink>smtp_getmxrr</variablelink> variable. See the SMTP
			class page for available alternatives.<paragraphbreak />
			<b>- Troubleshooting and debugging</b><paragraphbreak />
			If for some reason the delivery via SMTP is not working and the error
			messages are not self-explanatory, you may set the
			<variablelink>smtp_debug</variablelink> to
			<tt><booleanvalue>1</booleanvalue></tt> to make the class output the
			SMTP protocol dialog with the server. If you want to display this
			dialog properly formatted in an HTML page, also set the
			<variablelink>smtp_debug</variablelink> to
			<tt><booleanvalue>1</booleanvalue></tt>.<paragraphbreak />
			<b>- Optimizing the delivery of messages to many recipients</b><paragraphbreak />
			When sending messages to many recipients, this class can hinted to
			optimize its behavior by using the
			<functionlink>SetBulkMail</functionlink> function. After calling this
			function passing <booleanvalue>1</booleanvalue> to the <argumentlink>
				<function>SetBulkMail</function>
				<argument>on</argument>
			</argumentlink> argument, when the message is sent this class opens
			a TCP connection to the SMTP server but will not close it. This
			avoids the overhead of opening and closing connections.<paragraphbreak />
			When the delivery of the messages to all recipients is done, the
			connection may be closed implicitly by calling the
			<functionlink>SetBulkMail</functionlink> function again passing
			<booleanvalue>0</booleanvalue> to the <argumentlink>
				<function>SetBulkMail</function>
				<argument>on</argument>
			</argumentlink> argument.</usage>
	</documentation>

{/metadocument}
*/

class smtp_message_class extends email_message_class
{
	/* Private variables */

	var $smtp;
	var $line_break="\r\n";

	/* Public variables */

/*
{metadocument}
	<variable>
		<name>localhost</name>
		<type>STRING</type>
		<value></value>
		<documentation>
			<purpose>Specify the domain name of the computer sending the
				message.</purpose>
			<usage>This value is used to identify the sending machine to the
				SMTP server.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $localhost="";

/*
{metadocument}
	<variable>
		<name>smtp_host</name>
		<type>STRING</type>
		<value></value>
		<documentation>
			<purpose>Specify the address of the SMTP server.</purpose>
			<usage>Set to the address of the SMTP server that will relay the
				messages. This variable is not used in direct delivery mode.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $smtp_host="localhost";

/*
{metadocument}
	<variable>
		<name>smtp_port</name>
		<type>INTEGER</type>
		<value>25</value>
		<documentation>
			<purpose>Specify the TCP/IP port of SMTP server to connect.</purpose>
			<usage>Most servers work on port 25 . You should not need to change
				this variable.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $smtp_port=25;

/*
{metadocument}
	<variable>
		<name>smtp_direct_delivery</name>
		<type>BOOLEAN</type>
		<value>0</value>
		<documentation>
			<purpose>Boolean flag that indicates whether the message should be
				sent in direct delivery mode.</purpose>
			<usage>Set this to <tt><booleanvalue>1</booleanvalue></tt> if you
				want to send urgent messages directly to the recipient domain SMTP
				server.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $smtp_direct_delivery=0;

/*
{metadocument}
	<variable>
		<name>smtp_getmxrr</name>
		<type>STRING</type>
		<value>getmxrr</value>
		<documentation>
			<purpose>Specify the name of the function that is called to determine
				the SMTP server address of a given domain.</purpose>
			<usage>Change this to a working replacement of the PHP
				<tt>getmxrr()</tt> function if this is not working in your system
					and you want to send messages in direct delivery mode.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $smtp_getmxrr="getmxrr";

/*
{metadocument}
	<variable>
		<name>smtp_exclude_address</name>
		<type>STRING</type>
		<value></value>
		<documentation>
			<purpose>Specify an address that should be considered invalid
				when resolving host name addresses.</purpose>
			<usage>In some networks any domain name that does not exist is
				resolved as a sub-domain of the default local domain. If the DNS is
				configured in such way that it always resolves any sub-domain of
				the default local domain to a given address, it is hard to
				determine whether a given domain does not exist.<paragraphbreak />
				If your network is configured this way, you may set this variable
				to the address that all sub-domains of the default local domain
				resolves, so the class can assume that such address is invalid.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $smtp_exclude_address="";

/*
{metadocument}
	<variable>
		<name>smtp_user</name>
		<type>STRING</type>
		<value></value>
		<documentation>
			<purpose>Specify the user name for authentication.</purpose>
			<usage>Set this variable if you need to authenticate before sending
				a message.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $smtp_user="";

/*
{metadocument}
	<variable>
		<name>smtp_realm</name>
		<type>STRING</type>
		<value></value>
		<documentation>
			<purpose>Specify the user authentication realm.</purpose>
			<usage>Set this variable if you need to authenticate before sending
				a message.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $smtp_realm="";

/*
{metadocument}
	<variable>
		<name>smtp_workstation</name>
		<type>STRING</type>
		<value></value>
		<documentation>
			<purpose>Specify the user authentication workstation needed when
				using the <tt>NTLM</tt> authentication (Windows or Samba).</purpose>
			<usage>Set this variable if you need to authenticate before sending
				a message.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $smtp_workstation="";

/*
{metadocument}
	<variable>
		<name>smtp_password</name>
		<type>STRING</type>
		<value></value>
		<documentation>
			<purpose>Specify the user authentication password.</purpose>
			<usage>Set this variable if you need to authenticate before sending
				a message.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $smtp_password="";

/*
{metadocument}
	<variable>
		<name>smtp_pop3_auth_host</name>
		<type>STRING</type>
		<value></value>
		<documentation>
			<purpose>Specify the server address for POP3 based authentication.</purpose>
			<usage>Set this variable to the address of the POP3 server if the
				SMTP server requires POP3 based authentication.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $smtp_pop3_auth_host="";

/*
{metadocument}
	<variable>
		<name>smtp_debug</name>
		<type>BOOLEAN</type>
		<value>0</value>
		<documentation>
			<purpose>Specify whether it is necessary to output SMTP connection
				debug information.</purpose>
			<usage>Set this variable to
				<tt><booleanvalue>1</booleanvalue></tt> if you need to see
				the progress of the SMTP connection and protocol dialog when you
				need to understand the reason for delivery problems.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $smtp_debug=0;

/*
{metadocument}
	<variable>
		<name>smtp_html_debug</name>
		<type>BOOLEAN</type>
		<value>0</value>
		<documentation>
			<purpose>Specify whether the debug information should be outputted in
				HTML format.</purpose>
			<usage>Set this variable to
				<tt><booleanvalue>1</booleanvalue></tt> if you need to see
				the debug output in a Web page.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $smtp_html_debug=0;

/*
{metadocument}
	<variable>
		<name>esmtp</name>
		<type>BOOLEAN</type>
		<value>1</value>
		<documentation>
			<purpose>Specify whether the class should try to use Enhanced SMTP
				protocol features.</purpose>
			<usage>It is recommended to leave this variable set to
				<tt><booleanvalue>1</booleanvalue></tt> so the class can take
				advantage of Enhanced SMTP protocol features.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $esmtp=1;

/*
{metadocument}
	<variable>
		<name>timeout</name>
		<type>INTEGER</type>
		<value>25</value>
		<documentation>
			<purpose>Specify the connection timeout period in seconds.</purpose>
			<usage>Change this value if for some reason the timeout period seems
				insufficient or otherwise it seems too long.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $timeout=25;

/*
{metadocument}
	<variable>
		<name>invalid_recipients</name>
		<type>ARRAY</type>
		<value></value>
		<documentation>
			<purpose>Return the list of recipient addresses that were not
				accepted by the SMTP server.</purpose>
			<usage>Check this variable after attempting to send a message to
				figure whether there were any recipients that were rejected by the
				SMTP server.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $invalid_recipients=array();

/*
{metadocument}
	<variable>
		<name>mailer_delivery</name>
		<value>smtp $Revision: 1.1.1.1 $</value>
		<documentation>
			<purpose>Specify the text that is used to identify the mail
				delivery class or sub-class. This text is appended to the
				<tt>X-Mailer</tt> header text defined by the
				mailer variable.</purpose>
			<usage>Do not change this variable.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $mailer_delivery='smtp $Revision: 1.1.1.1 $';

	Function SetRecipients(&$recipients,&$valid_recipients)
	{
		for($valid_recipients=$recipient=0,Reset($recipients);$recipient<count($recipients);Next($recipients),$recipient++)
		{
			$address=Key($recipients);
			if($this->smtp->SetRecipient($address))
				$valid_recipients++;
			else
				$this->invalid_recipients[$address]=$this->smtp->error;
		}
		return(1);
	}

	Function StartSendingMessage()
	{
		if(function_exists("class_exists")
		&& !class_exists("smtp_class"))
			return("the smtp_class class was not included");
		if(IsSet($this->smtp))
			return("");
		$this->smtp=new smtp_class;
		$this->smtp->localhost=$this->localhost;
		$this->smtp->host_name=$this->smtp_host;
		$this->smtp->host_port=$this->smtp_port;
		$this->smtp->timeout=$this->timeout;
		$this->smtp->debug=$this->smtp_debug;
		$this->smtp->html_debug=$this->smtp_html_debug;
		$this->smtp->direct_delivery=$this->smtp_direct_delivery;
		$this->smtp->getmxrr=$this->smtp_getmxrr;
		$this->smtp->exclude_address=$this->smtp_exclude_address;
		$this->smtp->pop3_auth_host=$this->smtp_pop3_auth_host;
		$this->smtp->user=$this->smtp_user;
		$this->smtp->realm=$this->smtp_realm;
		$this->smtp->workstation=$this->smtp_workstation;
		$this->smtp->password=$this->smtp_password;
		$this->smtp->esmtp=$this->esmtp;
		if($this->smtp->Connect())
			return("");
		$error=$this->smtp->error;
		UnSet($this->smtp);
		return($this->OutputError($error));
	}

	Function SendMessageHeaders($headers)
	{
		for($header_data="",$message_id_set=$date_set=0,$header=0,$return_path=$from=$to=$recipients=array(),Reset($headers);$header<count($headers);$header++,Next($headers))
		{
			$header_name=Key($headers);
			switch(strtolower($header_name))
			{
				case "return-path":
					$return_path[$headers[$header_name]]=1;
					break;
				case "from":
					$error=$this->GetRFC822Addresses($headers[$header_name],$from);
					break;
				case "to":
					$error=$this->GetRFC822Addresses($headers[$header_name],$to);
					break;
				case "cc":
				case "bcc":
					$this->GetRFC822Addresses($headers[$header_name],$recipients);
					break;
				case "date":
					$date_set=1;
					break;
				case "message-id":
					$message_id_set=1;
					break;
			}
			if(strcmp($error,""))
				return($this->OutputError($error));
			if(strtolower($header_name)=="bcc")
				continue;
			$header_data.=$this->FormatHeader($header_name,$headers[$header_name])."\r\n";
		}
		if(count($from)==0)
			return($this->OutputError("it was not specified a valid From header"));
		if(count($to)==0)
			return($this->OutputError("it was not specified a valid To header"));
		Reset($return_path);
		Reset($from);
		$this->invalid_recipients=array();
		if(!$this->smtp->MailFrom(count($return_path) ? Key($return_path) : Key($from))
		|| !$this->SetRecipients($to,$valid_recipients))
			return($this->OutputError($this->smtp->error));
		if($valid_recipients==0)
			return($this->OutputError("it were not specified any valid recipients"));
		if(!$date_set)
			$header_data.="Date: ".strftime("%a, %d %b %Y %H:%M:%S %Z")."\r\n";
		if(!$message_id_set
		&& $this->auto_message_id)
		{
			$sender=(count($return_path) ? Key($return_path) : Key($from));
			$header_data.=$this->GenerateMessageID($sender)."\r\n";
		}
		if(!$this->SetRecipients($recipients,$valid_recipients)
		|| !$this->smtp->StartData()
		|| !$this->smtp->SendData("$header_data\r\n"))
			return($this->OutputError($this->smtp->error));
		return("");
	}

	Function SendMessageBody($data)
	{
		$this->smtp->PrepareData($data,$output);
		return($this->smtp->SendData($output) ? "" : $this->OutputError($this->smtp->error));
	}

	Function EndSendingMessage()
	{
		return($this->smtp->EndSendingData() ? "" : $this->OutputError($this->smtp->error));
	}

	Function StopSendingMessage()
	{
		if($this->bulk_mail
		&& !$this->smtp_direct_delivery)
			return("");
		$error=($this->smtp->Disconnect() ? "" : $this->OutputError($this->smtp->error));
		UnSet($this->smtp);
		return($error);
	}

	Function ChangeBulkMail($on)
	{
		if($on
		|| !IsSet($this->smtp))
			return(1);
		$error=($this->smtp->Disconnect() ? "" : $this->OutputError($this->smtp->error));
		UnSet($this->smtp);
		return(strlen($error)==0);
	}
};

/*

{metadocument}
</class>
{/metadocument}

*/




































/*
 * smtp.php
 *
 * @(#) $Header: /cvsroot/tellmatic/tellmatic/include/Class_SMTP.inc.php,v 1.1.1.1 2007/11/21 22:58:32 mcms09 Exp $
 *
 */

class smtp_class
{
	var $user="";
	var $realm="";
	var $password="";
	var $workstation="";
	var $authentication_mechanism="";
	var $host_name="";
	var $host_port=25;
	var $localhost="";
	var $timeout=0;
	var $data_timeout=0;
	var $direct_delivery=0;
	var $error="";
	var $debug=0;
	var $html_debug=0;
	var $esmtp=1;
	var $esmtp_host="";
	var $esmtp_extensions=array();
	var $maximum_piped_recipients=100;
	var $exclude_address="";
	var $getmxrr="GetMXRR";
	var $pop3_auth_host="";
	var $pop3_auth_port=110;

	/* private variables - DO NOT ACCESS */

	var $state="Disconnected";
	var $connection=0;
	var $pending_recipients=0;
	var $next_token="";
	var $direct_sender="";
	var $connected_domain="";
	var $result_code;

	/* Private methods - DO NOT CALL */

	Function Tokenize($string,$separator="")
	{
		if(!strcmp($separator,""))
		{
			$separator=$string;
			$string=$this->next_token;
		}
		for($character=0;$character<strlen($separator);$character++)
		{
			if(GetType($position=strpos($string,$separator[$character]))=="integer")
				$found=(IsSet($found) ? min($found,$position) : $position);
		}
		if(IsSet($found))
		{
			$this->next_token=substr($string,$found+1);
			return(substr($string,0,$found));
		}
		else
		{
			$this->next_token="";
			return($string);
		}
	}

	Function OutputDebug($message)
	{
		$message.="\n";
		if($this->html_debug)
			$message=str_replace("\n","<br />\n",HtmlEntities($message));
		echo $message;
		flush();
	}

	Function SetDataAccessError($error)
	{
		$this->error=$error;
		if(function_exists("socket_get_status"))
		{
			$status=socket_get_status($this->connection);
			if($status["timed_out"])
				$this->error.=": data access time out";
			elseif($status["eof"])
				$this->error.=": the server disconnected";
		}
	}

	Function GetLine()
	{
		for($line="";;)
		{
			if(feof($this->connection))
			{
				$this->error="reached the end of data while reading from the SMTP server conection";
				return("");
			}
			if(GetType($data=fgets($this->connection,100))!="string"
			|| strlen($data)==0)
			{
				$this->SetDataAccessError("it was not possible to read line from the SMTP server");
				return("");
			}
			$line.=$data;
			$length=strlen($line);
			if($length>=2
			&& substr($line,$length-2,2)=="\r\n")
			{
				$line=substr($line,0,$length-2);
				if($this->debug)
					$this->OutputDebug("S $line");
				return($line);
			}
		}
	}

	Function PutLine($line)
	{
		if($this->debug)
			$this->OutputDebug("C $line");
		if(!fputs($this->connection,"$line\r\n"))
		{
			$this->SetDataAccessError("it was not possible to send a line to the SMTP server");
			return(0);
		}
		return(1);
	}

	Function PutData(&$data)
	{
		if(strlen($data))
		{
			if($this->debug)
				$this->OutputDebug("C $data");
			if(!fputs($this->connection,$data))
			{
				$this->SetDataAccessError("it was not possible to send data to the SMTP server");
				return(0);
			}
		}
		return(1);
	}

	Function VerifyResultLines($code,&$responses)
	{
		$responses=array();
		Unset($this->result_code);
		while(strlen($line=$this->GetLine($this->connection)))
		{
			if(IsSet($this->result_code))
			{
				if(strcmp($this->Tokenize($line," -"),$this->result_code))
				{
					$this->error=$line;
					return(0);
				}
			}
			else
			{
				$this->result_code=$this->Tokenize($line," -");
				if(GetType($code)=="array")
				{
					for($codes=0;$codes<count($code) && strcmp($this->result_code,$code[$codes]);$codes++);
					if($codes>=count($code))
					{
						$this->error=$line;
						return(0);
					}
				}
				else
				{
					if(strcmp($this->result_code,$code))
					{
						$this->error=$line;
						return(0);
					}
				}
			}
			$responses[]=$this->Tokenize("");
			if(!strcmp($this->result_code,$this->Tokenize($line," ")))
				return(1);
		}
		return(-1);
	}

	Function FlushRecipients()
	{
		if($this->pending_sender)
		{
			if($this->VerifyResultLines("250",$responses)<=0)
				return(0);
			$this->pending_sender=0;
		}
		for(;$this->pending_recipients;$this->pending_recipients--)
		{
			if($this->VerifyResultLines(array("250","251"),$responses)<=0)
				return(0);
		}
		return(1);
	}

	Function ConnectToHost($domain, $port, $resolve_message)
	{
		if(ereg('^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$',$domain))
			$ip=$domain;
		else
		{
			if($this->debug)
				$this->OutputDebug($resolve_message);
			if(!strcmp($ip=@gethostbyname($domain),$domain))
				return("could not resolve host \"".$domain."\"");
		}
		if(strlen($this->exclude_address)
		&& !strcmp(@gethostbyname($this->exclude_address),$ip))
			return("domain \"".$domain."\" resolved to an address excluded to be valid");
		if($this->debug)
			$this->OutputDebug("Connecting to host address \"".$ip."\"...");
		if(($this->connection=($this->timeout ? @fsockopen($ip,$port,$errno,$error,$this->timeout) : @fsockopen($ip,$port))))
			return("");
		$error=($this->timeout ? strval($error) : "??");
		switch($error)
		{
			case "-3":
				return("-3 socket could not be created");
			case "-4":
				return("-4 dns lookup on hostname \"".$domain."\" failed");
			case "-5":
				return("-5 connection refused or timed out");
			case "-6":
				return("-6 fdopen() call failed");
			case "-7":
				return("-7 setvbuf() call failed");
		}
		return("could not connect to the host \"".$domain."\": ".$error);
	}

	Function SASLAuthenticate($mechanisms, $credentials, &$authenticated, &$mechanism)
	{
		$authenticated=0;
		if(!function_exists("class_exists")
		|| !class_exists("sasl_client_class"))
		{
			$this->error="it is not possible to authenticate using the specified mechanism because the SASL library class is not loaded";
			return(0);
		}
		$sasl=new sasl_client_class;
		$sasl->SetCredential("user",$credentials["user"]);
		$sasl->SetCredential("password",$credentials["password"]);
		if(IsSet($credentials["realm"]))
			$sasl->SetCredential("realm",$credentials["realm"]);
		if(IsSet($credentials["workstation"]))
			$sasl->SetCredential("workstation",$credentials["workstation"]);
		if(IsSet($credentials["mode"]))
			$sasl->SetCredential("mode",$credentials["mode"]);
		do
		{
			$status=$sasl->Start($mechanisms,$message,$interactions);
		}
		while($status==SASL_INTERACT);
		switch($status)
		{
			case SASL_CONTINUE:
				break;
			case SASL_NOMECH:
				if(strlen($this->authentication_mechanism))
				{
					$this->error="authenticated mechanism ".$this->authentication_mechanism." may not be used: ".$sasl->error;
					return(0);
				}
				break;
			default:
				$this->error="Could not start the SASL authentication client: ".$sasl->error;
				return(0);
		}
		if(strlen($mechanism=$sasl->mechanism))
		{
			if($this->PutLine("AUTH ".$sasl->mechanism.(IsSet($message) ? " ".base64_encode($message) : ""))==0)
			{
				$this->error="Could not send the AUTH command";
				return(0);
			}
			if(!$this->VerifyResultLines(array("235","334"),$responses))
				return(0);
			switch($this->result_code)
			{
				case "235":
					$response="";
					$authenticated=1;
					break;
				case "334":
					$response=base64_decode($responses[0]);
					break;
				default:
					$this->error="Authentication error: ".$responses[0];
					return(0);
			}
			for(;!$authenticated;)
			{
				do
				{
					$status=$sasl->Step($response,$message,$interactions);
				}
				while($status==SASL_INTERACT);
				switch($status)
				{
					case SASL_CONTINUE:
						if($this->PutLine(base64_encode($message))==0)
						{
							$this->error="Could not send the authentication step message";
							return(0);
						}
						if(!$this->VerifyResultLines(array("235","334"),$responses))
							return(0);
						switch($this->result_code)
						{
							case "235":
								$response="";
								$authenticated=1;
								break;
							case "334":
								$response=base64_decode($responses[0]);
								break;
							default:
								$this->error="Authentication error: ".$responses[0];
								return(0);
						}
						break;
					default:
						$this->error="Could not process the SASL authentication step: ".$sasl->error;
						return(0);
				}
			}
		}
		return(1);
	}

	/* Public methods */

	Function Connect($domain="")
	{
		if(strcmp($this->state,"Disconnected"))
		{
			$this->error="connection is already established";
			return(0);
		}
		$this->error=$error="";
		$this->esmtp_host="";
		$this->esmtp_extensions=array();
		$hosts=array();
		if($this->direct_delivery)
		{
			if(strlen($domain)==0)
				return(1);
			$hosts=$weights=$mxhosts=array();
			$getmxrr=$this->getmxrr;
			if(function_exists($getmxrr)
			&& $getmxrr($domain,$hosts,$weights))
			{
				for($host=0;$host<count($hosts);$host++)
					$mxhosts[$weights[$host]]=$hosts[$host];
				KSort($mxhosts);
				for(Reset($mxhosts),$host=0;$host<count($mxhosts);Next($mxhosts),$host++)
					$hosts[$host]=$mxhosts[Key($mxhosts)];
			}
			else
			{
				if(strcmp(@gethostbyname($domain),$domain)!=0)
					$hosts[]=$domain;
			}
		}
		else
		{
			if(strlen($this->host_name))
				$hosts[]=$this->host_name;
			if(strlen($this->pop3_auth_host))
			{
				$user=$this->user;
				if(strlen($user)==0)
				{
					$this->error="it was not specified the POP3 authentication user";
					return(0);
				}
				$password=$this->password;
				if(strlen($password)==0)
				{
					$this->error="it was not specified the POP3 authentication password";
					return(0);
				}
				$domain=$this->pop3_auth_host;
				$this->error=$this->ConnectToHost($domain, $this->pop3_auth_port, "Resolving POP3 authentication host \"".$domain."\"...");
				if(strlen($this->error))
					return(0);
				if(strlen($response=$this->GetLine())==0)
					return(0);
				if(strcmp($this->Tokenize($response," "),"+OK"))
				{
					$this->error="POP3 authentication server greeting was not found";
					return(0);
				}
				if(!$this->PutLine("USER ".$this->user)
				|| strlen($response=$this->GetLine())==0)
					return(0);
				if(strcmp($this->Tokenize($response," "),"+OK"))
				{
					$this->error="POP3 authentication user was not accepted: ".$this->Tokenize("\r\n");
					return(0);
				}
				if(!$this->PutLine("PASS ".$password)
				|| strlen($response=$this->GetLine())==0)
					return(0);
				if(strcmp($this->Tokenize($response," "),"+OK"))
				{
					$this->error="POP3 authentication password was not accepted: ".$this->Tokenize("\r\n");
					return(0);
				}
				fclose($this->connection);
				$this->connection=0;
			}
		}
		if(count($hosts)==0)
		{
			$this->error="could not determine the SMTP to connect";
			return(0);
		}
		for($host=0, $error="not connected";strlen($error) && $host<count($hosts);$host++)
		{
			$domain=$hosts[$host];
			$error=$this->ConnectToHost($domain, $this->host_port, "Resolving SMTP server domain \"$domain\"...");
		}
		if(strlen($error))
		{
			$this->error=$error;
			return(0);
		}
		$timeout=($this->data_timeout ? $this->data_timeout : $this->timeout);
		if($timeout
		&& function_exists("socket_set_timeout"))
			socket_set_timeout($this->connection,$timeout,0);
		if($this->debug)
			$this->OutputDebug("Connected to SMTP server \"".$domain."\".");
		if(!strcmp($localhost=$this->localhost,"")
		&& !strcmp($localhost=getenv("SERVER_NAME"),"")
		&& !strcmp($localhost=getenv("HOST"),""))
			$localhost="localhost";
		$success=0;
		if($this->VerifyResultLines("220",$responses)>0)
		{
			$fallback=1;
			if($this->esmtp
			|| strlen($this->user))
			{
				if($this->PutLine("EHLO $localhost"))
				{
					if(($success_code=$this->VerifyResultLines("250",$responses))>0)
					{
						$this->esmtp_host=$this->Tokenize($responses[0]," ");
						for($response=1;$response<count($responses);$response++)
						{
							$extension=strtoupper($this->Tokenize($responses[$response]," "));
							$this->esmtp_extensions[$extension]=$this->Tokenize("");
						}
						$success=1;
						$fallback=0;
					}
					else
					{
						if($success_code==0)
						{
							$code=$this->Tokenize($this->error," -");
							switch($code)
							{
								case "421":
									$fallback=0;
									break;
							}
						}
					}
				}
				else
					$fallback=0;
			}
			if($fallback)
			{
				if($this->PutLine("HELO $localhost")
				&& $this->VerifyResultLines("250",$responses)>0)
					$success=1;
			}
			if($success
			&& strlen($this->user)
			&& strlen($this->pop3_auth_host)==0)
			{
				if(!IsSet($this->esmtp_extensions["AUTH"]))
				{
					$this->error="server does not require authentication";
					$success=0;
				}
				else
				{
					if(strlen($this->authentication_mechanism))
						$mechanisms=array($this->authentication_mechanism);
					else
					{
						$mechanisms=array();
						for($authentication=$this->Tokenize($this->esmtp_extensions["AUTH"]," ");strlen($authentication);$authentication=$this->Tokenize(" "))
							$mechanisms[]=$authentication;
					}
					$credentials=array(
						"user"=>$this->user,
						"password"=>$this->password
					);
					if(strlen($this->realm))
						$credentials["realm"]=$this->realm;
					if(strlen($this->workstation))
						$credentials["workstation"]=$this->workstation;
					$success=$this->SASLAuthenticate($mechanisms,$credentials,$authenticated,$mechanism);
					if(!$success
					&& !strcmp($mechanism,"PLAIN"))
					{
						/*
						 * Author:  Russell Robinson, 25 May 2003, http://www.tectite.com/
						 * Purpose: Try various AUTH PLAIN authentication methods.
						 */
						$mechanisms=array("PLAIN");
						$credentials=array(
							"user"=>$this->user,
							"password"=>$this->password
						);
						if(strlen($this->realm))
						{
							/*
							 * According to: http://www.sendmail.org/~ca/email/authrealms.html#authpwcheck_method
							 * some sendmails won't accept the realm, so try again without it
							 */
							$success=$this->SASLAuthenticate($mechanisms,$credentials,$authenticated,$mechanism);
						}
						if(!$success)
						{
							/*
							 * It was seen an EXIM configuration like this:
							 * user^password^unused
							 */
							$credentials["mode"]=SASL_PLAIN_EXIM_DOCUMENTATION_MODE;
							$success=$this->SASLAuthenticate($mechanisms,$credentials,$authenticated,$mechanism);
						}
						if(!$success)
						{
							/*
							 * ... though: http://exim.work.de/exim-html-3.20/doc/html/spec_36.html
							 * specifies: ^user^password
							 */
							$credentials["mode"]=SASL_PLAIN_EXIM_MODE;
							$success=$this->SASLAuthenticate($mechanisms,$credentials,$authenticated,$mechanism);
						}
					}
					if($success
					&& strlen($mechanism)==0)
					{
						$this->error="it is not supported any of the authentication mechanisms required by the server";
						$success=0;
					}
				}
			}
		}
		if($success)
		{
			$this->state="Connected";
			$this->connected_domain=$domain;
		}
		else
		{
			fclose($this->connection);
			$this->connection=0;
		}
		return($success);
	}

	Function MailFrom($sender)
	{
		if($this->direct_delivery)
		{
			switch($this->state)
			{
				case "Disconnected":
					$this->direct_sender=$sender;
					return(1);
				case "Connected":
					$sender=$this->direct_sender;
					break;
				default:
					$this->error="direct delivery connection is already established and sender is already set";
					return(0);
			}
		}
		else
		{
			if(strcmp($this->state,"Connected"))
			{
				$this->error="connection is not in the initial state";
				return(0);
			}
		}
		$this->error="";
		if(!$this->PutLine("MAIL FROM:<$sender>"))
			return(0);
		if(!IsSet($this->esmtp_extensions["PIPELINING"])
		&& $this->VerifyResultLines("250",$responses)<=0)
			return(0);
		$this->state="SenderSet";
		if(IsSet($this->esmtp_extensions["PIPELINING"]))
			$this->pending_sender=1;
		$this->pending_recipients=0;
		return(1);
	}

	Function SetRecipient($recipient)
	{
		if($this->direct_delivery)
		{
			if(GetType($at=strrpos($recipient,"@"))!="integer")
				return("it was not specified a valid direct recipient");
			$domain=substr($recipient,$at+1);
			switch($this->state)
			{
				case "Disconnected":
					if(!$this->Connect($domain))
						return(0);
					if(!$this->MailFrom(""))
					{
						$error=$this->error;
						$this->Disconnect();
						$this->error=$error;
						return(0);
					}
					break;
				case "SenderSet":
				case "RecipientSet":
					if(strcmp($this->connected_domain,$domain))
					{
						$this->error="it is not possible to deliver directly to recipients of different domains";
						return(0);
					}
					break;
				default:
					$this->error="connection is already established and the recipient is already set";
					return(0);
			}
		}
		else
		{
			switch($this->state)
			{
				case "SenderSet":
				case "RecipientSet":
					break;
				default:
					$this->error="connection is not in the recipient setting state";
					return(0);
			}
		}
		$this->error="";
		if(!$this->PutLine("RCPT TO:<$recipient>"))
			return(0);
		if(IsSet($this->esmtp_extensions["PIPELINING"]))
		{
			$this->pending_recipients++;
			if($this->pending_recipients>=$this->maximum_piped_recipients)
			{
				if(!$this->FlushRecipients())
					return(0);
			}
		}
		else
		{
			if($this->VerifyResultLines(array("250","251"),$responses)<=0)
				return(0);
		}
		$this->state="RecipientSet";
		return(1);
	}

	Function StartData()
	{
		if(strcmp($this->state,"RecipientSet"))
		{
			$this->error="connection is not in the start sending data state";
			return(0);
		}
		$this->error="";
		if(!$this->PutLine("DATA"))
			return(0);
		if($this->pending_recipients)
		{
			if(!$this->FlushRecipients())
				return(0);
		}
		if($this->VerifyResultLines("354",$responses)<=0)
			return(0);
		$this->state="SendingData";
		return(1);
	}

	Function PrepareData(&$data,&$output,$preg=1)
	{
		if($preg
		&& function_exists("preg_replace"))
			$output=preg_replace(array("/\n\n|\r\r/","/(^|[^\r])\n/","/\r([^\n]|\$)/D","/(^|\n)\\./"),array("\r\n\r\n","\\1\r\n","\r\n\\1","\\1.."),$data);
		else
			$output=ereg_replace("(^|\n)\\.","\\1..",ereg_replace("\r([^\n]|\$)","\r\n\\1",ereg_replace("(^|[^\r])\n","\\1\r\n",ereg_replace("\n\n|\r\r","\r\n\r\n",$data))));
	}

	Function SendData($data)
	{
		if(strcmp($this->state,"SendingData"))
		{
			$this->error="connection is not in the sending data state";
			return(0);
		}
		$this->error="";
		return($this->PutData($data));
	}

	Function EndSendingData()
	{
		if(strcmp($this->state,"SendingData"))
		{
			$this->error="connection is not in the sending data state";
			return(0);
		}
		$this->error="";
		if(!$this->PutLine("\r\n.")
		|| $this->VerifyResultLines("250",$responses)<=0)
			return(0);
		$this->state="Connected";
		return(1);
	}

	Function ResetConnection()
	{
		switch($this->state)
		{
			case "Connected":
				return(1);
			case "SendingData":
				$this->error="can not reset the connection while sending data";
				return(0);
			case "Disconnected":
				$this->error="can not reset the connection before it is established";
				return(0);
		}
		$this->error="";
		if(!$this->PutLine("RSET")
		|| $this->VerifyResultLines("250",$responses)<=0)
			return(0);
		$this->state="Connected";
		return(1);
	}

	Function Disconnect($quit=1)
	{
		if(!strcmp($this->state,"Disconnected"))
		{
			$this->error="it was not previously established a SMTP connection";
			return(0);
		}
		$this->error="";
		if(!strcmp($this->state,"Connected")
		&& $quit
		&& (!$this->PutLine("QUIT")
		|| $this->VerifyResultLines("221",$responses)<=0))
			return(0);
		fclose($this->connection);
		$this->connection=0;
		$this->state="Disconnected";
		if($this->debug)
			$this->OutputDebug("Disconnected.");
		return(1);
	}

	Function SendMessage($sender,$recipients,$headers,$body)
	{
		if(($success=$this->Connect()))
		{
			if(($success=$this->MailFrom($sender)))
			{
				for($recipient=0;$recipient<count($recipients);$recipient++)
				{
					if(!($success=$this->SetRecipient($recipients[$recipient])))
						break;
				}
				if($success
				&& ($success=$this->StartData()))
				{
					for($header_data="",$header=0;$header<count($headers);$header++)
						$header_data.=$headers[$header]."\r\n";
					if(($success=$this->SendData($header_data."\r\n")))
					{
						$this->PrepareData($body,$body_data);
						$olddebug=$this->debug;
						$this->debug=false;
						$success=$this->SendData($body_data);
						$this->debug=$olddebug;
					}
					if($success)
						$success=$this->EndSendingData();
				}
			}
			$error=$this->error;
			$disconnect_success=$this->Disconnect($success);
			if($success)
				$success=$disconnect_success;
			else
				$this->error=$error;
		}
		return($success);
	}

};

















?>