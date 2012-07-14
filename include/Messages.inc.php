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

/***********************************************************/
//Tellmatic messages for subscribe and unsubscribe
/***********************************************************/

//German, de
$MSG['subscribe']['update']='E-Mail-Adresse existiert bereits. Ihre Daten wurden aktualisiert.';
$MSG['unsubscribe']['unsubscribe']='Sie wurden abgemeldet.';
$MSG['unsubscribe']['error']='Fehler!';
$MSG['unsubscribe']['invalid']='Ungültig!';
$MSG['unsubscribe']['already_unsubscribed']='Sie sind nicht mehr angemeldet.';
$MSG['unsubscribe']['invalid_email']='Ungültige E-Mail-Adresse';

$MSG['subscribe']['mail']['subject_user']='Newsletteranmeldung';
$MSG['subscribe']['mail']['subject_new']='Neuanmeldung';
$MSG['subscribe']['mail']['subject_update']='Aktualisierung';
$MSG['subscribe']['mail']['body_new']="
<br>Neuanmeldung: Daten wurden gespeichert.\n
<br>Die Adresse wurde den Gruppen zugewiesen, die fuer dieses Formular zum Zeitpunkt der Anmeldung markiert waren.\n
";
$MSG['subscribe']['mail']['body_doptin']="
<br>Double Opt-In: Es wurde eine e-Mail zu Bestaetigung an die angegebene Adresse geschickt.\n
<br>Es werden keine Newsletter an diesen Empfaenger geschickt,\n
<br>bis dieser die Anmeldung bestaetigt hat.\n
";
$MSG['subscribe']['mail']['body_update']="
<br>Aktualisierung: Daten wurden aktualisiert.\n
<br>Diese e-Mailadresse existiert schon.\n
<br>Der gespeicherte Datensatz wurde mit den eingegebenen Daten aktualisiert.\n
<br>Die Adresse wurde ggf. zusaetzlichen Gruppen zugeordnet.\n
";


//en
/*
$MSG['subscribe']['update']='emailaddress already exists. your data has been updated';
$MSG['unsubscribe']['unsubscribe']='you are now unsubscribed from our list.';
$MSG['unsubscribe']['error']='error!';
$MSG['unsubscribe']['invalid']='invalid!';
$MSG['unsubscribe']['already_unsubscribed']='you are already unsubscribed';
$MSG['unsubscribe']['invalid_email']='invalid emailaddress';


*/
?>