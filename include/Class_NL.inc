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


class mnlNL {  
	var $NL=Array();
	var $GRP=Array();
  
	function getNL($id=0,$offset=0,$limit=0,$group_id=0,$return_content=0,$sortIndex="",$sortType=0) {
		$this->NL=Array();
		$DB=new ConnectDB();
		$Query ="
						SELECT 
						id, subject, body, 
						created, author, updated, editor, 
						link, status, massmail, clicks, views, attm,
						grp_id, aktiv
						FROM ".mnlTABLE_NL."
						WHERE ".mnlTABLE_NL.".siteid='".MNL_SITEID."'
					";
		if (check_dbid($group_id)) {
			$Query .=" AND grp_id='".$group_id."'
						";
		}
		if (check_dbid($id)) {
			$Query .= " AND id='".$id."'";
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
			$this->NL[$ac]['id']=$DB->Record['id'];
			$this->NL[$ac]['aktiv']=$DB->Record['aktiv'];
			$this->NL[$ac]['created']=$DB->Record['created'];
			$this->NL[$ac]['updated']=$DB->Record['updated'];
			$this->NL[$ac]['author']=$DB->Record['author'];
			$this->NL[$ac]['editor']=$DB->Record['editor'];
			$this->NL[$ac]['subject']=$DB->Record['subject'];
			if ($return_content==1) {
				$this->NL[$ac]['body']=$DB->Record['body'];
			}
			$this->NL[$ac]['status']=$DB->Record['status'];
			$this->NL[$ac]['massmail']=$DB->Record['massmail'];
			$this->NL[$ac]['grp_id']=$DB->Record['grp_id'];
			$this->NL[$ac]['link']=$DB->Record['link'];
			$this->NL[$ac]['clicks']=$DB->Record['clicks'];
			$this->NL[$ac]['views']=$DB->Record['views'];
			$this->NL[$ac]['attm']=$DB->Record['attm'];
			$ac++;
		} 
		return $this->NL;  
	}//getNL


	function countNL($group_id=0) {
		$count=0;
		$this->NL=Array();
		$DB=new ConnectDB();
		$Query ="
						SELECT count(id) as c
						FROM ".mnlTABLE_NL."
						WHERE siteid='".MNL_SITEID."'
					";
		if (check_dbid($group_id)) { 
			$Query .=" AND grp_id='".$group_id."'	";
		}
		$DB->Query($Query);
		if ($DB->next_record()) {
			$count=$DB->Record['c'];
		} 
		return $count;  
	}//counNL

	function getNLID($group_id=0) {
		$this->NL=Array();
		if (check_dbid($group_id)) {
			$DB=new ConnectDB();
			$Query ="
							SELECT id
							FROM ".mnlTABLE_NL."
							WHERE siteid='".MNL_SITEID."'
						";
			if ($group_id!=0) {
				$Query .=" AND grp_id='".$group_id."'
							";
			}
			$DB->Query($Query);
			$ac=0;
			while ($DB->next_record()) {
				$this->NL[$ac]['id']=$DB->Record['id'];
				$ac++;
			} 
		}
		return $this->NL;  
	}//getNLID



	function getGroup($id=0,$nl_id=0,$count=0) {
		$this->GRP=Array();
		$DB=new ConnectDB();
		$Query ="
			SELECT ".mnlTABLE_NL_GRP.".id, ".mnlTABLE_NL_GRP.".name, ".mnlTABLE_NL_GRP.".descr, ".mnlTABLE_NL_GRP.".aktiv, ".mnlTABLE_NL_GRP.".standard
			FROM ".mnlTABLE_NL_GRP."
			WHERE ".mnlTABLE_NL_GRP.".siteid='".MNL_SITEID."'
			";
		if (check_dbid($id)) {
			$Query .= " AND ".mnlTABLE_NL_GRP.".id='".$id."'";
		}
		if (check_dbid($nl_id)) {
			$Query ="";
			$Query .= " 
				SELECT DISTINCT ".mnlTABLE_NL_GRP.".id, ".mnlTABLE_NL_GRP.".name, ".mnlTABLE_NL_GRP.".descr, ".mnlTABLE_NL_GRP.".aktiv, ".mnlTABLE_NL_GRP.".standard
				FROM ".mnlTABLE_NL_GRP.", ".mnlTABLE_NL."
				WHERE ".mnlTABLE_NL_GRP.".id=".mnlTABLE_NL.".grp_id
				AND ".mnlTABLE_NL_GRP.".siteid='".MNL_SITEID."'
				AND ".mnlTABLE_NL.".siteid='".MNL_SITEID."'
				AND ".mnlTABLE_NL.".id='".$nl_id."'
			";
		}
		$Query .= "	ORDER BY ".mnlTABLE_NL_GRP.".name";
		$DB->Query($Query);
		$ac=0;
		while ($DB->next_record()) {
			$this->GRP[$ac]['id']=$DB->Record['id'];
			$this->GRP[$ac]['name']=$DB->Record['name'];
			$this->GRP[$ac]['descr']=$DB->Record['descr'];
			$this->GRP[$ac]['aktiv']=$DB->Record['aktiv'];
			$this->GRP[$ac]['standard']=$DB->Record['standard'];
			if ($count==1) {
				$this->GRP[$ac]['nl_count']=$this->countNL($this->GRP[$ac]['id']);
			}
			$ac++;
		} 
		return $this->GRP;
	}//getGroup

	function getGroupID() {
		$this->NL=Array();
		$DB=new ConnectDB();
		$Query ="
						SELECT id
						FROM ".mnlTABLE_NL_GRP."
						WHERE siteid='".MNL_SITEID."'
					";
		$DB->Query($Query);
		$ac=0;
		while ($DB->next_record()) {
			$this->NL[$ac]['id']=$DB->Record['id'];
			$ac++;
		} 
		return $this->NL;  
	}//getGroupID


	function setAktiv($id=0,$aktiv=1) {
		$Return=false;
		if (check_dbid($id)) {
			$DB=new ConnectDB();
			$Query ="UPDATE ".mnlTABLE_NL." 
						SET aktiv='".$aktiv."' 
						WHERE id='".$id."' 
						AND siteid='".MNL_SITEID."'";
			if ($DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//setAktiv

	function copyNL($id,$copyfiles=1) {
		global $mnl_nlpath, $mnl_nlimgpath, $mnl_nlattachpath, $_SERVER;//, $mnl_siteid
		$Return=false;
		if (check_dbid($id)) {
			$created=date("Y-m-d H:i:s");
			$author=$_SERVER['PHP_AUTH_USER'];
			$status=1;
			$NL=$this->getNL($id,0,0,0,1);
			$this->addNL(Array(
				"subject"=>"COPY OF ".$NL[0]["subject"], 
				"body"=>$NL[0]["body"], 
				"aktiv"=>$NL[0]["aktiv"], 
				"created"=>$created,
				"author"=>$author,
				"status"=>$status,
				"massmail"=>$NL[0]["massmail"], 
				"link"=>$NL[0]["link"], 
				"attm"=>$NL[0]["attm"], 
				"grp_id"=>$NL[0]["grp_id"])
				);
				if ($copyfiles==1) {
					//bild
					$NL_Imagefile1=$mnl_nlimgpath."/nl_".date_convert_to_string($NL[0]['created'])."_1.jpg";
					$NL_Imagefile1_New=$mnl_nlimgpath."/nl_".date_convert_to_string($created)."_1.jpg";
					if (file_exists($NL_Imagefile1)) {
						copy($NL_Imagefile1,$NL_Imagefile1_New);
					}
					//atachement
					$NL_Attachfile1=$mnl_nlattachpath."/a".date_convert_to_string($NL[0]['created'])."_1.".$NL[0]['attm'];
					$NL_Attachfile1_New=$mnl_nlattachpath."/a".date_convert_to_string($created)."_1.".$NL[0]['attm'];
					if (file_exists($NL_Attachfile1)) {
						copy($NL_Attachfile1,$NL_Attachfile1_New);
					}
					//html datei
					$NL_File=$mnl_nlpath."/nl_".date_convert_to_string($NL[0]['created']).".html";
					$NL_File_New=$mnl_nlpath."/nl_".date_convert_to_string($created).".html";
					if (file_exists($NL_File)) {
						copy($NL_File,$NL_File_New);
					}
					//template
					$NL_File_N=$mnl_nlpath."/nl_".date_convert_to_string($NL[0]['created'])."_n.html";
					$NL_File_N_New=$mnl_nlpath."/nl_".date_convert_to_string($created)."_n.html";
					if (file_exists($NL_File_N)) {
						copy($NL_File_N,$NL_File_N_New);
					}
					//geparste version
					$NL_File_P=$mnl_nlpath."/nl_".date_convert_to_string($NL[0]['created'])."_p.html";
					$NL_File_P_New=$mnl_nlpath."/nl_".date_convert_to_string($created)."_p.html";
					if (file_exists($NL_File_P)) {
						copy($NL_File_P,$NL_File_P_New);
					}
				}
			$Return=true;
		}
		return $Return;
	}//copyNL

	function setGrpAktiv($id=0,$aktiv=1) {
		$Return=false;
		if (check_dbid($id)) {
			$DB=new ConnectDB();
			$Query ="UPDATE ".mnlTABLE_NL_GRP." 
						SET aktiv='".$aktiv."' 
						WHERE id='".$id."' 
						AND siteid='".MNL_SITEID."'";
			if ($DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//setGrpAktiv
	
	function setGrpStd($id=0) {
		$Return=false;
		if (check_dbid($id)) {
			$DB=new ConnectDB();
			$Query ="UPDATE ".mnlTABLE_NL_GRP." 
						SET standard=0 
						WHERE standard=1 
						AND siteid='".MNL_SITEID."'";
			if ($DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
			$Query ="UPDATE ".mnlTABLE_NL_GRP." 
						SET standard=1 
						WHERE id='".$id."' 
						AND siteid='".MNL_SITEID."'";
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
		$Return=false;
		$DB=new ConnectDB();
		$Query ="INSERT INTO ".mnlTABLE_NL_GRP." 
					(
					name,descr,
					aktiv,standard,siteid
					) 
					VALUES 
					(
					'".$group["name"]."', '".$group["descr"]."',
					'".$group["aktiv"]."', 0, '".MNL_SITEID."'
					)";
		if ($DB->Query($Query)) {
			$Return=true;
		}
		return $Return;
	}//addGrp

	function updateGrp($group) {
		$Return=false;
		if (check_dbid($group['id'])) {
			$DB=new ConnectDB();
			$Query ="UPDATE ".mnlTABLE_NL_GRP." 
						SET name='".$group["name"]."', 
						descr='".$group["descr"]."', 
						aktiv='".$group["aktiv"]."' 
						WHERE siteid='".MNL_SITEID."' 
						AND id='".$group["id"]."'";
			if ($DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//updateGrp

	function delGrp($id) {
		$Return=false;
		if (check_dbid($id)) {
			$DB=new ConnectDB();
			//standard gruppe suchen
			$Query ="SELECT id 
					FROM ".mnlTABLE_NL_GRP." 
					WHERE siteid='".MNL_SITEID."' 
					AND standard=1";
			if ($DB->Query($Query)) {
				$Return=true;
			}
			//wenn standardgruppe gefunden, weitermachen, ansonsten nichts tun!!! 
			//loeschen geht nur wenn eine std gruppe definiert 
			// wurde welche die NL aus zu loeschender Gruppe zugeordnet werden koennen
			if ($DB->next_record()) {
				$stdGrpID=$DB->Record['id'];
				//newsletter der stdgruppe neu zuordnen
				$Query ="UPDATE ".mnlTABLE_NL." SET 
							grp_id='".$stdGrpID."' 
							WHERE siteid='".MNL_SITEID."' 
							AND grp_id='".$id."'";
				if ($DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
				//gruppe loeschen
				$Query ="DELETE FROM ".mnlTABLE_NL_GRP." 
							WHERE siteid='".MNL_SITEID."' 
							AND id='".$id."'";
				if ($DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
			} else {
				$Return=false;
			}
		}
		return $Return;
	}//delGrp

	function delNL($id) {
		$Return=false;
		if (check_dbid($id)) {
			$DB=new ConnectDB();
			//versandliste, history h loeschen
			
			//ok historie loeschen!
			$Query ="DELETE FROM ".mnlTABLE_NL_H." 
						WHERE siteid='".MNL_SITEID."' 
						AND nl_id='".$id."'";
				if ($DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
			//q loeschen
			$Query ="DELETE FROM ".mnlTABLE_NL_Q." 
						WHERE siteid='".MNL_SITEID."' 
						AND nl_id='".$id."'";
			if ($DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
			//nl loecshen
			$Query ="DELETE FROM ".mnlTABLE_NL." 
						WHERE siteid='".MNL_SITEID."' 
						AND id='".$id."'";
			if ($DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
		}
		return $Return;
	}//delNL

	function addNL($nl) {
		$Return=false;
		$DB=new ConnectDB();
		$Query ="INSERT INTO ".mnlTABLE_NL." 
						(
						subject,body,aktiv,
						created,author,updated,editor,
						link,grp_id,status,attm,
						massmail,clicks,views,
						siteid
						) 
						VALUES 
						(
						'".$nl["subject"]."', '".$nl["body"]."', '".$nl["aktiv"]."',
						'".$nl["created"]."', '".$nl["author"]."', '".$nl["created"]."', '".$nl["author"]."',
						'".$nl["link"]."','".$nl["grp_id"]."','".$nl["status"]."', '".$nl["attm"]."',
						'".$nl["massmail"]."', 0, 0,
						'".MNL_SITEID."'
						)";
		if ($DB->Query($Query)) {
			$Return=true;
		}
		return $Return;
	}//addNL

	function setStatus($id,$status) {
		$Return=false;
		if (check_dbid($id)) {
			$DB=new ConnectDB();
			$Query ="UPDATE ".mnlTABLE_NL." SET status='".$status."'
						 WHERE siteid='".MNL_SITEID."' AND id='".$id."'";
			if ($DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
		}
		return $Return;
	}
	
	function updateNL($nl) {
		$Return=false;
		if (check_dbid($nl['id'])) {
			$DB=new ConnectDB();
			$Query ="UPDATE ".mnlTABLE_NL." 
						SET subject='".$nl["subject"]."', 
						updated='".$nl["created"]."', 
						editor='".$nl["author"]."', 
						body='".$nl["body"]."', 
						aktiv='".$nl["aktiv"]."', 
						attm='".$nl["attm"]."', 
						massmail='".$nl["massmail"]."', 
						link='".$nl["link"]."', 
						grp_id='".$nl["grp_id"]."' 
						WHERE siteid='".MNL_SITEID."' 
						AND id='".$nl["id"]."'";
			if ($DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//updateNL

	function addClick($nl_id) {
		$Return=false;
		if (check_dbid($nl_id)) {
			$NL=$this->getNL($nl_id);
			$clicks=$NL[0]['clicks'];
			$clicks++;
			
			$DB=new ConnectDB();
			$Query ="UPDATE ".mnlTABLE_NL." 
						SET clicks='".$clicks."' 
						WHERE siteid='".MNL_SITEID."' 
						AND id='".$nl_id."'";
			if ($DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//addClick

	function addView($nl_id) {
		$Return=false;
		if (check_dbid($nl_id)) {
			$NL=$this->getNL($nl_id);
			$views=$NL[0]['views'];
			$views++;
			
			$DB=new ConnectDB();
			$Query ="UPDATE ".mnlTABLE_NL." 
						SET views='".$views."' 
						WHERE siteid='".MNL_SITEID."' 
						AND id='".$nl_id."'";
			if ($DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//addView

} //class
?>