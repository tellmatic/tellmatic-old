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

$InputName_Submit="submit2";
$InputName_Reset="reset";

//Form
$Form=new tm_SimpleForm();
$FormularName="bounce_mail";
//make new Form
$Form->new_Form($FormularName,$_SERVER["PHP_SELF"],"post","_self");
$Form->set_FormJS($FormularName," onSubmit=\"switchSection('div_loader');\" ");
//add a Description
$Form->set_FormDesc($FormularName,___("Bouncemails"));
$Form->new_Input($FormularName,"act", "hidden", $action);
$Form->new_Input($FormularName,"host", "hidden", $host);
$Form->new_Input($FormularName,"offset", "hidden", $offset);
$Form->new_Input($FormularName,"limit", "hidden", $limit);
$Form->new_Input($FormularName,"set", "hidden", $set);

$Form->set_InputID($FormularName,"act", "act2");
$Form->set_InputID($FormularName,"host", "host2");
$Form->set_InputID($FormularName,"offset", "offset2");
$Form->set_InputID($FormularName,"limit", "limit2");
$Form->set_InputID($FormularName,"set", "set2");
//////////////////
//add inputfields and buttons....
//////////////////

//MailNo
$Form->new_Input($FormularName,$InputName_Mail,"checkbox", "");
$Form->set_InputJS($FormularName,$InputName_Mail," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_Mail,$$InputName_Mail);
$Form->set_InputStyleClass($FormularName,$InputName_Mail,"mFormCheckbox","mFormCheckboxFocus");
$Form->set_InputDesc($FormularName,$InputName_Mail,___("Auswählen"));
$Form->set_InputReadonly($FormularName,$InputName_Mail,false);
$Form->set_InputOrder($FormularName,$InputName_Mail,1);
$Form->set_InputLabel($FormularName,$InputName_Mail,"");
$Form->set_InputMultiple($FormularName,$InputName_Mail,true);

//Aktion
$Form->new_Input($FormularName,$InputName_Action,"select", "");
$Form->set_InputJS($FormularName,$InputName_Action," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_Action,$$InputName_Action);
$Form->set_InputStyleClass($FormularName,$InputName_Action,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Action,___("Aktion ausführen"));
$Form->set_InputReadonly($FormularName,$InputName_Action,false);
$Form->set_InputOrder($FormularName,$InputName_Action,1);
$Form->set_InputLabel($FormularName,$InputName_Action,"");
$Form->set_InputSize($FormularName,$InputName_Action,0,1);
$Form->set_InputMultiple($FormularName,$InputName_Action,false);
//$Form->add_InputOption($FormularName,$InputName_Action,"list",___("Ansicht aktualisieren"));
$Form->add_InputOption($FormularName,$InputName_Action,"filter_delete",___("Nach Adressen dursuchen und bearbeiten, Mails löschen"));
$Form->add_InputOption($FormularName,$InputName_Action,"filter",___("Nach Adressen durchsuchen und bearbeiten"));
$Form->add_InputOption($FormularName,$InputName_Action,"delete",___("Löschen"));

//submit button
$Form->new_Input($FormularName,$InputName_Submit,"submit",___("Aktion ausführen"));
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

/*DISPLAY*/
$_MAIN_OUTPUT.="\n\n<!-- bounce_mail_form_head.inc -->\n\n";
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['head'];
//hidden fieldsnicht vergessen!
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['act']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['host']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['limit']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['offset']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['set']['html'];
?>