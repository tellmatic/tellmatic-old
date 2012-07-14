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

$_MAIN_DESCR="Benutzereinstellungen aendern";
$_MAIN_MESSAGE.="";

$set=getVar("set");

//field names for query
$InputName_Pass="pass";//
$$InputName_Pass=getVar($InputName_Pass);
$InputName_Pass2="pass2";//
$$InputName_Pass2=getVar($InputName_Pass2);

$InputName_Style="style";
$$InputName_Style=getVar($InputName_Style);

$check=true;
if ($set=="save") {
	//checkinput
	if (empty($pass)) {$check=false;$_MAIN_MESSAGE.="<br>Kein passwort angegeben.";}
	if (strlen($pass)<6) {$check=false;$_MAIN_MESSAGE.="<br>Passwort sollte mindestens 6 Zeichen haben.";}
	if ($pass != $pass2) {$check=false;$_MAIN_MESSAGE.="<br>Bitte geben Sie zweimal das gleiche Passwort an.";}

	$USER=new mnlCFG();

	if ($check) {
		$USER->setPasswd($_SERVER['PHP_AUTH_USER'],$pass);//	$mnl_siteid,$PHP_AUTH_USER,$PHP_AUTH_PW; 
		$_MAIN_MESSAGE.="<br>Passwort wurde gespeichert und ist ab sofort gueltig!
											<br>Achtung! Passwort muss in include/.htpasswd manuell angepasst werden.
											<br>crypt: <font color=red>".crypt($pass)."</font>
											";
	} else {
		$_MAIN_MESSAGE.="<br>Passwort nicht geaendert.";
	}
	$USER->setStyle($_SERVER['PHP_AUTH_USER'],$style);	
	
}

$$InputName_Style=$LOGIN->USER['style'];
include_once ($mnl_includepath."/user_form.inc");
?>