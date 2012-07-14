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

$ADDRESS=new mnlADR();//fuer die gruppen
//Form
$Form=new mSimpleForm();
$FormularName="adr_clean";
//make new Form
$Form->new_Form($FormularName,$_SERVER["PHP_SELF"],"post","_self");
//$this->set_FormStyle($FormularName,"font-size:10pt;font-color=red;");
////$Form->set_FormStyleClass($FormularName,"mForm");
////$Form->set_FormInputStyleClass($FormularName,"mFormText","mFormTextFocus");
//add a Description
$Form->set_FormDesc($FormularName,___("Adressdatenbank bereinigen"));
//variable content aus menu als hidden field!
//$Form->new_Input($FormularName,"type", "hidden", $content);
$Form->new_Input($FormularName,"act", "hidden", $action);
//set --> select!
//////////////////
//add inputfields and buttons....
//////////////////
//EMAIL
$Form->new_Input($FormularName,$InputName_Name,"text", $$InputName_Name);
$Form->set_InputStyleClass($FormularName,$InputName_Name,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Name,48,256);
$Form->set_InputDesc($FormularName,$InputName_Name,___("Filtern nach E-Mail"));
$Form->set_InputReadonly($FormularName,$InputName_Name,false);
$Form->set_InputOrder($FormularName,$InputName_Name,1);
$Form->set_InputLabel($FormularName,$InputName_Name,"");

//Gruppe src
$Form->new_Input($FormularName,$InputName_Group,"select", "");
$Form->set_InputDefault($FormularName,$InputName_Group,$adr_grp_id);
$Form->set_InputStyleClass($FormularName,$InputName_Group,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Group,___("Gruppe"));
$Form->set_InputReadonly($FormularName,$InputName_Group,false);
$Form->set_InputOrder($FormularName,$InputName_Group,6);
$Form->set_InputLabel($FormularName,$InputName_Group,"");
//$Form->set_InputValue($FormularName,$InputName_Group,"");
$Form->set_InputSize($FormularName,$InputName_Group,0,1);
$Form->set_InputMultiple($FormularName,$InputName_Group,false);
//add Data
$GRP=$ADDRESS->getGroup();
$acg=count($GRP);
for ($accg=0; $accg<$acg; $accg++)
{
	$Form->add_InputOption($FormularName,$InputName_Group,$GRP[$accg]['id'],$GRP[$accg]['name']);
}

//Gruppe dst
$Form->new_Input($FormularName,$InputName_GroupDst,"select", "");
$Form->set_InputDefault($FormularName,$InputName_GroupDst,$adr_grp_id_dst);
$Form->set_InputStyleClass($FormularName,$InputName_GroupDst,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_GroupDst,___("Gruppe"));
$Form->set_InputReadonly($FormularName,$InputName_GroupDst,false);
$Form->set_InputOrder($FormularName,$InputName_GroupDst,6);
$Form->set_InputLabel($FormularName,$InputName_GroupDst,"");
//$Form->set_InputValue($FormularName,$InputName_GroupDst,"");
$Form->set_InputSize($FormularName,$InputName_GroupDst,0,1);
$Form->set_InputMultiple($FormularName,$InputName_GroupDst,false);
//add Data
$GRP=$ADDRESS->getGroup();
$acg=count($GRP);
for ($accg=0; $accg<$acg; $accg++)
{
	$Form->add_InputOption($FormularName,$InputName_GroupDst,$GRP[$accg]['id'],$GRP[$accg]['name']);
}



//Status
$Form->new_Input($FormularName,$InputName_Status,"select", "");
$Form->set_InputDefault($FormularName,$InputName_Status,$status);
$Form->set_InputStyleClass($FormularName,$InputName_Status,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Status,___("Suche nach Adress-Status"));
$Form->set_InputReadonly($FormularName,$InputName_Status,false);
$Form->set_InputOrder($FormularName,$InputName_Status,6);
$Form->set_InputLabel($FormularName,$InputName_Status,"");
$Form->set_InputSize($FormularName,$InputName_Status,0,1);
$Form->set_InputMultiple($FormularName,$InputName_Status,false);
//add Data
$sc=count($STATUS['adr']['status']);

$Form->add_InputOption($FormularName,$InputName_Status,"delete_all",___("Alle fehlerhaften Adressen"));
for ($scc=$sc; $scc>7; $scc--)//>0 , array beginnt bei 1! 
{
	$Form->add_InputOption($FormularName,$InputName_Status,$scc,$STATUS['adr']['status'][$scc]." (".$STATUS['adr']['descr'][$scc].")");
}



//set!
$Form->new_Input($FormularName,$InputName_Set,"select", "");
$Form->set_InputDefault($FormularName,$InputName_Set,$set);
$Form->set_InputStyleClass($FormularName,$InputName_Set,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Set,___("Aktion"));
$Form->set_InputReadonly($FormularName,$InputName_Set,false);
$Form->set_InputOrder($FormularName,$InputName_Set,6);
$Form->set_InputLabel($FormularName,$InputName_Set,"");
$Form->set_InputSize($FormularName,$InputName_Set,0,1);
$Form->set_InputMultiple($FormularName,$InputName_Set,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_Set,"delete",___("Loeschen"));
//$Form->add_InputOption($FormularName,$InputName_Set,"move",">> Verschieben");


//submit button 

//onclick=\"return confirmLink(this, 'Adresse loeschen')\"

$Form->new_Input($FormularName,$InputName_Submit,"submit",___("Aktion Ausfuehren"));
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
$_MAIN_OUTPUT.= "<table border=0>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>".___("E-Mail (leer = alle! ; wildcard = '*' oder '%'")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Name]['html'];
$_MAIN_OUTPUT.= "</td>";

$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";

$_MAIN_OUTPUT.= "<td valign=top colspan=1>".___("aus der Gruppe:")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Group]['html'];
//$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_GroupDst]['html'];
$_MAIN_OUTPUT.= "</td>";

$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";

$_MAIN_OUTPUT.= "<td valign=top>".___("mit dem Status:")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Status]['html'];
$_MAIN_OUTPUT.= "</td>";

$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=bottom colspan=1 align=right>&nbsp;";
$_MAIN_OUTPUT.= "</td>";

$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=bottom colspan=1 align=right>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Set]['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Submit]['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Reset]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "</table>";
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['foot'];
?>