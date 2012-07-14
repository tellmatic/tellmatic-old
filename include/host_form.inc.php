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
$FormularName="edit_host";
$Form->new_Form($FormularName,$_SERVER["PHP_SELF"],"post","_self");
$Form->set_FormJS($FormularName," onSubmit=\"switchSection('div_loader');\" OnChange=\"checkHostType();\" onClick=\"checkHostType();\"");
$Form->set_FormDesc($FormularName,___("Mailserver bearbeiten"));

//variable content aus menu als hidden field!
$Form->new_Input($FormularName,"act", "hidden", $action);
$Form->new_Input($FormularName,"set", "hidden", "save");
$Form->new_Input($FormularName,"h_id", "hidden", $h_id);
//////////////////
//add inputfields and buttons....
//////////////////

//Name
$Form->new_Input($FormularName,$InputName_Name,"text",display($$InputName_Name));
$Form->set_InputJS($FormularName,$InputName_Name," onChange=\"flash('submit','#ff0000');\" onkeyup=\"RemoveInvalidChars(this, '[^A-Za-z0-9\ \_\.\-]');\"");
$Form->set_InputStyleClass($FormularName,$InputName_Name,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Name,48,256);
$Form->set_InputDesc($FormularName,$InputName_Name,___("Name"));
$Form->set_InputReadonly($FormularName,$InputName_Name,false);
$Form->set_InputOrder($FormularName,$InputName_Name,1);
$Form->set_InputLabel($FormularName,$InputName_Name,"");


//HOSTName/IP
$Form->new_Input($FormularName,$InputName_Host,"text",$$InputName_Host);
$Form->set_InputJS($FormularName,$InputName_Host," onChange=\"flash('submit','#ff0000');\" onkeyup=\"RemoveInvalidChars(this, '[^A-Za-z0-9\_\.\-]'); ForceLowercase(this);\"");
$Form->set_InputStyleClass($FormularName,$InputName_Host,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Host,48,256);
$Form->set_InputDesc($FormularName,$InputName_Host,___("Hostname / IP-Adresse"));
$Form->set_InputReadonly($FormularName,$InputName_Host,false);
$Form->set_InputOrder($FormularName,$InputName_Host,1);
$Form->set_InputLabel($FormularName,$InputName_Host,"");

//Port
$Form->new_Input($FormularName,$InputName_Port,"text",$$InputName_Port);
$Form->set_InputJS($FormularName,$InputName_Port," onChange=\"flash('submit','#ff0000');\" onkeyup=\"RemoveInvalidChars(this, '[^0-9]'); ForceLowercase(this);\"");
$Form->set_InputStyleClass($FormularName,$InputName_Port,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Port,8,8);
$Form->set_InputDesc($FormularName,$InputName_Port,___("Port"));
$Form->set_InputReadonly($FormularName,$InputName_Port,false);
$Form->set_InputOrder($FormularName,$InputName_Port,1);
$Form->set_InputLabel($FormularName,$InputName_Port,"");

//Options
$Form->new_Input($FormularName,$InputName_Options,"text",$$InputName_Options);
$Form->set_InputJS($FormularName,$InputName_Options," onChange=\"flash('submit','#ff0000');\" onkeyup=\"RemoveInvalidChars(this, '[^A-Za-z0-9\_\.\-]');\"");
$Form->set_InputStyleClass($FormularName,$InputName_Options,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Options,48,256);
$Form->set_InputDesc($FormularName,$InputName_Options,___("Options"));
$Form->set_InputReadonly($FormularName,$InputName_Options,false);
$Form->set_InputOrder($FormularName,$InputName_Options,1);
$Form->set_InputLabel($FormularName,$InputName_Options,"");

//SMTP-AuthType
$Form->new_Input($FormularName,$InputName_SMTPAuth,"select", "");
$Form->set_InputJS($FormularName,$InputName_SMTPAuth," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_SMTPAuth,$$InputName_SMTPAuth);
$Form->set_InputStyleClass($FormularName,$InputName_SMTPAuth,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_SMTPAuth,___("SMTP-Auth"));
$Form->set_InputReadonly($FormularName,$InputName_SMTPAuth,false);
$Form->set_InputOrder($FormularName,$InputName_SMTPAuth,6);
$Form->set_InputLabel($FormularName,$InputName_SMTPAuth,"");
$Form->set_InputSize($FormularName,$InputName_SMTPAuth,0,1);
$Form->set_InputMultiple($FormularName,$InputName_SMTPAuth,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_SMTPAuth,"LOGIN","LOGIN");
$Form->add_InputOption($FormularName,$InputName_SMTPAuth,"PLAIN","PLAIN");
$Form->add_InputOption($FormularName,$InputName_SMTPAuth,"CRAM-MD5","CRAM-MD5");
#$Form->add_InputOption($FormularName,$InputName_SMTPAuth,"Digest","Digest");
#$Form->add_InputOption($FormularName,$InputName_SMTPAuth,"NTML","NTML");

//SMTP-Domain
$Form->new_Input($FormularName,$InputName_SMTPDomain,"text",$$InputName_SMTPDomain);
$Form->set_InputJS($FormularName,$InputName_SMTPDomain," onChange=\"flash('submit','#ff0000');\" onkeyup=\"RemoveInvalidChars(this, '[^A-Za-z0-9\_\.\-]');\"");
$Form->set_InputStyleClass($FormularName,$InputName_SMTPDomain,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_SMTPDomain,48,256);
$Form->set_InputDesc($FormularName,$InputName_SMTPDomain,___("SMTP-Domain"));
$Form->set_InputReadonly($FormularName,$InputName_SMTPDomain,false);
$Form->set_InputOrder($FormularName,$InputName_SMTPDomain,1);
$Form->set_InputLabel($FormularName,$InputName_SMTPDomain,"");


//Type
$Form->new_Input($FormularName,$InputName_Type,"select", "");
$Form->set_InputJS($FormularName,$InputName_Type," onChange=\"flash('submit','#ff0000');checkHostType();\" ");
$Form->set_InputDefault($FormularName,$InputName_Type,$$InputName_Type);
$Form->set_InputStyleClass($FormularName,$InputName_Type,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Type,___("Typ"));
$Form->set_InputReadonly($FormularName,$InputName_Type,false);
$Form->set_InputOrder($FormularName,$InputName_Type,6);
$Form->set_InputLabel($FormularName,$InputName_Type,"");
$Form->set_InputSize($FormularName,$InputName_Type,0,1);
$Form->set_InputMultiple($FormularName,$InputName_Type,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_Type,"smtp","SMTP");
$Form->add_InputOption($FormularName,$InputName_Type,"pop3","POP3");
$Form->add_InputOption($FormularName,$InputName_Type,"imap","IMAP4");

//User
$Form->new_Input($FormularName,$InputName_User,"text", $$InputName_User);
$Form->set_InputJS($FormularName,$InputName_User," onChange=\"flash('submit','#ff0000');\" onkeyup=\"RemoveInvalidChars(this, '[^A-Za-z0-9\_\.\-]');\"");
$Form->set_InputStyleClass($FormularName,$InputName_User,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_User,48,256);
$Form->set_InputDesc($FormularName,$InputName_User,___("Benutzername"));
$Form->set_InputReadonly($FormularName,$InputName_User,false);
$Form->set_InputOrder($FormularName,$InputName_User,1);
$Form->set_InputLabel($FormularName,$InputName_User,"");

//passwd
$Form->new_Input($FormularName,$InputName_Pass,"password", $$InputName_Pass);
$Form->set_InputJS($FormularName,$InputName_Pass," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Pass,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Pass,48,256);
$Form->set_InputDesc($FormularName,$InputName_Pass,___("Passwort"));
$Form->set_InputReadonly($FormularName,$InputName_Pass,false);
$Form->set_InputOrder($FormularName,$InputName_Pass,1);
$Form->set_InputLabel($FormularName,$InputName_Pass,"");

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
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['h_id']['html'];
$_MAIN_OUTPUT.= "<table>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top width=\"200\">".tm_icon("sum.png",___("Name"))."&nbsp;";
$_MAIN_OUTPUT.= ___("Name");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Name]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top width=\"200\">".tm_icon("server.png",___("Hostname / IP"))."&nbsp;";
$_MAIN_OUTPUT.= ___("Hostname / IP");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Host]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>".tm_icon("server_key.png",___("Typ"))."&nbsp;";
$_MAIN_OUTPUT.= ___("Typ");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Type]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>".tm_icon("door_open.png",___("Port"))."&nbsp;";
$_MAIN_OUTPUT.= ___("Port");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Port]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td style=\"border-top:1px dashed grey\" valign=\"top\">";
$_MAIN_OUTPUT.= "".tm_icon("server_lightning.png",___("Optionen"))."&nbsp;";
$_MAIN_OUTPUT.= ___("POP3/IMAP Optionen");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td style=\"border-top:1px dashed grey\" valign=\"top\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Options]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td style=\"border-top:1px dashed grey\" valign=\"top\">";
$_MAIN_OUTPUT.= "".tm_icon("server_lightning.png",___("SMTP-Auth"))."&nbsp;";
$_MAIN_OUTPUT.= ___("SMTP-Auth Methode");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td style=\"border-top:1px dashed grey\" valign=\"top\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_SMTPAuth]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td style=\"border-top:1px dashed grey\" valign=\"top\">";
$_MAIN_OUTPUT.= "".tm_icon("world_link.png",___("SMTP-Domain"))."&nbsp;";
$_MAIN_OUTPUT.= ___("SMTP-Domain");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td style=\"border-top:1px dashed grey\" valign=\"top\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_SMTPDomain]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td style=\"border-top:1px dashed grey\" valign=\"top\">";
$_MAIN_OUTPUT.= "".tm_icon("user_gray.png",___("Benutzername"))."&nbsp;";
$_MAIN_OUTPUT.= ___("Benutzername");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td style=\"border-top:1px dashed grey\" valign=\"top\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_User]['html'];
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
$_MAIN_OUTPUT.= "<td valign=top>".tm_icon("tick.png",___("Aktiv")).tm_icon("cancel.png",___("Aktiv"))."&nbsp;";
$_MAIN_OUTPUT.= ___("Aktiv");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Aktiv]['html'];
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