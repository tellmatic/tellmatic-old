<?php
/********************************************************************************/
/* this file is part of: / diese Datei ist ein Teil von:                        	*/
/* tellmatic, the newslettermachine                                             	*/
/* tellmatic, die Newslettermaschine                                            */
/* 2006/7 by Volker Augustin, multi.art.studio Hanau                            */
/* Contact/Kontakt: info@tellmatic.org                                      */
/* Homepage: www.tellmatic.org                                                   */
/* leave this header in file!                                                   */
/* diesen Header nicht loeschen!                                                */
/* check Homepage for Updates and more Infos                                    */
/* Besuchen Sie die Homepage fuer Updates und weitere Infos                     */
/********************************************************************************/

/***********************************************************/
//init
/***********************************************************/
$check=true;
$ERR_MESSAGE="";
/***********************************************************/
//php v5/6?
/***********************************************************/
if (version_compare(phpversion(), "5.0", ">=")) {
	$usePhp5=true;
} else {
	$usePhp5=false;
}
define("PHP5",$usePhp5);
if (PHP5) ini_set('zend.ze1_compatibility_mode', '1');

/***********************************************************/
//check
/***********************************************************/
//check for available memory
if ($mem==0) {
	//woot, unlimited memory...
	//i wouldn't recommend it to set to unlimited, ... but ok
}
if ($exec_time==0) {
	//yeah, unlimited time to execute php...
}

if ($mem>0 && $mem<8*1024*1024) {
	$ERR_MESSAGE.="<br>".sprintf(___("FEHLER! Für Tellmatic sollten mindestens %s Speicher für PHP zur Verfügung stehen, besser mehr"),"8MB")."";
	$check=false;
}
if ($exec_time> 0 && $exec_time<15) {
	$ERR_MESSAGE.="<br>".sprintf(___("FEHLER! Für Tellmatic sollten mindestens %s Sekunden Ausführungszeit für PHP zur Verfügung stehen, besser mehr"),"15")."";
	$check=false;
}

if ($mem<16*1024*1024) {
}
if ($exec_time<30) {
}

//check for php version
if (version_compare(phpversion(), "4.4", "<")) {
	$ERR_MESSAGE.="<br>".___("FEHLER! Sie verwenden PHP Version < 4.4. Tellmatic benötigt mindestens Version 4.4.")."";
	$check=false;
}

//if check is true (enough memory, exec time and php version)
if ($check) {
/***********************************************************/
	//check for windows
/***********************************************************/
	if (PHPWIN) {
		$ERR_MESSAGE.="<br>".___("PHP läuft unter Windows. Weitere Details finden Sie den den Dateien README und INSTALL oder der FAQ.")."";
	}
/***********************************************************/
//check for imap_open
/***********************************************************/
	if (!function_exists('imap_open')) {
		$ERR_MESSAGE.="<br>".___("Die Funktion imap_open() existiert nicht. Bouncemanagement und Mailbox wird nicht funktionieren. Weitere Details finden Sie den den Dateien README und INSTALL oder der FAQ.")."";
	}
/***********************************************************/
//check dir permissions
/***********************************************************/
	if (!is_writeable($tm_path."/admin/tmp")) {
		$ERR_MESSAGE.="<br>".sprintf(___("%s ist Schreibgeschützt. Weitere Details finden Sie den den Dateien README und INSTALL"),$tm_path."/admin/tmp")."";
		$check=false;
	}
	if (!is_writeable($tm_tplpath)) {
		$ERR_MESSAGE.="<br>".sprintf(___("%s ist Schreibgeschützt. Weitere Details finden Sie den den Dateien README und INSTALL"),$tm_tplpath)."";
		$check=false;
	}
	if (!is_writeable($tm_includepath)) {
		$ERR_MESSAGE.="<br>".sprintf(___("%s ist Schreibgeschützt. Weitere Details finden Sie den den Dateien README und INSTALL"),$tm_includepath)."";
		$check=false;
	}
	if (!is_writeable($tm_datapath)) {
		$ERR_MESSAGE.="<br>".sprintf(___("%s ist Schreibgeschützt. Weitere Details finden Sie den den Dateien README und INSTALL"),$tm_datapath)."";
		$check=false;
	}
	if (!is_writeable($tm_tmppath)) {
		$ERR_MESSAGE.="<br>".sprintf(___("%s ist Schreibgeschützt. Weitere Details finden Sie den den Dateien README und INSTALL"),$tm_tmppath)."";
		$check=false;
	}
	if (!is_writeable($tm_nlpath)) {
		$ERR_MESSAGE.="<br>".sprintf(___("%s ist Schreibgeschützt. Weitere Details finden Sie den den Dateien README und INSTALL"),$tm_nlpath)."";
		$check=false;
	}
	if (!is_writeable($tm_nlattachpath)) {
		$ERR_MESSAGE.="<br>".sprintf(___("%s ist Schreibgeschützt. Weitere Details finden Sie den den Dateien README und INSTALL"),$tm_nlattachpath)."";
		$check=false;
	}
	if (!is_writeable($tm_nlimgpath)) {
		$ERR_MESSAGE.="<br>".sprintf(___("%s ist Schreibgeschützt. Weitere Details finden Sie den den Dateien README und INSTALL"),$tm_nlimgpath)."";
		$check=false;
	}
	if (!is_writeable($tm_logpath)) {
		$ERR_MESSAGE.="<br>".sprintf(___("%s ist Schreibgeschützt. Weitere Details finden Sie den den Dateien README und INSTALL"),$tm_logpath)."";
		$check=false;
	}
	if (!is_writeable($tm_formpath)) {
		$ERR_MESSAGE.="<br>".sprintf(___("%s ist Schreibgeschützt. Weitere Details finden Sie den den Dateien README und INSTALL"),$tm_formpath)."";
		$check=false;
	}
	if (!is_writeable($tm_tmppath)) {
		$ERR_MESSAGE.="<br>".sprintf(___("%s ist Schreibgeschützt. Weitere Details finden Sie den den Dateien README und INSTALL"),$tm_tmppath)."";
		$check=false;
	}
	if (!is_writeable($tm_reportpath)) {
		$ERR_MESSAGE.="<br>".sprintf(___("%s ist Schreibgeschützt. Weitere Details finden Sie den den Dateien README und INSTALL"),$tm_reportpath)."";
		$check=false;
	}
} // check
/***********************************************************/

/***********************************************************/
if (!$check) {
	$ERR_MESSAGE="<p><font color=red><b>".___("Fehler")."</b>".
								$ERR_MESSAGE.
								"<br><br>There were Errors!<br>Es sind Fehler aufgetreten<br>".
								"<a href=\"".$_SERVER['PHP_SELF']."?lang=".$lang."&amp;accept=".$accept."\" target=\"_self\">".
								"Reload / Neu laden</a>".
								"</font></p>";
	$MESSAGE.=$ERR_MESSAGE;
	$ERR_MESSAGE="";
}

?>