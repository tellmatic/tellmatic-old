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

$ADDRESS=new tm_ADR();//fuer die gruppen
//Form
$Form=new tm_SimpleForm();
$FormularName="adr_clean";
//make new Form
$Form->new_Form($FormularName,$_SERVER["PHP_SELF"],"post","_self");
$Form->set_FormJS($FormularName," onSubmit=\"switchSection('div_loader');\" ");
//add a Description
$Form->set_FormDesc($FormularName,___("Adressdatenbank bereinigen"));
$Form->new_Input($FormularName,"act", "hidden", $action);
//set --> select!
//////////////////
//add inputfields and buttons....
//////////////////
//EMAIL
$Form->new_Input($FormularName,$InputName_Name,"text", display($$InputName_Name));
$Form->set_InputJS($FormularName,$InputName_Name," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Name,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Name,32,256);
$Form->set_InputDesc($FormularName,$InputName_Name,___("Filtern nach E-Mail"));
$Form->set_InputReadonly($FormularName,$InputName_Name,false);
$Form->set_InputOrder($FormularName,$InputName_Name,1);
$Form->set_InputLabel($FormularName,$InputName_Name,"");

//Gruppe src filter
$Form->new_Input($FormularName,$InputName_Group,"select", "");
$Form->set_InputJS($FormularName,$InputName_Group," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_Group,$adr_grp_id);
$Form->set_InputStyleClass($FormularName,$InputName_Group,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Group,___("Gruppe"));
$Form->set_InputReadonly($FormularName,$InputName_Group,false);
$Form->set_InputOrder($FormularName,$InputName_Group,2);
$Form->set_InputLabel($FormularName,$InputName_Group,"");
$Form->set_InputSize($FormularName,$InputName_Group,0,1);
$Form->set_InputMultiple($FormularName,$InputName_Group,false);
//add Data
$GRP=$ADDRESS->getGroup();
$acg=count($GRP);
for ($accg=0; $accg<$acg; $accg++)
{
	$Form->add_InputOption($FormularName,$InputName_Group,$GRP[$accg]['id'],$GRP[$accg]['name']);
}

//Status filter
$Form->new_Input($FormularName,$InputName_Status,"select", "");
$Form->set_InputJS($FormularName,$InputName_Status," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_Status,$status);
$Form->set_InputStyleClass($FormularName,$InputName_Status,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Status,___("Suche nach Adress-Status"));
$Form->set_InputReadonly($FormularName,$InputName_Status,false);
$Form->set_InputOrder($FormularName,$InputName_Status,3);
$Form->set_InputLabel($FormularName,$InputName_Status,"");
$Form->set_InputSize($FormularName,$InputName_Status,0,1);
$Form->set_InputMultiple($FormularName,$InputName_Status,false);
//add Data
$sc=count($STATUS['adr']['status']);

$Form->add_InputOption($FormularName,$InputName_Status,0,___(" -- Alle -- "));
#$Form->add_InputOption($FormularName,$InputName_Status,"delete_all",___(" -- Alle fehlerhaften Adressen -- "));
for ($scc=$sc; $scc>0; $scc--)//>0 , array beginnt bei 1! //5 und 6 undefiniert //5
{
	$Form->add_InputOption($FormularName,$InputName_Status,$scc,$STATUS['adr']['status'][$scc]." (".$STATUS['adr']['descr'][$scc].")");
}


//Gruppe dst, ziel
$Form->new_Input($FormularName,$InputName_GroupDst,"select", "");
$Form->set_InputJS($FormularName,$InputName_GroupDst," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_GroupDst,$$InputName_GroupDst);
$Form->set_InputStyleClass($FormularName,$InputName_GroupDst,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_GroupDst,___("Gruppen"));
$Form->set_InputReadonly($FormularName,$InputName_GroupDst,false);
$Form->set_InputOrder($FormularName,$InputName_GroupDst,6);
$Form->set_InputLabel($FormularName,$InputName_GroupDst,"");
$Form->set_InputSize($FormularName,$InputName_GroupDst,0,5);
$Form->set_InputMultiple($FormularName,$InputName_GroupDst,true);
//add Data
$GRP=$ADDRESS->getGroup();
$acg=count($GRP);
for ($accg=0; $accg<$acg; $accg++)
{
	$Form->add_InputOption($FormularName,$InputName_GroupDst,$GRP[$accg]['id'],$GRP[$accg]['name']);
}

//StatusDst, ziel
$Form->new_Input($FormularName,$InputName_StatusDst,"select", "");
$Form->set_InputJS($FormularName,$InputName_StatusDst," onChange=\"flash('submit_adr','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_StatusDst,$$InputName_StatusDst);
$Form->set_InputStyleClass($FormularName,$InputName_StatusDst,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_StatusDst,___("Status"));
$Form->set_InputReadonly($FormularName,$InputName_StatusDst,false);
$Form->set_InputOrder($FormularName,$InputName_StatusDst,5);
$Form->set_InputLabel($FormularName,$InputName_StatusDst,"");
$Form->set_InputSize($FormularName,$InputName_StatusDst,0,1);
$Form->set_InputMultiple($FormularName,$InputName_StatusDst,false);
//add Data
$sc=count($STATUS['adr']['status']);

for ($scc=1; $scc<=$sc; $scc++)//0
{
	$Form->add_InputOption($FormularName,$InputName_StatusDst,$scc,$STATUS['adr']['status'][$scc]);
}

//set! auszufuehrende aktion!
$Form->new_Input($FormularName,$InputName_Set,"select", "");
$Form->set_InputJS($FormularName,$InputName_Set," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_Set,$set);
$Form->set_InputStyleClass($FormularName,$InputName_Set,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Set,___("Aktion"));
$Form->set_InputReadonly($FormularName,$InputName_Set,false);
$Form->set_InputOrder($FormularName,$InputName_Set,4);
$Form->set_InputLabel($FormularName,$InputName_Set,"");
$Form->set_InputSize($FormularName,$InputName_Set,0,1);
$Form->set_InputMultiple($FormularName,$InputName_Set,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_Set,"--","--");
$Form->add_InputOption($FormularName,$InputName_Set,"delete",___("komplett Löschen"));
$Form->add_InputOption($FormularName,$InputName_Set,"aktiv_1",___("aktivieren"));
$Form->add_InputOption($FormularName,$InputName_Set,"aktiv_0",___("deaktivieren"));
$Form->add_InputOption($FormularName,$InputName_Set,"set_status",___("Status setzen"));
$Form->add_InputOption($FormularName,$InputName_Set,"move_grp",___("In gewählte Gruppen verschieben"));
$Form->add_InputOption($FormularName,$InputName_Set,"copy_grp",___("Zu gewählten Gruppen hinzufügen"));
$Form->add_InputOption($FormularName,$InputName_Set,"delete_grp",___("Aus gewählten Gruppen austragen"));
$Form->add_InputOption($FormularName,$InputName_Set,"delete_history",___("Historie löschen"));

//blacklist
$Form->new_Input($FormularName,$InputName_Blacklist,"checkbox", 1);
$Form->set_InputJS($FormularName,$InputName_Blacklist," onChange=\"flash('submit','#ff0000');checkImport();\"\"");
$Form->set_InputDefault($FormularName,$InputName_Blacklist,$$InputName_Blacklist);
$Form->set_InputStyleClass($FormularName,$InputName_Blacklist,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Blacklist,48,256);
$Form->set_InputDesc($FormularName,$InputName_Blacklist,___("Importierte Adressen in die Blacklist eintragen"));
$Form->set_InputReadonly($FormularName,$InputName_Blacklist,false);
$Form->set_InputOrder($FormularName,$InputName_Blacklist,7);
$Form->set_InputLabel($FormularName,$InputName_Blacklist,"");
//submit button
$Form->new_Input($FormularName,$InputName_Submit,"submit",___("Aktion Ausführen"));
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

/*DISPLAY*/
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['head'];
//hidden fieldsnicht vergessen!
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['act']['html'];
$_MAIN_OUTPUT.= "<table border=0>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">".tm_icon("email.png",___("E-Mail"))."&nbsp;".___("E-Mail (leer = alle! ; wildcard = '*' oder '%'")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Name]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">".tm_icon("group.png",___("Gruppe"))."&nbsp;".___("aus der Gruppe:")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Group]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\" colspan=2>".tm_icon("lightbulb.png",___("Status"))."&nbsp;".___("mit dem Status:")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Status]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\" colspan=2>".tm_icon("exclamation.png",___("Aktion"))."&nbsp;".___("Aktion:")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Set]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">".tm_icon("lightbulb.png",___("Status"))."&nbsp;".___("neuer Status:")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_StatusDst]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\" colspan=1>".tm_icon("group.png",___("Gruppen"))."&nbsp;".___("gewählte Gruppen:")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_GroupDst]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\" colspan=1>".tm_icon("ruby.png",___("Blacklist"))."&nbsp;".___("Adressen zur Blacklist hinzufügen:")."";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Blacklist]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"bottom\" colspan=2 align=left>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Submit]['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Reset]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "</table>";
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['foot'];
?>