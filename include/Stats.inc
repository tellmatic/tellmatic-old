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
	//statuscodes der adressen und bilder dazu
	//$STATUS['adr']['status'][0]="--";
	 
	//achtung!!! wenn neuer status dann auch beim versenden beachten......... und evtll. anfuegen an if abfrage, send.inc
	$STATUS['adr']['status'][1]=___("Neu");
	$STATUS['adr']['status'][2]=___("OK");
	$STATUS['adr']['status'][3]=___("Bestaetigt");
	$STATUS['adr']['status'][4]=___("Angezeigt");
	$STATUS['adr']['status'][5]=___("Warten");
	$STATUS['adr']['status'][6]="6";
	$STATUS['adr']['status'][7]="7";
	$STATUS['adr']['status'][8]=___("Fehler C");
	$STATUS['adr']['status'][9]=___("Fehler A");
	$STATUS['adr']['status'][10]=___("Fehler S");
	$STATUS['adr']['status'][11]=___("Abgemeldet");
	$STATUS['adr']['status'][12]=___("Touch");
	
	
	$STATUS['adr']['descr'][1]=___("Neuanmeldung");
	$STATUS['adr']['descr'][2]=___("manuell Eingetragen, Syntax Gepr&uuml;ft, Senden OK");
	$STATUS['adr']['descr'][3]=___("Best&auml;tigt, Double-Opt-In");
	$STATUS['adr']['descr'][4]=___("Rechecked, NL/Blindimage angezeigt");
	$STATUS['adr']['descr'][5]=___("Warten auf Best&auml;tigung (Double-Opt-IN)");
	$STATUS['adr']['descr'][6]=___("undefiniert");
	$STATUS['adr']['descr'][7]=___("undefiniert");
	$STATUS['adr']['descr'][8]=___("Fehler beim versenden, Status/Aktiv wurde ge&auml;ndert vor dem versenden!");
	$STATUS['adr']['descr'][9]=___("Fehlerhafte Adresse o. Rueckl&auml;ufer");
	$STATUS['adr']['descr'][10]=___("Fehler beim versenden, neuer Versuch");
	$STATUS['adr']['descr'][11]=___("Abgemeldet");
	$STATUS['adr']['descr'][12]=___("1st-Touch-Opt-In");
	 
	$STATUS['adr']['statimg'][0]="bullet_black.png";
	$STATUS['adr']['statimg'][1]="new.png";
	$STATUS['adr']['statimg'][2]="bullet_green.png";
	$STATUS['adr']['statimg'][3]="bullet_feed.png";
	$STATUS['adr']['statimg'][4]="bullet_purple.png";
	$STATUS['adr']['statimg'][5]="bullet_yellow.png";
	$STATUS['adr']['statimg'][6]="bullet_black.png";
	$STATUS['adr']['statimg'][7]="bullet_black.png";
	$STATUS['adr']['statimg'][8]="page_error.png";
	$STATUS['adr']['statimg'][9]="bullet_error.png";
	$STATUS['adr']['statimg'][10]="transmit_error.png";
	$STATUS['adr']['statimg'][11]="user_red.png";//bullet_delete
	$STATUS['adr']['statimg'][12]="user_add.png";//bullet_delete
	
	 //statuscodes der newsletter und bilder dazu
	$STATUS['nl']['status'][1]=___("Neu");
	$STATUS['nl']['status'][2]=___("Queued");
	$STATUS['nl']['status'][3]=___("Versand");
	$STATUS['nl']['status'][4]=___("Gesendet");
	$STATUS['nl']['status'][5]=___("Archiv");
	$STATUS['nl']['status'][6]=___("Warten");
	
	$STATUS['nl']['descr'][1]=___("Keine Versandauftr&auml;ge oder Historie f. dieses Newsletter");
	$STATUS['nl']['descr'][2]=___("In der Warteschlange");
	$STATUS['nl']['descr'][3]=___("Versand gestartet");
	$STATUS['nl']['descr'][4]=___("Versendet");
	$STATUS['nl']['descr'][5]=___("Archiviert - Qs wurden gel&ouml;scht");
	$STATUS['nl']['descr'][6]=___("Versand vorbereitet, Warten auf Versand (terminiert)");
	
	$STATUS['nl']['statimg'][1]="new.png";
	$STATUS['nl']['statimg'][2]="clock_orange.png";
	$STATUS['nl']['statimg'][3]="clock_play.png";
	$STATUS['nl']['statimg'][4]="feed_green.png";
	$STATUS['nl']['statimg'][5]="feed_disk_blue.png";
	$STATUS['nl']['statimg'][6]="clock.png";
	
	//statuscodes der Q und bilder dazu
	$STATUS['q']['status'][1]=___("Neu");
	$STATUS['q']['status'][2]=___("Gestartet");
	$STATUS['q']['status'][3]=___("Running");
	$STATUS['q']['status'][4]=___("Fertig");
	$STATUS['q']['status'][5]=___("Angehalten");
	 
	$STATUS['q']['descr'][1]="";
	$STATUS['q']['descr'][2]=___("Wird versendet");
	$STATUS['q']['descr'][3]=___("In Arbeit");
	$STATUS['q']['descr'][4]=___("Versendet");
	$STATUS['q']['descr'][5]=___("Angehalten");
	
	$STATUS['q']['statimg'][1]="new.png";
	$STATUS['q']['statimg'][2]="clock_orange.png";
	$STATUS['q']['statimg'][3]="clock_play.png";
	$STATUS['q']['statimg'][4]="feed_green.png";//bullet_feed
	$STATUS['q']['statimg'][5]="stop.png";
	
	//statuscodes der History und bilder dazu
	$STATUS['h']['status'][1]=___("Neu");
	$STATUS['h']['status'][2]=___("Fertig");
	$STATUS['h']['status'][3]=___("View");
	$STATUS['h']['status'][4]=___("Fehler");//
	$STATUS['h']['status'][5]=___("Versand");//wird in diesem moment versendet!!!
	$STATUS['h']['status'][6]=___("Abbruch");//
	 
	$STATUS['h']['descr'][1]=___("Warten auf Versand");
	$STATUS['h']['descr'][2]=___("Versendet, OK");
	$STATUS['h']['descr'][3]=___("Versendet, angezeigt");
	$STATUS['h']['descr'][4]=___("Versendet, Fehler");
	$STATUS['h']['descr'][5]=___("Wird in diesem Moment versendet!!!");
	$STATUS['h']['descr'][6]=___("Abgebrochen, Q gel&ouml;scht");

	$STATUS['h']['statimg'][1]="new.png";
	$STATUS['h']['statimg'][2]="bullet_green.png";
	$STATUS['h']['statimg'][3]="bullet_feed.png";
	$STATUS['h']['statimg'][4]="bullet_error.png";
	$STATUS['h']['statimg'][5]="bullet_feed.png";
	$STATUS['h']['statimg'][6]="bullet_red.png";

//////////////////////////////////	
?>