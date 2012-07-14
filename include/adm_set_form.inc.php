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

//emailcheck...intern
$Form->new_Input($FormularName,$InputName_ECheckIntern,"select", "");
$Form->set_InputJS($FormularName,$InputName_ECheckIntern," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_ECheckIntern,$$InputName_ECheckIntern);
$Form->set_InputStyleClass($FormularName,$InputName_ECheckIntern,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_ECheckIntern,"");
$Form->set_InputReadonly($FormularName,$InputName_ECheckIntern,false);
$Form->set_InputOrder($FormularName,$InputName_ECheckIntern,3);
$Form->set_InputLabel($FormularName,$InputName_ECheckIntern,"");
$Form->set_InputSize($FormularName,$InputName_ECheckIntern,0,1);
$Form->set_InputMultiple($FormularName,$InputName_ECheckIntern,false);
//add Data
$sc=count($EMAILCHECK['intern']);
for ($scc=0; $scc<$sc; $scc++) {
	$Form->add_InputOption($FormularName,$InputName_ECheckIntern,$scc,$EMAILCHECK['intern'][$scc]);
}

//emailcheck...subscribe
$Form->new_Input($FormularName,$InputName_ECheckSubscribe,"select", "");
$Form->set_InputJS($FormularName,$InputName_ECheckSubscribe," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_ECheckSubscribe,$$InputName_ECheckSubscribe);
$Form->set_InputStyleClass($FormularName,$InputName_ECheckSubscribe,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_ECheckSubscribe,"");
$Form->set_InputReadonly($FormularName,$InputName_ECheckSubscribe,false);
$Form->set_InputOrder($FormularName,$InputName_ECheckSubscribe,8);
$Form->set_InputLabel($FormularName,$InputName_ECheckSubscribe,"");
$Form->set_InputSize($FormularName,$InputName_ECheckSubscribe,0,1);
$Form->set_InputMultiple($FormularName,$InputName_ECheckSubscribe,false);
//add Data
$sc=count($EMAILCHECK['subscribe']);
for ($scc=1; $scc<=$sc; $scc++)//0
{
	$Form->add_InputOption($FormularName,$InputName_ECheckSubscribe,$scc,$EMAILCHECK['subscribe'][$scc]);
}

//emailcheck...sendit
$Form->new_Input($FormularName,$InputName_ECheckSendit,"select", "");
$Form->set_InputJS($FormularName,$InputName_ECheckSendit," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_ECheckSendit,$$InputName_ECheckSendit);
$Form->set_InputStyleClass($FormularName,$InputName_ECheckSendit,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_ECheckSendit,"");
$Form->set_InputReadonly($FormularName,$InputName_ECheckSendit,false);
$Form->set_InputOrder($FormularName,$InputName_ECheckSendit,4);
$Form->set_InputLabel($FormularName,$InputName_ECheckSendit,"");
$Form->set_InputSize($FormularName,$InputName_ECheckSendit,0,1);
$Form->set_InputMultiple($FormularName,$InputName_ECheckSendit,false);
//add Data
$sc=count($EMAILCHECK['sendit']);
for ($scc=1; $scc<=$sc; $scc++)//0
{
	$Form->add_InputOption($FormularName,$InputName_ECheckSendit,$scc,$EMAILCHECK['sendit'][$scc]);
}

//emailcheck...checkit
$Form->new_Input($FormularName,$InputName_ECheckCheckit,"select", "");
$Form->set_InputJS($FormularName,$InputName_ECheckCheckit," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_ECheckCheckit,$$InputName_ECheckCheckit);
$Form->set_InputStyleClass($FormularName,$InputName_ECheckCheckit,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_ECheckCheckit,"");
$Form->set_InputReadonly($FormularName,$InputName_ECheckCheckit,false);
$Form->set_InputOrder($FormularName,$InputName_ECheckCheckit,16);
$Form->set_InputLabel($FormularName,$InputName_ECheckCheckit,"");
$Form->set_InputSize($FormularName,$InputName_ECheckCheckit,0,1);
$Form->set_InputMultiple($FormularName,$InputName_ECheckCheckit,false);
//add Data
$sc=count($EMAILCHECK['checkit']);
for ($scc=1; $scc<=$sc; $scc++)//0
{
	if ($scc==3) $Form->add_InputOption($FormularName,$InputName_ECheckCheckit,$scc,$EMAILCHECK['checkit'][$scc]);
}


//notify
$Form->new_Input($FormularName,$InputName_NotifySubscribe,"checkbox", 1);
$Form->set_InputJS($FormularName,$InputName_NotifySubscribe," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_NotifySubscribe,$$InputName_NotifySubscribe);
$Form->set_InputStyleClass($FormularName,$InputName_NotifySubscribe,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_NotifySubscribe,48,256);
$Form->set_InputDesc($FormularName,$InputName_NotifySubscribe,___("Nachricht bei Anmeldung"));
$Form->set_InputReadonly($FormularName,$InputName_NotifySubscribe,false);
$Form->set_InputOrder($FormularName,$InputName_NotifySubscribe,9);
$Form->set_InputLabel($FormularName,$InputName_NotifySubscribe,"");

//notify
$Form->new_Input($FormularName,$InputName_NotifyUnsubscribe,"checkbox", 1);
$Form->set_InputJS($FormularName,$InputName_NotifyUnsubscribe," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_NotifyUnsubscribe,$$InputName_NotifyUnsubscribe);
$Form->set_InputStyleClass($FormularName,$InputName_NotifyUnsubscribe,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_NotifyUnsubscribe,48,256);
$Form->set_InputDesc($FormularName,$InputName_NotifyUnsubscribe,___("Nachricht bei Abmeldung"));
$Form->set_InputReadonly($FormularName,$InputName_NotifyUnsubscribe,false);
$Form->set_InputOrder($FormularName,$InputName_NotifyUnsubscribe,10);
$Form->set_InputLabel($FormularName,$InputName_NotifyUnsubscribe,"");

//notify_mail etc
$Form->new_Input($FormularName,$InputName_NotifyMail,"text", $$InputName_NotifyMail);
$Form->set_InputJS($FormularName,$InputName_NotifyMail," onChange=\"flash('submit','#ff0000');\" onkeyup=\"RemoveInvalidChars(this, '[^A-Za-z0-9\_\@\.\-]'); ForceLowercase(this);\"");
$Form->set_InputStyleClass($FormularName,$InputName_NotifyMail,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_NotifyMail,48,256);
$Form->set_InputDesc($FormularName,$InputName_NotifyMail,___("E-Mail-Adresse für Benachrichtigungen"));
$Form->set_InputReadonly($FormularName,$InputName_NotifyMail,false);
$Form->set_InputOrder($FormularName,$InputName_NotifyMail,11);
$Form->set_InputLabel($FormularName,$InputName_NotifyMail,"");

//Retries
$Form->new_Input($FormularName,$InputName_MaxRetry,"select", "");
$Form->set_InputJS($FormularName,$InputName_MaxRetry," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_MaxRetry,$$InputName_MaxRetry);
$Form->set_InputStyleClass($FormularName,$InputName_MaxRetry,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_MaxRetry,___("Maximale Anzahl Sendeversuche pro Adresse"));
$Form->set_InputReadonly($FormularName,$InputName_MaxRetry,false);
$Form->set_InputOrder($FormularName,$InputName_MaxRetry,5);
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
$Form->set_InputOrder($FormularName,$InputName_CheckVersion,1);
$Form->set_InputLabel($FormularName,$InputName_CheckVersion,"");

//Select existing Trackimage
$Form->new_Input($FormularName,$InputName_TrackImageExisting,"select", "");
$Form->set_InputJS($FormularName,$InputName_TrackImageExisting," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_TrackImageExisting,basename($C[0]['track_image']));
$Form->set_InputStyleClass($FormularName,$InputName_TrackImageExisting,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_TrackImageExisting,___("Blind-/Tracking-Bild auswählen"));
$Form->set_InputReadonly($FormularName,$InputName_TrackImageExisting,false);
$Form->set_InputOrder($FormularName,$InputName_TrackImageExisting,6);
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
$Form->set_InputOrder($FormularName,$InputName_TrackImageNew,7);
$Form->set_InputLabel($FormularName,$InputName_TrackImageNew,"");

//rcpt_name etc
$Form->new_Input($FormularName,$InputName_RCPTName,"text", $$InputName_RCPTName);
$Form->set_InputJS($FormularName,$InputName_RCPTName," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_RCPTName,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_RCPTName,48,256);
$Form->set_InputDesc($FormularName,$InputName_RCPTName,___("Erscheint als Empfängername in der E-Mail"));
$Form->set_InputReadonly($FormularName,$InputName_RCPTName,false);
$Form->set_InputOrder($FormularName,$InputName_RCPTName,2);
$Form->set_InputLabel($FormularName,$InputName_RCPTName,"");

//capctha unsub
$Form->new_Input($FormularName,$InputName_UnsubUseCaptcha,"checkbox", 1);
$Form->set_InputJS($FormularName,$InputName_UnsubUseCaptcha," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_UnsubUseCaptcha,$$InputName_UnsubUseCaptcha);
$Form->set_InputStyleClass($FormularName,$InputName_UnsubUseCaptcha,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_UnsubUseCaptcha,48,256);
$Form->set_InputDesc($FormularName,$InputName_UnsubUseCaptcha,___("Captcha im Abmeldeformular"));
$Form->set_InputReadonly($FormularName,$InputName_UnsubUseCaptcha,false);
$Form->set_InputOrder($FormularName,$InputName_UnsubUseCaptcha,12);
$Form->set_InputLabel($FormularName,$InputName_UnsubUseCaptcha,"");

//DigitsCaptcha
$Form->new_Input($FormularName,$InputName_UnsubDigitsCaptcha,"select", "");
$Form->set_InputJS($FormularName,$InputName_UnsubDigitsCaptcha," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_UnsubDigitsCaptcha,$$InputName_UnsubDigitsCaptcha);
$Form->set_InputStyleClass($FormularName,$InputName_UnsubDigitsCaptcha,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_UnsubDigitsCaptcha,___("Ziffern"));
$Form->set_InputReadonly($FormularName,$InputName_UnsubDigitsCaptcha,false);
$Form->set_InputOrder($FormularName,$InputName_UnsubDigitsCaptcha,13);
$Form->set_InputLabel($FormularName,$InputName_UnsubDigitsCaptcha,"");
$Form->set_InputSize($FormularName,$InputName_UnsubDigitsCaptcha,0,1);
$Form->set_InputMultiple($FormularName,$InputName_UnsubDigitsCaptcha,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_UnsubDigitsCaptcha,4,"4");
$Form->add_InputOption($FormularName,$InputName_UnsubDigitsCaptcha,5,"5");
$Form->add_InputOption($FormularName,$InputName_UnsubDigitsCaptcha,6,"6");
$Form->add_InputOption($FormularName,$InputName_UnsubDigitsCaptcha,7,"7");
$Form->add_InputOption($FormularName,$InputName_UnsubDigitsCaptcha,8,"8");
$Form->add_InputOption($FormularName,$InputName_UnsubDigitsCaptcha,9,"9");
$Form->add_InputOption($FormularName,$InputName_UnsubDigitsCaptcha,10,"10");

//unsub sendmail
$Form->new_Input($FormularName,$InputName_UnsubSendMail,"checkbox", 1);
$Form->set_InputJS($FormularName,$InputName_UnsubSendMail," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_UnsubSendMail,$$InputName_UnsubSendMail);
$Form->set_InputStyleClass($FormularName,$InputName_UnsubSendMail,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_UnsubSendMail,48,256);
$Form->set_InputDesc($FormularName,$InputName_UnsubSendMail,___("Bestätigungsmail senden"));
$Form->set_InputReadonly($FormularName,$InputName_UnsubSendMail,false);
$Form->set_InputOrder($FormularName,$InputName_UnsubSendMail,12);
$Form->set_InputLabel($FormularName,$InputName_UnsubSendMail,"");

//unsub action
$Form->new_Input($FormularName,$InputName_UnsubAction,"select", "");
$Form->set_InputJS($FormularName,$InputName_UnsubAction," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_UnsubAction,$$InputName_UnsubAction);
$Form->set_InputStyleClass($FormularName,$InputName_UnsubAction,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_UnsubAction,___("Aktion"));
$Form->set_InputReadonly($FormularName,$InputName_UnsubAction,false);
$Form->set_InputOrder($FormularName,$InputName_UnsubAction,13);
$Form->set_InputLabel($FormularName,$InputName_UnsubAction,"");
$Form->set_InputSize($FormularName,$InputName_UnsubAction,0,1);
$Form->set_InputMultiple($FormularName,$InputName_UnsubAction,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_UnsubAction,"unsubscribe",___("Abmelden"));
$Form->add_InputOption($FormularName,$InputName_UnsubAction,"delete",___("Löschen"));


//CheckitLimit
$Form->new_Input($FormularName,$InputName_CheckitLimit,"select", "");
$Form->set_InputJS($FormularName,$InputName_CheckitLimit," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_CheckitLimit,$$InputName_CheckitLimit);
$Form->set_InputStyleClass($FormularName,$InputName_CheckitLimit,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_CheckitLimit,___("Limit"));
$Form->set_InputReadonly($FormularName,$InputName_CheckitLimit,false);
$Form->set_InputOrder($FormularName,$InputName_CheckitLimit,13);
$Form->set_InputLabel($FormularName,$InputName_CheckitLimit,"");
$Form->set_InputSize($FormularName,$InputName_CheckitLimit,0,1);
$Form->set_InputMultiple($FormularName,$InputName_CheckitLimit,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_CheckitLimit,1,"1");
$Form->add_InputOption($FormularName,$InputName_CheckitLimit,10,"10");
$Form->add_InputOption($FormularName,$InputName_CheckitLimit,25,"25");
$Form->add_InputOption($FormularName,$InputName_CheckitLimit,50,"50");
$Form->add_InputOption($FormularName,$InputName_CheckitLimit,100,"100");
$Form->add_InputOption($FormularName,$InputName_CheckitLimit,250,"250");
$Form->add_InputOption($FormularName,$InputName_CheckitLimit,500,"500");
$Form->add_InputOption($FormularName,$InputName_CheckitLimit,1000,"1000");

//BounceitLimit
$Form->new_Input($FormularName,$InputName_BounceitLimit,"select", "");
$Form->set_InputJS($FormularName,$InputName_BounceitLimit," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_BounceitLimit,$$InputName_BounceitLimit);
$Form->set_InputStyleClass($FormularName,$InputName_BounceitLimit,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_BounceitLimit,___("Limit"));
$Form->set_InputReadonly($FormularName,$InputName_BounceitLimit,false);
$Form->set_InputOrder($FormularName,$InputName_BounceitLimit,18);
$Form->set_InputLabel($FormularName,$InputName_BounceitLimit,"");
$Form->set_InputSize($FormularName,$InputName_BounceitLimit,0,1);
$Form->set_InputMultiple($FormularName,$InputName_BounceitLimit,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_BounceitLimit,1,"1");
$Form->add_InputOption($FormularName,$InputName_BounceitLimit,10,"10");
$Form->add_InputOption($FormularName,$InputName_BounceitLimit,25,"25");
$Form->add_InputOption($FormularName,$InputName_BounceitLimit,50,"50");
$Form->add_InputOption($FormularName,$InputName_BounceitLimit,100,"100");
$Form->add_InputOption($FormularName,$InputName_BounceitLimit,250,"250");
$Form->add_InputOption($FormularName,$InputName_BounceitLimit,500,"500");
$Form->add_InputOption($FormularName,$InputName_BounceitLimit,1000,"1000");


//checkit_mail_from etc
$Form->new_Input($FormularName,$InputName_CheckitFromEmail,"text", $$InputName_CheckitFromEmail);
$Form->set_InputJS($FormularName,$InputName_CheckitFromEmail," onChange=\"flash('submit','#ff0000');\" onkeyup=\"RemoveInvalidChars(this, '[^A-Za-z0-9\_\@\.\-]'); ForceLowercase(this);\"");
$Form->set_InputStyleClass($FormularName,$InputName_CheckitFromEmail,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_CheckitFromEmail,48,256);
$Form->set_InputDesc($FormularName,$InputName_CheckitFromEmail,___("E-Mail-Adresse für Prüfung (Validate/MAIL FROM:)"));
$Form->set_InputReadonly($FormularName,$InputName_CheckitFromEmail,false);
$Form->set_InputOrder($FormularName,$InputName_CheckitFromEmail,16);
$Form->set_InputLabel($FormularName,$InputName_CheckitFromEmail,"");

//checkit reset error
$Form->new_Input($FormularName,$InputName_CheckitAdrResetError,"checkbox", 1);
$Form->set_InputJS($FormularName,$InputName_CheckitAdrResetError," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_CheckitAdrResetError,$$InputName_CheckitAdrResetError);
$Form->set_InputStyleClass($FormularName,$InputName_CheckitAdrResetError,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_CheckitAdrResetError,48,256);
$Form->set_InputDesc($FormularName,$InputName_CheckitAdrResetError,___("Wenn OK, Fehler zurücksetzen"));
$Form->set_InputReadonly($FormularName,$InputName_CheckitAdrResetError,false);
$Form->set_InputOrder($FormularName,$InputName_CheckitAdrResetError,17);
$Form->set_InputLabel($FormularName,$InputName_CheckitAdrResetError,"");

//checkit reset status
$Form->new_Input($FormularName,$InputName_CheckitAdrResetStatus,"checkbox", 1);
$Form->set_InputJS($FormularName,$InputName_CheckitAdrResetStatus," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_CheckitAdrResetStatus,$$InputName_CheckitAdrResetStatus);
$Form->set_InputStyleClass($FormularName,$InputName_CheckitAdrResetStatus,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_CheckitAdrResetStatus,48,256);
$Form->set_InputDesc($FormularName,$InputName_CheckitAdrResetStatus,___("Wenn OK, Status zurücksetzen"));
$Form->set_InputReadonly($FormularName,$InputName_CheckitAdrResetStatus,false);
$Form->set_InputOrder($FormularName,$InputName_CheckitAdrResetStatus,18);
$Form->set_InputLabel($FormularName,$InputName_CheckitAdrResetStatus,"");

//Bounce HOST
$Form->new_Input($FormularName,$InputName_BounceitHost,"select", "");
$Form->set_InputJS($FormularName,$InputName_BounceitHost," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_BounceitHost,$$InputName_BounceitHost);
$Form->set_InputStyleClass($FormularName,$InputName_BounceitHost,"mFormSelect","mFormSelectFocus");
$Form->set_InputSize($FormularName,$InputName_BounceitHost,1,1);
$Form->set_InputDesc($FormularName,$InputName_BounceitHost,___("Host auswählen"));
$Form->set_InputReadonly($FormularName,$InputName_BounceitHost,false);
$Form->set_InputOrder($FormularName,$InputName_BounceitHost,20);
$Form->set_InputLabel($FormularName,$InputName_BounceitHost,"");
$Form->set_InputMultiple($FormularName,$InputName_BounceitHost,false);
#Hostliste....
//pop3 hosts
$HOST_=$HOSTS->getHost("",Array("aktiv"=>1, "type"=>"imap"));//id,filter
$hcg=count($HOST_);
for ($hccg=0; $hccg<$hcg; $hccg++)
{
		$Form->add_InputOption($FormularName,$InputName_BounceitHost,$HOST_[$hccg]['id'],$HOST_[$hccg]['name']);
}
//imap hosts
$HOST_=$HOSTS->getHost("",Array("aktiv"=>1, "type"=>"pop3"));//id,filter
$hcg=count($HOST_);
for ($hccg=0; $hccg<$hcg; $hccg++)
{
		$Form->add_InputOption($FormularName,$InputName_BounceitHost,$HOST_[$hccg]['id'],$HOST_[$hccg]['name']);
}

//Aktion Bounce
$Form->new_Input($FormularName,$InputName_BounceitAction,"select", "");
$Form->set_InputDefault($FormularName,$InputName_BounceitAction,$$InputName_BounceitAction);
$Form->set_InputStyleClass($FormularName,$InputName_BounceitAction,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_BounceitAction,___("Aktion ausführen"));
$Form->set_InputReadonly($FormularName,$InputName_BounceitAction,false);
$Form->set_InputOrder($FormularName,$InputName_BounceitAction,22);
$Form->set_InputLabel($FormularName,$InputName_BounceitAction,"");
$Form->set_InputSize($FormularName,$InputName_BounceitAction,0,1);
$Form->set_InputMultiple($FormularName,$InputName_BounceitAction,false);
$Form->add_InputOption($FormularName,$InputName_BounceitAction,"auto",___("Adressen automatisch bearbeiten"));
$Form->add_InputOption($FormularName,$InputName_BounceitAction,"error",___("Adressen als Fehlerhaft markieren"));
$Form->add_InputOption($FormularName,$InputName_BounceitAction,"unsubscribe",___("Adressen abmelden und deaktivieren"));
$Form->add_InputOption($FormularName,$InputName_BounceitAction,"aktiv",___("Adressen deaktivieren"));
$Form->add_InputOption($FormularName,$InputName_BounceitAction,"delete",___("Adressen löschen"));

//bounce filter to?
$Form->new_Input($FormularName,$InputName_BounceitFilterTo,"checkbox", 1);
$Form->set_InputJS($FormularName,$InputName_BounceitFilterTo," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_BounceitFilterTo,$$InputName_BounceitFilterTo);
$Form->set_InputStyleClass($FormularName,$InputName_BounceitFilterTo,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_BounceitFilterTo,48,256);
$Form->set_InputDesc($FormularName,$InputName_BounceitFilterTo,___("nur Mails an TO: bearbeiten"));
$Form->set_InputReadonly($FormularName,$InputName_BounceitFilterTo,false);
$Form->set_InputOrder($FormularName,$InputName_BounceitFilterTo,24);
$Form->set_InputLabel($FormularName,$InputName_BounceitFilterTo,"");

//bounce email to adr
$Form->new_Input($FormularName,$InputName_BounceitFilterToEmail,"text", $$InputName_BounceitFilterToEmail);
$Form->set_InputJS($FormularName,$InputName_BounceitFilterToEmail," onChange=\"flash('submit','#ff0000');\" onkeyup=\"RemoveInvalidChars(this, '[^A-Za-z0-9\_\@\.\-]'); ForceLowercase(this);\"");
$Form->set_InputStyleClass($FormularName,$InputName_BounceitFilterToEmail,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_BounceitFilterToEmail,48,256);
$Form->set_InputDesc($FormularName,$InputName_BounceitFilterToEmail,___("Filter E-Mail-Adresse für Bouncemanagement)"));
$Form->set_InputReadonly($FormularName,$InputName_BounceitFilterToEmail,false);
$Form->set_InputOrder($FormularName,$InputName_BounceitFilterToEmail,25);
$Form->set_InputLabel($FormularName,$InputName_BounceitFilterToEmail,"");

//bounce method, type: header, body, body&header
$Form->new_Input($FormularName,$InputName_BounceitSearch,"select", "");
$Form->set_InputJS($FormularName,$InputName_BounceitSearch," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_BounceitSearch,$$InputName_BounceitSearch);
$Form->set_InputStyleClass($FormularName,$InputName_BounceitSearch,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_BounceitSearch,___("Bounce: suche nach Adressen"));
$Form->set_InputReadonly($FormularName,$InputName_BounceitSearch,false);
$Form->set_InputOrder($FormularName,$InputName_BounceitSearch,23);
$Form->set_InputLabel($FormularName,$InputName_BounceitSearch,"");
$Form->set_InputSize($FormularName,$InputName_BounceitSearch,0,1);
$Form->set_InputMultiple($FormularName,$InputName_BounceitSearch,false);
$Form->add_InputOption($FormularName,$InputName_BounceitSearch,"header",___("nur E-MailHeader"));
$Form->add_InputOption($FormularName,$InputName_BounceitSearch,"body",___("nur E-Mail-Body"));
$Form->add_InputOption($FormularName,$InputName_BounceitSearch,"headerbody","E-Mail-Header und -Body");

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

/* send / newsletter */

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td style=\"border-top:2px solid grey; font-weight:bold;\" valign=\"top\" colspan=2>";
$_MAIN_OUTPUT.= ___("Allgemein / Sonstiges");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("information.png",___("Versionsabfrage und News"))."&nbsp;".___("Versionsabfrage und News auf der Startseite");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_CheckVersion]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td style=\"border-top:2px solid grey; font-weight:bold;\" valign=\"top\" colspan=2>";
$_MAIN_OUTPUT.= ___("Newsletter")." &amp; ".___("Versand");
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
$_MAIN_OUTPUT.= tm_icon("spellcheck.png",___("E-Mail-Prüfung"))."&nbsp;".___("Prüfung der E-Mail-Adressen, Intern");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_ECheckIntern]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("spellcheck.png",___("E-Mail-Prüfung"))."&nbsp;".___("Prüfung der E-Mail-Adressen beim Versand");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_ECheckSendit]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("cog_error.png",___("Sendeversuche per E-Mail"))."&nbsp;".___("Maximale Versuche pro E-Mail (Gesamt)");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_MaxRetry]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("picture.png",___("Tracking Bild"))."&nbsp;".___("Blind- bzw. Tracking Bild auswählen oder neues Bild hochladen");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_TrackImageExisting]['html']."&nbsp; oder<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_TrackImageNew]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

/* Subscribe / Unsubscribe */

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td style=\"border-top:2px solid grey; font-weight:bold;\" valign=\"top\" colspan=2>";
$_MAIN_OUTPUT.= ___("Anmelden / Abmelden");
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
$_MAIN_OUTPUT.= "<td valign=\"top\">";
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
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("sport_8ball.png",___("Bestätigungsmail"))."&nbsp;".___("Bestätigungsmail senden");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_UnsubSendMail]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("sport_8ball.png",___("Aktion"))."&nbsp;".___("Aktion beim Abmelden");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_UnsubAction]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("sport_8ball.png",___("Captcha"))."&nbsp;".___("Captcha/Spamcode im Abmeldeformular prüfen");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_UnsubUseCaptcha]['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_UnsubDigitsCaptcha]['html'];
$_MAIN_OUTPUT.= ___("Ziffern");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

/* Checkit */

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td style=\"border-top:2px solid grey; font-weight:bold;\" valign=\"top\" colspan=2>";
$_MAIN_OUTPUT.= ___("Automatische Prüfung via check_it.php");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("control_end.png",___("Limit"))."&nbsp;".___("Anzahl zu prüfender Adressen in einem Durchlauf");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_CheckitLimit]['html']."&nbsp;".___("Adressen");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("spellcheck.png",___("E-Mail-Prüfung"))."&nbsp;".___("Prüfung der E-Mail-Adressen bei automatischer Prüfung");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_ECheckCheckit]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("email_go.png",___("Checkit MAIL FROM:"))."&nbsp;".___("Absender für Prüfung der E-Mail-Adressen bei automatischer Prüfung");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_CheckitFromEmail]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("cog_error.png",___("Fehler zurücksetzen"))."&nbsp;".___("Wenn Prüfung, Fehler zurücksetzen");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_CheckitAdrResetError]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("bullet_black.png",___("Status zurücksetzen"))."&nbsp;".___("Wenn Prüfung OK, Status zurücksetzen");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_CheckitAdrResetStatus]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

/* AutoBounce */

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td style=\"border-top:2px solid grey; font-weight:bold;\" valign=\"top\" colspan=2>";
$_MAIN_OUTPUT.= ___("Automatisches Bouncemanagement via bounce_it.php");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= tm_icon("control_end.png",___("Limit"))."&nbsp;".___("Anzahl zu prüfender Mails in einem Durchlauf");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_BounceitLimit]['html']."&nbsp;".___("Mails");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("server.png",___("Host für Bouncemanagement"))."&nbsp;".___("Host für automatisches Bouncemanagement");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_BounceitHost]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("sport_soccer.png",___("Aktion für Bouncemanagement"))."&nbsp;".___("Aktion für automatisches Bouncemanagement");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_BounceitAction]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("sport_soccer.png",___("Bounce: suche nach Adressen"))."&nbsp;".___("Suche nach Adressen");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_BounceitSearch]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("email.png",___("E-Mail-Adresse (TO:) für Bouncemanagement"))."&nbsp;".___("Filtern nach E-Mail-Adrese (TO:)");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_BounceitFilterTo]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("email_go.png",___("E-Mail-Adresse (TO:) für Bouncemanagement"))."&nbsp;".___("Filter  E-Mail-Adrese (TO:)");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_BounceitFilterToEmail]['html'];
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