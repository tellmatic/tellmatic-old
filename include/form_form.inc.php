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

$InputName_Submit="submit";
$InputName_Reset="reset";

//Form
$Form=new tm_SimpleForm();
$FormularName="frm_new";
//make new Form
$Form->new_Form($FormularName,$_SERVER["PHP_SELF"],"post","_self");
$Form->set_FormJS($FormularName," onSubmit=\"switchSection('div_loader');\" ");
//add a Description
$Form->set_FormDesc($FormularName,___("neues Formular erstellen"));
$Form->new_Input($FormularName,"act", "hidden", $action);
$Form->new_Input($FormularName,"set", "hidden", "save");
$Form->new_Input($FormularName,"frm_id", "hidden", $frm_id);
//////////////////
//add inputfields and buttons....
//////////////////
//Name
$Form->new_Input($FormularName,$InputName_Name,"text", $$InputName_Name);
$Form->set_InputJS($FormularName,$InputName_Name," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Name,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Name,48,1024);
$Form->set_InputDesc($FormularName,$InputName_Name,___("Name"));
$Form->set_InputReadonly($FormularName,$InputName_Name,false);
$Form->set_InputOrder($FormularName,$InputName_Name,1);
$Form->set_InputLabel($FormularName,$InputName_Name,"");

//Aktiv
	$Form->new_Input($FormularName,$InputName_Aktiv,"checkbox", 1);
	$Form->set_InputJS($FormularName,$InputName_Aktiv," onChange=\"flash('submit','#ff0000');\" ");
	$Form->set_InputDefault($FormularName,$InputName_Aktiv,$$InputName_Aktiv);
	$Form->set_InputStyleClass($FormularName,$InputName_Aktiv,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_Aktiv,48,1024);
	$Form->set_InputDesc($FormularName,$InputName_Aktiv,___("Aktiv"));
	$Form->set_InputReadonly($FormularName,$InputName_Aktiv,false);
	$Form->set_InputOrder($FormularName,$InputName_Aktiv,2);
	$Form->set_InputLabel($FormularName,$InputName_Aktiv,"");

//Subscribed Adresses Aktiv
	$Form->new_Input($FormularName,$InputName_SubAktiv,"checkbox", 1);
	$Form->set_InputJS($FormularName,$InputName_SubAktiv," onChange=\"flash('submit','#ff0000');\" ");
	$Form->set_InputDefault($FormularName,$InputName_SubAktiv,$$InputName_SubAktiv);
	$Form->set_InputStyleClass($FormularName,$InputName_SubAktiv,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_SubAktiv,48,1024);
	$Form->set_InputDesc($FormularName,$InputName_SubAktiv,___("Anmeldungen sind aktiv/inaktiv"));
	$Form->set_InputReadonly($FormularName,$InputName_SubAktiv,false);
	$Form->set_InputOrder($FormularName,$InputName_SubAktiv,2);
	$Form->set_InputLabel($FormularName,$InputName_SubAktiv,"");


//Use Captcha
	$Form->new_Input($FormularName,$InputName_UseCaptcha,"checkbox", 1);
	$Form->set_InputJS($FormularName,$InputName_UseCaptcha," onChange=\"flash('submit','#ff0000');\" ");
	$Form->set_InputDefault($FormularName,$InputName_UseCaptcha,$$InputName_UseCaptcha);
	$Form->set_InputStyleClass($FormularName,$InputName_UseCaptcha,"mFormText","mFormTextFocus");
	$Form->set_InputDesc($FormularName,$InputName_UseCaptcha,___("Captcha prüfen"));
	$Form->set_InputReadonly($FormularName,$InputName_UseCaptcha,false);
	$Form->set_InputOrder($FormularName,$InputName_UseCaptcha,2);
	$Form->set_InputLabel($FormularName,$InputName_UseCaptcha,"");

//DigitsCaptcha
$Form->new_Input($FormularName,$InputName_DigitsCaptcha,"select", "");
$Form->set_InputJS($FormularName,$InputName_DigitsCaptcha," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_DigitsCaptcha,$$InputName_DigitsCaptcha);
$Form->set_InputStyleClass($FormularName,$InputName_DigitsCaptcha,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_DigitsCaptcha,___("Ziffern"));
$Form->set_InputReadonly($FormularName,$InputName_DigitsCaptcha,false);
$Form->set_InputOrder($FormularName,$InputName_DigitsCaptcha,6);
$Form->set_InputLabel($FormularName,$InputName_DigitsCaptcha,"");
$Form->set_InputSize($FormularName,$InputName_DigitsCaptcha,0,1);
$Form->set_InputMultiple($FormularName,$InputName_DigitsCaptcha,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_DigitsCaptcha,4,"4");
$Form->add_InputOption($FormularName,$InputName_DigitsCaptcha,5,"5");
$Form->add_InputOption($FormularName,$InputName_DigitsCaptcha,6,"6");
$Form->add_InputOption($FormularName,$InputName_DigitsCaptcha,7,"7");
$Form->add_InputOption($FormularName,$InputName_DigitsCaptcha,8,"8");
$Form->add_InputOption($FormularName,$InputName_DigitsCaptcha,9,"9");
$Form->add_InputOption($FormularName,$InputName_DigitsCaptcha,10,"10");


//double optin
	$Form->new_Input($FormularName,$InputName_DoubleOptin,"checkbox", 1);
	$Form->set_InputJS($FormularName,$InputName_DoubleOptin," onChange=\"flash('submit','#ff0000');\" ");
	$Form->set_InputDefault($FormularName,$InputName_DoubleOptin,$$InputName_DoubleOptin);
	$Form->set_InputStyleClass($FormularName,$InputName_DoubleOptin,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_DoubleOptin,48,1024);
	$Form->set_InputDesc($FormularName,$InputName_DoubleOptin,___("Aktiv"));
	$Form->set_InputReadonly($FormularName,$InputName_DoubleOptin,false);
	$Form->set_InputOrder($FormularName,$InputName_DoubleOptin,2);
	$Form->set_InputLabel($FormularName,$InputName_DoubleOptin,"");

//Beschreibung
$Form->new_Input($FormularName,$InputName_Descr,"textarea", $$InputName_Descr);
$Form->set_InputJS($FormularName,$InputName_Descr," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Descr,"mFormTextarea","mFormTextareaFocus");
$Form->set_InputSize($FormularName,$InputName_Descr,20,3);
$Form->set_InputDesc($FormularName,$InputName_Descr,___("Beschreibung"));
$Form->set_InputReadonly($FormularName,$InputName_Descr,false);
$Form->set_InputOrder($FormularName,$InputName_Descr,3);
$Form->set_InputLabel($FormularName,$InputName_Descr,"");

//Gruppe
$Form->new_Input($FormularName,$InputName_Group,"select", "");
$Form->set_InputJS($FormularName,$InputName_Group," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Group,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Group,___("Gruppen wählen, STRG/CTRL gedrückt halten und klicken f. Mehrfachauswahl"));
$Form->set_InputReadonly($FormularName,$InputName_Group,false);
$Form->set_InputOrder($FormularName,$InputName_Group,6);
$Form->set_InputLabel($FormularName,$InputName_Group,"");
$Form->set_InputSize($FormularName,$InputName_Group,0,5);
$Form->set_InputMultiple($FormularName,$InputName_Group,true);
//add Data
$ADDRESS=new tm_ADR();
$GRP=$ADDRESS->getGroup();
$acg=count($GRP);
for ($accg=0; $accg<$acg; $accg++)
{
	$Form->add_InputOption($FormularName,$InputName_Group,$GRP[$accg]['id'],$GRP[$accg]['name']);
}

//SubmitValue
$Form->new_Input($FormularName,$InputName_SubmitValue,"text", $$InputName_SubmitValue);
$Form->set_InputJS($FormularName,$InputName_SubmitValue," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_SubmitValue,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_SubmitValue,32,255);
$Form->set_InputDesc($FormularName,$InputName_SubmitValue,"");
$Form->set_InputReadonly($FormularName,$InputName_SubmitValue,false);
$Form->set_InputOrder($FormularName,$InputName_SubmitValue,1);
$Form->set_InputLabel($FormularName,$InputName_SubmitValue,"");

//ResetValue
$Form->new_Input($FormularName,$InputName_ResetValue,"text", $$InputName_ResetValue);
$Form->set_InputJS($FormularName,$InputName_ResetValue," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_ResetValue,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_ResetValue,32,255);
$Form->set_InputDesc($FormularName,$InputName_ResetValue,"");
$Form->set_InputReadonly($FormularName,$InputName_ResetValue,false);
$Form->set_InputOrder($FormularName,$InputName_ResetValue,1);
$Form->set_InputLabel($FormularName,$InputName_ResetValue,"");


//Femailname
$Form->new_Input($FormularName,$InputName_email,"text", $$InputName_email);
$Form->set_InputJS($FormularName,$InputName_email," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_email,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_email,32,255);
$Form->set_InputDesc($FormularName,$InputName_email,"email");
$Form->set_InputReadonly($FormularName,$InputName_email,false);
$Form->set_InputOrder($FormularName,$InputName_email,1);
$Form->set_InputLabel($FormularName,$InputName_email,"");

//F
$Form->new_Input($FormularName,$InputName_F0,"text", $$InputName_F0);
$Form->set_InputJS($FormularName,$InputName_F0," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F0,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F0,32,1024);
$Form->set_InputDesc($FormularName,$InputName_F0,"F0");
$Form->set_InputReadonly($FormularName,$InputName_F0,false);
$Form->set_InputOrder($FormularName,$InputName_F0,1);
$Form->set_InputLabel($FormularName,$InputName_F0,"");

//F
$Form->new_Input($FormularName,$InputName_F1,"text", $$InputName_F1);
$Form->set_InputJS($FormularName,$InputName_F1," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F1,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F1,32,1024);
$Form->set_InputDesc($FormularName,$InputName_F1,"F1");
$Form->set_InputReadonly($FormularName,$InputName_F1,false);
$Form->set_InputOrder($FormularName,$InputName_F1,1);
$Form->set_InputLabel($FormularName,$InputName_F1,"");

//F
$Form->new_Input($FormularName,$InputName_F2,"text", $$InputName_F2);
$Form->set_InputJS($FormularName,$InputName_F2," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F2,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F2,32,1024);
$Form->set_InputDesc($FormularName,$InputName_F2,"F2");
$Form->set_InputReadonly($FormularName,$InputName_F2,false);
$Form->set_InputOrder($FormularName,$InputName_F2,1);
$Form->set_InputLabel($FormularName,$InputName_F2,"");

//F
$Form->new_Input($FormularName,$InputName_F3,"text", $$InputName_F3);
$Form->set_InputJS($FormularName,$InputName_F3," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F3,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F3,32,1024);
$Form->set_InputDesc($FormularName,$InputName_F3,"F3");
$Form->set_InputReadonly($FormularName,$InputName_F3,false);
$Form->set_InputOrder($FormularName,$InputName_F3,1);
$Form->set_InputLabel($FormularName,$InputName_F3,"");

//F
$Form->new_Input($FormularName,$InputName_F4,"text", $$InputName_F4);
$Form->set_InputJS($FormularName,$InputName_F4," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F4,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F4,32,1024);
$Form->set_InputDesc($FormularName,$InputName_F4,"F4");
$Form->set_InputReadonly($FormularName,$InputName_F4,false);
$Form->set_InputOrder($FormularName,$InputName_F4,1);
$Form->set_InputLabel($FormularName,$InputName_F4,"");

//F
$Form->new_Input($FormularName,$InputName_F5,"text", $$InputName_F5);
$Form->set_InputJS($FormularName,$InputName_F5," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F5,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F5,32,1024);
$Form->set_InputDesc($FormularName,$InputName_F5,"F5");
$Form->set_InputReadonly($FormularName,$InputName_F5,false);
$Form->set_InputOrder($FormularName,$InputName_F5,1);
$Form->set_InputLabel($FormularName,$InputName_F5,"");

//F
$Form->new_Input($FormularName,$InputName_F6,"text", $$InputName_F6);
$Form->set_InputJS($FormularName,$InputName_F6," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F6,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F6,32,1024);
$Form->set_InputDesc($FormularName,$InputName_F6,"F6");
$Form->set_InputReadonly($FormularName,$InputName_F6,false);
$Form->set_InputOrder($FormularName,$InputName_F6,1);
$Form->set_InputLabel($FormularName,$InputName_F6,"");

//F
$Form->new_Input($FormularName,$InputName_F7,"text", $$InputName_F7);
$Form->set_InputJS($FormularName,$InputName_F7," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F7,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F7,32,1024);
$Form->set_InputDesc($FormularName,$InputName_F7,"F7");
$Form->set_InputReadonly($FormularName,$InputName_F7,false);
$Form->set_InputOrder($FormularName,$InputName_F7,1);
$Form->set_InputLabel($FormularName,$InputName_F7,"");

//F
$Form->new_Input($FormularName,$InputName_F8,"text", $$InputName_F8);
$Form->set_InputJS($FormularName,$InputName_F8," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F8,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F8,32,1024);
$Form->set_InputDesc($FormularName,$InputName_F8,"F8");
$Form->set_InputReadonly($FormularName,$InputName_F8,false);
$Form->set_InputOrder($FormularName,$InputName_F8,1);
$Form->set_InputLabel($FormularName,$InputName_F8,"");

//F
$Form->new_Input($FormularName,$InputName_F9,"text", $$InputName_F9);
$Form->set_InputJS($FormularName,$InputName_F9," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F9,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F9,32,1024);
$Form->set_InputDesc($FormularName,$InputName_F9,"F9");
$Form->set_InputReadonly($FormularName,$InputName_F9,false);
$Form->set_InputOrder($FormularName,$InputName_F9,1);
$Form->set_InputLabel($FormularName,$InputName_F9,"");

/////////////////////////// f type

//Typ //checkbox, text...
$Form->new_Input($FormularName,$InputName_F0_type,"select", "");
$Form->set_InputJS($FormularName,$InputName_F0_type," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_F0_type,$$InputName_F0_type);
$Form->set_InputStyleClass($FormularName,$InputName_F0_type,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_F0_type,___("Typ wählen"));
$Form->set_InputReadonly($FormularName,$InputName_F0_type,false);
$Form->set_InputOrder($FormularName,$InputName_F0_type,6);
$Form->set_InputLabel($FormularName,$InputName_F0_type,"");
$Form->set_InputSize($FormularName,$InputName_F0_type,0,1);
$Form->set_InputMultiple($FormularName,$InputName_F0_type,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_F0_type,"text","TEXT");
$Form->add_InputOption($FormularName,$InputName_F0_type,"checkbox","CHECKBOX");
$Form->add_InputOption($FormularName,$InputName_F0_type,"select","SELECT");

//Typ //checkbox, text...
$Form->new_Input($FormularName,$InputName_F1_type,"select", "");
$Form->set_InputJS($FormularName,$InputName_F1_type," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_F1_type,$$InputName_F1_type);
$Form->set_InputStyleClass($FormularName,$InputName_F1_type,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_F1_type,___("Typ wählen"));
$Form->set_InputReadonly($FormularName,$InputName_F1_type,false);
$Form->set_InputOrder($FormularName,$InputName_F1_type,6);
$Form->set_InputLabel($FormularName,$InputName_F1_type,"");
$Form->set_InputSize($FormularName,$InputName_F1_type,0,1);
$Form->set_InputMultiple($FormularName,$InputName_F1_type,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_F1_type,"text","TEXT");
$Form->add_InputOption($FormularName,$InputName_F1_type,"checkbox","CHECKBOX");
$Form->add_InputOption($FormularName,$InputName_F1_type,"select","SELECT");

//Typ //checkbox, text...
$Form->new_Input($FormularName,$InputName_F2_type,"select", "");
$Form->set_InputJS($FormularName,$InputName_F2_type," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_F2_type,$$InputName_F2_type);
$Form->set_InputStyleClass($FormularName,$InputName_F2_type,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_F2_type,___("Typ wählen"));
$Form->set_InputReadonly($FormularName,$InputName_F2_type,false);
$Form->set_InputOrder($FormularName,$InputName_F2_type,6);
$Form->set_InputLabel($FormularName,$InputName_F2_type,"");
$Form->set_InputSize($FormularName,$InputName_F2_type,0,1);
$Form->set_InputMultiple($FormularName,$InputName_F2_type,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_F2_type,"text","TEXT");
$Form->add_InputOption($FormularName,$InputName_F2_type,"checkbox","CHECKBOX");
$Form->add_InputOption($FormularName,$InputName_F2_type,"select","SELECT");

//Typ //checkbox, text...
$Form->new_Input($FormularName,$InputName_F3_type,"select", "");
$Form->set_InputJS($FormularName,$InputName_F3_type," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_F3_type,$$InputName_F3_type);
$Form->set_InputStyleClass($FormularName,$InputName_F3_type,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_F3_type,___("Typ wählen"));
$Form->set_InputReadonly($FormularName,$InputName_F3_type,false);
$Form->set_InputOrder($FormularName,$InputName_F3_type,6);
$Form->set_InputLabel($FormularName,$InputName_F3_type,"");
$Form->set_InputSize($FormularName,$InputName_F3_type,0,1);
$Form->set_InputMultiple($FormularName,$InputName_F3_type,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_F3_type,"text","TEXT");
$Form->add_InputOption($FormularName,$InputName_F3_type,"checkbox","CHECKBOX");
$Form->add_InputOption($FormularName,$InputName_F3_type,"select","SELECT");

//Typ //checkbox, text...
$Form->new_Input($FormularName,$InputName_F4_type,"select", "");
$Form->set_InputJS($FormularName,$InputName_F4_type," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_F4_type,$$InputName_F4_type);
$Form->set_InputStyleClass($FormularName,$InputName_F4_type,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_F4_type,___("Typ wählen"));
$Form->set_InputReadonly($FormularName,$InputName_F4_type,false);
$Form->set_InputOrder($FormularName,$InputName_F4_type,6);
$Form->set_InputLabel($FormularName,$InputName_F4_type,"");
$Form->set_InputSize($FormularName,$InputName_F4_type,0,1);
$Form->set_InputMultiple($FormularName,$InputName_F4_type,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_F4_type,"text","TEXT");
$Form->add_InputOption($FormularName,$InputName_F4_type,"checkbox","CHECKBOX");
$Form->add_InputOption($FormularName,$InputName_F4_type,"select","SELECT");

//Typ //checkbox, text...
$Form->new_Input($FormularName,$InputName_F5_type,"select", "");
$Form->set_InputJS($FormularName,$InputName_F5_type," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_F5_type,$$InputName_F5_type);
$Form->set_InputStyleClass($FormularName,$InputName_F5_type,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_F5_type,___("Typ wählen"));
$Form->set_InputReadonly($FormularName,$InputName_F5_type,false);
$Form->set_InputOrder($FormularName,$InputName_F5_type,6);
$Form->set_InputLabel($FormularName,$InputName_F5_type,"");
$Form->set_InputSize($FormularName,$InputName_F5_type,0,1);
$Form->set_InputMultiple($FormularName,$InputName_F5_type,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_F5_type,"text","TEXT");
$Form->add_InputOption($FormularName,$InputName_F5_type,"checkbox","CHECKBOX");
$Form->add_InputOption($FormularName,$InputName_F5_type,"select","SELECT");

//Typ //checkbox, text...
$Form->new_Input($FormularName,$InputName_F6_type,"select", "");
$Form->set_InputJS($FormularName,$InputName_F6_type," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_F6_type,$$InputName_F6_type);
$Form->set_InputStyleClass($FormularName,$InputName_F6_type,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_F6_type,___("Typ wählen"));
$Form->set_InputReadonly($FormularName,$InputName_F6_type,false);
$Form->set_InputOrder($FormularName,$InputName_F6_type,6);
$Form->set_InputLabel($FormularName,$InputName_F6_type,"");
$Form->set_InputSize($FormularName,$InputName_F6_type,0,1);
$Form->set_InputMultiple($FormularName,$InputName_F6_type,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_F6_type,"text","TEXT");
$Form->add_InputOption($FormularName,$InputName_F6_type,"checkbox","CHECKBOX");
$Form->add_InputOption($FormularName,$InputName_F6_type,"select","SELECT");

//Typ //checkbox, text...
$Form->new_Input($FormularName,$InputName_F7_type,"select", "");
$Form->set_InputJS($FormularName,$InputName_F7_type," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_F7_type,$$InputName_F7_type);
$Form->set_InputStyleClass($FormularName,$InputName_F7_type,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_F7_type,___("Typ wählen"));
$Form->set_InputReadonly($FormularName,$InputName_F7_type,false);
$Form->set_InputOrder($FormularName,$InputName_F7_type,6);
$Form->set_InputLabel($FormularName,$InputName_F7_type,"");
$Form->set_InputSize($FormularName,$InputName_F7_type,0,1);
$Form->set_InputMultiple($FormularName,$InputName_F7_type,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_F7_type,"text","TEXT");
$Form->add_InputOption($FormularName,$InputName_F7_type,"checkbox","CHECKBOX");
$Form->add_InputOption($FormularName,$InputName_F7_type,"select","SELECT");

//Typ //checkbox, text...
$Form->new_Input($FormularName,$InputName_F8_type,"select", "");
$Form->set_InputJS($FormularName,$InputName_F8_type," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_F8_type,$$InputName_F8_type);
$Form->set_InputStyleClass($FormularName,$InputName_F8_type,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_F8_type,___("Typ wählen"));
$Form->set_InputReadonly($FormularName,$InputName_F8_type,false);
$Form->set_InputOrder($FormularName,$InputName_F8_type,6);
$Form->set_InputLabel($FormularName,$InputName_F8_type,"");
$Form->set_InputSize($FormularName,$InputName_F8_type,0,1);
$Form->set_InputMultiple($FormularName,$InputName_F8_type,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_F8_type,"text","TEXT");
$Form->add_InputOption($FormularName,$InputName_F8_type,"checkbox","CHECKBOX");
$Form->add_InputOption($FormularName,$InputName_F8_type,"select","SELECT");

//Typ //checkbox, text...
$Form->new_Input($FormularName,$InputName_F9_type,"select", "");
$Form->set_InputJS($FormularName,$InputName_F9_type," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_F9_type,$$InputName_F9_type);
$Form->set_InputStyleClass($FormularName,$InputName_F9_type,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_F9_type,___("Typ wählen"));
$Form->set_InputReadonly($FormularName,$InputName_F9_type,false);
$Form->set_InputOrder($FormularName,$InputName_F9_type,6);
$Form->set_InputLabel($FormularName,$InputName_F9_type,"");
$Form->set_InputSize($FormularName,$InputName_F9_type,0,1);
$Form->set_InputMultiple($FormularName,$InputName_F9_type,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_F9_type,"text","TEXT");
$Form->add_InputOption($FormularName,$InputName_F9_type,"checkbox","CHECKBOX");
$Form->add_InputOption($FormularName,$InputName_F9_type,"select","SELECT");



/////////////////////////// f required


//required
	$Form->new_Input($FormularName,$InputName_F0_required,"checkbox", 1);
	$Form->set_InputJS($FormularName,$InputName_F0_required," onChange=\"flash('submit','#ff0000');\" ");
	$Form->set_InputDefault($FormularName,$InputName_F0_required,$$InputName_F0_required);
	$Form->set_InputStyleClass($FormularName,$InputName_F0_required,"mFormText","mFormTextFocus");
	$Form->set_InputDesc($FormularName,$InputName_F0_required,___("Pflichtfeld"));
	$Form->set_InputReadonly($FormularName,$InputName_F0_required,false);
	$Form->set_InputOrder($FormularName,$InputName_F0_required,2);
	$Form->set_InputLabel($FormularName,$InputName_F0_required,"");

//required
	$Form->new_Input($FormularName,$InputName_F1_required,"checkbox", 1);
	$Form->set_InputJS($FormularName,$InputName_F1_required," onChange=\"flash('submit','#ff0000');\" ");
	$Form->set_InputDefault($FormularName,$InputName_F1_required,$$InputName_F1_required);
	$Form->set_InputStyleClass($FormularName,$InputName_F1_required,"mFormText","mFormTextFocus");
	$Form->set_InputDesc($FormularName,$InputName_F1_required,___("Pflichtfeld"));
	$Form->set_InputReadonly($FormularName,$InputName_F1_required,false);
	$Form->set_InputOrder($FormularName,$InputName_F1_required,2);
	$Form->set_InputLabel($FormularName,$InputName_F1_required,"");

//required
	$Form->new_Input($FormularName,$InputName_F2_required,"checkbox", 1);
	$Form->set_InputJS($FormularName,$InputName_F2_required," onChange=\"flash('submit','#ff0000');\" ");
	$Form->set_InputDefault($FormularName,$InputName_F2_required,$$InputName_F2_required);
	$Form->set_InputStyleClass($FormularName,$InputName_F2_required,"mFormText","mFormTextFocus");
	$Form->set_InputDesc($FormularName,$InputName_F2_required,___("Pflichtfeld"));
	$Form->set_InputReadonly($FormularName,$InputName_F2_required,false);
	$Form->set_InputOrder($FormularName,$InputName_F2_required,2);
	$Form->set_InputLabel($FormularName,$InputName_F2_required,"");

//required
	$Form->new_Input($FormularName,$InputName_F3_required,"checkbox", 1);
	$Form->set_InputJS($FormularName,$InputName_F3_required," onChange=\"flash('submit','#ff0000');\" ");
	$Form->set_InputDefault($FormularName,$InputName_F3_required,$$InputName_F3_required);
	$Form->set_InputStyleClass($FormularName,$InputName_F3_required,"mFormText","mFormTextFocus");
	$Form->set_InputDesc($FormularName,$InputName_F3_required,___("Pflichtfeld"));
	$Form->set_InputReadonly($FormularName,$InputName_F3_required,false);
	$Form->set_InputOrder($FormularName,$InputName_F3_required,2);
	$Form->set_InputLabel($FormularName,$InputName_F3_required,"");

//required
	$Form->new_Input($FormularName,$InputName_F4_required,"checkbox", 1);
	$Form->set_InputJS($FormularName,$InputName_F4_required," onChange=\"flash('submit','#ff0000');\" ");
	$Form->set_InputDefault($FormularName,$InputName_F4_required,$$InputName_F4_required);
	$Form->set_InputStyleClass($FormularName,$InputName_F4_required,"mFormText","mFormTextFocus");
	$Form->set_InputDesc($FormularName,$InputName_F4_required,___("Pflichtfeld"));
	$Form->set_InputReadonly($FormularName,$InputName_F4_required,false);
	$Form->set_InputOrder($FormularName,$InputName_F4_required,2);
	$Form->set_InputLabel($FormularName,$InputName_F4_required,"");

//required
	$Form->new_Input($FormularName,$InputName_F5_required,"checkbox", 1);
	$Form->set_InputJS($FormularName,$InputName_F5_required," onChange=\"flash('submit','#ff0000');\" ");
	$Form->set_InputDefault($FormularName,$InputName_F5_required,$$InputName_F5_required);
	$Form->set_InputStyleClass($FormularName,$InputName_F5_required,"mFormText","mFormTextFocus");
	$Form->set_InputDesc($FormularName,$InputName_F5_required,___("Pflichtfeld"));
	$Form->set_InputReadonly($FormularName,$InputName_F5_required,false);
	$Form->set_InputOrder($FormularName,$InputName_F5_required,2);
	$Form->set_InputLabel($FormularName,$InputName_F5_required,"");

//required
	$Form->new_Input($FormularName,$InputName_F6_required,"checkbox", 1);
	$Form->set_InputJS($FormularName,$InputName_F6_required," onChange=\"flash('submit','#ff0000');\" ");
	$Form->set_InputDefault($FormularName,$InputName_F6_required,$$InputName_F6_required);
	$Form->set_InputStyleClass($FormularName,$InputName_F6_required,"mFormText","mFormTextFocus");
	$Form->set_InputDesc($FormularName,$InputName_F6_required,___("Pflichtfeld"));
	$Form->set_InputReadonly($FormularName,$InputName_F6_required,false);
	$Form->set_InputOrder($FormularName,$InputName_F6_required,2);
	$Form->set_InputLabel($FormularName,$InputName_F6_required,"");

//required
	$Form->new_Input($FormularName,$InputName_F7_required,"checkbox", 1);
	$Form->set_InputJS($FormularName,$InputName_F7_required," onChange=\"flash('submit','#ff0000');\" ");
	$Form->set_InputDefault($FormularName,$InputName_F7_required,$$InputName_F7_required);
	$Form->set_InputStyleClass($FormularName,$InputName_F7_required,"mFormText","mFormTextFocus");
	$Form->set_InputDesc($FormularName,$InputName_F7_required,___("Pflichtfeld"));
	$Form->set_InputReadonly($FormularName,$InputName_F7_required,false);
	$Form->set_InputOrder($FormularName,$InputName_F7_required,2);
	$Form->set_InputLabel($FormularName,$InputName_F7_required,"");

//required
	$Form->new_Input($FormularName,$InputName_F8_required,"checkbox", 1);
	$Form->set_InputJS($FormularName,$InputName_F8_required," onChange=\"flash('submit','#ff0000');\" ");
	$Form->set_InputDefault($FormularName,$InputName_F8_required,$$InputName_F8_required);
	$Form->set_InputStyleClass($FormularName,$InputName_F8_required,"mFormText","mFormTextFocus");
	$Form->set_InputDesc($FormularName,$InputName_F8_required,___("Pflichtfeld"));
	$Form->set_InputReadonly($FormularName,$InputName_F8_required,false);
	$Form->set_InputOrder($FormularName,$InputName_F8_required,2);
	$Form->set_InputLabel($FormularName,$InputName_F8_required,"");

//required
	$Form->new_Input($FormularName,$InputName_F9_required,"checkbox", 1);
	$Form->set_InputJS($FormularName,$InputName_F9_required," onChange=\"flash('submit','#ff0000');\" ");
	$Form->set_InputDefault($FormularName,$InputName_F9_required,$$InputName_F9_required);
	$Form->set_InputStyleClass($FormularName,$InputName_F9_required,"mFormText","mFormTextFocus");
	$Form->set_InputDesc($FormularName,$InputName_F9_required,___("Pflichtfeld"));
	$Form->set_InputReadonly($FormularName,$InputName_F9_required,false);
	$Form->set_InputOrder($FormularName,$InputName_F9_required,2);
	$Form->set_InputLabel($FormularName,$InputName_F9_required,"");

/////////////////////////////////////////

//Values
$Form->new_Input($FormularName,$InputName_F0_value,"text", $$InputName_F0_value);
$Form->set_InputJS($FormularName,$InputName_F0_value," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F0_value,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F0_value,32,1024);
$Form->set_InputDesc($FormularName,$InputName_F0_value,___("Werte, (Trennzeichen ; (Semikolon)"));
$Form->set_InputReadonly($FormularName,$InputName_F0_value,false);
$Form->set_InputOrder($FormularName,$InputName_F0_value,1);
$Form->set_InputLabel($FormularName,$InputName_F0_value,"");

//Values
$Form->new_Input($FormularName,$InputName_F1_value,"text", $$InputName_F1_value);
$Form->set_InputJS($FormularName,$InputName_F1_value," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F1_value,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F1_value,32,1024);
$Form->set_InputDesc($FormularName,$InputName_F1_value,___("Werte, (Trennzeichen ; (Semikolon)"));
$Form->set_InputReadonly($FormularName,$InputName_F1_value,false);
$Form->set_InputOrder($FormularName,$InputName_F1_value,1);
$Form->set_InputLabel($FormularName,$InputName_F1_value,"");

//Values
$Form->new_Input($FormularName,$InputName_F2_value,"text", $$InputName_F2_value);
$Form->set_InputJS($FormularName,$InputName_F2_value," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F2_value,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F2_value,32,1024);
$Form->set_InputDesc($FormularName,$InputName_F2_value,___("Werte, (Trennzeichen ; (Semikolon)"));
$Form->set_InputReadonly($FormularName,$InputName_F2_value,false);
$Form->set_InputOrder($FormularName,$InputName_F2_value,1);
$Form->set_InputLabel($FormularName,$InputName_F2_value,"");

//Values
$Form->new_Input($FormularName,$InputName_F3_value,"text", $$InputName_F3_value);
$Form->set_InputJS($FormularName,$InputName_F3_value," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F3_value,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F3_value,32,1024);
$Form->set_InputDesc($FormularName,$InputName_F3_value,___("Werte, (Trennzeichen ; (Semikolon)"));
$Form->set_InputReadonly($FormularName,$InputName_F3_value,false);
$Form->set_InputOrder($FormularName,$InputName_F3_value,1);
$Form->set_InputLabel($FormularName,$InputName_F3_value,"");

//Values
$Form->new_Input($FormularName,$InputName_F4_value,"text", $$InputName_F4_value);
$Form->set_InputJS($FormularName,$InputName_F4_value," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F4_value,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F4_value,32,1024);
$Form->set_InputDesc($FormularName,$InputName_F4_value,___("Werte, (Trennzeichen ; (Semikolon)"));
$Form->set_InputReadonly($FormularName,$InputName_F4_value,false);
$Form->set_InputOrder($FormularName,$InputName_F4_value,1);
$Form->set_InputLabel($FormularName,$InputName_F4_value,"");

//Values
$Form->new_Input($FormularName,$InputName_F5_value,"text", $$InputName_F5_value);
$Form->set_InputJS($FormularName,$InputName_F5_value," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F5_value,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F5_value,32,1024);
$Form->set_InputDesc($FormularName,$InputName_F5_value,___("Werte, (Trennzeichen ; (Semikolon)"));
$Form->set_InputReadonly($FormularName,$InputName_F5_value,false);
$Form->set_InputOrder($FormularName,$InputName_F5_value,1);
$Form->set_InputLabel($FormularName,$InputName_F5_value,"");

//Values
$Form->new_Input($FormularName,$InputName_F6_value,"text", $$InputName_F6_value);
$Form->set_InputJS($FormularName,$InputName_F6_value," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F6_value,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F6_value,32,1024);
$Form->set_InputDesc($FormularName,$InputName_F6_value,___("Werte, (Trennzeichen ; (Semikolon)"));
$Form->set_InputReadonly($FormularName,$InputName_F6_value,false);
$Form->set_InputOrder($FormularName,$InputName_F6_value,1);
$Form->set_InputLabel($FormularName,$InputName_F6_value,"");

//Values
$Form->new_Input($FormularName,$InputName_F7_value,"text", $$InputName_F7_value);
$Form->set_InputJS($FormularName,$InputName_F7_value," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F7_value,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F7_value,32,1024);
$Form->set_InputDesc($FormularName,$InputName_F7_value,___("Werte, (Trennzeichen ; (Semikolon)"));
$Form->set_InputReadonly($FormularName,$InputName_F7_value,false);
$Form->set_InputOrder($FormularName,$InputName_F7_value,1);
$Form->set_InputLabel($FormularName,$InputName_F7_value,"");

//Values
$Form->new_Input($FormularName,$InputName_F8_value,"text", $$InputName_F8_value);
$Form->set_InputJS($FormularName,$InputName_F8_value," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F8_value,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F8_value,32,1024);
$Form->set_InputDesc($FormularName,$InputName_F8_value,___("Werte, (Trennzeichen ; (Semikolon)"));
$Form->set_InputReadonly($FormularName,$InputName_F8_value,false);
$Form->set_InputOrder($FormularName,$InputName_F8_value,1);
$Form->set_InputLabel($FormularName,$InputName_F8_value,"");

//Values
$Form->new_Input($FormularName,$InputName_F9_value,"text", $$InputName_F9_value);
$Form->set_InputJS($FormularName,$InputName_F9_value," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F9_value,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F9_value,32,1024);
$Form->set_InputDesc($FormularName,$InputName_F9_value,___("Werte, (Trennzeichen ; (Semikolon)"));
$Form->set_InputReadonly($FormularName,$InputName_F9_value,false);
$Form->set_InputOrder($FormularName,$InputName_F9_value,1);
$Form->set_InputLabel($FormularName,$InputName_F9_value,"");

//////////////////////////////////

//Email ErrMsg
$Form->new_Input($FormularName,$InputName_email_errmsg,"text", $$InputName_email_errmsg);
$Form->set_InputJS($FormularName,$InputName_email_errmsg," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_email_errmsg,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_email_errmsg,32,255);
$Form->set_InputDesc($FormularName,$InputName_email_errmsg,___("Fehlermeldung"));
$Form->set_InputReadonly($FormularName,$InputName_email_errmsg,false);
$Form->set_InputOrder($FormularName,$InputName_email_errmsg,1);
$Form->set_InputLabel($FormularName,$InputName_email_errmsg,"");

//Captcha ErrMsg
$Form->new_Input($FormularName,$InputName_captcha_errmsg,"text", $$InputName_captcha_errmsg);
$Form->set_InputJS($FormularName,$InputName_captcha_errmsg," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_captcha_errmsg,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_captcha_errmsg,32,255);
$Form->set_InputDesc($FormularName,$InputName_captcha_errmsg,___("Fehlermeldung"));
$Form->set_InputReadonly($FormularName,$InputName_captcha_errmsg,false);
$Form->set_InputOrder($FormularName,$InputName_captcha_errmsg,1);
$Form->set_InputLabel($FormularName,$InputName_captcha_errmsg,"");

/////////////////////////////////////////

//F ErrMsg
$Form->new_Input($FormularName,$InputName_F0_errmsg,"text", $$InputName_F0_errmsg);
$Form->set_InputJS($FormularName,$InputName_F0_errmsg," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F0_errmsg,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F0_errmsg,32,255);
$Form->set_InputDesc($FormularName,$InputName_F0_errmsg,___("Fehlermeldung"));
$Form->set_InputReadonly($FormularName,$InputName_F0_errmsg,false);
$Form->set_InputOrder($FormularName,$InputName_F0_errmsg,1);
$Form->set_InputLabel($FormularName,$InputName_F0_errmsg,"");

//F ErrMsg
$Form->new_Input($FormularName,$InputName_F1_errmsg,"text", $$InputName_F1_errmsg);
$Form->set_InputJS($FormularName,$InputName_F1_errmsg," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F1_errmsg,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F1_errmsg,32,255);
$Form->set_InputDesc($FormularName,$InputName_F1_errmsg,___("Fehlermeldung"));
$Form->set_InputReadonly($FormularName,$InputName_F1_errmsg,false);
$Form->set_InputOrder($FormularName,$InputName_F1_errmsg,1);
$Form->set_InputLabel($FormularName,$InputName_F1_errmsg,"");

//F ErrMsg
$Form->new_Input($FormularName,$InputName_F2_errmsg,"text", $$InputName_F2_errmsg);
$Form->set_InputJS($FormularName,$InputName_F2_errmsg," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F2_errmsg,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F2_errmsg,32,255);
$Form->set_InputDesc($FormularName,$InputName_F2_errmsg,___("Fehlermeldung"));
$Form->set_InputReadonly($FormularName,$InputName_F2_errmsg,false);
$Form->set_InputOrder($FormularName,$InputName_F2_errmsg,1);
$Form->set_InputLabel($FormularName,$InputName_F2_errmsg,"");

//F ErrMsg
$Form->new_Input($FormularName,$InputName_F3_errmsg,"text", $$InputName_F3_errmsg);
$Form->set_InputJS($FormularName,$InputName_F3_errmsg," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F3_errmsg,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F3_errmsg,32,255);
$Form->set_InputDesc($FormularName,$InputName_F3_errmsg,___("Fehlermeldung"));
$Form->set_InputReadonly($FormularName,$InputName_F3_errmsg,false);
$Form->set_InputOrder($FormularName,$InputName_F3_errmsg,1);
$Form->set_InputLabel($FormularName,$InputName_F3_errmsg,"");

//F ErrMsg
$Form->new_Input($FormularName,$InputName_F4_errmsg,"text", $$InputName_F4_errmsg);
$Form->set_InputJS($FormularName,$InputName_F4_errmsg," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F4_errmsg,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F4_errmsg,32,255);
$Form->set_InputDesc($FormularName,$InputName_F4_errmsg,___("Fehlermeldung"));
$Form->set_InputReadonly($FormularName,$InputName_F4_errmsg,false);
$Form->set_InputOrder($FormularName,$InputName_F4_errmsg,1);
$Form->set_InputLabel($FormularName,$InputName_F4_errmsg,"");

//F ErrMsg
$Form->new_Input($FormularName,$InputName_F5_errmsg,"text", $$InputName_F5_errmsg);
$Form->set_InputJS($FormularName,$InputName_F5_errmsg," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F5_errmsg,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F5_errmsg,32,255);
$Form->set_InputDesc($FormularName,$InputName_F5_errmsg,___("Fehlermeldung"));
$Form->set_InputReadonly($FormularName,$InputName_F5_errmsg,false);
$Form->set_InputOrder($FormularName,$InputName_F5_errmsg,1);
$Form->set_InputLabel($FormularName,$InputName_F5_errmsg,"");

//F ErrMsg
$Form->new_Input($FormularName,$InputName_F6_errmsg,"text", $$InputName_F6_errmsg);
$Form->set_InputJS($FormularName,$InputName_F6_errmsg," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F6_errmsg,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F6_errmsg,32,255);
$Form->set_InputDesc($FormularName,$InputName_F6_errmsg,___("Fehlermeldung"));
$Form->set_InputReadonly($FormularName,$InputName_F6_errmsg,false);
$Form->set_InputOrder($FormularName,$InputName_F6_errmsg,1);
$Form->set_InputLabel($FormularName,$InputName_F6_errmsg,"");

//F ErrMsg
$Form->new_Input($FormularName,$InputName_F7_errmsg,"text", $$InputName_F7_errmsg);
$Form->set_InputJS($FormularName,$InputName_F7_errmsg," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F7_errmsg,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F7_errmsg,32,255);
$Form->set_InputDesc($FormularName,$InputName_F7_errmsg,___("Fehlermeldung"));
$Form->set_InputReadonly($FormularName,$InputName_F7_errmsg,false);
$Form->set_InputOrder($FormularName,$InputName_F7_errmsg,1);
$Form->set_InputLabel($FormularName,$InputName_F7_errmsg,"");

//F ErrMsg
$Form->new_Input($FormularName,$InputName_F8_errmsg,"text", $$InputName_F8_errmsg);
$Form->set_InputJS($FormularName,$InputName_F8_errmsg," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F8_errmsg,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F8_errmsg,32,255);
$Form->set_InputDesc($FormularName,$InputName_F8_errmsg,___("Fehlermeldung"));
$Form->set_InputReadonly($FormularName,$InputName_F8_errmsg,false);
$Form->set_InputOrder($FormularName,$InputName_F8_errmsg,1);
$Form->set_InputLabel($FormularName,$InputName_F8_errmsg,"");

//F ErrMsg
$Form->new_Input($FormularName,$InputName_F9_errmsg,"text", $$InputName_F9_errmsg);
$Form->set_InputJS($FormularName,$InputName_F9_errmsg," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F9_errmsg,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F9_errmsg,32,255);
$Form->set_InputDesc($FormularName,$InputName_F9_errmsg,___("Fehlermeldung"));
$Form->set_InputReadonly($FormularName,$InputName_F9_errmsg,false);
$Form->set_InputOrder($FormularName,$InputName_F9_errmsg,1);
$Form->set_InputLabel($FormularName,$InputName_F9_errmsg,"");

////////////////////////////////////

//F Expression
$Form->new_Input($FormularName,$InputName_F0_expr,"text", $$InputName_F0_expr);
$Form->set_InputJS($FormularName,$InputName_F0_expr," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F0_expr,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F0_expr,32,255);
$Form->set_InputDesc($FormularName,$InputName_F0_expr,___("Regulärer Ausdruck"));
$Form->set_InputReadonly($FormularName,$InputName_F0_expr,false);
$Form->set_InputOrder($FormularName,$InputName_F0_expr,1);
$Form->set_InputLabel($FormularName,$InputName_F0_expr,"");

//F Expression
$Form->new_Input($FormularName,$InputName_F1_expr,"text", $$InputName_F1_expr);
$Form->set_InputJS($FormularName,$InputName_F1_expr," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F1_expr,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F1_expr,32,255);
$Form->set_InputDesc($FormularName,$InputName_F1_expr,___("Regulärer Ausdruck"));
$Form->set_InputReadonly($FormularName,$InputName_F1_expr,false);
$Form->set_InputOrder($FormularName,$InputName_F1_expr,1);
$Form->set_InputLabel($FormularName,$InputName_F1_expr,"");

//F Expression
$Form->new_Input($FormularName,$InputName_F2_expr,"text", $$InputName_F2_expr);
$Form->set_InputJS($FormularName,$InputName_F2_expr," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F2_expr,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F2_expr,32,255);
$Form->set_InputDesc($FormularName,$InputName_F2_expr,___("Regulärer Ausdruck"));
$Form->set_InputReadonly($FormularName,$InputName_F2_expr,false);
$Form->set_InputOrder($FormularName,$InputName_F2_expr,1);
$Form->set_InputLabel($FormularName,$InputName_F2_expr,"");

//F Expression
$Form->new_Input($FormularName,$InputName_F3_expr,"text", $$InputName_F3_expr);
$Form->set_InputJS($FormularName,$InputName_F3_expr," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F3_expr,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F3_expr,32,255);
$Form->set_InputDesc($FormularName,$InputName_F3_expr,___("Regulärer Ausdruck"));
$Form->set_InputReadonly($FormularName,$InputName_F3_expr,false);
$Form->set_InputOrder($FormularName,$InputName_F3_expr,1);
$Form->set_InputLabel($FormularName,$InputName_F3_expr,"");

//F Expression
$Form->new_Input($FormularName,$InputName_F4_expr,"text", $$InputName_F4_expr);
$Form->set_InputJS($FormularName,$InputName_F4_expr," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F4_expr,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F4_expr,32,255);
$Form->set_InputDesc($FormularName,$InputName_F4_expr,___("Regulärer Ausdruck"));
$Form->set_InputReadonly($FormularName,$InputName_F4_expr,false);
$Form->set_InputOrder($FormularName,$InputName_F4_expr,1);
$Form->set_InputLabel($FormularName,$InputName_F4_expr,"");

//F Expression
$Form->new_Input($FormularName,$InputName_F5_expr,"text", $$InputName_F5_expr);
$Form->set_InputJS($FormularName,$InputName_F5_expr," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F5_expr,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F5_expr,32,255);
$Form->set_InputDesc($FormularName,$InputName_F5_expr,___("Regulärer Ausdruck"));
$Form->set_InputReadonly($FormularName,$InputName_F5_expr,false);
$Form->set_InputOrder($FormularName,$InputName_F5_expr,1);
$Form->set_InputLabel($FormularName,$InputName_F5_expr,"");

//F Expression
$Form->new_Input($FormularName,$InputName_F6_expr,"text", $$InputName_F6_expr);
$Form->set_InputJS($FormularName,$InputName_F6_expr," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F6_expr,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F6_expr,32,255);
$Form->set_InputDesc($FormularName,$InputName_F6_expr,___("Regulärer Ausdruck"));
$Form->set_InputReadonly($FormularName,$InputName_F6_expr,false);
$Form->set_InputOrder($FormularName,$InputName_F6_expr,1);
$Form->set_InputLabel($FormularName,$InputName_F6_expr,"");

//F Expression
$Form->new_Input($FormularName,$InputName_F7_expr,"text", $$InputName_F7_expr);
$Form->set_InputJS($FormularName,$InputName_F7_expr," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F7_expr,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F7_expr,32,255);
$Form->set_InputDesc($FormularName,$InputName_F7_expr,___("Regulärer Ausdruck"));
$Form->set_InputReadonly($FormularName,$InputName_F7_expr,false);
$Form->set_InputOrder($FormularName,$InputName_F7_expr,1);
$Form->set_InputLabel($FormularName,$InputName_F7_expr,"");

//F Expression
$Form->new_Input($FormularName,$InputName_F8_expr,"text", $$InputName_F8_expr);
$Form->set_InputJS($FormularName,$InputName_F8_expr," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F8_expr,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F8_expr,32,255);
$Form->set_InputDesc($FormularName,$InputName_F8_expr,___("Regulärer Ausdruck"));
$Form->set_InputReadonly($FormularName,$InputName_F8_expr,false);
$Form->set_InputOrder($FormularName,$InputName_F8_expr,1);
$Form->set_InputLabel($FormularName,$InputName_F8_expr,"");

//F Expression
$Form->new_Input($FormularName,$InputName_F9_expr,"text", $$InputName_F9_expr);
$Form->set_InputJS($FormularName,$InputName_F9_expr," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F9_expr,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_F9_expr,32,255);
$Form->set_InputDesc($FormularName,$InputName_F9_expr,___("Regulärer Ausdruck"));
$Form->set_InputReadonly($FormularName,$InputName_F9_expr,false);
$Form->set_InputOrder($FormularName,$InputName_F9_expr,1);
$Form->set_InputLabel($FormularName,$InputName_F9_expr,"");

/////////////////////////////////////


//submit button
$Form->new_Input($FormularName,$InputName_Submit,"submit",___("Speichern"));
$Form->set_InputStyleClass($FormularName,$InputName_Submit,"mFormSubmit","mFormSubmitFocus");
$Form->set_InputDesc($FormularName,$InputName_Submit,"");
$Form->set_InputReadonly($FormularName,$InputName_Submit,false);
$Form->set_InputOrder($FormularName,$InputName_Submit,998);
$Form->set_InputLabel($FormularName,$InputName_Submit,"");

//a reset button
$Form->new_Input($FormularName,$InputName_Reset,"reset",___("Reset"));
$Form->set_InputStyleClass($FormularName,$InputName_Reset,"mFormReset","mFormResetFocus");
$Form->set_InputDesc($FormularName,$InputName_Reset,___("Eingaben zurücksetzen"));
$Form->set_InputReadonly($FormularName,$InputName_Reset,false);
$Form->set_InputOrder($FormularName,$InputName_Reset,999);
$Form->set_InputLabel($FormularName,$InputName_Reset,"");

/*RENDER FORM*/

$Form->render_Form($FormularName);

/*DISPLAY*/
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['head'];
//hidden fieldsnicht vergessen!
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['act']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['set']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['frm_id']['html'];
$_MAIN_OUTPUT.= "<table border=0>";

if (!empty($frm_id)) {
	$_MAIN_OUTPUT.= "<tr>";
	$_MAIN_OUTPUT.= "<td colspan=\"2\">";
	$_MAIN_OUTPUT.= "ID: <b>".$FRM[0]['id']."</b>";
	$_MAIN_OUTPUT.= "<br>";
	$_MAIN_OUTPUT.= sprintf(___("Erstellt am: %s von %s"),"<b>".$FRM[0]['author']."</b>","<b>".$FRM[0]['created']."</b>");
	$_MAIN_OUTPUT.= "<br>";
	$_MAIN_OUTPUT.= sprintf(___("Bearbeitet am: %s von %s"),"<b>".$FRM[0]['editor']."</b>","<b>".$FRM[0]['updated']."</b>");
	$_MAIN_OUTPUT.= "<br><br>";
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "</tr>";
}

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("folder.png",___("Name"))."&nbsp;".___("Name");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Name]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("tick.png",___("Aktiv")).tm_icon("cancel.png",___("Inaktiv"))."&nbsp;".___("Aktiv");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Aktiv]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("arrow_refresh.png",___("Double Opt-in"))."&nbsp;".___("Double Opt-in");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_DoubleOptin]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("sport_8ball.png",___("Captcha"))."&nbsp;".___("Captcha/Spamcode prüfen");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_UseCaptcha]['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_DigitsCaptcha]['html'];
$_MAIN_OUTPUT.= ___("Ziffern");
$_MAIN_OUTPUT.= "<br>".___("Fehlermeldung")." ".$Form->INPUT[$FormularName][$InputName_captcha_errmsg]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("tick.png",___("Aktiv")).tm_icon("cancel.png",___("Inaktiv"))."&nbsp;".___("Neuanmeldungen sind aktiv");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_SubAktiv]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top colspan=2>". tm_icon("layout.png",___("Beschreibung"))."&nbsp;".___("Beschreibung")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Descr]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>".tm_icon("group.png",___("Gruppen"))."&nbsp;".___("Gruppen")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Group]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top colspan=3 style=\"border-top:1px solid #000000\">".___("Fn / Pflichtfeld / Typ / Name");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top colspan=3  style=\"border-top:1px dashed #666666\">E-Mail ";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_email]['html'];
$_MAIN_OUTPUT.= " ".___("Fehler")." ".$Form->INPUT[$FormularName][$InputName_email_errmsg]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";


$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top colspan=3  style=\"border-top:1px dashed #666666\">F0 ";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F0_required]['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F0_type]['html'];
$_MAIN_OUTPUT.= " ".___("Name")." ".$Form->INPUT[$FormularName][$InputName_F0]['html'];
$_MAIN_OUTPUT.= " ".___("Werte")." ".$Form->INPUT[$FormularName][$InputName_F0_value]['html'];
$_MAIN_OUTPUT.= "<br>".___("Fehler")." ".$Form->INPUT[$FormularName][$InputName_F0_errmsg]['html'];
$_MAIN_OUTPUT.= " ".___("RegExpr")." ".$Form->INPUT[$FormularName][$InputName_F0_expr]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top colspan=3  style=\"border-top:1px dashed #666666\">F1 ";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F1_required]['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F1_type]['html'];
$_MAIN_OUTPUT.= " ".___("Name")." ".$Form->INPUT[$FormularName][$InputName_F1]['html'];
$_MAIN_OUTPUT.= " ".___("Werte")." ".$Form->INPUT[$FormularName][$InputName_F1_value]['html'];
$_MAIN_OUTPUT.= "<br>".___("Fehler")." ".$Form->INPUT[$FormularName][$InputName_F1_errmsg]['html'];
$_MAIN_OUTPUT.= " ".___("RegExpr")." ".$Form->INPUT[$FormularName][$InputName_F1_expr]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top colspan=3  style=\"border-top:1px dashed #666666\">F2 ";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F2_required]['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F2_type]['html'];
$_MAIN_OUTPUT.= " ".___("Name")." ".$Form->INPUT[$FormularName][$InputName_F2]['html'];
$_MAIN_OUTPUT.= " ".___("Werte")." ".$Form->INPUT[$FormularName][$InputName_F2_value]['html'];
$_MAIN_OUTPUT.= "<br>".___("Fehler")." ".$Form->INPUT[$FormularName][$InputName_F2_errmsg]['html'];
$_MAIN_OUTPUT.= " ".___("RegExpr")." ".$Form->INPUT[$FormularName][$InputName_F2_expr]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top colspan=3  style=\"border-top:1px dashed #666666\">F3 ";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F3_required]['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F3_type]['html'];
$_MAIN_OUTPUT.= " ".___("Name")." ".$Form->INPUT[$FormularName][$InputName_F3]['html'];
$_MAIN_OUTPUT.= " ".___("Werte")." ".$Form->INPUT[$FormularName][$InputName_F3_value]['html'];
$_MAIN_OUTPUT.= "<br>".___("Fehler")." ".$Form->INPUT[$FormularName][$InputName_F3_errmsg]['html'];
$_MAIN_OUTPUT.= " ".___("RegExpr")." ".$Form->INPUT[$FormularName][$InputName_F3_expr]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top colspan=3  style=\"border-top:1px dashed #666666\">F4 ";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F4_required]['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F4_type]['html'];
$_MAIN_OUTPUT.= " ".___("Name")." ".$Form->INPUT[$FormularName][$InputName_F4]['html'];
$_MAIN_OUTPUT.= " ".___("Werte")." ".$Form->INPUT[$FormularName][$InputName_F4_value]['html'];
$_MAIN_OUTPUT.= "<br>".___("Fehler")." ".$Form->INPUT[$FormularName][$InputName_F4_errmsg]['html'];
$_MAIN_OUTPUT.= " ".___("RegExpr")." ".$Form->INPUT[$FormularName][$InputName_F4_expr]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top colspan=3  style=\"border-top:1px dashed #666666\">F5 ";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F5_required]['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F5_type]['html'];
$_MAIN_OUTPUT.= " ".___("Name")." ".$Form->INPUT[$FormularName][$InputName_F5]['html'];
$_MAIN_OUTPUT.= " ".___("Werte")." ".$Form->INPUT[$FormularName][$InputName_F5_value]['html'];
$_MAIN_OUTPUT.= "<br>".___("Fehler")." ".$Form->INPUT[$FormularName][$InputName_F5_errmsg]['html'];
$_MAIN_OUTPUT.= " ".___("RegExpr")." ".$Form->INPUT[$FormularName][$InputName_F5_expr]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top colspan=3  style=\"border-top:1px dashed #666666\">F6 ";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F6_required]['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F6_type]['html'];
$_MAIN_OUTPUT.= " ".___("Name")." ".$Form->INPUT[$FormularName][$InputName_F6]['html'];
$_MAIN_OUTPUT.= " ".___("Werte")." ".$Form->INPUT[$FormularName][$InputName_F6_value]['html'];
$_MAIN_OUTPUT.= "<br>".___("Fehler")." ".$Form->INPUT[$FormularName][$InputName_F6_errmsg]['html'];
$_MAIN_OUTPUT.= " ".___("RegExpr")." ".$Form->INPUT[$FormularName][$InputName_F6_expr]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top colspan=3  style=\"border-top:1px dashed #666666\">F7 ";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F7_required]['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F7_type]['html'];
$_MAIN_OUTPUT.= " ".___("Name")." ".$Form->INPUT[$FormularName][$InputName_F7]['html'];
$_MAIN_OUTPUT.= " ".___("Werte")." ".$Form->INPUT[$FormularName][$InputName_F7_value]['html'];
$_MAIN_OUTPUT.= "<br>".___("Fehler")." ".$Form->INPUT[$FormularName][$InputName_F7_errmsg]['html'];
$_MAIN_OUTPUT.= " ".___("RegExpr")." ".$Form->INPUT[$FormularName][$InputName_F7_expr]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top colspan=3  style=\"border-top:1px dashed #666666\">F8 ";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F8_required]['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F8_type]['html'];
$_MAIN_OUTPUT.= " ".___("Name")." ".$Form->INPUT[$FormularName][$InputName_F8]['html'];
$_MAIN_OUTPUT.= " ".___("Werte")." ".$Form->INPUT[$FormularName][$InputName_F8_value]['html'];
$_MAIN_OUTPUT.= "<br>".___("Fehler")." ".$Form->INPUT[$FormularName][$InputName_F8_errmsg]['html'];
$_MAIN_OUTPUT.= " ".___("RegExpr")." ".$Form->INPUT[$FormularName][$InputName_F8_expr]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top colspan=3  style=\"border-top:1px dashed #666666\">F9 ";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F9_required]['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F9_type]['html'];
$_MAIN_OUTPUT.= " ".___("Name")." ".$Form->INPUT[$FormularName][$InputName_F9]['html'];
$_MAIN_OUTPUT.= " ".___("Werte")." ".$Form->INPUT[$FormularName][$InputName_F9_value]['html'];
$_MAIN_OUTPUT.= "<br>".___("Fehler")." ".$Form->INPUT[$FormularName][$InputName_F9_errmsg]['html'];
$_MAIN_OUTPUT.= " ".___("RegExpr")." ".$Form->INPUT[$FormularName][$InputName_F9_expr]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1  style=\"border-top:1px dashed #666666\">".tm_icon("tag_blue.png",___("Submit"))."&nbsp;".___("Submit");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=2 align=\"left\"  style=\"border-top:1px dashed #666666\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_SubmitValue]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>".tm_icon("tag_red.png",___("Reset"))."&nbsp;".___("Reset");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=2 align=\"left\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_ResetValue]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";


$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top colspan=3  style=\"border-top:1px solid #000000\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Submit]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "</table>";
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['foot'];
?>