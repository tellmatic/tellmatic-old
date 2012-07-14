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

$_MAIN_DESCR="neue Adresse eintragen";
$_MAIN_MESSAGE.="";

$set=getVar("set");
$adr_id=0;
$created=date("Y-m-d H:i:s");
$author=$_SERVER['PHP_AUTH_USER'];

//field names for query
$InputName_Group="adr_grp";//range from
//$$InputName_Group=getVar($InputName_Group);
pt_register("POST","adr_grp");
if (!isset($adr_grp)) {
	$adr_grp[0]=getVar("adr_grp_id");
}

$InputName_Name="email";//betreff
$$InputName_Name=getVar($InputName_Name);

$InputName_Aktiv="aktiv";//range from
$$InputName_Aktiv=getVar($InputName_Aktiv);

$InputName_Status="status";//
$$InputName_Status=getVar($InputName_Status);

$InputName_F0="f0";//range from
$$InputName_F0=getVar($InputName_F0);
$InputName_F1="f1";//range from
$$InputName_F1=getVar($InputName_F1);
$InputName_F2="f2";//range from
$$InputName_F2=getVar($InputName_F2);
$InputName_F3="f3";//range from
$$InputName_F3=getVar($InputName_F3);
$InputName_F4="f4";//range from
$$InputName_F4=getVar($InputName_F4);
$InputName_F5="f5";//range from
$$InputName_F5=getVar($InputName_F5);
$InputName_F6="f6";//range from
$$InputName_F6=getVar($InputName_F6);
$InputName_F7="f7";//range from
$$InputName_F7=getVar($InputName_F7);
$InputName_F8="f8";//range from
$$InputName_F8=getVar($InputName_F8);
$InputName_F9="f9";//range from
$$InputName_F9=getVar($InputName_F9);

$check=true;
if ($set=="save") {
	//checkinput
	if (empty($email)) {$check=false;$_MAIN_MESSAGE.="<br>e-Mail sollte nicht leer sein.";}
	//email auf gueltigkeit pruefen
	if (!checkemailadr($email,$EMailcheck_Intern)) {$check=false;$_MAIN_MESSAGE.="<br>e-Mail ist nicht korrekt oder Domain ist nicht gueltig.";}
	if ($check) {

		$ADDRESS=new mnlADR();	
		///////////////////////////
		//dublettencheck
		$search['email']=$email;
		//auf existenz pruefen und wenn email noch nicht existiert dann eintragen.
		$ADR=$ADDRESS->getAdr(0,0,0,0,$search);
		$ac=count($ADR);
		//oh! adresse ist bereits vorhanden!
		//wir diffen die gruppen und fuegen nur die referenzen hinzu die noch nicht existieren!
		$new_adr_grp=$adr_grp;
		$adr_exists=false;
		if ($ac>0) {
	//				$check=false;
			//gruppen denen die adr bereits  angehoert
			$old_adr_grp = $ADDRESS->getGroupID(0,$ADR[0]['id'],0);
			//neue gruppen nur die die neu sind, denen die adr noch nicht angehoert!
			//adr_grp=gruppen aus dem formular
			$new_adr_grp = array_diff($adr_grp,$old_adr_grp);
			$all_adr_grp = array_merge($old_adr_grp, $new_adr_grp);
	
	/*
			print_r($adr_grp);echo "<hr>";
			print_r($old_adr_grp);echo "<hr>";
			print_r($new_adr_grp);echo "<hr>";
			print_r($all_adr_grp);echo "<hr>";
	*/
			$adr_exists=true;
		}
		//////////////////////	
	
		if ($adr_exists) {
			//wenn adresse existiert, adressdaten updaten!
			//
			$code=$ADR[0]['code'];
			$ADDRESS->updateAdr(Array(
				"id"=>$ADR[0]['id'],
				"email"=>$email,
				"aktiv"=>$aktiv,
				"created"=>$created, 
				"author"=>$author, 
				"f0"=>$f0,
				"f1"=>$f1,
				"f2"=>$f2,
				"f3"=>$f3,
				"f4"=>$f4,
				"f5"=>$f5,
				"f6"=>$f6,
				"f7"=>$f7,
				"f8"=>$f8,
				"f9"=>$f9 
				),
				$all_adr_grp);
			//
			//und neue referenzen zu neuen gruppen hinzufuegen
			//$ADDRESS->addRef($ADR[0]['id'],$new_adr_grp);
			// ^^^ nur fuer den fall das daten nicht geupdated werden!!! sondern nur referenzen hinzugefuegt!
			//optional nachzuruesten und in den settings einstellbar :)
			$_MAIN_MESSAGE.="<br>e-Mail existiert bereits. Die Daten wurden aktualisiert.";
		} else {
			//wenn adresse noch nicht existiert , neu anlegen	
			srand((double)microtime()*1000000); 
			$code=rand(111111,999999); 
	
			$ADDRESS->addAdr(Array(
					"email"=>$email,
					"aktiv"=>$aktiv, 
					"created"=>$created,
					"author"=>$author, 
					"status"=>$status, 
					"code"=>$code, 
					"f0"=>$f0,
					"f1"=>$f1,
					"f2"=>$f2,
					"f3"=>$f3,
					"f4"=>$f4,
					"f5"=>$f5,
					"f6"=>$f6,
					"f7"=>$f7,
					"f8"=>$f8,
					"f9"=>$f9 
					),
					$new_adr_grp);
			$_MAIN_MESSAGE.="<br>Neue Adresse '<b>".$email."</b>' wurde angelegt.";
		}

		$action="adr_list";
		include_once ($mnl_includepath."/adr_list.inc");
		
		





	} else {
		include_once ($mnl_includepath."/adr_form.inc");
	}
	
} else {
	include_once ($mnl_includepath."/adr_form.inc");
}
?>