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

$_MAIN_DESCR=___("neue Adressgruppe erstellen");
$_MAIN_MESSAGE.="";

$created=date("Y-m-d H:i:s");
$author=$LOGIN->USER['name'];
$set=getVar("set");
$adr_grp_id=0;
$standard=0;

//field names for query
$InputName_Name="name";//range from
$$InputName_Name=getVar($InputName_Name);

$InputName_Descr="descr";//range from
$$InputName_Descr=getVar($InputName_Descr);

$InputName_Aktiv="aktiv";//range from
$$InputName_Aktiv=getVar($InputName_Aktiv);
//

$check=true;
if ($set=="save") {
	//checkinput
	if (empty($name)) {$check=false;$_MAIN_MESSAGE.="<br>".___("Name der Gruppe sollte nicht leer sein.");}
	if ($check) {
		$ADDRESS=new mnlAdr();
		$ADDRESS->addGrp(Array(
					"name"=>$name,
					"descr"=>$descr,
					"aktiv"=>$aktiv,
					"created"=>$created, 
					"author"=>$author
					));
		$_MAIN_MESSAGE.="<br>".sprintf(___("Neue Addressgruppe %s wurde erstellt."),"'<b>".$name."</b>'");
		$action="adr_grp_list";
		include_once ($mnl_includepath."/adr_grp_list.inc");
	} else {
		include_once ($mnl_includepath."/adr_grp_form.inc");
	}
	
} else {
	include_once ($mnl_includepath."/adr_grp_form.inc");
}
?>