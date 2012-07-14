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

$_MAIN_DESCR=___("Neuen Newsletter erstellen");
$_MAIN_MESSAGE.="";

$set=getVar("set");
$nl_id=0;
$created=date("Y-m-d H:i:s");
$author=$LOGIN->USER['name'];

//field names for query
$InputName_File="file";//datei
pt_register("POST","file");

$InputName_Image1="image1";//bild1
pt_register("POST","image1");

$InputName_Attach1="attach1";//bild1
pt_register("POST","attach1");

//field names for query
$InputName_Name="subject";//betreff
$$InputName_Name=getVar($InputName_Name);

$InputName_Massmail="massmail";//betreff
$$InputName_Massmail=getVar($InputName_Massmail);

$InputName_Descr="body";//range from
$$InputName_Descr=getVar($InputName_Descr,0);//varname,slashes? 0=dont add slashes

$InputName_Aktiv="aktiv";//range from
$$InputName_Aktiv=getVar($InputName_Aktiv);

$InputName_Link="link";//link
$$InputName_Link=getVar($InputName_Link);

$InputName_ContentType="content_type";
$$InputName_ContentType=getVar($InputName_ContentType);

$InputName_Group="nl_grp_id";//range from
$$InputName_Group=getVar($InputName_Group);

$InputName_TrackImageNew="track_image_new";//trackimage upload
pt_register("POST","track_image_new");

$InputName_TrackImageExisting="track_image_existing";//trackimage auswahl
$$InputName_TrackImageExisting=getVar($InputName_TrackImageExisting);


$check=true;
if ($set=="save") {
	//checkinput
	if (empty($subject)) {$check=false;$_MAIN_MESSAGE.="<br>".___("Betreff sollte nicht leer sein.");}

	//upload ?!
	include_once (TM_INCLUDEPATH."/nl_upload.inc.php");

	$track_image="";
	if ($uploaded_track_image_new) {
		$track_image="/".$uploaded_track_image_new_name;
	} else {
		$track_image=$track_image_existing;
	}

	if ($check) {
		$status=1;
		$NEWSLETTER=new tm_NL();
		$NEWSLETTER->addNL(
								Array(
									"subject"=>$subject,
									"body"=>$body,
									"aktiv"=>$aktiv,
									"status"=>$status,
									"massmail"=>$massmail,
									"link"=>$link,
									"created"=>$created,
									"author"=>$author,
									"grp_id"=>$nl_grp_id,
									"attm"=>$attach_ext,
									"content_type"=>$content_type,
									"track_image"=>$track_image
									)
								);
		$_MAIN_MESSAGE.="<br>".sprintf(___("Neuer Newsletter %s wurde erstellt."),"'<b>".display($subject)."</b>'");
		$_MAIN_MESSAGE.= "<br>".___("Der Newsletter wurde gespeichert unter:").
				"<ul>".
				___("Template:")." <a href=\"".$tm_nldir."/".$NL_Filename_N."\" target=\"_preview\">".$tm_nldir."/".$NL_Filename_N."</a>".
				"<br>".
				___("Online:")." <a href=\"".$tm_nldir."/".$NL_Filename_P."\"  target=\"_preview\">".$tm_nldir."/".$NL_Filename_P."</a>".
				"</ul>";
		$action="nl_list";
		include_once (TM_INCLUDEPATH."/nl_list.inc.php");
	} else {
		$body=stripslashes(strtr($body, $trans));
		include_once (TM_INCLUDEPATH."/nl_form.inc.php");
	}

} else {
	include_once (TM_INCLUDEPATH."/nl_form.inc.php");
}
?>