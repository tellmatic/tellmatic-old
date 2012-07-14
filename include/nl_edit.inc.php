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

$_MAIN_DESCR=___("Newsletter bearbeiten");
$_MAIN_MESSAGE.="";

$set=getVar("set");
$nl_id=getVar("nl_id");

//field names for query
$InputName_File="file";//datei
pt_register("POST","file");

$InputName_Image1="image1";//bild1
pt_register("POST","image1");

$InputName_Attach1="attach1";
pt_register("POST","attach1");

$InputName_Name="subject";
$$InputName_Name=getVar($InputName_Name);

$InputName_Massmail="massmail";
$$InputName_Massmail=getVar($InputName_Massmail);

$InputName_Descr="body";
$$InputName_Descr=getVar($InputName_Descr,0);//varname,slashes? 0=no add slashes

$InputName_Aktiv="aktiv";
$$InputName_Aktiv=getVar($InputName_Aktiv);

$InputName_Link="link";
$$InputName_Link=getVar($InputName_Link);

$InputName_ContentType="content_type";
$$InputName_ContentType=getVar($InputName_ContentType);

$InputName_Group="nl_grp_id";
$$InputName_Group=getVar($InputName_Group);

$InputName_TrackImageNew="track_image_new";//trackimage upload
pt_register("POST","track_image_new");

$InputName_TrackImageExisting="track_image_existing";//trackimage auswahl
$$InputName_TrackImageExisting=getVar($InputName_TrackImageExisting);

$NEWSLETTER=new tm_NL();
$NL=$NEWSLETTER->getNL($nl_id);

$created=$NL[0]['created'];
$updated=date("Y-m-d H:i:s");
$author=$LOGIN->USER['name'];

$check=true;
if ($set=="save") {
	//checkinput
	if (empty($subject)) {$check=false;$_MAIN_MESSAGE.=___("Betreff sollte nicht leer sein.");}

	//upload ?!
	include_once ($tm_includepath."/nl_upload.inc.php");

	$track_image="";
	if ($uploaded_track_image_new) {
		$track_image="/".$uploaded_track_image_new_name;
	} else {
		$track_image=$track_image_existing;
	}

	if ($check) {
		//da wir das attachement anhand seiner endung identifizieren muessen, attm nur aktualisieren wenn auch was hochgeladen wurde,
		if (!$uploaded_attach1) {
			//also wenn kein upload... dann endung beibehalten
			$NL=$NEWSLETTER->getNL($nl_id);
			$attach_ext=$NL[0]['attm'];
		}
		$NEWSLETTER->updateNL(
							Array(
									"id"=>$nl_id,
									"subject"=>$subject,
									"body"=>$body,
									"aktiv"=>$aktiv,
									"massmail"=>$massmail,
									"link"=>$link,
									"created"=>$updated,
									"author"=>$author,
									"grp_id"=>$nl_grp_id,
									"attm"=>$attach_ext,
									"content_type"=>$content_type,
									"track_image"=>$track_image
									)
									);
		$_MAIN_MESSAGE.="<br>".sprintf(___("Newsletter %s wurde aktualisiert."),"'<b>".display($subject)."</b>'");
		$_MAIN_MESSAGE.= "<br>".___("Der Newsletter wurde gespeichert unter:").
				"<ul>".
				___("Vorlage:")." <a href=\"".$tm_URL_FE."/".$tm_nldir."/".$NL_Filename_N."\" target=\"_preview\">".$tm_nldir."/".$NL_Filename_N."</a>".
				"<br>".
				___("Online:")." <a href=\"".$tm_URL_FE."/".$tm_nldir."/".$NL_Filename_P."\" target=\"_preview\">".$tm_nldir."/".$NL_Filename_P."</a>".
				"</ul>";

		$action="nl_list";
		include_once ($tm_includepath."/nl_list.inc.php");
	} else {
		$body=stripslashes(strtr($body, $trans));
		include_once ($tm_includepath."/nl_form.inc.php");
	}

} else {
	$NL=$NEWSLETTER->getNL($nl_id,0,0,0,1);
	$subject=$NL[0]['subject'];
	$body=strtr($NL[0]['body'], $trans);
	$aktiv=$NL[0]['aktiv'];
	$massmail=$NL[0]['massmail'];
	$link=$NL[0]['link'];
	$nl_grp_id=$NL[0]['grp_id'];
	$content_type=$NL[0]['content_type'];
	$$InputName_TrackImageExisting=$NL[0]['track_image'];
	include_once ($tm_includepath."/nl_form.inc.php");
}
?>