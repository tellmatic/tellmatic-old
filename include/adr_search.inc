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


//$_MAIN_DESCR="Adressen suchen";
//$_MAIN_MESSAGE.="Suchmaske: email, f0-f9, status, gruppe";
$set=getVar("set");
$search_array=Array();

$InputName_Name="email";//
$$InputName_Name=getVar($InputName_Name);

$InputName_F="f0_9";//
$$InputName_F=getVar($InputName_F);

$InputName_Status="status";//
$$InputName_Status=getVar($InputName_Status);

$InputName_Group="adr_grp_id";//
$$InputName_Group=getVar($InputName_Group);
//pt_register("POST","adr_grp");
/*
if (!isset($adr_grp)) {
	$adr_grp[0]=getVar("adr_grp_id");
}
*/
$InputName_Author="author";//
$$InputName_Author=getVar($InputName_Author);

$InputName_Limit="limit";//range from
//$limit=getVar($InputName_Limit);


include_once ($mnl_includepath."/adr_search_form.inc");

//if ($set=="search") {
	$search['email']=str_replace("*","%",$email);
	$search['status']=$status;
	$search['author']=$author;
	$search['f0_9']=str_replace("*","%",$f0_9);
	$search['group']=$adr_grp_id;
	//$limit=100;
	//include_once ($mnl_includepath."/adr_list.inc");
//}


?>