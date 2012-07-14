<?php
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
/*
//mkdir locale/[LANG]/LC_MESSAGES
//xgettext -C index.php -o index.po --keyword=_
//msgfmt index.po --output-file=index.mo
// ./locale/[LANG]/LC_MESSAGES/index.mo
*/
$locale = (isset($LOGIN->USER['lang']))? $LOGIN->USER['lang'] : DEFAULT_LOCALE;
// gettext setup
T_setlocale(LC_MESSAGES, $locale);
// Set the text domain as 'messages'
$domain = 'tellmatic';

T_bindtextdomain($domain, LOCALE_DIR);
T_bind_textdomain_codeset($domain, $encoding);

T_textdomain($domain);
?>