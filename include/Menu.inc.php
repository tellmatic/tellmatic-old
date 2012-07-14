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

$_TIMEOUT=sprintf(___("Login verfällt in %s Sekunden."),"<span id=\"timeoutdisplay\" style=\"font-weight:bold;\">".TM_SESSION_TIMEOUT."</span>");

$MENU=Array(
					0 => Array(
						'id'=>'menu_tm',
						'name'=>'Tellmatic',
						'links' => Array(
									0 => Array(
										'js' => 1,
										'link' => $_SERVER["PHP_SELF"]."",
										'name' => ___("Startseite"),
										'description' => ___("Aktuelle Meldungen ein-/ausblenden"),
										'text' => ___("Zur Startseite"),
										'icon' => 'house.png',
										'target' => '_self',
										'indent' => '0',
										'admin' => '0',
										'manager' => '0',
										),
									1 => Array(
										'js' => 1,
										'link' => "javascript:switchSection('main_info')",
										'name' => date("Y-m-d H:i:s"),
										'description' => ___("Aktuelle Meldungen ein-/ausblenden"),
										'text' => date("Y-m-d H:i:s"),
										'icon' => 'information.png',
										'target' => '_self',
										'indent' => '0',
										'admin' => '0',
										'manager' => '0',
										),
									),
						),
					1 => Array(
						'id'=>'menu_nl',
						'name'=>___("Newsletter"),
						'links' => Array(
									0 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=nl_grp_list",
										'name' => ___("Gruppen"),
										'description' => ___("Newsletter-Gruppen anzeigen"),
										'text' => ___("Hier verwalten Sie Ihre Newslettergruppen"),
										'icon' => 'book.png',
										'target' => '_self',
										'indent' => '0',
										'admin' => '0',
										'manager' => '0',
										),
									1 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=nl_grp_new",
										'name' => ___("Neue Gruppe"),
										'description' => ___("Neue Newsletter-Gruppe anlegen"),
										'text' => ___("Hier erstellen Sie eine neue Newslettergruppe"),
										'icon' => 'book_add.png',
										'target' => '_self',
										'indent' => '16',
										'admin' => '0',
										'manager' => '0',
										),
									2 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=nl_list",
										'name' => ___("Newsletter"),
										'description' => ___("Newsletter anzeigen"),
										'text' => ___("Hier verwalten Sie Ihre Newsletter"),
										'icon' => 'newspaper.png',
										'target' => '_self',
										'indent' => '0',
										'admin' => '0',
										'manager' => '0',
										),
									3 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=nl_new",
										'name' => ___("Neuer Newsletter"),
										'description' => ___("Neuen Newsletter anlegen"),
										'text' => ___("Hier erstellen Sie einen neuen Newsletter"),
										'icon' => 'newspaper_add.png',
										'target' => '_self',
										'indent' => '16',
										'admin' => '0',
										'manager' => '0',
										),
									4 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=queue_list",
										'name' => ___("Queue"),
										'description' => ___("Queue / Warteschlange anzeigen"),
										'text' => ___("Hier sehen Sie den Versandstatus Ihrer Newsletter"),
										'icon' => 'hourglass.png',
										'target' => '_self',
										'indent' => '0',
										'admin' => '1',
										'manager' => '1',
										),
									5 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=queue_new",
										'name' => ___("Neue Queue"),
										'description' => ___("neuen Newsletter in die Queue / Warteschlange eintragen"),
										'text' => ___("Hier bereiten Sie den Versand Ihres Newsletter vor"),
										'icon' => 'hourglass_add.png',
										'target' => '_self',
										'indent' => '16',
										'admin' => '0',
										'manager' => '0',
										),

									),
						),

					2 => Array(
						'id'=>'menu_adr',
						'name'=>___("Adressen"),
						'links' => Array(
									0 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=adr_grp_list",
										'name' => ___("Gruppen"),
										'description' => ___("Adress-Gruppen anzeigen"),
										'text' => ___("Hier verwalten Sie Ihre Adress-Gruppen"),
										'icon' => 'group.png',
										'target' => '_self',
										'indent' => '0',
										'admin' => '0',
										'manager' => '0',
										),
									1 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=adr_grp_new",
										'name' => ___("Neue Gruppe"),
										'description' => ___("Neue Adress-Gruppe anlegen"),
										'text' => ___("Hier erstellen Sie eine neue Adress-Gruppe"),
										'icon' => 'group_add.png',
										'target' => '_self',
										'indent' => '16',
										'admin' => '0',
										'manager' => '0',
										),
									2 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=adr_list",
										'name' => ___("Adressen"),
										'description' => ___("Adressen anzeigen"),
										'text' => ___("Hier können Sie Ihre Adressen suchen, anzeigen und bearbeiten"),
										'icon' => 'vcard.png',
										'target' => '_self',
										'indent' => '0',
										'admin' => '0',
										'manager' => '0',
										),
									3 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=adr_new",
										'name' => ___("Neue Adresse"),
										'description' => ___("Neue Adresse anlegen"),
										'text' => ___("Hier erfassen Sie Adressen manuell"),
										'icon' => 'vcard_add.png',
										'target' => '_self',
										'indent' => '16',
										'admin' => '0',
										'manager' => '0',
										),
									4 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=adr_import",
										'name' => ___("CSV-Import"),
										'description' => ___("Adressen aus einer CSV-Datei importieren"),
										'text' => ___("Importieren Sie Ihre Adressbestände aus einer CSV-Datei"),
										'icon' => 'vcard_add.png',
										'target' => '_self',
										'indent' => '0',
										'admin' => '0',
										'manager' => '1',
										),
									5 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=adr_export",
										'name' => ___("CSV-Export"),
										'description' => ___("Adressen in eine CSV-Datei exportieren"),
										'text' => ___("Exportieren Sie Ihre Adressbestünde in eine CSV-Datei"),
										'icon' => 'cake.png',
										'target' => '_self',
										'indent' => '0',
										'admin' => '0',
										'manager' => '1',
										),
									),
							),
					3 => Array(
						'id'=>'menu_frm',
						'name'=>___("Formulare"),
						'links' => Array(
									0 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=form_list",
										'name' => ___("Formulare"),
										'description' => ___("Formulare anzeigen"),
										'text' => ___("Hier verwalten Sie Ihre Anmeldeformulare"),
										'icon' => 'application_form.png',
										'target' => '_self',
										'indent' => '0',
										'admin' => '0',
										'manager' => '0',
										),
									1 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=form_new",
										'name' => ___("Neues Formular"),
										'description' => ___("Neues Formular erstellen"),
										'text' => ___("Hier verwalten Sie Ihre Anmeldeformulare"),
										'icon' => 'application_form_add.png',
										'target' => '_self',
										'indent' => '16',
										'admin' => '0',
										'manager' => '0',
										),
								),
						),
					4 => Array(
						'id'=>'menu_tools',
						'name'=>___("Tools"),
						'links' => Array(
									0 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=filemanager",
										'name' => ___("Filemanager"),
										'description' => ___("Filemanager"),
										'text' => ___("Filemanager from myftphp.sf.net - thx to Knittl"),
										'icon' => 'folder_wrench.png',
										'target' => '_self',
										'indent' => '0',
										'admin' => '0',
										'manager' => '0',
										),
								),
						),
					5 => Array(
						'id'=>'menu_st',
						'name'=>___("Status"),
						'links' => Array(
									0 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=status_top_x",
										'name' => ___("Top X"),
										'description' => ___("Top X"),
										'text' => ___("Top X Liste"),
										'icon' => 'report.png',
										'target' => '_self',
										'indent' => '0',
										'admin' => '0',
										'manager' => '0',
										),
									1 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=status",
										'name' => ___("Status"),
										'description' => ___("Aktueller Status"),
										'text' => ___("Hier sehen Sie den aktuellen Status"),
										'icon' => 'report.png',
										'target' => '_self',
										'indent' => '0',
										'admin' => '0',
										'manager' => '0',
										),
									2 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=status_map",
										'name' => ___("Karte"),
										'description' => ___("Benutzer-Karte, zeige die Standorte der Leser"),
										'text' => ___("Hier sehen Sie die geographische Verteilung der Leser"),
										'icon' => 'map.png',
										'target' => '_self',
										'indent' => '0',
										'admin' => '0',
										'manager' => '0',
										),
								),
						),
					6 => Array(
						'id'=>'menu_vw',
						'name'=>___("Verwaltung"),
						'links' => Array(
									0 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=bounce",
										'name' => ___("Bounce-Management"),
										'description' => ___("Bounce-Management"),
										'text' => ___("Verwalten Sie fehlgeschlagene E-Mails und Rückläufer"),
										'icon' => 'sport_soccer.png',
										'target' => '_self',
										'indent' => '0',
										'admin' => '0',
										'manager' => '1',
										),
									1 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=adr_clean",
										'name' => ___("Datenbank bereinigen"),
										'description' => ___("Datenbank bereinigen"),
										'text' => ___("Datenbank aufräumen und Adressbestände säubern"),
										'icon' => 'database_refresh.png',
										'target' => '_self',
										'indent' => '0',
										'admin' => '0',
										'manager' => '1',
										),
									2 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=bl_list",
										'name' => ___("Blacklist"),
										'description' => ___("Blackliste/Robinsonliste"),
										'text' => ___("Blacklist/Robinsonliste verwalten"),
										'icon' => 'ruby.png',
										'target' => '_self',
										'indent' => '0',
										'admin' => '0',
										'manager' => '1',
										),
									3 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=bl_new",
										'name' => ___("Neuer Blacklisteintrag"),
										'description' => ___("Neueintrag in Blackliste/Robinsonliste"),
										'text' => ___("Neuen Eintrag (E-Mail, Domain, ...) der Blacklist/Robinsonliste  hinzufügen"),
										'icon' => 'ruby_add.png',
										'target' => '_self',
										'indent' => '16',
										'admin' => '0',
										'manager' => '1',
										),
									4 => Array(
										'js' => 1,
										'link' => $tm_URL_FE."/include/send_it.php",
										'name' => ___("manueller Versand"),
										'description' => ___("manueller Versand"),
										'text' => ___("Hier versenden Sie Ihre Newsletter manuell"),
										'icon' => 'email_go.png',
										'target' => '_blank',
										'indent' => '0',
										'admin' => '0',
										'manager' => '1',
										),
									5 => Array(
										'js' => 1,
										'link' => $tm_URL_FE."/unsubscribe.php",
										'name' => ___("Abmeldeformular"),
										'description' => ___("Abmeldeformular"),
										'text' => ___("Hier gelangen Sie zum Abmeldeformular"),
										'icon' => 'door_out.png',
										'target' => '_blank',
										'indent' => '0',
										'admin' => '0',
										'manager' => '0',
										),
								),
						),
					7 => Array(
						'id'=>'menu_user',
						'name'=>___("Benutzer"),
						'links' => Array(
									0 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=user",
										'name' => ___("Benutzereinstellungen"),
										'description' => ___("Benutzereinstellungen"),
										'text' => ___("Hier ändern Sie Ihre persönlichen Einstellungen"),
										'icon' => 'user_edit.png',
										'target' => '_self',
										'indent' => '0',
										'admin' => '0',
										'manager' => '0',
										),
									1 => Array(
										'js' => 1,
										'link' => "http://www.tellmatic.org/doc",
										'name' => ___("Dokumentation"),
										'description' => ___("Hilfe / Dokumentation"),
										'text' => ___("Hier wird Ihnen geholfen"),
										'icon' => 'help.png',
										'target' => '_blank',
										'indent' => '0',
										'admin' => '0',
										'manager' => '0',
										),
									2 => Array(
										'js' => 1,
										'link' => "http://www.tellmatic.org/credits",
										'name' => ___("Credits"),
										'description' => ___("Credits"),
										'text' => ___("Credits"),
										'icon' => 'award_star_gold_3.png',
										'target' => '_blank',
										'indent' => '0',
										'admin' => '0',
										'manager' => '0',
										),
									3 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=logout",
										'name' => ___("Logout"),
										'description' => ___("Logout"),
										'text' => ___("Logout"),
										'icon' => 'door_out.png',
										'target' => '_self',
										'indent' => '0',
										'admin' => '0',
										'manager' => '0',
										),
								),
						),
					8 => Array(
						'id'=>'menu_admin',
						'name'=>___("Admin"),
						'links' => Array(
									0 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=host_list",
										'name' => ___("Mail-Server"),
										'description' => ___("Mail-Server verwalten"),
										'text' => ___("Mail-Server verwalten"),
										'icon' => 'server.png',
										'target' => '_self',
										'indent' => '0',
										'admin' => '1',
										'manager' => '0',
										),
									1 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=host_new",
										'name' => ___("Neuer Mail-Server"),
										'description' => ___("Neuen Mail-Server anlegen"),
										'text' => ___("Neuen Mail-Server anlegen"),
										'icon' => 'server_add.png',
										'target' => '_self',
										'indent' => '16',
										'admin' => '1',
										'manager' => '0',
										),
									2 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=adm_user_list",
										'name' => ___("Benutzer"),
										'description' => ___("Benutzer verwalten"),
										'text' => ___("Tellmatic Benutzer/Authoren verwalten"),
										'icon' => 'user.png',
										'target' => '_self',
										'indent' => '0',
										'admin' => '1',
										'manager' => '0',
										),
									3 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=adm_user_new",
										'name' => ___("Neuer Benutzer"),
										'description' => ___("Neuer Benutzer/Author"),
										'text' => ___("Neuen Tellmatic Benutzer/Authoren anlegen"),
										'icon' => 'user_add.png',
										'target' => '_self',
										'indent' => '16',
										'admin' => '1',
										'manager' => '0',
										),
									4 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=adm_set",
										'name' => ___("Einstellungen"),
										'description' => ___("Grundeinstellungen"),
										'text' => ___("Globale Einstellungen für Tellmatic"),
										'icon' => 'computer.png',
										'target' => '_self',
										'indent' => '0',
										'admin' => '1',
										'manager' => '0',
										),
									5 => Array(
										'js' => 1,
										'link' => "javascript:switchSection('div_debug');",
										'name' => ___("Serverinfo"),
										'description' => ___("Serverinfo"),
										'text' => ___("Hier sehen Sie einige zusätzliche Informationen"),
										'icon' => 'information.png',
										'target' => '_self',
										'indent' => '0',
										'admin' => '0',
										'manager' => '0',
										),
									6 => Array(
										'js' => 1,
										'link' => $tm_URL_FE."/".TM_INCLUDEDIR."/phpinfo.php",
										'name' => ___("PHP Info"),
										'description' => ___("PHP Info"),
										'text' => ___("PHP Info"),
										'icon' => 'information.png',
										'target' => '_blank',
										'indent' => '0',
										'admin' => '0',
										'manager' => '0',
										),
									7 => Array(
										'js' => 1,
										'link' => "http://www.tellmatic.org/donate",
										'name' => ___("Spende"),
										'description' => ___("Tellmatic unterstützen"),
										'text' => ___("Bitte unterstützen Sie Tellmatic mit einer Spende"),
										'icon' => 'money_euro.png',
										'target' => '_blank',
										'indent' => '0',
										'admin' => '0',
										'manager' => '0',
										),
								),
						),
				);

//MENU SECTIONS
$sections=getVar('s');
$menu_sections=split(",",$sections);
$menu_sections_c=count($menu_sections);
$_SESSION["s"]=$sections;

//new Template
$_Tpl_Menu_Head=new tm_Template();
$_Tpl_Menu_Head->setTemplatePath(TM_TPLPATH."/".$LOGIN->USER['style']);
$_Tpl_Menu_Entry=new tm_Template();
$_Tpl_Menu_Entry->setTemplatePath(TM_TPLPATH."/".$LOGIN->USER['style']);
$_Tpl_Menu_Foot=new tm_Template();
$_Tpl_Menu_Foot->setTemplatePath(TM_TPLPATH."/".$LOGIN->USER['style']);

//for topics
$_MENU="";
$mtc=count($MENU);
for ($mtcc=0;$mtcc<$mtc;$mtcc++) {
	//add head
	$_NAME=$MENU[$mtcc]['name'];
	$_ID=$MENU[$mtcc]['id'];
	$_Tpl_Menu_Head->setParseValue("_NAME", $_NAME);
	$_Tpl_Menu_Head->setParseValue("_ID", $_ID);
	$_MENU_HEAD=$_Tpl_Menu_Head->renderTemplate("Menu_head.html");
	//add entries
	$_MENU_ENTRY="";
	$mlc=count($MENU[$mtcc]['links']);
	for ($mlcc=0;$mlcc<$mlc;$mlcc++) {

		if (	($MENU[$mtcc]['links'][$mlcc]['admin']!=1 && $MENU[$mtcc]['links'][$mlcc]['manager']!=1) ||
				($user_is_admin && $MENU[$mtcc]['links'][$mlcc]['admin']==1) ||
				($user_is_manager && $MENU[$mtcc]['links'][$mlcc]['manager']==1)
			)	{
			$_Tpl_Menu_Entry->setParseValue("_NAME", $MENU[$mtcc]['links'][$mlcc]['name']);
			$_Tpl_Menu_Entry->setParseValue("_DESCRIPTION", $MENU[$mtcc]['links'][$mlcc]['description']);
			$_Tpl_Menu_Entry->setParseValue("_TEXT", $MENU[$mtcc]['links'][$mlcc]['text']);
			if ($MENU[$mtcc]['links'][$mlcc]['js'] != 1) {
				$_Tpl_Menu_Entry->setParseValue("_LINK", $MENU[$mtcc]['links'][$mlcc]['link']."&amp;s=s_".$MENU[$mtcc]['id']);
				$_Tpl_Menu_Entry->setParseValue("_LOADER", "onMousedown=\"load();switchSection('div_loader');\"" );
			} else {
				$_Tpl_Menu_Entry->setParseValue("_LINK", $MENU[$mtcc]['links'][$mlcc]['link']);
				$_Tpl_Menu_Entry->setParseValue("_LOADER", "");
			}
			$_Tpl_Menu_Entry->setParseValue("_ICON", $tm_iconURL."/".$MENU[$mtcc]['links'][$mlcc]['icon']);
			$_Tpl_Menu_Entry->setParseValue("_TARGET", $MENU[$mtcc]['links'][$mlcc]['target']);
			$_Tpl_Menu_Entry->setParseValue("_INDENT", $MENU[$mtcc]['links'][$mlcc]['indent']);
			$_Tpl_Menu_Entry->setParseValue("_ID", "me_".$mtcc."_".$mlcc);
			$_MENU_ENTRY.="\n".$_Tpl_Menu_Entry->renderTemplate("Menu_entry.html");
		}//if admin
	}
	//add foot
	$_Tpl_Menu_Foot->setParseValue("_ID", $_ID);
	$_MENU_FOOT=$_Tpl_Menu_Foot->renderTemplate("Menu_foot.html");
	if ($user_is_expert && $mtcc>0)
	$_MENU_FOOT.= "
		<script type=\"text/javascript\">
		switchSection('s_".$MENU[$mtcc]['id']."');
		</script>\n";
	//create menu
	$_MENU.=$_MENU_HEAD."\n".$_MENU_ENTRY."\n".$_MENU_FOOT."\n\n";
}


$_MENU.= "<div class=\"userinfo\"><!--a href=\"http://www.tellmatic.org\" target=\"blank\">".$ApplicationText."</a><br-->".
									sprintf(___("Benutzer: %s"),$LOGIN->USER['name']).
									" (".$LOGIN->USER['style']." / ".$LOGIN->USER['lang'].")".
									" ".___("Zuletzt angemeldet:")." ".date("F, D d-m-Y H:i:s",$LOGIN->USER['last_login']).
									"<br>".
									$_TIMEOUT.
									"</div>\n";

	//re-open selected menu sections
	for ($mscc=0;$mscc<$menu_sections_c;$mscc++) {
		if ($user_is_expert && $menu_sections[0]!="s_menu_tm") $_MENU.= "
			<script type=\"text/javascript\">
			switchSection('".$menu_sections[$mscc]."');
			</script>\n";
	}



//some Cookie Testcode
if (DEBUG) {
	$_MENU .='
	<div  class="userinfo">
	<form name="cookieform" action="#">
	<!--CookieName-->
	<input name="cookie_name" value="TellMatic"><br>
	CookieValue <input name="cookie_value"><br>
	<!--
	update:<br>
	CookieValueParamName <input name="cookie_p_name"><br>
	CookieValueParamValue <input name="cookie_p_value"><br>
	-->
	</form>
	<a href="javascript:cookie_check(document.forms[\'cookieform\'].cookie_name.value);">Check cookie</a><br>
	<a href="javascript:cookie_eraseIt(document.forms[\'cookieform\'].cookie_name.value);">Erase cookie</a><br>
	<a href="javascript:cookie_saveIt(document.forms[\'cookieform\'].cookie_name.value,document.forms[\'cookieform\'].cookie_value.value);">Create cookie</a><br>
	<!--
	<a href="javascript:cookie_readIt(document.forms[\'cookieform\'].cookie_name.value);">Read cookie</a><br>
	<a href="javascript:cookie_updateIt(document.forms[\'cookieform\'].cookie_name.value , document.forms[\'cookieform\'].cookie_p_name.value , document.forms[\'cookieform\'].cookie_p_value.value);" class="page">Add Param to To cookie</a><br>
	-->
	';
	$_MENU .=$LOGIN->USER['name']."<br>sessid: ".session_id();
	$_MENU .="<br>ip: ".$_SESSION['ip'];
	$_MENU .='</div>';
}

$_MENU.='
<p align="center">
<a href="http://validator.w3.org/check?uri=referer&amp;ss=1"><img
        src="http://www.w3.org/Icons/valid-html401-blue"
        alt="Valid HTML 4.01 Transitional" height="31" width="88" border="0"></a>
</p>

';

?>