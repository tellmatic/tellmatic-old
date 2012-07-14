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

class tm_ADR {
	var $ADR=Array();
	var $GRP=Array();

  var $DB;
  var $DB2;//2nd connection, e.g. needed to count adr from within getgroup()!

  function tm_ADR() {
		$this->DB=new tm_DB();
		$this->DB2=new tm_DB();
  }

	function getAdr($id=0,$offset=0,$limit=0,$group_id=0,$search=Array(),$sortIndex="",$sortType=0,$Details=1) {
		$this->ADR=Array();
		#$DB=new tm_DB();
		$Query ="SELECT ".TM_TABLE_ADR.".id, "
										."lcase(".TM_TABLE_ADR.".email) as email, "
										.TM_TABLE_ADR.".aktiv, "
										.TM_TABLE_ADR.".created, "
										.TM_TABLE_ADR.".updated, "
										.TM_TABLE_ADR.".author, "
										.TM_TABLE_ADR.".editor, "
										.TM_TABLE_ADR.".status, "
										.TM_TABLE_ADR.".errors, "
										.TM_TABLE_ADR.".code, "
										.TM_TABLE_ADR.".clicks, "
										.TM_TABLE_ADR.".views, "
										.TM_TABLE_ADR.".newsletter";
			$Query .=", ".TM_TABLE_ADR_DETAILS.".id as d_id,"
								.TM_TABLE_ADR_DETAILS.".memo";

		if ($Details==1) {
			$Query .=", ".TM_TABLE_ADR_DETAILS.".id as d_id,"
								.TM_TABLE_ADR_DETAILS.".memo, "
								.TM_TABLE_ADR_DETAILS.".f0, "
								.TM_TABLE_ADR_DETAILS.".f1, "
								.TM_TABLE_ADR_DETAILS.".f2, "
								.TM_TABLE_ADR_DETAILS.".f3, "
								.TM_TABLE_ADR_DETAILS.".f4, "
								.TM_TABLE_ADR_DETAILS.".f5, "
								.TM_TABLE_ADR_DETAILS.".f6, "
								.TM_TABLE_ADR_DETAILS.".f7, "
								.TM_TABLE_ADR_DETAILS.".f8, "
								.TM_TABLE_ADR_DETAILS.".f9";
		}

		$Query .=" FROM ".TM_TABLE_ADR;
			$Query .=" LEFT JOIN ".TM_TABLE_ADR_DETAILS." ON ".TM_TABLE_ADR.".id = ".TM_TABLE_ADR_DETAILS.".adr_id";

		if (isset($search['group']) && !empty($search['group'])) {
			$group_id=$search['group'];
		}
		if (check_dbid($group_id)) {
			$Query .=" LEFT JOIN ".TM_TABLE_ADR_GRP_REF." ON ".TM_TABLE_ADR.".id = ".TM_TABLE_ADR_GRP_REF.".adr_id";
		}

		$Query .=" WHERE ".TM_TABLE_ADR.".siteid='".TM_SITEID."'";

		if (check_dbid($group_id)) {
			$Query .=" AND ".TM_TABLE_ADR_GRP_REF.".siteid='".TM_SITEID."'
						  AND ".TM_TABLE_ADR_GRP_REF.".grp_id='".dbesc($group_id)."'";
		}

		if (isset($search['email']) && !empty($search['email'])) {
			if (isset($search['email_exact_match']) && $search['email_exact_match']===true) {
				$Query .= " AND ".TM_TABLE_ADR.".email = lcase('".dbesc($search['email'])."')";
			} else {
				$Query .= " AND ".TM_TABLE_ADR.".email like lcase('".dbesc($search['email'])."')";
			}
		}
		if (isset($search['author']) && !empty($search['author'])) {
			$Query .= " AND ".TM_TABLE_ADR.".author like '".dbesc($search['author'])."'";
		}
		if (isset($search['status']) && !empty($search['status'])) {
			$Query .= " AND ".TM_TABLE_ADR.".status = '".dbesc($search['status'])."'";
		}
		if (isset($search['code']) && !empty($search['code'])) {
			$Query .= " AND ".TM_TABLE_ADR.".code = '".dbesc($search['code'])."'";
		}

		if ($Details==1 && isset($search['f0_9']) && !empty($search['f0_9'])) {
			$Query .= " AND (
							".TM_TABLE_ADR_DETAILS.".f0 like '".dbesc($search['f0_9'])."'
							OR ".TM_TABLE_ADR_DETAILS.".f1 like '".dbesc($search['f0_9'])."'
							OR ".TM_TABLE_ADR_DETAILS.".f2 like '".dbesc($search['f0_9'])."'
							OR ".TM_TABLE_ADR_DETAILS.".f3 like '".dbesc($search['f0_9'])."'
							OR ".TM_TABLE_ADR_DETAILS.".f4 like '".dbesc($search['f0_9'])."'
							OR ".TM_TABLE_ADR_DETAILS.".f5 like '".dbesc($search['f0_9'])."'
							OR ".TM_TABLE_ADR_DETAILS.".f6 like '".dbesc($search['f0_9'])."'
							OR ".TM_TABLE_ADR_DETAILS.".f7 like '".dbesc($search['f0_9'])."'
							OR ".TM_TABLE_ADR_DETAILS.".f8 like '".dbesc($search['f0_9'])."'
							OR ".TM_TABLE_ADR_DETAILS.".f9 like '".dbesc($search['f0_9'])."'
							)";
		}//if

		if (check_dbid($id)) {
			$Query .= " AND ".TM_TABLE_ADR.".id='".$id."'";
		}

		if (!empty($sortIndex)) {
			$Query .= " ORDER BY ".dbesc($sortIndex);
			if ($sortType==0) {
				$Query .= " ASC";
			}
			if ($sortType==1) {
				$Query .= " DESC";
			}
		}

		if ($limit >0 and $offset>=0) {
			$Query .= " LIMIT ".dbesc($offset)." ,".dbesc($limit);
		}
		$this->DB->Query($Query);
		$ac=0;
		while ($this->DB->next_record()) {
			$this->ADR[$ac]['id']=$this->DB->Record['id'];
			$this->ADR[$ac]['email']=$this->DB->Record['email'];
			$this->ADR[$ac]['aktiv']=$this->DB->Record['aktiv'];
			$this->ADR[$ac]['created']=$this->DB->Record['created'];
			$this->ADR[$ac]['updated']=$this->DB->Record['updated'];
			$this->ADR[$ac]['author']=$this->DB->Record['author'];
			$this->ADR[$ac]['editor']=$this->DB->Record['editor'];
			$this->ADR[$ac]['status']=$this->DB->Record['status'];
			$this->ADR[$ac]['clicks']=$this->DB->Record['clicks'];
			$this->ADR[$ac]['views']=$this->DB->Record['views'];
			$this->ADR[$ac]['newsletter']=$this->DB->Record['newsletter'];
			$this->ADR[$ac]['errors']=$this->DB->Record['errors'];
			$this->ADR[$ac]['code']=$this->DB->Record['code'];
			$this->ADR[$ac]['memo']=$this->DB->Record['memo'];
			$this->ADR[$ac]['d_id']=$this->DB->Record['d_id'];
			if ($Details==1) {
				#$this->ADR[$ac]['memo']=$this->DB->Record['memo'];
				#$this->ADR[$ac]['d_id']=$this->DB->Record['d_id'];
				$this->ADR[$ac]['f0']=$this->DB->Record['f0'];
				$this->ADR[$ac]['f1']=$this->DB->Record['f1'];
				$this->ADR[$ac]['f2']=$this->DB->Record['f2'];
				$this->ADR[$ac]['f3']=$this->DB->Record['f3'];
				$this->ADR[$ac]['f4']=$this->DB->Record['f4'];
				$this->ADR[$ac]['f5']=$this->DB->Record['f5'];
				$this->ADR[$ac]['f6']=$this->DB->Record['f6'];
				$this->ADR[$ac]['f7']=$this->DB->Record['f7'];
				$this->ADR[$ac]['f8']=$this->DB->Record['f8'];
				$this->ADR[$ac]['f9']=$this->DB->Record['f9'];
			}
			$ac++;
		}
		return $this->ADR;
	}//getAdr

	function getAdrID($group_id=0,$search=Array()) {
	//liefert NUR die IDs zurueck als Array!!! Beoetigt fuer die Formulare
	//keine suche ueber f0_9 !!!!! da wir speicher sparen wollen... nur ids!
	//bzw neue query testen!
		$ADRID=Array();
		$DB=new tm_DB();
		$Query ="
						SELECT ".TM_TABLE_ADR.".id
						FROM ".TM_TABLE_ADR."
					";
		if (isset($search['group']) && !empty($search['group'])) {
			$group_id=$search['group'];
		}
		if (check_dbid($group_id)) {
			$Query .="LEFT JOIN ".TM_TABLE_ADR_GRP_REF." ON ".TM_TABLE_ADR.".id = ".TM_TABLE_ADR_GRP_REF.".adr_id";
		}
		$Query .=" WHERE ".TM_TABLE_ADR.".siteid='".TM_SITEID."'
					";
		if (check_dbid($group_id)) {
			$Query .=" AND ".TM_TABLE_ADR_GRP_REF.".siteid='".TM_SITEID."'
						  AND ".TM_TABLE_ADR_GRP_REF.".grp_id='".dbesc($group_id)."'
						";
		}
		if (isset($search['email']) && !empty($search['email'])) {
			$Query .= " AND ".TM_TABLE_ADR.".email like lcase('".dbesc($search['email'])."')";
		}
		if (isset($search['status']) && !empty($search['status'])) {
			$Query .= " AND ".TM_TABLE_ADR.".status = '".dbesc($search['status'])."'";
		}
		$DB->Query($Query);
		$ac=0;
		while ($DB->next_record()) {
			$ADRID[$ac]=$DB->Record['id'];
			$ac++;
		}
		return $ADRID;
	}//getAdrID

	function countADR($group_id=0,$search=Array()) {
	//liefert NUR die IDs zurueck als Array!!! Benoetigt fuer die Formulare
	//keine suche ueber f0_9 !!!!! da wir speicher sparen wollen... nur ids!
	//bzw neue query testen!
		$Query ="
						SELECT count(".TM_TABLE_ADR.".id) as c
						FROM ".TM_TABLE_ADR."
					";
		if (isset($search['group']) && !empty($search['group'])) {
			$group_id=$search['group'];
		}
		if (check_dbid($group_id)) {
			$Query .="LEFT JOIN ".TM_TABLE_ADR_GRP_REF." ON ".TM_TABLE_ADR.".id = ".TM_TABLE_ADR_GRP_REF.".adr_id";
		}
		$Query .=" WHERE ".TM_TABLE_ADR.".siteid='".TM_SITEID."'
					";
		if (check_dbid($group_id)) {
			$Query .=" AND ".TM_TABLE_ADR_GRP_REF.".siteid='".TM_SITEID."'
						  AND ".TM_TABLE_ADR_GRP_REF.".grp_id='".dbesc($group_id)."'
						";
		}
		if (isset($search['email']) && !empty($search['email'])) {
			$Query .= " AND ".TM_TABLE_ADR.".email like lcase('".dbesc($search['email'])."')";
		}
		if (isset($search['status']) && !empty($search['status'])) {
			$Query .= " AND ".TM_TABLE_ADR.".status = '".dbesc($search['status'])."'";
		}
		if (isset($search['aktiv']) && !empty($search['aktiv'])) {
			$Query .= " AND ".TM_TABLE_ADR.".aktiv = '".dbesc($search['aktiv'])."'";
		}
		$this->DB2->Query($Query);
		if ($this->DB2->next_record()) {
			$count=$this->DB2->Record['c'];
		}
		return $count;
	}//countADR


	function getGroup($id=0,$adr_id=0,$frm_id=0,$count=0) {
		$this->GRP=Array();
		$Query ="
			SELECT ".TM_TABLE_ADR_GRP.".id, "
							.TM_TABLE_ADR_GRP.".name, "
							.TM_TABLE_ADR_GRP.".descr, "
							.TM_TABLE_ADR_GRP.".aktiv, "
							.TM_TABLE_ADR_GRP.".standard,
							".TM_TABLE_ADR_GRP.".author,
							".TM_TABLE_ADR_GRP.".editor,
							".TM_TABLE_ADR_GRP.".created,
							".TM_TABLE_ADR_GRP.".updated
			FROM ".TM_TABLE_ADR_GRP."
			WHERE ".TM_TABLE_ADR_GRP.".siteid='".TM_SITEID."'
			";
		if (check_dbid($id)) {
			$Query .= " AND ".TM_TABLE_ADR_GRP.".id='".$id."'";
		}
		if ($adr_id >0) {
			$Query ="";
			$Query .= "
				SELECT DISTINCT ".TM_TABLE_ADR_GRP.".id, "
												.TM_TABLE_ADR_GRP.".name, "
												.TM_TABLE_ADR_GRP.".descr, "
												.TM_TABLE_ADR_GRP.".aktiv, "
												.TM_TABLE_ADR_GRP.".standard,
												".TM_TABLE_ADR_GRP.".author,
												".TM_TABLE_ADR_GRP.".editor,
												".TM_TABLE_ADR_GRP.".created,
												".TM_TABLE_ADR_GRP.".updated
				FROM ".TM_TABLE_ADR_GRP.", ".TM_TABLE_ADR_GRP_REF."
				WHERE ".TM_TABLE_ADR_GRP.".id=".TM_TABLE_ADR_GRP_REF.".grp_id
				AND ".TM_TABLE_ADR_GRP.".siteid='".TM_SITEID."'
				AND ".TM_TABLE_ADR_GRP_REF.".siteid='".TM_SITEID."'
				AND ".TM_TABLE_ADR_GRP_REF.".adr_id='".dbesc($adr_id)."'
			";
		}
		if (check_dbid($frm_id)) {
			$Query ="";
			$Query .= "
				SELECT DISTINCT ".TM_TABLE_ADR_GRP.".id, "
												.TM_TABLE_ADR_GRP.".name, "
												.TM_TABLE_ADR_GRP.".descr, "
												.TM_TABLE_ADR_GRP.".aktiv, "
												.TM_TABLE_ADR_GRP.".standard,
				".TM_TABLE_ADR_GRP.".author,
				".TM_TABLE_ADR_GRP.".editor,
				".TM_TABLE_ADR_GRP.".created,
				".TM_TABLE_ADR_GRP.".updated

				FROM ".TM_TABLE_ADR_GRP.", ".TM_TABLE_FRM_GRP_REF."
				WHERE ".TM_TABLE_ADR_GRP.".id=".TM_TABLE_FRM_GRP_REF.".grp_id
				AND ".TM_TABLE_ADR_GRP.".siteid='".TM_SITEID."'
				AND ".TM_TABLE_FRM_GRP_REF.".siteid='".TM_SITEID."'
				AND ".TM_TABLE_FRM_GRP_REF.".frm_id='".dbesc($frm_id)."'
			";
		}

		$Query .= "	ORDER BY ".TM_TABLE_ADR_GRP.".name";
		$this->DB->Query($Query);
		$ac=0;
		while ($this->DB->next_record()) {
			$this->GRP[$ac]['id']=$this->DB->Record['id'];
			$this->GRP[$ac]['name']=$this->DB->Record['name'];
			$this->GRP[$ac]['descr']=$this->DB->Record['descr'];
			$this->GRP[$ac]['aktiv']=$this->DB->Record['aktiv'];
			$this->GRP[$ac]['standard']=$this->DB->Record['standard'];
			$this->GRP[$ac]['author']=$this->DB->Record['author'];
			$this->GRP[$ac]['editor']=$this->DB->Record['editor'];
			$this->GRP[$ac]['created']=$this->DB->Record['created'];
			$this->GRP[$ac]['updated']=$this->DB->Record['updated'];
			if ($count==1) {
				$this->GRP[$ac]['adr_count']=$this->countADR($this->GRP[$ac]['id']);
			}
			$ac++;
		}
		return $this->GRP;
	}//getGroup

	function getGroupID($id=0,$adr_id=0,$frm_id=0) {
	//liefert NUR die IDs zurueck als Array!!! Beoetigt fuer die Formulare
		$GRPID=Array();
		$GRP=$this->getGroup($id,$adr_id,$frm_id,0);
		$acg=count($GRP);
		for ($accg=0;$accg<$acg;$accg++) {
			$GRPID[$accg]=$GRP[$accg]['id'];
		}
		return $GRPID;
	}//getGroupID



	function setAktiv($id=0,$aktiv=1) {
		$Return=false;
		if (check_dbid($id)) {
			$Query ="UPDATE ".TM_TABLE_ADR." SET aktiv='".dbesc($aktiv)."' WHERE id='".$id."' AND siteid='".TM_SITEID."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//setAktiv

	function setGrpAktiv($id=0,$aktiv=1) {
		$Return=false;
		if (check_dbid($id)) {
			$Query ="UPDATE ".TM_TABLE_ADR_GRP." SET aktiv='".dbesc($aktiv)."' WHERE id='".$id."' AND siteid='".TM_SITEID."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//setGrpAktiv

	function setGrpStd($id=0) {
		$Return=false;
		if (check_dbid($id)) {
			$Query ="UPDATE ".TM_TABLE_ADR_GRP." SET standard=0 WHERE standard=1 AND siteid='".TM_SITEID."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
			$Query ="UPDATE ".TM_TABLE_ADR_GRP." SET standard=1 WHERE id='".$id."' AND siteid='".TM_SITEID."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
		}
		return $Return;
	}//setGrpStd

	function addGrp($group) {
		$Return=false;
		$Query ="INSERT INTO ".TM_TABLE_ADR_GRP." (
					name,descr,aktiv,
					standard,
					created,author,
					updated,editor,
					siteid
					)
					VALUES (
					'".dbesc($group["name"])."', '".dbesc($group["descr"])."',
					'".dbesc($group["aktiv"])."', 0,
					'".dbesc($group["created"])."', '".dbesc($group["author"])."',
					'".dbesc($group["created"])."', '".dbesc($group["author"])."',
					'".TM_SITEID."')";
		if ($this->DB->Query($Query)) {
			$Return=true;
		}
		return $Return;
	}//addGrp

	function updateGrp($group) {
		$Return=false;
		if (isset($group['id']) && check_dbid($group['id'])) {
			$Query ="UPDATE ".TM_TABLE_ADR_GRP."
					SET
					name='".dbesc($group["name"])."', descr='".dbesc($group["descr"])."',
					aktiv='".dbesc($group["aktiv"])."',
					updated='".dbesc($group["created"])."',
					editor='".dbesc($group["author"])."'
					WHERE siteid='".TM_SITEID."' AND id='".dbesc($group["id"])."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//updateGrp

	function cleanAdr($search) {
				/**/
				//delete flag setzen 'clean'
				/**/
				$Query ="UPDATE ".TM_TABLE_ADR." LEFT JOIN ".TM_TABLE_ADR_GRP_REF.
								" ON ".TM_TABLE_ADR.".id = ".TM_TABLE_ADR_GRP_REF.".adr_id".
								" SET ".TM_TABLE_ADR.".clean=1".
								" WHERE ".TM_TABLE_ADR.".status='".$search['status']."'".
								" AND ".TM_TABLE_ADR_GRP_REF.".grp_id='".$search['group']."'";
				if ($this->DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
				/**/
				//adr details loeschen
				/**/
				$Query ="DELETE ".TM_TABLE_ADR_DETAILS." FROM ".TM_TABLE_ADR_DETAILS."  ".
								" LEFT JOIN ".TM_TABLE_ADR." ON ".TM_TABLE_ADR.".id = ".TM_TABLE_ADR_DETAILS.".adr_id".
								" LEFT JOIN ".TM_TABLE_ADR_GRP_REF." ON ".TM_TABLE_ADR.".id = ".TM_TABLE_ADR_GRP_REF.".adr_id".
								" WHERE ".TM_TABLE_ADR.".siteid='".TM_SITEID."'".
								" AND ".TM_TABLE_ADR.".clean=1".
								" AND ".TM_TABLE_ADR.".status='".$search['status']."'".
								" AND ".TM_TABLE_ADR_DETAILS.".siteid='".TM_SITEID."'".
								" AND ".TM_TABLE_ADR_GRP_REF.".siteid='".TM_SITEID."'".
								" AND ".TM_TABLE_ADR_GRP_REF.".grp_id='".$search['group']."'";
				if ($this->DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
				
				/**/
				//referenzen zu gruppen loeschen
				/**/
				$Query ="DELETE ".TM_TABLE_ADR_GRP_REF." FROM ".TM_TABLE_ADR_GRP_REF."  ".
								" LEFT JOIN ".TM_TABLE_ADR." ON ".TM_TABLE_ADR.".id = ".TM_TABLE_ADR_GRP_REF.".adr_id".
								" WHERE ".TM_TABLE_ADR.".siteid='".TM_SITEID."'".
								" AND ".TM_TABLE_ADR.".status='".$search['status']."'".
								" AND ".TM_TABLE_ADR.".clean=1".
								" AND ".TM_TABLE_ADR_GRP_REF.".siteid='".TM_SITEID."'".
								" AND ".TM_TABLE_ADR_GRP_REF.".grp_id='".$search['group']."'";

				if ($this->DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}

				/**/
				//subscriptions loeschen
				/**/
				/**/
				//adressen loeschen
				/**/
				$Query ="DELETE FROM ".TM_TABLE_ADR."  ".
								" WHERE ".TM_TABLE_ADR.".siteid='".TM_SITEID."'".
								" AND ".TM_TABLE_ADR.".status='".$search['status']."'";
								" AND ".TM_TABLE_ADR.".clean=1";
				if ($this->DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
	}
	
	function delGrp($id,$reorg=1,$deleteAdr=0) {
		$Return=false;
		if (check_dbid($id)) {
			//wenn reorg==1, dfault, dann adressen der standardgruppe neu zuordnen
			//andernfalls, auch adressen loeschen?
			//standard gruppe suchen
			if ($reorg==1) {
				$Query ="SELECT id FROM ".TM_TABLE_ADR_GRP
								." WHERE siteid='".TM_SITEID
								."' AND standard=1";
				if ($this->DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
				//wenn standardgruppe gefunden, weitermachen, ansonsten nichts tun!!! loeschen geht nur wenn eine std gruppe definiert wurde welcher die NL aus zu loeschender Gruppe zugeordnet werden koennen
				if ($this->DB->next_record()) {
					$stdGrpID=$this->DB->Record['id'];
					//adresse der stdgruppe neu zuordnen
					//achtung! durch das normale update aller referenzen gibt es redundante eintraege!!!
					//alle adr suchen die zur loeschenden gruppe gehoeren
					//einzelne adressen in array einlesen! achtung, array wird zu gross! deshalb kommt hier ne eigene query hin!
					//bzw. mit limit und offset arbeiten und in schleife einbinden!
					//function getAdr($id=0,$offset=0,$limit=0,$group_id=0,$search=Array(),$sortIndex="",$sortType=0,$Details=1) {
					//neu:
					$total=$this->countADR($id);
					global $adr_row_limit;
					$limit=$adr_row_limit;
					for ($offset=0; $offset <= $total; $offset+=$limit) {
						$adr=$this->getAdr(0,$offset,$limit,$id,Array(),"","",0);
						//neu
						//referenzen zur Standardgruppe dieser adressen suchen und aufloesen:
						$ac=count($adr);
						//schleife drumherum mit adr_row_limit
						for ($acc=0;$acc<$ac;$acc++) {
							$Query ="SELECT ".TM_TABLE_ADR_GRP_REF.".id FROM ".TM_TABLE_ADR_GRP_REF
											." WHERE siteid='".TM_SITEID
											."' AND adr_id='".$adr[$acc]['id']
											."' AND grp_id='".$stdGrpID."'";
							if ($this->DB->Query($Query)) {
								$Return=true;
							} else {
								$Return=false;
								return $Return;
							}
							if ($this->DB->next_record()) {
								//  ist adr mit standardgruppe verknuepft, dann alte referenz loeschen
								$Query ="DELETE FROM ".TM_TABLE_ADR_GRP_REF."  WHERE siteid='".TM_SITEID."' AND adr_id='".$adr[$acc]['id']."' AND grp_id='".$id."'";
								if ($this->DB->Query($Query)) {
									$Return=true;
								} else {
									$Return=false;
									return $Return;
								}
							} else {	//oder
								//  ist adr NICHT mit standardgruppe verknuepft, dann alte referenz mit stdgruppe updaten
								//update der verknuepfung zur alten Gruppe mit der neuen Gruppe...
								$Query ="UPDATE ".TM_TABLE_ADR_GRP_REF." SET grp_id='".$stdGrpID."' WHERE siteid='".TM_SITEID."' AND grp_id='".$id."'";
								if ($this->DB->Query($Query)) {
									$Return=true;
								} else {
									$Return=false;
									return $Return;
								}
							}//if
						}//for acc
					}//offset
				}//next record
			}//reorg
			
			if ($deleteAdr==1) {
				//einzelne adressen in array einlesen! achtung, array wird zu gross! deshalb kommt hier ne eigene query hin!
				//adressdetails loeschen:
				/*zu dumm, mysql kann kein delete + join...pfff, also 2 queries, zuerst die adresseendetails, dann die adr, ... und zum schluss die detailsdaten wie q und history etc?? siehe unten, anmerkungen
				*/
				$Query ="DELETE ".TM_TABLE_ADR_DETAILS." FROM ".TM_TABLE_ADR_DETAILS."  ";//WHERE siteid='".TM_SITEID."' ";
				$Query .=" LEFT JOIN ".TM_TABLE_ADR." ON ".TM_TABLE_ADR.".id = ".TM_TABLE_ADR_DETAILS.".adr_id";
				$Query .=" LEFT JOIN ".TM_TABLE_ADR_GRP_REF." ON ".TM_TABLE_ADR.".id = ".TM_TABLE_ADR_GRP_REF.".adr_id";
				$Query .=" WHERE ".TM_TABLE_ADR.".siteid='".TM_SITEID."'";
				$Query .=" AND ".TM_TABLE_ADR_DETAILS.".siteid='".TM_SITEID."'
							AND ".TM_TABLE_ADR_GRP_REF.".siteid='".TM_SITEID."'
						  AND ".TM_TABLE_ADR_GRP_REF.".grp_id='".$id."'";
				if ($this->DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
				/**/
				//adressen loeschen
				/**/
				$Query ="DELETE ".TM_TABLE_ADR." FROM ".TM_TABLE_ADR."  ";//WHERE siteid='".TM_SITEID."' ";
				$Query .="LEFT JOIN ".TM_TABLE_ADR_GRP_REF." ON ".TM_TABLE_ADR_GRP_REF.".adr_id = ".TM_TABLE_ADR.".id";
				$Query .=" WHERE ".TM_TABLE_ADR.".siteid='".TM_SITEID."'";
				$Query .=" AND ".TM_TABLE_ADR_GRP_REF.".siteid='".TM_SITEID."'
						  AND ".TM_TABLE_ADR_GRP_REF.".grp_id='".$id."'";
				if ($this->DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
				/**/
				//referenzen loeschen
				/**/
				$Query ="DELETE FROM ".TM_TABLE_ADR_GRP_REF."  WHERE siteid='".TM_SITEID."' AND grp_id='".$id."'";
				if ($this->DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
				/**/
				if ($this->DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
			}
			/* nein historie nicht loeschen! nur wenn nl oder adresse geloescht wird!
			//versandliste, history h loeschen
			*/
			//aber die q muss geloescht werden!!!
			//q loeschen
			$Query ="DELETE FROM ".TM_TABLE_NL_Q." WHERE siteid='".TM_SITEID."' AND grp_id='".$id."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
			//verknuepfung zu formularen loeschen
			$Query ="DELETE FROM ".TM_TABLE_FRM_GRP_REF."  WHERE siteid='".TM_SITEID."' AND grp_id='".$id."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
			//gruppe loeschen
			$Query ="DELETE FROM ".TM_TABLE_ADR_GRP."  WHERE siteid='".TM_SITEID."' AND id='".$id."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
		}
		return $Return;
	}//delGrp

	function delAdr($id) {
		$Return=false;
		if (check_dbid($id)) {
			//versandliste, history h loeschen
			//ok jetzt historie loeschen! aber nicht wenn adr_grp oder q!
			$Query ="DELETE FROM ".TM_TABLE_NL_H." WHERE siteid='".TM_SITEID."' AND adr_id='".$id."'";
				if ($this->DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
			//referenzen loeschen
			$Query ="DELETE FROM ".TM_TABLE_ADR_GRP_REF." WHERE siteid='".TM_SITEID."' AND adr_id='".$id."'";
				if ($this->DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
			//details loeschen
			$Query ="DELETE FROM ".TM_TABLE_ADR_DETAILS." WHERE siteid='".TM_SITEID."' AND adr_id='".$id."'";
				if ($this->DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
			//subscriptions loeschen
			$Query ="DELETE FROM ".TM_TABLE_FRM_S." WHERE siteid='".TM_SITEID."' AND adr_id='".$id."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
			//adresse loeschen
			$Query ="DELETE FROM ".TM_TABLE_ADR." WHERE siteid='".TM_SITEID."' AND id='".$id."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
		}
		return $Return;
	}//delAdr

	function addAdr($adr,$grp) {
		$Return=false;
		//neue Adresse speichern
		$Query ="INSERT INTO ".TM_TABLE_ADR." (email,aktiv,status,code,author,created,editor,updated,clicks,views,newsletter,siteid)
					VALUES (lcase('".dbesc($adr["email"])."'), '".dbesc($adr["aktiv"])."',
								'".dbesc($adr["status"])."', '".dbesc($adr["code"])."', '".dbesc($adr["author"])."', '".dbesc($adr["created"])."', '".dbesc($adr["author"])."', '".dbesc($adr["created"])."', 0, 0, 0, '".TM_SITEID."'
								)";
		if ($this->DB->Query($Query)) {
			$Return=true;
		} else {
			$Return=false;
			return $Return;
		}
		//Abfragen! und ID suchen, die brauchen wir fuer die Verknuepfung zu den Adressgruppen
		//neu:
		if ($this->DB->LastInsertID != 0) {
		//neu
			$new_adr_id=$this->DB->LastInsertID;
			//detaildaten eintragen
				$Query="INSERT INTO ".TM_TABLE_ADR_DETAILS." (adr_id,memo,siteid,f0,f1,f2,f3,f4,f5,f6,f7,f8,f9)
							VALUES ('".$new_adr_id."',
										'".dbesc($adr['memo'])."',
										'".TM_SITEID."',
										'".dbesc($adr['f0'])."',
										'".dbesc($adr['f1'])."',
										'".dbesc($adr['f2'])."',
										'".dbesc($adr['f3'])."',
										'".dbesc($adr['f4'])."',
										'".dbesc($adr['f5'])."',
										'".dbesc($adr['f6'])."',
										'".dbesc($adr['f7'])."',
										'".dbesc($adr['f8'])."',
										'".dbesc($adr['f9'])."'
										)";
				if ($this->DB->Query($Query)) {
					$Return=true;
				} else {//if query
					$Return=false;
					return $Return;
				}//if query

			//gruppen eintragen
			$acg=count($grp);
			for ($accg=0;$accg<$acg;$accg++) {
				$Query="INSERT 
								INTO ".TM_TABLE_ADR_GRP_REF.
								" (adr_id,grp_id,siteid)".
								" VALUES "
								."('".$new_adr_id."',
								'".$grp[$accg]."',
								'".TM_SITEID."')";
				if ($this->DB->Query($Query)) {
					$Return=true;
				} else {//if query
					$Return=false;
					return $Return;
				}//if query
			}//for
		}//get id, next record, bzw if $this->DB->LastInsertID!=0
		$Return=$new_adr_id;
		return $Return;
	}//addAdr

	function addRef($adr_id,$grp) {
		$Return=false;
		if (check_dbid($adr_id)) {
			//gruppen eintragen
			$acg=count($grp);
			for ($accg=0;$accg<$acg;$accg++) {
				$Query="INSERT INTO ".TM_TABLE_ADR_GRP_REF." (adr_id,grp_id,siteid) VALUES ('".$adr_id."','".$grp[$accg]."','".TM_SITEID."')";
				if ($this->DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
			}
		}
		return $Return;
	}

	function setStatus($id,$status) {
		$Return=false;
		if (check_dbid($id)) {
			$Query ="UPDATE ".TM_TABLE_ADR." SET status='".$status."'
						 WHERE siteid='".TM_SITEID."' AND id='".$id."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
		}
		return $Return;
	}

	function unsubscribe($id,$author) {
		$Return=false;
		if (check_dbid($id)) {
			$Query ="UPDATE ".TM_TABLE_ADR." SET updated='".date("Y-m-d H:i:s")."', status=11, editor='".dbesc($author)."'
						 WHERE siteid='".TM_SITEID."' AND id='".$id."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}

	function updateAdr($adr,$grp) {
		$Return=false;
		if (isset($adr['id']) && check_dbid($adr['id'])) {
			$Query ="UPDATE ".TM_TABLE_ADR." SET
							email=lcase('".dbesc($adr["email"])."'),
							aktiv='".dbesc($adr["aktiv"])."',
							editor='".dbesc($adr["author"])."',
							updated='".dbesc($adr["created"])."'
						 WHERE siteid='".TM_SITEID."' AND id='".$adr["id"]."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
			//details
			$Query ="UPDATE ".TM_TABLE_ADR_DETAILS." SET
						memo='".dbesc($adr['memo'])."',
						f0='".dbesc($adr["f0"])."',
						f1='".dbesc($adr["f1"])."',
						f2='".dbesc($adr["f2"])."',
						f3='".dbesc($adr["f3"])."',
						f4='".dbesc($adr["f4"])."',
						f5='".dbesc($adr["f5"])."',
						f6='".dbesc($adr["f6"])."',
						f7='".dbesc($adr["f7"])."',
						f8='".dbesc($adr["f8"])."',
						f9='".dbesc($adr["f9"])."'
						 WHERE siteid='".TM_SITEID."' AND adr_id='".$adr["id"]."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
			//alle refs loeschen
			$Query ="DELETE FROM ".TM_TABLE_ADR_GRP_REF." WHERE siteid='".TM_SITEID."' AND adr_id='".$adr['id']."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
			//neue refs anlegen
			$acg=count($grp);
			for ($accg=0;$accg<$acg;$accg++) {
				$Query="INSERT INTO ".TM_TABLE_ADR_GRP_REF." (adr_id,grp_id,siteid) VALUES ('".$adr['id']."','".$grp[$accg]."','".TM_SITEID."')";
				if ($this->DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
			}
		}
		return $Return;
	}//updateAdr

	function setAError($id,$errors) {
		$Return=false;
		if (check_dbid($id)) {
			$Query ="UPDATE ".TM_TABLE_ADR." SET errors='".dbesc($errors)."'
						 WHERE siteid='".TM_SITEID."' AND id='".$id."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
		}
		return $Return;
	}

	function addClick($adr_id) {
		$Return=false;
		if (check_dbid($adr_id)) {
			$ADR=$this->getADR($adr_id);
			$clicks=$ADR[0]['clicks'];
			$clicks++;
			$Query ="UPDATE ".TM_TABLE_ADR." SET clicks='".$clicks."' WHERE siteid='".TM_SITEID."' AND id='".$adr_id."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//addClick

	function addView($adr_id) {
		$Return=false;
		if (check_dbid($adr_id)) {
			$ADR=$this->getADR($adr_id);
			$views=$ADR[0]['views'];
			$views++;
			$Query ="UPDATE ".TM_TABLE_ADR." SET views='".$views."' WHERE siteid='".TM_SITEID."' AND id='".$adr_id."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//addView

	function addNL($adr_id) {
		$Return=false;
		if (check_dbid($adr_id)) {
			$ADR=$this->getADR($adr_id);
			$nl=$ADR[0]['newsletter'];
			$nl++;
			$Query ="UPDATE ".TM_TABLE_ADR." SET newsletter='".$nl."' WHERE siteid='".TM_SITEID."' AND id='".$adr_id."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//addView


}  //class
?>