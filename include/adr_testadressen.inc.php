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
exit;//remove this line or add # in front of line

$_MAIN_DESCR=___("Testadressen erzeugen");
$_MAIN_MESSAGE.="";

//CONFIG
	//anzahl adressen / how many addresses:
	$max_adr=10;
	//gruppen ids / group ids
	$adr_grp[0]=1;
	#$adr_grp[1]=2;
	#$adr_grp[2]=2;
//CONFIG END

if (!DEMO && $user_is_admin) {
	$created=date("Y-m-d H:i:s");
	$f_text="0123456789abcdefghijklmnopqrstuvwxyz";
	$author=$LOGIN->USER['name'];
	$rnd=rand(111111,999999); 
	$gc=count($adr_grp);
	$_MAIN_MESSAGE.="<br>".sprintf(___("Erstelle %s Testadressen in der(den) Gruppe(n) :"),$max_adr);
	$ADDRESS=new tm_ADR();
	for ($gcc=0;$gcc<$gc;$gcc++) {
		$GRP=$ADDRESS->getGroup($adr_grp[$gcc]);
		$_MAIN_MESSAGE.="<br>".display($GRP[0]['name']);
	}
	for ($adr_c=0;$adr_c<$max_adr;$adr_c++) {
			$code=$adr_c+$rnd;
			$email="test_".$adr_c."_".$code."@tellmatic.org";
			//random status?
			#$status=rand(1,12);
			//fixed status
			$status=2;//2:new
			$ADDRESS->addAdr(Array(
							"email"=>$email,
							"aktiv"=>1, 
							"created"=>$created, 
							"author"=>$author, 
							"status"=>$status, 
							"code"=>$code,
							"memo"=>"$adr_c testadressen",
							"f0"=>"f0_".$code,
							"f1"=>"f1_".$code,
							"f2"=>"f2_".$code,
							"f3"=>$f_text,
							"f4"=>$f_text,
							"f5"=>$f_text,
							"f6"=>$f_text,
							"f7"=>$f_text,
							"f8"=>$f_text,
							"f9"=>$f_text
							),
							$adr_grp);
	}//for
}//is user_is_admin
?>