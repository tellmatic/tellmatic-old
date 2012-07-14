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
	//STATUSCODES
	//statuscodes und bilder dazu
	$STATUS=Array(
						"adr"=>Array(
								"status"=>Array(
												1=>___("Neu"),
												2=>___("OK"),
												3=>___("Bestätigt"),
												4=>___("Angezeigt"),
												5=>___("Warten"),
												6=>"6",
												7=>"7",
												8=>___("Fehler C"),
												9=>___("Fehler A"),
												10=>___("Fehler S"),
												11=>___("Abgemeldet"),
												12=>___("Touch")
								),
								"descr"=>Array(
												1=>___("Neuanmeldung"),
												2=>___("manuell Eingetragen, Syntax Geprüft, Senden OK"),
												3=>___("Bestätigt, Double-Opt-In"),
												4=>___("Rechecked, NL/Blindimage angezeigt"),
												5=>___("Warten auf Bestätigung (Double-Opt-IN)"),
												6=>___("undefiniert"),
												7=>___("undefiniert"),
												8=>___("Fehler beim versenden, Status/Aktiv wurde geändert vor dem versenden!"),
												9=>___("Fehlerhafte Adresse o. Rückläufer"),
												10=>___("Fehler beim versenden, neuer Versuch"),
												11=>___("Abgemeldet"),
												12=>___("1st-Touch-Opt-In")
								),
								"statimg"=>Array(
												1=>"bullet_black.png",
												2=>"new.png",
												3=>"bullet_green.png",
												4=>"bullet_feed.png",
												5=>"bullet_purple.png",
												6=>"bullet_yellow.png",
												7=>"bullet_black.png",
												8=>"page_error.png",
												9=>"bullet_error.png",
												10=>"transmit_error.png",
												11=>"user_red.png",
												12=>"user_add.png"
								),
								"color"=>Array(
												1=>"#009933",
												2=>"#00cc66",
												3=>"#00ff00",
												4=>"#00ffff",
												5=>"#ffff00",
												6=>"#000000",
												7=>"#000000",
												8=>"#ff6600",
												9=>"#ff0000",
												10=>"#ffcc00",
												11=>"#333333",//#ff9933
												12=>"#996600"
								),
						),

						"nl"=>Array(
								"status"=>Array(
												"1"=>___("Neu"),
												"2"=>___("Queued"),
												"3"=>___("Versand"),
												"4"=>___("Gesendet"),
												"5"=>___("Archiv"),
												"6"=>___("Warten")
								),
								"descr"=>Array(
												"1"=>___("Keine Versandaufträge oder Historie f. dieses Newsletter"),
												"2"=>___("In der Warteschlange"),
												"3"=>___("Versand gestartet"),
												"4"=>___("Versendet"),
												"5"=>___("Archiviert - Qs wurden gelöscht"),
												"6"=>___("Versand vorbereitet, Warten auf Versand (terminiert)")
								),
								"statimg"=>Array(
												"1"=>"new.png",
												"2"=>"clock_orange.png",
												"3"=>"clock_play.png",
												"4"=>"feed_green.png",
												"5"=>"feed_disk_blue.png",
												"6"=>"clock.png"
								),
								"color"=>Array(
												"1"=>"#009933",
												"2"=>"#ffcc00",
												"3"=>"#00ff00",
												"4"=>"#00ffcc",
												"5"=>"#333399",
												"6"=>"#ffff00"
								),
						),

						"q"=>Array(
								"status"=>Array(
												"1"=>___("Neu"),
												"2"=>___("Gestartet"),
												"3"=>___("Running"),
												"4"=>___("Fertig"),
												"5"=>___("Angehalten")
								),
								"descr"=>Array(
												"1"=>"",
												"2"=>___("Wird versendet"),
												"3"=>___("In Arbeit"),
												"4"=>___("Versendet"),
												"5"=>___("Angehalten")
								),
								"statimg"=>Array(
												"1"=>"new.png",
												"2"=>"clock_orange.png",
												"3"=>"clock_play.png",
												"4"=>"feed_green.png",
												"5"=>"stop.png"
								),
						),

						"h"=>Array(
								"status"=>Array(
												"1"=>___("Neu"),
												"2"=>___("Fertig"),
												"3"=>___("View"),
												"4"=>___("Fehler"),
												"5"=>___("Versand"),
												"6"=>___("Abbruch")
								),
								"descr"=>Array(
												"1"=>___("Warten auf Versand"),
												"2"=>___("Versendet, OK"),
												"3"=>___("Versendet, angezeigt"),
												"4"=>___("Versendet, Fehler"),
												"5"=>___("Wird in diesem Moment versendet!!!"),
												"6"=>___("Abgebrochen, Q gelöscht")
								),
								"statimg"=>Array(
												"1"=>"new.png",
												"2"=>"bullet_green.png",
												"3"=>"bullet_feed.png",
												"4"=>"bullet_error.png",
												"5"=>"bullet_feed.png",
												"6"=>"bullet_red.png"
								),
						),
				);
?>