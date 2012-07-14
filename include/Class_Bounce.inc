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

Class mBounce {
	var $Bounces=Array();
	var $count=0;
	
	function filterBounces($Mail,$checkHeader=1,$checkBody=1,$returnOnlyBounces=0,$returnOnlyTo="") {
		/*
		Uebernimmt ein Array fuer eine einzelne Mail (aus class mMail ... getMail()] und prueft wahlweise Header und /oder Body auf Bounces...und gibt dieses Array 'gefiltert' zurueck
		*/
		$Bounce_Head=Array();
		$Bounce_Body=Array();
		
		$mc=count($Mail);
		for ($mcc=0;$mcc<$mc;$mcc++) {
		
			//pruefen des to: felds auf email
			//wenn $returnOnlyTo nict leer ist aber nicht gleich der to adresse....
			if (!empty($returnOnlyTo) && $returnOnlyTo!=$Mail[$mcc]['to']) {
				unset($Mail[$mcc]);
			}
			
			//abfrage isset fuer bouncemail scanning.....evtl haben wir den eintrag ja geloescht...
			if (isset($Mail[$mcc])) {
				$is_bouncemail=false;
				$Message=$Mail[$mcc];//Array
				//header checken?
				if ($checkHeader) {
					$Bounce_Head=$this->checkHeader($Message);
				}
				//body checken?
				if ($checkBody) {
					$Bounce_Body=$this->checkBody($Message);
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

	function checkHeader($Message) {
		$Bounce=Array();
		$header = explode("\n", $Message['header']);
		$bounce_count=0;
		$regex_headerfield="^([^:]*): (.*)";
		$regex_nextline="^([^ ]*)(.*)";
	   // browse array
	   if (is_array($header) && count($header)) {
	       $lc=count($header);//anzahl zeilen, lines
		    for ($lcc=0;$lcc<$lc;$lcc++) {
	       		$line=$header[$lcc];
				//wir suchen als erstes nach einem X-Header X-Failed-recipients: name@domain.tld
				//mehrere adressen sind moeglicherweise zeilenweise angefuegt....
	           if (eregi("^X-failed", $line)) {
	               //trennen von name und wert (alles nach ': ')
	               eregi("$regex_headerfield", $line, $arg);
	               //adresse speichern
					$arg[2]=utrim(str_replace(",","",$arg[2]));
					if (checkemailadr($arg[2],1)) {
	               		$Bounce[$bounce_count] =utrim($arg[2]);
	               		$bounce_count++;
					}
					//nun die naechste zeile pruefen....! wenn diese existiert kein headerfeld enthaelt, fuegen wir sie an da es moeglicherweise eine weitere x-failed adrese ist......!
					for ($lcc2=($lcc+1);$lcc2<$lc;$lcc2++) {
						if (isset($header[$lcc2]) && !eregi("$regex_headerfield", $header[$lcc2])) {
		               		eregi("$regex_nextline", $header[$lcc2], $arg);
							if (!empty($arg[2])) {
								$arg[2]=utrim(str_replace(",","",$arg[2]));
								if (checkemailadr($arg[2],1)) {
				               		$Bounce[$bounce_count] = $arg[2];
				               		$bounce_count++;
								}
			            	}
			         	}
					}
					$lcc=$lc;//damit wird die schleife beednet!
	               unset ($arg); 
	           }//if eregi x-faild....
	       }//for lcc (1)
	   }//is array && count
	   return $Bounce;
	}//function checkHeader()






	function checkBody($Message) {
		$Bounce=Array();
		$body=explode("\n", $Message['body']);
		$bounce_count=0;
		foreach ($body as $line) {
			//wir suchen nun nach diversen mustern....
			//als erste trennen wir nach : doppelpunkt :
			//und nach ; semikolon ;
			//< und > wegmachen....
			$line=str_replace("<","",$line);
    		$line=str_replace(">","",$line);
					
    		//doppelpunkt auch filtern
    		$line=str_replace(":","",$line);
			$line=utrim($line);
			//for each regex_body as $regex... etc
			//wenn email syntax korrekt, also wenn es wirklich einen email ist in dieser zeile....
			//checkemailadr($email,1)//1==nur syntax
			if (checkemailadr($line,1)) {
    	       $Bounce[$bounce_count] = $line;
    	       $bounce_count++;
			} else {
				//spezialfall 1
				//Original-Recipient: rfc822;mnl_xxxx@domain.tld
				//Final-Recipient: rfc822;mnl_xxxx@domain.tld
				//wir trennen nach semikolon..... und nehmen den zweiten eintrag!
				$line_x = explode(";", $line);
				if (isset($line_x[1])) {
					$line_x[1]=utrim($line_x[1]);
					if (checkemailadr($line_x[1],1)) {
  		 	        	$Bounce[$bounce_count] = $line_x[1];
  		   		      	$bounce_count++;
					}	//checkemailadr line_x
				}//isset line_x[1]
			} //chkemail line
		}//foreach
		return $Bounce;
	}//function check Body
	

} //Class mBounce
?>