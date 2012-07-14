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
$FormularName="bounce_filter";
//make new Form
$Form->new_Form($FormularName,$_SERVER["PHP_SELF"],"post","_self");
$Form->set_FormJS($FormularName," onSubmit=\"switchSection('div_loader');\" ");
//add a Description
$Form->set_FormDesc($FormularName,"Host waehlen");
//variable content aus menu als hidden field!
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
$Form->set_InputDefault($FormularName,$InputName_Mail,$$InputName_Mail);
$Form->set_InputStyleClass($FormularName,$InputName_Mail,"mFormCheckbox","mFormCheckboxFocus");
$Form->set_InputDesc($FormularName,$InputName_Mail,___("Auswählen"));
$Form->set_InputReadonly($FormularName,$InputName_Mail,false);
$Form->set_InputOrder($FormularName,$InputName_Mail,1);
$Form->set_InputLabel($FormularName,$InputName_Mail,"");
$Form->set_InputMultiple($FormularName,$InputName_Mail,true);

//Adr
$Form->new_Input($FormularName,$InputName_Adr,"checkbox", "");
$Form->set_InputDefault($FormularName,$InputName_Adr,$$InputName_Adr);
$Form->set_InputStyleClass($FormularName,$InputName_Adr,"mFormCheckbox","mFormCheckboxFocus");
$Form->set_InputDesc($FormularName,$InputName_Adr,___("Auswählen"));
$Form->set_InputReadonly($FormularName,$InputName_Adr,false);
$Form->set_InputOrder($FormularName,$InputName_Adr,1);
$Form->set_InputLabel($FormularName,$InputName_Adr,"");
$Form->set_InputMultiple($FormularName,$InputName_Adr,true);



//Aktion Mail
$Form->new_Input($FormularName,$InputName_Action,"select", "");
$Form->set_InputDefault($FormularName,$InputName_Action,$$InputName_Action);
$Form->set_InputStyleClass($FormularName,$InputName_Action,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Action,___("Aktion ausführen"));
$Form->set_InputReadonly($FormularName,$InputName_Action,false);
$Form->set_InputOrder($FormularName,$InputName_Action,1);
$Form->set_InputLabel($FormularName,$InputName_Action,"");
$Form->set_InputSize($FormularName,$InputName_Action,0,1);
$Form->set_InputMultiple($FormularName,$InputName_Action,false);
$Form->add_InputOption($FormularName,$InputName_Action,"list",___("Mails nicht löschen"));
$Form->add_InputOption($FormularName,$InputName_Action,"delete",___("Mails löschen"));

//Aktion Adr
$Form->new_Input($FormularName,$InputName_ActionAdr,"select", "");
$Form->set_InputDefault($FormularName,$InputName_ActionAdr,$$InputName_ActionAdr);
$Form->set_InputStyleClass($FormularName,$InputName_ActionAdr,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_ActionAdr,___("Aktion ausführen"));
$Form->set_InputReadonly($FormularName,$InputName_ActionAdr,false);
$Form->set_InputOrder($FormularName,$InputName_ActionAdr,1);
$Form->set_InputLabel($FormularName,$InputName_ActionAdr,"");
$Form->set_InputSize($FormularName,$InputName_ActionAdr,0,1);
$Form->set_InputMultiple($FormularName,$InputName_ActionAdr,false);
$Form->add_InputOption($FormularName,$InputName_ActionAdr,"auto",___("Adressen automatisch bearbeiten"));
$Form->add_InputOption($FormularName,$InputName_ActionAdr,"error",___("Adressen als Fehlerhaft markieren"));
$Form->add_InputOption($FormularName,$InputName_ActionAdr,"unsubscribe",___("Adressen abmelden und deaktivieren"));
$Form->add_InputOption($FormularName,$InputName_ActionAdr,"aktiv",___("Adressen deaktivieren"));
$Form->add_InputOption($FormularName,$InputName_ActionAdr,"delete",___("Adressen löschen"));

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
$Form->set_InputDesc($FormularName,$InputName_Reset,"Reset");
$Form->set_InputReadonly($FormularName,$InputName_Reset,false);
$Form->set_InputOrder($FormularName,$InputName_Reset,999);
$Form->set_InputLabel($FormularName,$InputName_Reset,"");

/*RENDER FORM*/
$Form->render_Form($FormularName);

/*DISPLAY*/
$_MAIN_OUTPUT.="\n\n<!-- bounce_filter_form_head.inc -->\n\n";
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['head'];
//hidden fieldsnicht vergessen!
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['act']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['host']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['limit']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['offset']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['set']['html'];

?>