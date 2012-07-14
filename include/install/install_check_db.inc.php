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
if (DEMO) {
	$checkDB=true;
	$check=true;
	$MESSAGE.="<p>".___("Die Verbindung zur Datenbank war erfolgreich")."</p>";
}

if ($check && !DEMO) {
    if(!@mysql_connect($db_host.":".$db_port, $db_user, $db_pass)) {
		$MESSAGE.="<p><font color=red>".___("Fehler! Es konnte keine Verbindung zur Datenbank aufgebaut werden");
		$MESSAGE.="<pre>".mysql_error()."</pre>";
		$MESSAGE.="</font></p>";
		$check=false;
		$checkDB=false;
	} else {
		$MESSAGE.="<p>".___("Die Verbindung zur Datenbank war erfolgreich")."</p>";
		$checkDB=true;
		$check=true;
	}
}

?>