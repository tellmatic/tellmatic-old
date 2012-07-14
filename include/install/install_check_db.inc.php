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
$MESSAGE.="<p>".___("Verbindung zur Datenbank wird geprüft")."</p>";
if (DEMO) {
	$checkDB=true;
	$check=true;
	$MESSAGE.="<p><font color=green>".___("Die Verbindung zur Datenbank war erfolgreich")."</font></p>";
}

if ($check && !DEMO) {
	$db_connect_host=$db_host;
	if ($db_socket!=1) {
		$db_connect_host.=":".$db_port;
	}
    if(!@mysql_connect($db_connect_host, $db_user, $db_pass)) {
		$MESSAGE.="<p><font color=red>".___("Fehler! Es konnte keine Verbindung zur Datenbank aufgebaut werden");
		$MESSAGE.="<pre>".mysql_error()."</pre>";
		$MESSAGE.="</font></p>";
		$check=false;
		$checkDB=false;
	} else {
		$MESSAGE.="<p><font color=green>".___("Die Verbindung zur Datenbank war erfolgreich")."</font></p>";
		$checkDB=true;
		$check=true;
		//check for temporary table permissions		
		$tmp_code=rand(111,999);
		$tmp_tablename="tellmatic_temporary_table_test_".$tmp_code;
		$MESSAGE.="<p>".___("Prüfe auf Berechtigung zum erstellen temporärer Tabellen.")."";
		$MESSAGE.="<br>".sprintf(___("Temporäre Tabelle %s wird erstellt."),$tmp_tablename)."</p>";
		$Query_tmptable="CREATE TEMPORARY TABLE ".$tmp_tablename." (".
						"id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,".
						"name varchar(255)".
						")";
		$db_res=mysql_connect($db_connect_host, $db_user, $db_pass);
		$db_selected = mysql_select_db($db_name, $db_res);
		if ($db_selected) {	
		    $checkTmpTable = mysql_query($Query_tmptable,$db_res);
		    if (!$checkTmpTable) {//check if false, otherwise may contain values or true 
				$MESSAGE.="<p><font color=red>".___("Ein Fehler beim erstellen temporärer Tabellen ist aufgetreten. Bitte prüfen Sie die Berechtigungen des Datenbankbenutzers.")."<br>";
				$MESSAGE.="<pre>".mysql_error()."</pre></font></p>";
				$checkTmpTable=false;
				$checkDB=false;
				$check=false;
		    } else {
				$MESSAGE.="<p><font color=green>".___("OK, temporäre Tabellen können erstellt werden.")."</font></p>";
				$checkTmpTable=true;
		    }//checktmptable
		} else {
    		$check=false;
			$MESSAGE.="<p><font color=red>".___("SQL ERROR:").mysql_error()."</font></p>";
		}
	}//mysqlconnect
}

?>