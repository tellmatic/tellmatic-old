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
$FormularName="adm_set";
//make new Form
$Form->new_Form($FormularName,$_SERVER["PHP_SELF"],"post","_self");
$Form->set_FormType($FormularName,"multipart/form-data");
$Form->set_FormJS($FormularName," onSubmit=\"switchSection('div_loader');\" ");
//add a Description
$Form->set_FormDesc($FormularName,___("Systemeinstellungen ändern"));
$Form->new_Input($FormularName,"act", "hidden", $action);
$Form->new_Input($FormularName,"set", "hidden", "save");
//////////////////
//add inputfields and buttons....
//////////////////
//emailcheck...
$Form->new_Input($FormularName,$InputName_ECheckIntern,"select", "");
$Form->set_InputJS($FormularName,$InputName_ECheckIntern," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_ECheckIntern,$$InputName_ECheckIntern);
$Form->set_InputStyleClass($FormularName,$InputName_ECheckIntern,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_ECheckIntern,"");
$Form->set_InputReadonly($FormularName,$InputName_ECheckIntern,false);
$Form->set_InputOrder($FormularName,$InputName_ECheckIntern,1);
$Form->set_InputLabel($FormularName,$InputName_ECheckIntern,"");
$Form->set_InputSize($FormularName,$InputName_ECheckIntern,0,1);
$Form->set_InputMultiple($FormularName,$InputName_ECheckIntern,false);
//add Data
$sc=count($EMAILCHECK['intern']);
for ($scc=0; $scc<$sc; $scc++) {
	$Form->add_InputOption($FormularName,$InputName_ECheckIntern,$scc,$EMAILCHECK['intern'][$scc]);
}

//emailcheck...
$Form->new_Input($FormularName,$InputName_ECheckSubscribe,"select", "");
$Form->set_InputJS($FormularName,$InputName_ECheckSubscribe," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_ECheckSubscribe,$$InputName_ECheckSubscribe);
$Form->set_InputStyleClass($FormularName,$InputName_ECheckSubscribe,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_ECheckSubscribe,"");
$Form->set_InputReadonly($FormularName,$InputName_ECheckSubscribe,false);
$Form->set_InputOrder($FormularName,$InputName_ECheckSubscribe,2);
$Form->set_InputLabel($FormularName,$InputName_ECheckSubscribe,"");
$Form->set_InputSize($FormularName,$InputName_ECheckSubscribe,0,1);
$Form->set_InputMultiple($FormularName,$InputName_ECheckSubscribe,false);
//add Data
$sc=count($EMAILCHECK['subscribe']);
for ($scc=1; $scc<=$sc; $scc++)//0
{
	$Form->add_InputOption($FormularName,$InputName_ECheckSubscribe,$scc,$EMAILCHECK['subscribe'][$scc]);
}


//notify
$Form->new_Input($FormularName,$InputName_NotifySubscribe,"checkbox", 1);
$Form->set_InputJS($FormularName,$InputName_NotifySubscribe," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_NotifySubscribe,$$InputName_NotifySubscribe);
$Form->set_InputStyleClass($FormularName,$InputName_NotifySubscribe,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_NotifySubscribe,48,256);
$Form->set_InputDesc($FormularName,$InputName_NotifySubscribe,___("Nachricht bei Anmeldung"));
$Form->set_InputReadonly($FormularName,$InputName_NotifySubscribe,false);
$Form->set_InputOrder($FormularName,$InputName_NotifySubscribe,3);
$Form->set_InputLabel($FormularName,$InputName_NotifySubscribe,"");

//notify
$Form->new_Input($FormularName,$InputName_NotifyUnsubscribe,"checkbox", 1);
$Form->set_InputJS($FormularName,$InputName_NotifyUnsubscribe," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_NotifyUnsubscribe,$$InputName_NotifyUnsubscribe);
$Form->set_InputStyleClass($FormularName,$InputName_NotifyUnsubscribe,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_NotifyUnsubscribe,48,256);
$Form->set_InputDesc($FormularName,$InputName_NotifyUnsubscribe,___("Nachricht bei Abmeldung"));
$Form->set_InputReadonly($FormularName,$InputName_NotifyUnsubscribe,false);
$Form->set_InputOrder($FormularName,$InputName_NotifyUnsubscribe,4);
$Form->set_InputLabel($FormularName,$InputName_NotifyUnsubscribe,"");

//notify_mail etc
$Form->new_Input($FormularName,$InputName_NotifyMail,"text", $$InputName_NotifyMail);
$Form->set_InputJS($FormularName,$InputName_NotifyMail," onChange=\"flash('submit','#ff0000');\" onkeyup=\"RemoveInvalidChars(this, '[^A-Za-z0-9\_\@\.\-]'); ForceLowercase(this);\"");
$Form->set_InputStyleClass($FormularName,$InputName_NotifyMail,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_NotifyMail,48,256);
$Form->set_InputDesc($FormularName,$InputName_NotifyMail,___("E-Mail-Adresse für Benachrichtigungen"));
$Form->set_InputReadonly($FormularName,$InputName_NotifyMail,false);
$Form->set_InputOrder($FormularName,$InputName_NotifyMail,5);
$Form->set_InputLabel($FormularName,$InputName_NotifyMail,"");


//Retries
$Form->new_Input($FormularName,$InputName_MaxRetry,"select", "");
$Form->set_InputJS($FormularName,$InputName_MaxRetry," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_MaxRetry,$$InputName_MaxRetry);
$Form->set_InputStyleClass($FormularName,$InputName_MaxRetry,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_MaxRetry,___("Maximale Anzahl Sendeversuche pro Adresse"));
$Form->set_InputReadonly($FormularName,$InputName_MaxRetry,false);
$Form->set_InputOrder($FormularName,$InputName_MaxRetry,6);
$Form->set_InputLabel($FormularName,$InputName_MaxRetry,"");
$Form->set_InputSize($FormularName,$InputName_MaxRetry,0,1);
$Form->set_InputMultiple($FormularName,$InputName_MaxRetry,false);
//add Data
$rt=10;
for ($rtc=1; $rtc<=$rt; $rtc=$rtc+2)
{
	$Form->add_InputOption($FormularName,$InputName_MaxRetry,$rtc,$rtc);
}

//check version and show news
$Form->new_Input($FormularName,$InputName_CheckVersion,"checkbox", 1);
$Form->set_InputJS($FormularName,$InputName_CheckVersion," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_CheckVersion,$$InputName_CheckVersion);
$Form->set_InputStyleClass($FormularName,$InputName_CheckVersion,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_CheckVersion,48,256);
$Form->set_InputDesc($FormularName,$InputName_CheckVersion,___("Aktuelle Version und News auf der Startseite einblenden"));
$Form->set_InputReadonly($FormularName,$InputName_CheckVersion,false);
$Form->set_InputOrder($FormularName,$InputName_CheckVersion,7);
$Form->set_InputLabel($FormularName,$InputName_CheckVersion,"");


//Select existing Trackimage
$Form->new_Input($FormularName,$InputName_TrackImageExisting,"select", "");
$Form->set_InputJS($FormularName,$InputName_TrackImageExisting," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_TrackImageExisting,basename($C[0]['track_image']));
$Form->set_InputStyleClass($FormularName,$InputName_TrackImageExisting,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_TrackImageExisting,___("Blind-/Tracking-Bild auswählen"));
$Form->set_InputReadonly($FormularName,$InputName_TrackImageExisting,false);
$Form->set_InputOrder($FormularName,$InputName_TrackImageExisting,8);
$Form->set_InputLabel($FormularName,$InputName_TrackImageExisting,"");
$Form->set_InputSize($FormularName,$InputName_TrackImageExisting,0,1);
$Form->set_InputMultiple($FormularName,$InputName_TrackImageExisting,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_TrackImageExisting,"_blank","-- BLANK --");
$TrackImg_Files=getFiles($tm_nlimgpath) ;
foreach ($TrackImg_Files as $field) {
	$btsort[]=$field['name'];
}
@array_multisort($btsort, SORT_ASC, $TrackImg_Files, SORT_ASC);
$ic= count($TrackImg_Files);
for ($icc=0; $icc < $ic; $icc++) {
	if ($TrackImg_Files[$icc]['name']!=".htaccess" && $TrackImg_Files[$icc]['name']!="index.php" && $TrackImg_Files[$icc]['name']!="index.html") {
		$Form->add_InputOption($FormularName,$InputName_TrackImageExisting,$TrackImg_Files[$icc]['name'],display($TrackImg_Files[$icc]['name']));
	}
}

//upload new trackingimage
$Form->new_Input($FormularName,$InputName_TrackImageNew,"file", "");
$Form->set_InputJS($FormularName,$InputName_TrackImageNew," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_TrackImageNew,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_TrackImageNew,48,48);
$Form->set_InputDesc($FormularName,$InputName_TrackImageNew,___("neues Bild hochladen"));
$Form->set_InputReadonly($FormularName,$InputName_TrackImageNew,false);
$Form->set_InputOrder($FormularName,$InputName_TrackImageNew,9);
$Form->set_InputLabel($FormularName,$InputName_TrackImageNew,"");

//rcpt_name etc
$Form->new_Input($FormularName,$InputName_RCPTName,"text", $$InputName_RCPTName);
$Form->set_InputJS($FormularName,$InputName_RCPTName," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_RCPTName,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_RCPTName,48,256);
$Form->set_InputDesc($FormularName,$InputName_RCPTName,___("Erscheint als Empfängername in der E-Mail"));
$Form->set_InputReadonly($FormularName,$InputName_RCPTName,false);
$Form->set_InputOrder($FormularName,$InputName_RCPTName,10);
$Form->set_InputLabel($FormularName,$InputName_RCPTName,"");

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
$_MAIN_OUTPUT.= "<table>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("spellcheck.png",___("E-Mail-Prüfung"))."&nbsp;".___("Prüfung der E-Mail-Adressen, Intern + Versand");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_ECheckIntern]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("spellcheck.png",___("E-Mail-Prüfung"))."&nbsp;".___("Prüfung der E-Mail-Adressen bei Anmeldung");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_ECheckSubscribe]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td style=\"border-top:1px dashed grey\" valign=\"top\">";
$_MAIN_OUTPUT.=  tm_icon("note_go.png",___("Benachrichtigung"))."&nbsp;".___("Benachrichtigung bei Neuanmeldung (subscribe)");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_NotifySubscribe]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.=  tm_icon("note_go.png",___("Benachrichtigung"))."&nbsp;".___("Benachrichtigung bei Abmeldung (unsubscribe)");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_NotifyUnsubscribe]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.=  tm_icon("email_go.png",___("E-Mail"))."&nbsp;".___("Benachrichtigungen gehen an (name@domain.tld)");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_NotifyMail]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td style=\"border-top:1px dashed grey\" valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("cog_error.png",___("Sendeversuche per E-Mail"))."&nbsp;".___("Maximale Versuche pro E-Mail (Gesamt)");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_MaxRetry]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td style=\"border-top:1px dashed grey\" valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("information.png",___("Versionsabfrage und News"))."&nbsp;".___("Versionsabfrage und News auf der Startseite");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_CheckVersion]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td style=\"border-top:1px dashed grey\" valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("picture.png",___("Tracking Bild"))."&nbsp;".___("Blind- bzw. Tracking Bild auswählen oder neues Bild hochladen");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_TrackImageExisting]['html']."&nbsp; oder<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_TrackImageNew]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";


$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("user_comment.png",___("Name"))."&nbsp;".___("Empfänger-Name");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_RCPTName]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";


$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Submit]['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Reset]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "</table>";
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['foot'];

?>