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

Class tm_Bounce {
	var $Bounces=Array();
	var $count=0;
	var $regex_headerfield="^([^:]*): (.*)";
	//the easy way, everything that might look like an emailaddress
	var $regex_email='/[-.\w]+@[-.\w]+\.\w{2,}/';//for preg_match_all: /[-.\w]+@[-.\w]+\.\w{1,6}/
	//array with regex for headers to search for addresses
	var $searchXHeaders=Array("^X-Failed:","^From:","^Return-Path:","^Reply-To:","^Followup-To:","^CC:","^To:","^envelope-to:","^X-");
	//"^X-Failed:","^From:","^Return-Path:","^Reply-To:","^Followup-To:","^CC:","^To:","^envelope-to:","^X-"
	//chars to remove from header key value
	var $removable_chars=Array("<",">","|",":",",",";");//"<",">","|",":",",",";"

	function filterBounces($Mail,$checkHeader=1,$checkBody=1,$returnOnlyBounces=0) {
		/*
		Uebernimmt ein Array fuer eine einzelne Mail (aus class mMail ... getMail()] und prueft wahlweise Header und /oder Body auf Bounces...und gibt dieses Array 'gefiltert' zurueck
		*/
		$Bounce=Array();
		$Bounce_Head=Array();
		$Bounce_Body=Array();

		$mc=count($Mail);
		for ($mcc=0;$mcc<$mc;$mcc++) {
			if (isset($Mail[$mcc])) {
				$is_bouncemail=false;
				$Message=$Mail[$mcc];//Array
				//header checken?
				if ($checkHeader==1) {
					$Bounce_Head=$this->checkHeader($Message['header']);
					//adressen mit falscher syntax rauswerfen
					$Bounce_Head=$this->removeInvalidEmails($Bounce_Head);
				}
				//body checken?
				if ($checkBody==1) {
					$Bounce_Body=$this->checkBody($Message['body']);
					//adressen mit falscher syntax rauswerfen
					$Bounce_Body=$this->removeInvalidEmails($Bounce_Body);
				}
				//wenn was gefunden wurde... ist der array nicht leer, also ist es eine potentielle boncemail
				$Mail[$mcc]['is_bouncemail']=0;
				if (count($Bounce_Head) || count($Bounce_Body)) {
					$is_bouncemail=true;
					$Mail[$mcc]['is_bouncemail']=1;
				}
				//wenn nur bounces zurueckgeliefert werden sollen, und es ist keines, dann eintrag loeschen
				if ($returnOnlyBounces==1 && !$is_bouncemail ) {
					unset($Mail[$mcc]);
				}
				if ($returnOnlyBounces==0 || ($returnOnlyBounces==1 && $is_bouncemail) ) {
					//array erzeigen aus den gefundenen adressen in head und body
					$Bounce=array_merge($Bounce_Head,$Bounce_Body);
					//hier unifying, da wir pro mail jede adresse nur einmal auswerten muessen.
					$Bounce=unify_array($Bounce);
					//Array in der Message Speichern
					$Mail[$mcc]['bounce']=$Bounce;
				}
			}
		}
		//arraay neu ordnen
		$Mail=array_values($Mail);
		return $Mail;
	}//function filter Bounces
	function check_for_emails($line) {
		$adr=Array();
		$return=Array();
		if (preg_match_all($this->regex_email , $line, $adr)) {
			$lac=count($adr[0]);
			for ($lacc=0;$lacc<$lac;$lacc++) {
				$email=$adr[0][$lacc];
				$ac=count($return);
				$return[$ac]=$email;
			}//for
		}//if pregmatch
		return $return;
	}//check_for_emails

	function removeInvalidEmails($adr) {
		//removes syntactically invalid emails from 1-dim adr array
		$ac=count($adr);
		for ($acc=0;$acc<$ac;$acc++) {
			if (isset($adr[$acc])) {
				$check_mail=checkEmailAdr($adr[$acc],1);//1=nur syntax
				if (!$check_mail[0]) unset($adr[$acc]);
			}
		}
		$adr=array_values($adr);
		return $adr;
	}//removeInvalidEmails

	function checkHeader($message_header) {
		$adr=array();
		$header_lines = explode("\n", $message_header);
		$hlc=count($header_lines);//anzahl zeilen, lines
		#if (DEBUG) echo "found ".$hlc." lines in header<br>\n";
		//now browse header array:
		$lc=count($header_lines);
		for ($lcc=0;$lcc<$lc;$lcc++) {
			$hline_arr=Array();
			$hline=$header_lines[$lcc];
			#if (DEBUG) echo "<br>\nline $lcc: <font size=1>".$hline."</font>";
			//sieht die zeile wie eine headerzeile aus? 
			//trennen von name und wert (alles nach ': ')
		   if (eregi($this->regex_headerfield, $hline, $hline_arr)) {
		   	#if (DEBUG) echo "<br>\nis Header, continue";
		      #if (DEBUG) echo "<br>\nsplit header and value: ";
			   $hline_key=$hline_arr[1];
			   $hline_value=$hline_arr[2];
		      if (DEBUG) echo "<br>\nkey: ".$hline_key."<br>\nvalue: ".$hline_value;
				//remove removable chars
				$hline_value=str_replace($this->removable_chars," ",$hline_value);
		  		//search for headers
		  		foreach ($this->searchXHeaders as $XHeader) {
		  			//if header matches
		         if (eregi("$XHeader", $hline)) {
			         #if (DEBUG) echo "<br>\nmatches: '$XHeader'";
						//now detect email in current line.......
						$xadr=$this->check_for_emails($hline_value);
						//merge array with $adr
						$adr=array_merge($adr,$xadr);
							//mehrere adressen sind moeglicherweise zeilenweise angefuegt....
							//nun die naechste zeile pruefen....! wenn diese existiert kein headerfeld enthaelt, fuegen wir sie an da es moeglicherweise eine weitere x-failed adrese ist......!
							#if (isset($header_lines[$lcc+1]) && !eregi("$regex_headerfield", $header_lines[$lcc+1])) {//doppeltgemoppelt, aber noetig fuer die meldung, kann eigentlich weg, dann wird es aber immer durchlaufen....
								#if (DEBUG) echo "<br>\n....continues on next headerline ".($lcc+1);
								//nun die naechsten zeilen pruefen....! wenn diese existiert kein headerfeld enthaelt, fuegen wir sie an da es moeglicherweise eine weitere header adrese ist......! sobald headerfield entdeckt wurde, abbruch, lcc2=lc
								for ($lcc2=($lcc+1);$lcc2<$lc;$lcc2++) {
									if (isset($header_lines[$lcc2]) && !eregi($this->regex_headerfield, $header_lines[$lcc2])) {
										#if (DEBUG) echo "<br>checking next line $lcc2";
										$hline2=$header_lines[$lcc2];
										#if (DEBUG) echo "<br>$hline2";
										$xadr=$this->check_for_emails($hline2);
										#if (DEBUG) print_r($xadr);
										$adr=array_merge($adr,$xadr);
						         } else {//if isset 
						         	#if (DEBUG) echo "<br>skip, next line ".($lcc2)." is a new headerline!";
						         	$lcc2=$lc;//absprung
						         }//if isset 
								}//for lcc2
							#}//if isset headerline+1
		           }//if eregi XHeader....
				}//foreach searchXHeader as XHeader
			} else {//if line looks like a header
				#if (DEBUG) echo "<br>\ndoes not look like a headerline...";
			}//if line looks like a header
		   #if (DEBUG) echo "<br>\n----------------------------------------------------------------<br>\n";
		}//foreach header_lines as line
		#if (DEBUG) echo "<br>gesamt ".count($adr)." adressen erkannt<br>";
		$adr=array_unique($adr);
		return $adr;
	}//checkHeader

	function checkBody($message_body) {
		$adr=array();
		$body_lines = explode("\n", $message_body);
		$hlc=count($body_lines);//anzahl zeilen, lines
		#if (DEBUG) echo "found ".$hlc." lines in body<br>\n";
		//now browse body line array:
		$lc=count($body_lines);
		for ($lcc=0;$lcc<$lc;$lcc++) {
			$bline_arr=Array();
			$bline=$body_lines[$lcc];
			#if (DEBUG) echo "<br>\nline $lcc: <font size=1>".$bline."</font>";
				//remove removable chars
				$bline=str_replace($this->removable_chars," ",$bline);
				$xadr=$this->check_for_emails($bline);
				//merge array with $adr
				$adr=array_merge($adr,$xadr);
		}//foreach body_lines as line
		#if (DEBUG) echo "<br>gesamt ".count($adr)." adressen erkannt<br>";
		$adr=array_unique($adr);
		return $adr;
	}//checkBody

} //Class tm_Bounce
?>