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
$MESSAGE.="<br><br>";

if ($check) {
/***********************************************************/

/***********************************************************/
			$MESSAGE.= "Herzlichen Glückwunsch,<br>\n".
					"<br>Die Installation der Tellmatic Newslettermaschine auf ".TM_DOMAIN."/".TM_DIR." war erfolgreich.<br>\n".
					"<br>Besuchen Sie <br><a href=\"".TM_DOMAIN."/".TM_DIR."/admin/index.php\">".TM_DOMAIN."/".TM_DIR."/admin/index.php</a><br>\n".
					"und melden sich mit Ihrem Benutzernamen und Passwort an.<br>";

			$MESSAGE.= "<br><br>Congratulations,<br>\n".
					"<br>Installation of Tellmatic Newslettermaschine on ".TM_DOMAIN."/".TM_DIR." was successful.<br>\n".
					"<br>Visit <br><a href=\"".TM_DOMAIN."/".TM_DIR."/admin/index.php\">".TM_DOMAIN."/".TM_DIR."/admin/index.php</a><br>\n".
					"and log in with your username and password.<br>";


/***********************************************************/

/***********************************************************/
	if (!DEMO) {
		$MESSAGE_TEXT=str_replace("<br>","\n",$MESSAGE);
		$MESSAGE_TEXT=strip_htmltags($MESSAGE_TEXT);
		$MESSAGE_TEXT=strip_tags($MESSAGE_TEXT);

		$headers = "";
		$headers .= "Return-Path: <".$email.">\r\n";
		$headers .= "From: ".$email." <".$email.">\r\n";
		$headers .= "X-Mailer: Tellmatic\r\n";
		$headers .= "Content-Type: text/plain;\n\tcharset=\"utf-8\"\n";
		@mail($email,
					"Tellmatic Installation",
					$MESSAGE_TEXT,
					$headers
					);//
		if ($reg==1) {
			$headers = "";
			$headers .= "Return-Path: <".$email.">\r\n";
			$headers .= "From: ".$email." <".$email.">\r\n";
			$headers .= "X-Mailer: Tellmatic\r\n";
			$headers .= "Content-Type: text/plain;\n\tcharset=\"utf-8\"\n";
			@mail("install@tellmatic.org",
				"Installation ".TM_VERSION,
				display($regmsg),
				$headers
			);//,
			
			$MESSAGE.=___("Eine E-Mail mit folgenden Informationen wurde an den Entwickler von Tellmatic gesendet").":";
			$MESSAGE.="<pre>".display($regmsg)."</pre>";
			
		}//reg

	}//demo


}//if check
?>