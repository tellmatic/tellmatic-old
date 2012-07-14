<?php
/********************************************************************************/
/* this file is part of: / diese Datei ist ein Teil von:                        	*/
/* tellmatic, the newslettermachine                                             	*/
/* tellmatic, die Newslettermaschine                                            */
/* 2006/7 by Volker Augustin, multi.art.studio Hanau                            */
/* Contact/Kontakt: info@tellmatic.org                                      */
/* Homepage: www.tellmatic.org                                                   */
/* leave this header in file!                                                   */
/* diesen Header nicht loeschen!                                                */
/* check Homepage for Updates and more Infos                                    */
/* Besuchen Sie die Homepage fuer Updates und weitere Infos                     */
/********************************************************************************/

if ($check) {

	$MESSAGE.="<br><br>Beispieldaten werden hinzugefügt / Inserting some example Data.";

	if (!DEMO) {
/***********************************************************/
//create example data
/***********************************************************/
//nl gruppe
		$NEWSLETTER=new tm_NL();

		$NEWSLETTER->addGrp(Array("name"=>"NL Group 1", "descr"=>"zum testen / for testings", "aktiv"=>1, "author"=>"install", "created"=>$created, "editor"=>"install", "updated"=>$created));
		$NEWSLETTER->setGRPStd(1,1);
		$NEWSLETTER->addGrp(Array("name"=>"NL Group 2", "descr"=>"zum testen / for testings", "aktiv"=>0, "author"=>"install", "created"=>$created, "editor"=>"install", "updated"=>$created));
//nl: personal, massmailing
		$body="Hallo {F0} {F1} {F2}<br>\n".
					"<br>\n".
					"Attachement-URL<br>\n".
					"{ATTACH1_URL}<br>\n".
					"Attachement mit Link<br>\n".
					"{ATTACH1} {ATTACH1_URL} {CLOSELINK}<br>\n".
					"<br>\n".
					"Link-URL<br>\n".
					"{LINK1_URL}<br>\n".
					"<br>\n".
					"Link mit Link<br>\n".
					"{LINK1}{LINK1_URL}{CLOSELINK}<br>\n".
					"<br>\n".
					"Bild-URL<br>\n".
					"{IMAGE1_URL}<br>\n".
					"<br>\n".
					"Bild<br>\n".
					"{IMAGE1}<br>\n".
					"<br>\n".
					"Bild mit Link<br>\n".
					"{LINK1}{IMAGE1}{CLOSELINK}<br>\n".
					"<br>\n".
					"Online-URL<br>\n".
					"{NLONLINE_URL}<br>\n".
					"<br>\n".
					"Online Link<br>\n".
					"{NLONLINE} {NLONLINE_URL} {CLOSELINK}<br>\n".
					"<br>\n".
					"Ihre bei uns gespeicherten Daten:<br>\n".
					"{F3}, {F4}, {F5}, {F6}, {F7}, {F8}, {F9}<br>\n".
					"Die email mit der Sie bei unserem Newsletter angemeldet sind lautet: {EMAIL}<br>\n".
					"Wenn Sie unseren Newsleter nicht mehr erhalten moechten, koennen Sie sich<br>\n".
					"{UNSUBSCRIBE_URL}<br>\n".
					"{UNSUBSCRIBE}HIER{CLOSELINK} abmelden.<br>\n".
					"{UNSUBSCRIBE}{UNSUBSCRIBE_URL}{CLOSELINK}<br>\n".
					"<br>\n".
					"Url zum Blindimage:<br>\n".
					" {BLINDIMAGE_URL}<br>\n".
					"<br>\n".
					"Blindimage:<br>\n".
					"{BLINDIMAGE}<br>\n".
					"Der Link zum Bestaetigen des Newsletter Empfangs f. 1st-touch-opt-in:<br>\n".
					"{SUBSCRIBE_URL}<br>\n".
					"<br>\n".
					"{SUBSCRIBE}{SUBSCRIBE_URL}{CLOSELINK}<br>\n".
					"<br>\n".
					"Viel Spass mit tellmatic! :-)<br>\n";
		$NEWSLETTER->addNL(
								Array(
									"subject"=>"Newsletter 1",
									"body"=>$body,
									"aktiv"=>1,
									"status"=>1,
									"massmail"=>0,
									"link"=>"http://www.tellmatic.org",
									"created"=>date("Y-m-d H:i:s"),
									"author"=>"example",
									"grp_id"=>1,
									"attm"=>"",
									"track_image"=>"_blank",
									"content_type"=>"text/html"
									)
								);

//adr gruppe
		$ADDRESS=new tm_ADR();

		$ADDRESS->addGrp(Array("name"=>"ADR Group 1", "descr"=>"zum testen / for testings", "aktiv"=>1, "author"=>"install", "created"=>$created, "editor"=>"install", "updated"=>$created));
		$ADDRESS->setGRPStd(1,1);
		$ADDRESS->addGrp(Array("name"=>"ADR Group 2", "descr"=>"zum testen / for testings", "aktiv"=>0, "author"=>"install", "created"=>$created, "editor"=>"install", "updated"=>$created));
//adr : ok, bounce
			$code=rand(111111,999999);
			$new_adr_grp[0]=1;
			$ADDRESS->addAdr(Array(
					"email"=>"test@tellmatic.org",
					"aktiv"=>1,
					"created"=>date("Y-m-d H:i:s"),
					"author"=>"example",
					"status"=>3,
					"code"=>$code,
					"memo"=>$created,
					"f0"=>"Herr",
					"f1"=>"Telly",
					"f2"=>"Tellmatic",
					"f3"=>"",
					"f4"=>"",
					"f5"=>"",
					"f6"=>"",
					"f7"=>"",
					"f8"=>"",
					"f9"=>""
					),
					$new_adr_grp);

			$code=rand(111111,999999);
			$new_adr_grp[0]=1;
			$ADDRESS->addAdr(Array(
					"email"=>"bounce@tellmatic.org",
					"aktiv"=>1,
					"created"=>date("Y-m-d H:i:s"),
					"author"=>"example",
					"status"=>1,
					"code"=>$code,
					"memo"=>$created,
					"f0"=>"Herr",
					"f1"=>"Tello",
					"f2"=>"Bounce",
					"f3"=>"",
					"f4"=>"",
					"f5"=>"",
					"f6"=>"",
					"f7"=>"",
					"f8"=>"",
					"f9"=>""
					),
					$new_adr_grp);


//form
		$FORMULAR=new tm_FRM();
		$new_adr_grp[0]=1;
		$FORMULAR->addForm(Array(
				"name"=>"Form 1",
				"descr"=>"zum testen / for testing",
				"aktiv"=>1,
				"created"=>date("Y-m-d H:i:s"),
				"author"=>"example",
				"double_optin"=>0,
				"use_captcha"=>1,
				"digits_captcha"=>4,
				"subscribe_aktiv"=>1,
				"submit_value"=>"Abschicken",
				"reset_value"=>"Eingaben zurücksetzen",
				"email"=>"E-Mail",
				"f0"=>"Anrede",
				"f1"=>"Name",
				"f2"=>"Name2",
				"f3"=>"",
				"f4"=>"",
				"f5"=>"",
				"f6"=>"",
				"f7"=>"",
				"f8"=>"",
				"f9"=>"",
				"f0_type"=>"select",
				"f1_type"=>"text",
				"f2_type"=>"text",
				"f3_type"=>"text",
				"f4_type"=>"text",
				"f5_type"=>"text",
				"f6_type"=>"text",
				"f7_type"=>"text",
				"f8_type"=>"text",
				"f9_type"=>"text",
				"f0_required"=>1,
				"f1_required"=>1,
				"f2_required"=>1,
				"f3_required"=>0,
				"f4_required"=>0,
				"f5_required"=>0,
				"f6_required"=>0,
				"f7_required"=>0,
				"f8_required"=>0,
				"f9_required"=>0,
				"f0_value"=>"Frau;Herr;Firma",
				"f1_value"=>"",
				"f2_value"=>"",
				"f3_value"=>"",
				"f4_value"=>"",
				"f5_value"=>"",
				"f6_value"=>"",
				"f7_value"=>"",
				"f8_value"=>"",
				"f9_value"=>"",
				"f0_expr"=>"^[A-Za-z_ ][A-Za-z0-9_ ]*$",
				"f1_expr"=>"^[A-Za-z_ ][A-Za-z0-9_ ]*$",
				"f2_expr"=>"^[A-Za-z_ ][A-Za-z0-9_ ]*$",
				"f3_expr"=>"",
				"f4_expr"=>"",
				"f5_expr"=>"",
				"f6_expr"=>"",
				"f7_expr"=>"",
				"f8_expr"=>"",
				"f9_expr"=>"",
				"email_errmsg"=>"Ungültige E-Mail-Adresse",
				"captcha_errmsg"=>"Spamschutz! Bitte geben Sie untenstehenden Zahlencode ein.",
				"f0_errmsg"=>"Bitte füllen Sie das Feld Anrede aus",
				"f1_errmsg"=>"Bitte füllen Sie das Feld Name aus",
				"f2_errmsg"=>"Bitte füllen Sie das Feld Name2 aus",
				"f3_errmsg"=>"",
				"f4_errmsg"=>"",
				"f5_errmsg"=>"",
				"f6_errmsg"=>"",
				"f7_errmsg"=>"",
				"f8_errmsg"=>"",
				"f9_errmsg"=>""

				),
				$new_adr_grp);
	}//demo
}//if check
?>