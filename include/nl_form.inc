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
$FormularName="nl_new";
//make new Form
$Form->new_Form($FormularName,$_SERVER["PHP_SELF"],"post","_self");
//$this->set_FormStyle($FormularName,"font-size:10pt;font-color=red;");
////$Form->set_FormStyleClass($FormularName,"mForm");
////$Form->set_FormInputStyleClass($FormularName,"mFormText","mFormTextFocus");
$Form->set_FormJS($FormularName," onSubmit=\"switchSection('div_loader');\" ");
//add a Description
$Form->set_FormDesc($FormularName,___("Neue Newslettergruppe erstellen"));
$Form->set_FormType($FormularName,"multipart/form-data");
//variable content aus menu als hidden field!
//$Form->new_Input($FormularName,"type", "hidden", $content);
$Form->new_Input($FormularName,"act", "hidden", $action);
$Form->new_Input($FormularName,"set", "hidden", "save");
$Form->new_Input($FormularName,"nl_id", "hidden", $nl_id);
//////////////////
//add inputfields and buttons....
//////////////////
//File 1, html
$Form->new_Input($FormularName,$InputName_File,"file", "");
$Form->set_InputStyleClass($FormularName,$InputName_File,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_File,48,48);
$Form->set_InputDesc($FormularName,$InputName_File,___("HTML-Vorlage hochladen"));
$Form->set_InputReadonly($FormularName,$InputName_File,false);
$Form->set_InputOrder($FormularName,$InputName_File,1);
$Form->set_InputLabel($FormularName,$InputName_File,"");
//File 2, image
$Form->new_Input($FormularName,$InputName_Image1,"file", "");
$Form->set_InputStyleClass($FormularName,$InputName_Image1,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Image1,48,48);
$Form->set_InputDesc($FormularName,$InputName_Image1,___("Bild hochladen")." {IMAGE1}");
$Form->set_InputReadonly($FormularName,$InputName_Image1,false);
$Form->set_InputOrder($FormularName,$InputName_Image1,1);
$Form->set_InputLabel($FormularName,$InputName_Image1,"");
//File 3, Attachement
$Form->new_Input($FormularName,$InputName_Attach1,"file", "");
$Form->set_InputStyleClass($FormularName,$InputName_Attach1,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Attach1,48,48);
$Form->set_InputDesc($FormularName,$InputName_Attach1,___("Anhang hochladen")." {ATTACH1}");
$Form->set_InputReadonly($FormularName,$InputName_Attach1,false);
$Form->set_InputOrder($FormularName,$InputName_Attach1,1);
$Form->set_InputLabel($FormularName,$InputName_Attach1,"");



//Subject
$Form->new_Input($FormularName,$InputName_Name,"text", $$InputName_Name);
$Form->set_InputStyleClass($FormularName,$InputName_Name,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Name,48,48);
$Form->set_InputDesc($FormularName,$InputName_Name,___("Erscheint als Betreff in der e-Mail"));
$Form->set_InputReadonly($FormularName,$InputName_Name,false);
$Form->set_InputOrder($FormularName,$InputName_Name,1);
$Form->set_InputLabel($FormularName,$InputName_Name,"");

//Link
$Form->new_Input($FormularName,$InputName_Link,"text", $$InputName_Link);
$Form->set_InputStyleClass($FormularName,$InputName_Link,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Link,48,48);
$Form->set_InputDesc($FormularName,$InputName_Link,___("Link")." {LINK1}");
$Form->set_InputReadonly($FormularName,$InputName_Link,false);
$Form->set_InputOrder($FormularName,$InputName_Link,1);
$Form->set_InputLabel($FormularName,$InputName_Link,"");

//Aktiv
	$Form->new_Input($FormularName,$InputName_Aktiv,"checkbox", 1);
	$Form->set_InputDefault($FormularName,$InputName_Aktiv,$$InputName_Aktiv);
	$Form->set_InputStyleClass($FormularName,$InputName_Aktiv,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_Aktiv,48,48);
	$Form->set_InputDesc($FormularName,$InputName_Aktiv,___("Aktiv"));
	$Form->set_InputReadonly($FormularName,$InputName_Aktiv,false);
	$Form->set_InputOrder($FormularName,$InputName_Aktiv,2);
	$Form->set_InputLabel($FormularName,$InputName_Aktiv,"");

//Massenmail!?
	$Form->new_Input($FormularName,$InputName_Massmail,"checkbox", 1);
	$Form->set_InputDefault($FormularName,$InputName_Massmail,$$InputName_Massmail);
	$Form->set_InputStyleClass($FormularName,$InputName_Massmail,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_Massmail,48,48);
	$Form->set_InputDesc($FormularName,$InputName_Massmail,___("Massenmailing (BCC)"));
	$Form->set_InputReadonly($FormularName,$InputName_Massmail,false);
	$Form->set_InputOrder($FormularName,$InputName_Massmail,2);
	$Form->set_InputLabel($FormularName,$InputName_Massmail,"");

//Content
$Form->new_Input($FormularName,$InputName_Descr,"textarea", $$InputName_Descr);
$Form->set_InputStyleClass($FormularName,$InputName_Descr,"mFormTextarea_Content","mFormTextareaFocus_Content");
$Form->set_InputSize($FormularName,$InputName_Descr,180,50);
$Form->set_InputDesc($FormularName,$InputName_Descr,___("Newsletter-Text"));
$Form->set_InputReadonly($FormularName,$InputName_Descr,false);
$Form->set_InputOrder($FormularName,$InputName_Descr,3);
$Form->set_InputLabel($FormularName,$InputName_Descr,"");

//Gruppe
$Form->new_Input($FormularName,$InputName_Group,"select", "");
$Form->set_InputDefault($FormularName,$InputName_Group,$nl_grp_id);
$Form->set_InputStyleClass($FormularName,$InputName_Group,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Group,___("Newsletter-Gruppe waehlen"));
$Form->set_InputReadonly($FormularName,$InputName_Group,false);
$Form->set_InputOrder($FormularName,$InputName_Group,6);
$Form->set_InputLabel($FormularName,$InputName_Group,"");
//$Form->set_InputValue($FormularName,$InputName_Group,"");
$Form->set_InputSize($FormularName,$InputName_Group,0,1);
$Form->set_InputMultiple($FormularName,$InputName_Group,false);
//add Data
$NEWSLETTER=new mnlNL();
$GRP=$NEWSLETTER->getGroup();
$acg=count($GRP);
for ($accg=0; $accg<$acg; $accg++)
{
	$Form->add_InputOption($FormularName,$InputName_Group,$GRP[$accg]['id'],$GRP[$accg]['name']);
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
//then you dont have to render the head and foot .....

/*DISPLAY*/
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['head'];
//hidden fieldsnicht vergessen!
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['act']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['set']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['nl_id']['html'];
$_MAIN_OUTPUT.= "<table>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= ___("Betreff");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Name]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= ___("Aktiv");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Aktiv]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= ___("Massenmailing (BCC)");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Massmail]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= ___("Gruppe");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Group]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= ___("Link");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Link]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= ___("Bild");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Image1]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= ___("HTML");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_File]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= ___("Anhang");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Attach1]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top colspan=2>";
$_MAIN_OUTPUT.= ___("Text")."&nbsp;&nbsp;&nbsp;";
$_MAIN_OUTPUT.= "(<a href=\"javascript:toggleEditor('".$InputName_Descr."')\">";
$_MAIN_OUTPUT.= ___("Editor Ein/Aus");
$_MAIN_OUTPUT.= "&nbsp;<img src=\"".$mnl_iconURL."/wand.png\" border=\"0\" title=\"".___("Editor Ein/Aus")."\" alt=\"".___("Editor Ein/Aus")."\"></a>)<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Descr]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top colspan=2>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Submit]['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Reset]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "</table>";
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['foot'];
$_MAIN_OUTPUT.= sprintf(___("%s enth&auml;lt das hochgeladene Bild 'img src' | %s enth&auml;lt nur die URL zum Bild"),"<b>{IMAGE1}</b>","<b>{IMAGE1_URL}</b>")."<br>".
						sprintf(___("%s enth&auml;lt den angegebenen Link 'a href' | %s enth&auml;lt nur die URL des Links"),"<b>{LINK1}</b>","<b>{LINK1_URL}</b>")."<br>".
						sprintf(___("%s enth&auml;lt den Link zum Attachement 'a href' |  %s enth&auml;lt nur die URL zum Attachement"),"<b>{ATTACH1}</b>","<b>{ATTACH1_URL}</b>")."<br>".
						sprintf(___("%s enth&auml;lt den Link zum abmelden |   %s enth&auml;lt nur die URL zum Abmeldeformular"),"<b>{UNSUBSCRIBE}</b>","<b>{UNSUBSCRIBE_URL}</b>")."<br>".
						sprintf(___("%s enth&auml;lt den Link zur Onlineversion 'a href' |  %s enth&auml;lt nur die URL zur Onlineversion"),"<b>{NLONLINE}</b>","<b>{NLONLINE_URL}</b>")."<br>".
						sprintf(___("%s enth&auml;lt das schliessende TAG '/a' fuer die Links"),"<b>{CLOSELINK}</b>")."<br>".
						"<u>".___("Nur f&uuml; personalisierten Newsleter:")."</u><br>".
						sprintf(___("%s enth&auml;lt ein 1x1 Pixel grosses transparentes PNG-Bild (f&uuml;r View-Tracking, nur HTML-Mails)"),"<b>{BLINDIMAGE}</b>")."<br>".
						sprintf(___("%s enth&auml;lt die e-Mailadresse des Empfaengers"),"<b>{EMAIL}</b>")."<br>".
						sprintf(___("%s bis %s enth&auml;lt die Felder aus den Formularen/Adressen"),"<b>{F0}</b>","<b>{F9}</b>")."<br>".
						sprintf(___("%s enth&auml;lt den kompletten Link 'a href' zum Aktivierungslink ('(1st)-Touch-Opt-In) | %s enth&auml;lt nur die URL"),"<b>{SUBSCRIBE}</b>","<b>{SUBSCRIBE_URL}</b>")."<br>".
						"";

include_once ($mnl_includepath."/wysiwyg.inc");
?>