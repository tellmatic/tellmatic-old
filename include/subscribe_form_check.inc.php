<?php
/********************************************************************************/
/* this file is part of: / diese Datei ist ein Teil von:                        */
/* tellmatic, the newslettermachine                                             */
/* tellmatic, die Newslettermaschine                                            */
/* 2006/10 by Volker Augustin, multi.art.studio Hanau                            */
/* Contact/Kontakt: info@tellmatic.org                                      */
/* Homepage: www.tellmatic.org                                                   */
/* leave this header in file!                                                   */
/* diesen Header nicht loeschen!                                                */
/* check Homepage for Updates and more Infos                                    */
/* Besuchen Sie die Homepage fuer Updates und weitere Infos                     */
/*******************************************************************************/

if ($FRM[0]['use_captcha']==1) {
	if (DEBUG) $MESSAGE.=tm_debugmessage("checking captcha");
	if (!is_numeric($fcpt) || empty($fcpt) || md5($fcpt)!=$cpt) {
		$check=false;
		if (DEBUG) $MESSAGE.=tm_debugmessage("wrong captcha code");
		$MESSAGE.="".$FRM[0]['captcha_errmsg'];
	}
}
//blacklist checken
if ($FRM[0]['check_blacklist']==1) {
	if (DEBUG) $MESSAGE.=tm_debugmessage("checking blacklist");
	$BLACKLIST=new tm_Blacklist();
	$check_mail=checkEmailAdr($email,$EMailcheck_Subscribe);
	$blacklisted=$BLACKLIST->isBlacklisted($email);
	if ($blacklisted) {
		$check=false;
		if (DEBUG) $MESSAGE.=tm_debugmessage("blacklisted!");
		$MESSAGE.="<br>".$FRM[0]['blacklist_errmsg'];
	}
}
//email auf gueltigkeit pruefen
if (DEBUG) $MESSAGE.=tm_debugmessage("checking email");
$check_mail=checkEmailAdr($email,$EMailcheck_Subscribe);
if (empty($email) || !$check_mail[0]) {
	$check=false;
	if (DEBUG) $MESSAGE.=tm_debugmessage("incorrect email");			
	$MESSAGE.="<br>".$FRM[0]['email_errmsg'];
}
//eingaben pruefen
//"simplified":
for ($fc=0;$fc<=9;$fc++) {
	$field="f".$fc;
	if (DEBUG) $MESSAGE.=tm_debugmessage("checking ".$field);
	if ( (!empty($FRM[0]['f'.$fc.'_expr']) && !ereg($FRM[0]['f'.$fc.'_expr'],$$field)) || ($FRM[0]['f'.$fc.'_required']==1 && empty($$field)) ) {
		$check=false;
		if (DEBUG) $MESSAGE.=tm_debugmessage($field." failed!");
		$MESSAGE.="<br>".$FRM[0]['f'.$fc.'_errmsg'];}
}			
//check for public groups, force user to select at least one public group			
if ($FRM[0]['force_pubgroup']==1) {
	if (DEBUG) $MESSAGE.=tm_debugmessage("checking force public group");
	if (!isset($adr_grp_pub[0])) {
		$check=false;
		if (DEBUG) $MESSAGE.=tm_debugmessage("no group selected");
		$MESSAGE.="<br>".$FRM[0]['pubgroup_errmsg'];
	}			
}

?>