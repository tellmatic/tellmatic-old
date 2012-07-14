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

$_MAIN_DESCR=___("neues Formluar erstellen");
$_MAIN_MESSAGE.="";

$set=getVar("set");
$frm_id=0;
$created=date("Y-m-d H:i:s");
$author=$LOGIN->USER['name'];

//field names for query
$InputName_Group="adr_grp";
//$$InputName_Group=getVar($InputName_Group);
pt_register("POST","adr_grp");
if (!isset($adr_grp)) {
	$adr_grp=Array();
}

$InputName_Name="name";//betreff
$$InputName_Name=getVar($InputName_Name);

$InputName_Descr="descr";
$$InputName_Descr=getVar($InputName_Descr,0);//varname,slashes? 0=no add slashes

$InputName_Aktiv="aktiv";
$$InputName_Aktiv=getVar($InputName_Aktiv);

$InputName_DoubleOptin="double_optin";
$$InputName_DoubleOptin=getVar($InputName_DoubleOptin);


$InputName_F0="f0";
$$InputName_F0=getVar($InputName_F0);
$InputName_F1="f1";
$$InputName_F1=getVar($InputName_F1);
$InputName_F2="f2";
$$InputName_F2=getVar($InputName_F2);
$InputName_F3="f3";
$$InputName_F3=getVar($InputName_F3);
$InputName_F4="f4";
$$InputName_F4=getVar($InputName_F4);
$InputName_F5="f5";
$$InputName_F5=getVar($InputName_F5);
$InputName_F6="f6";
$$InputName_F6=getVar($InputName_F6);
$InputName_F7="f7";
$$InputName_F7=getVar($InputName_F7);
$InputName_F8="f8";
$$InputName_F8=getVar($InputName_F8);
$InputName_F9="f9";
$$InputName_F9=getVar($InputName_F9);

$InputName_F0_type="f0_type";
$$InputName_F0_type=getVar($InputName_F0_type);
$InputName_F1_type="f1_type";
$$InputName_F1_type=getVar($InputName_F1_type);
$InputName_F2_type="f2_type";
$$InputName_F2_type=getVar($InputName_F2_type);
$InputName_F3_type="f3_type";
$$InputName_F3_type=getVar($InputName_F3_type);
$InputName_F4_type="f4_type";
$$InputName_F4_type=getVar($InputName_F4_type);
$InputName_F5_type="f5_type";
$$InputName_F5_type=getVar($InputName_F5_type);
$InputName_F6_type="f6_type";
$$InputName_F6_type=getVar($InputName_F6_type);
$InputName_F7_type="f7_type";
$$InputName_F7_type=getVar($InputName_F7_type);
$InputName_F8_type="f8_type";
$$InputName_F8_type=getVar($InputName_F8_type);
$InputName_F9_type="f9_type";
$$InputName_F9_type=getVar($InputName_F9_type);

$InputName_F0_required="f0_required";
$$InputName_F0_required=getVar($InputName_F0_required);
$InputName_F1_required="f1_required";
$$InputName_F1_required=getVar($InputName_F1_required);
$InputName_F2_required="f2_required";
$$InputName_F2_required=getVar($InputName_F2_required);
$InputName_F3_required="f3_required";
$$InputName_F3_required=getVar($InputName_F3_required);
$InputName_F4_required="f4_required";
$$InputName_F4_required=getVar($InputName_F4_required);
$InputName_F5_required="f5_required";
$$InputName_F5_required=getVar($InputName_F5_required);
$InputName_F6_required="f6_required";
$$InputName_F6_required=getVar($InputName_F6_required);
$InputName_F7_required="f7_required";
$$InputName_F7_required=getVar($InputName_F7_required);
$InputName_F8_required="f8_required";
$$InputName_F8_required=getVar($InputName_F8_required);
$InputName_F9_required="f9_required";
$$InputName_F9_required=getVar($InputName_F9_required);

$InputName_F0_value="f0_value";
$$InputName_F0_value=getVar($InputName_F0_value);
$InputName_F1_value="f1_value";
$$InputName_F1_value=getVar($InputName_F1_value);
$InputName_F2_value="f2_value";
$$InputName_F2_value=getVar($InputName_F2_value);
$InputName_F3_value="f3_value";
$$InputName_F3_value=getVar($InputName_F3_value);
$InputName_F4_value="f4_value";
$$InputName_F4_value=getVar($InputName_F4_value);
$InputName_F5_value="f5_value";
$$InputName_F5_value=getVar($InputName_F5_value);
$InputName_F6_value="f6_value";
$$InputName_F6_value=getVar($InputName_F6_value);
$InputName_F7_value="f7_value";
$$InputName_F7_value=getVar($InputName_F7_value);
$InputName_F8_value="f8_value";
$$InputName_F8_value=getVar($InputName_F8_value);
$InputName_F9_value="f9_value";
$$InputName_F9_value=getVar($InputName_F9_value);

$check=true;
if ($set=="save") {
	//checkinput
	if (empty($name)) {$check=false;$_MAIN_MESSAGE.=___("Name sollte nicht leer sein.");}
	if ($check) {
		$FORMULAR=new mnlFRM();
		$FORMULAR->addForm(Array(
				"name"=>$name,
				"descr"=>$descr,
				"aktiv"=>$aktiv, 
				"created"=>$created, 
				"author"=>$author,
				"double_optin"=>$double_optin,
				"f0"=>$f0,
				"f1"=>$f1,
				"f2"=>$f2,
				"f3"=>$f3,
				"f4"=>$f4,
				"f5"=>$f5,
				"f6"=>$f6,
				"f7"=>$f7,
				"f8"=>$f8,
				"f9"=>$f9,
				"f0_type"=>$f0_type,
				"f1_type"=>$f1_type,
				"f2_type"=>$f2_type,
				"f3_type"=>$f3_type,
				"f4_type"=>$f4_type,
				"f5_type"=>$f5_type,
				"f6_type"=>$f6_type,
				"f7_type"=>$f7_type,
				"f8_type"=>$f8_type,
				"f9_type"=>$f9_type,
				"f0_required"=>$f0_required,
				"f1_required"=>$f1_required,
				"f2_required"=>$f2_required,
				"f3_required"=>$f3_required,
				"f4_required"=>$f4_required,
				"f5_required"=>$f5_required,
				"f6_required"=>$f6_required,
				"f7_required"=>$f7_required,
				"f8_required"=>$f8_required,
				"f9_required"=>$f9_required, 
				"f0_value"=>$f0_value, 
				"f1_value"=>$f1_value, 
				"f2_value"=>$f2_value, 
				"f3_value"=>$f3_value, 
				"f4_value"=>$f4_value, 
				"f5_value"=>$f5_value, 
				"f6_value"=>$f6_value, 
				"f7_value"=>$f7_value, 
				"f8_value"=>$f8_value, 
				"f9_value"=>$f9_value
				),
				$adr_grp);
		$_MAIN_MESSAGE.="<br>".sprintf(___("Neues Formular %s wurde erstellt."),"'<b>".$name."</b>'");
		$action="form_list";
		include_once ($mnl_includepath."/form_list.inc");
	} else {
		include_once ($mnl_includepath."/form_form.inc");
	}
	
} else {
	include_once ($mnl_includepath."/form_form.inc");
}
?>