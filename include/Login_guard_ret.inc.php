<?php
	if (TM_LOG) $LOG=new tm_LOG();
/***********************************************************/
//Session starten
/***********************************************************/
	session_name("TellMatic");
	session_start();

/***********************************************************/
//Not new login by default
/***********************************************************/
	$new_login = FALSE;

/***********************************************************/
//Handle Logout
/***********************************************************/
	//LOGOUT
	if ($action=="logout") {
		$LOGIN->Logout();
		$Return[0]=FALSE;
		$Return[1]=___("Sie wurden abgemeldet.");
		return $Return;
	}

/***********************************************************/
//get post (login)
//get session (already logged in)
/***********************************************************/
	//Name und Passwort entnehmen wir zuerst $_POST (login über Formular)
	if ( ( isset($_POST['user_name']) && isset($_POST['user_pw']) && !empty($_POST['user_name']) && !empty($_POST['user_pw']) ) ) {
		$user_name = $_POST['user_name']; //(get_magic_quotes_gpc()) ? stripslashes($_POST['user_name']) : $_POST['user_name'];
		$user_pw = $_POST['user_pw']; //(get_magic_quotes_gpc()) ? stripslashes($_POST['user_pw']) : $_POST['user_pw'];
		//passwort verschluesseln
		//hash ist md5 aus siteid+name+passwort
		$user_pw_md5 = md5(TM_SITEID.$user_name.$user_pw);
		unset($user_pw);
		//wenn die daten aus dem post kommen nehmen wir an es handelt sich um einen ersten loginversuch....
		$new_login = TRUE;
	} else {
		if ( isset($_SESSION['user_name']) && isset($_SESSION['user_pw_md5']) && !empty($_SESSION['user_name']) && !empty($_SESSION['user_pw_md5']) ) {
			//Name und Passwort entnehmen wir $_SESSION (Benutzer evtl. bereits angemeldet).
			$user_name = $_SESSION['user_name'];
			$user_pw_md5 = $_SESSION['user_pw_md5'];
		} else {
			$Return[0]=FALSE;
			$Return[1]=___("Kein Benutzername / Passwort angegeben");
			return $Return;
		}
	}

/***********************************************************/
//check refferer
/***********************************************************/
	//Stimmt die IP des Referrers mit der IP in der Session überein?
	if ( !$new_login && $_SESSION['ip'] != $_SERVER['REMOTE_ADDR'] ) {
		$LOGIN->Logout();
		$Return[0]=FALSE;
		$Return[1]=___("ungültiger Refferrer");
		return $Return;
	}

	//IP und aktuelle SessionID in Session speichern
	$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
	$_SESSION['id'] = session_id();


/***********************************************************/
//try login
/***********************************************************/
	//Login versuchen:
	//Stimmen name_md5 und passowrt_md5 mit md5-Daten in DB ueberein? (name im klartext in db, pw als md5 in db)
	if (!$LOGIN->Login($user_name,$user_pw_md5))  {
		$LOGIN->Logout();
		$Return[0]=FALSE;
		$Return[1]=___("Falscher Benutzer, Passwort ungültig oder Benutzer deaktiviert, Anmeldung ist fehlgeschlagen");
		return $Return;
	}

/***********************************************************/
//check timeout
/***********************************************************/
	//Zeitraum zwischen jetzt und letztem Login pruefen
	if ($LOGIN->USER['last_login']!=0) {
		if ( !$new_login && time()-$LOGIN->USER['last_login'] > TM_SESSION_TIMEOUT)  {
			$LOGIN->Logout();
			$Return[0]=FALSE;
			$Return[1]=___("Zeitüberschreitung");
			return $Return;
		}
	}

/***********************************************************/
//set session vars and save last login time
/***********************************************************/
	//User wird angemeldet
	//Name-Hash und PW-Hash in Session speichern
	$_SESSION['user_pw_md5'] = $user_pw_md5;
	$_SESSION['user_name'] = $user_name;
	//Zeitstempel in DB speichern
	//neuen Zeitstempel setzen
	$LOGIN->setTime($LOGIN->USER['name']);
/***********************************************************/
//OK, logged in!
/***********************************************************/
	//Benutzer ist nun angemeldet.
	$Return[0]=TRUE;
	$Return[1]="";
	if ($new_login) $Return[1]=___("Sie sind angemeldet");
	return $Return;
?>