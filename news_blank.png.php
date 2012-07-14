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


include("./include/mnl_config.inc");

//aufruf: news_blank.png.php?h_id=&nl_id=&a_id=

$h_id=getVar("h_id");
$nl_id=getVar("nl_id");
$a_id=getVar("a_id");


if (checkid($nl_id)) {
	$NEWSLETTER=new mnlNL();
	//nl view counter ++
	$NEWSLETTER->addView($nl_id);
	if (checkid($h_id)) { 
		$QUEUE=new mnlQ();
		$QUEUE->setHStatus($h_id,3);	//view
	}
	if (checkid($a_id)) {
		$ADDRESS=new mnlAdr();
		$ADDRESS->setStatus($a_id,4);	//view
		//adr view counter ++
		$ADDRESS->addView($a_id,4);	//view
	}
}	

//bild generieren, png 1x1px
$Width	=	1;
$Height	=	1;
$Image = ImageCreate($Width,$Height); 
$White = ImageColorAllocate($Image, 255,255,255); 
$FC_=$White; 
$BG_=$White; 
$TC=$BG_; 
ImageColorTransparent($Image, $TC); 
ImageFill($Image, 0, 0, $BG_); 
Imageinterlace($Image, 1); 
Header("content-type: image/png"); 
ImagePNG($Image); 
ImageDestroy($Image); 
?>