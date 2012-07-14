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

$InputName_Submit="submit";
$InputName_Reset="reset";

//Form
$Form=new tm_SimpleForm();
$FormularName="queue_new";
//make new Form
$Form->new_Form($FormularName,$_SERVER["PHP_SELF"],"post","_self");
$Form->set_FormJS($FormularName," onSubmit=\"switchSection('div_loader');\" OnChange=\"checkQNewLimitOffset();\" onClick=\"checkQNewLimitOffset();\"");
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
$Form->set_InputJS($FormularName,$InputName_NL," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_NL,$nl_id);
$Form->set_InputStyleClass($FormularName,$InputName_NL,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_NL,___("Newsletter wählen"));
$Form->set_InputReadonly($FormularName,$InputName_NL,false);
$Form->set_InputOrder($FormularName,$InputName_NL,1);
$Form->set_InputLabel($FormularName,$InputName_NL,"");
$Form->set_InputSize($FormularName,$InputName_NL,0,5);
$Form->set_InputMultiple($FormularName,$InputName_NL,false);
//add Data
$NEWSLETTER=new tm_NL();
$NL=$NEWSLETTER->getNL();
$nc=count($NL);
for ($ncc=0; $ncc<$nc; $ncc++)
{
	if ($NL[$ncc]['aktiv']==1 && $NL[$ncc]['is_template']==0) {
		$NLOpt=display($NL[$ncc]['subject']);
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
$Form->set_InputJS($FormularName,$InputName_Group," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Group,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_Group,___("Gruppen wählen, STRG/CTRL gedrückt halten und klicken f. Mehrfachauswahl"));
$Form->set_InputReadonly($FormularName,$InputName_Group,false);
$Form->set_InputOrder($FormularName,$InputName_Group,2);
$Form->set_InputLabel($FormularName,$InputName_Group,"");
$Form->set_InputSize($FormularName,$InputName_Group,0,5);
$Form->set_InputMultiple($FormularName,$InputName_Group,true);
//add Data
$ADDRESS=new tm_ADR();
$GRP=$ADDRESS->getGroup(0,0,0,1);
$acg=count($GRP);
for ($accg=0; $accg<$acg; $accg++)
{
	if ($GRP[$accg]['aktiv']==1) {
		$Form->add_InputOption($FormularName,$InputName_Group,$GRP[$accg]['id'],display($GRP[$accg]['name'])." (".$GRP[$accg]['adr_count']." ".___("Adressen").")");
	}
}

//use blacklist?
	$Form->new_Input($FormularName,$InputName_Blacklist,"checkbox", 1);
	$Form->set_InputJS($FormularName,$InputName_Blacklist," onChange=\"flash('submit','#ff0000');\"");
	$Form->set_InputDefault($FormularName,$InputName_Blacklist,1);
	$Form->set_InputStyleClass($FormularName,$InputName_Blacklist,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_Blacklist,48,256);
	$Form->set_InputDesc($FormularName,$InputName_Blacklist,___("Blacklist prüfen"));
	$Form->set_InputReadonly($FormularName,$InputName_Blacklist,false);
	$Form->set_InputOrder($FormularName,$InputName_Blacklist,6);
	$Form->set_InputLabel($FormularName,$InputName_Blacklist,"");

//send now
	$Form->new_Input($FormularName,$InputName_Send,"checkbox", 1);
	$Form->set_InputJS($FormularName,$InputName_Send," onChange=\"flash('submit','#ff0000');\"");
	$Form->set_InputDefault($FormularName,$InputName_Send,1);
	$Form->set_InputStyleClass($FormularName,$InputName_Send,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_Send,48,256);
	$Form->set_InputDesc($FormularName,$InputName_Send,___("Versandliste sofort aktivieren"));
	$Form->set_InputReadonly($FormularName,$InputName_Send,false);
	$Form->set_InputOrder($FormularName,$InputName_Send,8);
	$Form->set_InputLabel($FormularName,$InputName_Send,"");

//Autogen
	$Form->new_Input($FormularName,$InputName_Autogen,"checkbox", 1);
	$Form->set_InputJS($FormularName,$InputName_Autogen," onChange=\"flash('submit','#ff0000');\"");
	$Form->set_InputDefault($FormularName,$InputName_Autogen,1);
	$Form->set_InputStyleClass($FormularName,$InputName_Autogen,"mFormText","mFormTextFocus");
	$Form->set_InputSize($FormularName,$InputName_Send,48,256);
	$Form->set_InputDesc($FormularName,$InputName_Autogen,___("Versand automatisch starten / Empfängerliste automatisch aktualisieren"));
	$Form->set_InputReadonly($FormularName,$InputName_Autogen,false);
	$Form->set_InputOrder($FormularName,$InputName_Autogen,7);
	$Form->set_InputLabel($FormularName,$InputName_Autogen,"");

//send_at_date
$Form->new_Input($FormularName,$InputName_SendAt,"text", $send_at_date);
$Form->set_InputJS($FormularName,$InputName_SendAt," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_SendAt,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_SendAt,20,30);
$Form->set_InputDesc($FormularName,$InputName_SendAt,___("Datum des terminierten Versands"));
$Form->set_InputReadonly($FormularName,$InputName_SendAt,false);
$Form->set_InputOrder($FormularName,$InputName_SendAt,3);
$Form->set_InputLabel($FormularName,$InputName_SendAt,"");



//send_at_h
$Form->new_Input($FormularName,$InputName_SendAtTimeH,"select", "");
$Form->set_InputJS($FormularName,$InputName_SendAtTimeH," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_SendAtTimeH,$$InputName_SendAtTimeH);
$Form->set_InputStyleClass($FormularName,$InputName_SendAtTimeH,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_SendAtTimeH,___("Stunde"));
$Form->set_InputReadonly($FormularName,$InputName_SendAtTimeH,false);
$Form->set_InputOrder($FormularName,$InputName_SendAtTimeH,4);
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
$Form->set_InputJS($FormularName,$InputName_SendAtTimeM," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_SendAtTimeM,$$InputName_SendAtTimeM);
$Form->set_InputStyleClass($FormularName,$InputName_SendAtTimeM,"mFormSelect","mFormSelectFocus");
$Form->set_InputDesc($FormularName,$InputName_SendAtTimeM,___("Minute"));
$Form->set_InputReadonly($FormularName,$InputName_SendAtTimeH,false);
$Form->set_InputOrder($FormularName,$InputName_SendAtTimeM,5);
$Form->set_InputLabel($FormularName,$InputName_SendAtTimeM,"");
$Form->set_InputSize($FormularName,$InputName_SendAtTimeM,0,1);
$Form->set_InputMultiple($FormularName,$InputName_SendAtTimeM,false);
//add Data
for ($m=0; $m<60; $m++)
{
		$Form->add_InputOption($FormularName,$InputName_SendAtTimeM,$m,$m."");
}

//offset
$Form->new_Input($FormularName,$InputName_Offset,"text", $$InputName_Offset);
$Form->set_InputJS($FormularName,$InputName_Offset," onChange=\"flash('submit','#ff0000');\" onKeyUp=\"RemoveInvalidChars(this, '[^0-9]');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Offset,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Offset,20,8);
$Form->set_InputDesc($FormularName,$InputName_Offset,___("Offset"));
$Form->set_InputReadonly($FormularName,$InputName_Offset,false);
$Form->set_InputOrder($FormularName,$InputName_Offset,10);
$Form->set_InputLabel($FormularName,$InputName_Offset,"");

//limit
$Form->new_Input($FormularName,$InputName_Limit,"text", $$InputName_Limit);
$Form->set_InputJS($FormularName,$InputName_Limit," onChange=\"flash('submit','#ff0000');\" onKeyUp=\"RemoveInvalidChars(this, '[^1-90]');\" ");
$Form->set_InputStyleClass($FormularName,$InputName_Limit,"mFormText","mFormTextFocus");
$Form->set_InputSize($FormularName,$InputName_Limit,20,8);
$Form->set_InputDesc($FormularName,$InputName_Limit,___("Limit"));
$Form->set_InputReadonly($FormularName,$InputName_Limit,false);
$Form->set_InputOrder($FormularName,$InputName_Limit,11);
$Form->set_InputLabel($FormularName,$InputName_Limit,"");

//HOST
$Form->new_Input($FormularName,$InputName_Host,"select", "");
$Form->set_InputJS($FormularName,$InputName_Host," onChange=\"flash('submit','#ff0000');\" ");
$Form->set_InputDefault($FormularName,$InputName_Host,$$InputName_Host);
$Form->set_InputStyleClass($FormularName,$InputName_Host,"mFormSelect","mFormSelectFocus");
$Form->set_InputSize($FormularName,$InputName_Host,1,1);
$Form->set_InputDesc($FormularName,$InputName_Host,___("SMTP Server auswählen"));
$Form->set_InputReadonly($FormularName,$InputName_Host,false);
$Form->set_InputOrder($FormularName,$InputName_Host,9);
$Form->set_InputLabel($FormularName,$InputName_Host,"");
$Form->set_InputMultiple($FormularName,$InputName_Host,false);
#Hostliste....
//smtp hosts
$HOST_=$HOSTS->getHost(0,Array("aktiv"=>1, "type"=>"smtp"));//id,filter
$hcg=count($HOST_);
for ($hccg=0; $hccg<$hcg; $hccg++)
{
		$Form->add_InputOption($FormularName,$InputName_Host,$HOST_[$hccg]['id'],display($HOST_[$hccg]['name']));
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

/*DISPLAY*/
$_MAIN_OUTPUT.= $Form->FORM[$FormularName]['head'];
//hidden fieldsnicht vergessen!
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['act']['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName]['set']['html'];
$_MAIN_OUTPUT.= "<table border=0>";
$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\">".tm_icon("newspaper.png",___("Newsletter"))."&nbsp;".___("Newsletter")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_NL]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=\"middle\">";
$_MAIN_OUTPUT.= "".___("versenden an:");
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "<td valign=\"top\">".tm_icon("group.png",___("Gruppen"))."&nbsp;".___("Gruppen")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Group]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\" colspan=3>".tm_icon("calendar.png",___("Versanddatum"))."&nbsp;".___("Versand starten am:")."<br>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_SendAt]['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_SendAtTimeH]['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_SendAtTimeM]['html'];
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\" colspan=3>";
$_MAIN_OUTPUT.= "<br>".tm_icon("ruby.png",___("Blacklist prüfen"))."&nbsp;".___("Blacklist prüfen");
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Blacklist]['html']."&nbsp;&nbsp;";
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\" colspan=3>";
$_MAIN_OUTPUT.= "<br>".tm_icon("cog.png",___("Versand automatisch starten / Empfängerliste automatisch aktualisieren"))."&nbsp;".___("Versand automatisch starten / Empfängerliste automatisch aktualisieren");
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Autogen]['html']."&nbsp;&nbsp;";
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\" colspan=3>";
$_MAIN_OUTPUT.= "<br>".tm_icon("hourglass.png",___("Versandliste sofort erstellen"))."&nbsp;".___("Versandliste sofort erstellen");
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Send]['html']."&nbsp;&nbsp;";
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";

$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\" colspan=3>";
$_MAIN_OUTPUT.= "<br>".tm_icon("server.png",___("Mail-Server"))."&nbsp;".___("Mail-Server");
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Host]['html']."&nbsp;&nbsp;";
$_MAIN_OUTPUT.= "</td>";
$_MAIN_OUTPUT.= "</tr>";


$_MAIN_OUTPUT.= "<tr>";
$_MAIN_OUTPUT.= "<td valign=\"top\" colspan=3>";
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Submit]['html'];
$_MAIN_OUTPUT.= $Form->INPUT[$FormularName][$InputName_Reset]['html'];
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