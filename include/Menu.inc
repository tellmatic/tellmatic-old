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

$MENU=Array(
					0 => Array(
						'name'=>'Tellmatic',
						'links' => Array( 
									0 => Array(
										'link' => "javascript:switchSection('main_info')",
										'name' => date("Y-m-d H:i:s"),
										'description' => ___("Aktuelle Meldungen ein-/ausblenden"),
										'text' => date("Y-m-d H:i:s"),
										'icon' => 'information.png',
										),
									),
						),
					1 => Array(
						'name'=>'Newsletter',
						'links' => Array( 
									0 => Array(
										'link' => $_SERVER["PHP_SELF"]."?act=nl_grp_list",
										'name' => ___("Gruppen"),
										'description' => ___("Newsletter-Gruppen anzeigen"),
										'text' => ___("Hier verwalten Sie Ihre Newslettergruppen"),
										'icon' => 'book.png',
										),
									1 => Array(
										'link' => $_SERVER["PHP_SELF"]."?act=nl_grp_new",
										'name' => ___("Neue Gruppe"),
										'description' => ___("Neue Newsletter-Gruppe anlegen"),
										'text' => ___("Hier erstellen Sie eine neue Newslettergruppe"),
										'icon' => 'book_add.png',
										),
									2 => Array(
										'link' => $_SERVER["PHP_SELF"]."?act=nl_list",
										'name' => ___("Newsletter"),
										'description' => ___("Newsletter anzeigen"),
										'text' => ___("Hier verwalten Sie Ihre Newsletter"),
										'icon' => 'newspaper.png',
										),
									3 => Array(
										'link' => $_SERVER["PHP_SELF"]."?act=nl_new",
										'name' => ___("Neuer Newsletter"),
										'description' => ___("Neuen Newsletter anlegen"),
										'text' => ___("Hier erstellen Sie einen neuen Newsletter"),
										'icon' => 'newspaper_add.png',
										),
									4 => Array(
										'link' => $_SERVER["PHP_SELF"]."?act=nl_grp_list",
										'name' => ___("Neue Queue"),
										'description' => ___("neuen Newsletter in die Queue / Warteschlange eintragen"),
										'text' => ___("Hier bereiten Sie den Versand Ihres Newsletter vor"),
										'icon' => 'hourglass_add.png',
										),

									),
						),
						
					2 => Array(
						'name'=>'Adressen',
						'links' => Array( 
									0 => Array(
										'link' => $_SERVER["PHP_SELF"]."?act=adr_grp_list",
										'name' => ___("Gruppen"),
										'description' => ___("Adress-Gruppen anzeigen"),
										'text' => ___("Hier verwalten Sie Ihre AdressGruppen"),
										'icon' => 'group.png',
										),
									1 => Array(
										'link' => $_SERVER["PHP_SELF"]."?act=adr_grp_new",
										'name' => ___("Neue Gruppe"),
										'description' => ___("Neue Adress-Gruppe anlegen"),
										'text' => ___("Hier erstellen Sie eine neue Adress-Gruppe"),
										'icon' => 'group_add.png',
										),
									2 => Array(
										'link' => $_SERVER["PHP_SELF"]."?act=adr_list",
										'name' => ___("Adressen"),
										'description' => ___("Adressen anzeigen"),
										'text' => ___("Hier k&ouml;nnen Sie Ihre Adressen suchen, anzeigen und bearbeiten"),
										'icon' => 'vcard.png',
										),
									3 => Array(
										'link' => $_SERVER["PHP_SELF"]."?act=adr_new",
										'name' => ___("Neue Adresse"),
										'description' => ___("Neue Adresse anlegen"),
										'text' => ___("Hier erfassen Sie Adressen manuell"),
										'icon' => 'vcard_add.png',
										),
									4 => Array(
										'link' => $_SERVER["PHP_SELF"]."?act=adr_import",
										'name' => ___("CSV-Import"),
										'description' => ___("Adressen aus einer CSV-Datei importieren"),
										'text' => ___("Importieren Sie Ihre Adressbest&auml;nde aus einer CSV-Datei"),
										'icon' => 'vcard_add.png',
										),
									5 => Array(
										'link' => $_SERVER["PHP_SELF"]."?act=adr_export",
										'name' => ___("CSV-Export"),
										'description' => ___("Adressen in eine CSV-Datei exportieren"),
										'text' => ___("Exportieren Sie Ihre Adressbest&uuml;nde in eine CSV-Datei"),
										'icon' => 'cake.png',
										),
									6 => Array(
										'link' => $_SERVER["PHP_SELF"]."?act=bounce",
										'name' => ___("Bounce-Management"),
										'description' => ___("Bounce-Management"),
										'text' => ___("Verwalten Sie fehlgeschlagene E-Mails und R&uuml;ckl&auml;ufer"),
										'icon' => 'sport_soccer.png',
										),
									7 => Array(
										'link' => $_SERVER["PHP_SELF"]."?act=adr_clean",
										'name' => ___("Datenbank bereinigen"),
										'description' => ___("Datenbank bereinigen"),
										'text' => ___("Datenbank aufr&auml;umen und Adressbest&auml;nde s&auml;ubern"),
										'icon' => 'database_refresh.png',
										),
									),
							),
					3 => Array(
						'name'=>'Formulare',
						'links' => Array( 
									0 => Array(
										'link' => $_SERVER["PHP_SELF"]."?act=form_list",
										'name' => ___("Formulare"),
										'description' => ___("Formulare anzeigen"),
										'text' => ___("Hier verwalten Sie Ihre Anmeldeformulare"),
										'icon' => 'application_form.png',
										),
									1 => Array(
										'link' => $_SERVER["PHP_SELF"]."?act=form_new",
										'name' => ___("Neues Formular"),
										'description' => ___("Neues Formular erstellen"),
										'text' => ___("Hier verwalten Sie Ihre Anmeldeformulare"),
										'icon' => 'application_form_add.png',
										),
								),
						),
					4 => Array(
						'name'=>'Verwaltung',
						'links' => Array( 
									0 => Array(
										'link' => $_SERVER["PHP_SELF"]."?act=status",
										'name' => ___("Status"),
										'description' => ___("Aktueller Status"),
										'text' => ___("Hier sehen Sie den aktuellen Status"),
										'icon' => 'report.png',
										),
									1 => Array(
										'link' => $_SERVER["PHP_SELF"]."?act=adm_set",
										'name' => ___("Einstellungen"),
										'description' => ___("Grundeinstellungen"),
										'text' => ___("Globale Einstellungen f&uuml;r Tellmatic"),
										'icon' => 'computer.png',
										),
									2 => Array(
										'link' => "javascript:switchSection('div_debug');",
										'name' => ___("Serverinfo"),
										'description' => ___("Serverinfo"),
										'text' => ___("Hier sehen Sie einige zus&auml;tzliche Informationen"),
										'icon' => 'information.png',
										),
									3 => Array(
										'link' => "include/send_it.php",
										'name' => ___("manueller Versand"),
										'description' => ___("manueller Versand"),
										'text' => ___("Hier versenden Sie Ihre Newsletter manuell"),
										'icon' => 'email_go.png',
										),
									4 => Array(
										'link' => "unsubscribe.php",
										'name' => ___("Abmelden"),
										'description' => ___("Abmeldeformular"),
										'text' => ___("Hier gelangen Sie zum Abmeldeformular"),
										'icon' => 'door_out.png',
										),
									5 => Array(
										'link' => "http://www.tellmatic.org",
										'name' => ___("Dokumentation"),
										'description' => ___("Hilfe / Dokumentation"),
										'text' => ___("Hier wird Ihnen geholfen"),
										'icon' => 'help.png',
										),
								),
						),
					5 => Array(
						'name'=>'Benutzer',
						'links' => Array( 
									0 => Array(
										'link' => $_SERVER["PHP_SELF"]."?act=user",
										'name' => ___("Benutzereinstellungen"),
										'description' => ___("Benutzereinstellungen"),
										'text' => ___("Hier &auml;ndern Sie Ihre pers&ouml;nlichen Einstellungen"),
										'icon' => 'user_edit.png',
										),
								),
						),

				);
				//


//new Template
$_Tpl_Menu_Head=new mTemplate();
$_Tpl_Menu_Head->setTemplatePath($mnl_tplpath);
$_Tpl_Menu_Entry=new mTemplate();
$_Tpl_Menu_Entry->setTemplatePath($mnl_tplpath);
$_Tpl_Menu_Foot=new mTemplate();
$_Tpl_Menu_Foot->setTemplatePath($mnl_tplpath);

//for topics
$_MENU="";
$mtc=count($MENU);
for ($mtcc=0;$mtcc<$mtc;$mtcc++) {

	//add head
	$_NAME=$MENU[$mtcc]['name'];
	$_Tpl_Menu_Head->setParseValue("_NAME", $_NAME);
	$_Tpl_Menu_Head->setParseValue("_ID", $mtcc);
	$_MENU_HEAD=$_Tpl_Menu_Head->renderTemplate("Menu_head.html");

	//add entries
	$_MENU_ENTRY="";
	$mlc=count($MENU[$mtcc]['links']);
	for ($mlcc=0;$mlcc<$mlc;$mlcc++) {
		$_NAME=$MENU[$mtcc]['links'][$mlcc]['name'];
		$_LINK=$MENU[$mtcc]['links'][$mlcc]['link'];
		$_DESCRIPTION=$MENU[$mtcc]['links'][$mlcc]['description'];
		$_TEXT=$MENU[$mtcc]['links'][$mlcc]['text'];
		$_ICON=$MENU[$mtcc]['links'][$mlcc]['icon'];

		$_Tpl_Menu_Entry->setParseValue("_NAME", $_NAME);
		$_Tpl_Menu_Entry->setParseValue("_DESCRIPTION", $_DESCRIPTION);
		$_Tpl_Menu_Entry->setParseValue("_TEXT", $_TEXT);
		$_Tpl_Menu_Entry->setParseValue("_LINK", $_LINK);
		$_Tpl_Menu_Entry->setParseValue("_ICON", $_ICON);

		$_MENU_ENTRY.=$_Tpl_Menu_Entry->renderTemplate("Menu_entry.html");
	}
	
	//add foot
	$_MENU_FOOT=$_Tpl_Menu_Foot->renderTemplate("Menu_foot.html");

	//create menu
	$_MENU.=$_MENU_HEAD.$_MENU_ENTRY.$_MENU_FOOT;
}
?>