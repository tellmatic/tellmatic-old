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


class tm_Q {
	var $ADR=Array();
	var $GRP=Array();
	var $Q=Array();
  var $DB;
  #var $DB2;//2nd connection, e.g. needed to count adr from within getgroup()!

  function tm_Q() {
		$this->DB=new tm_DB();
		#$this->DB2=new tm_DB();
		//wichtig! hier darf kein fehler passieren indem man db un db2 verwechselt! sonst stimmen die ergebnisse nicht mehr!!!!
  }

	function getQ($id=0,$offset=0,$limit=0,$nl_id=0,$grp_id=0,$status=0) {
		$this->Q=Array();
		$Query ="SELECT ".TM_TABLE_NL_Q.".id, "
											.TM_TABLE_NL_Q.".nl_id, "
											.TM_TABLE_NL_Q.".grp_id, "
											.TM_TABLE_NL_Q.".created, "
											.TM_TABLE_NL_Q.".author, "
											.TM_TABLE_NL_Q.".status, "
											.TM_TABLE_NL_Q.".send_at, "
											.TM_TABLE_NL_Q.".sent
						FROM ".TM_TABLE_NL_Q."
					";
		$Query .=" WHERE ".TM_TABLE_NL_Q.".siteid='".TM_SITEID."'";
		if (check_dbid($nl_id)) {
			$Query .=" AND ".TM_TABLE_NL_Q.".nl_id='".$nl_id."'	";
		}
		if (check_dbid($grp_id)) {
			$Query .=" AND ".TM_TABLE_NL_Q.".grp_id='".$grp_id."'	";
		}
		if ($status>0) {
			$Query .=" AND ".TM_TABLE_NL_Q.".status='".dbesc($status)."'	";
		}
		if (check_dbid($id)) {
			$Query .=" AND ".TM_TABLE_NL_Q.".id='".$id."'	";
		}
		if ($limit >0 and $offset>=0) {
			$Query .= " LIMIT ".dbesc($offset)." ,".dbesc($limit);
		}
		$Query .=" ORDER BY ".TM_TABLE_NL_Q.".created desc	";

		$this->DB->Query($Query);
		$ac=0;
		while ($this->DB->next_record()) {
			$this->Q[$ac]['id']=$this->DB->Record['id'];
			$this->Q[$ac]['created']=$this->DB->Record['created'];
			$this->Q[$ac]['author']=$this->DB->Record['author'];
			$this->Q[$ac]['status']=$this->DB->Record['status'];
			$this->Q[$ac]['send_at']=$this->DB->Record['send_at'];
			$this->Q[$ac]['sent']=$this->DB->Record['sent'];
			$this->Q[$ac]['nl_id']=$this->DB->Record['nl_id'];
			$this->Q[$ac]['grp_id']=$this->DB->Record['grp_id'];
			$ac++;
		}
		return $this->Q;
	}//getQ

	function countQ($nl_id=0,$grp_id=0,$status=0) {
		$this->Q=Array();
		$Query ="SELECT count(id) as c
						FROM ".TM_TABLE_NL_Q;
		$Query .=" WHERE siteid='".TM_SITEID."'";
		if (check_dbid($nl_id)) {
			$Query .=" AND nl_id='".$nl_id."'	";
		}
		if (check_dbid($grp_id)) {
			$Query .=" AND grp_id='".$grp_id."'	";
		}
		if ($status>0) {
			$Query .=" AND status='".dbesc($status)."'	";
		}
		$this->DB->Query($Query);
		$count=0;
		if ($this->DB->next_record()) {
			$count=$this->DB->Record['c'];
		}
		return $count;
	}//countQ


	function getQtoSend($id=0,$offset=0,$limit=0,$nl_id=0,$grp_id=0) {
		$this->Q=Array();
		$send_at=date("Y-m-d H:i:s");

		$Query ="SELECT ".TM_TABLE_NL_Q.".id, "
											.TM_TABLE_NL_Q.".nl_id, "
											.TM_TABLE_NL_Q.".grp_id, "
											.TM_TABLE_NL_Q.".created, "
											.TM_TABLE_NL_Q.".author, "
											.TM_TABLE_NL_Q.".status, "
											.TM_TABLE_NL_Q.".send_at
						FROM ".TM_TABLE_NL_Q."
					";
		$Query .=" WHERE ".TM_TABLE_NL_Q.".siteid='".TM_SITEID."'";

		$Query .=" AND (
							".TM_TABLE_NL_Q.".status=2 OR ".TM_TABLE_NL_Q.".status=3 OR ".TM_TABLE_NL_Q.".status=6
							)
							";

		//terminierter versand!!!!
		$Query .=" AND ".TM_TABLE_NL_Q.".send_at <  '".dbesc($send_at)."'";


		if (check_dbid($id)) {
			$Query .=" AND ".TM_TABLE_NL_Q.".id='".$id."'	";
		}
		if (check_dbid($nl_id)) {
			$Query .=" AND ".TM_TABLE_NL_Q.".nl_id='".$nl_id."'	";
		}
		if (check_dbid($grp_id)) {
			$Query .=" AND ".TM_TABLE_NL_Q.".grp_id='".$grp_id."'	";
		}

		$Query .=" ORDER BY ".TM_TABLE_NL_Q.".send_at asc,".TM_TABLE_NL_Q.".status asc	";

		if ($limit >0 and $offset>=0) {
			$Query .= " LIMIT ".dbesc($offset)." ,".dbesc($limit);
		}

		$this->DB->Query($Query);
		$qc=0;
		while ($this->DB->next_record()) {
			$this->Q[$qc]['id']=$this->DB->Record['id'];
			$this->Q[$qc]['created']=$this->DB->Record['created'];
			$this->Q[$qc]['author']=$this->DB->Record['author'];
			$this->Q[$qc]['status']=$this->DB->Record['status'];
			$this->Q[$qc]['send_at']=$this->DB->Record['send_at'];
			$this->Q[$qc]['nl_id']=$this->DB->Record['nl_id'];
			$this->Q[$qc]['grp_id']=$this->DB->Record['grp_id'];
			$qc++;
		}
		return $this->Q;
	}//getQtoSend


	function getQID($nl_id=0, $grp_id=0, $status=0) {
		$this->Q=Array();
		$Query ="SELECT ".TM_TABLE_NL_Q.".id
						FROM ".TM_TABLE_NL_Q;
		$Query .=" WHERE ".TM_TABLE_NL_Q.".siteid='".TM_SITEID."'";
		if (check_dbid($nl_id)) {
			$Query .=" AND ".TM_TABLE_NL_Q.".nl_id='".$nl_id."'	";
		}
		if (check_dbid($grp_id)) {
			$Query .=" AND ".TM_TABLE_NL_Q.".grp_id='".$grp_id."'	";
		}
		if ($status>0) {
			$Query .=" AND ".TM_TABLE_NL_Q.".status='".dbesc($status)."'	";
		}

		$Query .=" ORDER BY ".TM_TABLE_NL_Q.".created desc ";

		$this->DB->Query($Query);
		$ac=0;
		while ($this->DB->next_record()) {
			$this->Q[$ac]=$this->DB->Record['id'];
			$ac++;
		}
		return $this->Q;
	}//getQID


	function getH($id=0,$offset=0,$limit=0,$q_id=0,$nl_id=0,$grp_id=0,$adr_id=0,$status=0) {
		$this->H=Array();
		$Query ="SELECT ".TM_TABLE_NL_H.".id, "
											.TM_TABLE_NL_H.".q_id, "
											.TM_TABLE_NL_H.".nl_id, "
											.TM_TABLE_NL_H.".grp_id, "
											.TM_TABLE_NL_H.".adr_id, "
											.TM_TABLE_NL_H.".created, "
											.TM_TABLE_NL_H.".status, "
											.TM_TABLE_NL_H.".sent
						FROM ".TM_TABLE_NL_H."	";
		$Query .=" WHERE ".TM_TABLE_NL_H.".siteid='".TM_SITEID."'";
		if (check_dbid($q_id)) {
			$Query .=" AND ".TM_TABLE_NL_H.".q_id='".$q_id."'	";
		}
		if (check_dbid($nl_id)) {
			$Query .=" AND ".TM_TABLE_NL_H.".nl_id='".$nl_id."'	";
		}
		if (check_dbid($grp_id)) {
			$Query .=" AND ".TM_TABLE_NL_H.".grp_id='".$grp_id."'	";
		}
		if (check_dbid($adr_id)) {
			$Query .=" AND ".TM_TABLE_NL_H.".adr_id='".$adr_id."'	";
		}
		if ($status>0) {
			$Query .=" AND ".TM_TABLE_NL_H.".status='".dbesc($status)."'	";
		}
		if (check_dbid($id)) {
			$Query .=" AND ".TM_TABLE_NL_H.".id='".$id."'	";
		}
		if ($limit >0 and $offset>=0) {
			$Query .= " LIMIT ".dbesc($offset)." ,".dbesc($limit);
		}
		$Query .=" ORDER BY ".TM_TABLE_NL_H.".created desc	";

		$this->DB->Query($Query);
		$hc=0;
		while ($this->DB->next_record()) {
			$this->H[$hc]['id']=$this->DB->Record['id'];
			$this->H[$hc]['created']=$this->DB->Record['created'];
			$this->H[$hc]['status']=$this->DB->Record['status'];
			$this->H[$hc]['q_id']=$this->DB->Record['q_id'];
			$this->H[$hc]['nl_id']=$this->DB->Record['nl_id'];
			$this->H[$hc]['grp_id']=$this->DB->Record['grp_id'];
			$this->H[$hc]['adr_id']=$this->DB->Record['adr_id'];
			$this->H[$hc]['sent']=$this->DB->Record['sent'];
			$hc++;
		}
		return $this->H;
	}//getH



	function getHtoSend($id=0,$offset=0,$limit=0,$q_id=0,$nl_id=0,$grp_id=0,$adr_id=0) {
		//liefert nur zu sendende eintarege zurueck!!! status==1 !!!
		$this->H=Array();
		$Query ="SELECT ".TM_TABLE_NL_H.".id, "
											.TM_TABLE_NL_H.".q_id, "
											.TM_TABLE_NL_H.".nl_id, "
											.TM_TABLE_NL_H.".grp_id, "
											.TM_TABLE_NL_H.".adr_id, "
											.TM_TABLE_NL_H.".created, "
											.TM_TABLE_NL_H.".status, "
											.TM_TABLE_NL_H.".sent
						FROM ".TM_TABLE_NL_H."
					";
		$Query .=" WHERE ".TM_TABLE_NL_H.".siteid='".TM_SITEID."'";
		//!!!!
		$Query .=" AND ".TM_TABLE_NL_H.".status=1 ";

		if (check_dbid($q_id)) {
			$Query .=" AND ".TM_TABLE_NL_H.".q_id='".$q_id."' ";
		}
		if (check_dbid($nl_id)) {
			$Query .=" AND ".TM_TABLE_NL_H.".nl_id='".$nl_id."' ";
		}
		if (check_dbid($grp_id)) {
			$Query .=" AND ".TM_TABLE_NL_H.".grp_id='".$grp_id."' ";
		}
		if (check_dbid($adr_id)) {
			$Query .=" AND ".TM_TABLE_NL_H.".adr_id='".$adr_id."' ";
		}

		if (check_dbid($id)) {
			$Query .=" AND ".TM_TABLE_NL_H.".id='".$id."' ";
		}
		$Query .=" ORDER BY ".TM_TABLE_NL_H.".created asc, status asc";

		if ($limit >0 and $offset>=0) {
			$Query .= " LIMIT ".dbesc($offset)." ,".dbesc($limit);
		}


		$this->DB->Query($Query);
		$ac=0;
		while ($this->DB->next_record()) {
			$this->H[$ac]['id']=$this->DB->Record['id'];
			$this->H[$ac]['created']=$this->DB->Record['created'];
			$this->H[$ac]['status']=$this->DB->Record['status'];
			$this->H[$ac]['q_id']=$this->DB->Record['q_id'];
			$this->H[$ac]['nl_id']=$this->DB->Record['nl_id'];
			$this->H[$ac]['grp_id']=$this->DB->Record['grp_id'];
			$this->H[$ac]['adr_id']=$this->DB->Record['adr_id'];
			$this->H[$ac]['sent']=$this->DB->Record['sent'];
			$ac++;
		}
		return $this->H;
	}//getHtoSend

	function countH($q_id=0,$nl_id=0,$grp_id=0,$adr_id=0,$status=0) {
		$count=0;
		$Query ="
						SELECT count(".TM_TABLE_NL_H.".id) as c
						FROM ".TM_TABLE_NL_H."
					";
		$Query .=" WHERE ".TM_TABLE_NL_H.".siteid='".TM_SITEID."'
					";
		if (check_dbid($q_id)) {
			$Query .=" AND ".TM_TABLE_NL_H.".q_id='".$q_id."'	";
		}
		if (check_dbid($nl_id)) {
			$Query .=" AND ".TM_TABLE_NL_H.".nl_id='".$nl_id."'	";
		}
		if (check_dbid($grp_id)) {
			$Query .=" AND ".TM_TABLE_NL_H.".grp_id='".$grp_id."'	";
		}
		if (check_dbid($adr_id)) {
			$Query .=" AND ".TM_TABLE_NL_H.".adr_id='".$adr_id."'	";
		}
		if ($status>0) {
			$Query .=" AND ".TM_TABLE_NL_H.".status='".dbesc($status)."'	";
		}
		$Query .=" ORDER BY ".TM_TABLE_NL_H.".created desc	";

		$this->DB->Query($Query);
		if ($this->DB->next_record()) {
			$count=$this->DB->Record['c'];
		}
		return $count;
	}//getH


	function delQ($id) {
		$Return=false;
		if (check_dbid($id)) {
			//q loeschen
			$Query ="DELETE FROM ".TM_TABLE_NL_Q
							." WHERE siteid='".TM_SITEID."' AND id='".$id."'";
				if ($this->DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
			//versandliste, history h loeschen
			//historie loeschen? .....hmmmmm , nein, nur wenn nl oder adresse
			//stattdessen markieren wir einen abbruch!
			$Query ="UPDATE ".TM_TABLE_NL_H."
								SET status=6
								WHERE siteid='".TM_SITEID."'
								AND q_id='".$id."'
								AND ( status=1 or status=5 )
						";
				if ($this->DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
		}
		return $Return;
	}//delQ

	function addQ($q,$grp) {
		$Return=false;
		//neue Q speichern fuer jede gewaehlte Gruppe
		$gc=count($grp);
		for ($gcc=0;$gcc<$gc;$gcc++) {
			if (check_dbid($q['nl_id'])) {
				$Query ="INSERT INTO ".TM_TABLE_NL_Q." (nl_id,grp_id,status,send_at,author,created,siteid)
									VALUES ('".$q["nl_id"]."', '"
													.dbesc($grp[$gcc])."', '"
													.dbesc($q["status"])."', '"
													.dbesc($q["send_at"])."', '"
													.dbesc($q["author"])."', '"
													.dbesc($q["created"])."', '"
													.TM_SITEID."'
										)";
				if ($this->DB->Query($Query)) {
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
		$Return=false;
		if (check_dbid($h['q_id']) && check_dbid($h['nl_id']) && check_dbid($h['grp_id']) &&	check_dbid($h['adr_id'])	) {
			//neue History, Versandliste
			$Query ="INSERT INTO ".TM_TABLE_NL_H." (q_id,nl_id,grp_id,adr_id,status,created,sent,siteid)
						VALUES ( '".$h["q_id"]."',
									'".$h["nl_id"]."',
									'".$h["grp_id"]."',
									'".$h["adr_id"]."',
									'".dbesc($h["status"])."',
									'".dbesc($h["created"])."',
									'',
									'".TM_SITEID."'
										)";
			if ($this->DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//addH

	function setHStatus($id,$status) {
		$Return=false;
		if (check_dbid($id)) {
			$Query ="UPDATE ".TM_TABLE_NL_H." SET status='".dbesc($status)."'
						 WHERE siteid='".TM_SITEID."' AND id='".$id."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}

	function setHSentDate($id,$created) {
		$Return=false;
		if (check_dbid($id)) {
			$Query ="UPDATE ".TM_TABLE_NL_H." SET sent='".dbesc($created)."'
						 WHERE siteid='".TM_SITEID."' AND id='".$id."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}

	function setHIP($id,$ip) {
		$Return=false;
		if (check_dbid($id)) {
			$Query ="UPDATE ".TM_TABLE_NL_H." SET ip='".dbesc($ip)."'
						 WHERE siteid='".TM_SITEID."' AND id='".$id."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}

	function setStatus($id,$status) {
		$Return=false;
		if (check_dbid($id)) {
			$Query ="UPDATE ".TM_TABLE_NL_Q." SET status='".dbesc($status)."'
						 WHERE siteid='".TM_SITEID."' AND id='".$id."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}

	function setSentDate($id,$date) {
		$Return=false;
		if (check_dbid($id)) {
			$Query ="UPDATE ".TM_TABLE_NL_Q." SET sent='".dbesc($date)."'
						 WHERE siteid='".TM_SITEID."' AND id='".$id."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}

	function makeMap(&$img,&$gi,$q_id,$width,$height) {
		$Query ="SELECT ip FROM ".TM_TABLE_NL_H."
					WHERE siteid='".TM_SITEID."'";
		$Query .=" AND ip!='0.0.0.0' AND ip!=''";
		if (check_dbid($q_id)) {
			$Query .=" AND q_id='".$q_id."'";
		}
		if ($this->DB->Query($Query)) {
			$Color1 = imagecolorallocate ($img, 255,255,0);
			$Color2 = imagecolorallocate ($img, 255,0,0);
			while ($this->DB->next_Record()) {
				$geoip = geoip_record_by_addr($gi,$this->DB->Record['ip']);
				if (isset($geoip->latitude, $geoip->longitude)) {
					$pt = getlocationcoords($geoip->latitude, $geoip->longitude, $width, $height);
					imagefilledrectangle($img,$pt["x"]-1,$pt["y"]-1,$pt["x"]+1,$pt["y"]+1,$Color1);
					imagerectangle($img,$pt["x"]-2,$pt["y"]-2,$pt["x"]+2,$pt["y"]+2,$Color2);
				}
				#imagesetpixel($img,$pt["x"],$pt["y"],$Color1);
			}//while
		}//if query
	}//makeMap

	function makeMapWeight(&$img,&$gi,$q_id,$width,$height) {
		$Query ="SELECT ip FROM ".TM_TABLE_NL_H."
					WHERE siteid='".TM_SITEID."'";
		$Query .=" AND ip!='0.0.0.0' AND ip!=''";
		if (check_dbid($q_id)) {
			$Query .=" AND q_id='".$q_id."'";
		}
		#$Query .=" Limit 10000";
		if ($this->DB->Query($Query)) {
			$max=0;
			$sum=0;
			$K[0][0]=0;
			while ($this->DB->next_Record()) {
				$geoip = geoip_record_by_addr($gi,$this->DB->Record['ip']);
				if (isset($geoip->latitude, $geoip->longitude)) {
					$pt = getlocationcoords($geoip->latitude, $geoip->longitude, $width, $height);
					if (isset($K[$pt['x']][$pt['y']])) {
						$K[$pt['x']][$pt['y']]++;
						if ($K[$pt['x']][$pt['y']] > $max) $max=$K[$pt['x']][$pt['y']];
					} else {
						$K[$pt['x']][$pt['y']]=1;
					}
					$sum ++;
				}
			}//while
			$one_pc=$sum/100;
			$Color1 = imagecolorallocatealpha ($img, 255,0,0,0);
			foreach ($K as $x => $ya) {
				foreach ($ya as $y => $c) {
					$d=round($c/$one_pc);
					$r=$d*5;
					imagearc ( $img, $x, $y, $r, $r, 0, 360, $Color1 );
				}
			}
		}//if query
	}//makeMap

	function makeRandomIP($limit) {
		$DB2=new tm_DB();
		$Query ="SELECT id FROM ".TM_TABLE_NL_H."
					WHERE siteid='".TM_SITEID."'";
		$Query .=" AND ip='0.0.0.0' LIMIT ".$limit;
		if ($this->DB->Query($Query)) {
			while ($this->DB->next_Record()) {
				srand((double)microtime()*30000);
				$newip=rand(1,254).".".rand(1,254).".".rand(1,240).".".rand(1,254);
				$Query2="update ".TM_TABLE_NL_H."  set ip='".$newip."' where id='".$this->DB->Record['id']."'";
				$DB2->Query($Query2);
			}//while
		}//if query
	}//makeRandomIP

}  //class

?>