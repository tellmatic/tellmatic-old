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

$_MAIN_DESCR=___("Newslettergruppe bearbeiten");
$_MAIN_MESSAGE.="";

$set=getVar("set");
$nl_grp_id=getVar("nl_grp_id");

//field names for query
$InputName_Name="name";//range from
$$InputName_Name=getVar($InputName_Name);

$InputName_Descr="descr";//range from
$$InputName_Descr=getVar($InputName_Descr);
$$InputName_Descr = strtr($$InputName_Descr, $trans); 

$InputName_Aktiv="aktiv";//range from
$$InputName_Aktiv=getVar($InputName_Aktiv);
//
$InputName_Color="color";
$$InputName_Color=getVar($InputName_Color);

$InputName_ColorView="color_view";//nur anzeige....

$check=true;
if ($set=="save") {
	//checkinput
	if (empty($name)) {$check=false;$_MAIN_MESSAGE.="<br>".___("Name der Gruppe sollte nicht leer sein.");}
	if ($check) {
		$NEWSLETTER=new mnlNL();
		$NEWSLETTER->updateGrp(Array("id"=>$nl_grp_id, "name"=>$name, "descr"=>$descr, "aktiv"=>$aktiv));
		$_MAIN_MESSAGE.="<br>".sprintf(___("Newslettergruppe %s wurde aktualisiert."),"'<b>".$name."</b>'");
		$action="nl_grp_list";
		include_once ($mnl_includepath."/nl_grp_list.inc");
	} else {
		include_once ($mnl_includepath."/nl_grp_form.inc");
	}
	
} else {
	$NEWSLETTER=new mnlNL();
	$GRP=$NEWSLETTER->getGroup($nl_grp_id,0,0);
	$name=$GRP[0]['name'];
	$descr=$GRP[0]['descr'];
	$aktiv=$GRP[0]['aktiv'];
	$standard=$GRP[0]['standard'];
	include_once ($mnl_includepath."/nl_grp_form.inc");
}
?>