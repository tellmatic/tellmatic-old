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


class mnlFRM {  
	var $FORM=Array();
  
	function getForm($id=0,$offset=0,$limit=0,$group_id=0,$sortIndex="",$sortType=0) {
		$this->FRM=Array();
		$DB=new ConnectDB();
		$Query ="	SELECT ".mnlTABLE_FRM.".id, ".mnlTABLE_FRM.".name, ".mnlTABLE_FRM.".descr, ".mnlTABLE_FRM.".aktiv, ".mnlTABLE_FRM.".author, ".mnlTABLE_FRM.".created, ".mnlTABLE_FRM.".editor, ".mnlTABLE_FRM.".updated, ".mnlTABLE_FRM.".double_optin, ".mnlTABLE_FRM.".subscriptions,
						".mnlTABLE_FRM.".f0, ".mnlTABLE_FRM.".f1, ".mnlTABLE_FRM.".f2, ".mnlTABLE_FRM.".f3, ".mnlTABLE_FRM.".f4, ".mnlTABLE_FRM.".f5, ".mnlTABLE_FRM.".f6, ".mnlTABLE_FRM.".f7, ".mnlTABLE_FRM.".f8, ".mnlTABLE_FRM.".f9,
						".mnlTABLE_FRM.".f0_type, ".mnlTABLE_FRM.".f1_type, ".mnlTABLE_FRM.".f2_type, ".mnlTABLE_FRM.".f3_type, ".mnlTABLE_FRM.".f4_type, ".mnlTABLE_FRM.".f5_type, ".mnlTABLE_FRM.".f6_type, ".mnlTABLE_FRM.".f7_type, ".mnlTABLE_FRM.".f8_type, ".mnlTABLE_FRM.".f9_type,
						".mnlTABLE_FRM.".f0_required, ".mnlTABLE_FRM.".f1_required, ".mnlTABLE_FRM.".f2_required, ".mnlTABLE_FRM.".f3_required, ".mnlTABLE_FRM.".f4_required, ".mnlTABLE_FRM.".f5_required, ".mnlTABLE_FRM.".f6_required, ".mnlTABLE_FRM.".f7_required, ".mnlTABLE_FRM.".f8_required, ".mnlTABLE_FRM.".f9_required,
						".mnlTABLE_FRM.".f0_value, ".mnlTABLE_FRM.".f1_value, ".mnlTABLE_FRM.".f2_value, ".mnlTABLE_FRM.".f3_value, ".mnlTABLE_FRM.".f4_value, ".mnlTABLE_FRM.".f5_value, ".mnlTABLE_FRM.".f6_value, ".mnlTABLE_FRM.".f7_value, ".mnlTABLE_FRM.".f8_value, ".mnlTABLE_FRM.".f9_value
						FROM ".mnlTABLE_FRM." 
					";
		if (check_dbid($group_id)) {
			$Query .="LEFT JOIN ".mnlTABLE_FRM_GRP_REF." ON ".mnlTABLE_FRM.".id = ".mnlTABLE_FRM_GRP_REF.".frm_id";
		}
		$Query .=" WHERE ".mnlTABLE_FRM.".siteid='".MNL_SITEID."'";
		if ($group_id!=0) {
			$Query .=" AND ".mnlTABLE_FRM_GRP_REF.".siteid='".MNL_SITEID."'
						  AND ".mnlTABLE_FRM_GRP_REF.".grp_id='".$group_id."'
						";
		}
						//achtung, durch AND adr_details.siteid='".MNL_SITEID."' werden nur die eintraege angezeigt die auch eien detaildatensatz haben!!!
		if (check_dbid($id)) {
			$Query .= " AND ".mnlTABLE_FRM.".id='".$id."'";
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
			$this->FORM[$ac]['id']=$DB->Record['id'];
			$this->FORM[$ac]['name']=$DB->Record['name'];
			$this->FORM[$ac]['aktiv']=$DB->Record['aktiv'];
			$this->FORM[$ac]['descr']=$DB->Record['descr'];
			$this->FORM[$ac]['author']=$DB->Record['author'];
			$this->FORM[$ac]['created']=$DB->Record['created'];
			$this->FORM[$ac]['editor']=$DB->Record['editor'];
			$this->FORM[$ac]['updated']=$DB->Record['updated'];
			$this->FORM[$ac]['double_optin']=$DB->Record['double_optin'];
			$this->FORM[$ac]['subscriptions']=$DB->Record['subscriptions'];
			$this->FORM[$ac]['f0']=$DB->Record['f0'];
			$this->FORM[$ac]['f1']=$DB->Record['f1'];
			$this->FORM[$ac]['f2']=$DB->Record['f2'];
			$this->FORM[$ac]['f3']=$DB->Record['f3'];
			$this->FORM[$ac]['f4']=$DB->Record['f4'];
			$this->FORM[$ac]['f5']=$DB->Record['f5'];
			$this->FORM[$ac]['f6']=$DB->Record['f6'];
			$this->FORM[$ac]['f7']=$DB->Record['f7'];
			$this->FORM[$ac]['f8']=$DB->Record['f8'];
			$this->FORM[$ac]['f9']=$DB->Record['f9'];
			$this->FORM[$ac]['f0_type']=$DB->Record['f0_type'];
			$this->FORM[$ac]['f1_type']=$DB->Record['f1_type'];
			$this->FORM[$ac]['f2_type']=$DB->Record['f2_type'];
			$this->FORM[$ac]['f3_type']=$DB->Record['f3_type'];
			$this->FORM[$ac]['f4_type']=$DB->Record['f4_type'];
			$this->FORM[$ac]['f5_type']=$DB->Record['f5_type'];
			$this->FORM[$ac]['f6_type']=$DB->Record['f6_type'];
			$this->FORM[$ac]['f7_type']=$DB->Record['f7_type'];
			$this->FORM[$ac]['f8_type']=$DB->Record['f8_type'];
			$this->FORM[$ac]['f9_type']=$DB->Record['f9_type'];
			$this->FORM[$ac]['f0_required']=$DB->Record['f0_required'];
			$this->FORM[$ac]['f1_required']=$DB->Record['f1_required'];
			$this->FORM[$ac]['f2_required']=$DB->Record['f2_required'];
			$this->FORM[$ac]['f3_required']=$DB->Record['f3_required'];
			$this->FORM[$ac]['f4_required']=$DB->Record['f4_required'];
			$this->FORM[$ac]['f5_required']=$DB->Record['f5_required'];
			$this->FORM[$ac]['f6_required']=$DB->Record['f6_required'];
			$this->FORM[$ac]['f7_required']=$DB->Record['f7_required'];
			$this->FORM[$ac]['f8_required']=$DB->Record['f8_required'];
			$this->FORM[$ac]['f9_required']=$DB->Record['f9_required'];
			$this->FORM[$ac]['f0_value']=$DB->Record['f0_value'];
			$this->FORM[$ac]['f1_value']=$DB->Record['f1_value'];
			$this->FORM[$ac]['f2_value']=$DB->Record['f2_value'];
			$this->FORM[$ac]['f3_value']=$DB->Record['f3_value'];
			$this->FORM[$ac]['f4_value']=$DB->Record['f4_value'];
			$this->FORM[$ac]['f5_value']=$DB->Record['f5_value'];
			$this->FORM[$ac]['f6_value']=$DB->Record['f6_value'];
			$this->FORM[$ac]['f7_value']=$DB->Record['f7_value'];
			$this->FORM[$ac]['f8_value']=$DB->Record['f8_value'];
			$this->FORM[$ac]['f9_value']=$DB->Record['f9_value'];
			
			$ac++;
		} 
		return $this->FORM;  
	}//getForm

	function setAktiv($id=0,$aktiv=1) {
		$Return=false;
		if (check_dbid($id)) {
			$DB=new ConnectDB();
			$Query ="UPDATE ".mnlTABLE_FRM." SET aktiv='".$aktiv."' WHERE id='".$id."' AND siteid='".MNL_SITEID."'";
			if ($DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//setAktiv
	
	function copyForm($id) {
		global $_SERVER;//, $mnl_siteid
	
		$Return=false;
		if (check_dbid($id)) {
			$created=date("Y-m-d H:i:s");
			$author=$_SERVER['PHP_AUTH_USER'];
			$FRM=$this->getForm($id);
			$ADDRESS=new mnlADR();
			$adr_grp=$ADDRESS->getGroupID(0,0,$id);
			$Return=$this->addForm(Array(
				"name"=>"COPY OF ".$FRM[0]["name"], 
				"descr"=>$FRM[0]["descr"], 
				"aktiv"=>$FRM[0]["aktiv"], 
				"created"=>$created, 
				"author"=>$author, 
				"double_optin"=>$FRM[0]["double_optin"],
				"f0"=>$FRM[0]["f0"],
				"f1"=>$FRM[0]["f1"],
				"f2"=>$FRM[0]["f2"],
				"f3"=>$FRM[0]["f3"],
				"f4"=>$FRM[0]["f4"],
				"f5"=>$FRM[0]["f5"],
				"f6"=>$FRM[0]["f6"],
				"f7"=>$FRM[0]["f7"],
				"f8"=>$FRM[0]["f8"],
				"f9"=>$FRM[0]["f9"],
				"f0_type"=>$FRM[0]["f0_type"],
				"f1_type"=>$FRM[0]["f1_type"],
				"f2_type"=>$FRM[0]["f2_type"],
				"f3_type"=>$FRM[0]["f3_type"],
				"f4_type"=>$FRM[0]["f4_type"],
				"f5_type"=>$FRM[0]["f5_type"],
				"f6_type"=>$FRM[0]["f6_type"],
				"f7_type"=>$FRM[0]["f7_type"],
				"f8_type"=>$FRM[0]["f8_type"],
				"f9_type"=>$FRM[0]["f9_type"],
				"f0_required"=>$FRM[0]["f0_required"],
				"f1_required"=>$FRM[0]["f1_required"],
				"f2_required"=>$FRM[0]["f2_required"],
				"f3_required"=>$FRM[0]["f3_required"],
				"f4_required"=>$FRM[0]["f4_required"],
				"f5_required"=>$FRM[0]["f5_required"],
				"f6_required"=>$FRM[0]["f6_required"],
				"f7_required"=>$FRM[0]["f7_required"],
				"f8_required"=>$FRM[0]["f8_required"],
				"f9_required"=>$FRM[0]["f9_required"],
				"f0_value"=>$FRM[0]["f0_value"],
				"f1_value"=>$FRM[0]["f1_value"],
				"f2_value"=>$FRM[0]["f2_value"],
				"f3_value"=>$FRM[0]["f3_value"],
				"f4_value"=>$FRM[0]["f4_value"],
				"f5_value"=>$FRM[0]["f5_value"],
				"f6_value"=>$FRM[0]["f6_value"],
				"f7_value"=>$FRM[0]["f7_value"],
				"f8_value"=>$FRM[0]["f8_value"],
				"f9_value"=>$FRM[0]["f9_value"]
				),
				$adr_grp);
		}
		return $Return;
	}//copyForm

	function delForm($id) {
		$Return=false;
		if (check_dbid($id)) {
			$DB=new ConnectDB();
			//referenzen loeschen
			$Query ="DELETE FROM ".mnlTABLE_FRM_GRP_REF." WHERE siteid='".MNL_SITEID."' AND frm_id='".$id."'";
			if ($DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;			
			}
			//subscriptions loeschen
			$Query ="DELETE FROM ".mnlTABLE_FRM_S." WHERE siteid='".MNL_SITEID."' AND frm_id='".$id."'";
			if ($DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;			
			}
	
			//formular loeschen
			$Query ="DELETE FROM ".mnlTABLE_FRM." WHERE siteid='".MNL_SITEID."' AND id='".$id."'";
			if ($DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;			
			}
		}
		return $Return;
	}//delForm
	
	function addForm($frm,$grp) {
		global $mnl_formpath, $mnl_tplpath, $mnl_URL;//, $mnl_siteid
		$Return=false;
		$DB=new ConnectDB();
		//neues Formular speichern
		$Query ="INSERT INTO 
					".mnlTABLE_FRM." 
					(
					name,descr,aktiv,author,created,editor,updated,double_optin,subscriptions,siteid,
					f0,f1,f2,f3,f4,f5,f6,f7,f8,f9,
					f0_type, f1_type, f2_type, f3_type, f4_type, f5_type, f6_type, f7_type, f8_type, f9_type,
					f0_required, f1_required, f2_required, f3_required, f4_required, f5_required, f6_required, f7_required, f8_required, f9_required,
					f0_value, f1_value, f2_value, f3_value, f4_value, f5_value, f6_value, f7_value, f8_value, f9_value
					) 
					VALUES 
					(
					'".$frm["name"]."', '".$frm["descr"]."', '".$frm["aktiv"]."', '".$frm["author"]."', '".$frm["created"]."', '".$frm["author"]."', '".$frm["created"]."', '".$frm["double_optin"]."', 0, '".MNL_SITEID."',
					'".$frm["f0"]."',
					'".$frm["f1"]."',
					'".$frm["f2"]."',
					'".$frm["f3"]."',
					'".$frm["f4"]."',
					'".$frm["f5"]."',
					'".$frm["f6"]."',
					'".$frm["f7"]."',
					'".$frm["f8"]."',
					'".$frm["f9"]."',
					'".$frm["f0_type"]."',
					'".$frm["f1_type"]."',
					'".$frm["f2_type"]."',
					'".$frm["f3_type"]."',
					'".$frm["f4_type"]."',
					'".$frm["f5_type"]."',
					'".$frm["f6_type"]."',
					'".$frm["f7_type"]."',
					'".$frm["f8_type"]."',
					'".$frm["f9_type"]."',
					'".$frm["f0_required"]."',
					'".$frm["f1_required"]."',
					'".$frm["f2_required"]."',
					'".$frm["f3_required"]."',
					'".$frm["f4_required"]."',
					'".$frm["f5_required"]."',
					'".$frm["f6_required"]."',
					'".$frm["f7_required"]."',
					'".$frm["f8_required"]."',
					'".$frm["f9_required"]."',
					'".$frm["f0_value"]."',
					'".$frm["f1_value"]."',
					'".$frm["f2_value"]."',
					'".$frm["f3_value"]."',
					'".$frm["f4_value"]."',
					'".$frm["f5_value"]."',
					'".$frm["f6_value"]."',
					'".$frm["f7_value"]."',
					'".$frm["f8_value"]."',
					'".$frm["f9_value"]."'					
					)";
		if ($DB->Query($Query)) {
			$Return=true;
		} else {
			$Return=false;
			return $Return;			
		}
		//Abfragen! und ID suchen, die brauchen wir fuer die Verknuepfung zu den Adressgruppen
		$Query ="SELECT id FROM ".mnlTABLE_FRM." 
					WHERE name='".$frm["name"]."'
					AND descr='".$frm["descr"]."'
					AND aktiv='".$frm["aktiv"]."'
					AND siteid='".MNL_SITEID."'
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
			$new_frm_id=$DB->Record['id'];
			//gruppen eintragen
			$acg=count($grp);
			for ($accg=0;$accg<$acg;$accg++) {
				$Query="INSERT INTO ".mnlTABLE_FRM_GRP_REF." (frm_id,grp_id,siteid) VALUES ('".$new_frm_id."','".$grp[$accg]."','".MNL_SITEID."')";
				if ($DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;			
				}
			}
		}
		
		//jetzt die Formularvorlage speichern!
		//templatevariablen einfuegen etc.
		//namen der Felder einschreiben wenn angegeben
		//nur angegebene Felder!
		$Form_Filename_TPL="/Form.html";
		$Form_Filename_S_TPL="/Form_s.html";
		$Form_Filename_O_TPL="/Form_o.html";
		$Form_Filename_OS_TPL="/Form_os.html";
		$Form_Filename="/Form_".$new_frm_id.".html";
		$Form_Filename_S="/Form_".$new_frm_id."_s.html";
		$Form_Filename_P="/Form_".$new_frm_id."_p.html";
		$Form_Filename_O="/Form_".$new_frm_id."_o.html";
		$Form_Filename_OS="/Form_".$new_frm_id."_os.html";

		$_Tpl_FRM=new mTemplate();
		$_Tpl_FRM->setTemplatePath($mnl_tplpath);

		//Formular Template erzeugen
		$Form_Html=$_Tpl_FRM->renderTemplate($Form_Filename_TPL);		
		write_file($mnl_formpath,$Form_Filename,$Form_Html);		
		//Formular Template erzeugen, Meldung wenn subscribed
		$Form_S_Html=$_Tpl_FRM->renderTemplate($Form_Filename_S_TPL);		
		write_file($mnl_formpath,$Form_Filename_S,$Form_S_Html);
		//Formular Template erzeugen, OptinMail
		$Form_O_Html=$_Tpl_FRM->renderTemplate($Form_Filename_O_TPL);
		write_file($mnl_formpath,$Form_Filename_O,$Form_O_Html);
		
		//Formular Template erzeugen, OptinMail nach Bestaetigung
		$Form_OS_Html=$_Tpl_FRM->renderTemplate($Form_Filename_OS_TPL);
		write_file($mnl_formpath,$Form_Filename_OS,$Form_OS_Html);
		
		//geparste Version:
		/*
		$Form_P=file_get_contents($mnl_URL."/subscribe.php?fid=".$new_frm_id);
		write_file($mnl_formpath,$Form_Filename_P,$Form_P);		
		*/
		
		return $Return;			
	}//addForm
	
	function updateForm($frm,$grp) {
		global $mnl_formpath, $mnl_URL;//, $mnl_siteid
		$Return=false;
		if (check_dbid($frm['id'])) {
			$DB=new ConnectDB();
			$Query ="UPDATE ".mnlTABLE_FRM." SET 
						name='".$frm["name"]."', descr='".$frm["descr"]."', aktiv='".$frm["aktiv"]."',
						updated='".$frm["created"]."',
						editor='".$frm["author"]."',
						double_optin='".$frm["double_optin"]."',
						f0='".$frm["f0"]."',
						f1='".$frm["f1"]."',
						f2='".$frm["f2"]."',
						f3='".$frm["f3"]."',
						f4='".$frm["f4"]."',
						f5='".$frm["f5"]."',
						f6='".$frm["f6"]."',
						f7='".$frm["f7"]."',
						f8='".$frm["f8"]."',
						f9='".$frm["f9"]."',
						f0_type='".$frm["f0_type"]."',
						f1_type='".$frm["f1_type"]."',
						f2_type='".$frm["f2_type"]."',
						f3_type='".$frm["f3_type"]."',
						f4_type='".$frm["f4_type"]."',
						f5_type='".$frm["f5_type"]."',
						f6_type='".$frm["f6_type"]."',
						f7_type='".$frm["f7_type"]."',
						f8_type='".$frm["f8_type"]."',
						f9_type='".$frm["f9_type"]."',
						f0_required='".$frm["f0_required"]."',
						f1_required='".$frm["f1_required"]."',
						f2_required='".$frm["f2_required"]."',
						f3_required='".$frm["f3_required"]."',
						f4_required='".$frm["f4_required"]."',
						f5_required='".$frm["f5_required"]."',
						f6_required='".$frm["f6_required"]."',
						f7_required='".$frm["f7_required"]."',
						f8_required='".$frm["f8_required"]."',
						f9_required='".$frm["f9_required"]."',
						f0_value='".$frm["f0_value"]."',
						f1_value='".$frm["f1_value"]."',
						f2_value='".$frm["f2_value"]."',
						f3_value='".$frm["f3_value"]."',
						f4_value='".$frm["f4_value"]."',
						f5_value='".$frm["f5_value"]."',
						f6_value='".$frm["f6_value"]."',
						f7_value='".$frm["f7_value"]."',
						f8_value='".$frm["f8_value"]."',
						f9_value='".$frm["f9_value"]."'
						 WHERE siteid='".MNL_SITEID."' AND id='".$frm["id"]."'";
			if ($DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;			
			}
			//alle refs loeschen
			$Query ="DELETE FROM ".mnlTABLE_FRM_GRP_REF." WHERE siteid='".MNL_SITEID."' AND frm_id='".$frm['id']."'";
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
				$Query="INSERT INTO ".mnlTABLE_FRM_GRP_REF." (frm_id,grp_id,siteid) VALUES ('".$frm['id']."','".$grp[$accg]."','".MNL_SITEID."')";
				if ($DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;			
				}
			}
			
			//geparste Version speichern
			/*
			$Form_Filename_P="/Form_".$frm['id']."_p.html";
			$Form_P=file_get_contents($mnl_URL."/subscribe.php?fid=".$frm['id']);
			write_file($mnl_formpath,$Form_Filename_P,$Form_P);		
			*/
		}			
		return $Return;			
	}//updateForm

	//subscriptions zaehlen
	function addSub($frm_id,$adr_id=0) {
		$Return=false;
		if (check_dbid($frm_id)) {
			$F=$this->getForm($frm_id);
			$subs=$F[0]['subscriptions'];
			$subs++;
			
			$DB=new ConnectDB();
			$Query ="UPDATE ".mnlTABLE_FRM." 
						SET subscriptions='".$subs."' 
						WHERE siteid='".MNL_SITEID."' 
						AND id='".$frm_id."'";
			if ($DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}//query
			
			if (check_dbid($adr_id)) {
				$Query ="INSERT INTO ".mnlTABLE_FRM_S."
								(created,frm_id,adr_id,siteid)
								VALUES
								(
								'".date("Y-m-d H:i:s")."',
								'".$frm_id."',
								'".$adr_id."',
								'".MNL_SITEID."'
								)";
				if ($DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}//query
			}//if adr_id
		}
		return $Return;
	}//addSub

}//class 
?>