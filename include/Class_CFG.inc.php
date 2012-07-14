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


class tm_CFG {
	var $C=Array();
	var $USER=Array();


//LOGIN / LOGOUT
	function Logout() {
		//logout....
		global $user_name,$user_pw,$Style;
		$user_name="";
		$user_pw="";
		$Style="default";
		// Unset all of the session variables.
		$_SESSION = array();
		// If it's desired to kill the session, also delete the session cookie.
		// Note: This will destroy the session, and not just the session data!
		if (isset($_COOKIE[session_name()])) {
		   setcookie(session_name(), '', time()-42000, '/');
		}
		// Finally, destroy the session.
		session_unset();
		session_destroy();
	}

	function Login($name,$passwd,$checkadmin=0) {
		$Return=false;
		if ($this->checkUserLogin($name,$passwd,$checkadmin)) {
			//ok, logged in , userdaten holen
			$this->getUser($name);
			//wenn ok
			//cookie setzen
			$Return=true;
		}
		return $Return;
	}


	function LoginHTTP($checkadmin=0,$msg="new Login") {
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
		$DB = new tm_DB();
		$Query="
				SELECT name,aktiv,admin FROM ".TM_TABLE_USER."
				WHERE name='".dbesc($name)."'
				AND passwd='".dbesc($passwd)."'
				AND aktiv='1'
				AND siteid='".TM_SITEID."'
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
		Header("WWW-Authenticate: Basic realm=$msg");
		Header("HTTP/1.0 401 Unauthorized");
		echo "<html><head></head><body>$msg<br>Sie sind nicht angemeldet! You are not logged in!<br><b>Zugriff verweigert! Access denied!</b><br>";
		echo "</body></html>";
		exit;
	}

//USER
	function getUser($user,$id=0) {
		$this->USER=Array();
		$USER_=$this->getUsers($user,$id);
		$this->USER=$USER_[0];
		return $this->USER;
	}//getUserSettings

	function getUsers($user="",$id=0) {
		$USER=Array();//this->
		$DB=new tm_DB();
		$Query ="	SELECT id,
							name,
							passwd,
							crypt,
							last_login,
							email,
							admin,
							manager,
							style,
							lang,
							expert,
							aktiv
						FROM ".TM_TABLE_USER."
						WHERE siteid='".TM_SITEID."'";
		if (!empty($user)) {
			$Query .=" AND name='".dbesc($user)."'";
		}
		if (check_dbid($id)) {
			$Query .=" AND id='".$id."'";
		}
		if (!empty($user) || check_dbid($id)) {
			$Query .=" LIMIT 1";
		}

		$DB->Query($Query);
		$uc=0;
		while ($DB->next_record()) {
			$USER[$uc]['id']=$DB->Record['id'];//this->
			$USER[$uc]['name']=$DB->Record['name'];
			$USER[$uc]['passwd']=$DB->Record['passwd'];
			$USER[$uc]['crypt']=$DB->Record['crypt'];
			$USER[$uc]['email']=$DB->Record['email'];
			$USER[$uc]['last_login']=$DB->Record['last_login'];
			$USER[$uc]['admin']=$DB->Record['admin'];
			$USER[$uc]['manager']=$DB->Record['manager'];
			$USER[$uc]['style']=$DB->Record['style'];
			$USER[$uc]['lang']=$DB->Record['lang'];
			$USER[$uc]['expert']=$DB->Record['expert'];
			$USER[$uc]['aktiv']=$DB->Record['aktiv'];
			$uc++;
		}
		return $USER;//this->
	}//getUsers


	function addUSER($user) {
		$Return=false;
		$DB=new tm_DB();
		$Query ="INSERT INTO
						".TM_TABLE_USER."
					(name,passwd,crypt,email,last_login,aktiv,admin,manager,style,lang,expert,siteid)
					VALUES
					('".dbesc($user['name'])."','".dbesc($user['passwd'])."','".dbesc($user['crypt'])."','".dbesc($user['email'])."',0,'".dbesc($user['aktiv'])."','".dbesc($user['admin'])."','".dbesc($user['manager'])."','".dbesc($user['style'])."','".dbesc($user['lang'])."','".dbesc($user['expert'])."','".dbesc($user['siteid'])."')
					";
		if ($DB->Query($Query)) {
			$Return=true;
		}
		return $Return;
	}//addUSER

	function updateUser($user) {
		$Return=false;
		$DB=new tm_DB();
		if (check_dbid($user['id'])) {
			$Query ="UPDATE ".TM_TABLE_USER."
					SET
					name='".dbesc($user["name"])."',
					email='".dbesc($user["email"])."',
					admin='".dbesc($user["admin"])."',
					manager='".dbesc($user["manager"])."',
					style='".dbesc($user["style"])."',
					lang='".dbesc($user["lang"])."',
					expert='".dbesc($user["expert"])."',
					aktiv='".dbesc($user["aktiv"])."'
					WHERE id='".$user['id']."' AND siteid='".TM_SITEID."'";
			if ($DB->Query($Query)) {
				$Return=true;
			}
			return $Return;
		}
	}
	
	function delUser($id=0) {
		$Return=false;
		if (check_dbid($id)) {
			$DB=new tm_DB();
			$Query ="DELETE FROM ".TM_TABLE_USER." WHERE id='".$id."' AND admin!='1' AND siteid='".TM_SITEID."'";
			if ($DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//delUser
	
	function setPasswd($user,$passwd,$crypt) {
		$Return=false;
		$DB=new tm_DB();
		$Query ="UPDATE ".TM_TABLE_USER." SET passwd='".dbesc($passwd)."', crypt='".dbesc($crypt)."' WHERE siteid='".dbesc(TM_SITEID)."' AND name='".dbesc($user)."'";
		if ($DB->Query($Query)) {
			$Return=true;
		}
		return $Return;
	}//setPasswd

	//update last_login
	function setTime($user) {
		$Return=false;
		$DB=new tm_DB();
		$time=time();
		$Query ="UPDATE ".TM_TABLE_USER." SET last_login='".$time."' WHERE siteid='".dbesc(TM_SITEID)."' AND name='".dbesc($user)."'";
		if ($DB->Query($Query)) {
			$Return=$time;
		}
		return $Return;
	}//setPasswd

	function setStyle($user,$style="default") {
		$Return=false;
		$DB=new tm_DB();
		$Query ="UPDATE ".TM_TABLE_USER." SET style='".dbesc($style)."' WHERE siteid='".TM_SITEID."'	AND name='".dbesc($user)."'";
		if ($DB->Query($Query)) {
			$Return=true;
		}
		return $Return;
	}//setStyle

	function setEMail($user,$email) {
		$Return=false;
		$DB=new tm_DB();
		$Query ="UPDATE ".TM_TABLE_USER." SET `email`='".dbesc($email)."' WHERE siteid='".TM_SITEID."' AND name='".dbesc($user)."'";
		if ($DB->Query($Query)) {
			$Return=true;
		}
		return $Return;
	}//setLang

	function setLang($user,$lang="de") {
		$Return=false;
		$DB=new tm_DB();
		$Query ="UPDATE ".TM_TABLE_USER." SET `lang`='".dbesc($lang)."' WHERE siteid='".TM_SITEID."' AND name='".dbesc($user)."'";
		if ($DB->Query($Query)) {
			$Return=true;
		}
		return $Return;
	}//setLang

	function setExpert($user,$expert=0) {
		$Return=false;
		$DB=new tm_DB();
		$Query ="UPDATE ".TM_TABLE_USER." SET `expert`='".dbesc($expert)."' WHERE siteid='".TM_SITEID."' AND name='".dbesc($user)."'";
		if ($DB->Query($Query)) {
			$Return=true;
		}
		return $Return;
	}//setExpert

	function setUSERAktiv($id=0,$aktiv=1) {
		$Return=false;
		if (check_dbid($id)) {
			$DB=new tm_DB();
			$Query ="UPDATE ".TM_TABLE_USER." SET aktiv='".dbesc($aktiv)."' WHERE id='".$id."' AND admin!='1' AND siteid='".TM_SITEID."'";
			if ($DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//setAktiv

	function setAdmin($id,$admin=0) {
		$Return=false;
		if (check_dbid($id)) {
			$DB=new tm_DB();
			$Query ="UPDATE ".TM_TABLE_USER." SET `admin`='".dbesc($admin)."' WHERE siteid='".TM_SITEID."' AND id='".dbesc($id)."' ";
			if ($DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//setAdmin

	function setManager($id,$manager=0) {
		$Return=false;
		if (check_dbid($id)) {
			$DB=new tm_DB();
			$Query ="UPDATE ".TM_TABLE_USER." SET `manager`='".dbesc($manager)."' WHERE siteid='".TM_SITEID."' AND id='".dbesc($id)."' ";
			if ($DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//setManager


 //CONFIG
	function getSites() {
		$Sites=Array();
		$DB=new tm_DB();
		$Query ="	SELECT id,
							name, siteid
						FROM ".TM_TABLE_CONFIG."
					";
		$DB->Query($Query);
		$cc=0;
		while ($DB->next_record()) {
			$Sites[$cc]['id']=$DB->Record['id'];
			$Sites[$cc]['name']=$DB->Record['name'];
			$Sites[$cc]['siteid']=$DB->Record['siteid'];
			$cc++;
		}
		return $Sites;
	}//getSites

	function getCFG($siteid) {
		$this->C=Array();
		$DB=new tm_DB();
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
							max_mails_retry,
							check_version,
							track_image
						FROM ".TM_TABLE_CONFIG."
						WHERE siteid='".TM_SITEID."'
						LIMIT 1
					";
		$DB->Query($Query);
		$cc=0;
		if ($DB->next_record()) {
			$this->C[$cc]['id']=$DB->Record['id'];
			$this->C[$cc]['name']=$DB->Record['name'];
			#$this->C[$cc]['siteid']=$siteid;
			$this->C[$cc]['siteid']=TM_SITEID;
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
			$this->C[$cc]['check_version']=$DB->Record['check_version'];
			$this->C[$cc]['track_image']=$DB->Record['track_image'];
		}
		return $this->C;
	}//getCFG

	function addCFG($cfg) {
		$Return=false;
		$DB=new tm_DB();

		$Query ="INSERT INTO
						".TM_TABLE_CONFIG."
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
					check_version,
					max_mails_atonce,
					max_mails_bcc,
					max_mails_retry,
					smtp_host,
					smtp_user,
					smtp_pass,
					smtp_domain,
					track_image,
					siteid
					)
					VALUES
					(
					'".dbesc($cfg["name"])."',
					'".dbesc($cfg["sender_name"])."',
					'".dbesc($cfg["sender_email"])."',
					'".dbesc($cfg["return_mail"])."',
					'".dbesc($cfg["notify_mail"])."',
					'".dbesc($cfg["notify_subscribe"])."',
					'".dbesc($cfg["notify_unsubscribe"])."',
					'".dbesc($cfg["emailcheck_intern"])."',
					'".dbesc($cfg["emailcheck_subscribe"])."',
					'".dbesc($cfg["check_version"])."',
					'".dbesc($cfg["max_mails_atonce"])."',
					'".dbesc($cfg["max_mails_bcc"])."',
					'".dbesc($cfg["max_mails_retry"])."',
					'".dbesc($cfg["smtp_host"])."',
					'".dbesc($cfg["smtp_user"])."',
					'".dbesc($cfg["smtp_pass"])."',
					'".dbesc($cfg["smtp_domain"])."',
					'".dbesc($cfg["track_image"])."',
					'".dbesc($cfg["siteid"])."'
					)
					";
		if ($DB->Query($Query)) {
			$Return=true;
		} else {
			$Return=false;
			return $Return;
		}
		return $Return;
	}//addCFG

	function updateCFG($cfg) {
		$Return=false;
		$DB=new tm_DB();
		$Query ="UPDATE ".TM_TABLE_CONFIG."
					SET
					name='".dbesc($cfg["name"])."',
					sender_name='".dbesc($cfg["sender_name"])."',
					sender_email='".dbesc($cfg["sender_email"])."',
					return_mail='".dbesc($cfg["return_mail"])."',
					notify_mail='".dbesc($cfg["notify_mail"])."',
					notify_subscribe='".dbesc($cfg["notify_subscribe"])."',
					notify_unsubscribe='".dbesc($cfg["notify_unsubscribe"])."',
					emailcheck_intern='".dbesc($cfg["emailcheck_intern"])."',
					emailcheck_subscribe='".dbesc($cfg["emailcheck_subscribe"])."',
					check_version='".dbesc($cfg["check_version"])."',
					max_mails_atonce='".dbesc($cfg["max_mails_atonce"])."',
					max_mails_bcc='".dbesc($cfg["max_mails_bcc"])."',
					max_mails_retry='".dbesc($cfg["max_mails_retry"])."',
					smtp_host='".dbesc($cfg["smtp_host"])."',
					smtp_user='".dbesc($cfg["smtp_user"])."',
					smtp_pass='".dbesc($cfg["smtp_pass"])."',
					smtp_domain='".dbesc($cfg["smtp_domain"])."',
					track_image='".dbesc($cfg["track_image"])."'
					WHERE siteid='".dbesc($cfg["siteid"])."'
					";
		if ($DB->Query($Query)) {
			$Return=true;
		}
		return $Return;
	}//updateCFG

}
?>