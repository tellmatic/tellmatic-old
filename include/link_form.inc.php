<?php
/********************************************************************************/
/* this file is part of: / diese Datei ist ein Teil von:                        */
/* tellmatic, the newslettermachine                                             */
/* tellmatic, die Newslettermaschine                                            */
/* 2006-2010 by Volker Augustin, multi.art.studio Hanau                            */
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
$FormularName="lnk_new";
//make new Form
$Form->new_Form($FormularName,$_SERVER["PHP_SELF"],"post","_self");
//$this->set_FormStyle($FormularName,"font-size:10pt;font-color=red;");
////$Form->set_FormStyleClass($FormularName,"mForm");
////$Form->set_FormInputStyleClass($FormularName,"mFormText","mFormTextFocus");

$Form->set_FormJS($FormularName," onSubmit=\"switchSection('div_loader');\" ");

//add a Description
$Form->set_FormDesc($FormularName,___("Neuen Link erstellen / Link bearbeiten"));
$Form->new_Input($FormularName,"act", "hidden", $action);
$Form->new_Input($FormularName,"set", "hidden", "save");
$Form->new_Input($FormularName,"lnk_id", "hidden", $lnk_id);
//suchparameter
$Form->new_Input($FormularName,"offset", "hidden", $offset);
$Form->new_Input($FormularName,"limit", "hidden", $limit);
$Form->new_Input($FormularName,"s_name", "hidden", $s_name);
$Form->new_Input($FormularName,"s_url", "hidden", $s_url);
$Form->new_Input($FormularName,"lnk_grp_id", "hidden", $lnk_grp_id);
$Form->new_Input($FormularName,"st", "hidden", $st);
$Form->new_Input($FormularName,"si", "hidden", $si);

//////////////////
//add inputfields and buttons....
//////////////////
//Name
$Form->new_Input($FormularName,$InputName_Name,"text", display($$InputName_Name));
$Form->set_InputJS($FormularName,$InputName_Name," onChange=\"flash('submit','#ff0000');\"");
$Form->set_InputStyleClass($FormularName,$InputName_Name,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Name,48,256);
$Form->set_InputDesc($FormularName,$InputName_Name,___("Name"));
$Form->set_InputReadonly($FormularName,$InputName_Name,false);
$Form->set_InputOrder($FormularName,$InputName_Name,1);
$Form->set_InputLabel($FormularName,$InputName_Name,"");

//url
$Form->new_Input($FormularName,$InputName_URL,"text", display($$InputName_URL));
$Form->set_InputJS($FormularName,$InputName_URL," onChange=\"flash('submit','#ff0000');\"");
$Form->set_InputStyleClass($FormularName,$InputName_URL,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_URL,48,256);
$Form->set_InputDesc($FormularName,$InputName_URL,___("URL"));
$Form->set_InputReadonly($FormularName,$InputName_URL,false);
$Form->set_InputOrder($FormularName,$InputName_URL,1);
$Form->set_InputLabel($FormularName,$InputName_URL,"");

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
$Form->set_InputOrder($FormularName,$InputName_Group,4);
$Form->set_InputLabel($FormularName,$InputName_Group,"");
$Form->set_InputSize($FormularName,$InputName_Group,0,10);
$Form->set_InputMultiple($FormularName,$InputName_Group,true);
//add Data
$LINK=new tm_LNK();
$LNKGRP=$LINK->getGroup();
$acg=count($LNKGRP);
for ($accg=0; $accg<$acg; $accg++)
{
	$Form->add_InputOption($FormularName,$InputName_Group,$LNKGRP[$accg]['id'],$LNKGRP[$accg]['name']);
}

//short
$Form->new_Input($FormularName,$InputName_Short,"text", display($$InputName_Short));
$Form->set_InputJS($FormularName,$InputName_Short," onChange=\"flash('submit','#ff0000');\"  onkeyup=\"RemoveInvalidChars(this, '[^A-Za-z0-9\_\.\-]'); ForceLowercase(this);\"");
$Form->set_InputStyleClass($FormularName,$InputName_Short,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Short,48,256);
$Form->set_InputDesc($FormularName,$InputName_Short,___("Kurzbezeichnung/Kürzel"));
$Form->set_InputReadonly($FormularName,$InputName_Short,false);
$Form->set_InputOrder($FormularName,$InputName_Short,1);
$Form->set_InputLabel($FormularName,$InputName_Short,"");

//Descr
$Form->new_Input($FormularName,$InputName_Descr,"textarea", display($$InputName_Descr));
$Form->set_InputJS($FormularName,$InputName_Descr," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Descr,"mFormTextarea","mFormTextareaFocus");
$Form->set_InputSize($FormularName,$InputName_Descr,20,5);
$Form->set_InputDesc($FormularName,$InputName_Descr,___("Beschreibung"));
$Form->set_InputReadonly($FormularName,$InputName_Descr,false);
$Form->set_InputOrder($FormularName,$InputName_Descr,5);
$Form->set_InputLabel($FormularName,$InputName_Descr,"");

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
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['lnk_id']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['offset']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['limit']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['s_name']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['s_url']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['lnk_grp_id']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['st']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['si']['html'];
$_MAIN_OUTPUT.= "<table border=0>";

//assume an edit
if (!empty($lnk_id) && isset($LNK[0])) {
	$_MAIN_OUTPUT.= "<tr>";
	$_MAIN_OUTPUT.= "<td colspan=\"2\">";
	$_MAIN_OUTPUT.= "ID: <b>".$LNK[0]['id']."</b>";
	$_MAIN_OUTPUT.= "<br>";
	$_MAIN_OUTPUT.= sprintf(___("Erstellt am: %s von %s"),"<b>".$LNK[0]['created']."</b>","<b>".$LNK[0]['author']."</b>");
	$_MAIN_OUTPUT.= "<br>";
	$_MAIN_OUTPUT.= sprintf(___("Bearbeitet am: %s von %s"),"<b>".$LNK[0]['updated']."</b>","<b>".$LNK[0]['editor']."</b>");
	$_MAIN_OUTPUT.= "<br><br>";
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "</tr>";
}

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("tick.png",___("Aktiv")).tm_icon("cancel.png",___("Inaktiv"))."&nbsp;".___("Aktiv");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=\"top\" 	align=left>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Aktiv]['html'];
$_MAIN_OUTPUT.= "</td>";

$_MAIN_OUTPUT.= "<td valign=\"top\" rowspan=13 align=left>";
$_MAIN_OUTPUT.= tm_icon("group.png",___("Gruppen"))."&nbsp;".___("Gruppen")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Group]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("email.png",___("Kürzel"))."&nbsp;".___("Kürzel");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Short]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("textfield.png",___("Name"))."&nbsp;".___("Name");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=\"top\" 	align=left>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Name]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("link.png",___("URL"))."&nbsp;".___("URL");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=\"top\" 	align=left>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_URL]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("textfield.png",___("Beschreibung"))."&nbsp;".___("Beschreibung");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=\"top\" 	align=left>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Descr]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\" colspan=3><br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Submit]['html'];
//$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Reset]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "</table>";
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['foot'];

?>