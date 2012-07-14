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


class mnlADR {  
	var $ADR=Array();
	var $GRP=Array();
  
	function getAdr($id=0,$offset=0,$limit=0,$group_id=0,$search=Array(),$sortIndex="",$sortType=0) {
		global $mnl_siteid;
		$this->ADR=Array();
		$DB=new ConnectDB();
		$Query ="
						SELECT ".mnlTABLE_ADR.".id, ".mnlTABLE_ADR.".email, ".mnlTABLE_ADR.".aktiv, ".mnlTABLE_ADR.".created, ".mnlTABLE_ADR.".updated, ".mnlTABLE_ADR.".author, ".mnlTABLE_ADR.".editor, ".mnlTABLE_ADR.".status, ".mnlTABLE_ADR.".errors, ".mnlTABLE_ADR.".code, ".mnlTABLE_ADR.".clicks, ".mnlTABLE_ADR.".views, ".mnlTABLE_ADR.".newsletter,
								".mnlTABLE_ADR_DETAILS.".id as d_id, ".mnlTABLE_ADR_DETAILS.".f0, ".mnlTABLE_ADR_DETAILS.".f1, ".mnlTABLE_ADR_DETAILS.".f2, ".mnlTABLE_ADR_DETAILS.".f3, ".mnlTABLE_ADR_DETAILS.".f4, ".mnlTABLE_ADR_DETAILS.".f5, ".mnlTABLE_ADR_DETAILS.".f6, ".mnlTABLE_ADR_DETAILS.".f7, ".mnlTABLE_ADR_DETAILS.".f8, ".mnlTABLE_ADR_DETAILS.".f9
						FROM ".mnlTABLE_ADR." 
						LEFT JOIN ".mnlTABLE_ADR_DETAILS." ON ".mnlTABLE_ADR.".id = ".mnlTABLE_ADR_DETAILS.".adr_id
					";
		if (isset($search['group']) && !empty($search['group'])) {
			$group_id=$search['group'];
		}
		if (check_dbid($group_id)) {
			$Query .="LEFT JOIN ".mnlTABLE_ADR_GRP_REF." ON ".mnlTABLE_ADR.".id = ".mnlTABLE_ADR_GRP_REF.".adr_id";
		}
		$Query .=" WHERE ".mnlTABLE_ADR.".siteid='".$mnl_siteid."'
					";
//					  AND ".mnlTABLE_ADR_DETAILS.".siteid='".$mnl_siteid."'
					//achtung, durch AND ".mnlTABLE_ADR_DETAILS.".siteid='".$mnl_siteid."' werden nur die eintraege angezeigt die auch eien detaildatensatz haben!!!
		if (check_dbid($group_id)) {
			$Query .=" AND ".mnlTABLE_ADR_GRP_REF.".siteid='".$mnl_siteid."'
						  AND ".mnlTABLE_ADR_GRP_REF.".grp_id='".$group_id."'
						";
		}
		if (isset($search['email']) && !empty($search['email'])) {
			$Query .= " AND ".mnlTABLE_ADR.".email like '".$search['email']."'";
		}
		if (isset($search['author']) && !empty($search['author'])) {
			$Query .= " AND ".mnlTABLE_ADR.".author like '".$search['author']."'";
		}
		if (isset($search['status']) && !empty($search['status'])) {
			$Query .= " AND ".mnlTABLE_ADR.".status = '".$search['status']."'";
		}
		if (isset($search['code']) && !empty($search['code'])) {
			$Query .= " AND ".mnlTABLE_ADR.".code = '".$search['code']."'";
		}
		if (isset($search['f0_9']) && !empty($search['f0_9'])) {
			$Query .= " AND (
							".mnlTABLE_ADR_DETAILS.".f0 like '".$search['f0_9']."'
							OR ".mnlTABLE_ADR_DETAILS.".f1 like '".$search['f0_9']."'
							OR ".mnlTABLE_ADR_DETAILS.".f2 like '".$search['f0_9']."'
							OR ".mnlTABLE_ADR_DETAILS.".f3 like '".$search['f0_9']."'
							OR ".mnlTABLE_ADR_DETAILS.".f4 like '".$search['f0_9']."'
							OR ".mnlTABLE_ADR_DETAILS.".f5 like '".$search['f0_9']."'
							OR ".mnlTABLE_ADR_DETAILS.".f6 like '".$search['f0_9']."'
							OR ".mnlTABLE_ADR_DETAILS.".f7 like '".$search['f0_9']."'
							OR ".mnlTABLE_ADR_DETAILS.".f8 like '".$search['f0_9']."'
							OR ".mnlTABLE_ADR_DETAILS.".f9 like '".$search['f0_9']."'
							)";
		}
		if (check_dbid($id)) {
			$Query .= " AND ".mnlTABLE_ADR.".id='".$id."'";
		}

		if (!empty($sortIndex)) {
			$Query .= " ORDER BY ".$sortIndex;
			if ($sortType==0) {
				$Query .= " ASC";
			}
			if ($sortType==1) {
				$Query .= " DESC";
			}
		}

		if ($limit >0 and $offset>=0) {
			$Query .= " LIMIT ".$offset." ,".$limit;
		}
		$DB->Query($Query);
		$ac=0;
		while ($DB->next_record()) {
			$this->ADR[$ac]['id']=$DB->Record['id'];
			$this->ADR[$ac]['email']=$DB->Record['email'];
			$this->ADR[$ac]['aktiv']=$DB->Record['aktiv'];
			$this->ADR[$ac]['created']=$DB->Record['created'];
			$this->ADR[$ac]['updated']=$DB->Record['updated'];
			$this->ADR[$ac]['author']=$DB->Record['author'];
			$this->ADR[$ac]['editor']=$DB->Record['editor'];
			$this->ADR[$ac]['status']=$DB->Record['status'];
			$this->ADR[$ac]['clicks']=$DB->Record['clicks'];
			$this->ADR[$ac]['views']=$DB->Record['views'];
			$this->ADR[$ac]['newsletter']=$DB->Record['newsletter'];
			$this->ADR[$ac]['errors']=$DB->Record['errors'];
			$this->ADR[$ac]['code']=$DB->Record['code'];
			$this->ADR[$ac]['d_id']=$DB->Record['d_id'];
			$this->ADR[$ac]['f0']=$DB->Record['f0'];
			$this->ADR[$ac]['f1']=$DB->Record['f1'];
			$this->ADR[$ac]['f2']=$DB->Record['f2'];
			$this->ADR[$ac]['f3']=$DB->Record['f3'];
			$this->ADR[$ac]['f4']=$DB->Record['f4'];
			$this->ADR[$ac]['f5']=$DB->Record['f5'];
			$this->ADR[$ac]['f6']=$DB->Record['f6'];
			$this->ADR[$ac]['f7']=$DB->Record['f7'];
			$this->ADR[$ac]['f8']=$DB->Record['f8'];
			$this->ADR[$ac]['f9']=$DB->Record['f9'];
			$ac++;
		} 
		return $this->ADR;
	}//getAdr

	function getAdrID($group_id=0,$search=Array()) {
	//liefert NUR die IDs zurueck als Array!!! Beoetigt fuer die Formulare
	//keine suche ueber f0_9 !!!!! da wir speicher sparen wollen... nur ids!
	//bzw neue query testen!
		
		global $mnl_siteid;
		$ADRID=Array();
		$DB=new ConnectDB();
		$Query ="
						SELECT ".mnlTABLE_ADR.".id
						FROM ".mnlTABLE_ADR." 
					";
		if (isset($search['group']) && !empty($search['group'])) {
			$group_id=$search['group'];
		}
		if (check_dbid($group_id)) {
			$Query .="LEFT JOIN ".mnlTABLE_ADR_GRP_REF." ON ".mnlTABLE_ADR.".id = ".mnlTABLE_ADR_GRP_REF.".adr_id";
		}
		$Query .=" WHERE ".mnlTABLE_ADR.".siteid='".$mnl_siteid."'
					";
		if (check_dbid($group_id)) {
			$Query .=" AND ".mnlTABLE_ADR_GRP_REF.".siteid='".$mnl_siteid."'
						  AND ".mnlTABLE_ADR_GRP_REF.".grp_id='".$group_id."'
						";
		}
		if (isset($search['email']) && !empty($search['email'])) {
			$Query .= " AND ".mnlTABLE_ADR.".email like '".$search['email']."'";
		}
		if (isset($search['status']) && !empty($search['status'])) {
			$Query .= " AND ".mnlTABLE_ADR.".status = '".$search['status']."'";
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
		
		global $mnl_siteid;
		$this->ADR=Array();
		$DB=new ConnectDB();
		$Query ="
						SELECT count(".mnlTABLE_ADR.".id) as c
						FROM ".mnlTABLE_ADR." 
					";
		if (isset($search['group']) && !empty($search['group'])) {
			$group_id=$search['group'];
		}
		if (check_dbid($group_id)) {
			$Query .="LEFT JOIN ".mnlTABLE_ADR_GRP_REF." ON ".mnlTABLE_ADR.".id = ".mnlTABLE_ADR_GRP_REF.".adr_id";
		}
		$Query .=" WHERE ".mnlTABLE_ADR.".siteid='".$mnl_siteid."'
					";
		if (check_dbid($group_id)) {
			$Query .=" AND ".mnlTABLE_ADR_GRP_REF.".siteid='".$mnl_siteid."'
						  AND ".mnlTABLE_ADR_GRP_REF.".grp_id='".$group_id."'
						";
		}
		if (isset($search['email']) && !empty($search['email'])) {
			$Query .= " AND ".mnlTABLE_ADR.".email like '".$search['email']."'";
		}
		if (isset($search['status']) && !empty($search['status'])) {
			$Query .= " AND ".mnlTABLE_ADR.".status = '".$search['status']."'";
		}
		if (isset($search['aktiv']) && !empty($search['aktiv'])) {
			$Query .= " AND ".mnlTABLE_ADR.".aktiv = '".$search['aktiv']."'";
		}
		$DB->Query($Query);
		if ($DB->next_record()) {
			$count=$DB->Record['c'];
		} 
		return $count;
	}//countADR


	function getGroup($id=0,$adr_id=0,$frm_id=0,$count=0) {
		global $mnl_siteid;
		$this->GRP=Array();
		$DB=new ConnectDB();
		$Query ="
			SELECT ".mnlTABLE_ADR_GRP.".id, ".mnlTABLE_ADR_GRP.".name, ".mnlTABLE_ADR_GRP.".descr, ".mnlTABLE_ADR_GRP.".aktiv, ".mnlTABLE_ADR_GRP.".standard
			FROM ".mnlTABLE_ADR_GRP." 
			WHERE ".mnlTABLE_ADR_GRP.".siteid='".$mnl_siteid."'
			";
		if (check_dbid($id)) {
			$Query .= " AND ".mnlTABLE_ADR_GRP.".id='".$id."'";
		}
		if ($adr_id >0) {
			$Query ="";
			$Query .= " 
				SELECT DISTINCT ".mnlTABLE_ADR_GRP.".id, ".mnlTABLE_ADR_GRP.".name, ".mnlTABLE_ADR_GRP.".descr, ".mnlTABLE_ADR_GRP.".aktiv, ".mnlTABLE_ADR_GRP.".standard
				FROM ".mnlTABLE_ADR_GRP.", ".mnlTABLE_ADR_GRP_REF."
				WHERE ".mnlTABLE_ADR_GRP.".id=".mnlTABLE_ADR_GRP_REF.".grp_id
				AND ".mnlTABLE_ADR_GRP.".siteid='".$mnl_siteid."'
				AND ".mnlTABLE_ADR_GRP_REF.".siteid='".$mnl_siteid."'
				AND ".mnlTABLE_ADR_GRP_REF.".adr_id='".$adr_id."'
			";
		}
		if (check_dbid($frm_id)) {
			$Query ="";
			$Query .= " 
				SELECT DISTINCT ".mnlTABLE_ADR_GRP.".id, ".mnlTABLE_ADR_GRP.".name, ".mnlTABLE_ADR_GRP.".descr, ".mnlTABLE_ADR_GRP.".aktiv, ".mnlTABLE_ADR_GRP.".standard
				FROM ".mnlTABLE_ADR_GRP.", ".mnlTABLE_FRM_GRP_REF." 
				WHERE ".mnlTABLE_ADR_GRP.".id=".mnlTABLE_FRM_GRP_REF.".grp_id
				AND ".mnlTABLE_ADR_GRP.".siteid='".$mnl_siteid."'
				AND ".mnlTABLE_FRM_GRP_REF.".siteid='".$mnl_siteid."'
				AND ".mnlTABLE_FRM_GRP_REF.".frm_id='".$frm_id."'
			";
		}

		$Query .= "	ORDER BY ".mnlTABLE_ADR_GRP.".name";
		$DB->Query($Query);
		$ac=0;
		while ($DB->next_record()) {
			$this->GRP[$ac]['id']=$DB->Record['id'];
			$this->GRP[$ac]['name']=$DB->Record['name'];
			$this->GRP[$ac]['descr']=$DB->Record['descr'];
			$this->GRP[$ac]['aktiv']=$DB->Record['aktiv'];
			$this->GRP[$ac]['standard']=$DB->Record['standard'];
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
		global $mnl_siteid;
		if (check_dbid($id)) {
			$DB=new ConnectDB();
			$Query ="UPDATE ".mnlTABLE_ADR." SET aktiv='".$aktiv."' WHERE id='".$id."' AND siteid='".$mnl_siteid."'";
			if ($DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//setAktiv

	function setGrpAktiv($id=0,$aktiv=1) {
		global $mnl_siteid;
		$Return=false;
		if (check_dbid($id)) {
			$DB=new ConnectDB();
			$Query ="UPDATE ".mnlTABLE_ADR_GRP." SET aktiv='".$aktiv."' WHERE id='".$id."' AND siteid='".$mnl_siteid."'";
			if ($DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//setGrpAktiv
	
	function setGrpStd($id=0) {
		global $mnl_siteid;
		$Return=false;
		if (check_dbid($id)) {
			$DB=new ConnectDB();
			$Query ="UPDATE ".mnlTABLE_ADR_GRP." SET standard=0 WHERE standard=1 AND siteid='".$mnl_siteid."'";
			if ($DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
			$Query ="UPDATE ".mnlTABLE_ADR_GRP." SET standard=1 WHERE id='".$id."' AND siteid='".$mnl_siteid."'";
			if ($DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
		}
		return $Return;
	}//setGrpStd
	
	function addGrp($group) {
		global $mnl_siteid;
		$Return=false;
		$DB=new ConnectDB();
		$Query ="INSERT INTO ".mnlTABLE_ADR_GRP." (name,descr,aktiv,standard,siteid) VALUES ('".$group["name"]."', '".$group["descr"]."', '".$group["aktiv"]."', 0, '".$mnl_siteid."')";
		if ($DB->Query($Query)) {
			$Return=true;
		}
		return $Return;
	}//addGrp

	function updateGrp($group) {
		global $mnl_siteid;
		$Return=false;
		if (isset($group['id']) && check_dbid($group['id'])) {
			$DB=new ConnectDB();
			$Query ="UPDATE ".mnlTABLE_ADR_GRP." SET name='".$group["name"]."', descr='".$group["descr"]."', aktiv='".$group["aktiv"]."' WHERE siteid='".$mnl_siteid."' AND id='".$group["id"]."'";
			if ($DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//updateGrp
	
	function delGrp($id,$reorg=1,$deleteAdr=0) {
		global $mnl_siteid;
		$Return=false;
		if (check_dbid($id)) {
			$DB=new ConnectDB();
			
			//wenn reorg==1, dfault, dann adressen der standardgruppe neu zuordnen
			//andernfalls, auch adressen loeschen?
			//standard gruppe suchen
			if ($reorg==1) {
				$Query ="SELECT id FROM ".mnlTABLE_ADR_GRP." WHERE siteid='".$mnl_siteid."' AND standard=1";
				if ($DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
				//wenn standardgruppe gefunden, weitermachen, ansonsten nichts tun!!! loeschen geht nur wenn eine std gruppe definiert wurde welcher die NL aus zu loeschender Gruppe zugeordnet werden koennen
				if ($DB->next_record()) {
					$stdGrpID=$DB->Record['id'];
					//adresse der stdgruppe neu zuordnen
					//achtung! durch das normale update aller referenzen gibt es redundante eintraege!!!
					//alle adr suchen die zur loeschenden gruppe gehoeren
					$adr=$this->getAdr(0,0,0,$id);
					//referenzen zur Standardgruppe dieser adressen suchen und aufloesen:
					$ac=count($adr);
					for ($acc=0;$acc<$ac;$acc++) {
						$Query ="SELECT ".mnlTABLE_ADR_GRP_REF.".id FROM ".mnlTABLE_ADR_GRP_REF." WHERE siteid='".$mnl_siteid."' AND adr_id='".$adr[$acc]['id']."' AND grp_id='".$stdGrpID."'";
						if ($DB->Query($Query)) {
							$Return=true;
						} else {
							$Return=false;
							return $Return;
						}
						if ($DB->next_record()) {
							//  ist adr mit standardgruppe verknuepft, dann alte referenz loeschen
							$Query ="DELETE FROM ".mnlTABLE_ADR_GRP_REF."  WHERE siteid='".$mnl_siteid."' AND adr_id='".$adr[$acc]['id']."' AND grp_id='".$id."'";
							if ($DB->Query($Query)) {
								$Return=true;
							} else {
								$Return=false;
								return $Return;
							}
						} else {	//oder 
							//  ist adr NICHT mit standardgruppe verknuepft, dann alte referenz mit stdgruppe updaten
							//update der verknuepfung zur alten Gruppe mit der neuen Gruppe...
							$Query ="UPDATE ".mnlTABLE_ADR_GRP_REF." SET grp_id='".$stdGrpID."' WHERE siteid='".$mnl_siteid."' AND grp_id='".$id."'";
							if ($DB->Query($Query)) {
								$Return=true;
							} else {
								$Return=false;
								return $Return;
							}
						}//if
					}//for acc
				//
				}//next record
				
			}//reorg
			
			//echo $deleteAdr;
			if ($deleteAdr==1) {
				$ADR=$this->getAdr(0,0,0,$id);//id,offset,limit,gid
				$ac=count($ADR);
				for ($acc=0;$acc<$ac;$acc++) {
					$this->delAdr($ADR[$acc]['id']);
				}
				$Query ="DELETE FROM ".mnlTABLE_ADR_GRP_REF."  WHERE siteid='".$mnl_siteid."' AND grp_id='".$id."'";
				if ($DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
			}
			
			/* nein historie nicht loeschen! nur wenn nl oder adresse geloescht wird!
			//versandliste, history h loeschen
			$Query ="DELETE FROM nl_h WHERE siteid='".$mnl_siteid."' AND grp_id='".$id."'";
				if ($DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
			
			*/
			
			//aber die q muss geloescht werden!!!
			//q loeschen
			$Query ="DELETE FROM ".mnlTABLE_NL_Q." WHERE siteid='".$mnl_siteid."' AND grp_id='".$id."'";
			if ($DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
			//verknuepfung zu formularen loeschen
			$Query ="DELETE FROM ".mnlTABLE_FRM_GRP_REF."  WHERE siteid='".$mnl_siteid."' AND grp_id='".$id."'";
			if ($DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
			//gruppe loeschen
			$Query ="DELETE FROM ".mnlTABLE_ADR_GRP."  WHERE siteid='".$mnl_siteid."' AND id='".$id."'";
			if ($DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
		}
		return $Return;
	}//delGrp

	function delAdr($id) {
		global $mnl_siteid;
		$Return=false;
		if (check_dbid($id)) {
			$DB=new ConnectDB();
			//versandliste, history h loeschen	
			//ok jetzt historie loeschen! aber nicht wenn adr_grp oder q!
			$Query ="DELETE FROM ".mnlTABLE_NL_H." WHERE siteid='".$mnl_siteid."' AND adr_id='".$id."'";
				if ($DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}		
			//referenzen loeschen
			$Query ="DELETE FROM ".mnlTABLE_ADR_GRP_REF." WHERE siteid='".$mnl_siteid."' AND adr_id='".$id."'";
				if ($DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
			//details loeschen
			$Query ="DELETE FROM ".mnlTABLE_ADR_DETAILS." WHERE siteid='".$mnl_siteid."' AND adr_id='".$id."'";
				if ($DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
			//subscriptions loeschen
			$Query ="DELETE FROM ".mnlTABLE_FRM_S." WHERE siteid='".$mnl_siteid."' AND adr_id='".$id."'";
			if ($DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;			
			}
			//adresse loeschen
			$Query ="DELETE FROM ".mnlTABLE_ADR." WHERE siteid='".$mnl_siteid."' AND id='".$id."'";
			if ($DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
		}
		return $Return;
	}//delAdr
	
	function addAdr($adr,$grp) {
		global $mnl_siteid;
		$Return=false;
		$DB=new ConnectDB();
		//neues Formular speichern
		$Query ="INSERT INTO ".mnlTABLE_ADR." (email,aktiv,status,code,author,created,editor,updated,clicks,views,newsletter,siteid) 
					VALUES ('".$adr["email"]."', '".$adr["aktiv"]."', 
								'".$adr["status"]."', '".$adr["code"]."', '".$adr["author"]."', '".$adr["created"]."', '".$adr["author"]."', '".$adr["created"]."', 0, 0, 0, '".$mnl_siteid."'
								)";
		if ($DB->Query($Query)) {
			$Return=true;
		} else {
			$Return=false;
			return $Return;			
		}
		//Abfragen! und ID suchen, die brauchen wir fuer die Verknuepfung zu den Adressgruppen
		$Query ="SELECT id FROM ".mnlTABLE_ADR." 
					WHERE email='".$adr["email"]."'
					AND status='".$adr["status"]."'
					AND author='".$adr["author"]."'
					AND code='".$adr["code"]."'
					AND aktiv='".$adr["aktiv"]."'
					AND created='".$adr["created"]."'
					AND siteid='".$mnl_siteid."'
					ORDER BY id desc LIMIT 1
					";//es muessen nicht alle felder abgefragt werden, order by id desc limit 1 liefert uns den letzten eintrag ;)
		if ($DB->Query($Query)) {
			$Return=true;
		} else {
			$Return=false;
			return $Return;			
		}
		//wenn ein eintrag gefunden wurde....:
		if ($DB->next_record()) {
			//neue id
			$new_adr_id=$DB->Record['id'];
			//detaildaten eintragen
				$Query="INSERT INTO ".mnlTABLE_ADR_DETAILS." (adr_id,siteid,f0,f1,f2,f3,f4,f5,f6,f7,f8,f9) 
							VALUES ('".$new_adr_id."','".$mnl_siteid."',
										'".$adr['f0']."',
										'".$adr['f1']."',
										'".$adr['f2']."',
										'".$adr['f3']."',
										'".$adr['f4']."',
										'".$adr['f5']."',
										'".$adr['f6']."',
										'".$adr['f7']."',
										'".$adr['f8']."',
										'".$adr['f9']."'
										)";
				if ($DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;			
				}

			//gruppen eintragen
			$acg=count($grp);
			for ($accg=0;$accg<$acg;$accg++) {
				$Query="INSERT INTO ".mnlTABLE_ADR_GRP_REF." (adr_id,grp_id,siteid) VALUES ('".$new_adr_id."','".$grp[$accg]."','".$mnl_siteid."')";
				if ($DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;			
				}
			}
		}
		$Return=$new_adr_id;
		return $Return;			
	}//addAdr
	
	function addRef($adr_id,$grp) {
		global $mnl_siteid;
		$Return=false;
		if (check_dbid($adr_id)) {
			$DB=new ConnectDB();
			//gruppen eintragen
			$acg=count($grp);
			for ($accg=0;$accg<$acg;$accg++) {
				$Query="INSERT INTO ".mnlTABLE_ADR_GRP_REF." (adr_id,grp_id,siteid) VALUES ('".$adr_id."','".$grp[$accg]."','".$mnl_siteid."')";
				if ($DB->Query($Query)) {
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
		global $mnl_siteid;
		$Return=false;
		if (check_dbid($id)) {
			$DB=new ConnectDB();
			$Query ="UPDATE ".mnlTABLE_ADR." SET status='".$status."'
						 WHERE siteid='".$mnl_siteid."' AND id='".$id."'";
			if ($DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
		}
		return $Return;
	}
	
	function unsubscribe($id,$author) {
		global $mnl_siteid;
		$Return=false;
		if (check_dbid($id)) {
			$DB=new ConnectDB();
			$Query ="UPDATE ".mnlTABLE_ADR." SET updated='".date("Y-m-d H:i:s")."', status=11, editor='".$author."'
						 WHERE siteid='".$mnl_siteid."' AND id='".$id."'";
			if ($DB->Query($Query)) {
				$Return=true;
			}
			//$ADDRESS->setStatus($adr_id,11);//unsubscribed
			//^^ machen wir mit nur einer abfrage oben! status=1
		}
		return $Return;
	}

	function updateAdr($adr,$grp) {
		global $mnl_siteid;
		$Return=false;
		if (isset($adr['id']) && check_dbid($adr['id'])) {
			$DB=new ConnectDB();
			$Query ="UPDATE ".mnlTABLE_ADR." SET email='".$adr["email"]."', aktiv='".$adr["aktiv"]."', editor='".$adr["author"]."', updated='".$adr["created"]."'
						 WHERE siteid='".$mnl_siteid."' AND id='".$adr["id"]."'";
			if ($DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
			//details
			$Query ="UPDATE ".mnlTABLE_ADR_DETAILS." SET
						f0='".$adr["f0"]."',
						f1='".$adr["f1"]."',
						f2='".$adr["f2"]."',
						f3='".$adr["f3"]."',
						f4='".$adr["f4"]."',
						f5='".$adr["f5"]."',
						f6='".$adr["f6"]."',
						f7='".$adr["f7"]."',
						f8='".$adr["f8"]."',
						f9='".$adr["f9"]."'
						 WHERE siteid='".$mnl_siteid."' AND adr_id='".$adr["id"]."'";
			if ($DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;			
			}
	
			//alle refs loeschen
			$Query ="DELETE FROM ".mnlTABLE_ADR_GRP_REF." WHERE siteid='".$mnl_siteid."' AND adr_id='".$adr['id']."'";
			if ($DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;			
			}
			//neue refs anlegen
			$acg=count($grp);
			//print_r($grp);
			for ($accg=0;$accg<$acg;$accg++) {
				$Query="INSERT INTO ".mnlTABLE_ADR_GRP_REF." (adr_id,grp_id,siteid) VALUES ('".$adr['id']."','".$grp[$accg]."','".$mnl_siteid."')";
				if ($DB->Query($Query)) {
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
		global $mnl_siteid;
		$Return=false;
		if (check_dbid($id)) {
			$DB=new ConnectDB();
			$Query ="UPDATE ".mnlTABLE_ADR." SET errors='".$errors."'
						 WHERE siteid='".$mnl_siteid."' AND id='".$id."'";
			if ($DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
		}
		return $Return;
	}

	function addClick($adr_id) {
		global $mnl_siteid;
		$Return=false;
		if (check_dbid($adr_id)) {
			$ADR=$this->getADR($adr_id);
			$clicks=$ADR[0]['clicks'];
			$clicks++;
			
			$DB=new ConnectDB();
			$Query ="UPDATE ".mnlTABLE_ADR." SET clicks='".$clicks."' WHERE siteid='".$mnl_siteid."' AND id='".$adr_id."'";
			if ($DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//addClick

	function addView($adr_id) {
		global $mnl_siteid;
		$Return=false;
		if (check_dbid($adr_id)) {
			$ADR=$this->getADR($adr_id);
			$views=$ADR[0]['views'];
			$views++;
			
			$DB=new ConnectDB();
			$Query ="UPDATE ".mnlTABLE_ADR." SET views='".$views."' WHERE siteid='".$mnl_siteid."' AND id='".$adr_id."'";
			if ($DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//addView

	function addNL($adr_id) {
		global $mnl_siteid;
		$Return=false;
		if (check_dbid($adr_id)) {
			$ADR=$this->getADR($adr_id);
			$nl=$ADR[0]['newsletter'];
			$nl++;
		
			$DB=new ConnectDB();
			$Query ="UPDATE ".mnlTABLE_ADR." SET newsletter='".$nl."' WHERE siteid='".$mnl_siteid."' AND id='".$adr_id."'";
			if ($DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//addView


}  //class
?>