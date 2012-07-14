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

//sender_name, email etc
$Form->new_Input($FormularName,$InputName_SenderName,"text", $$InputName_SenderName);
$Form->set_InputJS($FormularName,$InputName_SenderName," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_SenderName,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_SenderName,48,256);
$Form->set_InputDesc($FormularName,$InputName_SenderName,___("Erscheint als Absender-name in der E-Mail"));
$Form->set_InputReadonly($FormularName,$InputName_SenderName,false);
$Form->set_InputOrder($FormularName,$InputName_SenderName,1);
$Form->set_InputLabel($FormularName,$InputName_SenderName,"");

//sender_name, email etc
$Form->new_Input($FormularName,$InputName_SenderEMail,"text", $$InputName_SenderEMail);
$Form->set_InputJS($FormularName,$InputName_SenderEMail," onChange=\"flash('submit','#ff0000');\" onkeyup=\"RemoveInvalidChars(this, '[^A-Za-z0-9\_\@\.\-]'); ForceLowercase(this);\"");
$Form->set_InputStyleClass($FormularName,$InputName_SenderEMail,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_SenderEMail,48,256);
$Form->set_InputDesc($FormularName,$InputName_SenderEMail,___("Erscheint als Absender-E-Mail-Adresse in der E-Mail"));
$Form->set_InputReadonly($FormularName,$InputName_SenderEMail,false);
$Form->set_InputOrder($FormularName,$InputName_SenderEMail,1);
$Form->set_InputLabel($FormularName,$InputName_SenderEMail,"");

//emailcheck...
$Form->new_Input($FormularName,$InputName_ECheckIntern,"select", "");
$Form->set_InputJS($FormularName,$InputName_ECheckIntern," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_ECheckIntern,$$InputName_ECheckIntern);
$Form->set_InputStyleClass($FormularName,$InputName_ECheckIntern,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_ECheckIntern,"");
$Form->set_InputReadonly($FormularName,$InputName_ECheckIntern,false);
$Form->set_InputOrder($FormularName,$InputName_ECheckIntern,6);
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
$Form->set_InputOrder($FormularName,$InputName_ECheckSubscribe,6);
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
$Form->set_InputOrder($FormularName,$InputName_NotifySubscribe,2);
$Form->set_InputLabel($FormularName,$InputName_NotifySubscribe,"");

//notify
$Form->new_Input($FormularName,$InputName_NotifyUnsubscribe,"checkbox", 1);
$Form->set_InputJS($FormularName,$InputName_NotifyUnsubscribe," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_NotifyUnsubscribe,$$InputName_NotifyUnsubscribe);
$Form->set_InputStyleClass($FormularName,$InputName_NotifyUnsubscribe,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_NotifyUnsubscribe,48,256);
$Form->set_InputDesc($FormularName,$InputName_NotifyUnsubscribe,___("Nachricht bei Abmeldung"));
$Form->set_InputReadonly($FormularName,$InputName_NotifyUnsubscribe,false);
$Form->set_InputOrder($FormularName,$InputName_NotifyUnsubscribe,2);
$Form->set_InputLabel($FormularName,$InputName_NotifyUnsubscribe,"");

//notify_mail etc
$Form->new_Input($FormularName,$InputName_NotifyMail,"text", $$InputName_NotifyMail);
$Form->set_InputJS($FormularName,$InputName_NotifyMail," onChange=\"flash('submit','#ff0000');\" onkeyup=\"RemoveInvalidChars(this, '[^A-Za-z0-9\_\@\.\-]'); ForceLowercase(this);\"");
$Form->set_InputStyleClass($FormularName,$InputName_NotifyMail,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_NotifyMail,48,256);
$Form->set_InputDesc($FormularName,$InputName_NotifyMail,___("E-Mail-Adresse für Benachrichtigungen"));
$Form->set_InputReadonly($FormularName,$InputName_NotifyMail,false);
$Form->set_InputOrder($FormularName,$InputName_NotifyMail,1);
$Form->set_InputLabel($FormularName,$InputName_NotifyMail,"");

//return_mail etc
$Form->new_Input($FormularName,$InputName_ReturnMail,"text", $$InputName_ReturnMail);
$Form->set_InputJS($FormularName,$InputName_ReturnMail," onChange=\"flash('submit','#ff0000');\" onkeyup=\"RemoveInvalidChars(this, '[^A-Za-z0-9\_\@\.\-]'); ForceLowercase(this);\"");
$Form->set_InputStyleClass($FormularName,$InputName_ReturnMail,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_ReturnMail,48,256);
$Form->set_InputDesc($FormularName,$InputName_ReturnMail,___("Return-Path, Adresse für E-Mail Fehlermeldungen"));
$Form->set_InputReadonly($FormularName,$InputName_ReturnMail,false);
$Form->set_InputOrder($FormularName,$InputName_ReturnMail,1);
$Form->set_InputLabel($FormularName,$InputName_ReturnMail,"");

//smtp
$Form->new_Input($FormularName,$InputName_SMTPHost,"text", $$InputName_SMTPHost);
$Form->set_InputJS($FormularName,$InputName_SMTPHost," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_SMTPHost,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_SMTPHost,48,256);
$Form->set_InputDesc($FormularName,$InputName_SMTPHost,___("SMTP Servername / IP-Adresse"));
$Form->set_InputReadonly($FormularName,$InputName_SMTPHost,false);
$Form->set_InputOrder($FormularName,$InputName_SMTPHost,1);
$Form->set_InputLabel($FormularName,$InputName_SMTPHost,"");

//smtp
$Form->new_Input($FormularName,$InputName_SMTPUser,"text", $$InputName_SMTPUser);
$Form->set_InputJS($FormularName,$InputName_SMTPUser," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_SMTPUser,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_SMTPUser,48,256);
$Form->set_InputDesc($FormularName,$InputName_SMTPUser,___("SMTP Benutzername"));
$Form->set_InputReadonly($FormularName,$InputName_SMTPUser,false);
$Form->set_InputOrder($FormularName,$InputName_SMTPUser,1);
$Form->set_InputLabel($FormularName,$InputName_SMTPUser,"");

//smtp
$Form->new_Input($FormularName,$InputName_SMTPPass,"password", $$InputName_SMTPPass);
$Form->set_InputJS($FormularName,$InputName_SMTPPass," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_SMTPPass,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_SMTPPass,48,256);
$Form->set_InputDesc($FormularName,$InputName_SMTPPass,___("SMTP Passwort"));
$Form->set_InputReadonly($FormularName,$InputName_SMTPPass,false);
$Form->set_InputOrder($FormularName,$InputName_SMTPPass,1);
$Form->set_InputLabel($FormularName,$InputName_SMTPPass,"");

//smtp
$Form->new_Input($FormularName,$InputName_SMTPDomain,"text", $$InputName_SMTPDomain);
$Form->set_InputJS($FormularName,$InputName_SMTPDomain," onChange=\"flash('submit','#ff0000');\" onkeyup=\"RemoveInvalidChars(this, '[^A-Za-z0-9\.\-]'); ForceLowercase(this);\" ");
$Form->set_InputStyleClass($FormularName,$InputName_SMTPDomain,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_SMTPDomain,48,256);
$Form->set_InputDesc($FormularName,$InputName_SMTPDomain,___("SMTP Domain"));
$Form->set_InputReadonly($FormularName,$InputName_SMTPDomain,false);
$Form->set_InputOrder($FormularName,$InputName_SMTPDomain,1);
$Form->set_InputLabel($FormularName,$InputName_SMTPDomain,"");


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

//Mails at once
$Form->new_Input($FormularName,$InputName_MaxMails,"select", "");
$Form->set_InputJS($FormularName,$InputName_MaxMails," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_MaxMails,$$InputName_MaxMails);
$Form->set_InputStyleClass($FormularName,$InputName_MaxMails,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_MaxMails,___("Maximale Anzahl Mails pro Durchgang"));
$Form->set_InputReadonly($FormularName,$InputName_MaxMails,false);
$Form->set_InputOrder($FormularName,$InputName_MaxMails,6);
$Form->set_InputLabel($FormularName,$InputName_MaxMails,"");
$Form->set_InputSize($FormularName,$InputName_MaxMails,0,1);
$Form->set_InputMultiple($FormularName,$InputName_MaxMails,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_MaxMails,5,"  5 - very low");
$Form->add_InputOption($FormularName,$InputName_MaxMails,10," 10 - low Traffic");
$Form->add_InputOption($FormularName,$InputName_MaxMails,25," 25 - small Newsletter");
$Form->add_InputOption($FormularName,$InputName_MaxMails,35," 35 - normal *");
$Form->add_InputOption($FormularName,$InputName_MaxMails,50," 50 - bulk mail");
$Form->add_InputOption($FormularName,$InputName_MaxMails,75," 75 - fast");
$Form->add_InputOption($FormularName,$InputName_MaxMails,100,"100 - fast");
$Form->add_InputOption($FormularName,$InputName_MaxMails,150,"150 - high");
$Form->add_InputOption($FormularName,$InputName_MaxMails,250,"250 - very high");
$Form->add_InputOption($FormularName,$InputName_MaxMails,500,"500 - too much");
$Form->add_InputOption($FormularName,$InputName_MaxMails,1000,"1000 - 2fast4u");

//Mails Bcc
$Form->new_Input($FormularName,$InputName_MaxMailsBcc,"select", "");
$Form->set_InputJS($FormularName,$InputName_MaxMailsBcc," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_MaxMailsBcc,$$InputName_MaxMailsBcc);
$Form->set_InputStyleClass($FormularName,$InputName_MaxMailsBcc,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_MaxMailsBcc,___("Maximale Anzahl BCC-Adressen pro Mail für Massenmailing"));
$Form->set_InputReadonly($FormularName,$InputName_MaxMailsBcc,false);
$Form->set_InputOrder($FormularName,$InputName_MaxMailsBcc,6);
$Form->set_InputLabel($FormularName,$InputName_MaxMailsBcc,"");
$Form->set_InputSize($FormularName,$InputName_MaxMailsBcc,0,1);
$Form->set_InputMultiple($FormularName,$InputName_MaxMailsBcc,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_MaxMailsBcc,5,"  5");
$Form->add_InputOption($FormularName,$InputName_MaxMailsBcc,10," 10");
$Form->add_InputOption($FormularName,$InputName_MaxMailsBcc,25," 25");
$Form->add_InputOption($FormularName,$InputName_MaxMailsBcc,50," 50");
$Form->add_InputOption($FormularName,$InputName_MaxMailsBcc,75," 75");
$Form->add_InputOption($FormularName,$InputName_MaxMailsBcc,100,"100");

//check version and show news
$Form->new_Input($FormularName,$InputName_CheckVersion,"checkbox", 1);
$Form->set_InputJS($FormularName,$InputName_CheckVersion," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_CheckVersion,$$InputName_CheckVersion);
$Form->set_InputStyleClass($FormularName,$InputName_CheckVersion,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_CheckVersion,48,256);
$Form->set_InputDesc($FormularName,$InputName_CheckVersion,___("Aktuelle Version und News auf der Startseite einblenden"));
$Form->set_InputReadonly($FormularName,$InputName_CheckVersion,false);
$Form->set_InputOrder($FormularName,$InputName_CheckVersion,2);
$Form->set_InputLabel($FormularName,$InputName_CheckVersion,"");


//Select existing Trackimage
$Form->new_Input($FormularName,$InputName_TrackImageExisting,"select", "");
$Form->set_InputJS($FormularName,$InputName_TrackImageExisting," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_TrackImageExisting,$C[0]['track_image']);
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
$Form->add_InputOption($FormularName,$InputName_TrackImageExisting,"_blank","-- BLANK --");
for ($icc=0; $icc < $ic; $icc++) {
	$Form->add_InputOption($FormularName,$InputName_TrackImageExisting,$FileARRAY[$icc]['filename'],$FileARRAY[$icc]['filename']);
}

//upload new trackingimage
$Form->new_Input($FormularName,$InputName_TrackImageNew,"file", "");
$Form->set_InputJS($FormularName,$InputName_TrackImageNew," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_TrackImageNew,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_TrackImageNew,48,48);
$Form->set_InputDesc($FormularName,$InputName_TrackImageNew,___("neues Bild hochladen"));
$Form->set_InputReadonly($FormularName,$InputName_TrackImageNew,false);
$Form->set_InputOrder($FormularName,$InputName_TrackImageNew,91);
$Form->set_InputLabel($FormularName,$InputName_TrackImageNew,"");

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
$_MAIN_OUTPUT.= tm_icon("email.png",___("E-Mail"))."&nbsp;".___("Absender- und Antwort-Adresse")."<br>".___("E-Mail (name@domain.tld)");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_SenderEMail]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("user_gray.png",___("Name"))."&nbsp;".___("Absender-Name");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_SenderName]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("email_error.png",___("E-Mail"))."&nbsp;".___("Return-Path, E-Mail für Fehlermeldungen");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_ReturnMail]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";


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
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("cog.png",___("Maximale Anzahl Mails"))."&nbsp;".___("Maximale Anzahl Mails pro Sendevorgang");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_MaxMails]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("cog.png",___("Maximale Anzahl Mails für BCC"))."&nbsp;".___("Maximale Anzahl Adressen pro Mail im BCC-Header für Massenmailing");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_MaxMailsBcc]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";


$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td style=\"border-top:1px dashed grey\" valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("server.png",___("SMTP Servername"))."&nbsp;".___("SMTP Servername / IP-Adresse");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_SMTPHost]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("server_connect.png",___("SMTP Benutzername"))."&nbsp;".___("SMTP Benutzername");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_SMTPUser]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("server_connect.png",___("SMTP Passwort"))."&nbsp;".___("SMTP Passwort");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_SMTPPass]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("server_connect.png",___("Domain"))."&nbsp;".___("SMTP Domain");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_SMTPDomain]['html'];
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
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Submit]['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Reset]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "</table>";
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['foot'];

?>