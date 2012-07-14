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

$_MAIN_DESCR="Bounce Management";
$_MAIN_MESSAGE.="";

$set=getVar("set");
if (empty($set)) {
	$set="connect";
}

$InputName_Host="host";//
$$InputName_Host=getVar($InputName_Host);
if (empty($$InputName_Host)) {
	$$InputName_Host=$SMTPHost;
}

$InputName_Limit="limit";
$$InputName_Limit=getVar($InputName_Limit);
if ($$InputName_Limit <1 || empty($$InputName_Limit)) {
	$$InputName_Limit=10;
}

$InputName_Offset="offset";
$$InputName_Offset=getVar($InputName_Offset);
if ($$InputName_Offset <0 || empty($$InputName_Offset)) {
	$$InputName_Offset=0;
}

$InputName_Bounce="bounce";//
$$InputName_Bounce=getVar($InputName_Bounce,1);
//
$InputName_FilterTo="filter_to";//
$$InputName_FilterTo=getVar($InputName_FilterTo,1);
//

$InputName_Mail="mailno";//
pt_register("POST","mailno");
if (!isset($mailno)) {
	$mailno=Array();
}

$InputName_Adr="adr";//
pt_register("POST","adr");
if (!isset($adr)) {
	$adr=Array();
}

$InputName_Action="val";
$$InputName_Action=getVar($InputName_Action);
if (empty($val)) {
	$val="list";
}

$InputName_ActionAdr="val2";
$$InputName_ActionAdr=getVar($InputName_ActionAdr);

//if ($val!="filter" && $val!="filter_delete") {
	include_once ($mnl_includepath."/bounce_host_form.inc");
//}

//server ausgewaehlt, wir connecten
if ($set=="connect") {

	$Mailer=new mMail();
	$Bounce=new mBounce();
	$ADDRESS=new mnlADR();

	$search_mail=Array();
	//filter? emails suchen? 
	if ($filter_to==1) { 
		//nur mails an aktuelle return adesse fuer host
		$search_mail['to']=$ReturnPath;
	}
	
	$_MAIN_OUTPUT .= "<br>Verbindung zum Server $SMTPHost wird aufgebaut...";
	$Mailer->Connect($SMTPHost, $SMTPUser, $SMTPPasswd);
	//$folders = imap_listmailbox ($Mailer->mbox, "{".$Mailer->Srv."}INBOX", "*");
	if (!empty($Mailer->Error)) {
		$_MAIN_MESSAGE .= "<br><b>Servermeldung:</b><ul>".$Mailer->Error."</ul>";
	}
	
	//Mails auslesen
	$Mail=$Mailer->getMail(0,$offset,$limit,$search_mail);

	if ($val=="filter" || $val=="filter_delete") {
		$mc=count($mailno);
		if ($mc>0) {
			include_once ($mnl_includepath."/bounce_filter_form_head.inc");//formularokpf und felder
			//include_once ($mnl_includepath."/bounce_filter_list.inc");//liste der durchsuchten emails, ausgelagert und zusammengefasst in list!
			include_once ($mnl_includepath."/bounce_filter_adr_list.inc");//liste der aressen mit checkboxen
			include_once ($mnl_includepath."/bounce_filter_form.inc");//render formular! aktion waehlen etc
		} else {
			$_MAIN_MESSAGE.= "<br>Es wurden keine Mails zum Bearbeiten ausgewaehlt.";
			$val="list";
		}
	}


	if ($val=="delete" || $val=="filter_delete") {
		$mc=count($mailno);
		if ($mc>0) {
			$_MAIN_MESSAGE .= "<br>Loesche Mail: ";
			for ($mcc=0;$mcc<$mc;$mcc++) {
				$_MAIN_MESSAGE .= "".$mailno[$mcc]." ";
				$Mailer->delete($mailno[$mcc]);
			}
			//mailbox aufraeumen
			$_MAIN_MESSAGE .= "<br>Mailbox aufraeumen, als geloescht markierte Mails wurden entfernt.";
			$Mailer->expunge();
			//todo: reconnect! damit bekommen wir aktuelle servermeldungen etc.
			//Mails neu auslesen
			$Mail=$Mailer->getMail(0,$offset,$limit,$search_mail);
		} else {
			$_MAIN_MESSAGE.= "<br>Es wurden keine Mails zum Loeschen ausgewaehlt.";
			$val="list";
		}
		//nur bei delete die liste wieder anzeigen, bei filter oder filter_delete setzen wir es hinterher im hiddenfield auf list, bzw zeigen vorher noch das adressformular an!
		if ($val=="delete") {
			$val="list";
		}
	}


	
	//val2==..... aktionen fuer die adressen
	if (!empty($val2)) {
		$ac=count($adr);

		if ($ac>0) {
			$_MAIN_MESSAGE.= "<br>$ac Adressen zum Bearbeiten ausgewaehlt.";

			for ($acc=0;$acc<$ac;$acc++) {
				$search['email']=$adr[$acc];
				$A=$ADDRESS->getAdr(0,0,0,0,$search);
				if (isset($A[0]['id'])) {
				
					if ($val2 == "delete") {
						$ADDRESS->delAdr($A[0]['id']);
						$_MAIN_MESSAGE.= "<br>".$A[0]['email']." wurde geloescht.";
					}
					
					if ($val2 == "error") {
						$ADDRESS->setStatus($A[0]['id'],9);
						$_MAIN_MESSAGE.= "<br>".$A[0]['email']." wurde als Fehlerhaft markiert.";
					}

					if ($val2 == "aktiv") {
						$ADDRESS->setAktiv($A[0]['id'],0);
						$_MAIN_MESSAGE.= "<br>".$A[0]['email']." wurde deaktiviert.";
					}

					if ($val2 == "unsubscribe") {
						$ADDRESS->unsubscribe($A[0]['id'],"Bounce");
						$ADDRESS->setAktiv($A[0]['id'],0);
						$_MAIN_MESSAGE.= "<br>".$A[0]['email']." wurde als abgemeldet und deaktivert.";
					}
					if ($val2 == "auto") {
						$_MAIN_MESSAGE.= "<br>".$A[0]['email'].": ";
						//wenn erros noch unter dem limit... 
						//if ($A[0]['errors'] <= $max_mails_retry) {
							//fehler zaehlen
							$ADDRESS->setAError($A[0]['id'],($A[0]['errors']+1));
							$_MAIN_MESSAGE.= " -- Fehler: ".($A[0]['errors']+1)." von max.".$max_mails_retry;

							//wenn adresse noch nicht abgemeldet!!!!! 
							if ($A[0]['status']!=11) {
								//wenn erros das limit ueberschritten hat:
								if (($A[0]['errors']+1) > $max_mails_retry)  {
									//unsubscribe und deaktivieren
									$ADDRESS->setStatus($A[0]['id'],9);
									$ADDRESS->setAktiv($A[0]['id'],0);
									$_MAIN_MESSAGE.= " -- als fehlerhaft markiert und deaktivert (sendefehler >".$max_mails_retry.").";
								} else {
									//wenn errors limit noch nicht ueberschritten
									//dann als sendefehler markieren
									//das auch nur wenn status nicht warten ist.
									//oben ist status warten ok, da der fehler gezaehlt wird, kommen so und so viele bouncemails wegen der optin mail, so wird er deaktiviert etc und als fehelrhaft markiert
									if ($A[0]['status']!=5) {
										$ADDRESS->setStatus($A[0]['id'],10);
									}
								}
							} else {
								$_MAIN_MESSAGE.= " -- ist bereits abgemeldet (unsubscribed).";// und wurde geloescht
								//$ADDRESS->delAdr($A[0]['id']);
							}// if status !=11
						//} // else {}
			

					}
					
				} else { //isset A
					$_MAIN_MESSAGE.= "<br>".$adr[$acc]." ist nicht bekannt.";
				}//isset A
			}//for $acc
		} else { //$ac>0
			$_MAIN_MESSAGE.= "<br>Es wurden keine Adressen zum Bearbeiten ausgewaehlt.";
		}//$ac>0
	}//if !empty val2






	//Liste der Mails anzeigen
	if ($val=="list") {
		include_once ($mnl_includepath."/bounce_mail_form_head.inc");
		include_once ($mnl_includepath."/bounce_mail_list.inc");
		include_once ($mnl_includepath."/bounce_mail_form.inc");
	}
	//verbindung schliessen
	$Mailer->disconnect();
} else {
	//include_once ($mnl_includepath."/bounce_host_form.inc");
}

?>