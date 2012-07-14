<?php
/********************************************************************************/
/* this file is part of: / diese Datei ist ein Teil von:                        	*/
/* tellmatic, the newslettermachine                                             	*/
/* tellmatic, die Newslettermaschine                                            */
/* 2006/7 by Volker Augustin, multi.art.studio Hanau                            */
/* Contact/Kontakt: info@tellmatic.org                                      */
/* Homepage: www.tellmatic.org                                                   */
/* leave this header in file!                                                   */
/* diesen Header nicht loeschen!                                                */
/* check Homepage for Updates and more Infos                                    */
/* Besuchen Sie die Homepage fuer Updates und weitere Infos                     */
/********************************************************************************/
/***********************************************************/
//checkinput
/***********************************************************/
	if (empty($name)) {$check=false;$ERR_MESSAGE.="<br>".___("Kein Benutzernamen angeben");}
	if (empty($pass)) {$check=false;$ERR_MESSAGE.="<br>".___("Kein Passwort angegeben");}
	if ($pass!=$pass2) {$check=false;$ERR_MESSAGE.="<br>".___("Bitte zwei mal das gleiche Passwort angeben");}
	if (empty($email)) {$check=false;$ERR_MESSAGE.="<br>".___("E-Mail darf nicht leer sein");}
	$check_mail=checkEmailAdr($email,1);
	if (!$check_mail[0]) {$check=false;$ERR_MESSAGE.="<br>".___("Ungültige E-Mail-Adresse");}
	//achtung! wenn socket=1 dann kein port pruefen!
	if (empty($db_host)  || empty($db_name) || empty($db_user) || empty($db_pass)) {$check=false;$ERR_MESSAGE.="<br>".___("Daten für den Zugriff auf die Datenbank sind nicht vollständig (Host,Name,User,Passwort?)");}
	if (empty($db_port)  && $db_socket!=1) {$check=false;$ERR_MESSAGE.="<br>".___("Daten für den Zugriff auf die Datenbank sind nicht vollständig (Port? oder Socket?)");}
	if (!$check) {
		$ERR_MESSAGE="<p><font color=red><b>".___("Fehler")."</b>".$ERR_MESSAGE."</font></p>";
		$MESSAGE.=$ERR_MESSAGE;
		$ERR_MESSAGE="";
	}
?>