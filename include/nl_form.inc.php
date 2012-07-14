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
$Form->set_InputOrder($FormularName,$InputName_File,9);
$Form->set_InputLabel($FormularName,$InputName_File,"");
//File 2, image
$Form->new_Input($FormularName,$InputName_Image1,"file", "");
$Form->set_InputJS($FormularName,$InputName_Image1," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Image1,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Image1,48,48);
$Form->set_InputDesc($FormularName,$InputName_Image1,___("Bild hochladen")." {IMAGE1}");
$Form->set_InputReadonly($FormularName,$InputName_Image1,false);
$Form->set_InputOrder($FormularName,$InputName_Image1,8);
$Form->set_InputLabel($FormularName,$InputName_Image1,"");
//File 3, Attachement
$Form->new_Input($FormularName,$InputName_Attach1,"file", "");
$Form->set_InputJS($FormularName,$InputName_Attach1," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Attach1,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Attach1,8,255);
$Form->set_InputDesc($FormularName,$InputName_Attach1,___("Anhang hochladen")." {ATTACH1}");
$Form->set_InputReadonly($FormularName,$InputName_Attach1,false);
$Form->set_InputOrder($FormularName,$InputName_Attach1,12);
$Form->set_InputLabel($FormularName,$InputName_Attach1,"");

//Watermark?
$Form->new_Input($FormularName,$InputName_ImageWatermark,"checkbox", 1);
$Form->set_InputJS($FormularName,$InputName_ImageWatermark," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_ImageWatermark,$$InputName_ImageWatermark);
$Form->set_InputStyleClass($FormularName,$InputName_ImageWatermark,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_ImageWatermark,48,48);
$Form->set_InputDesc($FormularName,$InputName_ImageWatermark,___("Wasserzeichen hinzufügen"));
$Form->set_InputReadonly($FormularName,$InputName_ImageWatermark,false);
$Form->set_InputOrder($FormularName,$InputName_ImageWatermark,4);
$Form->set_InputLabel($FormularName,$InputName_ImageWatermark,"");

//Select Watermark Image
$Form->new_Input($FormularName,$InputName_ImageWatermarkImage,"select", "watermark.png");
$Form->set_InputJS($FormularName,$InputName_ImageWatermarkImage," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_ImageWatermarkImage,basename($$InputName_ImageWatermarkImage));
$Form->set_InputStyleClass($FormularName,$InputName_ImageWatermarkImage,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_ImageWatermarkImage,___("Wasserzeichen-Bild auswählen"));
$Form->set_InputReadonly($FormularName,$InputName_ImageWatermarkImage,false);
$Form->set_InputOrder($FormularName,$InputName_ImageWatermarkImage,10);
$Form->set_InputLabel($FormularName,$InputName_ImageWatermarkImage,"");
$Form->set_InputSize($FormularName,$InputName_ImageWatermarkImage,0,1);
$Form->set_InputMultiple($FormularName,$InputName_ImageWatermarkImage,false);
//add Data
$WatermarkImg_Files=getFiles(TM_IMGPATH) ;
foreach ($WatermarkImg_Files as $field) {
	$btsort[]=$field['name'];
}
@array_multisort($btsort, SORT_ASC, $WatermarkImg_Files, SORT_ASC);
$ic= count($WatermarkImg_Files);
for ($icc=0; $icc < $ic; $icc++) {
		//only png files for watermark are accepted
		if (preg_match ("/.png$/i", $WatermarkImg_Files[$icc]['name']) || preg_match ("/.PNG$/i", $WatermarkImg_Files[$icc]['name'])) {
			$Form->add_InputOption($FormularName,$InputName_ImageWatermarkImage,$WatermarkImg_Files[$icc]['name'],display($WatermarkImg_Files[$icc]['name']));
		}
}

//Resize?
$Form->new_Input($FormularName,$InputName_ImageResize,"checkbox", 1);
$Form->set_InputJS($FormularName,$InputName_ImageResize," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_ImageResize,$$InputName_ImageResize);
$Form->set_InputStyleClass($FormularName,$InputName_ImageResize,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_ImageResize,48,48);
$Form->set_InputDesc($FormularName,$InputName_ImageResize,___("Größe ändern"));
$Form->set_InputReadonly($FormularName,$InputName_ImageResize,false);
$Form->set_InputOrder($FormularName,$InputName_ImageResize,4);
$Form->set_InputLabel($FormularName,$InputName_ImageResize,"");

//Resize Size
$Form->new_Input($FormularName,$InputName_ImageResizeSize,"text", display($$InputName_ImageResizeSize));
$Form->set_InputJS($FormularName,$InputName_ImageResizeSize," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_ImageResizeSize,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_ImageResizeSize,5,3);
$Form->set_InputDesc($FormularName,$InputName_ImageResizeSize,___("Neue Größe"));
$Form->set_InputReadonly($FormularName,$InputName_ImageResizeSize,false);
$Form->set_InputOrder($FormularName,$InputName_ImageResizeSize,1);
$Form->set_InputLabel($FormularName,$InputName_ImageResizeSize,"");

//existing attachements
$Form->new_Input($FormularName,$InputName_AttachExisting,"select", "");
$Form->set_InputJS($FormularName,$InputName_AttachExisting," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_AttachExisting,basename($$InputName_AttachExisting));
$Form->set_InputStyleClass($FormularName,$InputName_AttachExisting,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_AttachExisting,___("Anhänge auswählen, Strg/Ctrl+Klick f. Mehrfachauswahl"));
$Form->set_InputReadonly($FormularName,$InputName_AttachExisting,false);
$Form->set_InputOrder($FormularName,$InputName_AttachExisting,22);
$Form->set_InputLabel($FormularName,$InputName_AttachExisting,"");
$Form->set_InputSize($FormularName,$InputName_AttachExisting,0,24);
$Form->set_InputMultiple($FormularName,$InputName_AttachExisting,true);
//add Data
$Attm_Dirs=getDirectories($tm_nlattachpath) ;
foreach ($Attm_Dirs as $field) {
	$btsort[]=$field['name'];
}
@array_multisort($btsort, SORT_ASC, $Attm_Dirs, SORT_ASC);
$dc= count($Attm_Dirs);
for ($dcc=0; $dcc < $dc; $dcc++) {
	$a_path=$tm_nlattachpath;
	if ($Attm_Dirs[$dcc]['name']!="CVS") {
		if (!empty($Attm_Dirs[$dcc]['name'])) {
			$a_path.="/".$Attm_Dirs[$dcc]['name'];
		}
		$Attm_Files=getFiles($a_path) ;
		foreach ($Attm_Files as $field) {
			$btsort[]=$field['name'];
		}
		@array_multisort($btsort, SORT_ASC, $Attm_Files, SORT_ASC);
		$ic= count($Attm_Files);
		for ($icc=0; $icc < $ic; $icc++) {
			if ($Attm_Files[$icc]['name']!=".htaccess" && $Attm_Files[$icc]['name']!="index.php" && $Attm_Files[$icc]['name']!="index.html") {
				$a_file=$Attm_Files[$icc]['name'];
				if (!empty($Attm_Dirs[$dcc]['name']) && $Attm_Dirs[$dcc]['name']!=".") {
					$a_file=$Attm_Dirs[$dcc]['name']."/".$Attm_Files[$icc]['name'];
				}

				$Form->add_InputOption($FormularName,$InputName_AttachExisting,$a_file,display($Attm_Files[$icc]['name'])." (".formatFileSize($Attm_Files[$icc]['size']).")",display($Attm_Dirs[$dcc]['name']));
			}//if Attm name
		}//for  lcc
	}//if attmdir name
}//for dcc

//Subject
$Form->new_Input($FormularName,$InputName_Name,"text", display($$InputName_Name));
$Form->set_InputJS($FormularName,$InputName_Name," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Name,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Name,48,255);
$Form->set_InputDesc($FormularName,$InputName_Name,___("Erscheint als Betreff in der e-Mail"));
$Form->set_InputReadonly($FormularName,$InputName_Name,false);
$Form->set_InputOrder($FormularName,$InputName_Name,1);
$Form->set_InputLabel($FormularName,$InputName_Name,"");

//Titel
$Form->new_Input($FormularName,$InputName_Title,"text", display($$InputName_Title));
$Form->set_InputJS($FormularName,$InputName_Title," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Title,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Title,48,255);
$Form->set_InputDesc($FormularName,$InputName_Title,___("Titel (z.Bsp. zur Anzeige auf der Webseite)"));
$Form->set_InputReadonly($FormularName,$InputName_Title,false);
$Form->set_InputOrder($FormularName,$InputName_Title,1);
$Form->set_InputLabel($FormularName,$InputName_Title,"");

//SubTitel
$Form->new_Input($FormularName,$InputName_TitleSub,"text", display($$InputName_TitleSub));
$Form->set_InputJS($FormularName,$InputName_TitleSub," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_TitleSub,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_TitleSub,48,255);
$Form->set_InputDesc($FormularName,$InputName_TitleSub,___("Sub-Titel (z.Bsp. zur Anzeige auf der Webseite)"));
$Form->set_InputReadonly($FormularName,$InputName_TitleSub,false);
$Form->set_InputOrder($FormularName,$InputName_TitleSub,1);
$Form->set_InputLabel($FormularName,$InputName_TitleSub,"");


//Link
$Form->new_Input($FormularName,$InputName_Link,"text", display($$InputName_Link));
$Form->set_InputJS($FormularName,$InputName_Link," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Link,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Link,48,1024);
$Form->set_InputDesc($FormularName,$InputName_Link,___("Link")." {LINK1}");
$Form->set_InputReadonly($FormularName,$InputName_Link,false);
$Form->set_InputOrder($FormularName,$InputName_Link,7);
$Form->set_InputLabel($FormularName,$InputName_Link,"");

//Aktiv
	$Form->new_Input($FormularName,$InputName_Aktiv,"checkbox", 1);
	$Form->set_InputJS($FormularName,$InputName_Aktiv," onChange=\"flash('submit','#ff0000');\" ");
	$Form->set_InputDefault($FormularName,$InputName_Aktiv,$$InputName_Aktiv);
	$Form->set_InputStyleClass($FormularName,$InputName_Aktiv,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_Aktiv,48,48);
	$Form->set_InputDesc($FormularName,$InputName_Aktiv,___("Aktiv"));
	$Form->set_InputReadonly($FormularName,$InputName_Aktiv,false);
	$Form->set_InputOrder($FormularName,$InputName_Aktiv,4);
	$Form->set_InputLabel($FormularName,$InputName_Aktiv,"");

//Template?
	$Form->new_Input($FormularName,$InputName_Template,"checkbox", 1);
	$Form->set_InputJS($FormularName,$InputName_Template," onChange=\"flash('submit','#ff0000');\" ");
	$Form->set_InputDefault($FormularName,$InputName_Template,$$InputName_Template);
	$Form->set_InputStyleClass($FormularName,$InputName_Template,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_Template,48,48);
	$Form->set_InputDesc($FormularName,$InputName_Template,___("Aktiv"));
	$Form->set_InputReadonly($FormularName,$InputName_Template,false);
	$Form->set_InputOrder($FormularName,$InputName_Template,4);
	$Form->set_InputLabel($FormularName,$InputName_Template,"");


//Massenmail!?
$Form->new_Input($FormularName,$InputName_Massmail,"select", "");
$Form->set_InputJS($FormularName,$InputName_Massmail," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_Massmail,$$InputName_Massmail);
$Form->set_InputStyleClass($FormularName,$InputName_Massmail,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Massmail,___("Mailing-Typ"));
$Form->set_InputReadonly($FormularName,$InputName_Massmail,false);
$Form->set_InputOrder($FormularName,$InputName_Massmail,4);
$Form->set_InputLabel($FormularName,$InputName_Massmail,"");
$Form->set_InputSize($FormularName,$InputName_Massmail,0,1);
$Form->set_InputMultiple($FormularName,$InputName_Massmail,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_Massmail,0,"Personalisiertes Newsletter (einzelne Mails)");
$Form->add_InputOption($FormularName,$InputName_Massmail,1,"Massenmailing (per BCC, nicht personalisiert)");

//Content html
$Form->new_Input($FormularName,$InputName_Descr,"textarea", $$InputName_Descr);
$Form->set_InputJS($FormularName,$InputName_Descr," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Descr,"mFormTextarea_Content","mFormTextareaFocus_Content");
$Form->set_InputSize($FormularName,$InputName_Descr,180,50);
$Form->set_InputDesc($FormularName,$InputName_Descr,___("Newsletter-Text")." (html)");
$Form->set_InputReadonly($FormularName,$InputName_Descr,false);
$Form->set_InputOrder($FormularName,$InputName_Descr,16);
$Form->set_InputLabel($FormularName,$InputName_Descr,"");

//Content text
$Form->new_Input($FormularName,$InputName_DescrText,"textarea", $$InputName_DescrText);
$Form->set_InputJS($FormularName,$InputName_DescrText," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_DescrText,"mFormTextarea_Content","mFormTextareaFocus_Content");
$Form->set_InputSize($FormularName,$InputName_DescrText,180,30);
$Form->set_InputDesc($FormularName,$InputName_DescrText,___("Newsletter-Text")." (text)");
$Form->set_InputReadonly($FormularName,$InputName_DescrText,false);
$Form->set_InputOrder($FormularName,$InputName_DescrText,15);
$Form->set_InputLabel($FormularName,$InputName_DescrText,"");

//Summary
$Form->new_Input($FormularName,$InputName_Summary,"textarea", $$InputName_Summary);
$Form->set_InputJS($FormularName,$InputName_Summary," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Summary,"mFormTextarea_Content","mFormTextareaFocus_Content");
$Form->set_InputSize($FormularName,$InputName_Summary,180,8);
$Form->set_InputDesc($FormularName,$InputName_Summary,___("Zusammenfassung")." (html)");
$Form->set_InputReadonly($FormularName,$InputName_Summary,false);
$Form->set_InputOrder($FormularName,$InputName_Summary,16);
$Form->set_InputLabel($FormularName,$InputName_Summary,"");


//Gruppe
$Form->new_Input($FormularName,$InputName_Group,"select", "");
$Form->set_InputJS($FormularName,$InputName_Group," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_Group,$nl_grp_id);
$Form->set_InputStyleClass($FormularName,$InputName_Group,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Group,___("Newsletter-Gruppe waehlen"));
$Form->set_InputReadonly($FormularName,$InputName_Group,false);
$Form->set_InputOrder($FormularName,$InputName_Group,6);
$Form->set_InputLabel($FormularName,$InputName_Group,"");
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
$Form->set_InputDefault($FormularName,$InputName_TrackImageExisting,basename($$InputName_TrackImageExisting));
$Form->set_InputStyleClass($FormularName,$InputName_TrackImageExisting,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_TrackImageExisting,___("Blind-/Tracking-Bild auswählen"));
$Form->set_InputReadonly($FormularName,$InputName_TrackImageExisting,false);
$Form->set_InputOrder($FormularName,$InputName_TrackImageExisting,10);
$Form->set_InputLabel($FormularName,$InputName_TrackImageExisting,"");
$Form->set_InputSize($FormularName,$InputName_TrackImageExisting,0,1);
$Form->set_InputMultiple($FormularName,$InputName_TrackImageExisting,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_TrackImageExisting,"_global","-- GLOBAL --");
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
$Form->set_InputDesc($FormularName,$InputName_TrackImageNew,___("neues Bild hochladen")." {IMAGE1}");
$Form->set_InputReadonly($FormularName,$InputName_TrackImageNew,false);
$Form->set_InputOrder($FormularName,$InputName_TrackImageNew,11);
$Form->set_InputLabel($FormularName,$InputName_TrackImageNew,"");

//Content_Type
$Form->new_Input($FormularName,$InputName_ContentType,"select", "");
$Form->set_InputJS($FormularName,$InputName_ContentType," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_ContentType,$$InputName_ContentType);
$Form->set_InputStyleClass($FormularName,$InputName_ContentType,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_ContentType,___("Format"));
$Form->set_InputReadonly($FormularName,$InputName_ContentType,false);
$Form->set_InputOrder($FormularName,$InputName_ContentType,4);
$Form->set_InputLabel($FormularName,$InputName_ContentType,"");
$Form->set_InputSize($FormularName,$InputName_ContentType,0,1);
$Form->set_InputMultiple($FormularName,$InputName_ContentType,false);
//add Data
$Form->add_InputOption($FormularName,$InputName_ContentType,"text/html","TEXT/HTML");
$Form->add_InputOption($FormularName,$InputName_ContentType,"html","HTML");
$Form->add_InputOption($FormularName,$InputName_ContentType,"text","TEXT");

//rcpt_name etc
$Form->new_Input($FormularName,$InputName_RCPTName,"text", display($$InputName_RCPTName));
$Form->set_InputJS($FormularName,$InputName_RCPTName," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_RCPTName,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_RCPTName,48,256);
$Form->set_InputDesc($FormularName,$InputName_RCPTName,___("Erscheint als Empfängername in der E-Mail"));
$Form->set_InputReadonly($FormularName,$InputName_RCPTName,false);
$Form->set_InputOrder($FormularName,$InputName_RCPTName,2);
$Form->set_InputLabel($FormularName,$InputName_RCPTName,"");

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

	$_MAIN_OUTPUT.= "<tr>";
	$_MAIN_OUTPUT.= "<td colspan=\"2\">";
if (!empty($nl_id)) {
	$_MAIN_OUTPUT.= "ID: <b>".$NL[0]['id']."</b>";
	$_MAIN_OUTPUT.= "<br>";
	$_MAIN_OUTPUT.= sprintf(___("Erstellt am: %s von %s"),"<b>".$NL[0]['created']."</b>","<b>".$NL[0]['author']."</b>");
	$_MAIN_OUTPUT.= "<br>";
	$_MAIN_OUTPUT.= sprintf(___("Bearbeitet am: %s von %s"),"<b>".$NL[0]['updated']."</b>","<b>".$NL[0]['editor']."</b>");
}
	$_MAIN_OUTPUT.= "<br><br>";
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td valign=\"top\"  rowspan=15>";
	$_MAIN_OUTPUT.= tm_icon("disk.png",___("Anhänge"))."&nbsp;".___("Anhänge");
	$_MAIN_OUTPUT.= "<br>";
	$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_AttachExisting]['html'];
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("textfield_rename.png",___("Vorlage"))."&nbsp;".___("Vorlage");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Template]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("tick.png",___("Aktiv")).tm_icon("cancel.png",___("Inaktiv"))."&nbsp;".___("Aktiv");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Aktiv]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";


$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\" width=\"200\">";
$_MAIN_OUTPUT.= tm_icon("sum.png",___("Betreff"))."&nbsp;".___("Betreff");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Name]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\" width=\"200\">";
$_MAIN_OUTPUT.= tm_icon("textfield.png",___("Titel"))."&nbsp;".___("Titel");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Title]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\" width=\"200\">";
$_MAIN_OUTPUT.= tm_icon("textfield.png",___("Sub-Titel"))."&nbsp;".___("Sub-Titel");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_TitleSub]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\" width=\"200\">";
$_MAIN_OUTPUT.= tm_icon("user_comment.png",___("Empfängername"))."&nbsp;".___("Empfängername");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_RCPTName]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("page_white_office.png",___("Format"))."&nbsp;".___("Format");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_ContentType]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("lorry.png",___("Massenmailing")).tm_icon("user_suit.png",___("personalisiertes Newsletter"))."&nbsp;".___("Mailing-Typ");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Massmail]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("book.png",___("Gruppe"))."&nbsp;".___("Gruppe");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Group]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("page_white_link.png",___("Link"))."&nbsp;".___("Link");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Link]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("photo.png",___("Bild"))."&nbsp;".___("Bild");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Image1]['html'];

$_MAIN_OUTPUT.= "<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_ImageResize]['html'];
$_MAIN_OUTPUT.= ___("Neue Größe").":&nbsp;";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_ImageResizeSize]['html'];
$_MAIN_OUTPUT.= "px";
$_MAIN_OUTPUT.= "<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_ImageWatermark]['html'];
$_MAIN_OUTPUT.= ___("Wasserzeichen").":&nbsp;<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_ImageWatermarkImage]['html'];


$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("page_white_world.png",___("HTML"))."&nbsp;".___("HTML");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_File]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("picture_go.png",___("Tracking Bild"))."&nbsp;".___("Blind- bzw. Tracking Bild auswählen oder neues Bild hochladen");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_TrackImageExisting]['html']."&nbsp; oder<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_TrackImageNew]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= tm_icon("attach.png",___("Anhang"))."&nbsp;".___("Neuer Anhang");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=\"top\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Attach1]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\" colspan=3 style=\"border: 1px dashed #cccccc;\">";
$_MAIN_OUTPUT.= tm_icon("page_white_text.png",___("Text"))."&nbsp;".___("Text-Part")."&nbsp;&nbsp;&nbsp;";
$_MAIN_OUTPUT.= "(<a href=\"javascript:switchSection('text_part');\" >".___("Ein-/Ausblenden")."</a>)";
$_MAIN_OUTPUT.= "<div id=\"text_part\">";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_DescrText]['html'];
$_MAIN_OUTPUT.= "</div>";
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\" colspan=3 style=\"border: 1px dashed #cccccc;\">";
$_MAIN_OUTPUT.= tm_icon("page_white_h.png",___("Text"))."&nbsp;".___("HTML-Part")."&nbsp;&nbsp;&nbsp;";
$_MAIN_OUTPUT.= "(<a href=\"javascript:switchSection('html_part');\" >".___("Ein-/Ausblenden")."</a>)";
$_MAIN_OUTPUT.= "<div id=\"html_part\">";
#$_MAIN_OUTPUT.= "<a href=\"#\" onclick=\"loadWysiwyg();\">";
#$_MAIN_OUTPUT.= ___("Lade Wysiwyg Editor");
#$_MAIN_OUTPUT.= "&nbsp;".tm_icon("wand.png",___("Lade Wysiwyg Editor"))."</a>";
$_MAIN_OUTPUT.= "<a href=\"javascript:toggleEditor('".$InputName_Descr."');\" >";
$_MAIN_OUTPUT.= tm_icon("wand.png",___("Editor Ein/Aus"))."&nbsp;".___("Wysiwyg Editor Ein/Aus");
$_MAIN_OUTPUT.= "</a><br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Descr]['html'];
$_MAIN_OUTPUT.= "</div>";
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

//summary
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\" colspan=3 style=\"border: 1px dashed #cccccc;\">";
$_MAIN_OUTPUT.= tm_icon("page_white_zip.png",___("Zusammenfassung"))."&nbsp;".___("Zusammenfassung")."&nbsp;&nbsp;&nbsp;";
$_MAIN_OUTPUT.= "(<a href=\"javascript:switchSection('nl_summary');\" >".___("Ein-/Ausblenden")."</a>)";
$_MAIN_OUTPUT.= "<div id=\"nl_summary\">";
$_MAIN_OUTPUT.= "<a href=\"javascript:toggleEditor('".$InputName_Summary."');\" >";
$_MAIN_OUTPUT.= tm_icon("wand.png",___("Editor Ein/Aus"))."&nbsp;".___("Wysiwyg Editor Ein/Aus");
$_MAIN_OUTPUT.= "</a><br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Summary]['html'];
$_MAIN_OUTPUT.= "</div>";
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";


$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\" colspan=3>&nbsp;";
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\" colspan=3>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Submit]['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Reset]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "</table>";
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['foot'];

$_MAIN_OUTPUT.= "<br><br>";
$_MAIN_OUTPUT.= 
						sprintf(___("%s enthält den das aktuelle Datum zum Zeitpunkt des Versandes. Das Datumsformat wird in tm_lib.inc.php voreingestellt (TM_NL_DATEFORMAT). Standard: d.m.Y, Aktuell: %s"),"<b>{DATE}</b>",TM_NL_DATEFORMAT)."<br>".
						sprintf(___("%s enthält den Titel zur Anzeige auf der Webseite | %s enthält den Untertitel zur Anzeige auf der Webseite"),"<b>{TITLE}</b>","<b>{TITLE_SUB}</b>")."<br>".
						sprintf(___("%s enthält die Zusammenfasung zur Anzeige auf der Webseite"),"<b>{SUMMARY}</b>")."<br>".
						sprintf(___("%s enthält das hochgeladene Bild 'img src' | %s enthält nur die URL zum Bild"),"<b>{IMAGE1}</b>","<b>{IMAGE1_URL}</b>")."<br>".
						sprintf(___("%s enthält den angegebenen Link 'a href' | %s enthält nur die URL des Links"),"<b>{LINK1}</b>","<b>{LINK1_URL}</b>")."<br>".
						sprintf(___("%s enthält die Links zu den Attachements"),"<b>{ATTACHEMENTS}</b>")."<br>".
						sprintf(___("%s enthält den Link zum abmelden |   %s enthält nur die URL zum Abmeldeformular"),"<b>{UNSUBSCRIBE}</b>","<b>{UNSUBSCRIBE_URL}</b>")."<br>".
						sprintf(___("%s enthält den Link zur Onlineversion 'a href' |  %s enthält nur die URL zur Onlineversion"),"<b>{NLONLINE}</b>","<b>{NLONLINE_URL}</b>")."<br>".
						sprintf(___("%s enthält das schliessende TAG '/a' fuer die Links"),"<b>{CLOSELINK}</b>")."<br>".
						"<u>".___("Nur für personalisierten Newsleter:")."</u><br>".
						sprintf(___("%s enthält das Tracker-Bild (für View-Tracking, nur HTML-Mails)"),"<b>{BLINDIMAGE}</b>")."<br>".
						sprintf(___("%s enthält die e-Mailadresse des Empfaengers"),"<b>{EMAIL}</b>")."<br>".
						sprintf(___("%s bis %s enthält die Felder aus den Formularen/Adressen"),"<b>{F0}</b>","<b>{F9}</b>")."<br>".
						sprintf(___("%s enthält den kompletten Link 'a href' zum Aktivierungslink ('(1st)-Touch-Opt-In) | %s enthält nur die URL"),"<b>{SUBSCRIBE}</b>","<b>{SUBSCRIBE_URL}</b>")."<br>".
						"";

	$_MAIN_OUTPUT.= "
		<script language=\"javascript\" type=\"text/javascript\">
		switchSection('html_part');
		switchSection('text_part');
		switchSection('nl_summary');
		//toggleSlide('toggle_nlbody_text','text_part',1);//trigger function erzeugen: triggerid,divid,toggle
		//toggleSlide('toggle_nlbody_html','html_part',1);//trigger function erzeugen: triggerid,divid,toggle
		</script>
	";

include_once (TM_INCLUDEPATH."/wysiwyg.inc.php");

?>