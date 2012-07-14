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


class mnlQ {  
	var $ADR=Array();
	var $GRP=Array();
	var $Q=Array();
  
	function getQ($id=0,$offset=0,$limit=0,$nl_id=0,$grp_id=0,$status=0) {
		global $mnl_siteid;
		$this->Q=Array();
		$DB=new ConnectDB();
		$Query ="
						SELECT ".mnlTABLE_NL_Q.".id, ".mnlTABLE_NL_Q.".nl_id, ".mnlTABLE_NL_Q.".grp_id, ".mnlTABLE_NL_Q.".created, ".mnlTABLE_NL_Q.".author, ".mnlTABLE_NL_Q.".status, ".mnlTABLE_NL_Q.".send_at, ".mnlTABLE_NL_Q.".sent
						FROM ".mnlTABLE_NL_Q."
					";
		$Query .=" WHERE ".mnlTABLE_NL_Q.".siteid='".$mnl_siteid."'
					";
		if (check_dbid($nl_id)) {
			$Query .=" AND ".mnlTABLE_NL_Q.".nl_id='".$nl_id."'	";
		}
		if (check_dbid($grp_id)) {
			$Query .=" AND ".mnlTABLE_NL_Q.".grp_id='".$grp_id."'	";
		}
		if ($status>0) {
			$Query .=" AND ".mnlTABLE_NL_Q.".status='".$status."'	";
		}
		if (check_dbid($id)) {
			$Query .=" AND ".mnlTABLE_NL_Q.".id='".$id."'	";
		}
		if ($limit >0 and $offset>=0) {
			$Query .= " LIMIT ".$offset." ,".$limit;
		}
		$Query .=" ORDER BY ".mnlTABLE_NL_Q.".created desc	";

		$DB->Query($Query);
		$ac=0;
		while ($DB->next_record()) {
			$this->Q[$ac]['id']=$DB->Record['id'];
			$this->Q[$ac]['created']=$DB->Record['created'];
			$this->Q[$ac]['author']=$DB->Record['author'];
			$this->Q[$ac]['status']=$DB->Record['status'];
			$this->Q[$ac]['send_at']=$DB->Record['send_at'];
			$this->Q[$ac]['sent']=$DB->Record['sent'];
			$this->Q[$ac]['nl_id']=$DB->Record['nl_id'];
			$this->Q[$ac]['grp_id']=$DB->Record['grp_id'];
			$ac++;
		} 
		return $this->Q;
	}//getQ

	function countQ($nl_id=0,$grp_id=0,$status=0) {
		global $mnl_siteid;
		$this->Q=Array();
		$DB=new ConnectDB();
		$Query ="
						SELECT count(id) as c
						FROM ".mnlTABLE_NL_Q."
					";
		$Query .=" WHERE siteid='".$mnl_siteid."'
					";
		if (check_dbid($nl_id)) {
			$Query .=" AND nl_id='".$nl_id."'	";
		}
		if (check_dbid($grp_id)) {
			$Query .=" AND grp_id='".$grp_id."'	";
		}
		if ($status>0) {
			$Query .=" AND status='".$status."'	";
		}
		$DB->Query($Query);
		$count=0;
		if ($DB->next_record()) {
			$count=$DB->Record['c'];
		} 
		return $count;
	}//countQ

	
	function getQtoSend($id=0,$offset=0,$limit=0,$nl_id=0,$grp_id=0) {
		global $mnl_siteid;
		$this->Q=Array();
		$DB=new ConnectDB();

		$send_at=date("Y-m-d H:i:s");
		
		$Query ="
						SELECT ".mnlTABLE_NL_Q.".id, ".mnlTABLE_NL_Q.".nl_id, ".mnlTABLE_NL_Q.".grp_id, ".mnlTABLE_NL_Q.".created, ".mnlTABLE_NL_Q.".author, ".mnlTABLE_NL_Q.".status, ".mnlTABLE_NL_Q.".send_at
						FROM ".mnlTABLE_NL_Q."
					";
		$Query .=" WHERE ".mnlTABLE_NL_Q.".siteid='".$mnl_siteid."'";

		$Query .=" AND (
							".mnlTABLE_NL_Q.".status=2 OR ".mnlTABLE_NL_Q.".status=3 OR ".mnlTABLE_NL_Q.".status=6 
							)
							";


		//terminierter versand!!!!
		$Query .=" AND ".mnlTABLE_NL_Q.".send_at <  '".$send_at."'";
				

		if (check_dbid($id)) {
			$Query .=" AND ".mnlTABLE_NL_Q.".id='".$id."'	";
		}
		if (check_dbid($nl_id)) {
			$Query .=" AND ".mnlTABLE_NL_Q.".nl_id='".$nl_id."'	";
		}
		if (check_dbid($grp_id)) {
			$Query .=" AND ".mnlTABLE_NL_Q.".grp_id='".$grp_id."'	";
		}


		$Query .=" ORDER BY ".mnlTABLE_NL_Q.".send_at asc,".mnlTABLE_NL_Q.".status asc	";
		
		if ($limit >0 and $offset>=0) {
			$Query .= " LIMIT ".$offset." ,".$limit;
		}
	
		$DB->Query($Query);
		$ac=0;
		while ($DB->next_record()) {
			$this->Q[$ac]['id']=$DB->Record['id'];
			$this->Q[$ac]['created']=$DB->Record['created'];
			$this->Q[$ac]['author']=$DB->Record['author'];
			$this->Q[$ac]['status']=$DB->Record['status'];
			$this->Q[$ac]['send_at']=$DB->Record['send_at'];
			$this->Q[$ac]['nl_id']=$DB->Record['nl_id'];
			$this->Q[$ac]['grp_id']=$DB->Record['grp_id'];
			$ac++;
		} 
		return $this->Q;
	}//getQtoSend


	function getQID($nl_id=0, $grp_id=0, $status=0) {
		global $mnl_siteid;
		$this->Q=Array();
		$DB=new ConnectDB();
		$Query ="
						SELECT ".mnlTABLE_NL_Q.".id
						FROM ".mnlTABLE_NL_Q."
					";
		$Query .=" WHERE ".mnlTABLE_NL_Q.".siteid='".$mnl_siteid."'
					";
		if (check_dbid($nl_id)) {
			$Query .=" AND ".mnlTABLE_NL_Q.".nl_id='".$nl_id."'	";
		}
		if (check_dbid($grp_id)) {
			$Query .=" AND ".mnlTABLE_NL_Q.".grp_id='".$grp_id."'	";
		}
		if ($status>0) {
			$Query .=" AND ".mnlTABLE_NL_Q.".status='".$status."'	";
		}

		$Query .=" ORDER BY ".mnlTABLE_NL_Q.".created desc ";

		$DB->Query($Query);
		$ac=0;
		while ($DB->next_record()) {
			$this->Q[$ac]=$DB->Record['id'];
			$ac++;
		} 
		return $this->Q;
	}//getQID


	function getH($id=0,$offset=0,$limit=0,$q_id=0,$nl_id=0,$grp_id=0,$adr_id=0,$status=0) {
		global $mnl_siteid;
		$this->H=Array();
		$DB=new ConnectDB();
		$Query ="
						SELECT ".mnlTABLE_NL_H.".id, ".mnlTABLE_NL_H.".q_id, ".mnlTABLE_NL_H.".nl_id, ".mnlTABLE_NL_H.".grp_id, ".mnlTABLE_NL_H.".adr_id, ".mnlTABLE_NL_H.".created, ".mnlTABLE_NL_H.".status, ".mnlTABLE_NL_H.".sent
						FROM ".mnlTABLE_NL_H."	";
		$Query .=" WHERE ".mnlTABLE_NL_H.".siteid='".$mnl_siteid."'
					";
		if (check_dbid($q_id)) {
			$Query .=" AND ".mnlTABLE_NL_H.".q_id='".$q_id."'	";
		}
		if (check_dbid($nl_id)) {
			$Query .=" AND ".mnlTABLE_NL_H.".nl_id='".$nl_id."'	";
		}
		if (check_dbid($grp_id)) {
			$Query .=" AND ".mnlTABLE_NL_H.".grp_id='".$grp_id."'	";
		}
		if (check_dbid($adr_id)) {
			$Query .=" AND ".mnlTABLE_NL_H.".adr_id='".$adr_id."'	";
		}
		if ($status>0) {
			$Query .=" AND ".mnlTABLE_NL_H.".status='".$status."'	";
		}
		if (check_dbid($id)) {
			$Query .=" AND ".mnlTABLE_NL_H.".id='".$id."'	";
		}
		if ($limit >0 and $offset>=0) {
			$Query .= " LIMIT ".$offset." ,".$limit;
		}
		$Query .=" ORDER BY ".mnlTABLE_NL_H.".created desc	";

		$DB->Query($Query);
		$ac=0;
		while ($DB->next_record()) {
			$this->H[$ac]['id']=$DB->Record['id'];
			$this->H[$ac]['created']=$DB->Record['created'];
			$this->H[$ac]['status']=$DB->Record['status'];
			$this->H[$ac]['q_id']=$DB->Record['q_id'];
			$this->H[$ac]['nl_id']=$DB->Record['nl_id'];
			$this->H[$ac]['grp_id']=$DB->Record['grp_id'];
			$this->H[$ac]['adr_id']=$DB->Record['adr_id'];
			$this->H[$ac]['sent']=$DB->Record['sent'];
			$ac++;
		} 
		return $this->H;
	}//getH



	function getHtoSend($id=0,$offset=0,$limit=0,$q_id=0,$nl_id=0,$grp_id=0,$adr_id=0) {
		//liefert nur zu sendende eintarege zurueck!!! status==1 !!!
		global $mnl_siteid;
		$this->H=Array();
		$DB=new ConnectDB();
		$Query ="
						SELECT ".mnlTABLE_NL_H.".id, ".mnlTABLE_NL_H.".q_id, ".mnlTABLE_NL_H.".nl_id, ".mnlTABLE_NL_H.".grp_id, ".mnlTABLE_NL_H.".adr_id, ".mnlTABLE_NL_H.".created, ".mnlTABLE_NL_H.".status, ".mnlTABLE_NL_H.".sent
						FROM ".mnlTABLE_NL_H."
					";
		$Query .=" WHERE ".mnlTABLE_NL_H.".siteid='".$mnl_siteid."'";
		//!!!!
		$Query .=" AND ".mnlTABLE_NL_H.".status=1 ";


		if (check_dbid($q_id)) {
			$Query .=" AND ".mnlTABLE_NL_H.".q_id='".$q_id."' ";
		}
		if (check_dbid($nl_id)) {
			$Query .=" AND ".mnlTABLE_NL_H.".nl_id='".$nl_id."' ";
		}
		if (check_dbid($grp_id)) {
			$Query .=" AND ".mnlTABLE_NL_H.".grp_id='".$grp_id."' ";
		}
		if (check_dbid($adr_id)) {
			$Query .=" AND ".mnlTABLE_NL_H.".adr_id='".$adr_id."' ";
		}


		if (check_dbid($id)) {
			$Query .=" AND ".mnlTABLE_NL_H.".id='".$id."' ";
		}
		$Query .=" ORDER BY ".mnlTABLE_NL_H.".created asc, status asc";
		
		if ($limit >0 and $offset>=0) {
			$Query .= " LIMIT ".$offset." ,".$limit;
		}


		$DB->Query($Query);
		$ac=0;
		while ($DB->next_record()) {
			$this->H[$ac]['id']=$DB->Record['id'];
			$this->H[$ac]['created']=$DB->Record['created'];
			$this->H[$ac]['status']=$DB->Record['status'];
			$this->H[$ac]['q_id']=$DB->Record['q_id'];
			$this->H[$ac]['nl_id']=$DB->Record['nl_id'];
			$this->H[$ac]['grp_id']=$DB->Record['grp_id'];
			$this->H[$ac]['adr_id']=$DB->Record['adr_id'];
			$this->H[$ac]['sent']=$DB->Record['sent'];
			$ac++;
		} 
		return $this->H;
	}//getHtoSend

	function countH($q_id=0,$nl_id=0,$grp_id=0,$adr_id=0,$status=0) {
		global $mnl_siteid;
		$count=0;
		$DB=new ConnectDB();
		$Query ="
						SELECT count(".mnlTABLE_NL_H.".id) as c
						FROM ".mnlTABLE_NL_H."
					";
		$Query .=" WHERE ".mnlTABLE_NL_H.".siteid='".$mnl_siteid."'
					";
		if (check_dbid($q_id)) {
			$Query .=" AND ".mnlTABLE_NL_H.".q_id='".$q_id."'	";
		}
		if (check_dbid($nl_id)) {
			$Query .=" AND ".mnlTABLE_NL_H.".nl_id='".$nl_id."'	";
		}
		if (check_dbid($grp_id)) {
			$Query .=" AND ".mnlTABLE_NL_H.".grp_id='".$grp_id."'	";
		}
		if (check_dbid($adr_id)) {
			$Query .=" AND ".mnlTABLE_NL_H.".adr_id='".$adr_id."'	";
		}
		if ($status>0) {
			$Query .=" AND ".mnlTABLE_NL_H.".status='".$status."'	";
		}
		$Query .=" ORDER BY ".mnlTABLE_NL_H.".created desc	";

		$DB->Query($Query);
		if ($DB->next_record()) {
			$count=$DB->Record['c'];
		} 
		return $count;
	}//getH


	function delQ($id) {
		global $mnl_siteid;
		$Return=false;
		if (check_dbid($id)) {
			$DB=new ConnectDB();
			//q loeschen
			$Query ="DELETE FROM ".mnlTABLE_NL_Q." WHERE siteid='".$mnl_siteid."' AND id='".$id."'";
				if ($DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
			//versandliste, history h loeschen
			/*
			//historie loeschen? .....hmmmmm , nein, nur wenn nl oder adresse
			$Query ="DELETE FROM ".mnlTABLE_NL_H." WHERE siteid='".$mnl_siteid."' AND q_id='".$id."'";
				if ($DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
			*/
			//stattdessen markieren wir einen abbruch!
			$Query ="UPDATE ".mnlTABLE_NL_H." 
						SET status=6 
						WHERE siteid='".$mnl_siteid."' 
						AND q_id='".$id."'
						AND ( status=1 or status=5 )
						";
				if ($DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
		}
		return $Return;
	}//delAdr
	
	function addQ($q,$grp) {
		global $mnl_siteid;
		$Return=false;
		$DB=new ConnectDB();
		//neue Q speichern fuer jede gewaehlte Gruppe

		$gc=count($grp);
		for ($gcc=0;$gcc<$gc;$gcc++) {
			if (check_dbid($q['nl_id'])) {
				$Query ="INSERT INTO ".mnlTABLE_NL_Q." (nl_id,grp_id,status,send_at,author,created,siteid)
							VALUES ('".$q["nl_id"]."', '".$grp[$gcc]."', 
										'".$q["status"]."', '".$q["send_at"]."', '".$q["author"]."', '".$q["created"]."', '".$mnl_siteid."'
										)";
				if ($DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;			
				}
			}
		}
		return $Return;			
	}//addQ
	
	function addH($h) {
		global $mnl_siteid;
		$Return=false;
		if (check_dbid($h['q_id']) && check_dbid($h['nl_id']) && check_dbid($h['grp_id']) &&	check_dbid($h['adr_id'])	) {
			$DB=new ConnectDB();
			//neue History, Versandliste
			$Query ="INSERT INTO ".mnlTABLE_NL_H." (q_id,nl_id,grp_id,adr_id,status,created,sent,siteid)
						VALUES ( '".$h["q_id"]."',
									'".$h["nl_id"]."',
									'".$h["grp_id"]."',
									'".$h["adr_id"]."',
									'".$h["status"]."',
									'".$h["created"]."',
									'',
									'".$mnl_siteid."'
										)";
			if ($DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;			
	}//addH
	
	function setHStatus($id,$status) {
		global $mnl_siteid;
		$Return=false;
		if (check_dbid($id)) {
			$DB=new ConnectDB();
			$Query ="UPDATE ".mnlTABLE_NL_H." SET status='".$status."'
						 WHERE siteid='".$mnl_siteid."' AND id='".$id."'";
			if ($DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}
	
	function setHSentDate($id,$created) {
		global $mnl_siteid;
		$Return=false;
		if (check_dbid($id)) {
			$DB=new ConnectDB();
			$Query ="UPDATE ".mnlTABLE_NL_H." SET sent='".$created."'
						 WHERE siteid='".$mnl_siteid."' AND id='".$id."'";
			if ($DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}
	
	function setStatus($id,$status) {
		global $mnl_siteid;
		$Return=false;
		if (check_dbid($id)) {
			$DB=new ConnectDB();
			$Query ="UPDATE ".mnlTABLE_NL_Q." SET status='".$status."'
						 WHERE siteid='".$mnl_siteid."' AND id='".$id."'";
			if ($DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}

	function setSentDate($id,$date) {
		global $mnl_siteid;
		$Return=false;
		if (check_dbid($id)) {
			$DB=new ConnectDB();
			$Query ="UPDATE ".mnlTABLE_NL_Q." SET sent='".$date."'
						 WHERE siteid='".$mnl_siteid."' AND id='".$id."'";
			if ($DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}
	
}  //class

?>