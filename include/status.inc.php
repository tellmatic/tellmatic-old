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
include_once ($tm_includepath."/libchart-1.1/libchart.php");

$_MAIN_DESCR=___("Status");
$_MAIN_MESSAGE.="";

$NEWSLETTER=new tm_NL();
$ADDRESS=new tm_ADR();
$QUEUE=new tm_Q();
$FORMULAR=new tm_FRM();


$shownlgURLPara=$mSTDURL;
$shownlgURLPara->addParam("act","nl_grp_list");
$shownlgURLPara->addParam("s","s_menu_nl,s_menu_st");
$shownlgURLPara_=$shownlgURLPara->getAllParams();

$shownlURLPara=$mSTDURL;
$shownlURLPara->addParam("s","s_menu_nl,s_menu_st");

$showformURLPara=$mSTDURL;
$showformURLPara->addParam("s","s_menu_frm,s_menu_st");

$showadrURLPara=$mSTDURL;
$showadrURLPara->addParam("act","statistic");
$showadrURLPara->addParam("s","s_menu_adr,s_menu_st");
$showadrURLPara->addParam("set","adr");

$showadrgURLPara=$mSTDURL;
$showadrgURLPara->addParam("act","statistic");
$showadrgURLPara->addParam("s","s_menu_adr,s_menu_st");
$showadrgURLPara->addParam("set","adrg");

$showgrpURLPara=$mSTDURL;
$showgrpURLPara->addParam("act","adr_grp_list");
$showgrpURLPara->addParam("s","s_menu_adr,s_menu_st");

//$showadrURLPara->addParam("set","search");//wird nicht mehr benoteigt.... suchmaske bestandteil der liste!
$showadrURLPara_=$showadrURLPara->getAllParams();
$showgrpURLPara_=$showgrpURLPara->getAllParams();


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Gesamt nach Status
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$_MAIN_OUTPUT.="<br><center><table border=0><tr><td valign=top align=left>";// width=50%<h1>".___("Gesamtstatus")."</h1><br>

////////////////////////////////////////////////////////////////////////////////////////
//Adressen-Gruppen
////////////////////////////////////////////////////////////////////////////////////////
//prepare chart
	$chart = new HorizontalChart(640,360);
	$chart->setLogo($tm_imgpath."/blank.png");//tellmatic_logo_256.png
	$_MAIN_OUTPUT.= "<br><img alt=\"Chart\"  src=\"".$tm_URL_FE."/".$tm_reportdir."/status_adrg_total_".TM_TODAY.".png\"><br>";

//	function getGroup($id=0,$adr_id=0,$frm_id=0,$count=0) {
$AG=$ADDRESS->getGroup(0,0,0,1);//count!
$agc=count($AG);
$ac=$ADDRESS->countAdr();
$showadrURLPara->delParam("email");
$showadrURLPara->delParam("adr_id");
$showadrURLPara->addParam("act","adr_list");
$showadrURLPara_=$showadrURLPara->getAllParams();
$_MAIN_OUTPUT.="<a href=\"".$tm_URL."/".$showadrURLPara_."\">".sprintf(___("%s Adressen"),$ac)."</a> ::: <a href=\"".$tm_URL."/".$showgrpURLPara_."\">".sprintf(___("%s Gruppen"),$agc)."</a><br>";

for ($agcc=0; $agcc<$agc; $agcc++) {

	$showadrgURLPara->addParam("adr_grp_id",$AG[$agcc]['id']);
	$showadrgURLPara_=$showadrgURLPara->getAllParams();
	$_MAIN_OUTPUT.="<a href=\"".$tm_URL."/".$showadrgURLPara_."\">".$AG[$agcc]['name']."</a> :".$AG[$agcc]['adr_count']." ".___("Adressen")."<br>";
//add values to chart
	$adc_pc=$AG[$agcc]['adr_count']/($ac/100);//anteil in prozent
	$chart->addPoint(new Point($AG[$agcc]['name']." (".number_format($adc_pc, 2, ',', '')."%)", $AG[$agcc]['adr_count']));
}

$_MAIN_OUTPUT.="</td></tr><tr><td valign=top align=left>";// width=50%

//create chart
	$chart->setTitle(___("Adressgruppen ").TM_TODAY);
	$chart->render($tm_reportpath."/status_adrg_total_".TM_TODAY.".png");

////////////////////////////////////////////////////////////////////////////////////////
//Adressen:
////////////////////////////////////////////////////////////////////////////////////////
//prepare chart
	#$chart = new PieChart(640,480);
	$chart = new HorizontalChart(640,360);
	$chart->setLogo($tm_imgpath."/blank.png");//tellmatic_logo_256.png
	$_MAIN_OUTPUT.= "<br><img alt=\"Chart\"  src=\"".$tm_URL_FE."/".$tm_reportdir."/status_adr_total_".TM_TODAY.".png\"><br>";
//
$AG=$ADDRESS->getGroup();
$agc=count($AG);
$chart->addPoint(new Point(___("Summe")." (100%)", $ac));
$showadrURLPara->delParam("email");
$showadrURLPara->delParam("adr_id");
$showadrURLPara->addParam("act","adr_list");
$showadrURLPara_=$showadrURLPara->getAllParams();
$asc=count($STATUS['adr']['status']);
for ($ascc=1; $ascc<=$asc; $ascc++)//0
{
	$search['status']=$ascc;
	$showadrURLPara->addParam("s_status",$ascc);
	$showadrURLPara_=$showadrURLPara->getAllParams();
	$adc=$ADDRESS->countADR(0,$search);
	$_MAIN_OUTPUT.="<br>".
						"&nbsp;&nbsp;&nbsp;<a href=\"".$tm_URL."/".$showadrURLPara_."\">".$adc."</a>".
							"&nbsp;".tm_icon($STATUS['adr']['statimg'][$ascc],$STATUS['adr']['status'][$ascc]).
							"&nbsp;".$STATUS['adr']['status'][$ascc].
							"&nbsp;(".$STATUS['adr']['descr'][$ascc].")	";

//add values to chart
	$adc_pc=$adc/($ac/100);//anteil in prozent
	$chart->addPoint(new Point($STATUS['adr']['status'][$ascc]." (".number_format($adc_pc, 2, ',', '')."%)", $adc));
}
//create chart
	$chart->setTitle(___("Adressen ").TM_TODAY);
	$chart->render($tm_reportpath."/status_adr_total_".TM_TODAY.".png");

////////////////////////////////////////////////////////////////////////////////////////

$_MAIN_OUTPUT.="</td></tr><tr><td valign=top align=left>";// width=50%

////////////////////////////////////////////////////////////////////////////////////////
//Newsletter Queue:
////////////////////////////////////////////////////////////////////////////////////////
//prepare chart
	$chart = new HorizontalChart(640,360);
	$chart->setLogo($tm_imgpath."/blank.png");//tellmatic_logo_256.png
	$_MAIN_OUTPUT.= "<br><img alt=\"Chart\"  src=\"".$tm_URL_FE."/".$tm_reportdir."/status_q_total_".TM_TODAY.".png\"><br>";
$NG=$NEWSLETTER->getGroup();
$nlgc=count($NG);
$N=$NEWSLETTER->getNLID();//$group
$nlc=count($N);
$hc=$QUEUE->countH();
//add total value to graph
$chart->addPoint(new Point(___("Summe")." (100%)", $hc));
$shownlURLPara->addParam("act","nl_list");
$shownlURLPara->addParam("set","");
$shownlURLPara->delParam("nl_id","");
$shownlURLPara_=$shownlURLPara->getAllParams();
$_MAIN_OUTPUT.="<a href=\"".$tm_URL."/".$shownlURLPara_."\">".sprintf(___("%s Newsletter"),$nlc)."</a> ::: <a href=\"".$tm_URL."/".$shownlgURLPara_."\">".sprintf(___("%s Gruppen"),$nlgc)."</a>";
$_MAIN_OUTPUT.="<br><br><b>".sprintf(___("Insgesamt %s Mails im Versand:"),$hc)."</b>";
$hsc=count($STATUS['h']['status']);
for ($hscc=1; $hscc<=$hsc; $hscc++)//0
{
	$qc=$QUEUE->countH(0,0,0,0,$hscc);
	$_MAIN_OUTPUT.="<br>".
						"&nbsp;&nbsp;&nbsp;".$qc.
							"&nbsp;".tm_icon($STATUS['h']['statimg'][$hscc],$STATUS['h']['status'][$hscc]).
							"&nbsp;".$STATUS['h']['status'][$hscc].
							"&nbsp;(".$STATUS['h']['descr'][$hscc].")";
	//add values to chart
	$qc_pc=$qc/($hc/100);//anteil in prozent
	$chart->addPoint(new Point($STATUS['h']['status'][$hscc]." (".number_format($qc_pc, 2, ',', '')."%)", $qc));
}
//create chart
	$chart->setTitle(___("Newsletter Queue ").TM_TODAY);
	$chart->render($tm_reportpath."/status_q_total_".TM_TODAY.".png");
////////////////////////////////////////////////////////////////////////////////////////

$_MAIN_OUTPUT.="</td></tr>".
					"</table>".
					"</center>";

$_MAIN_OUTPUT.= "<br><br>";
?>