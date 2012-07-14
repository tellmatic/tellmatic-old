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

//alternativ: eigenes bild aus png erzeugen und einblenden:
/*geht, jedoch ohne transparenz im png....*/
if (file_exists($mnl_imgpath."/mylogo.png")) {
	$ImageIn  = imagecreatefrompng($mnl_imgpath."/mylogo.png");
	$width=ImageSX($ImageIn);
	$height=ImageSY($ImageIn);
	$ImageOut = imagecreatetruecolor($width,$height);
	//$BGColor = imagecolorallocate($ImageOut, 255, 255, 255);
	$BGColor = imagecolorresolve($ImageOut, 255, 255, 255);
	ImageColorTransparent($Image, $BGColor); 
	imagefilledrectangle($ImageOut, 0, 0, $width, $height, $BGColor);
	//Imageinterlace($ImageOut, 1);
	imagecopy($ImageOut, $ImageIn, 0, 0, 0, 0, $width, $height);
	//imagetruecolortopalette($ImageOut, false, 250);
	imagealphablending($ImageOut, FALSE);
	imagesavealpha($ImageOut, TRUE);
	$Image=$ImageOut;
} else {
//bild generieren, png 4x7px
	$width	=	4;
	$height	=	7;
	$Image = ImageCreate($width,$height); 
	$White = ImageColorAllocate($Image, 255,255,255); 
	$FC=$White; 
	$BG=$White; 
	$TC=$BG; 
	ImageColorTransparent($Image, $TC); 
	ImageFill($Image, 0, 0, $BG); 
	Imageinterlace($Image, 1); 
}

Header("content-type: image/png"); 
ImagePNG($Image); 
ImageDestroy($Image); 
?>