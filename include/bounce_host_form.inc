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
$FormularName="bounce_host";
//make new Form
$Form->new_Form($FormularName,$_SERVER["PHP_SELF"],"post","_self");
//$this->set_FormStyle($FormularName,"font-size:10pt;font-color=red;");
////$Form->set_FormStyleClass($FormularName,"mForm");
////$Form->set_FormInputStyleClass($FormularName,"mFormText","mFormTextFocus");
//add a Description
$Form->set_FormDesc($FormularName,___("Host waehlen"));
//variable content aus menu als hidden field!
//$Form->new_Input($FormularName,"type", "hidden", $content);
$Form->new_Input($FormularName,"act", "hidden", $action);
$Form->new_Input($FormularName,"set", "hidden", "connect");
$Form->new_Input($FormularName,"val", "hidden", "list");

//////////////////
//add inputfields and buttons....
//////////////////
//HOST
$Form->new_Input($FormularName,$InputName_Host,"select", "");
$Form->set_InputDefault($FormularName,$InputName_Host,$$InputName_Host);
$Form->set_InputStyleClass($FormularName,$InputName_Host,"mFormSelect","mFormSelectFocus");
$Form->set_InputSize($FormularName,$InputName_Host,1,1);
$Form->set_InputDesc($FormularName,$InputName_Host,___("Host auswaehlen"));
$Form->set_InputReadonly($FormularName,$InputName_Host,true);
$Form->set_InputOrder($FormularName,$InputName_Host,1);
$Form->set_InputLabel($FormularName,$InputName_Host,"");
$Form->set_InputMultiple($FormularName,$InputName_Host,false);
$Form->add_InputOption($FormularName,$InputName_Host,$$InputName_Host,$$InputName_Host);

//Offset
$Form->new_Input($FormularName,$InputName_Offset,"select", "");
$Form->set_InputDefault($FormularName,$InputName_Offset,$$InputName_Offset);
$Form->set_InputStyleClass($FormularName,$InputName_Offset,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Offset,___("Anzahl Mails die uebersprungen werden."));
$Form->set_InputReadonly($FormularName,$InputName_Offset,false);
$Form->set_InputOrder($FormularName,$InputName_Offset,1);
$Form->set_InputLabel($FormularName,$InputName_Offset,"");
$Form->set_InputSize($FormularName,$InputName_Offset,0,1);
$Form->set_InputMultiple($FormularName,$InputName_Offset,false);

for ($occ=0;$occ<=500;$occ=$occ+25) {
	$Form->add_InputOption($FormularName,$InputName_Offset,$occ,$occ." ");
}

/*
$Form->add_InputOption($FormularName,$InputName_Offset,"10","10 Mails");
$Form->add_InputOption($FormularName,$InputName_Offset,"25","25 Mails");
$Form->add_InputOption($FormularName,$InputName_Offset,"50","50 Mails");
$Form->add_InputOption($FormularName,$InputName_Offset,"100","100 Mails");
$Form->add_InputOption($FormularName,$InputName_Offset,"250","250 Mails");
$Form->add_InputOption($FormularName,$InputName_Offset,"500","500 Mails");
$Form->add_InputOption($FormularName,$InputName_Offset,"1000","1000 Mails");
*/
//Limit
$Form->new_Input($FormularName,$InputName_Limit,"select", "");
$Form->set_InputDefault($FormularName,$InputName_Limit,$$InputName_Limit);
$Form->set_InputStyleClass($FormularName,$InputName_Limit,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Limit,___("max. Anzahl Mails die durchsucht/angezeigt werden."));
$Form->set_InputReadonly($FormularName,$InputName_Limit,false);
$Form->set_InputOrder($FormularName,$InputName_Limit,1);
$Form->set_InputLabel($FormularName,$InputName_Limit,"");
$Form->set_InputSize($FormularName,$InputName_Limit,0,1);
$Form->set_InputMultiple($FormularName,$InputName_Limit,false);
$Form->add_InputOption($FormularName,$InputName_Limit,"10","10 Mails");
$Form->add_InputOption($FormularName,$InputName_Limit,"25","25 Mails");
$Form->add_InputOption($FormularName,$InputName_Limit,"50","50 Mails");
$Form->add_InputOption($FormularName,$InputName_Limit,"100","100 Mails");
/*

$Form->add_InputOption($FormularName,$InputName_Limit,"250","250 Mails");
$Form->add_InputOption($FormularName,$InputName_Limit,"500","500 Mails");
$Form->add_InputOption($FormularName,$InputName_Limit,"1000","1000 Mails");
*/


//nur bounces
	$Form->new_Input($FormularName,$InputName_Bounce,"checkbox", 1);
	$Form->set_InputDefault($FormularName,$InputName_Bounce,$$InputName_Bounce);
	$Form->set_InputStyleClass($FormularName,$InputName_Bounce,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_Bounce,48,48);
	$Form->set_InputDesc($FormularName,$InputName_Bounce,___("Nur Bouncemails anzeigen"));
	$Form->set_InputReadonly($FormularName,$InputName_Bounce,false);
	$Form->set_InputOrder($FormularName,$InputName_Bounce,2);
	$Form->set_InputLabel($FormularName,$InputName_Bounce,"");

//to adresse filtern nach return path fuer den host
	$Form->new_Input($FormularName,$InputName_FilterTo,"checkbox", 1);
	$Form->set_InputDefault($FormularName,$InputName_FilterTo,$$InputName_FilterTo);
	$Form->set_InputStyleClass($FormularName,$InputName_FilterTo,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_FilterTo,48,48);
	$Form->set_InputDesc($FormularName,$InputName_FilterTo,___("Nur E-Mails an die Fehleradresse anzeigen"));
	$Form->set_InputReadonly($FormularName,$InputName_FilterTo,false);
	$Form->set_InputOrder($FormularName,$InputName_FilterTo,2);
	$Form->set_InputLabel($FormularName,$InputName_FilterTo,"");
//submit button 
$Form->new_Input($FormularName,$InputName_Submit,"submit",___("Verbinden und e-Mails abrufen"));
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
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['head'];
//hidden fieldsnicht vergessen!
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['act']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['set']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['val']['html'];
$_MAIN_OUTPUT.= "<table border=0>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>".___("Host")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Host]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>".___("Offset")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Offset]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>".___("Limit")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Limit]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1><br>";
$_MAIN_OUTPUT.= ___("Nur Bouncemails")." ".$Form->INPUT[$FormularName][$InputName_Bounce]['html'];
$_MAIN_OUTPUT.= " ".___("Nur Returnmails")." ".$Form->INPUT[$FormularName][$InputName_FilterTo]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=bottom colspan=1><br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Submit]['html'];
//$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Reset]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "</table>";
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['foot'];
?>