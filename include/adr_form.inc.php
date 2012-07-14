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
$Form->new_Input($FormularName,"s_aktiv", "hidden", $s_aktiv);
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
$Form->new_Input($FormularName,$InputName_Name,"text", display($$InputName_Name));
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
$Form->set_InputOrder($FormularName,$InputName_Group,4);
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
$Form->set_InputOrder($FormularName,$InputName_Status,3);
$Form->set_InputLabel($FormularName,$InputName_Status,"");
$Form->set_InputSize($FormularName,$InputName_Status,0,1);
$Form->set_InputMultiple($FormularName,$InputName_Status,false);
//add Data
$sc=count($STATUS['adr']['status']);

for ($scc=1; $scc<=$sc; $scc++)//0
{
	$Form->add_InputOption($FormularName,$InputName_Status,$scc,$STATUS['adr']['status'][$scc],"","color:".$STATUS['adr']['textcolor'][$scc]."; background-color:".$STATUS['adr']['color'][$scc].";");
}

//MEMO
$Form->new_Input($FormularName,$InputName_Memo,"textarea", display($$InputName_Memo));
$Form->set_InputDefault($FormularName,$InputName_Memo,display($$InputName_Memo));
$Form->set_InputStyleClass($FormularName,$InputName_Memo,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Memo,80,5);
$Form->set_InputDesc($FormularName,$InputName_Memo,"");
$Form->set_InputReadonly($FormularName,$InputName_Memo,false);
$Form->set_InputOrder($FormularName,$InputName_Memo,888);
$Form->set_InputLabel($FormularName,$InputName_Memo,"");

//F, neu f0-9
for ($fc=0;$fc<=9;$fc++) {
	$FInputName="InputName_F".$fc;
	$Form->new_Input($FormularName,$$FInputName,"text", $$$FInputName);
	$Form->set_InputJS($FormularName,$$FInputName," onChange=\"flash('submit','#ff0000');\" ");
	$Form->set_InputStyleClass($FormularName,$$FInputName,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$$FInputName,48,256);
	$Form->set_InputDesc($FormularName,$$FInputName,"F".$fc);
	$Form->set_InputReadonly($FormularName,$$FInputName,false);
	$Form->set_InputOrder($FormularName,$$FInputName,$fc+100);
	$Form->set_InputLabel($FormularName,$$FInputName,"");
}

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
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['s_aktiv']['html'];
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
	$_MAIN_OUTPUT.= sprintf(___("Erstellt am: %s von %s"),"<b>".$ADR[0]['created']."</b>","<b>".$ADR[0]['author']."</b>");
	$_MAIN_OUTPUT.= "<br>";
	$_MAIN_OUTPUT.= sprintf(___("Bearbeitet am: %s von %s"),"<b>".$ADR[0]['updated']."</b>","<b>".$ADR[0]['editor']."</b>");
	$_MAIN_OUTPUT.= "<br><br>";
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "</tr>";
}

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("email.png",___("E-Mail"))."&nbsp;".___("E-Mail");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Name]['html'];
$_MAIN_OUTPUT.= "</td>";

$_MAIN_OUTPUT.= "<td valign=\"top\" rowspan=13 align=left>";
$_MAIN_OUTPUT.= tm_icon("group.png",___("Gruppen"))."&nbsp;".___("Gruppen")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Group]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("tick.png",___("Aktiv")).tm_icon("cancel.png",___("Inaktiv"))."&nbsp;".___("Aktiv");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=\"top\" 	align=left>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Aktiv]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("lightbulb.png",___("Status"))."&nbsp;".___("Status");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=\"top\" 	align=left>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Status]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

//F, neu f0-9
for ($fc=0;$fc<=9;$fc++) {
	$FInputName="InputName_F".$fc;
	$_MAIN_OUTPUT.= "<tr>";
	$_MAIN_OUTPUT.= "<td valign=\"top\">";
	$_MAIN_OUTPUT.= "F".$fc;
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td valign=\"top\" colspan=1 align=left>";
	$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$$FInputName]['html'];
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "</tr>";

}

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\" colspan=1>";
$_MAIN_OUTPUT.= tm_icon("layout.png",___("Memo"))."&nbsp;".___("Memo");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=\"top\" align=\"left\"colspan=2>";
$_MAIN_OUTPUT.= tm_icon("pencil.png",___("Memo einblenden/bearbeiten"),___("Memo einblenden/bearbeiten"),"toggle_adrmemo")."&nbsp;".___("Memo einblenden/bearbeiten");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\" colspan=3>";
$_MAIN_OUTPUT.= "<div id=\"adr_memo\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Memo]['html'];
$_MAIN_OUTPUT.= "</div>";
$_MAIN_OUTPUT.= "
	<script type=\"text/javascript\">
		toggleSlide('toggle_adrmemo','adr_memo',1);
	</script>";
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";


$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\" colspan=3><br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Submit]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "</table>";
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['foot'];

?>