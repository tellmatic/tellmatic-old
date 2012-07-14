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

$_MAIN_DESCR=___("Neuen Mailserver eintragen");
$_MAIN_MESSAGE.="";

$set=getVar("set");
$h_id=getVar("h_id");
$created=date("Y-m-d H:i:s");
#$author=$LOGIN->USER['name'];

$InputName_Name="name";
$$InputName_Name=getVar($InputName_Name);

$InputName_Host="host";
$$InputName_Host=getVar($InputName_Host);

$InputName_Port="port";
$$InputName_Port=getVar($InputName_Port);

$InputName_Type="type";
$$InputName_Type=getVar($InputName_Type);

$InputName_Options="options";
$$InputName_Options=getVar($InputName_Options);

$InputName_SMTPAuth="smtp_auth";
$$InputName_SMTPAuth=getVar($InputName_SMTPAuth);

$InputName_SMTPDomain="smtp_domain";
$$InputName_SMTPDomain=getVar($InputName_SMTPDomain);

$InputName_User="user";
$$InputName_User=getVar($InputName_User);

$InputName_Pass="pass";
$$InputName_Pass=getVar($InputName_Pass);

$InputName_Aktiv="aktiv";
$$InputName_Aktiv=getVar($InputName_Aktiv);

if ($set=="save") {
	$check=true;
	//checkinput
	if (empty($name)) {$check=false;$_MAIN_MESSAGE.="<br>".___("Der Name darf nicht leer sein.");}
	if (empty($port)) {$check=false;$_MAIN_MESSAGE.="<br>".___("Der Port muss angegeben werden.");}
	if (empty($host)) {$check=false;$_MAIN_MESSAGE.="<br>".___("Der Hostname oder IP-Adresse muss angegeben werden.");}
	if ($check) {
			if (!DEMO) {
				$HOSTS=new tm_HOST();
				$HOSTS->addHost(Array(
							"siteid"=>TM_SITEID,
							"name"=>$name,
							"aktiv"=>$aktiv,
							"host"=>$host,
							"port"=>$port,
							"options"=>$options,
							"smtp_auth"=>$smtp_auth,
							"smtp_domain"=>$smtp_domain,
							"type"=>$type,
							"user"=>$user,
							"pass"=>$pass
							));
		}//demo
		$_MAIN_MESSAGE.="<br>".sprintf(___("Neuer Mailserver %s wurde angelegt."),"'<b>".display($name)."</b>'");
		$action="host_list";
		include_once (TM_INCLUDEPATH."/host_list.inc.php");
	} else {//check
		include_once (TM_INCLUDEPATH."/host_form.inc.php");
	}//check
} else {//set==save
	include_once (TM_INCLUDEPATH."/host_form.inc.php");
}//set==save
?>