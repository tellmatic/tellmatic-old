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


class tm_NL {
	var $NL=Array();
	var $GRP=Array();
	var $DB;
	var $DB2;//2nd connection, e.g. needed to count adr from within getgroup()!

  function tm_NL() {
		$this->DB=new tm_DB();
		$this->DB2=new tm_DB();
  }

	function getNL($id=0,$offset=0,$limit=0,$group_id=0,$return_content=0,$sortIndex="",$sortType=0) {
		$this->NL=Array();
		$Query ="
						SELECT
						id, subject, body,
						created, author, updated, editor,
						link, status, massmail, clicks, views, attm, track_image,
						grp_id, aktiv,
						content_type
						FROM ".TM_TABLE_NL."
						WHERE ".TM_TABLE_NL.".siteid='".TM_SITEID."'
					";
		if (check_dbid($group_id)) {
			$Query .=" AND grp_id='".$group_id."'
						";
		}
		if (check_dbid($id)) {
			$Query .= " AND id='".$id."'";
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
			$this->NL[$ac]['id']=$this->DB->Record['id'];
			$this->NL[$ac]['aktiv']=$this->DB->Record['aktiv'];
			$this->NL[$ac]['created']=$this->DB->Record['created'];
			$this->NL[$ac]['updated']=$this->DB->Record['updated'];
			$this->NL[$ac]['author']=$this->DB->Record['author'];
			$this->NL[$ac]['editor']=$this->DB->Record['editor'];
			$this->NL[$ac]['subject']=$this->DB->Record['subject'];
			if ($return_content==1) {
				$this->NL[$ac]['body']=$this->DB->Record['body'];
			}
			$this->NL[$ac]['status']=$this->DB->Record['status'];
			$this->NL[$ac]['massmail']=$this->DB->Record['massmail'];
			$this->NL[$ac]['grp_id']=$this->DB->Record['grp_id'];
			$this->NL[$ac]['link']=$this->DB->Record['link'];
			$this->NL[$ac]['clicks']=$this->DB->Record['clicks'];
			$this->NL[$ac]['views']=$this->DB->Record['views'];
			$this->NL[$ac]['attm']=$this->DB->Record['attm'];
			$this->NL[$ac]['content_type']=$this->DB->Record['content_type'];
			$this->NL[$ac]['track_image']=$this->DB->Record['track_image'];
			$ac++;
		}
		return $this->NL;
	}//getNL

	function addNL($nl) {
		$Return=false;
		$Query ="INSERT INTO ".TM_TABLE_NL."
						(
						subject,body,aktiv,
						created,author,updated,editor,
						link,grp_id,status,attm,track_image,
						massmail,clicks,views,
						content_type,
						siteid
						)
						VALUES
						(
						'".dbesc($nl["subject"])."', '".dbesc($nl["body"])."', '".dbesc($nl["aktiv"])."',
						'".dbesc($nl["created"])."', '".dbesc($nl["author"])."', '".dbesc($nl["created"])."', '".dbesc($nl["author"])."',
						'".dbesc($nl["link"])."','".dbesc($nl["grp_id"])."','".dbesc($nl["status"])."', '".dbesc($nl["attm"])."', '".dbesc($nl["track_image"])."',
						'".dbesc($nl["massmail"])."', 0, 0,
						'".dbesc($nl["content_type"])."',
						'".TM_SITEID."'
						)";
		if ($this->DB->Query($Query)) {
			$Return=true;
		}
		return $Return;
	}//addNL

	function updateNL($nl) {
		$Return=false;
		if (check_dbid($nl['id'])) {
			$Query ="UPDATE ".TM_TABLE_NL."
						SET subject='".dbesc($nl["subject"])."',
						updated='".dbesc($nl["created"])."',
						editor='".dbesc($nl["author"])."',
						body='".dbesc($nl["body"])."',
						aktiv='".dbesc($nl["aktiv"])."',
						attm='".dbesc($nl["attm"])."',
						track_image='".dbesc($nl["track_image"])."',
						massmail='".dbesc($nl["massmail"])."',
						link='".dbesc($nl["link"])."',
						content_type='".dbesc($nl["content_type"])."',
						grp_id='".dbesc($nl["grp_id"])."'
						WHERE siteid='".TM_SITEID."'
						AND id='".$nl["id"]."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//updateNL

	function delNL($id) {
		$Return=false;
		if (check_dbid($id)) {
			//versandliste, history h loeschen
			//ok historie loeschen!
			$Query ="DELETE FROM ".TM_TABLE_NL_H."
						WHERE siteid='".TM_SITEID."'
						AND nl_id='".$id."'";
				if ($this->DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
			//q loeschen
			$Query ="DELETE FROM ".TM_TABLE_NL_Q."
						WHERE siteid='".TM_SITEID."'
						AND nl_id='".$id."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
			//nl loecshen
			$Query ="DELETE FROM ".TM_TABLE_NL."
						WHERE siteid='".TM_SITEID."'
						AND id='".$id."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
		}
		return $Return;
	}//delNL

	function setAktiv($id=0,$aktiv=1) {
		$Return=false;
		if (check_dbid($id)) {
			
			$Query ="UPDATE ".TM_TABLE_NL."
						SET aktiv='".dbesc($aktiv)."'
						WHERE id='".$id."'
						AND siteid='".TM_SITEID."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//setAktiv

	function setStatus($id,$status) {
		$Return=false;
		if (check_dbid($id)) {
			
			$Query ="UPDATE ".TM_TABLE_NL." SET status='".dbesc($status)."'
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

	function addClick($nl_id) {
		$Return=false;
		if (check_dbid($nl_id)) {
			$NL=$this->getNL($nl_id);
			$clicks=$NL[0]['clicks'];
			$clicks++;

			
			$Query ="UPDATE ".TM_TABLE_NL."
						SET clicks='".$clicks."'
						WHERE siteid='".TM_SITEID."'
						AND id='".$nl_id."'";
			if ($this->DB->Query($Query)) {
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

			
			$Query ="UPDATE ".TM_TABLE_NL."
						SET views='".$views."'
						WHERE siteid='".TM_SITEID."'
						AND id='".$nl_id."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//addView


	function countNL($group_id=0) {
		$count=0;
		$this->NL=Array();
		
		//use this->DB2 !!!!!
		$Query ="
						SELECT count(id) as c
						FROM ".TM_TABLE_NL."
						WHERE siteid='".TM_SITEID."'
					";
		if (check_dbid($group_id)) {
			$Query .=" AND grp_id='".$group_id."'	";
		}
		$this->DB2->Query($Query);
		if ($this->DB2->next_record()) {
			$count=$this->DB2->Record['c'];
		}
		return $count;
	}//counNL

	function getNLID($group_id=0) {
		$this->NL=Array();
		
		$Query ="
							SELECT id
							FROM ".TM_TABLE_NL."
							WHERE siteid='".TM_SITEID."'
						";
			if (check_dbid($group_id)) {
				$Query .=" AND grp_id='".$group_id."'
							";
			}
			$this->DB->Query($Query);
			$ac=0;
			while ($this->DB->next_record()) {
				$this->NL[$ac]['id']=$this->DB->Record['id'];
				$ac++;
			}
		return $this->NL;
	}//getNLID

	function copyNL($id,$copyfiles=1) {
		global $tm_nlpath, $tm_nlimgpath, $tm_nlattachpath, $LOGIN;//, $TM_SITEID
		$Return=false;
		if (check_dbid($id)) {
			$created=date("Y-m-d H:i:s");
			$author=$LOGIN->USER['name'];
			$status=1;
			$NL=$this->getNL($id,0,0,0,1);
			//make a copy
			$NL_copy=$NL[0];
			//change some values
			$NL_copy['subject']="COPY OF ".$NL[0]["subject"];
			$NL_copy['created']=$created;
			$NL_copy['author']=$author;
			$NL_copy['status']=$status;
			//add new NL
			$Return=$this->addNL($NL_copy);
			//thats it
				if ($Return && $copyfiles==1) {
					//trackimage braucht nicht kopiert zu werden da eigen-name
					//bild
					$NL_Imagefile1=$tm_nlimgpath."/nl_".date_convert_to_string($NL[0]['created'])."_1.jpg";
					$NL_Imagefile1_New=$tm_nlimgpath."/nl_".date_convert_to_string($created)."_1.jpg";
					if (file_exists($NL_Imagefile1)) {
						copy($NL_Imagefile1,$NL_Imagefile1_New);
					}
					//atachement
					$NL_Attachfile1=$tm_nlattachpath."/a".date_convert_to_string($NL[0]['created'])."_1.".$NL[0]['attm'];
					$NL_Attachfile1_New=$tm_nlattachpath."/a".date_convert_to_string($created)."_1.".$NL[0]['attm'];
					if (file_exists($NL_Attachfile1)) {
						copy($NL_Attachfile1,$NL_Attachfile1_New);
					}
					//html datei
					$NL_File=$tm_nlpath."/nl_".date_convert_to_string($NL[0]['created']).".html";
					$NL_File_New=$tm_nlpath."/nl_".date_convert_to_string($created).".html";
					if (file_exists($NL_File)) {
						copy($NL_File,$NL_File_New);
					}
					//template
					$NL_File_N=$tm_nlpath."/nl_".date_convert_to_string($NL[0]['created'])."_n.html";
					$NL_File_N_New=$tm_nlpath."/nl_".date_convert_to_string($created)."_n.html";
					if (file_exists($NL_File_N)) {
						copy($NL_File_N,$NL_File_N_New);
					}
					//geparste version
					$NL_File_P=$tm_nlpath."/nl_".date_convert_to_string($NL[0]['created'])."_p.html";
					$NL_File_P_New=$tm_nlpath."/nl_".date_convert_to_string($created)."_p.html";
					if (file_exists($NL_File_P)) {
						copy($NL_File_P,$NL_File_P_New);
					}
				}//if return && copyfiles
		}
		return $Return;
	}//copyNL

//GROUP FUNCTIONS

	function getGroup($id=0,$nl_id=0,$count=0) {
		$this->GRP=Array();
		$Query ="
			SELECT ".TM_TABLE_NL_GRP.".id, ".TM_TABLE_NL_GRP.".name, ".TM_TABLE_NL_GRP.".descr, ".TM_TABLE_NL_GRP.".aktiv, ".TM_TABLE_NL_GRP.".standard,
			".TM_TABLE_NL_GRP.".author,
			".TM_TABLE_NL_GRP.".editor,
			".TM_TABLE_NL_GRP.".created,
			".TM_TABLE_NL_GRP.".updated
			FROM ".TM_TABLE_NL_GRP."
			WHERE ".TM_TABLE_NL_GRP.".siteid='".TM_SITEID."'
			";
		if (check_dbid($id)) {
			$Query .= " AND ".TM_TABLE_NL_GRP.".id='".$id."'";
		}
		if (check_dbid($nl_id)) {
			$Query ="";
			$Query .= "
				SELECT DISTINCT ".TM_TABLE_NL_GRP.".id, ".TM_TABLE_NL_GRP.".name, ".TM_TABLE_NL_GRP.".descr, ".TM_TABLE_NL_GRP.".aktiv, ".TM_TABLE_NL_GRP.".standard,
				".TM_TABLE_NL_GRP.".author,
				".TM_TABLE_NL_GRP.".editor,
				".TM_TABLE_NL_GRP.".created,
				".TM_TABLE_NL_GRP.".updated
				FROM ".TM_TABLE_NL_GRP.", ".TM_TABLE_NL."
				WHERE ".TM_TABLE_NL_GRP.".id=".TM_TABLE_NL.".grp_id
				AND ".TM_TABLE_NL_GRP.".siteid='".TM_SITEID."'
				AND ".TM_TABLE_NL.".siteid='".TM_SITEID."'
				AND ".TM_TABLE_NL.".id='".$nl_id."'
			";
		}
		$Query .= "	ORDER BY ".TM_TABLE_NL_GRP.".name";
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
				$this->GRP[$ac]['nl_count']=$this->countNL($this->GRP[$ac]['id']);
			}
			$ac++;
		}
		return $this->GRP;
	}//getGroup

	function getGroupID() {
		$this->NL=Array();
		$Query ="
						SELECT id
						FROM ".TM_TABLE_NL_GRP."
						WHERE siteid='".TM_SITEID."'
					";
		$this->DB->Query($Query);
		$ac=0;
		while ($this->DB->next_record()) {
			$this->NL[$ac]['id']=$DB->Record['id'];
			$ac++;
		}
		return $this->NL;
	}//getGroupID



	function setGrpAktiv($id=0,$aktiv=1) {
		$Return=false;
		if (check_dbid($id)) {
			$Query ="UPDATE ".TM_TABLE_NL_GRP."
						SET aktiv='".dbesc($aktiv)."'
						WHERE id='".$id."'
						AND siteid='".TM_SITEID."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//setGrpAktiv

	function setGrpStd($id=0) {
		$Return=false;
		if (check_dbid($id)) {
			$Query ="UPDATE ".TM_TABLE_NL_GRP."
						SET standard=0
						WHERE standard=1
						AND siteid='".TM_SITEID."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
			$Query ="UPDATE ".TM_TABLE_NL_GRP."
						SET standard=1
						WHERE id='".$id."'
						AND siteid='".TM_SITEID."'";
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
		$Query ="INSERT INTO ".TM_TABLE_NL_GRP."
					(
					name,descr,
					aktiv,standard,
					created,author,
					updated,editor,
					siteid
					)
					VALUES
					(
					'".dbesc($group["name"])."', '".dbesc($group["descr"])."',
					'".dbesc($group["aktiv"])."', 0,
					'".dbesc($group["created"])."', '".dbesc($group["author"])."',
					'".dbesc($group["created"])."', '".dbesc($group["author"])."',
					 '".TM_SITEID."'
					)";
		if ($this->DB->Query($Query)) {
			$Return=true;
		}
		return $Return;
	}//addGrp

	function updateGrp($group) {
		$Return=false;
		if (check_dbid($group['id'])) {
			$Query ="UPDATE ".TM_TABLE_NL_GRP."
						SET name='".dbesc($group["name"])."',
						descr='".dbesc($group["descr"])."',
						aktiv='".dbesc($group["aktiv"])."' ,
						updated='".dbesc($group["created"])."',
						editor='".dbesc($group["author"])."'
						WHERE siteid='".TM_SITEID."'
						AND id='".$group["id"]."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//updateGrp

	function delGrp($id) {
		$Return=false;
		if (check_dbid($id)) {
			
			//standard gruppe suchen
			$Query ="SELECT id
					FROM ".TM_TABLE_NL_GRP."
					WHERE siteid='".TM_SITEID."'
					AND standard=1";
			if ($this->DB->Query($Query)) {
				$Return=true;
			}
			//wenn standardgruppe gefunden, weitermachen, ansonsten nichts tun!!!
			//loeschen geht nur wenn eine std gruppe definiert
			// wurde welche die NL aus zu loeschender Gruppe zugeordnet werden koennen
			if ($this->DB->next_record()) {
				$stdGrpID=$this->DB->Record['id'];
				//newsletter der stdgruppe neu zuordnen
				$Query ="UPDATE ".TM_TABLE_NL." SET
							grp_id='".$stdGrpID."'
							WHERE siteid='".TM_SITEID."'
							AND grp_id='".$id."'";
				if ($this->DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
				//gruppe loeschen
				$Query ="DELETE FROM ".TM_TABLE_NL_GRP."
							WHERE siteid='".TM_SITEID."'
							AND id='".$id."'";
				if ($this->DB->Query($Query)) {
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

function convertNL2Text($html,$type) {
	$text=$html;
	if ($type=="html" || $type=="text/html") {
		$htmlToText=new Html2Text($html, 80);//class has apache license, may be in conflict with gpl???
	    $text=$htmlToText->convert();
		$text = preg_replace('~<[^>]+>~', '', $text); // remove any HTML tags that are still left
	}
	return $text;
}

} //class
?>