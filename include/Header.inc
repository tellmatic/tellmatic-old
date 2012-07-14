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

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=<?php echo $encoding;?>">
<meta name="application" content="<?php echo $ApplicationText; ?>">
<meta name="author" content="Volker">
<meta name="Publisher" content="multi.art.studio Hanau">
<meta name="Copyright" content="2007 Volker Augustin - multi.art.studio Hanau">
<meta name="Description" content="tellmatic - the newslettermaschine - www.tellmatic.org">
<meta name="Page-topic" content="Newsletter">
<meta name="Audience" content="all">
<meta name="Content-language" content="DE">
<meta name="Robots" content="NOINDEX,NOFOLLOW">
<meta name="Keywords" content="news, newsletter, massmail, personalized mail, mailing, emailmarketing">

<meta name="OBGZip" content="true">
<link rel="shortcut icon" href="<?php echo $mnl_URL_FE."/".$mnl_imgdir."/favicon.ico";?>">

<title><?php echo $ApplicationText;?></title>
<!--link rel="stylesheet" type="text/css" media="all" href="<?php echo $mnl_URL_FE;?>/css/mnl_<?php echo $LOGIN->USER['style']; ?>.css" title="mnl" /-->

<!--style type="text/css">
@import url(<?php echo $mnl_URL_FE;?>/css/calendar.css) screen;
@import url(<?php echo $mnl_URL_FE;?>/css/<?php echo $LOGIN->USER['style']; ?>/mnl.css) screen;
@import url(<?php echo $mnl_URL_FE;?>/css/<?php echo $LOGIN->USER['style']; ?>/mnl_head.css) screen;
@import url(<?php echo $mnl_URL_FE;?>/css/<?php echo $LOGIN->USER['style']; ?>/mnl_menu.css) screen;
@import url(<?php echo $mnl_URL_FE;?>/css/<?php echo $LOGIN->USER['style']; ?>/mnl_main.css) screen;
@import url(<?php echo $mnl_URL_FE;?>/css/<?php echo $LOGIN->USER['style']; ?>/mnl_form.css) screen;
</style-->

<style type="text/css">
@import url(<?php echo $mnl_URL_FE;?>/css/calendar.css);
@import url(<?php echo $mnl_URL_FE;?>/css/<?php echo $LOGIN->USER['style']; ?>/mnl.css);
@import url(<?php echo $mnl_URL_FE;?>/css/<?php echo $LOGIN->USER['style']; ?>/mnl_head.css);
@import url(<?php echo $mnl_URL_FE;?>/css/<?php echo $LOGIN->USER['style']; ?>/mnl_menu.css);
@import url(<?php echo $mnl_URL_FE;?>/css/<?php echo $LOGIN->USER['style']; ?>/mnl_main.css);
@import url(<?php echo $mnl_URL_FE;?>/css/<?php echo $LOGIN->USER['style']; ?>/mnl_form.css);
</style>
<!-- daemlicher IE unterstuetzt kein mediatype.... in den naechsten versionen wird darauf keine ruecksicht mehr genommen, wer ie benutzt ist selbst schuld und kann die software halt nicht benutzen!-->

<script type="text/javascript" src="<?php echo $mnl_URL_FE;?>/js/mnl.js"></script>
<script type="text/javascript" src="<?php echo $mnl_URL_FE;?>/js/ajax.js"></script>
<script type="text/javascript" src="<?php echo $mnl_URL_FE;?>/js/drag.js"></script>
<script type="text/javascript" src="<?php echo $mnl_URL_FE;?>/js/cal/calendar.js"></script>
<script type="text/javascript" src="<?php echo $mnl_URL_FE;?>/js/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="<?php echo $mnl_URL_FE;?>/js/cal/calendar-setup.js"></script>
<script type="text/javascript" src="<?php echo $mnl_URL_FE;?>/js/jsfx_image_fader.js"></script>
</head>


<body>

<div id="div_loader" class="loader">
<br><b>
</b>
<center>
<b>
<?php
echo ___("Bitte warten...")."<br>".___("Seite wird geladen");
?>
</b>
<br>
<img src="<?php echo $mnl_URL_FE."/".$mnl_imgdir."/counter.gif";?>" border=0></b>
<br>
<font size=-1>
<?php
echo ___("Achtung! Ein Abbruch des Ladevorgangs kann zu Datenverlust und ungewünschten Nebeneffekten führen. Bitte tun Sie dies auf Ihr eigenes Risiko.");
?>
</font><br>
</center>
<br>
	<center>
	<div id="ld" align="left" style="display:block;background-color:#ff0000;padding:0;">
	<table id="lpc" bgcolor="#ffcc00" height="14" cellpadding=0 cellspacing=0><tr><td>
	<div id="lt" style="background-color:#33ff33; color:#ffffff; font-size:12px; padding:0;">
			<div id="ltt" style="background-color:#eeeeee; color:#ff0000; font-size:10px; padding:0;"><b>loading&nbsp;.......</b></div>
	</div>
	</td></tr></table>
	</div>
	</center>
<br><br>
</div>


<script type="text/javascript">
//<!--
load();
//--></script>