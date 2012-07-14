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
$_MAIN_OUTPUT.="\n\n<!-- bl_list_form.inc.php -->\n\n";

$InputName_Submit="submit_bl";
$InputName_Reset="reset";

//Form
$Form=new tm_SimpleForm();
$FormularName="bl_list_filter";
//make new Form
$Form->new_Form($FormularName,$_SERVER["PHP_SELF"],"post","_self");

#$Form->set_FormJS($FormularName," onSubmit=\"return confirmLink(this, '".___("Wirklich?")."');switchSection('div_loader');\" ");
#$Form->set_FormJS($FormularName," onChange=\"this->submit();switchSection('div_loader');\" ");

//add a Description
$Form->set_FormDesc($FormularName,___("Blacklist nach Typ filtern"));

$Form->new_Input($FormularName,"act", "hidden", $action);
//hidden felder f. sortierung, search, gruppe etc.....

//////////////////
//add inputfields and buttons....
//////////////////
//Typ
$Form->new_Input($FormularName,$InputName_Type,"select", "");
$Form->set_InputJS($FormularName,$InputName_Type," onChange=\"flash('submit_bl','#ff0000');submit();switchSection('div_loader');\" ");

$Form->set_InputDefault($FormularName,$InputName_Type,$$InputName_Type);
$Form->set_InputStyleClass($FormularName,$InputName_Type,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Type,___("Blacklist Typ wählen"));
$Form->set_InputReadonly($FormularName,$InputName_Type,false);
$Form->set_InputOrder($FormularName,$InputName_Type,1);
$Form->set_InputLabel($FormularName,$InputName_Type,___("Blacklist Typ").":");
$Form->set_InputSize($FormularName,$InputName_Type,0,1);
$Form->set_InputMultiple($FormularName,$InputName_Type,false);
$Form->add_InputOption($FormularName,$InputName_Type,"email",___("E-Mail")." (".$BLACKLIST->countBL(Array("type"=>"email")).")");
$Form->add_InputOption($FormularName,$InputName_Type,"domain",___("Domain")." (".$BLACKLIST->countBL(Array("type"=>"domain")).")");
$Form->add_InputOption($FormularName,$InputName_Type,"expr",___("reg. Ausdruck")." (".$BLACKLIST->countBL(Array("type"=>"expr")).")");

//submit button
$Form->new_Input($FormularName,$InputName_Submit,"submit",___("Aktion ausführen"));
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

$_MAIN_OUTPUT.= "<table border=0 width=\"100%\">";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\" colspan=1>";
$_MAIN_OUTPUT.=  tm_icon("ruby_gear.png",___("Typ"))."&nbsp;".$Form->INPUT[$FormularName][$InputName_Type]['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Submit]['html'];
$_MAIN_OUTPUT.= "</td>";
//export blacklist
$_MAIN_OUTPUT.= "<td valign=\"top\" colspan=1 align=\"right\">";
if ($type=="email") { $bl_typename=tm_icon("ruby_key.png",$type)."&nbsp;".___("E-Mail");}
if ($type=="domain") { $bl_typename=tm_icon("ruby_link.png",$type)."&nbsp;".___("Domain");}
if ($type=="expr") { $bl_typename=tm_icon("ruby_gear.png",$type)."&nbsp;".___("regulärer Ausdruck");}
$_MAIN_OUTPUT.="<a href=\"".$tm_URL."/".$exportURLPara_."\">".tm_icon("disk.png",___("Blacklist exportieren"))."&nbsp;".sprintf(___("Blacklist vom Typ %s exportieren"),"'".$bl_typename."'")."</a><br>";
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "</table>";
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['foot'];
?>