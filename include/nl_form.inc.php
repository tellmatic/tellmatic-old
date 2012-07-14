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
$FormularName="nl_new";
//make new Form
$Form->new_Form($FormularName,$_SERVER["PHP_SELF"],"post","_self");
$Form->set_FormJS($FormularName," onSubmit=\"switchSection('div_loader');\" ");
//add a Description
$Form->set_FormDesc($FormularName,___("Neue Newslettergruppe erstellen"));
$Form->set_FormType($FormularName,"multipart/form-data");
$Form->new_Input($FormularName,"act", "hidden", $action);
$Form->new_Input($FormularName,"set", "hidden", "save");
$Form->new_Input($FormularName,"nl_id", "hidden", $nl_id);
//////////////////
//add inputfields and buttons....
//////////////////
//File 1, html
$Form->new_Input($FormularName,$InputName_File,"file", "");
$Form->set_InputJS($FormularName,$InputName_File," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_File,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_File,48,48);
$Form->set_InputDesc($FormularName,$InputName_File,___("HTML-Vorlage hochladen"));
$Form->set_InputReadonly($FormularName,$InputName_File,false);
$Form->set_InputOrder($FormularName,$InputName_File,1);
$Form->set_InputLabel($FormularName,$InputName_File,"");
//File 2, image
$Form->new_Input($FormularName,$InputName_Image1,"file", "");
$Form->set_InputJS($FormularName,$InputName_Image1," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Image1,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Image1,48,48);
$Form->set_InputDesc($FormularName,$InputName_Image1,___("Bild hochladen")." {IMAGE1}");
$Form->set_InputReadonly($FormularName,$InputName_Image1,false);
$Form->set_InputOrder($FormularName,$InputName_Image1,1);
$Form->set_InputLabel($FormularName,$InputName_Image1,"");
//File 3, Attachement
$Form->new_Input($FormularName,$InputName_Attach1,"file", "");
$Form->set_InputJS($FormularName,$InputName_Attach1," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Attach1,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Attach1,48,48);
$Form->set_InputDesc($FormularName,$InputName_Attach1,___("Anhang hochladen")." {ATTACH1}");
$Form->set_InputReadonly($FormularName,$InputName_Attach1,false);
$Form->set_InputOrder($FormularName,$InputName_Attach1,1);
$Form->set_InputLabel($FormularName,$InputName_Attach1,"");

//Subject
$Form->new_Input($FormularName,$InputName_Name,"text", $$InputName_Name);
$Form->set_InputJS($FormularName,$InputName_Name," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Name,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Name,48,255);
$Form->set_InputDesc($FormularName,$InputName_Name,___("Erscheint als Betreff in der e-Mail"));
$Form->set_InputReadonly($FormularName,$InputName_Name,false);
$Form->set_InputOrder($FormularName,$InputName_Name,1);
$Form->set_InputLabel($FormularName,$InputName_Name,"");

//Link
$Form->new_Input($FormularName,$InputName_Link,"text", $$InputName_Link);
$Form->set_InputJS($FormularName,$InputName_Link," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Link,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Link,48,1024);
$Form->set_InputDesc($FormularName,$InputName_Link,___("Link")." {LINK1}");
$Form->set_InputReadonly($FormularName,$InputName_Link,false);
$Form->set_InputOrder($FormularName,$InputName_Link,1);
$Form->set_InputLabel($FormularName,$InputName_Link,"");

//Aktiv
	$Form->new_Input($FormularName,$InputName_Aktiv,"checkbox", 1);
	$Form->set_InputJS($FormularName,$InputName_Aktiv," onChange=\"flash('submit','#ff0000');\" ");
	$Form->set_InputDefault($FormularName,$InputName_Aktiv,$$InputName_Aktiv);
	$Form->set_InputStyleClass($FormularName,$InputName_Aktiv,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_Aktiv,48,48);
	$Form->set_InputDesc($FormularName,$InputName_Aktiv,___("Aktiv"));
	$Form->set_InputReadonly($FormularName,$InputName_Aktiv,false);
	$Form->set_InputOrder($FormularName,$InputName_Aktiv,2);
	$Form->set_InputLabel($FormularName,$InputName_Aktiv,"");

//Massenmail!?
	$Form->new_Input($FormularName,$InputName_Massmail,"checkbox", 1);
	$Form->set_InputJS($FormularName,$InputName_Massmail," onChange=\"flash('submit','#ff0000');\" ");
	$Form->set_InputDefault($FormularName,$InputName_Massmail,$$InputName_Massmail);
	$Form->set_InputStyleClass($FormularName,$InputName_Massmail,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_Massmail,48,48);
	$Form->set_InputDesc($FormularName,$InputName_Massmail,___("Massenmailing (BCC)"));
	$Form->set_InputReadonly($FormularName,$InputName_Massmail,false);
	$Form->set_InputOrder($FormularName,$InputName_Massmail,2);
	$Form->set_InputLabel($FormularName,$InputName_Massmail,"");

//Content
$Form->new_Input($FormularName,$InputName_Descr,"textarea", $$InputName_Descr);
$Form->set_InputJS($FormularName,$InputName_Descr," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Descr,"mFormTextarea_Content","mFormTextareaFocus_Content");
$Form->set_InputSize($FormularName,$InputName_Descr,180,50);
$Form->set_InputDesc($FormularName,$InputName_Descr,___("Newsletter-Text"));
$Form->set_InputReadonly($FormularName,$InputName_Descr,false);
$Form->set_InputOrder($FormularName,$InputName_Descr,3);
$Form->set_InputLabel($FormularName,$InputName_Descr,"");

//Gruppe
$Form->new_Input($FormularName,$InputName_Group,"select", "");
$Form->set_InputJS($FormularName,$InputName_Group," onChange=\"flash('submit','#ff0000');\" ");
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
$NEWSLETTER=new tm_NL();
$GRP=$NEWSLETTER->getGroup();
$acg=count($GRP);
for ($accg=0; $accg<$acg; $accg++)
{
	$Form->add_InputOption($FormularName,$InputName_Group,$GRP[$accg]['id'],$GRP[$accg]['name']);
}

//Select existing Trackimage
$Form->new_Input($FormularName,$InputName_TrackImageExisting,"select", "");
$Form->set_InputJS($FormularName,$InputName_TrackImageExisting," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_TrackImageExisting,$$InputName_TrackImageExisting);
$Form->set_InputStyleClass($FormularName,$InputName_TrackImageExisting,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_TrackImageExisting,___("Blind-/Tracking-Bild auswählen"));
$Form->set_InputReadonly($FormularName,$InputName_TrackImageExisting,false);
$Form->set_InputOrder($FormularName,$InputName_TrackImageExisting,6);
$Form->set_InputLabel($FormularName,$InputName_TrackImageExisting,"");
$Form->set_InputSize($FormularName,$InputName_TrackImageExisting,0,1);
$Form->set_InputMultiple($FormularName,$InputName_TrackImageExisting,false);
//add Data
unset($FileARRAY);
gen_rec_files_array($tm_nlimgpath);
//sort array by name:
foreach ($FileARRAY as $field) {
	$btsort[]=$field['filename'];
}
@array_multisort($btsort, SORT_ASC, $FileARRAY, SORT_ASC);
$ic= count($FileARRAY);
$Form->add_InputOption($FormularName,$InputName_TrackImageExisting,"_global","-- GLOBAL --");
$Form->add_InputOption($FormularName,$InputName_TrackImageExisting,"_blank","-- BLANK --");
for ($icc=0; $icc < $ic; $icc++) {
	$Form->add_InputOption($FormularName,$InputName_TrackImageExisting,$FileARRAY[$icc]['filename'],$FileARRAY[$icc]['filename']);
}

//upload new trackingimage
$Form->new_Input($FormularName,$InputName_TrackImageNew,"file", "");
$Form->set_InputJS($FormularName,$InputName_TrackImageNew," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_TrackImageNew,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_TrackImageNew,48,48);
$Form->set_InputDesc($FormularName,$InputName_TrackImageNew,___("neues Bild hochladen")." {IMAGE1}");
$Form->set_InputReadonly($FormularName,$InputName_TrackImageNew,false);
$Form->set_InputOrder($FormularName,$InputName_TrackImageNew,1);
$Form->set_InputLabel($FormularName,$InputName_TrackImageNew,"");


//Content_Type
$Form->new_Input($FormularName,$InputName_ContentType,"select", "");
$Form->set_InputJS($FormularName,$InputName_ContentType," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_ContentType,$$InputName_ContentType);
$Form->set_InputStyleClass($FormularName,$InputName_ContentType,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_ContentType,___("Format"));
$Form->set_InputReadonly($FormularName,$InputName_ContentType,false);
$Form->set_InputOrder($FormularName,$InputName_ContentType,6);
$Form->set_InputLabel($FormularName,$InputName_ContentType,"");
$Form->set_InputSize($FormularName,$InputName_ContentType,0,1);
$Form->set_InputMultiple($FormularName,$InputName_ContentType,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_ContentType,"text/html","TEXT/HTML");
$Form->add_InputOption($FormularName,$InputName_ContentType,"html","HTML");
$Form->add_InputOption($FormularName,$InputName_ContentType,"text","TEXT");

//submit button
$Form->new_Input($FormularName,$InputName_Submit,"submit",___("Speichern"));
$Form->set_InputStyleClass($FormularName,$InputName_Submit,"mFormSubmit","mFormSubmitFocus");
$Form->set_InputDesc($FormularName,$InputName_Submit,"");
$Form->set_InputReadonly($FormularName,$InputName_Submit,false);
$Form->set_InputOrder($FormularName,$InputName_Submit,998);
$Form->set_InputLabel($FormularName,$InputName_Submit,"");
//$Form->set_InputJS($FormularName,$InputName_Submit," onClick=\"switchSection('div_loader');\" ");

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
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['nl_id']['html'];

$_MAIN_OUTPUT.= "<table border=0>";

if (!empty($nl_id)) {
	$_MAIN_OUTPUT.= "<tr>";
	$_MAIN_OUTPUT.= "<td colspan=\"2\">";
	$_MAIN_OUTPUT.= "ID: <b>".$NL[0]['id']."</b>";
	$_MAIN_OUTPUT.= "<br>";
	$_MAIN_OUTPUT.= sprintf(___("Erstellt am: %s von %s"),"<b>".$NL[0]['created']."</b>","<b>".$NL[0]['author']."</b>");
	$_MAIN_OUTPUT.= "<br>";
	$_MAIN_OUTPUT.= sprintf(___("Bearbeitet am: %s von %s"),"<b>".$NL[0]['updated']."</b>","<b>".$NL[0]['editor']."</b>");
	$_MAIN_OUTPUT.= "<br><br>";
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "</tr>";
}

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top width=\"200\">";
$_MAIN_OUTPUT.= tm_icon("sum.png",___("Betreff"))."&nbsp;".___("Betreff");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Name]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("tick.png",___("Aktiv")).tm_icon("cancel.png",___("Inaktiv"))."&nbsp;".___("Aktiv");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Aktiv]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("page_white_office.png",___("Format"))."&nbsp;".___("Format");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_ContentType]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("lorry.png",___("Massenmailing")).tm_icon("user_suit.png",___("personalisiertes Newsletter"))."&nbsp;".___("Massenmailing (BCC)");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Massmail]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("book.png",___("Gruppe"))."&nbsp;".___("Gruppe");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Group]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("page_white_link.png",___("Link"))."&nbsp;".___("Link");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Link]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("photo.png",___("Bild"))."&nbsp;".___("Bild");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Image1]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("page_white_world.png",___("HTML"))."&nbsp;".___("HTML");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_File]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("attach.png",___("Anhang"))."&nbsp;".___("Anhang");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Attach1]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("picture_go.png",___("Tracking Bild"))."&nbsp;".___("Blind- bzw. Tracking Bild auswählen oder neues Bild hochladen");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_TrackImageExisting]['html']."&nbsp; oder<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_TrackImageNew]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top colspan=2>";
$_MAIN_OUTPUT.= tm_icon("layout.png",___("Text"))."&nbsp;".___("Text")."&nbsp;&nbsp;&nbsp;";
$_MAIN_OUTPUT.= "(<a href=\"javascript:toggleEditor('".$InputName_Descr."')\">";
$_MAIN_OUTPUT.= ___("Editor Ein/Aus");
$_MAIN_OUTPUT.= "&nbsp;".tm_icon("wand.png",___("Editor Ein/Aus"))."</a>)<br>";
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
$_MAIN_OUTPUT.= sprintf(___("%s enthält das hochgeladene Bild 'img src' | %s enthält nur die URL zum Bild"),"<b>{IMAGE1}</b>","<b>{IMAGE1_URL}</b>")."<br>".
						sprintf(___("%s enthält den angegebenen Link 'a href' | %s enthält nur die URL des Links"),"<b>{LINK1}</b>","<b>{LINK1_URL}</b>")."<br>".
						sprintf(___("%s enthält den Link zum Attachement 'a href' |  %s enthält nur die URL zum Attachement"),"<b>{ATTACH1}</b>","<b>{ATTACH1_URL}</b>")."<br>".
						sprintf(___("%s enthält den Link zum abmelden |   %s enthält nur die URL zum Abmeldeformular"),"<b>{UNSUBSCRIBE}</b>","<b>{UNSUBSCRIBE_URL}</b>")."<br>".
						sprintf(___("%s enthält den Link zur Onlineversion 'a href' |  %s enthält nur die URL zur Onlineversion"),"<b>{NLONLINE}</b>","<b>{NLONLINE_URL}</b>")."<br>".
						sprintf(___("%s enthält das schliessende TAG '/a' fuer die Links"),"<b>{CLOSELINK}</b>")."<br>".
						"<u>".___("Nur für personalisierten Newsleter:")."</u><br>".
						sprintf(___("%s enthält das Tracker-Bild (für View-Tracking, nur HTML-Mails)"),"<b>{BLINDIMAGE}</b>")."<br>".
						sprintf(___("%s enthält die e-Mailadresse des Empfaengers"),"<b>{EMAIL}</b>")."<br>".
						sprintf(___("%s bis %s enthält die Felder aus den Formularen/Adressen"),"<b>{F0}</b>","<b>{F9}</b>")."<br>".
						sprintf(___("%s enthält den kompletten Link 'a href' zum Aktivierungslink ('(1st)-Touch-Opt-In) | %s enthält nur die URL"),"<b>{SUBSCRIBE}</b>","<b>{SUBSCRIBE_URL}</b>")."<br>".
						"";

include_once ($tm_includepath."/wysiwyg.inc.php");
?>