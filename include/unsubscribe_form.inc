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
$FormularName="unsubscribe";
//make new Form
//$Form->new_Form($FormularName,$mnl_URL."/unsubscribe.php","post","_self");
$Form->new_Form($FormularName,$_SERVER["PHP_SELF"],"post","_self");
//add a Description
$Form->set_FormDesc($FormularName,"unsubscribe");
$Form->new_Input($FormularName,"set", "hidden", "unsubscribe");
$Form->new_Input($FormularName,"a_id", "hidden", $a_id);
$Form->new_Input($FormularName,"h_id", "hidden", $h_id);
$Form->new_Input($FormularName,"nl_id", "hidden", $nl_id);
$Form->new_Input($FormularName,"c", "hidden", $code);

//////////////////
//add inputfields and buttons....
//////////////////
//EMAIL
$Form->new_Input($FormularName,$InputName_Name,"text", $$InputName_Name);
$Form->set_InputStyleClass($FormularName,$InputName_Name,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Name,48,256);
$Form->set_InputDesc($FormularName,$InputName_Name,"");
$Form->set_InputReadonly($FormularName,$InputName_Name,false);
$Form->set_InputOrder($FormularName,$InputName_Name,1);
$Form->set_InputLabel($FormularName,$InputName_Name,"");



//submit button 
$Form->new_Input($FormularName,$InputName_Submit,"submit","Abmelden");
$Form->set_InputStyleClass($FormularName,$InputName_Submit,"mFormSubmit","mFormSubmitFocus");
$Form->set_InputDesc($FormularName,$InputName_Submit,"");
$Form->set_InputReadonly($FormularName,$InputName_Submit,false);
$Form->set_InputOrder($FormularName,$InputName_Submit,998);
$Form->set_InputLabel($FormularName,$InputName_Submit,"");

/*RENDER FORM*/

$Form->render_Form($FormularName);
//then you dont have to render the head and foot .....

/*DISPLAY*/

$FHEAD= $Form->FORM[$FormularName]['head'];
$FHEAD.= $Form->INPUT[$FormularName]['a_id']['html'];
$FHEAD.= $Form->INPUT[$FormularName]['h_id']['html'];
$FHEAD.= $Form->INPUT[$FormularName]['nl_id']['html'];
$FHEAD.= $Form->INPUT[$FormularName]['c']['html'];
$FHEAD.= $Form->INPUT[$FormularName]['set']['html'];
$FEMAIL= $Form->INPUT[$FormularName][$InputName_Name]['html'];
$FSUBMIT= $Form->INPUT[$FormularName][$InputName_Submit]['html'];
$FFOOT=$Form->FORM[$FormularName]['foot'];;

?>