<?php
//config einbinden
include ("./include/tm_config.inc.php");

/***********************************************************/
//create a new newsletter:
/***********************************************************/
//all vars are required, even if they are used or not e.g. track_image, attach_ext
//subject
$subject='test_newsletter';//subject
//body
$body='test <b>test</b> <em>test</em>';
//creation date
$created=date("Y-m-d H:i:s");
//status
$status=1;//1:new
//active
$aktiv=1;//newsletter is active
//a link
$link="http://www.tellmatic.org";
//massmail or personalized email?
$massmail=1;//1:bcc, 0:personalized
//name of te author
$author="name";//name of author, e.g. login name from cms etc, you may add this user to tellmatic to make statistics (when it gets implemented)...
//newsletter group id
$nl_grp_id=33;//id of the group the newsletter should become a member of
//attachement extension
$attach_ext="";//extension of attachement, can be empty, so no attachement is used
//content type, send as html, text or both
$content_type="html";//text, html, text/html
//track image
$track_image="_global";//"_global", "_blank", "/image.png"

//remove the #
//new instance of newsletter class
#$NEWSLETTER=new tm_NL();
//add a newsletter
#$NEWSLETTER->addNL(
								Array(
									"subject"=>$subject,
									"body"=>$body,
									"aktiv"=>$aktiv,
									"status"=>$status,
									"massmail"=>$massmail,
									"link"=>$link,
									"created"=>$created,
									"author"=>$author,
									"grp_id"=>$nl_grp_id,
									"attm"=>$attach_ext,
									"content_type"=>$content_type,
									"track_image"=>$track_image
									)
								);
//thats it
?>