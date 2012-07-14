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


class mnlCFG {  
	var $C=Array();
	var $LoggedInUsername;
	var $USER=Array();
	
	function Logout() {
		/*
		*/
	}
	function Login($checkadmin=0,$msg="new Login") { 
		if (!isset($_SERVER['PHP_AUTH_USER'])) {
			$this->authenticate($msg);
		}
		
		$LoginName=$_SERVER['PHP_AUTH_USER'];
		$PassWD=$_SERVER['PHP_AUTH_PW']; 
		if ($this->checkUserLogin($LoginName,$PassWD,$checkadmin)) {
			$this->User=$LoginName;
			return true; 
		}	else { 
	 		$this->authenticate("another Login"); 
	 	} 
	}

	function checkUserLogin($name,$passwd,$checkadmin=0) {
		global $mnl_siteid;
		$DB = new ConnectDB(); 
		$Query="
				SELECT name,aktiv,admin FROM ".mnlTABLE_USER."
				WHERE name='".$name."'
				AND passwd='".$passwd."'
				AND aktiv='1'
				AND siteid='".$mnl_siteid."'
				ORDER by name
				";
		$DB->Query($Query);
		if ($DB->next_record())	{ 
			$isAdmin=$DB->Record['admin']; 
			if ($checkadmin==1) { 
				if ($isAdmin==1) { 
					return true; 
				} else { 
					return false; 
				} 
			} else { 
				return true; 
			} 
		}	else { 
			return false; 
	 	} 
	}//checkUserLogin

	function authenticate($msg) 
	{ 
		Header("WWW-authenticate: basic realm=$msg");
		Header("HTTP/1.0 401 Unauthorized");
		echo "<html><head></head><body>$msg<br>Sie sind nicht angemeldet! You are not logged in!<br><b>Zugriff verweigert! Access denied!</b><br>";
		echo "</body></html>";
		exit; 
	} 

	function getUser($user) {
		global $mnl_siteid;
		$this->USER=Array();
		$DB=new ConnectDB();
		$Query ="
						SELECT id,
							name,
							admin,
							style
						FROM ".mnlTABLE_USER."
						WHERE siteid='".$mnl_siteid."'
						LIMIT 1
					";
		$DB->Query($Query);
		if ($DB->next_record()) {
			$this->USER['id']=$DB->Record['id'];
			$this->USER['name']=$DB->Record['name'];
			$this->USER['admin']=$DB->Record['admin'];
			$this->USER['style']=$DB->Record['style'];
		} 
		return $this->USER;
	}//getUserSettings
  
	function getCFG($siteid) {
		$this->C=Array();
		$DB=new ConnectDB();
		$Query ="
						SELECT id,
							name,
							smtp_host,
							smtp_domain,
							smtp_user,
							smtp_pass,
							sender_name,
							sender_email,
							return_mail,
							notify_mail,
							notify_subscribe,
							notify_unsubscribe,
							emailcheck_intern,
							emailcheck_subscribe,
							max_mails_atonce,
							max_mails_bcc,
							max_mails_retry
						FROM ".mnlTABLE_CONFIG."
						WHERE siteid='".$siteid."'
						LIMIT 1
					";
		$DB->Query($Query);
		$cc=0;
		if ($DB->next_record()) {
			$this->C[$cc]['id']=$DB->Record['id'];
			$this->C[$cc]['name']=$DB->Record['name'];
			$this->C[$cc]['siteid']=$siteid;
			$this->C[$cc]['smtp_host']=$DB->Record['smtp_host'];
			$this->C[$cc]['smtp_domain']=$DB->Record['smtp_domain'];
			$this->C[$cc]['smtp_user']=$DB->Record['smtp_user'];
			$this->C[$cc]['smtp_pass']=$DB->Record['smtp_pass'];
			$this->C[$cc]['sender_name']=$DB->Record['sender_name'];
			$this->C[$cc]['sender_email']=$DB->Record['sender_email'];
			$this->C[$cc]['return_mail']=$DB->Record['return_mail'];
			$this->C[$cc]['notify_mail']=$DB->Record['notify_mail'];
			$this->C[$cc]['notify_subscribe']=$DB->Record['notify_subscribe'];
			$this->C[$cc]['notify_unsubscribe']=$DB->Record['notify_unsubscribe'];
			$this->C[$cc]['emailcheck_intern']=$DB->Record['emailcheck_intern'];
			$this->C[$cc]['emailcheck_subscribe']=$DB->Record['emailcheck_subscribe'];
			$this->C[$cc]['max_mails_atonce']=$DB->Record['max_mails_atonce'];
			$this->C[$cc]['max_mails_bcc']=$DB->Record['max_mails_bcc'];
			$this->C[$cc]['max_mails_retry']=$DB->Record['max_mails_retry'];
			$cc++;
		} 
		return $this->C;
	}//getCFG
	
	function addCFG($cfg) {
		$Return=false;
		$DB=new ConnectDB();

		$Query ="INSERT INTO
						".mnlTABLE_CONFIG."
					(
					name,
					sender_name,
					sender_email,
					return_mail,
					notify_mail,
					notify_subscribe,
					notify_unsubscribe,
					emailcheck_intern,
					emailcheck_subscribe,
					max_mails_atonce,
					max_mails_bcc,
					max_mails_retry,
					smtp_host,
					smtp_user,
					smtp_pass,
					smtp_domain,
					siteid
					)
					VALUES
					(
					'".$cfg["name"]."',
					'".$cfg["sender_name"]."',
					'".$cfg["sender_email"]."',
					'".$cfg["return_mail"]."',
					'".$cfg["notify_mail"]."',
					'".$cfg["notify_subscribe"]."',
					'".$cfg["notify_unsubscribe"]."',
					'".$cfg["emailcheck_intern"]."',
					'".$cfg["emailcheck_subscribe"]."',
					'".$cfg["max_mails_atonce"]."',
					'".$cfg["max_mails_bcc"]."',
					'".$cfg["max_mails_retry"]."',
					'".$cfg["smtp_host"]."',
					'".$cfg["smtp_user"]."',
					'".$cfg["smtp_pass"]."',
					'".$cfg["smtp_domain"]."',
					'".$cfg["siteid"]."'					)
					";
		if ($DB->Query($Query)) {
			$Return=true;
		} else {
			$Return=false;
			return $Return;			
		}
		return $Return;			
	}//addCFG
	

		
	function addUSER($user) {
		$Return=false;
		$DB=new ConnectDB();
		$Query ="INSERT INTO
						".mnlTABLE_USER."
					(name,passwd,aktiv,admin,style,siteid)
					VALUES
					('".$user['name']."','".$user['passwd']."','".$user['aktiv']."','".$user['admin']."','".$user['style']."','".$user['siteid']."')
					";
		if ($DB->Query($Query)) {
			$Return=true;
		} else {
			$Return=false;
			return $Return;			
		}
		return $Return;			
	}//addUSER

	function updateCFG($cfg) {
		$Return=false;
		$DB=new ConnectDB();
		$Query ="UPDATE ".mnlTABLE_CONFIG." 
					SET 
					name='".$cfg["name"]."',
					sender_name='".$cfg["sender_name"]."',
					sender_email='".$cfg["sender_email"]."',
					return_mail='".$cfg["return_mail"]."',
					notify_mail='".$cfg["notify_mail"]."',
					notify_subscribe='".$cfg["notify_subscribe"]."',
					notify_unsubscribe='".$cfg["notify_unsubscribe"]."',
					emailcheck_intern='".$cfg["emailcheck_intern"]."',
					emailcheck_subscribe='".$cfg["emailcheck_subscribe"]."',
					max_mails_atonce='".$cfg["max_mails_atonce"]."',
					max_mails_bcc='".$cfg["max_mails_bcc"]."',
					max_mails_retry='".$cfg["max_mails_retry"]."',
					smtp_host='".$cfg["smtp_host"]."',
					smtp_user='".$cfg["smtp_user"]."',
					smtp_pass='".$cfg["smtp_pass"]."',
					smtp_domain='".$cfg["smtp_domain"]."'
					WHERE siteid='".$cfg["siteid"]."'
					";
		if ($DB->Query($Query)) {
			$Return=true;
		}
		return $Return;
	}//updateCFG
	
	function setPasswd($user,$passwd) {
		global $mnl_siteid;
		$Return=false;
		$DB=new ConnectDB();
		$Query ="UPDATE ".mnlTABLE_USER." SET passwd='".$passwd."' WHERE siteid='".$mnl_siteid."' AND name='".$user."'";
		if ($DB->Query($Query)) {
			$Return=true;
		}
		return $Return;
	}//setPasswd
	
	function setStyle($user,$style="default") {
		global $mnl_siteid;
		$Return=false;
		$DB=new ConnectDB();
		$Query ="UPDATE ".mnlTABLE_USER." SET style='".$style."' WHERE siteid='".$mnl_siteid."'	AND name='".$user."'";
		if ($DB->Query($Query)) {
			$Return=true;
		}
		return $Return;
	}//setStyle
}  

?>