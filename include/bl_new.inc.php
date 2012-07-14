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

$_MAIN_DESCR=___("Neuer Eintrag in Blacklist");
$_MAIN_MESSAGE.="";

$set=getVar("set");
$bl_id=getVar("bl_id");
$created=date("Y-m-d H:i:s");
#$author=$LOGIN->USER['name'];

$InputName_Expr="expr";
$$InputName_Expr=getVar($InputName_Expr);

$InputName_Type="type";
$$InputName_Type=getVar($InputName_Type);

$InputName_Aktiv="aktiv";
$$InputName_Aktiv=getVar($InputName_Aktiv);

if ($set=="save") {
	$check=true;
	//checkinput
	if (empty($expr)) {$check=false;$_MAIN_MESSAGE.="<br>".___("Der Ausdruck darf nicht leer sein.");}
	//syntaxcheck wenn email

	if ($type=="email") {
		$check_mail=checkEmailAdr($expr,$EMailcheck_Intern);
		if (!$check_mail[0]) {$check=false;$_MAIN_MESSAGE.="<br>".sprintf(___("E-Mail %s hat ein falsches Format."),display($expr))." ".$check_mail[1];;}
	}
	if ($check) {
			if (!DEMO) {
				$BLACKLIST=new tm_BLACKLIST();
				//dublettencheck, anders als in adr_list, dort ist nur typ domain und email, hier wuerde isBlacklisted bei regexp probleme machen, ganze email erwartet!
				//eintrag suchen:
				$BL=$BLACKLIST->getBL(0,Array("type"=>$type,"expr"=>$expr));
				//wenn nix gefunden, eintragen:
				if (count($BL)<1) {
					$BLACKLIST->addBL(Array(
							"siteid"=>TM_SITEID,
							"expr"=>$expr,
							"aktiv"=>$aktiv,
							"type"=>$type
							));
				} else {
					$_MAIN_MESSAGE.="<br>".sprintf(___("Der Eintrag %s ist bereits vorhanden."),"'<b>".display($expr)."</b>'");
				}//if count
		}//demo
		$_MAIN_MESSAGE.="<br>".sprintf(___("Neuer Eintrag %s wurde angelegt."),"'<b>".display($expr)."</b>'");
		$action="bl_list";
		include_once (TM_INCLUDEPATH."/bl_list.inc.php");
	} else {//check
		include_once (TM_INCLUDEPATH."/bl_form.inc.php");
	}//check
} else {//set==save
	include_once (TM_INCLUDEPATH."/bl_form.inc.php");
}//set==save
?>