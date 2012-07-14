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
										),
									),
						),
					1 => Array(
						'id'=>'menu_nl',
						'name'=>'Newsletter',
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
										),
									4 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=queue_new",
										'name' => ___("Neue Queue"),
										'description' => ___("neuen Newsletter in die Queue / Warteschlange eintragen"),
										'text' => ___("Hier bereiten Sie den Versand Ihres Newsletter vor"),
										'icon' => 'hourglass_add.png',
										'target' => '_self',
										'indent' => '0',
										),

									),
						),
						
					2 => Array(
						'id'=>'menu_adr',
						'name'=>'Adressen',
						'links' => Array( 
									0 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=adr_grp_list",
										'name' => ___("Gruppen"),
										'description' => ___("Adress-Gruppen anzeigen"),
										'text' => ___("Hier verwalten Sie Ihre AdressGruppen"),
										'icon' => 'group.png',
										'target' => '_self',
										'indent' => '0',
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
										),
									2 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=adr_list",
										'name' => ___("Adressen"),
										'description' => ___("Adressen anzeigen"),
										'text' => ___("Hier kÖnnen Sie Ihre Adressen suchen, anzeigen und bearbeiten"),
										'icon' => 'vcard.png',
										'target' => '_self',
										'indent' => '0',
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
										),
									),
							),
					3 => Array(
						'id'=>'menu_frm',
						'name'=>'Formulare',
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
										),
								),
						),
					4 => Array(
						'id'=>'menu_tools',
						'name'=>'Tools',
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
										),
								),
						),
					5 => Array(
						'id'=>'menu_vw',
						'name'=>'Verwaltung',
						'links' => Array( 
									0 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=status",
										'name' => ___("Status"),
										'description' => ___("Aktueller Status"),
										'text' => ___("Hier sehen Sie den aktuellen Status"),
										'icon' => 'report.png',
										'target' => '_self',
										'indent' => '0',
										),
									1 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=bounce",
										'name' => ___("Bounce-Management"),
										'description' => ___("Bounce-Management"),
										'text' => ___("Verwalten Sie fehlgeschlagene E-Mails und Rückläufer"),
										'icon' => 'sport_soccer.png',
										'target' => '_self',
										'indent' => '0',
										),
									2 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=adr_clean",
										'name' => ___("Datenbank bereinigen"),
										'description' => ___("Datenbank bereinigen"),
										'text' => ___("Datenbank aufräumen und Adressbestände säubern"),
										'icon' => 'database_refresh.png',
										'target' => '_self',
										'indent' => '0',
										),
									3 => Array(
										'js' => 1,
										'link' => $mnl_URL_FE."/include/send_it.php",
										'name' => ___("manueller Versand"),
										'description' => ___("manueller Versand"),
										'text' => ___("Hier versenden Sie Ihre Newsletter manuell"),
										'icon' => 'email_go.png',
										'target' => '_blank',
										'indent' => '0',
										),
									4 => Array(
										'js' => 1,
										'link' => $mnl_URL_FE."/unsubscribe.php",
										'name' => ___("Abmeldeformular"),
										'description' => ___("Abmeldeformular"),
										'text' => ___("Hier gelangen Sie zum Abmeldeformular"),
										'icon' => 'door_out.png',
										'target' => '_blank',
										'indent' => '0',
										),
								),
						),
					6 => Array(
						'id'=>'menu_user',
						'name'=>'Benutzer',
						'links' => Array( 
									0 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=user",
										'name' => ___("Benutzereinstellungen"),
										'description' => ___("Benutzereinstellungen"),
										'text' => ___("Hier ändern Sie Ihre persÖnlichen Einstellungen"),
										'icon' => 'user_edit.png',
										'target' => '_self',
										'indent' => '0',
										),
									1 => Array(
										'js' => 1,
										'link' => "http://www.tellmatic.org",
										'name' => ___("Dokumentation"),
										'description' => ___("Hilfe / Dokumentation"),
										'text' => ___("Hier wird Ihnen geholfen"),
										'icon' => 'help.png',
										'target' => '_blank',
										'indent' => '0',
										),
								),
						),
					7 => Array(
						'id'=>'menu_admin',
						'name'=>'Admin',
						'links' => Array( 
									0 => Array(
										'js' => 0,
										'link' => $_SERVER["PHP_SELF"]."?act=adm_set",
										'name' => ___("Einstellungen"),
										'description' => ___("Grundeinstellungen"),
										'text' => ___("Globale Einstellungen für Tellmatic"),
										'icon' => 'computer.png',
										'target' => '_self',
										'indent' => '0',
										),
									1 => Array(
										'js' => 1,
										'link' => "javascript:switchSection('div_debug');",
										'name' => ___("Serverinfo"),
										'description' => ___("Serverinfo"),
										'text' => ___("Hier sehen Sie einige zusätzliche Informationen"),
										'icon' => 'information.png',
										'target' => '_self',
										'indent' => '0',
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
	$_ID=$MENU[$mtcc]['id'];
	$_Tpl_Menu_Head->setParseValue("_NAME", $_NAME);
	$_Tpl_Menu_Head->setParseValue("_ID", $_ID);
	$_MENU_HEAD=$_Tpl_Menu_Head->renderTemplate("Menu_head.html");

	//add entries
	$_MENU_ENTRY="";
	$mlc=count($MENU[$mtcc]['links']);
	for ($mlcc=0;$mlcc<$mlc;$mlcc++) {
		$_Tpl_Menu_Entry->setParseValue("_NAME", $MENU[$mtcc]['links'][$mlcc]['name']);
		$_Tpl_Menu_Entry->setParseValue("_DESCRIPTION", $MENU[$mtcc]['links'][$mlcc]['description']);
		$_Tpl_Menu_Entry->setParseValue("_TEXT", $MENU[$mtcc]['links'][$mlcc]['text']);
		if ($MENU[$mtcc]['links'][$mlcc]['js'] != 1) {
			$_Tpl_Menu_Entry->setParseValue("_LINK", $MENU[$mtcc]['links'][$mlcc]['link']."&s=s_".$MENU[$mtcc]['id']);
		} else {
		$_Tpl_Menu_Entry->setParseValue("_LINK", $MENU[$mtcc]['links'][$mlcc]['link']);
		}
		$_Tpl_Menu_Entry->setParseValue("_ICON", $mnl_iconURL."/".$MENU[$mtcc]['links'][$mlcc]['icon']);
		$_Tpl_Menu_Entry->setParseValue("_TARGET", $MENU[$mtcc]['links'][$mlcc]['target']);
		$_Tpl_Menu_Entry->setParseValue("_INDENT", $MENU[$mtcc]['links'][$mlcc]['indent']);

		$_MENU_ENTRY.=$_Tpl_Menu_Entry->renderTemplate("Menu_entry.html");
	}
	
	//add foot
	$_Tpl_Menu_Foot->setParseValue("_ID", $_ID);
	$_MENU_FOOT=$_Tpl_Menu_Foot->renderTemplate("Menu_foot.html");
	if ($user_is_expert && $mtcc>0) 
	$_MENU_FOOT.= "
		<script type=\"text/javascript\">
		switchSection('s_".$MENU[$mtcc]['id']."');
		</script>";

	//create menu
	$_MENU.=$_MENU_HEAD.$_MENU_ENTRY.$_MENU_FOOT;
}
	//re-open selected menu sections
	for ($mscc=0;$mscc<$menu_sections_c;$mscc++) {
		if ($user_is_expert && $menu_sections[0]!="s_menu_tm") $_MENU.= "
			<script type=\"text/javascript\">
			switchSection('".$menu_sections[$mscc]."');
			</script>";
	}
?>