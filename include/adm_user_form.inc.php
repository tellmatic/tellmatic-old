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

//read css directories and check for stylesheets and template directories
$CSSDirs=Array();
$CSSDirsTmp=getCSSDirectories($tm_path."/css");
$css_c=count($CSSDirsTmp);
$css_i=0;
for ($css_cc=0; $css_cc < $css_c; $css_cc++) {
	$css_file=$tm_path."/css/".$CSSDirsTmp[$css_cc]."/tellmatic.css";
	$tpl_dir=$tm_tplpath."/".$CSSDirsTmp[$css_cc];
	if (file_exists($css_file)) {
		if (is_dir($tpl_dir)) {
			$CSSDirs[$css_i]["dir"]=$CSSDirsTmp[$css_cc];
			$CSSDirs[$css_i]["name"]=$CSSDirsTmp[$css_cc];
			$css_i++;
		}
	}
}
unset($CSSDirsTmp);


//Form
$Form=new tm_SimpleForm();
$FormularName="user";
$Form->new_Form($FormularName,$_SERVER["PHP_SELF"],"post","_self");
$Form->set_FormJS($FormularName," onSubmit=\"switchSection('div_loader');\" ");
$Form->set_FormDesc($FormularName,___("Benutzer bearbeiten"));

//variable content aus menu als hidden field!
$Form->new_Input($FormularName,"act", "hidden", $action);
$Form->new_Input($FormularName,"set", "hidden", "save");
$Form->new_Input($FormularName,"u_id", "hidden", $u_id);
//////////////////
//add inputfields and buttons....
//////////////////

//Name
$Form->new_Input($FormularName,$InputName_Name,"text",$$InputName_Name);
$Form->set_InputJS($FormularName,$InputName_Name," onChange=\"flash('submit','#ff0000');\" onkeyup=\"RemoveInvalidChars(this, '[^A-Za-z0-9\ \_\.\-]'); ForceLowercase(this);\"");
$Form->set_InputStyleClass($FormularName,$InputName_Name,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Name,48,256);
$Form->set_InputDesc($FormularName,$InputName_Name,___("E-Mail"));
$Form->set_InputReadonly($FormularName,$InputName_Name,false);
$Form->set_InputOrder($FormularName,$InputName_Name,1);
$Form->set_InputLabel($FormularName,$InputName_Name,"");


//EMAIL
$Form->new_Input($FormularName,$InputName_EMail,"text",$$InputName_EMail);
$Form->set_InputJS($FormularName,$InputName_EMail," onChange=\"flash('submit','#ff0000');\" onkeyup=\"RemoveInvalidChars(this, '[^A-Za-z0-9\_\@\.\-]'); ForceLowercase(this);\"");
$Form->set_InputStyleClass($FormularName,$InputName_EMail,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_EMail,48,256);
$Form->set_InputDesc($FormularName,$InputName_EMail,___("E-Mail"));
$Form->set_InputReadonly($FormularName,$InputName_EMail,false);
$Form->set_InputOrder($FormularName,$InputName_EMail,1);
$Form->set_InputLabel($FormularName,$InputName_EMail,"");

//passwd
$Form->new_Input($FormularName,$InputName_Pass,"password", "");
$Form->set_InputJS($FormularName,$InputName_Pass," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Pass,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Pass,48,256);
$Form->set_InputDesc($FormularName,$InputName_Pass,___("Passwort"));
$Form->set_InputReadonly($FormularName,$InputName_Pass,false);
$Form->set_InputOrder($FormularName,$InputName_Pass,1);
$Form->set_InputLabel($FormularName,$InputName_Pass,"");

//passwd 2
$Form->new_Input($FormularName,$InputName_Pass2,"password", "");
$Form->set_InputJS($FormularName,$InputName_Pass2," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Pass2,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Pass2,48,256);
$Form->set_InputDesc($FormularName,$InputName_Pass2,___("Passwort"));
$Form->set_InputReadonly($FormularName,$InputName_Pass2,false);
$Form->set_InputOrder($FormularName,$InputName_Pass2,1);
$Form->set_InputLabel($FormularName,$InputName_Pass2,"");

//Style
$Form->new_Input($FormularName,$InputName_Style,"select", "");
$Form->set_InputJS($FormularName,$InputName_Style," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_Style,$$InputName_Style);
$Form->set_InputStyleClass($FormularName,$InputName_Style,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Style,___("Layout / Style"));
$Form->set_InputReadonly($FormularName,$InputName_Style,false);
$Form->set_InputOrder($FormularName,$InputName_Style,6);
$Form->set_InputLabel($FormularName,$InputName_Style,"");
$Form->set_InputSize($FormularName,$InputName_Style,0,1);
$Form->set_InputMultiple($FormularName,$InputName_Style,false);
//add Data
$css_c=count($CSSDirs);
for ($css_cc=0; $css_cc < $css_c; $css_cc++) {
	$Form->add_InputOption($FormularName,$InputName_Style,$CSSDirs[$css_cc]['dir'],$CSSDirs[$css_cc]['name']);
}

//lang
$Form->new_Input($FormularName,$InputName_Lang,"select", "");
$Form->set_InputJS($FormularName,$InputName_Lang," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_Lang,$$InputName_Lang);
$Form->set_InputStyleClass($FormularName,$InputName_Lang,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Lang,___("Sprache"));
$Form->set_InputReadonly($FormularName,$InputName_Lang,false);
$Form->set_InputOrder($FormularName,$InputName_Lang,6);
$Form->set_InputLabel($FormularName,$InputName_Lang,"");
$Form->set_InputSize($FormularName,$InputName_Lang,0,1);
$Form->set_InputMultiple($FormularName,$InputName_Lang,false);
//add Data
$lc=count($LANGUAGES['lang']);
for ($lcc=0;$lcc<$lc;$lcc++) {
	$Form->add_InputOption($FormularName,$InputName_Lang,$LANGUAGES['lang'][$lcc],$LANGUAGES['text'][$lcc]);
}

//Expert
$Form->new_Input($FormularName,$InputName_Expert,"checkbox", 1);
$Form->set_InputJS($FormularName,$InputName_Expert," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_Expert,$$InputName_Expert);
$Form->set_InputStyleClass($FormularName,$InputName_Expert,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Expert,48,256);
$Form->set_InputDesc($FormularName,$InputName_Expert,___("Experten-Modus"));
$Form->set_InputReadonly($FormularName,$InputName_Expert,false);
$Form->set_InputOrder($FormularName,$InputName_Expert,2);
$Form->set_InputLabel($FormularName,$InputName_Expert,"");

//Admin
$Form->new_Input($FormularName,$InputName_Admin,"checkbox", 1);
$Form->set_InputJS($FormularName,$InputName_Admin," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_Admin,$$InputName_Admin);
$Form->set_InputStyleClass($FormularName,$InputName_Admin,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Admin,48,256);
$Form->set_InputDesc($FormularName,$InputName_Admin,___("Admin"));
$Form->set_InputReadonly($FormularName,$InputName_Admin,false);
$Form->set_InputOrder($FormularName,$InputName_Admin,2);
$Form->set_InputLabel($FormularName,$InputName_Admin,"");

//Manager
$Form->new_Input($FormularName,$InputName_Manager,"checkbox", 1);
$Form->set_InputJS($FormularName,$InputName_Manager," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_Manager,$$InputName_Manager);
$Form->set_InputStyleClass($FormularName,$InputName_Manager,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Manager,48,256);
$Form->set_InputDesc($FormularName,$InputName_Manager,___("Verwalter"));
$Form->set_InputReadonly($FormularName,$InputName_Manager,false);
$Form->set_InputOrder($FormularName,$InputName_Manager,2);
$Form->set_InputLabel($FormularName,$InputName_Manager,"");

//Aktiv
$Form->new_Input($FormularName,$InputName_Aktiv,"checkbox", 1);
$Form->set_InputJS($FormularName,$InputName_Aktiv," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_Aktiv,$$InputName_Aktiv);
$Form->set_InputStyleClass($FormularName,$InputName_Aktiv,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Aktiv,48,256);
$Form->set_InputDesc($FormularName,$InputName_Aktiv,___("Aktiv"));
$Form->set_InputReadonly($FormularName,$InputName_Aktiv,false);
$Form->set_InputOrder($FormularName,$InputName_Aktiv,2);
$Form->set_InputLabel($FormularName,$InputName_Aktiv,"");

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
$Form->set_InputDesc($FormularName,$InputName_Reset,___("Reset"));
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
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['u_id']['html'];
$_MAIN_OUTPUT.= "<table>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top width=\"200\">".tm_icon("user.png",___("Name"))."&nbsp;";
$_MAIN_OUTPUT.= ___("Name");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Name]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top width=\"200\">".tm_icon("user_comment.png",___("Sprache"))."&nbsp;";
$_MAIN_OUTPUT.= ___("Sprache");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Lang]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>".tm_icon("monitor.png",___("Style"))."&nbsp;";
$_MAIN_OUTPUT.= ___("Layout / Style");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Style]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>".tm_icon("tick.png",___("Aktiv")).tm_icon("cancel.png",___("Aktiv"))."&nbsp;";
$_MAIN_OUTPUT.= ___("Aktiv");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Aktiv]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>".tm_icon("user_gray.png",___("Admin"))."&nbsp;";
$_MAIN_OUTPUT.= ___("Administrator");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Admin]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>".tm_icon("user_red.png",___("Verwalter"))."&nbsp;";
$_MAIN_OUTPUT.= ___("Verwalter");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Manager]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";


$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>".tm_icon("tux.png",___("Erfahrener Benutzer"))."&nbsp;";
$_MAIN_OUTPUT.= ___("Erfahrener Benutzer, Hilfen ausblenden etc.");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Expert]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>".tm_icon("email.png",___("E-Mail-Adresse"))."&nbsp;";
$_MAIN_OUTPUT.= ___("E-Mail-Adresse");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_EMail]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>".tm_icon("pilcrow.png",___("Passwort"))."&nbsp;";
$_MAIN_OUTPUT.= ___("Passwort");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Pass]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>".tm_icon("pilcrow.png",___("Passwort"))."&nbsp;";
$_MAIN_OUTPUT.= ___("Passwort wiederholen");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Pass2]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top colspan=2>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Submit]['html'];
//$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Reset]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "</table>";
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['foot'];

?>