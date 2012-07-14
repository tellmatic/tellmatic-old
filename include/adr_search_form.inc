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
$FormularName="adr_new";
//make new Form
$Form->new_Form($FormularName,$_SERVER["PHP_SELF"],"post","_self");
//$this->set_FormStyle($FormularName,"font-size:10pt;font-color=red;");
////$Form->set_FormStyleClass($FormularName,"mForm");
////$Form->set_FormInputStyleClass($FormularName,"mFormText","mFormTextFocus");
//add a Description
$Form->set_FormDesc($FormularName,___("Adressen suchen und filtern"));
//variable content aus menu als hidden field!
//$Form->new_Input($FormularName,"type", "hidden", $content);
$Form->new_Input($FormularName,"act", "hidden", $action);
$Form->new_Input($FormularName,"set", "hidden", "search");

//////////////////
//add inputfields and buttons....
//////////////////
//EMAIL
$Form->new_Input($FormularName,$InputName_Name,"text","");
$Form->set_InputStyleClass($FormularName,$InputName_Name,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Name,12,256);
$Form->set_InputDesc($FormularName,$InputName_Name,___("Suche nach e-Mail"));
$Form->set_InputReadonly($FormularName,$InputName_Name,false);
$Form->set_InputOrder($FormularName,$InputName_Name,1);
$Form->set_InputLabel($FormularName,$InputName_Name,"e-Mail<br>");

//F
$Form->new_Input($FormularName,$InputName_F,"text", $$InputName_F);
$Form->set_InputStyleClass($FormularName,$InputName_F,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F,12,256);
$Form->set_InputDesc($FormularName,$InputName_F,___("Suche in den Feldern F0-F9"));
$Form->set_InputReadonly($FormularName,$InputName_F,false);
$Form->set_InputOrder($FormularName,$InputName_F,1);
$Form->set_InputLabel($FormularName,$InputName_F,"F0-F9<br>");


//Gruppe
$Form->new_Input($FormularName,$InputName_Group,"select", "");
$Form->set_InputDefault($FormularName,$InputName_Group,$adr_grp_id);
$Form->set_InputStyleClass($FormularName,$InputName_Group,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Group,___("Suche nach Gruppenzugehoerigkeit"));
$Form->set_InputReadonly($FormularName,$InputName_Group,false);
$Form->set_InputOrder($FormularName,$InputName_Group,6);
$Form->set_InputLabel($FormularName,$InputName_Group,"Gruppe<br>");
//$Form->set_InputValue($FormularName,$InputName_Group,"");
$Form->set_InputSize($FormularName,$InputName_Group,0,1);
$Form->set_InputMultiple($FormularName,$InputName_Group,false);
//add Data
$ADDRESS=new mnlADR();
$GRP=$ADDRESS->getGroup();
$acg=count($GRP);

$Form->add_InputOption($FormularName,$InputName_Group,"","-- alle");
for ($accg=0; $accg<$acg; $accg++)
{
	$Form->add_InputOption($FormularName,$InputName_Group,$GRP[$accg]['id'],$GRP[$accg]['name']);
}

//Author bzw Formular! Form_[ID]
$Form->new_Input($FormularName,$InputName_Author,"select", "");
$Form->set_InputDefault($FormularName,$InputName_Author,$author);
$Form->set_InputStyleClass($FormularName,$InputName_Author,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Author,___("Author, angemeldet ueber Formular"));
$Form->set_InputReadonly($FormularName,$InputName_Author,false);
$Form->set_InputOrder($FormularName,$InputName_Author,6);
$Form->set_InputLabel($FormularName,$InputName_Author,___("angemeldet ueber")."<br>");
//$Form->set_InputValue($FormularName,$InputName_Author,"");
$Form->set_InputSize($FormularName,$InputName_Author,0,1);
$Form->set_InputMultiple($FormularName,$InputName_Author,false);
//add Data
$FORMULAR=new mnlFRM();
$FRM=$FORMULAR->getForm();
$fcg=count($FRM);

$Form->add_InputOption($FormularName,$InputName_Author,"","-- alle");
for ($fccg=0; $fccg<$fcg; $fccg++)
{
//	$Form->add_InputOption($FormularName,$InputName_Author,$FRM[$fccg]['id'],$FRM[$fccg]['name']."(".$FRM[$fccg]['id'].")");
	$Form->add_InputOption($FormularName,$InputName_Author,$FRM[$fccg]['id'],"Formular ID ".$FRM[$fccg]['id']);
}

//Status
$Form->new_Input($FormularName,$InputName_Status,"select", "");
$Form->set_InputDefault($FormularName,$InputName_Status,$status);
$Form->set_InputStyleClass($FormularName,$InputName_Status,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Status,___("Suche nach Adress-Status"));
$Form->set_InputReadonly($FormularName,$InputName_Status,false);
$Form->set_InputOrder($FormularName,$InputName_Status,6);
$Form->set_InputLabel($FormularName,$InputName_Status,___("Status")."<br>");
$Form->set_InputSize($FormularName,$InputName_Status,0,1);
$Form->set_InputMultiple($FormularName,$InputName_Status,false);
//add Data
$sc=count($STATUS['adr']['status']);

$Form->add_InputOption($FormularName,$InputName_Status,"","-- ".___("Egal"));
for ($scc=1; $scc<=$sc; $scc++)//0
{
	$Form->add_InputOption($FormularName,$InputName_Status,$scc,$STATUS['adr']['status'][$scc]);
}


//Limit
$Form->new_Input($FormularName,$InputName_Limit,"select", "");
$Form->set_InputDefault($FormularName,$InputName_Limit,$limit);
$Form->set_InputStyleClass($FormularName,$InputName_Limit,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Limit,___("Maximale Anzahl Eintraege die auf einmal angezeigt werden."));
$Form->set_InputReadonly($FormularName,$InputName_Limit,false);
$Form->set_InputOrder($FormularName,$InputName_Limit,6);
$Form->set_InputLabel($FormularName,$InputName_Limit,___("zeige max.")."<br>");
//$Form->set_InputValue($FormularName,$InputName_Group,"");
$Form->set_InputSize($FormularName,$InputName_Limit,0,1);
$Form->set_InputMultiple($FormularName,$InputName_Limit,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_Limit,5,"5 ".___("Adressen"));
$Form->add_InputOption($FormularName,$InputName_Limit,10,"10 ".___("Adressen"));
$Form->add_InputOption($FormularName,$InputName_Limit,25,"25 ".___("Adressen"));
$Form->add_InputOption($FormularName,$InputName_Limit,50,"50 ".___("Adressen"));
$Form->add_InputOption($FormularName,$InputName_Limit,100,"100 ".___("Adressen"));

//submit button 
$Form->new_Input($FormularName,$InputName_Submit,"submit",___("Suchen"));
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
$_MAIN_OUTPUT.= "<table border=0>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Name]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
//$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Status]['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F]['html'];
$_MAIN_OUTPUT.= "</td>";
/*
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";
*/
$_MAIN_OUTPUT.= "<td valign=top>";
//$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F]['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Status]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Group]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Limit]['html'];
$_MAIN_OUTPUT.= "</td>";

$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Author]['html'];
$_MAIN_OUTPUT.= "</td>";

$_MAIN_OUTPUT.= "<td valign=bottom colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Submit]['html'];
//$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Reset]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "</table>";
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['foot'];
?>