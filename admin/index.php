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

if (!file_exists("../include/tm_config.inc.php")) {
	exit;
}
require_once ("../include/tm_config.inc.php");
require_once (TM_DOCROOT."/".TM_DIR."/include/tm_lib_admin.inc.php");
require_once (TM_INCLUDEPATH."/Index.inc.php");
?>