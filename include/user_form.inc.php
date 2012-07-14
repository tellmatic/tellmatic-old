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
$FormularName="user";
$Form->new_Form($FormularName,$_SERVER["PHP_SELF"],"post","_self");
$Form->set_FormJS($FormularName," onSubmit=\"switchSection('div_loader');\" ");
//add a Description
$Form->set_FormDesc($FormularName,___("Benutzereinstellungen ändern"));
//variable content aus menu als hidden field!
$Form->new_Input($FormularName,"act", "hidden", $action);
$Form->new_Input($FormularName,"set", "hidden", "save");
//////////////////
//add inputfields and buttons....
//////////////////

//EMAIL
$Form->new_Input($FormularName,$InputName_EMail,"text",$LOGIN->USER['email']);
$Form->set_InputJS($FormularName,$InputName_EMail," onChange=\"flash('submit','#ff0000');\" onkeyup=\"RemoveInvalidChars(this, '[^A-Za-z0-9\_\@\.\-]'); ForceLowercase(this);\"");
$Form->set_InputStyleClass($FormularName,$InputName_EMail,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_EMail,48,256);
$Form->set_InputDesc($FormularName,$InputName_EMail,___("E-Mail"));
$Form->set_InputReadonly($FormularName,$InputName_EMail,false);
$Form->set_InputOrder($FormularName,$InputName_EMail,4);
$Form->set_InputLabel($FormularName,$InputName_EMail,"");

//passwd
$Form->new_Input($FormularName,$InputName_Pass,"password", "");
$Form->set_InputJS($FormularName,$InputName_Pass," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Pass,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Pass,48,256);
$Form->set_InputDesc($FormularName,$InputName_Pass,___("Passwort"));
$Form->set_InputReadonly($FormularName,$InputName_Pass,false);
$Form->set_InputOrder($FormularName,$InputName_Pass,5);
$Form->set_InputLabel($FormularName,$InputName_Pass,"");

//passwd 2
$Form->new_Input($FormularName,$InputName_Pass2,"password", "");
$Form->set_InputJS($FormularName,$InputName_Pass2," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Pass2,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Pass2,48,256);
$Form->set_InputDesc($FormularName,$InputName_Pass2,___("Passwort"));
$Form->set_InputReadonly($FormularName,$InputName_Pass2,false);
$Form->set_InputOrder($FormularName,$InputName_Pass2,5);
$Form->set_InputLabel($FormularName,$InputName_Pass2,"");

//Style
$Form->new_Input($FormularName,$InputName_Style,"select", "");
$Form->set_InputJS($FormularName,$InputName_Style," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_Style,$$InputName_Style);
$Form->set_InputStyleClass($FormularName,$InputName_Style,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Style,___("Layout / Style"));
$Form->set_InputReadonly($FormularName,$InputName_Style,false);
$Form->set_InputOrder($FormularName,$InputName_Style,2);
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
$Form->set_InputOrder($FormularName,$InputName_Lang,1);
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
$Form->set_InputOrder($FormularName,$InputName_Expert,3);
$Form->set_InputLabel($FormularName,$InputName_Expert,"");

//submit button
$Form->new_Input($FormularName,$InputName_Submit,"submit",sprintf(___("Einstellungen für Benutzer %s ändern"),$LOGIN->USER['name']));
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
$_MAIN_OUTPUT.= "<table>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top width=\"200\">".tm_icon("user_comment.png",___("Sprache"))."&nbsp;";
$_MAIN_OUTPUT.= ___("Sprache");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Lang]['html'];
$_MAIN_OUTPUT.= "<br><a href=\"http://www.tellmatic.org\" target=\"_blank\">Please help translating Tellmatic</a>";
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
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "</table>";
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['foot'];

?>