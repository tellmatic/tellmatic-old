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
$MSG['unsubscribe']['invalid_captcha']="Ungültiger Code!";

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
//thx to vwinstead, http://sourceforge.net/users/vwinstead/
//see http://sourceforge.net/forum/message.php?msg_id=7456872
$MSG['subscribe']['update']='Email address exists in our database already. The data for this address has been updated.'; 
$MSG['unsubscribe']['unsubscribe']='You have successfully unsubscribed from the newsletter.'; 
$MSG['unsubscribe']['error']='Error!'; 
$MSG['unsubscribe']['invalid']='Invalid!'; 
$MSG['unsubscribe']['already_unsubscribed']='This email is already unsubscribed from the our newsletter.'; 
$MSG['unsubscribe']['invalid_email']='Invalid email address'; 
$MSG['unsubscribe']['invalid_captcha']="Inavlid code!";
 
$MSG['subscribe']['mail']['subject_user']='Newsletter Subscription'; 
$MSG['subscribe']['mail']['subject_new']='New Subscriber'; 
$MSG['subscribe']['mail']['subject_update']='Subscriber Update'; 
$MSG['subscribe']['mail']['body_new']=" 
<br>New Subscription: Data was stored.\n 
<br>The address was assigned to the groups which were marked for this form at the time of the registration.\n 
"; 
$MSG['subscribe']['mail']['body_doptin']=" 
<br>Double Opt-In: A confirmation email was sent to indicated address.\n 
<br>No newsletter will be sent to this email\n 
<br>until the registration has been confirmed.\n 
"; 
$MSG['subscribe']['mail']['body_update']=" 
<br>Activation: The data was updated.\n 
<br>This email address exists already.\n 
<br>The stored data record was updated with the entered data.\n 
<br>The address was assigned if necessary to additional groups.\n 
"; 

*/
?>