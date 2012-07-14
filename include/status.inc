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

$_MAIN_DESCR=___("Status");
$_MAIN_MESSAGE.="";

$NEWSLETTER=new mnlNL();
$ADDRESS=new mnlADR();
$QUEUE=new mnlQ();
$FORMULAR=new mnlFRM();


$shownlgURLPara=$mSTDURL;
$shownlgURLPara->addParam("act","nl_grp_list");
$shownlgURLPara_=$shownlgURLPara->getAllParams();

$shownlURLPara=$mSTDURL;

$showformURLPara=$mSTDURL;

$showadrURLPara=$mSTDURL;
$showadrURLPara->addParam("act","statistic");
$showadrURLPara->addParam("set","adr");

$showgrpURLPara=$mSTDURL;
$showgrpURLPara->addParam("act","adr_grp_list");

//$showadrURLPara->addParam("set","search");//wird nicht mehr benoteigt.... suchmaske bestandteil der liste!
$showadrURLPara_=$showadrURLPara->getAllParams();
$showgrpURLPara_=$showgrpURLPara->getAllParams();




$_MAIN_OUTPUT.="<br><center><b>".sprintf(___("TOP %s"),"5")."</b><br><table border=0 ><tr><td width=50% valign=top align=left>";

//NL Views
$_MAIN_OUTPUT.="<b>".sprintf(___("TOP %s - Newsletter"),"5")."</b>";
$_MAIN_OUTPUT.="<br><b>".___("Views")."</b>";
$shownlURLPara->addParam("act","statistic");
$shownlURLPara->addParam("set","nl");
$NL=$NEWSLETTER->getNL(0,0,5,0,0,"views",1);
$nc=count($NL);
for ($ncc=0;$ncc<$nc;$ncc++) {
	if (!empty($NL[$ncc]['views'])) {
		$shownlURLPara->addParam("nl_id",$NL[$ncc]['id']);
		$shownlURLPara_=$shownlURLPara->getAllParams();
		$_MAIN_OUTPUT.="<br>".($ncc+1).".) <a href=\"".$mnl_URL."/".$shownlURLPara_."\">".$NL[$ncc]['subject']."</a> (".$NL[$ncc]['views'].")";
	}
}

//NL - Clicks
$_MAIN_OUTPUT.="<br><b>".___("Klicks")."</b>";
$NL=$NEWSLETTER->getNL(0,0,5,0,0,"clicks",1);
$nc=count($NL);
for ($ncc=0;$ncc<$nc;$ncc++) {
	if (!empty($NL[$ncc]['clicks'])) {
		$shownlURLPara->addParam("nl_id",$NL[$ncc]['id']);
		$shownlURLPara_=$shownlURLPara->getAllParams();
		$_MAIN_OUTPUT.="<br>".($ncc+1).".) <a href=\"".$mnl_URL."/".$shownlURLPara_."\">".$NL[$ncc]['subject']."</a> (".$NL[$ncc]['clicks'].")";
	}
}

//FORMS

$_MAIN_OUTPUT.="<b>".sprintf(___("TOP %s - Formulare"),"5")."</b>";
$_MAIN_OUTPUT.="<br><b>".___("Anmeldungen")."</b>";
$showformURLPara->addParam("act","statistic");
$showformURLPara->addParam("set","form");
$FRM=$FORMULAR->getForm(0,0,5,0,"subscriptions",1);
$fc=count($FRM);
for ($fcc=0;$fcc<$fc;$fcc++) {
	if (!empty($FRM[$fcc]['subscriptions'])) {
		$showformURLPara->addParam("frm_id",$FRM[$fcc]['id']);
		$showformURLPara_=$showformURLPara->getAllParams();
		$_MAIN_OUTPUT.="<br>".($fcc+1).".) <a href=\"".$mnl_URL."/".$showformURLPara_."\">".$FRM[$fcc]['name']."</a> (".$FRM[$fcc]['subscriptions'].")";
	}
}


//LESER - Views
$_MAIN_OUTPUT.="</td><td width=50% valign=top align=left>";

$_MAIN_OUTPUT.="<b>".sprintf(___("TOP %s - Abonnenten"),"5")."</b>";
$_MAIN_OUTPUT.="<br><b>".___("Views")."</b>";
$ADR=$ADDRESS->getAdr(0,0,5,0,Array(),"views",1);
$ac=count($ADR);
for ($acc=0;$acc<$ac;$acc++) {
	if (!empty($ADR[$acc]['views'])) {
		$showadrURLPara->addParam("email",$ADR[$acc]['email']);
		$showadrURLPara->addParam("adr_id",$ADR[$acc]['id']);
		$showadrURLPara_=$showadrURLPara->getAllParams();
		$_MAIN_OUTPUT.="<br>".($acc+1).".) <a href=\"".$mnl_URL."/".$showadrURLPara_."\">".$ADR[$acc]['email']."</a> (".$ADR[$acc]['views'].")";
	}
}
//LESER - Clicks
$_MAIN_OUTPUT.="<br><b>".___("Klicks")."</b>";
$ADR=$ADDRESS->getAdr(0,0,5,0,Array(),"clicks",1);
$ac=count($ADR);
for ($acc=0;$acc<$ac;$acc++) {
	if (!empty($ADR[$acc]['clicks'])) {
		$showadrURLPara->addParam("email",$ADR[$acc]['email']);
		$showadrURLPara->addParam("adr_id",$ADR[$acc]['id']);
		$showadrURLPara_=$showadrURLPara->getAllParams();
		$_MAIN_OUTPUT.="<br>".($acc+1).".) <a href=\"".$mnl_URL."/".$showadrURLPara_."\">".$ADR[$acc]['email']."</a> (".$ADR[$acc]['clicks'].")";
	}
}
//LESER - NL
$_MAIN_OUTPUT.="<br><b>".___("Anz. empfangene NL")."</b>";
$ADR=$ADDRESS->getAdr(0,0,5,0,Array(),"newsletter",1);
$ac=count($ADR);
for ($acc=0;$acc<$ac;$acc++) {
	if (!empty($ADR[$acc]['newsletter'])) {
		$showadrURLPara->addParam("email",$ADR[$acc]['email']);
		$showadrURLPara->addParam("adr_id",$ADR[$acc]['id']);
		$showadrURLPara_=$showadrURLPara->getAllParams();
		$_MAIN_OUTPUT.="<br>".($acc+1).".) <a href=\"".$mnl_URL."/".$showadrURLPara_."\">".$ADR[$acc]['email']."</a> (".$ADR[$acc]['newsletter'].")";
	}
}
$_MAIN_OUTPUT.="</td></tr>".
						"<tr><td colspan=2 align=center><font size=-1>(".sprintf(___("Die TOP %s Liste  z&auml;hlt auch doppelte Klicks und Views!"),"5").")</font></td></tr>".
						"</table></center>";



//Gesamt nach Status

$_MAIN_OUTPUT.="<br><br>";

$_MAIN_OUTPUT.="<br><center><b>".___("Gesamtstatus")."</b><br><table border=0><tr><td width=50% valign=top align=left>";

//Newsletter:
$NG=$NEWSLETTER->getGroup();
$nlgc=count($NG);
$N=$NEWSLETTER->getNLID();//$group
$nlc=count($N);
$hc=$QUEUE->countH();
//countH($q_id=0,$nl_id=0,$grp_id=0,$adr_id=0,$status=0)
$shownlURLPara->addParam("act","nl_list");
$shownlURLPara->addParam("set","");
$shownlURLPara_=$shownlURLPara->getAllParams();
$_MAIN_OUTPUT.="<a href=\"".$mnl_URL."/".$shownlURLPara_."\">".sprintf(___("%s Newsletter"),$nlc)."</a> ::: <a href=\"".$mnl_URL."/".$shownlgURLPara_."\">".sprintf(___("%s Gruppen"),$nlgc)."</a>";
$_MAIN_OUTPUT.="<br><br>".sprintf(___("Insgesamt %s Mails im Versand:"),$hc);
$hsc=count($STATUS['h']['status']);
for ($hscc=1; $hscc<=$hsc; $hscc++)//0
{
	$_MAIN_OUTPUT.="<br>".
						"&nbsp;&nbsp;&nbsp;".$QUEUE->countH(0,0,0,0,$hscc).
							"&nbsp;<img src=\"".$mnl_iconURL."/".$STATUS['h']['statimg'][$hscc]."\" border=\"0\">".
							"&nbsp;".$STATUS['h']['status'][$hscc].
							"&nbsp;(".$STATUS['h']['descr'][$hscc].")";
}
$_MAIN_OUTPUT.="</td><td width=50% valign=top align=left>";

//Adressen:
$AG=$ADDRESS->getGroup();
$agc=count($AG);
$ac=$ADDRESS->countADR();
//countADR($group_id=0,$search=Array())
$showadrURLPara->delParam("email");
$showadrURLPara->delParam("adr_id");
$showadrURLPara->addParam("act","adr_list");
$showadrURLPara_=$showadrURLPara->getAllParams();
$_MAIN_OUTPUT.="<a href=\"".$mnl_URL."/".$showadrURLPara_."\">".sprintf(___("%s Newsletter"),$ac)."</a> ::: <a href=\"".$mnl_URL."/".$showgrpURLPara_."\">".sprintf(___("%s Gruppen"),$agc)."</a>";
$asc=count($STATUS['adr']['status']);
for ($ascc=1; $ascc<=$asc; $ascc++)//0
{
	$search['status']=$ascc;
	$showadrURLPara->addParam("status",$ascc);
	$showadrURLPara_=$showadrURLPara->getAllParams();
	$_MAIN_OUTPUT.="<br>".
						"&nbsp;&nbsp;&nbsp;<a href=\"".$mnl_URL."/".$showadrURLPara_."\">".$ADDRESS->countADR(0,$search)."</a>".
							"&nbsp;<img src=\"".$mnl_iconURL."/".$STATUS['adr']['statimg'][$ascc]."\" border=\"0\">".
							"&nbsp;".$STATUS['adr']['status'][$ascc].
							"&nbsp;(".$STATUS['adr']['descr'][$ascc].")	";
}
$_MAIN_OUTPUT.="</td></tr>".
					"</table>".
					"</center>";

$_MAIN_OUTPUT.= "<br><br><br><br>";
?>