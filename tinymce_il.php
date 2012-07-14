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


include ("./include/mnl_config.inc");

function tinymce_createimagelist($FileA,$UrlPrefix) {
	$Return="";
	//sort array by name:
		$btsort=Array();
			foreach ($FileA as $field) {  
			$btsort[]=$field['filename'];
		}  
		@array_multisort($btsort, SORT_ASC, $FileA, SORT_ASC);
	$ic= count($FileA);
	for ($icc=0; $icc < $ic; $icc++) {
		$Return.= "[\"".$FileA[$icc]['filename']."\",\"".$UrlPrefix."/".$FileA[$icc]['filename']."\"]";
		if ($icc < ($ic-1)) {
		 $Return.= ",\n";
		}
	}
	Return $Return;
}

	$tinymce_il="";

	unset($FileARRAY);
	gen_rec_files_array($mnl_nlimgpath);
	$tinymce_il.=tinymce_createimagelist($FileARRAY,$mnl_URL."/".$mnl_nlimgdir);
	// Name, URL
?>

var tinyMCEImageList = new Array(
	<?php
		echo $tinymce_il;
	?>
);

<head></head>
