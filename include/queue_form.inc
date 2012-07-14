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

$InputName_Submit="submit";
$InputName_Reset="reset";

//Form
$Form=new mSimpleForm();
$FormularName="queue_new";
//make new Form
$Form->new_Form($FormularName,$_SERVER["PHP_SELF"],"post","_self");
//add a Description
$Form->set_FormDesc($FormularName,___("neuen Q erstellen"));
//variable content aus menu als hidden field!
$Form->new_Input($FormularName,"act", "hidden", $action);
$Form->new_Input($FormularName,"set", "hidden", "save");
//////////////////
//add inputfields and buttons....
//////////////////

//NL
$Form->new_Input($FormularName,$InputName_NL,"select", "");
$Form->set_InputDefault($FormularName,$InputName_NL,$nl_id);
$Form->set_InputStyleClass($FormularName,$InputName_NL,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_NL,___("Newsletter waehlen"));
$Form->set_InputReadonly($FormularName,$InputName_NL,false);
$Form->set_InputOrder($FormularName,$InputName_NL,6);
$Form->set_InputLabel($FormularName,$InputName_NL,"");
$Form->set_InputSize($FormularName,$InputName_NL,0,1);
$Form->set_InputMultiple($FormularName,$InputName_NL,false);
//add Data
$NEWSLETTER=new mnlNL();
$NL=$NEWSLETTER->getNL();
$nc=count($NL);
for ($ncc=0; $ncc<$nc; $ncc++)
{
	if ($NL[$ncc]['aktiv']==1) {
		$NLOpt=$NL[$ncc]['subject'];
		if ($NL[$ncc]['massmail']==1) {
			$NLOpt .="   ".___("(Massenmailing)");
		} else {
			$NLOpt .="   ".___("(personalisiert)");
		}
		$Form->add_InputOption($FormularName,$InputName_NL,$NL[$ncc]['id'],$NLOpt);
	}
}


//Gruppe
$Form->new_Input($FormularName,$InputName_Group,"select", "");
$Form->set_InputStyleClass($FormularName,$InputName_Group,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Group,___("Gruppen waehlen, STRG/CTRL gedrueckt halten und klicken f. Mehrfachauswahl"));
$Form->set_InputReadonly($FormularName,$InputName_Group,false);
$Form->set_InputOrder($FormularName,$InputName_Group,6);
$Form->set_InputLabel($FormularName,$InputName_Group,"");
$Form->set_InputSize($FormularName,$InputName_Group,0,5);
$Form->set_InputMultiple($FormularName,$InputName_Group,true);
//add Data
$ADDRESS=new mnlADR();
$GRP=$ADDRESS->getGroup(0,0,0,1);
$acg=count($GRP);
for ($accg=0; $accg<$acg; $accg++)
{
	if ($GRP[$accg]['aktiv']==1) {
		$Form->add_InputOption($FormularName,$InputName_Group,$GRP[$accg]['id'],$GRP[$accg]['name']." (".$GRP[$accg]['adr_count']." Adressen)");
	}
}


//send now
//Aktiv
	$Form->new_Input($FormularName,$InputName_Send,"checkbox", 1);
	$Form->set_InputDefault($FormularName,$InputName_Send,1);
	$Form->set_InputStyleClass($FormularName,$InputName_Send,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_Send,48,256);
	$Form->set_InputDesc($FormularName,$InputName_Send,___("Versandliste sofort aktivieren"));
	$Form->set_InputReadonly($FormularName,$InputName_Send,false);
	$Form->set_InputOrder($FormularName,$InputName_Send,2);
	$Form->set_InputLabel($FormularName,$InputName_Send,"");
	
//send_at_date
$Form->new_Input($FormularName,$InputName_SendAt,"text", $send_at_date);
$Form->set_InputStyleClass($FormularName,$InputName_SendAt,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_SendAt,20,30);
$Form->set_InputDesc($FormularName,$InputName_SendAt,___("Datum des terminierten Versands"));
$Form->set_InputReadonly($FormularName,$InputName_SendAt,false);
$Form->set_InputOrder($FormularName,$InputName_SendAt,77);
$Form->set_InputLabel($FormularName,$InputName_SendAt,"");



//send_at_h
$Form->new_Input($FormularName,$InputName_SendAtTimeH,"select", "");
$Form->set_InputDefault($FormularName,$InputName_SendAtTimeH,$$InputName_SendAtTimeH);
$Form->set_InputStyleClass($FormularName,$InputName_SendAtTimeH,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_SendAtTimeH,___("Stunde"));
$Form->set_InputReadonly($FormularName,$InputName_SendAtTimeH,false);
$Form->set_InputOrder($FormularName,$InputName_SendAtTimeH,6);
$Form->set_InputLabel($FormularName,$InputName_SendAtTimeH,"");
$Form->set_InputSize($FormularName,$InputName_SendAtTimeH,0,1);
$Form->set_InputMultiple($FormularName,$InputName_SendAtTimeH,false);
//add Data
for ($h=0; $h<24; $h++)
{
		$Form->add_InputOption($FormularName,$InputName_SendAtTimeH,$h,$h." h");
}

//send_at_m
$Form->new_Input($FormularName,$InputName_SendAtTimeM,"select", "");
$Form->set_InputDefault($FormularName,$InputName_SendAtTimeM,$$InputName_SendAtTimeM);
$Form->set_InputStyleClass($FormularName,$InputName_SendAtTimeM,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_SendAtTimeM,___("Minute"));
$Form->set_InputReadonly($FormularName,$InputName_SendAtTimeH,false);
$Form->set_InputOrder($FormularName,$InputName_SendAtTimeM,6);
$Form->set_InputLabel($FormularName,$InputName_SendAtTimeM,"");
$Form->set_InputSize($FormularName,$InputName_SendAtTimeM,0,1);
$Form->set_InputMultiple($FormularName,$InputName_SendAtTimeM,false);
//add Data
for ($m=0; $m<60; $m++)
{
		$Form->add_InputOption($FormularName,$InputName_SendAtTimeM,$m,$m."");
}

//submit button 
$Form->new_Input($FormularName,$InputName_Submit,"submit",___("Speichern"));
$Form->set_InputStyleClass($FormularName,$InputName_Submit,"mFormSubmit","mFormSubmitFocus");
$Form->set_InputDesc($FormularName,$InputName_Submit,"");
$Form->set_InputReadonly($FormularName,$InputName_Submit,false);
$Form->set_InputOrder($FormularName,$InputName_Submit,998);
$Form->set_InputLabel($FormularName,$InputName_Submit,"");

//a reset button
$Form->new_Input($FormularName,$InputName_Reset,"reset",___("Reset"));
$Form->set_InputStyleClass($FormularName,$InputName_Reset,"mFormReset","mFormResetFocus");
$Form->set_InputDesc($FormularName,$InputName_Reset,"Reset");
$Form->set_InputReadonly($FormularName,$InputName_Reset,false);
$Form->set_InputOrder($FormularName,$InputName_Reset,999);
$Form->set_InputLabel($FormularName,$InputName_Reset,"");

/*RENDER FORM*/

$Form->render_Form($FormularName);
//then you dont have to render the head and foot .....

/*DISPLAY*/
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['head'];
//hidden fieldsnicht vergessen!
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['act']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['set']['html'];
$_MAIN_OUTPUT.= "<table border=0>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top>".___("Newsletter")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_NL]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=top colspan=1>";
$_MAIN_OUTPUT.= "<br>".___("versenden an:");
$_MAIN_OUTPUT.= "</td>";

$_MAIN_OUTPUT.= "<td valign=top colspan=1>".___("Gruppen")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Group]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<td valign=top colspan=2>".___("Versand starten am:")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_SendAt]['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_SendAtTimeH]['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_SendAtTimeM]['html'];
$_MAIN_OUTPUT.= "<br>";
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=top colspan=2>";
$_MAIN_OUTPUT.= "<br>".___("Versandliste sofort erstellen");
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Send]['html']."&nbsp;&nbsp;";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Submit]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";
$_MAIN_OUTPUT.= "</table>";
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['foot'];

$_MAIN_OUTPUT.= '
<script type="text/javascript">
  Calendar.setup(
    {
      inputField  : "send_at_date",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      button      : "send_at_date",       // ID of the button
      date			: "",
      firstDay		: 0
    }
  );
</script>
';

?>