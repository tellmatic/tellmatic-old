<?
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

if (!isset($wysiwyg_loaded)) {
    $wysiwyg_loaded=false;
}
if (!$wysiwyg_loaded) {

$_MAIN_OUTPUT.='

<!-- TinyMCE -->
<!--script language="javascript" type="text/javascript" src="'.$tm_URL.'/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script-->
<script language="javascript" type="text/javascript" src="'.$tm_URL_FE.'/js/tinymce/jscripts/tiny_mce/tiny_mce_gzip.php"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	//prevent special charcter encoding: 
	//important!
	entities : "",
	theme : "advanced",
	remove_linebreaks : false,
	relative_urls : false,
	remove_script_host : false,
	force_br_newlines : true,
   force_p_newlines : false,
	browsers : "msie,gecko",
	language : "'.$LOGIN->USER['lang'].'",
	plugins : "table,advimage,advhr,insertdatetime,preview,searchreplace,contextmenu,paste,directionality,spellchecker,fullpage,layer,fullscreen,media,emotions", //flash
	theme_advanced_buttons1_add_before : "help,fullpage,preview,fullscreen,separator,spellchecker,separator,cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
	theme_advanced_buttons1_add : "",
	theme_advanced_buttons2_add_before: "fontselect,fontsizeselect,forecolor,backcolor",
	theme_advanced_buttons2_add : "separator,insertdate,inserttime,separator,flash,media",
	theme_advanced_buttons3_add_before : "tablecontrols,separator",
	theme_advanced_buttons3_add : "advhr,separator,ltr,rtl,separator,insertlayer,moveforward,movebackward,absolute,separator,emotions",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_path_location : "bottom",
	content_css : "'.$tm_URL_FE.'/css/tinymce.css",
   spellchecker_languages : "+English=en,Deutsch=de,Francais=fr,Italiano=it",
	plugin_insertdate_dateFormat : "%Y-%m-%d",
	plugin_insertdate_timeFormat : "%H:%M:%S",
	//extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style],form[action|name|type|method],input[name|type|size|maxlength],select[name],option[value],textarea[name|cols|rows],radio[name|value]",
	extended_valid_elements : "*[*]",
	external_image_list_url : "'.$tm_URL_FE.'/'.$tm_includedir.'/tinymce_il.php",
	theme_advanced_resize_horizontal : false,
	theme_advanced_resizing : true,
	fullpage_default_langcode : "'.$LOGIN->USER['lang'].'",
	fullpage_default_title : "",
	//"'.___("Newsletter").'",
	fullpage_default_encoding : "'.$encoding.'",
	fullpage_default_xml_pi : false,
	fullpage_default_doctype : "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">",
	fullscreen_new_window : true,
	fullscreen_settings : {
		theme_advanced_path_location : "top"
	},
	});

function toggleEditor(id) {
	var elm = document.getElementById(id);

	if (tinyMCE.getInstanceById(id) == null)
		tinyMCE.execCommand("mceAddControl", false, id);
	else
		tinyMCE.execCommand("mceRemoveControl", false, id);
}
</script>
<!-- /TinyMCE -->
';
	$wysiwyg_loaded=true;
}
?>