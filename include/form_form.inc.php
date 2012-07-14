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
$Form->new_Input($FormularName,$InputName_Name,"text", display($$InputName_Name));
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

//Check Blacklist
	$Form->new_Input($FormularName,$InputName_Blacklist,"checkbox", 1);
	$Form->set_InputJS($FormularName,$InputName_Blacklist," onChange=\"flash('submit','#ff0000');\" ");
	$Form->set_InputDefault($FormularName,$InputName_Blacklist,$$InputName_Blacklist);
	$Form->set_InputStyleClass($FormularName,$InputName_Blacklist,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_Blacklist,48,1024);
	$Form->set_InputDesc($FormularName,$InputName_Blacklist,___("Aktiv"));
	$Form->set_InputReadonly($FormularName,$InputName_Blacklist,false);
	$Form->set_InputOrder($FormularName,$InputName_Blacklist,2);
	$Form->set_InputLabel($FormularName,$InputName_Blacklist,"");


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
	$Form->set_InputSize($FormularName,$InputName_DoubleOptin,0,1);
	$Form->set_InputDesc($FormularName,$InputName_DoubleOptin,___("Aktiv"));
	$Form->set_InputReadonly($FormularName,$InputName_DoubleOptin,false);
	$Form->set_InputOrder($FormularName,$InputName_DoubleOptin,2);
	$Form->set_InputLabel($FormularName,$InputName_DoubleOptin,"");

//Beschreibung
$Form->new_Input($FormularName,$InputName_Descr,"textarea", display($$InputName_Descr));
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
	$grp_name=$GRP[$accg]['name'];
	if ($GRP[$accg]['aktiv']!=1) $grp_name.=" (na)";
	$Form->add_InputOption($FormularName,$InputName_Group,$GRP[$accg]['id'],$grp_name);
}

//Public Group, subscriber can choose
$Form->new_Input($FormularName,$InputName_GroupPub,"select", "");
$Form->set_InputJS($FormularName,$InputName_GroupPub," onChange=\"flash('submit','#ff0000');\" ");
//$Form->set_InputDefault($FormularName,$InputName_GroupPub,$adr_grp_pub);
$Form->set_InputStyleClass($FormularName,$InputName_GroupPub,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_GroupPub,___("Gruppen wählen, STRG/CTRL gedrückt halten und klicken f. Mehrfachauswahl"));
$Form->set_InputReadonly($FormularName,$InputName_GroupPub,false);
$Form->set_InputOrder($FormularName,$InputName_GroupPub,6);
$Form->set_InputLabel($FormularName,$InputName_GroupPub,"");
//$Form->set_InputValue($FormularName,$InputName_GroupPub,"");
$Form->set_InputSize($FormularName,$InputName_GroupPub,0,5);
$Form->set_InputMultiple($FormularName,$InputName_GroupPub,true);
//add Data
$ADDRESS=new tm_ADR();
$GRPPUB=$ADDRESS->getGroup();
$acgp=count($GRPPUB);
for ($accgp=0; $accgp<$acgp; $accgp++)
{
	if ($GRPPUB[$accgp]['public']==1) {
		$grp_name=$GRPPUB[$accgp]['name'];
		if ($GRPPUB[$accgp]['aktiv']!=1) $grp_name.=" (na)";
		$Form->add_InputOption($FormularName,$InputName_GroupPub,$GRPPUB[$accgp]['id'],$grp_name." [".$GRPPUB[$accgp]['public_name']."]");
	}
}

//SubmitValue
$Form->new_Input($FormularName,$InputName_SubmitValue,"text", display($$InputName_SubmitValue));
$Form->set_InputJS($FormularName,$InputName_SubmitValue," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_SubmitValue,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_SubmitValue,32,255);
$Form->set_InputDesc($FormularName,$InputName_SubmitValue,"");
$Form->set_InputReadonly($FormularName,$InputName_SubmitValue,false);
$Form->set_InputOrder($FormularName,$InputName_SubmitValue,1);
$Form->set_InputLabel($FormularName,$InputName_SubmitValue,"");

//ResetValue
$Form->new_Input($FormularName,$InputName_ResetValue,"text", display($$InputName_ResetValue));
$Form->set_InputJS($FormularName,$InputName_ResetValue," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_ResetValue,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_ResetValue,32,255);
$Form->set_InputDesc($FormularName,$InputName_ResetValue,"");
$Form->set_InputReadonly($FormularName,$InputName_ResetValue,false);
$Form->set_InputOrder($FormularName,$InputName_ResetValue,1);
$Form->set_InputLabel($FormularName,$InputName_ResetValue,"");


//Femailname
$Form->new_Input($FormularName,$InputName_email,"text", display($$InputName_email));
$Form->set_InputJS($FormularName,$InputName_email," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_email,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_email,32,255);
$Form->set_InputDesc($FormularName,$InputName_email,"email");
$Form->set_InputReadonly($FormularName,$InputName_email,false);
$Form->set_InputOrder($FormularName,$InputName_email,1);
$Form->set_InputLabel($FormularName,$InputName_email,"");

//F, FName, f0-f9 new:
for ($fc=0;$fc<=9;$fc++) {
	$FInputName="InputName_F".$fc;
	$Form->new_Input($FormularName,$$FInputName,"text", display($$$FInputName));
	$Form->set_InputJS($FormularName,$$FInputName," onChange=\"flash('submit','#ff0000');\" ");
	$Form->set_InputStyleClass($FormularName,$$FInputName,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$$FInputName,32,1024);
	$Form->set_InputDesc($FormularName,$$FInputName,"F".$fc);
	$Form->set_InputReadonly($FormularName,$$FInputName,false);
	$Form->set_InputOrder($FormularName,$$FInputName,1);
	$Form->set_InputLabel($FormularName,$$FInputName,"");
}


/////////////////////////// f type
//Typ //checkbox, text,select, new, f0-f9
for ($fc=0;$fc<=9;$fc++) {
	$FInputName="InputName_F".$fc."_type";
	$Form->new_Input($FormularName,$$FInputName,"select", "");
	$Form->set_InputJS($FormularName,$$FInputName," onChange=\"flash('submit','#ff0000');\" ");
	$Form->set_InputDefault($FormularName,$$FInputName,$$$FInputName);
	$Form->set_InputStyleClass($FormularName,$$FInputName,"mFormSelect","mFormSelectFocus");
	$Form->set_InputDesc($FormularName,$$FInputName,___("Typ wählen"));
	$Form->set_InputReadonly($FormularName,$$FInputName,false);
	$Form->set_InputOrder($FormularName,$$FInputName,6);
	$Form->set_InputLabel($FormularName,$$FInputName,"");
	//$Form->set_InputValue($FormularName,$$FInputName,"");
	$Form->set_InputSize($FormularName,$$FInputName,0,1);
	$Form->set_InputMultiple($FormularName,$$FInputName,false);
	//add Data
	$Form->add_InputOption($FormularName,$$FInputName,"text","TEXT");
	$Form->add_InputOption($FormularName,$$FInputName,"checkbox","CHECKBOX");
	$Form->add_InputOption($FormularName,$$FInputName,"select","SELECT");
}


/////////////////////////// f required
//required, new, f0-f9
for ($fc=0;$fc<=9;$fc++) {
	$FInputName="InputName_F".$fc."_required";
	$Form->new_Input($FormularName,$$FInputName,"checkbox", 1);
	$Form->set_InputJS($FormularName,$$FInputName," onChange=\"flash('submit','#ff0000');\" ");
	$Form->set_InputDefault($FormularName,$$FInputName,$$$FInputName);
	$Form->set_InputStyleClass($FormularName,$$FInputName,"mFormText","mFormTextFocus");
	$Form->set_InputDesc($FormularName,$$FInputName,___("Pflichtfeld"));
	$Form->set_InputReadonly($FormularName,$$FInputName,false);
	$Form->set_InputOrder($FormularName,$$FInputName,2);
	$Form->set_InputLabel($FormularName,$$FInputName,"");
}

/////////////////////////////////////////f values
//Values, new, f0-f9
for ($fc=0;$fc<=9;$fc++) {
	$FInputName="InputName_F".$fc."_value";
	$Form->new_Input($FormularName,$$FInputName,"text", display($$$FInputName));
	$Form->set_InputJS($FormularName,$$FInputName," onChange=\"flash('submit','#ff0000');\" ");
	$Form->set_InputStyleClass($FormularName,$$FInputName,"mFormText","mFormTextFocus_wide");
	$Form->set_InputSize($FormularName,$$FInputName,32,8192);
	$Form->set_InputDesc($FormularName,$$FInputName,___("Werte, (Trennzeichen ; (Semikolon)"));
	$Form->set_InputReadonly($FormularName,$$FInputName,false);
	$Form->set_InputOrder($FormularName,$$FInputName,1);
	$Form->set_InputLabel($FormularName,$$FInputName,"");
}
////////////////////////////////// error messages
//Email ErrMsg
$Form->new_Input($FormularName,$InputName_email_errmsg,"text", display($$InputName_email_errmsg));
$Form->set_InputJS($FormularName,$InputName_email_errmsg," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_email_errmsg,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_email_errmsg,32,255);
$Form->set_InputDesc($FormularName,$InputName_email_errmsg,___("Fehlermeldung"));
$Form->set_InputReadonly($FormularName,$InputName_email_errmsg,false);
$Form->set_InputOrder($FormularName,$InputName_email_errmsg,1);
$Form->set_InputLabel($FormularName,$InputName_email_errmsg,"");

//Captcha ErrMsg
$Form->new_Input($FormularName,$InputName_captcha_errmsg,"text", display($$InputName_captcha_errmsg));
$Form->set_InputJS($FormularName,$InputName_captcha_errmsg," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_captcha_errmsg,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_captcha_errmsg,32,255);
$Form->set_InputDesc($FormularName,$InputName_captcha_errmsg,___("Fehlermeldung"));
$Form->set_InputReadonly($FormularName,$InputName_captcha_errmsg,false);
$Form->set_InputOrder($FormularName,$InputName_captcha_errmsg,1);
$Form->set_InputLabel($FormularName,$InputName_captcha_errmsg,"");

//Blacklist ErrMsg
$Form->new_Input($FormularName,$InputName_Blacklist_errmsg,"text", display($$InputName_Blacklist_errmsg));
$Form->set_InputJS($FormularName,$InputName_Blacklist_errmsg," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Blacklist_errmsg,"mFormText","mFormTextFocus_wide");
$Form->set_InputSize($FormularName,$InputName_Blacklist_errmsg,32,255);
$Form->set_InputDesc($FormularName,$InputName_Blacklist_errmsg,___("Fehlermeldung"));
$Form->set_InputReadonly($FormularName,$InputName_Blacklist_errmsg,false);
$Form->set_InputOrder($FormularName,$InputName_Blacklist_errmsg,1);
$Form->set_InputLabel($FormularName,$InputName_Blacklist_errmsg,"");

/////////////////////////////////////////
//F ErrMsg, new, f0-f9
for ($fc=0;$fc<=9;$fc++) {
	$FInputName="InputName_F".$fc."_errmsg";
	$Form->new_Input($FormularName,$$FInputName,"text", display($$$FInputName));
	$Form->set_InputJS($FormularName,$$FInputName," onChange=\"flash('submit','#ff0000');\" ");
	$Form->set_InputStyleClass($FormularName,$$FInputName,"mFormText","mFormTextFocus_wide");
	$Form->set_InputSize($FormularName,$$FInputName,32,255);
	$Form->set_InputDesc($FormularName,$$FInputName,___("Fehlermeldung"));
	$Form->set_InputReadonly($FormularName,$$FInputName,false);
	$Form->set_InputOrder($FormularName,$$FInputName,1);
	$Form->set_InputLabel($FormularName,$$FInputName,"");
}


////////////////////////////////////

//F Expression, new, f0-f9
for ($fc=0;$fc<=9;$fc++) {
	$FInputName="InputName_F".$fc."_expr";
	$Form->new_Input($FormularName,$$FInputName,"text", display($$$FInputName));
	$Form->set_InputJS($FormularName,$$FInputName," onChange=\"flash('submit','#ff0000');\" ");
	$Form->set_InputStyleClass($FormularName,$$FInputName,"mFormText","mFormTextFocus_wide");
	$Form->set_InputSize($FormularName,$$FInputName,32,255);
	$Form->set_InputDesc($FormularName,$$FInputName,___("Regulärer Ausdruck"));
	$Form->set_InputReadonly($FormularName,$$FInputName,false);
	$Form->set_InputOrder($FormularName,$$FInputName,1);
	$Form->set_InputLabel($FormularName,$$FInputName,"");
}

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
//then you dont have to render the head and foot .....

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
$_MAIN_OUTPUT.= tm_icon("ruby.png",___("Blacklist"))."&nbsp;".___("Blacklist prüfen");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Blacklist]['html'];
$_MAIN_OUTPUT.= "<br>".___("Fehlermeldung")." ".$Form->INPUT[$FormularName][$InputName_Blacklist_errmsg]['html'];
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
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("group.png",___("Gruppen"))."&nbsp;".___("Gruppen")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Group]['html'];
$_MAIN_OUTPUT.= "<br>".tm_icon("group.png",___("Gruppen"))."&nbsp;".___("öffentliche Gruppen")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_GroupPub]['html'];
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

//render form, F0-F9
for ($fc=0;$fc<=9;$fc++) {
	$FInputName="InputName_F".$fc;
	$_MAIN_OUTPUT.= "<tr>";
	$_MAIN_OUTPUT.= "<td valign=top colspan=3  style=\"border-top:1px dashed #666666\">F".$fc." ";
	$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$$FInputName."_required"]['html'];
	$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$$FInputName."_type"]['html'];
	$_MAIN_OUTPUT.= " ".___("Name")." ".$Form->INPUT[$FormularName][$$FInputName]['html'];
	$_MAIN_OUTPUT.= " ".___("Werte")." ".$Form->INPUT[$FormularName][$$FInputName."_value"]['html'];
	$_MAIN_OUTPUT.= "<br>".___("Fehler")." ".$Form->INPUT[$FormularName][$$FInputName."_errmsg"]['html'];
	$_MAIN_OUTPUT.= " ".___("RegExpr")." ".$Form->INPUT[$FormularName][$$FInputName."_expr"]['html'];
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "</tr>";
}


//FSubmit value
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1  style=\"border-top:1px dashed #666666\">".tm_icon("tag_blue.png",___("Submit"))."&nbsp;".___("Submit");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=2 align=\"left\"  style=\"border-top:1px dashed #666666\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_SubmitValue]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

//FReset value
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>".tm_icon("tag_red.png",___("Reset"))."&nbsp;".___("Reset");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=2 align=\"left\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_ResetValue]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

//Submit, save form
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top colspan=3  style=\"border-top:1px solid #000000\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Submit]['html'];
//$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Reset]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "</table>";
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['foot'];
?>