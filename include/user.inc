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

$_MAIN_DESCR=___("Benutzereinstellungen &auml;ndern");
$_MAIN_MESSAGE.="";

$set=getVar("set");

//field names for query
$InputName_Pass="pass";//
$$InputName_Pass=getVar($InputName_Pass);
$InputName_Pass2="pass2";//
$$InputName_Pass2=getVar($InputName_Pass2);

$InputName_Style="style";
$$InputName_Style=getVar($InputName_Style);

$InputName_Lang="lang";
$$InputName_Lang=getVar($InputName_Lang);

$check=true;
if ($set=="save") {
	//checkinput
	$pwchanged=0;
	$minlength_pw=6;
	if (empty($pass)) {$check=false;$_MAIN_MESSAGE.="<br>".___("Kein Passwort angegeben.");}
	if (strlen($pass)<$minlength_pw) {$check=false;$_MAIN_MESSAGE.="<br>".sprintf(___("Passwort sollte mindestens %s Zeichen haben."),$minlength_pw);}
	if ($pass != $pass2) {$check=false;$_MAIN_MESSAGE.="<br>".___("Bitte geben Sie zweimal das gleiche Passwort an.");}

	$USER=new mnlCFG();

	if ($check) {
		$USER->setPasswd($LOGIN->USER['name'],$pass);//	MNL_SITEID,$PHP_AUTH_USER,$PHP_AUTH_PW; 
		$pwchanged=1;
	} else {
		$_MAIN_MESSAGE.="<br>".___("Das Passwort wurde nicht ge&auml;ndert.");
	}
	
	$USER->setStyle($LOGIN->USER['name'],$style);
	$USER->setLang($LOGIN->USER['name'],$lang);


	header('Location: '.$mnl_URL."/?act=user&pwchanged=".$pwchanged."&cryptpw=".crypt($LOGIN->USER['passwd']));
	exit;
}

$$InputName_Style=$LOGIN->USER['style'];
$$InputName_Lang=$LOGIN->USER['lang'];
include_once ($mnl_includepath."/user_form.inc");
?>