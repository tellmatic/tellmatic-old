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

if (!isset($tm_config_admin)) {
    $tm_config_admin=false;
}

if (!$tm_config_admin) {

/***********************************************************/
//uploads
/***********************************************************/
	$allowed_html_filetypes = "(htm|html|txt)";
	$allowed_image_filetypes = "(jpg|jpeg)";
	$allowed_trackimage_filetypes = "(jpg|jpeg|png)";
	$allowed_csv_filetypes = "(csv|txt)";

	$max_upload_size=2048000;//2M
	if (DEMO) $max_upload_size=2048;//2k

/***********************************************************/
//limits
/***********************************************************/
	$adr_row_limit=500;
	$available_mem=calc_bytes(ini_get("memory_limit"));

	if ($available_mem==0) {
		//we have unlimted memory, but set a limit here
		$adr_row_limit=4000;//4k is enough :) like having 32mb of ram
	}

	if ($available_mem >= (8*1024*1024)) { //8M
		$adr_row_limit=1000;
	}
	if ($available_mem >= (16*1024*1024)) {
		$adr_row_limit=2000;
	}
	if ($available_mem >= (24*1024*1024)) {
		$adr_row_limit=3000;
	}
	if ($available_mem >= (32*1024*1024)) {
		$adr_row_limit=4000;
	}
	if ($available_mem >= (48*1024*1024)) {
		$adr_row_limit=6000;
	}
	if ($available_mem >= (64*1024*1024)) {
		$adr_row_limit=8000;
	}
	
	
	$max_execution_time=ini_get("max_execution_time");
	if ($max_execution_time==0) $max_execution_time=3600;

/***********************************************************/
//kleinkram
/***********************************************************/
	$row_bgcolor="#ffffff";
	$row_bgcolor2="#eeefee";
	$row_bgcolor_inactive="#ff9999";
	$row_bgcolor_hilite="#ffcc00";
/***********************************************************/
//php settings etc
/***********************************************************/
	#@ini_set("max_execution_time","0");
	@ini_set("ignore_user_abort","1");

/***********************************************************/
//sessions
/***********************************************************/
	//sessions
	define ("TM_SESSION_TIMEOUT", 360*60);//360 * 60 sek = 6h
	@ini_set("session.cookie_lifetime",TM_SESSION_TIMEOUT*10);
	@ini_set("session.use_cookies","1");
	@ini_set("session.use_only_cookies","1");

/***********************************************************/
//cache off
/***********************************************************/
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Datum in der Vergangenheit

/***********************************************************/
//send http header encoding
/***********************************************************/
	header("Content-type: text/html; charset=$encoding");
	
/***********************************************************/
//start compression output
/***********************************************************/
	m_obstart();

/***********************************************************/
//configured
/***********************************************************/
	$tm_config_admin=true;
}
?>