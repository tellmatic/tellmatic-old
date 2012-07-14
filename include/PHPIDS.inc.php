<?php
/********************************************************************************/
/* this file is part of: / diese Datei ist ein Teil von:                        */
/* tellmatic, the newslettermachine                                             */
/* tellmatic, die Newslettermaschine                                            */
/* 2006/10 by Volker Augustin, multi.art.studio Hanau                            */
/* Contact/Kontakt: info@tellmatic.org                                      */
/* Homepage: www.tellmatic.org                                                   */
/* leave this header in file!                                                   */
/* diesen Header nicht loeschen!                                                */
/* check Homepage for Updates and more Infos                                    */
/* Besuchen Sie die Homepage fuer Updates und weitere Infos                     */
/********************************************************************************/

/******************************************/
//php ids
/******************************************/
	#phpids sucks a lot, we need explicitely define the include dir, base path has no effect! ;P bad style, doesnt really work as explained, lacks documentation, example is just a fake. needs too much tweaking.

	set_include_path(
	    get_include_path()
    	. PATH_SEPARATOR
    	. TM_INCLUDEPATH.'/phpids/lib/'
	);
	
    $ids_request = array(
        'REQUEST' => $_REQUEST,
        'GET' => $_GET,
        'POST' => $_POST,
        'COOKIE' => $_COOKIE
    );
	require_once (TM_INCLUDEPATH.'/phpids/lib/IDS/Init.php');
	$ids_init = IDS_Init::init(TM_INCLUDEPATH . '/phpids/lib/IDS/Config/Config.ini.php');
	$ids_init->config['General']['filter_type'] = 'xml';
	$ids_init->config['General']['filter_path'] = 'default_filter.xml';
    #tmp_path        = tmp    #scan_keys       = false	
	$ids_init->config['General']['base_path'] = TM_INCLUDEPATH.'/phpids/lib/IDS/';
	$ids_init->config['General']['use_base_path'] = true;
	#$ids_init->config['General']['use_base_path'] = false;
	
	$ids_init->config['General']['html'] = Array(
			"POST.summary",
			"POST.body",
			"POST.body_text",
			"POST.subject",
			"POST.message_doptin",
			"POST.message_greeting",
			"POST.message_update",
			"POST.content",
	);

	$ids_init->config['General']['exceptions'] = Array(
			"POST.summary",
			"POST.body",
			"POST.body_text",
			"POST.subject",
			"POST.message_doptin",
			"POST.message_greeting",
			"POST.message_update",
			"POST.content",
			"REQUEST.summary",
			"REQUEST.body",
			"REQUEST.body_text",
			"REQUEST.subject",
			"REQUEST.message_doptin",
			"REQUEST.message_greeting",
			"REQUEST.message_update",
			"REQUEST.content",
	);
	
	$ids_init->config['Caching']['caching'] = 'file';//none
	$ids_init->config['Caching']['expiration_time'] = 600;
	$ids_init->config['Caching']['path'] = "../../../../admin/tmp/phpids.cache";
	
	$ids_init->config['Logging']['path'] = "../../../../admin/tmp/phpids.log";
	#$ids_init->config['Caching']['path'] =TM_INCLUDEPATH."/../admin/tmp/phpids.cache";
	#$ids_init->config['Logging']['path'] =TM_INCLUDEPATH."/../admin/tmp/phpids.log";

    $ids = new IDS_Monitor($ids_request, $ids_init);
    $ids_result = $ids->run();
	if (!$ids_result->isEmpty()) {


        /*
        * The following steps are optional to log the results
        */
        require_once 'IDS/Log/File.php';
        require_once 'IDS/Log/Email.php';
        require_once 'IDS/Log/Composite.php';

		#require_once (TM_INCLUDEPATH.'/phpids/lib/IDS/Log/File.php');
		#require_once (TM_INCLUDEPATH.'/phpids/lib/IDS/Log/Email.php');
		#require_once (TM_INCLUDEPATH.'/phpids/lib/IDS/Log/Comopsite.php');
		
        $compositeLog = new IDS_Log_Composite();
        $compositeLog->addLogger(
        	IDS_Log_File::getInstance($ids_init),
			IDS_Log_Email::getInstance($ids_init)
		);

        $compositeLog->execute($ids_result);

        #if (DEBUG) echo $ids_result;
        $_MAIN_MESSAGE.="<h1>PHPIDS Intrusion detection:</h1>";
        $_MAIN_MESSAGE.="<pre><font size=1 color=\"red\">".$ids_result."</font></pre>";
	}
	
?>