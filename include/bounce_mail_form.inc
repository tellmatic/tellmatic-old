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

if ($mc>0) {
	$_MAIN_OUTPUT.= "<table border=0>";
	$_MAIN_OUTPUT.= "<tr>";
	$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
	$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Action]['html'];
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "<td valign=bottom colspan=1>";
	$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Submit]['html'];
	//$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Reset]['html'];
	$_MAIN_OUTPUT.= "</td>";
	$_MAIN_OUTPUT.= "</tr>";
	$_MAIN_OUTPUT.= "</table>";
}
	$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['foot'];

?>