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
//inclue tm config //remove the #
#include ("./include/tm_config.inc.php");//change path to full path to tm_config if the script is not in tellmatic installation directory!

/***********************************************************/
//create a new newsletter:
/***********************************************************/
//all vars are required, even if they are used or not e.g. track_image, attach_ext
//subject
$subject='test_newsletter';//subject
//body
$body='test <b>test</b> <em>test</em>';
$body_text="test";
//creation date
$created=date("Y-m-d H:i:s");
//status
$status=1;//1:new
//active
$aktiv=1;//newsletter is active
//a link
$link="http://www.tellmatic.org";
//massmail or personalized email?
$massmail=0;//1:bcc, 0:personalized
//name of te author
$author="name";//name of author, e.g. login name from cms etc, you may add this user to tellmatic to make statistics (when it gets implemented)...
//newsletter group id
$nl_grp_id=1;//id of the group the newsletter should become a member of
//content type, send as html, text or both
$content_type="text/html";//text, html, text/html
//track image
$track_image="_global";//"_global", "_blank", "/image.png"
//recipients name
$rcpt_name="Recipient";
//attachements
$attach_existing=Array();

//new instance of newsletter class, //remove the #
#$NEWSLETTER=new tm_NL();
//add a newsletter, //remove the #
#$NEWSLETTER->addNL(
								Array(
									"subject"=>$subject,
									"body"=>$body,
									"body_text"=>$body_text,
									"aktiv"=>$aktiv,
									"status"=>$status,
									"massmail"=>$massmail,
									"link"=>$link,
									"created"=>$created,
									"author"=>$author,
									"grp_id"=>$nl_grp_id,
									"content_type"=>$content_type,
									"track_image"=>$track_image,
									"rcpt_name"=>$rcpt_name,
									"attachements"=>$attach_existing
									)
								);
//thats it
?>