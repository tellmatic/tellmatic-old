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
$FormularName="adr_import";
//make new Form
$Form->new_Form($FormularName,$_SERVER["PHP_SELF"],"post","_self");
$Form->set_FormJS($FormularName," onSubmit=\"switchSection('div_loader');\" ");
//add a Description
$Form->set_FormDesc($FormularName,___("Addressen aus CSV-Datei importieren"));
$Form->set_FormType($FormularName,"multipart/form-data");
//variable content aus menu als hidden field!
//$Form->new_Input($FormularName,"type", "hidden", $content);
$Form->new_Input($FormularName,"act", "hidden", $action);
$Form->new_Input($FormularName,"set", "hidden", "import");

//////////////////
//add inputfields and buttons....
//////////////////
//File 1, csv
$Form->new_Input($FormularName,$InputName_File,"file", "");
$Form->set_InputJS($FormularName,$InputName_File," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_File,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_File,48,256);
$Form->set_InputDesc($FormularName,$InputName_File,___("CSV-Datei hochladen und importieren"));
$Form->set_InputReadonly($FormularName,$InputName_File,false);
$Form->set_InputOrder($FormularName,$InputName_File,1);
$Form->set_InputLabel($FormularName,$InputName_File,"");

//Select existing file
$Form->new_Input($FormularName,$InputName_FileExisting,"select", "");
$Form->set_InputJS($FormularName,$InputName_FileExisting," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_FileExisting,"");
$Form->set_InputStyleClass($FormularName,$InputName_FileExisting,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_FileExisting,___("CSV-Datei auswählen"));
$Form->set_InputReadonly($FormularName,$InputName_FileExisting,false);
$Form->set_InputOrder($FormularName,$InputName_FileExisting,6);
$Form->set_InputLabel($FormularName,$InputName_FileExisting,"");
$Form->set_InputSize($FormularName,$InputName_FileExisting,0,1);
$Form->set_InputMultiple($FormularName,$InputName_FileExisting,false);
//add Data
unset($FileARRAY);
gen_rec_files_array($mnl_datapath);
//sort array by name:
foreach ($FileARRAY as $field) {  
	$btsort[]=$field['filename'];
}
@array_multisort($btsort, SORT_ASC, $FileARRAY, SORT_ASC);
$ic= count($FileARRAY);
$Form->add_InputOption($FormularName,$InputName_FileExisting,"","--");
for ($icc=0; $icc < $ic; $icc++) {
	$Form->add_InputOption($FormularName,$InputName_FileExisting,$FileARRAY[$icc]['filename'],$FileARRAY[$icc]['filename']);
}

//Bulk
$Form->new_Input($FormularName,$InputName_Bulk,"textarea", $$InputName_Bulk);
$Form->set_InputDefault($FormularName,$InputName_Bulk,$$InputName_Bulk);
$Form->set_InputStyleClass($FormularName,$InputName_Bulk,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Bulk,80,5);
$Form->set_InputDesc($FormularName,$InputName_Bulk,"");
$Form->set_InputReadonly($FormularName,$InputName_Bulk,false);
$Form->set_InputOrder($FormularName,$InputName_Bulk,1);
$Form->set_InputLabel($FormularName,$InputName_Bulk,"");

//Gruppe
$Form->new_Input($FormularName,$InputName_Group,"select", "");
$Form->set_InputJS($FormularName,$InputName_Group," onChange=\"flash('submit','#ff0000');\" ");
//$Form->set_InputDefault($FormularName,$InputName_Group,$adr_grp);
$Form->set_InputStyleClass($FormularName,$InputName_Group,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Group,___("Gruppen waehlen, STRG/CTRL gedrueckt halten und klicken f. Mehrfachauswahl"));
$Form->set_InputReadonly($FormularName,$InputName_Group,false);
$Form->set_InputOrder($FormularName,$InputName_Group,6);
$Form->set_InputLabel($FormularName,$InputName_Group,"");
//$Form->set_InputValue($FormularName,$InputName_Group,"");
$Form->set_InputSize($FormularName,$InputName_Group,0,8);
$Form->set_InputMultiple($FormularName,$InputName_Group,true);
//add Data
$ADDRESS=new mnlADR();
$GRP=$ADDRESS->getGroup();
$acg=count($GRP);
for ($accg=0; $accg<$acg; $accg++)
{
	$Form->add_InputOption($FormularName,$InputName_Group,$GRP[$accg]['id'],$GRP[$accg]['name']);
}

//merge groups?
$Form->new_Input($FormularName,$InputName_GroupsMerge,"checkbox", 1);
#$Form->set_InputJS($FormularName,$InputName_Delete," onChange=\"flash('submit','#ff0000');\" onClick=\"del=1; document.form.".$InputName_AktivEx."; document.form.".$InputName_AktivNew."; document.form.".$InputName_StatusEx."; document.form.".$InputName_Group."; \"");
$Form->set_InputJS($FormularName,$InputName_GroupsMerge," onChange=\"flash('submit','#ff0000');\"");
#onFocus="if (!activ)this.blur();" onChange="if (!activ)this.blur();"
#http://www.javarea.de/index.php3?opencat=Javascript&subcat=Formulare-Button&id=266
$Form->set_InputDefault($FormularName,$InputName_GroupsMerge,1);
$Form->set_InputStyleClass($FormularName,$InputName_GroupsMerge,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_GroupsMerge,48,256);
$Form->set_InputDesc($FormularName,$InputName_GroupsMerge,___("Gruppen hinzufügen"));
$Form->set_InputReadonly($FormularName,$InputName_GroupsMerge,false);
$Form->set_InputOrder($FormularName,$InputName_GroupsMerge,2);
$Form->set_InputLabel($FormularName,$InputName_GroupsMerge,"");
//Status
$Form->new_Input($FormularName,$InputName_Status,"select", "");
$Form->set_InputJS($FormularName,$InputName_Status," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_Status,1);
$Form->set_InputStyleClass($FormularName,$InputName_Status,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Status,___("Adress-Status f. neue Adressen"));
$Form->set_InputReadonly($FormularName,$InputName_Status,false);
$Form->set_InputOrder($FormularName,$InputName_Status,6);
$Form->set_InputLabel($FormularName,$InputName_Status,"");
$Form->set_InputSize($FormularName,$InputName_Status,0,1);
$Form->set_InputMultiple($FormularName,$InputName_Status,false);
//add Data
$sc=count($STATUS['adr']['status']);
for ($scc=1; $scc<=$sc; $scc++) {
	$Form->add_InputOption($FormularName,$InputName_Status,$scc,$STATUS['adr']['status'][$scc]." (".$STATUS['adr']['descr'][$scc].")");
}

//StatusEx
$Form->new_Input($FormularName,$InputName_StatusEx,"select", "");
$Form->set_InputJS($FormularName,$InputName_StatusEx," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_StatusEx,0);
$Form->set_InputStyleClass($FormularName,$InputName_StatusEx,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_StatusEx,___("Adress-Status f. existierende Adressen"));
$Form->set_InputReadonly($FormularName,$InputName_StatusEx,false);
$Form->set_InputOrder($FormularName,$InputName_StatusEx,6);
$Form->set_InputLabel($FormularName,$InputName_StatusEx,"");
$Form->set_InputSize($FormularName,$InputName_StatusEx,0,1);
$Form->set_InputMultiple($FormularName,$InputName_StatusEx,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_StatusEx,0,___("Keine Aenderungen"));
$sc=count($STATUS['adr']['status']);
for ($scc=1; $scc<=$sc; $scc++) {
	$Form->add_InputOption($FormularName,$InputName_StatusEx,$scc,$STATUS['adr']['status'][$scc]." (".$STATUS['adr']['descr'][$scc].")");
}

//aktiv neue adr
$Form->new_Input($FormularName,$InputName_AktivNew,"select", "");
$Form->set_InputJS($FormularName,$InputName_AktivNew," onChange=\"flash('submit','#ff0000');\" ");

$Form->set_InputDefault($FormularName,$InputName_AktivNew,1);
$Form->set_InputStyleClass($FormularName,$InputName_AktivNew,"mFormSelect","mFormSelectFocus");

$Form->set_InputDesc($FormularName,$InputName_AktivNew,___("Neue Adressen de-/aktivieren"));
$Form->set_InputReadonly($FormularName,$InputName_AktivNew,false);
$Form->set_InputOrder($FormularName,$InputName_AktivNew,6);
$Form->set_InputLabel($FormularName,$InputName_AktivNew,"");
$Form->set_InputSize($FormularName,$InputName_AktivNew,0,1);
$Form->set_InputMultiple($FormularName,$InputName_AktivNew,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_AktivNew,1,___("Aktiv"));
$Form->add_InputOption($FormularName,$InputName_AktivNew,0,___("De-Aktiviert"));

//aktiv existierende adr
$Form->new_Input($FormularName,$InputName_AktivEx,"select", "");
#$Form->set_InputJS($FormularName,$InputName_AktivEx," onChange=\"flash('submit','#ff0000');if (del)this.blur();\" onFocus=\"if (del)this.blur();\"");
$Form->set_InputJS($FormularName,$InputName_AktivEx," onChange=\"flash('submit','#ff0000');\"");
$Form->set_InputDefault($FormularName,$InputName_AktivEx,-1);
$Form->set_InputStyleClass($FormularName,$InputName_AktivEx,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_AktivEx,___("Existierende Adressen bei Update de-/aktivieren"));
$Form->set_InputReadonly($FormularName,$InputName_AktivEx,false);
$Form->set_InputOrder($FormularName,$InputName_AktivEx,6);
$Form->set_InputLabel($FormularName,$InputName_AktivEx,"");
$Form->set_InputSize($FormularName,$InputName_AktivEx,0,1);
$Form->set_InputMultiple($FormularName,$InputName_AktivEx,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_AktivEx,-1,___("keine Änderung"));
$Form->add_InputOption($FormularName,$InputName_AktivEx,1,___("Aktiv"));
$Form->add_InputOption($FormularName,$InputName_AktivEx,0,___("De-Aktiviert"));

//trennzeichen
$Form->new_Input($FormularName,$InputName_Delimiter,"select", "");
$Form->set_InputJS($FormularName,$InputName_Delimiter," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_Delimiter,$$InputName_Delimiter);
$Form->set_InputStyleClass($FormularName,$InputName_Delimiter,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Delimiter,___("Trennzeichen"));
$Form->set_InputReadonly($FormularName,$InputName_Delimiter,false);
$Form->set_InputOrder($FormularName,$InputName_Delimiter,6);
$Form->set_InputLabel($FormularName,$InputName_Delimiter,"");
$Form->set_InputSize($FormularName,$InputName_Delimiter,0,1);
$Form->set_InputMultiple($FormularName,$InputName_Delimiter,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_Delimiter,",",",");
$Form->add_InputOption($FormularName,$InputName_Delimiter,";",";");
$Form->add_InputOption($FormularName,$InputName_Delimiter,"|","|");

//delete
$Form->new_Input($FormularName,$InputName_Delete,"checkbox", 1);
#$Form->set_InputJS($FormularName,$InputName_Delete," onChange=\"flash('submit','#ff0000');\" onClick=\"del=1; document.form.".$InputName_AktivEx."; document.form.".$InputName_AktivNew."; document.form.".$InputName_StatusEx."; document.form.".$InputName_Group."; \"");
$Form->set_InputJS($FormularName,$InputName_Delete," onChange=\"flash('submit','#ff0000');checkImport();\" onClick=\"checkImport();\"");
#onFocus="if (!activ)this.blur();" onChange="if (!activ)this.blur();"
#http://www.javarea.de/index.php3?opencat=Javascript&subcat=Formulare-Button&id=266
$Form->set_InputDefault($FormularName,$InputName_Delete,0);
$Form->set_InputStyleClass($FormularName,$InputName_Delete,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Delete,48,256);
$Form->set_InputDesc($FormularName,$InputName_Delete,___("Importierte Adressen löschen"));
$Form->set_InputReadonly($FormularName,$InputName_Delete,false);
$Form->set_InputOrder($FormularName,$InputName_Delete,2);
$Form->set_InputLabel($FormularName,$InputName_Delete,"");



//emailcheck...
$Form->new_Input($FormularName,$InputName_ECheckImport,"select", "");
$Form->set_InputJS($FormularName,$InputName_ECheckImport," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_ECheckImport,$EMailcheck_Intern);
$Form->set_InputStyleClass($FormularName,$InputName_ECheckImport,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_ECheckImport,"");
$Form->set_InputReadonly($FormularName,$InputName_ECheckImport,false);
$Form->set_InputOrder($FormularName,$InputName_ECheckImport,6);
$Form->set_InputLabel($FormularName,$InputName_ECheckImport,"");
$Form->set_InputSize($FormularName,$InputName_ECheckImport,0,1);
$Form->set_InputMultiple($FormularName,$InputName_ECheckImport,false);
//add Data
$sc=count($EMAILCHECK['intern']);
for ($scc=0; $scc<$sc; $scc++)//0
{
	$Form->add_InputOption($FormularName,$InputName_ECheckImport,$scc,$EMAILCHECK['intern'][$scc]);
}


//submit button 
$Form->new_Input($FormularName,$InputName_Submit,"submit",___("Adressen Importieren"));
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
$_MAIN_OUTPUT.= "<table>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top rowspan=\"10\" style=\"border-right:1px solid grey\"><img src=\"".$mnl_iconURL."/group.png\" border=\"0\">&nbsp;".___("Gruppen:")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Group]['html'];
$_MAIN_OUTPUT.= "</td>";


$_MAIN_OUTPUT.= "<td valign=top><img src=\"".$mnl_iconURL."/page_white_gear.png\" border=\"0\">&nbsp;".___("CSV-Upload:")."";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_File]['html'];
$_MAIN_OUTPUT.= "&nbsp;&nbsp;<img src=\"".$mnl_iconURL."/disk.png\" border=\"0\">&nbsp;".$Form->INPUT[$FormularName][$InputName_FileExisting]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td style=\"border-top:1px dashed grey\" valign=\"top\"><img src=\"".$mnl_iconURL."/keyboard.png\" border=\"0\">&nbsp;".___("Eine E-Mail-Adresse pro Zeile:")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Bulk]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td style=\"border-top:2px solid grey\" valign=\"top\">";
$_MAIN_OUTPUT.= ___("Status f. neue Adressen:")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Status]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>".___("Neue Adressen (De-)Aktivieren:")."";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_AktivNew]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td style=\"border-top:1px dashed grey\" valign=\"top\">";
$_MAIN_OUTPUT.= ___("Status bei Update:")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_StatusEx]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>".___("Existierende Adressen bei Update (De-)Aktivieren:")."";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_AktivEx]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td style=\"border-top:1px dashed grey\" valign=\"top\">";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/group_add.png\" border=\"0\">&nbsp;".___("Gruppen zusammenführen:")."";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_GroupsMerge]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";


$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td style=\"border-top:2px solid grey\" valign=\"top\">";
$_MAIN_OUTPUT.= "<img src=\"".$mnl_iconURL."/cross.png\" border=\"0\">&nbsp;<font color=\"#ff0000\">".___("Importierte Adressen löschen")."</font>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Delete]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td style=\"border-top:2px solid grey\" valign=\"top\">";
$_MAIN_OUTPUT.= ___("Trennzeichen:")."";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Delimiter]['html'];
$_MAIN_OUTPUT.= "&nbsp;";
$_MAIN_OUTPUT.= ___("Prüfung der E-Mail:")."";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_ECheckImport]['html'];

$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\" align=\"right\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Submit]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "</table>";
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['foot'];
?>