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

include("./include/tm_config.inc.php");

//aufruf: news_blank.png.php?h_id=&nl_id=&a_id=

$h_id=getVar("h_id");
$nl_id=getVar("nl_id");
$a_id=getVar("a_id");

$TrackImageType="png";
$create_track_image=false;

if (checkid($nl_id)) {
	$NEWSLETTER=new tm_NL();
	//nl holen
	$NL=$NEWSLETTER->getNL($nl_id);
	//wenn newsletter gefunden, ok
	if (count($NL)>0) {
		$create_track_image=true;
	}
	//nl view counter ++
	$NEWSLETTER->addView($nl_id);
	//history id? dann in der historie auf view setzen!
	if (checkid($h_id)) {
		$QUEUE=new tm_Q();
		//nur der erste aufruf wird mit der ip versehen! ansonsten wuerde diese jedesmal ueberschrieben wenn der leser oder ein anderer das nl anschaut.
		$H=$QUEUE->getH($h_id);
		if (empty($H[0]['ip']) || $H[0]['ip']=='0.0.0.0') {
			$QUEUE->setHIP($H[0]['id'], getIP());	//save ip
		}
		if ($H[0]['status']!=7) { //7:unsubscribed
			$QUEUE->setHStatus($h_id,3);	//view
		}
	}
	//adressid? wenn ja status aendern und view zaehlen
	if (checkid($a_id)) {
		$ADDRESS=new tm_ADR();
		$ADR=$ADDRESS->getAdr($a_id);
		//only set view status if not waiting status or unsubscribed // !5 && !11
		if ($ADR[0]['status']!=5 && $ADR[0]['status']!=11) {
			$ADDRESS->setStatus($a_id,4);	//view
		}
		//adr view counter ++
		$ADDRESS->addView($a_id);	//view
		//save memo
		$created=date("Y-m-d H:i:s");
		$memo="\n".$created.": viewed (".$NL[0]['subject'].")";
		$ADDRESS->addMemo($a_id,$memo);
	}
}
//wenn kein trackimage erzeugt werden soll, also kein newsletter gefunden wurde, blank erzeugen
if (!$create_track_image) {
	$Image=makeBlankImage(4,7);
}
//andernfalls, falls track image erzeugt werden soll, abhaengig vom newsletter...
if ($create_track_image) {
	//track image auslesen
	$imagefilename=$NL[0]['track_image'];
	//wenn "_global":
	if ($imagefilename=="_global") {
		//bildname uebergeben, evtl ist es "_blank"
		//einstellungen aus der config uebernehmen:
		$imagefilename=$C[0]['track_image'];
	}
	//"_blank"?
	if ($imagefilename=="_blank") {
		$Image=makeBlankImage(4,7);
	}
	//wenn kein blank oder global
	if ($imagefilename!="_blank" && $imagefilename!="_global" ) {
		$TrackImageType=strtolower(get_file_ext( $imagefilename ));
		if ($TrackImageType=="jpeg") $TrackImageType="jpg";
		$imagefile=$tm_nlimgpath.$imagefilename;
		//wenn die datei existiert:
		if (file_exists($imagefile)) {
			$Image=makeTrackImage($imagefile,$TrackImageType);
		} else {
			//wenn die datei nicht existiert, blank!
			$Image=makeBlankImage(4,7);
		}
	}
}

ob_start("trackimage_output_handler");

if ($TrackImageType=="png") {
	ImagePNG($Image);
}
if ($TrackImageType=="jpg") {
	ImageJPEG($Image);
}

ob_end_flush();

ImageDestroy($Image);

/////////////////////////////////
//    Output handler
function trackimage_output_handler($img) {
	global $TrackImageType;
    header('Content-type: image/'.$TrackImageType);
    header('Content-Length: ' . strlen($img));
    return $img;
}

//read and return existing image
function makeTrackImage($imagefile,$type="png") {
	if ($type=="png") {
		$ImageIn  = imagecreatefrompng($imagefile);
	}
	if ($type=="jpg") {
		$ImageIn  = imagecreatefromjpeg($imagefile);
	}
	$width=ImageSX($ImageIn);
	$height=ImageSY($ImageIn);

	//now create truecolor image and transfer
	$ImageOut = imagecreatetruecolor($width, $height);

	if ($type=="png") {
		//if not truecolor, convert png to truecolor png
		if (!imageistruecolor($ImageIn)) {
	        imagealphablending($ImageOut, false);
			imagecopy($ImageOut, $ImageIn, 0, 0, 0, 0, $width, $height);
    	    imagesavealpha($ImageOut, true);
			$bgColor = imagecolorallocate($ImageIn, 255,255,255);
			ImageColorTransparent($ImageOut, $bgColor);
			imagefill($ImageOut , 0,0 , $bgColor);
		}//not truecolor
		//true color png
		if (imageistruecolor($ImageIn)) {
			imageAlphaBlending($ImageIn, true);
			imageSaveAlpha($ImageIn, true);
			$ImageOut=$ImageIn;
		}//truecolor
	}//type=png
	if ($type=="jpg") {
		$ImageOut=$ImageIn;
	}//jpg
    #imagedestroy($imageIn);
	return $ImageOut;
}//function

function makeBlankImage($width=4,$height=7) {
	//bild generieren
	$ImageOut = ImageCreate($width,$height);
	$White = ImageColorAllocate($ImageOut, 255,255,255);
	$FC=$White;
	$BG=$White;
	$TC=$BG;
	ImageColorTransparent($ImageOut, $TC);
	ImageFill($ImageOut, 0, 0, $BG);
	Imageinterlace($ImageOut, 1);
	return $ImageOut;
}




?>