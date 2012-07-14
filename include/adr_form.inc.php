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
$FormularName="adr_new";
//make new Form
$Form->new_Form($FormularName,$_SERVER["PHP_SELF"],"post","_self");
$Form->set_FormJS($FormularName," onSubmit=\"switchSection('div_loader');\" ");
//add a Description
$Form->set_FormDesc($FormularName,___("Neue Adresse erstellen"));
$Form->new_Input($FormularName,"act", "hidden", $action);
$Form->new_Input($FormularName,"set", "hidden", "save");
$Form->new_Input($FormularName,"adr_id", "hidden", $adr_id);
//suchparameter
$Form->new_Input($FormularName,"offset", "hidden", $offset);
$Form->new_Input($FormularName,"limit", "hidden", $limit);
$Form->new_Input($FormularName,"s_email", "hidden", $s_email);
$Form->new_Input($FormularName,"s_status", "hidden", $s_status);
$Form->new_Input($FormularName,"s_author", "hidden", $s_author);
$Form->new_Input($FormularName,"adr_grp_id", "hidden", $adr_grp_id);
$Form->new_Input($FormularName,"st", "hidden", $st);
$Form->new_Input($FormularName,"si", "hidden", $si);
$Form->new_Input($FormularName,"si0", "hidden", $si0);
$Form->new_Input($FormularName,"si1", "hidden", $si1);
$Form->new_Input($FormularName,"si2", "hidden", $si2);

//////////////////
//add inputfields and buttons....
//////////////////
//EMAIL
$Form->new_Input($FormularName,$InputName_Name,"text", $$InputName_Name);
$Form->set_InputJS($FormularName,$InputName_Name," onChange=\"flash('submit','#ff0000');\" onkeyup=\"RemoveInvalidChars(this, '[^A-Za-z0-9\_\@\.\-]'); ForceLowercase(this);\"");
$Form->set_InputStyleClass($FormularName,$InputName_Name,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Name,48,256);
$Form->set_InputDesc($FormularName,$InputName_Name,___("E-Mail"));
$Form->set_InputReadonly($FormularName,$InputName_Name,false);
$Form->set_InputOrder($FormularName,$InputName_Name,1);
$Form->set_InputLabel($FormularName,$InputName_Name,"");

//Aktiv
	$Form->new_Input($FormularName,$InputName_Aktiv,"checkbox", 1);
	$Form->set_InputJS($FormularName,$InputName_Aktiv," onChange=\"flash('submit','#ff0000');\" ");
	$Form->set_InputDefault($FormularName,$InputName_Aktiv,$$InputName_Aktiv);
	$Form->set_InputStyleClass($FormularName,$InputName_Aktiv,"mFormCheckbox","mFormCheckboxFocus");
	$Form->set_InputSize($FormularName,$InputName_Aktiv,1,1);
	$Form->set_InputDesc($FormularName,$InputName_Aktiv,___("Aktiv"));
	$Form->set_InputReadonly($FormularName,$InputName_Aktiv,false);
	$Form->set_InputOrder($FormularName,$InputName_Aktiv,2);
	$Form->set_InputLabel($FormularName,$InputName_Aktiv,"");

//Gruppe
$Form->new_Input($FormularName,$InputName_Group,"select", "");
$Form->set_InputJS($FormularName,$InputName_Group," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Group,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Group,___("Gruppen wählen, STRG/CTRL gedrückt halten und klicken f. Mehrfachauswahl"));
$Form->set_InputReadonly($FormularName,$InputName_Group,false);
$Form->set_InputOrder($FormularName,$InputName_Group,6);
$Form->set_InputLabel($FormularName,$InputName_Group,"");
$Form->set_InputSize($FormularName,$InputName_Group,0,10);
$Form->set_InputMultiple($FormularName,$InputName_Group,true);
//add Data
$ADDRESS=new tm_ADR();
$GRP=$ADDRESS->getGroup();
$acg=count($GRP);
for ($accg=0; $accg<$acg; $accg++)
{
	$Form->add_InputOption($FormularName,$InputName_Group,$GRP[$accg]['id'],$GRP[$accg]['name']);
}

//Status
$Form->new_Input($FormularName,$InputName_Status,"select", "");
$Form->set_InputJS($FormularName,$InputName_Status," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_Status,$status);
$Form->set_InputStyleClass($FormularName,$InputName_Status,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Status,___("Status"));
$Form->set_InputReadonly($FormularName,$InputName_Status,false);
$Form->set_InputOrder($FormularName,$InputName_Status,6);
$Form->set_InputLabel($FormularName,$InputName_Status,"");
$Form->set_InputSize($FormularName,$InputName_Status,0,1);
$Form->set_InputMultiple($FormularName,$InputName_Status,false);
//add Data
$sc=count($STATUS['adr']['status']);

for ($scc=1; $scc<=$sc; $scc++)//0
{
	$Form->add_InputOption($FormularName,$InputName_Status,$scc,$STATUS['adr']['status'][$scc]);
}

//MEMO
$Form->new_Input($FormularName,$InputName_Memo,"textarea", $$InputName_Memo);
$Form->set_InputDefault($FormularName,$InputName_Memo,$$InputName_Memo);
$Form->set_InputStyleClass($FormularName,$InputName_Memo,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Memo,80,5);
$Form->set_InputDesc($FormularName,$InputName_Memo,"");
$Form->set_InputReadonly($FormularName,$InputName_Memo,false);
$Form->set_InputOrder($FormularName,$InputName_Memo,1);
$Form->set_InputLabel($FormularName,$InputName_Memo,"");

//F
$Form->new_Input($FormularName,$InputName_F0,"text", $$InputName_F0);
$Form->set_InputJS($FormularName,$InputName_F0," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F0,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F0,48,256);
$Form->set_InputDesc($FormularName,$InputName_F0,"F0");
$Form->set_InputReadonly($FormularName,$InputName_F0,false);
$Form->set_InputOrder($FormularName,$InputName_F0,1);
$Form->set_InputLabel($FormularName,$InputName_F0,"");

//F
$Form->new_Input($FormularName,$InputName_F1,"text", $$InputName_F1);
$Form->set_InputJS($FormularName,$InputName_F1," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F1,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F1,48,256);
$Form->set_InputDesc($FormularName,$InputName_F1,"F1");
$Form->set_InputReadonly($FormularName,$InputName_F1,false);
$Form->set_InputOrder($FormularName,$InputName_F1,1);
$Form->set_InputLabel($FormularName,$InputName_F1,"");

//F
$Form->new_Input($FormularName,$InputName_F2,"text", $$InputName_F2);
$Form->set_InputJS($FormularName,$InputName_F2," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F2,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F2,48,256);
$Form->set_InputDesc($FormularName,$InputName_F2,"F2");
$Form->set_InputReadonly($FormularName,$InputName_F2,false);
$Form->set_InputOrder($FormularName,$InputName_F2,1);
$Form->set_InputLabel($FormularName,$InputName_F2,"");

//F
$Form->new_Input($FormularName,$InputName_F3,"text", $$InputName_F3);
$Form->set_InputJS($FormularName,$InputName_F3," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F3,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F3,48,256);
$Form->set_InputDesc($FormularName,$InputName_F3,"F3");
$Form->set_InputReadonly($FormularName,$InputName_F3,false);
$Form->set_InputOrder($FormularName,$InputName_F3,1);
$Form->set_InputLabel($FormularName,$InputName_F3,"");

//F
$Form->new_Input($FormularName,$InputName_F4,"text", $$InputName_F4);
$Form->set_InputJS($FormularName,$InputName_F4," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F4,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F4,48,256);
$Form->set_InputDesc($FormularName,$InputName_F4,"F4");
$Form->set_InputReadonly($FormularName,$InputName_F4,false);
$Form->set_InputOrder($FormularName,$InputName_F4,1);
$Form->set_InputLabel($FormularName,$InputName_F4,"");

//F
$Form->new_Input($FormularName,$InputName_F5,"text", $$InputName_F5);
$Form->set_InputJS($FormularName,$InputName_F5," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F5,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F5,48,256);
$Form->set_InputDesc($FormularName,$InputName_F5,"F5");
$Form->set_InputReadonly($FormularName,$InputName_F5,false);
$Form->set_InputOrder($FormularName,$InputName_F5,1);
$Form->set_InputLabel($FormularName,$InputName_F5,"");

//F
$Form->new_Input($FormularName,$InputName_F6,"text", $$InputName_F6);
$Form->set_InputJS($FormularName,$InputName_F6," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F6,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F6,48,256);
$Form->set_InputDesc($FormularName,$InputName_F6,"F6");
$Form->set_InputReadonly($FormularName,$InputName_F6,false);
$Form->set_InputOrder($FormularName,$InputName_F6,1);
$Form->set_InputLabel($FormularName,$InputName_F6,"");

//F
$Form->new_Input($FormularName,$InputName_F7,"text", $$InputName_F7);
$Form->set_InputJS($FormularName,$InputName_F7," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F7,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F7,48,256);
$Form->set_InputDesc($FormularName,$InputName_F7,"F7");
$Form->set_InputReadonly($FormularName,$InputName_F7,false);
$Form->set_InputOrder($FormularName,$InputName_F7,1);
$Form->set_InputLabel($FormularName,$InputName_F7,"");

//F
$Form->new_Input($FormularName,$InputName_F8,"text", $$InputName_F8);
$Form->set_InputJS($FormularName,$InputName_F8," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F8,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F8,48,256);
$Form->set_InputDesc($FormularName,$InputName_F8,"F8");
$Form->set_InputReadonly($FormularName,$InputName_F8,false);
$Form->set_InputOrder($FormularName,$InputName_F8,1);
$Form->set_InputLabel($FormularName,$InputName_F8,"");

//F
$Form->new_Input($FormularName,$InputName_F9,"text", $$InputName_F9);
$Form->set_InputJS($FormularName,$InputName_F9," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_F9,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_F9,48,256);
$Form->set_InputDesc($FormularName,$InputName_F9,"F9");
$Form->set_InputReadonly($FormularName,$InputName_F9,false);
$Form->set_InputOrder($FormularName,$InputName_F9,1);
$Form->set_InputLabel($FormularName,$InputName_F9,"");



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

/*DISPLAY*/
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['head'];
//hidden fieldsnicht vergessen!
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['act']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['set']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['adr_id']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['offset']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['limit']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['s_email']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['s_status']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['s_author']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['adr_grp_id']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['st']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['si']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['si0']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['si1']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['si2']['html'];
$_MAIN_OUTPUT.= "<table border=0>";

if (!empty($adr_id)) {
	$_MAIN_OUTPUT.= "<tr>";
	$_MAIN_OUTPUT.= "<td colspan=\"2\">";
	$_MAIN_OUTPUT.= "ID: <b>".$ADR[0]['id']."</b>";
	$_MAIN_OUTPUT.= "<br>";
	$_MAIN_OUTPUT.= sprintf(___("Erstellt am: %s von %s"),"<b>".$ADR[0]['author']."</b>","<b>".$ADR[0]['created']."</b>");
	$_MAIN_OUTPUT.= "<br>";
	$_MAIN_OUTPUT.= sprintf(___("Bearbeitet am: %s von %s"),"<b>".$ADR[0]['editor']."</b>","<b>".$ADR[0]['updated']."</b>");
	$_MAIN_OUTPUT.= "<br><br>";
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "</tr>";
}

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("email.png",___("E-Mail"))."&nbsp;".___("E-Mail");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Name]['html'];
$_MAIN_OUTPUT.= "</td>";

$_MAIN_OUTPUT.= "<td valign=top rowspan=13 align=left>";
$_MAIN_OUTPUT.= tm_icon("group.png",___("Gruppen"))."&nbsp;".___("Gruppen")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Group]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("tick.png",___("Aktiv")).tm_icon("cancel.png",___("Inaktiv"))."&nbsp;".___("Aktiv");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top 	align=left>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Aktiv]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("lightbulb.png",___("Status"))."&nbsp;".___("Status");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top 	align=left>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Status]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= "F0";
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1 align=left>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F0]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= "F1";
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F1]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= "F2";
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F2]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= "F3";
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F3]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= "F4";
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F4]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= "F5";
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F5]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= "F6";
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F6]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= "F7";
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F7]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= "F8";
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F8]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= "F9";
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_F9]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("layout.png",___("Memo"))."&nbsp;".___("Memo");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=2>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Memo]['html'];
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