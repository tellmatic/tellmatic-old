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

$set=getVar("set");
$search_array=Array();

$InputName_Name="s_email";//
$$InputName_Name=stripslashes(getVar($InputName_Name));

$InputName_F="f0_9";//
$$InputName_F=getVar($InputName_F);

$InputName_Status="s_status";//
$$InputName_Status=getVar($InputName_Status);

$InputName_Group="adr_grp_id";//
$$InputName_Group=getVar($InputName_Group);

$InputName_Author="s_author";//
$$InputName_Author=getVar($InputName_Author);

$InputName_Limit="limit";//range from

$InputName_SI0="si0";//
$$InputName_SI0=getVar($InputName_SI0);

$InputName_SI1="si1";//
$$InputName_SI1=getVar($InputName_SI1);

$InputName_SI2="si2";//
$$InputName_SI2=getVar($InputName_SI2);

$sort_search=false;
if (!isset($sortIndex)) {
	$sortIndex=getVar("si");
}
if (!empty($si0)) {
	$sortIndex.=$si0.",";
	$sort_search=true;
}
if (!empty($si1)) {
	$sortIndex.=$si1.",";
	$sort_search=true;
}
if (!empty($si2)) {
	$sortIndex.=$si2.",";
	$sort_search=true;
}

if (empty($sortIndex)) {
	$sortIndex="id";
}
if ($sort_search) { //abschliessend nach id sortieren!
	$sortIndex.="id";
}

$sortType=getVar("st");
if (empty($sortType)) {
	$sortType="0";//asc
}

include_once ($tm_includepath."/adr_search_form.inc.php");

	$search['email']=str_replace("*","%",$s_email);
	$search['status']=$s_status;
	$search['author']=$s_author;
	$search['f0_9']=str_replace("*","%",$f0_9);
	$search['group']=$adr_grp_id;
?>