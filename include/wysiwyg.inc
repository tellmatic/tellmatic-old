<?
/********************************************************************************/
/* this file is part of: / diese Datei ist ein Teil von:                        */
/* tellmatic, the newslettermachine                                             */
/* tellmatic, die Newslettermaschine                                            */
/* 2006/7 by Volker Augustin, multi.art.studio Hanau                            */
/* Contact/Kontakt: mnl@multiartstudio.com                                      */
/* Homepage: www.tellmatic.de                                                   */
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
<!--script language="javascript" type="text/javascript" src="'.$mnl_URL.'/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script-->
<script language="javascript" type="text/javascript" src="'.$mnl_URL.'/js/tinymce/jscripts/tiny_mce/tiny_mce_gzip.php"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	remove_linebreaks : false,
	relative_urls : false,
	remove_script_host : false,
	force_br_newlines : true,
   force_p_newlines : false,
	browsers : "msie,gecko",
	plugins : "table,advimage,advhr,insertdatetime,preview,searchreplace,contextmenu,paste,directionality",
	theme_advanced_buttons1_add : "fontselect,fontsizeselect",
	theme_advanced_buttons2_add : ",separator,forecolor,backcolor,separator,insertdate,inserttime,preview",
	theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
	theme_advanced_buttons3_add_before : "tablecontrols,separator",
	theme_advanced_buttons3_add : "advhr,separator,ltr,rtl,separator",	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_path_location : "bottom",
	content_css : "'.$mnl_URL.'/css/tinymce.css",
   plugin_insertdate_dateFormat : "%Y-%m-%d",
   plugin_insertdate_timeFormat : "%H:%M:%S",
   //extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style],form[action|name|type|method],input[name|type|size|maxlength],select[name],option[value],textarea[name|cols|rows],radio[name|value]",
	extended_valid_elements : "*[*]",
   external_image_list_url : "'.$mnl_URL.'/tinymce_il.php",
   theme_advanced_resize_horizontal : false,
   theme_advanced_resizing : true
	});
</script>
<!-- /TinyMCE -->
';


	$wysiwyg_loaded=true;
}
?>