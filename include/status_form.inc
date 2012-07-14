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
$Form=new mSimpleForm();
$FormularName="status";
//make new Form
$Form->new_Form($FormularName,$_SERVER["PHP_SELF"],"post","_self");
//$this->set_FormStyle($FormularName,"font-size:10pt;font-color=red;");
////$Form->set_FormStyleClass($FormularName,"mForm");
////$Form->set_FormInputStyleClass($FormularName,"mFormText","mFormTextFocus");

$Form->set_FormJS($FormularName," onSubmit=\"switchSection('div_loader');\" ");

//add a Description
$Form->set_FormDesc($FormularName,___("Top X"));
//variable content aus menu als hidden field!
//$Form->new_Input($FormularName,"type", "hidden", $content);
$Form->new_Input($FormularName,"act", "hidden", $action);

//////////////////
//add inputfields and buttons....
//////////////////
//Top X
$Form->new_Input($FormularName,$InputName_TopX,"select", "");
$Form->set_InputDefault($FormularName,$InputName_TopX,$show_top_x);
$Form->set_InputStyleClass($FormularName,$InputName_TopX,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_TopX,___("Zeige Top X Einträge"));
$Form->set_InputReadonly($FormularName,$InputName_TopX,false);
$Form->set_InputOrder($FormularName,$InputName_TopX,6);
$Form->set_InputLabel($FormularName,$InputName_TopX,"Top ");
$Form->set_InputSize($FormularName,$InputName_TopX,0,1);
$Form->set_InputMultiple($FormularName,$InputName_TopX,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_TopX,5,5);
$Form->add_InputOption($FormularName,$InputName_TopX,10,10);
$Form->add_InputOption($FormularName,$InputName_TopX,25,25);
$Form->add_InputOption($FormularName,$InputName_TopX,50,50);

//submit button 
$Form->new_Input($FormularName,$InputName_Submit,"submit",___("Anzeigen"));
$Form->set_InputStyleClass($FormularName,$InputName_Submit,"mFormSubmit","mFormSubmitFocus");
$Form->set_InputDesc($FormularName,$InputName_Submit,"");
$Form->set_InputReadonly($FormularName,$InputName_Submit,false);
$Form->set_InputOrder($FormularName,$InputName_Submit,998);
$Form->set_InputLabel($FormularName,$InputName_Submit,"");


/*RENDER FORM*/

$Form->render_Form($FormularName);
//then you dont have to render the head and foot .....

/*DISPLAY*/
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['head'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['act']['html'];
$_MAIN_OUTPUT.= "<table border=0>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_TopX]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=bottom colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Submit]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "</table>";
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['foot'];
?>