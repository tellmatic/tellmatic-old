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

$InputName_Submit="submit";
$InputName_Reset="reset";

//Form
$Form=new mSimpleForm();
$FormularName="subscribe".$FRM[0]['id'];
//make new Form
//$Form->new_Form($FormularName,$mnl_URL."/subscribe.php","post","_self");
$Form->new_Form($FormularName,$_SERVER["PHP_SELF"],"post","_self");

//add a Description
$Form->set_FormDesc($FormularName,"subscribe");
$Form->new_Input($FormularName,"set", "hidden", "save");
$Form->new_Input($FormularName,"fid", "hidden", $frm_id);
$Form->new_Input($FormularName,"cpt", "hidden", $captcha_code);

//////////////////
//add inputfields and buttons....
//////////////////
//EMAIL
$Form->new_Input($FormularName,$InputName_Name,"text", $$InputName_Name);
$Form->set_InputStyleClass($FormularName,$InputName_Name,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Name,48,256);
$Form->set_InputDesc($FormularName,$InputName_Name,"");
$Form->set_InputReadonly($FormularName,$InputName_Name,false);
$Form->set_InputOrder($FormularName,$InputName_Name,1);
$Form->set_InputLabel($FormularName,$InputName_Name,"");

//Captcha
$Form->new_Input($FormularName,$InputName_Captcha,"text", "");
$Form->set_InputStyleClass($FormularName,$InputName_Captcha,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Captcha,8,4);
$Form->set_InputDesc($FormularName,$InputName_Captcha,"");
$Form->set_InputReadonly($FormularName,$InputName_Captcha,false);
$Form->set_InputOrder($FormularName,$InputName_Captcha,1);
$Form->set_InputLabel($FormularName,$InputName_Captcha,"");


//F
if ($FRM[0]['f0_type']=="checkbox") {$$InputName_F0=1;} //die einfache variante, die andere waere new input value=1 wenn checkbox, sonst $$, das is aber so viel.....
$Form->new_Input($FormularName,$InputName_F0,$FRM[0]['f0_type'], $$InputName_F0);
$Form->set_InputDefault($FormularName,$InputName_F0,$$InputName_F0);
$Form->set_InputStyleClass($FormularName,$InputName_F0,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F0,48,256);
$Form->set_InputDesc($FormularName,$InputName_F0,"");
$Form->set_InputReadonly($FormularName,$InputName_F0,false);
$Form->set_InputOrder($FormularName,$InputName_F0,1);
$Form->set_InputLabel($FormularName,$InputName_F0,"");
if ($FRM[0]['f0_type']=="select" && !empty($FRM[0]['f0_value'])) {
	$Form->set_InputMultiple($FormularName,$InputName_F0,false);
	$Form->set_InputSize($FormularName,$InputName_F0,1,1);
	$val=explode(";",$FRM[0]['f0_value']);
	foreach ($val as $value) {
		$Form->add_InputOption($FormularName,$InputName_F0,$value,$value);
	}
}

//F
if ($FRM[0]['f1_type']=="checkbox") {$$InputName_F1=1;} //die einfache variante, die andere waere new input value=1 wenn checkbox, sonst $$, das is aber so viel.....
$Form->new_Input($FormularName,$InputName_F1,$FRM[0]['f1_type'], $$InputName_F1);
$Form->set_InputDefault($FormularName,$InputName_F1,$$InputName_F1);
$Form->set_InputStyleClass($FormularName,$InputName_F1,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F1,48,256);
$Form->set_InputDesc($FormularName,$InputName_F1,"");
$Form->set_InputReadonly($FormularName,$InputName_F1,false);
$Form->set_InputOrder($FormularName,$InputName_F1,1);
$Form->set_InputLabel($FormularName,$InputName_F1,"");
if ($FRM[0]['f1_type']=="select" && !empty($FRM[0]['f1_value'])) {
	$Form->set_InputMultiple($FormularName,$InputName_F1,false);
	$Form->set_InputSize($FormularName,$InputName_F1,1,1);
	$val=explode(";",$FRM[0]['f1_value']);
	foreach ($val as $value) {
		$Form->add_InputOption($FormularName,$InputName_F1,$value,$value);
	}
}
//F
if ($FRM[0]['f2_type']=="checkbox") {$$InputName_F2=1;} //die einfache variante, die andere waere new input value=1 wenn checkbox, sonst $$, das is aber so viel.....
$Form->new_Input($FormularName,$InputName_F2,$FRM[0]['f2_type'], $$InputName_F2);
$Form->set_InputDefault($FormularName,$InputName_F2,$$InputName_F2);
$Form->set_InputStyleClass($FormularName,$InputName_F2,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F2,48,256);
$Form->set_InputDesc($FormularName,$InputName_F2,"");
$Form->set_InputReadonly($FormularName,$InputName_F2,false);
$Form->set_InputOrder($FormularName,$InputName_F2,1);
$Form->set_InputLabel($FormularName,$InputName_F2,"");
if ($FRM[0]['f2_type']=="select" && !empty($FRM[0]['f2_value'])) {
	$Form->set_InputMultiple($FormularName,$InputName_F2,false);
	$Form->set_InputSize($FormularName,$InputName_F2,1,1);
	$val=explode(";",$FRM[0]['f2_value']);
	foreach ($val as $value) {
		$Form->add_InputOption($FormularName,$InputName_F2,$value,$value);
	}
}
//F
if ($FRM[0]['f3_type']=="checkbox") {$$InputName_F3=1;} //die einfache variante, die andere waere new input value=1 wenn checkbox, sonst $$, das is aber so viel.....
$Form->new_Input($FormularName,$InputName_F3,$FRM[0]['f3_type'], $$InputName_F3);
$Form->set_InputDefault($FormularName,$InputName_F3,$$InputName_F3);
$Form->set_InputStyleClass($FormularName,$InputName_F3,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F3,48,256);
$Form->set_InputDesc($FormularName,$InputName_F3,"");
$Form->set_InputReadonly($FormularName,$InputName_F3,false);
$Form->set_InputOrder($FormularName,$InputName_F3,1);
$Form->set_InputLabel($FormularName,$InputName_F3,"");
if ($FRM[0]['f3_type']=="select" && !empty($FRM[0]['f3_value'])) {
	$Form->set_InputMultiple($FormularName,$InputName_F3,false);
	$Form->set_InputSize($FormularName,$InputName_F3,1,1);
	$val=explode(";",$FRM[0]['f3_value']);
	foreach ($val as $value) {
		$Form->add_InputOption($FormularName,$InputName_F3,$value,$value);
	}
}
//F
if ($FRM[0]['f4_type']=="checkbox") {$$InputName_F4=1;} //die einfache variante, die andere waere new input value=1 wenn checkbox, sonst $$, das is aber so viel.....
$Form->new_Input($FormularName,$InputName_F4,$FRM[0]['f4_type'], $$InputName_F4);
$Form->set_InputDefault($FormularName,$InputName_F4,$$InputName_F4);
$Form->set_InputStyleClass($FormularName,$InputName_F4,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F4,48,256);
$Form->set_InputDesc($FormularName,$InputName_F4,"");
$Form->set_InputReadonly($FormularName,$InputName_F4,false);
$Form->set_InputOrder($FormularName,$InputName_F4,1);
$Form->set_InputLabel($FormularName,$InputName_F4,"");
if ($FRM[0]['f4_type']=="select" && !empty($FRM[0]['f4_value'])) {
	$Form->set_InputMultiple($FormularName,$InputName_F4,false);
	$Form->set_InputSize($FormularName,$InputName_F4,1,1);
	$val=explode(";",$FRM[0]['f4_value']);
	foreach ($val as $value) {
		$Form->add_InputOption($FormularName,$InputName_F4,$value,$value);
	}
}
//F
if ($FRM[0]['f5_type']=="checkbox") {$$InputName_F5=1;} //die einfache variante, die andere waere new input value=1 wenn checkbox, sonst $$, das is aber so viel.....
$Form->new_Input($FormularName,$InputName_F5,$FRM[0]['f5_type'], $$InputName_F5);
$Form->set_InputDefault($FormularName,$InputName_F5,$$InputName_F5);
$Form->set_InputStyleClass($FormularName,$InputName_F5,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F5,48,256);
$Form->set_InputDesc($FormularName,$InputName_F5,"");
$Form->set_InputReadonly($FormularName,$InputName_F5,false);
$Form->set_InputOrder($FormularName,$InputName_F5,1);
$Form->set_InputLabel($FormularName,$InputName_F5,"");
if ($FRM[0]['f5_type']=="select" && !empty($FRM[0]['f5_value'])) {
	$Form->set_InputMultiple($FormularName,$InputName_F5,false);
	$Form->set_InputSize($FormularName,$InputName_F5,1,1);
	$val=explode(";",$FRM[0]['f5_value']);
	foreach ($val as $value) {
		$Form->add_InputOption($FormularName,$InputName_F5,$value,$value);
	}
}
//F
if ($FRM[0]['f6_type']=="checkbox") {$$InputName_F6=1;} //die einfache variante, die andere waere new input value=1 wenn checkbox, sonst $$, das is aber so viel.....
$Form->new_Input($FormularName,$InputName_F6,$FRM[0]['f6_type'], $$InputName_F6);
$Form->set_InputDefault($FormularName,$InputName_F6,$$InputName_F6);
$Form->set_InputStyleClass($FormularName,$InputName_F6,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F6,48,256);
$Form->set_InputDesc($FormularName,$InputName_F6,"");
$Form->set_InputReadonly($FormularName,$InputName_F6,false);
$Form->set_InputOrder($FormularName,$InputName_F6,1);
$Form->set_InputLabel($FormularName,$InputName_F6,"");
if ($FRM[0]['f6_type']=="select" && !empty($FRM[0]['f6_value'])) {
	$Form->set_InputMultiple($FormularName,$InputName_F6,false);
	$Form->set_InputSize($FormularName,$InputName_F6,1,1);
	$val=explode(";",$FRM[0]['f6_value']);
	foreach ($val as $value) {
		$Form->add_InputOption($FormularName,$InputName_F6,$value,$value);
	}
}
//F
if ($FRM[0]['f7_type']=="checkbox") {$$InputName_F7=1;} //die einfache variante, die andere waere new input value=1 wenn checkbox, sonst $$, das is aber so viel.....
$Form->new_Input($FormularName,$InputName_F7,$FRM[0]['f7_type'], $$InputName_F7);
$Form->set_InputDefault($FormularName,$InputName_F7,$$InputName_F7);
$Form->set_InputStyleClass($FormularName,$InputName_F7,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F7,48,256);
$Form->set_InputDesc($FormularName,$InputName_F7,"");
$Form->set_InputReadonly($FormularName,$InputName_F7,false);
$Form->set_InputOrder($FormularName,$InputName_F7,1);
$Form->set_InputLabel($FormularName,$InputName_F7,"");
if ($FRM[0]['f7_type']=="select" && !empty($FRM[0]['f7_value'])) {
	$Form->set_InputMultiple($FormularName,$InputName_F7,false);
	$Form->set_InputSize($FormularName,$InputName_F7,1,1);
	$val=explode(";",$FRM[0]['f7_value']);
	foreach ($val as $value) {
		$Form->add_InputOption($FormularName,$InputName_F7,$value,$value);
	}
}
//F
if ($FRM[0]['f8_type']=="checkbox") {$$InputName_F8=1;} //die einfache variante, die andere waere new input value=1 wenn checkbox, sonst $$, das is aber so viel.....
$Form->new_Input($FormularName,$InputName_F8,$FRM[0]['f8_type'], $$InputName_F8);
$Form->set_InputDefault($FormularName,$InputName_F8,$$InputName_F8);
$Form->set_InputStyleClass($FormularName,$InputName_F8,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F8,48,256);
$Form->set_InputDesc($FormularName,$InputName_F8,"");
$Form->set_InputReadonly($FormularName,$InputName_F8,false);
$Form->set_InputOrder($FormularName,$InputName_F8,1);
$Form->set_InputLabel($FormularName,$InputName_F8,"");
if ($FRM[0]['f8_type']=="select" && !empty($FRM[0]['f8_value'])) {
	$Form->set_InputMultiple($FormularName,$InputName_F8,false);
	$Form->set_InputSize($FormularName,$InputName_F8,1,1);
	$val=explode(";",$FRM[0]['f8_value']);
	foreach ($val as $value) {
		$Form->add_InputOption($FormularName,$InputName_F8,$value,$value);
	}
}
//F
if ($FRM[0]['f9_type']=="checkbox") {$$InputName_F9=1;} //die einfache variante, die andere waere new input value=1 wenn checkbox, sonst $$, das is aber so viel.....
$Form->new_Input($FormularName,$InputName_F9,$FRM[0]['f9_type'], $$InputName_F9);
$Form->set_InputDefault($FormularName,$InputName_F9,$$InputName_F9);
$Form->set_InputStyleClass($FormularName,$InputName_F9,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F9,48,256);
$Form->set_InputDesc($FormularName,$InputName_F9,"");
$Form->set_InputReadonly($FormularName,$InputName_F9,false);
$Form->set_InputOrder($FormularName,$InputName_F9,1);
$Form->set_InputLabel($FormularName,$InputName_F9,"");
if ($FRM[0]['f9_type']=="select" && !empty($FRM[0]['f9_value'])) {
	$Form->set_InputMultiple($FormularName,$InputName_F9,false);
	$Form->set_InputSize($FormularName,$InputName_F9,1,1);
	$val=explode(";",$FRM[0]['f9_value']);
	foreach ($val as $value) {
		$Form->add_InputOption($FormularName,$InputName_F9,$value,$value);
	}
}


//submit button 
$Form->new_Input($FormularName,$InputName_Submit,"submit","Speichern");
$Form->set_InputStyleClass($FormularName,$InputName_Submit,"mFormSubmit","mFormSubmitFocus");
$Form->set_InputDesc($FormularName,$InputName_Submit,"");
$Form->set_InputReadonly($FormularName,$InputName_Submit,false);
$Form->set_InputOrder($FormularName,$InputName_Submit,998);
$Form->set_InputLabel($FormularName,$InputName_Submit,"");

//a reset button
$Form->new_Input($FormularName,$InputName_Reset,"reset","Reset");
$Form->set_InputStyleClass($FormularName,$InputName_Reset,"mFormReset","mFormResetFocus");
$Form->set_InputDesc($FormularName,$InputName_Reset,"Reset");
$Form->set_InputReadonly($FormularName,$InputName_Reset,false);
$Form->set_InputOrder($FormularName,$InputName_Reset,999);
$Form->set_InputLabel($FormularName,$InputName_Reset,"");

/*RENDER FORM*/

$Form->render_Form($FormularName);
//then you dont have to render the head and foot .....

/*DISPLAY*/

$FHEAD= $Form->FORM[$FormularName]['head'];
$FHEAD.= $Form->INPUT[$FormularName]['set']['html'];
$FHEAD.= $Form->INPUT[$FormularName]['fid']['html'];
$FHEAD.= $Form->INPUT[$FormularName]['cpt']['html'];

$FEMAIL= $Form->INPUT[$FormularName][$InputName_Name]['html'];
$FCAPTCHA= $Form->INPUT[$FormularName][$InputName_Captcha]['html'];;

$F0="";$F1="";$F2="";$F3="";$F4="";$F5="";$F6="";$F7="";$F8="";$F9="";

if (!empty($FRM[0]['f0'])) {
	$F0= $Form->INPUT[$FormularName][$InputName_F0]['html'];
}
if (!empty($FRM[0]['f1'])) {
	$F1= $Form->INPUT[$FormularName][$InputName_F1]['html'];
}
if (!empty($FRM[0]['f2'])) {
	$F2= $Form->INPUT[$FormularName][$InputName_F2]['html'];
}
if (!empty($FRM[0]['f3'])) {
	$F3= $Form->INPUT[$FormularName][$InputName_F3]['html'];
}
if (!empty($FRM[0]['f4'])) {
	$F4= $Form->INPUT[$FormularName][$InputName_F4]['html'];
}
if (!empty($FRM[0]['f5'])) {
	$F5= $Form->INPUT[$FormularName][$InputName_F5]['html'];
}
if (!empty($FRM[0]['f6'])) {
	$F6= $Form->INPUT[$FormularName][$InputName_F6]['html'];
}
if (!empty($FRM[0]['f7'])) {
	$F7= $Form->INPUT[$FormularName][$InputName_F7]['html'];
}
if (!empty($FRM[0]['f8'])) {
	$F8= $Form->INPUT[$FormularName][$InputName_F8]['html'];
}
if (!empty($FRM[0]['f9'])) {
	$F9= $Form->INPUT[$FormularName][$InputName_F9]['html'];
}
$FSUBMIT= $Form->INPUT[$FormularName][$InputName_Submit]['html'];
$FRESET= $Form->INPUT[$FormularName][$InputName_Reset]['html'];

$FFOOT=$Form->FORM[$FormularName]['foot'];
?>