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

$Form=new tm_SimpleForm();
$FormularName="login";
$Form->new_Form($FormularName,$_SERVER["PHP_SELF"],"post","_self");
$Form->set_FormJS($FormularName," onSubmit=\"switchSection('div_loader');\" ");
$Form->set_FormDesc($FormularName,___("Login"));
$Form->new_Input($FormularName,"act", "hidden", "login");

//////////////////
//add inputfields and buttons....
//////////////////

//user
$Form->new_Input($FormularName,$InputName_User,"text", "");
$Form->set_InputJS($FormularName,$InputName_User," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_User,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_User,48,256);
$Form->set_InputDesc($FormularName,$InputName_User,___("Benutzer"));
$Form->set_InputReadonly($FormularName,$InputName_User,false);
$Form->set_InputOrder($FormularName,$InputName_User,1);
$Form->set_InputLabel($FormularName,$InputName_User,"");

//passwd
$Form->new_Input($FormularName,$InputName_Pass,"password", "");
$Form->set_InputJS($FormularName,$InputName_Pass," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Pass,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Pass,48,256);
$Form->set_InputDesc($FormularName,$InputName_Pass,___("Passwort"));
$Form->set_InputReadonly($FormularName,$InputName_Pass,false);
$Form->set_InputOrder($FormularName,$InputName_Pass,2);
$Form->set_InputLabel($FormularName,$InputName_Pass,"");

//submit button
$Form->new_Input($FormularName,$InputName_Submit,"submit",___("Anmelden"));
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
$_MAIN_OUTPUT.= "<table>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top><img src=\"".$tm_iconURL."/user_comment.png\" border=\"0\" alt=\"".___("Benutzer")."\">&nbsp;";
$_MAIN_OUTPUT.= ___("Benutzer");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_User]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top><img src=\"".$tm_iconURL."/pilcrow.png\" border=\"0\"  alt=\"".___("Passwort")."\">&nbsp;";
$_MAIN_OUTPUT.= ___("Passwort");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Pass]['html'];
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