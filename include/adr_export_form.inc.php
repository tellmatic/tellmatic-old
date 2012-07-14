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
$FormularName="adr_import";
//make new Form
$Form->new_Form($FormularName,$_SERVER["PHP_SELF"],"post","_self");
$Form->set_FormJS($FormularName," onSubmit=\"switchSection('div_loader');\" ");
//add a Description
$Form->set_FormDesc($FormularName,___("Adressen in eine CSV-Datei exportieren"));
$Form->set_FormType($FormularName,"multipart/form-data");
$Form->new_Input($FormularName,"act", "hidden", $action);
$Form->new_Input($FormularName,"set", "hidden", "export");

//////////////////
//add inputfields and buttons....
//////////////////
//Gruppe
$Form->new_Input($FormularName,$InputName_Group,"select", "");
$Form->set_InputJS($FormularName,$InputName_Group," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_Group,$$InputName_Group);
$Form->set_InputStyleClass($FormularName,$InputName_Group,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Group,___("Gruppen wählen, STRG/CTRL gedrückt halten und klicken f. Mehrfachauswahl"));
$Form->set_InputReadonly($FormularName,$InputName_Group,false);
$Form->set_InputOrder($FormularName,$InputName_Group,6);
$Form->set_InputLabel($FormularName,$InputName_Group,"");
$Form->set_InputSize($FormularName,$InputName_Group,0,1);
$Form->set_InputMultiple($FormularName,$InputName_Group,false);
//add Data
$ADDRESS=new tm_ADR();
$GRP=$ADDRESS->getGroup(0,0,0,1);
$acg=count($GRP);
for ($accg=0; $accg<$acg; $accg++)
{
	$Form->add_InputOption($FormularName,$InputName_Group,$GRP[$accg]['id'],$GRP[$accg]['name']." (".$GRP[$accg]['adr_count'].")");
}

//Status
$Form->new_Input($FormularName,$InputName_Status,"select", "");
$Form->set_InputJS($FormularName,$InputName_Status," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_Status,$$InputName_Status);
$Form->set_InputStyleClass($FormularName,$InputName_Status,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Status,___("Nur Adressen mit diesem Status exportieren"));
$Form->set_InputReadonly($FormularName,$InputName_Status,false);
$Form->set_InputOrder($FormularName,$InputName_Status,2);
$Form->set_InputLabel($FormularName,$InputName_Status,"");
$Form->set_InputSize($FormularName,$InputName_Status,0,1);
$Form->set_InputMultiple($FormularName,$InputName_Status,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_Status,0,"Alle");
$sc=count($STATUS['adr']['status']);
for ($scc=1; $scc<=$sc; $scc++) {
	$Form->add_InputOption($FormularName,$InputName_Status,$scc,$STATUS['adr']['status'][$scc]." (".$STATUS['adr']['descr'][$scc].")");
}

//trennzeichen
$Form->new_Input($FormularName,$InputName_Delimiter,"select", "");
$Form->set_InputJS($FormularName,$InputName_Delimiter," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_Delimiter,$$InputName_Delimiter);
$Form->set_InputStyleClass($FormularName,$InputName_Delimiter,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Delimiter,___("Trennzeichen"));
$Form->set_InputReadonly($FormularName,$InputName_Delimiter,false);
$Form->set_InputOrder($FormularName,$InputName_Delimiter,3);
$Form->set_InputLabel($FormularName,$InputName_Delimiter,"");
$Form->set_InputSize($FormularName,$InputName_Delimiter,0,1);
$Form->set_InputMultiple($FormularName,$InputName_Delimiter,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_Delimiter,",",",");
$Form->add_InputOption($FormularName,$InputName_Delimiter,";",";");
$Form->add_InputOption($FormularName,$InputName_Delimiter,"|","|");

//Dateiname
$Form->new_Input($FormularName,$InputName_File,"text", $$InputName_File);
$Form->set_InputJS($FormularName,$InputName_File," onChange=\"flash('submit','#ff0000');\" onKeyUp=\"RemoveInvalidChars(this, '[^A-Za-z0-9\_\,\:\+\~\#\.\-]');\"");
$Form->set_InputStyleClass($FormularName,$InputName_File,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_File,32,256);
$Form->set_InputDesc($FormularName,$InputName_File,___("Dateiname"));
$Form->set_InputReadonly($FormularName,$InputName_File,false);
$Form->set_InputOrder($FormularName,$InputName_File,4);
$Form->set_InputLabel($FormularName,$InputName_File,"");

//offset
$Form->new_Input($FormularName,$InputName_Offset,"text", $$InputName_Offset);
$Form->set_InputJS($FormularName,$InputName_Offset," onChange=\"flash('submit','#ff0000');\" onKeyUp=\"RemoveInvalidChars(this, '[^0-9]');\"");
$Form->set_InputStyleClass($FormularName,$InputName_Offset,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Offset,20,10);
$Form->set_InputDesc($FormularName,$InputName_Offset,___("Offset: Anzahl der Datensätze die übersprungen werden sollen."));
$Form->set_InputReadonly($FormularName,$InputName_Offset,false);
$Form->set_InputOrder($FormularName,$InputName_Offset,4);
$Form->set_InputLabel($FormularName,$InputName_Offset,"");

//limit
$Form->new_Input($FormularName,$InputName_Limit,"text", $$InputName_Limit);
$Form->set_InputJS($FormularName,$InputName_Limit," onChange=\"flash('submit','#ff0000');\" onKeyUp=\"RemoveInvalidChars(this, '[^0-9]');\"");
$Form->set_InputStyleClass($FormularName,$InputName_Limit,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Limit,20,10);
$Form->set_InputDesc($FormularName,$InputName_Limit,___("Limit: Anzahl maximal zu exportierender Datensätze."));
$Form->set_InputReadonly($FormularName,$InputName_Limit,false);
$Form->set_InputOrder($FormularName,$InputName_Limit,4);
$Form->set_InputLabel($FormularName,$InputName_Limit,"");

//append to file
$Form->new_Input($FormularName,$InputName_Append,"checkbox", 1);
$Form->set_InputJS($FormularName,$InputName_Append," onChange=\"flash('submit','#ff0000');checkImport();\" onClick=\"checkImport();\"");
$Form->set_InputDefault($FormularName,$InputName_Append,0);
$Form->set_InputStyleClass($FormularName,$InputName_Append,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Append,48,256);
$Form->set_InputDesc($FormularName,$InputName_Append,___("An bestehende Datei anfügen"));
$Form->set_InputReadonly($FormularName,$InputName_Append,false);
$Form->set_InputOrder($FormularName,$InputName_Append,2);
$Form->set_InputLabel($FormularName,$InputName_Append,"");

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
gen_rec_files_array($tm_datapath);
//sort array by name:
foreach ($FileARRAY as $field) {
	$btsort[]=$field['filename'];
}
@array_multisort($btsort, SORT_ASC, $FileARRAY, SORT_ASC);
$ic= count($FileARRAY);
$Form->add_InputOption($FormularName,$InputName_FileExisting,"","--");
for ($icc=0; $icc < $ic; $icc++) {
	if ($FileARRAY[$icc]['filename'] !="/.htaccess") {
		$Form->add_InputOption($FormularName,$InputName_FileExisting,$FileARRAY[$icc]['filename'],$FileARRAY[$icc]['filename']);
	}
}

//submit button
$Form->new_Input($FormularName,$InputName_Submit,"submit","Adressen exportieren");
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
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['set']['html'];
$_MAIN_OUTPUT.= "<table>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("group.png",___("Gruppe"))."&nbsp;".___("Gruppe")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Group]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("lightbulb.png",___("Status"))."&nbsp;".___("Adressen mit folgendem Status").":<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Status]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= ___("Trennzeichen").":<br>";
$_MAIN_OUTPUT.= tm_icon("pilcrow.png",___("Trennzeichen"))."&nbsp;";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Delimiter]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= ___("Dateiname").":<br>";
$_MAIN_OUTPUT.= tm_icon("disk.png",___("Dateiname"))."&nbsp;";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_File]['html'].".csv";
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= ___("Dateiname").":<br>";
$_MAIN_OUTPUT.= tm_icon("disk_multiple.png",___("Dateiname"))."&nbsp;";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_FileExisting]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= ___("Anfügen").":<br>";
$_MAIN_OUTPUT.= tm_icon("bullet_add.png",___("Anfügen"))."&nbsp;";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Append]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= ___("Offset").":<br>";
$_MAIN_OUTPUT.= tm_icon("control_fastforward.png",___("Offset"))."&nbsp;";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Offset]['html'];
$_MAIN_OUTPUT.= " ".___("0= Anfang")."</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= ___("Limit").":<br>";
$_MAIN_OUTPUT.= tm_icon("control_end.png",___("Limit"))."&nbsp;";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Limit]['html'];
$_MAIN_OUTPUT.= "&nbsp;".___("0= Alle")."</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Submit]['html'];
//$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Reset]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "</table>";
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['foot'];
?>