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

$nl_id=getVar("nl_id");//nl id
$l_id=getVar("l_id");//link id
$q_id=getVar("q_id");//queue id
$a_id=getVar("a_id");//adr id
$h_id=getVar("h_id");//history id

//at first we need the newsletter id!
//we dont continue without a valid nl_id
//fetch newsletter and check if active, only active newsletters are valid
//check if nl is personalized
//check if link id is set and valid, otherwise replace with link1!!!
//count clicks and views
//do not add memo, we dont really need that
//instead we have the linktracker which can give much better statistics

$personalized=FALSE;//is personalized mailing?
$track_personalized=FALSE;//is personalized mailing?
$valid_nl=FALSE;//valid nl record?
$valid_adr=FALSE;//valid address record?
$valid_lnk=FALSE;//valid link?
$valid_h=FALSE;//do we have a valid history entry?
$valid_url=FALSE;

$URL="";

//check valid nl id
if (check_dbid($nl_id)) {
	//checkid()?
	$NEWSLETTER=new tm_NL();
	//Link holen
	$NL=$NEWSLETTER->getNL($nl_id);
	//check for valid newsletter, must be active and not a template
	if (isset($NL[0]) && $NL[0]['aktiv']==1 && $NL[0]['is_template']!=1) {
		$valid_nl=TRUE;

		//check if newsletter and tracking is personalized, massmail==0 track-personalized==1 need at least adr or history id here 
		if ($NL[0]['massmail']==0 && (check_dbid($a_id) || check_dbid($h_id)) ) {
			$personalized=TRUE;
		}
		if ($personalized && $NL[0]['track_personalized']==1 ) {
			$track_personalized=TRUE;
		}

		//check for valid url
		if (!empty($NL[0]['link'])) {
			$URL=$NL[0]['link'];
			$valid_url=TRUE;
		}

		//check for valid record in history/rcpt-list
		if (check_dbid($h_id) && $personalized) {
			$QUEUE=new tm_Q();
			$H=$QUEUE->getH($h_id);
			if (isset($H[0])) {
				$valid_h=TRUE;
				//now we can check if we have a valid address record... if not, we can get one from the history table... :O
				if (!check_dbid($a_id) && check_dbid($H[0]['adr_id']) ) {
					//if a_id is not valid yet, set a_id to a_id from history table
					//must be done before address checking ;)
					$a_id=$H[0]['adr_id'];
				}
				//if we have valid adr_id yet, lets check if it differs from the adr_i in hostory table... if not, we dont have a valid h record
				if (check_dbid($a_id) && $a_id!=$H[0]['adr_id']) {
					$valid_h=FALSE;
				}
				//also check if newsletter matches history!
				if ($valid_nl && $nl_id!=$H[0]['nl_id']) {
					$valid_h=FALSE;
				}
				//ok, if we have a valid h record, lets do some tracking and logging
			}//isset H
		}//check_dbid h_id && personalized
		
		//check for valid address record
		if (check_dbid($a_id) && $personalized) {
			$ADDRESS=new tm_ADR();
			$ADR=$ADDRESS->getAdr($a_id);
			//check if adr isset , active and not unsubscribed, status !=11
			if (isset($ADR[0]) && $ADR[0]['aktiv']==1 && $ADR[0]['status']!=11)
				$valid_adr=TRUE;
			}//isset ADR && aktiv
			//but wait :)
			//we checked for valid h record before, so if we maybe now have a new adr id if none was set, we will check again if the adr id is still the same as the given a_id if we have a valid h record! hehe
			if ($valid_adr && $valid_h && $H[0]['adr_id']!=$a_id) {
				$valid_adr=FALSE;
			}
		}//a_id && personalized

		//check for a valid link id, if set, this link, if valid, will replace the internal fixed LINK1 
		if (check_dbid($l_id)) {
			$LINK=new tm_LNK();
			$LNK=$LINK->get($l_id);
			//link must be valid and active!
			if (isset($LNK[0]) && $LNK[0]['aktiv']==1) {
				$valid_lnk=TRUE;	
			}
		}//l-id

		//set status and count click of adr record
		if ($valid_adr) {
			//only set view status if not waiting status or unsubscribed // !5 && !11
			if ($ADR[0]['status']!=5 && $ADR[0]['status']!=11) {
				$ADDRESS->setStatus($a_id,4);	//view
			}
			//adr click counter ++
			$ADDRESS->addClick($a_id);	//click
			//save memo
			#$created=date("Y-m-d H:i:s");
			#$memo="clicked (".$NL[0]['subject'].") ".$NL[0]['link'];
			#$ADDRESS->addMemo($a_id,$memo);
		}//valid_adr
		
		//set ip and status on history
		if ($valid_h) {
			//nur der erste aufruf wird mit der ip versehen! ansonsten wuerde diese jedesmal ueberschrieben wenn der leser oder ein anderer das nl anschaut. i pwird seit 1088 auch in der linkclicktabelle gespeichert!
			if (empty($H[0]['ip']) || $H[0]['ip']=='0.0.0.0') {
				$QUEUE->setHIP($H[0]['id'], getIP());	//save ip
			}//ip
			if ($H[0]['status']!=7) { //7:unsubscribed
				$QUEUE->setHStatus($h_id,3);	//view
			}//status
		}//valid_h

		//create link from id if valid
		if ($valid_lnk) {
			//new url
			//count clicks
			$LINK->countClick($l_id);
			
			//if !personalized or no valid adr record : add anonymous click
			if (!$track_personalized || !$valid_adr || !$valid_h) {
				$LINK->addClick(Array("lnk_id"=>$l_id,"nl_id"=>$nl_id,"q_id"=>$q_id));//we always should have a valid nl id, this is good, q_id is also a good idea, its still anonymous tracking
			}

			//if personalized and valid adr record, add click with all params
			//it should be save to always pass all params to addClick, but we only want valid records, so ...			
			if ($track_personalized && $valid_adr && $valid_h) {//&& $valid_h ? hmmm, ok, strict
				$LINK->addClick(Array("lnk_id"=>$l_id,"nl_id"=>$nl_id,"q_id"=>$q_id,"adr_id"=>$a_id,"h_id"=>$h_id));
			}

			//parse variables in links....
			$var_search = array (
												"{F0}","{F1}","{F2}","{F3}","{F4}","{F5}","{F6}","{F7}","{F8}","{F9}",
												"{EMAIL}","{CODE}","{ADRID}"
												);

			if (!$personalized || !$valid_adr || !$valid_h) {
				//replace vars with empty values!
				$var_replace = array ("", "", "","","","","","","","","","","" );
				$URL = str_replace($var_search, $var_replace, $LNK[0]['url']);
			}
			
			if ($personalized && $valid_adr && $valid_h) {
				//replace vars!
				//personalize link! (only if adr record and id is valid and aktiv and only if nl is set to personalized tracking!!!)
				//replace vars, f0-f9, email, code, adrid
				$var_replace = array (
												$ADR[0]['f0'], $ADR[0]['f1'], $ADR[0]['f2'], $ADR[0]['f3'], $ADR[0]['f4'],
												$ADR[0]['f5'], $ADR[0]['f6'], $ADR[0]['f7'], $ADR[0]['f8'], $ADR[0]['f9'],
												$ADR[0]['email'],$ADR[0]['code'],$ADR[0]['id']
												);
				$URL = str_replace($var_search, $var_replace, $LNK[0]['url']);
			}//
			$valid_url=TRUE;
		}//valid_lnk
		
		//nl click counter ++
		$NEWSLETTER->addClick($nl_id);
}//valid nl

if (DEBUG) {
	if (!$valid_nl) {
		echo "invalid nl<br>";
	}
	if (!$valid_h) {
		echo "invalid h<br>";
	}
	if (!$valid_adr) {
		echo "invalid adr<br>";
	}
	if (!$valid_lnk) {
		echo "invalid lnk<br>";
	}
	if (!$valid_url) {
		echo "invalid url<br>";
	}
	echo $URL;
	echo "<hr>debug mode..., exit.";
	exit;
	
}
//finally send header...
if ($valid_nl && $valid_url) {
	header("Location: ".$URL.""); /* Browser umleiten */
	exit;
}

header("HTTP/1.0 404 Not Found");
exit;
?>