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


class tm_FRM {
	var $FORM=Array();
 	var $DB;
  #var $DB2;//2nd connection, e.g. needed to count adr from within getgroup()!

  function tm_FRM() {
		$this->DB=new tm_DB();
		#$this->DB2=new tm_DB();
  }

	function getForm($id=0,$offset=0,$limit=0,$group_id=0,$sortIndex="",$sortType=0) {
		$this->FRM=Array();
		#$DB=new tm_DB();
		$Query ="	SELECT ".TM_TABLE_FRM.".id, ".TM_TABLE_FRM.".name, ".TM_TABLE_FRM.".descr, ".TM_TABLE_FRM.".aktiv, ".TM_TABLE_FRM.".author, ".TM_TABLE_FRM.".created, ".TM_TABLE_FRM.".editor, ".TM_TABLE_FRM.".updated, ".TM_TABLE_FRM.".double_optin, ".TM_TABLE_FRM.".subscriptions,
						 ".TM_TABLE_FRM.".use_captcha,  ".TM_TABLE_FRM.".digits_captcha,  ".TM_TABLE_FRM.".subscribe_aktiv,
						 ".TM_TABLE_FRM.".submit_value, ".TM_TABLE_FRM.".reset_value,
						".TM_TABLE_FRM.".email, ".TM_TABLE_FRM.".f0, ".TM_TABLE_FRM.".f1, ".TM_TABLE_FRM.".f2, ".TM_TABLE_FRM.".f3, ".TM_TABLE_FRM.".f4, ".TM_TABLE_FRM.".f5, ".TM_TABLE_FRM.".f6, ".TM_TABLE_FRM.".f7, ".TM_TABLE_FRM.".f8, ".TM_TABLE_FRM.".f9,
						".TM_TABLE_FRM.".f0_type, ".TM_TABLE_FRM.".f1_type, ".TM_TABLE_FRM.".f2_type, ".TM_TABLE_FRM.".f3_type, ".TM_TABLE_FRM.".f4_type, ".TM_TABLE_FRM.".f5_type, ".TM_TABLE_FRM.".f6_type, ".TM_TABLE_FRM.".f7_type, ".TM_TABLE_FRM.".f8_type, ".TM_TABLE_FRM.".f9_type,
						".TM_TABLE_FRM.".f0_required, ".TM_TABLE_FRM.".f1_required, ".TM_TABLE_FRM.".f2_required, ".TM_TABLE_FRM.".f3_required, ".TM_TABLE_FRM.".f4_required, ".TM_TABLE_FRM.".f5_required, ".TM_TABLE_FRM.".f6_required, ".TM_TABLE_FRM.".f7_required, ".TM_TABLE_FRM.".f8_required, ".TM_TABLE_FRM.".f9_required,
						".TM_TABLE_FRM.".f0_value, ".TM_TABLE_FRM.".f1_value, ".TM_TABLE_FRM.".f2_value, ".TM_TABLE_FRM.".f3_value, ".TM_TABLE_FRM.".f4_value, ".TM_TABLE_FRM.".f5_value, ".TM_TABLE_FRM.".f6_value, ".TM_TABLE_FRM.".f7_value, ".TM_TABLE_FRM.".f8_value, ".TM_TABLE_FRM.".f9_value,
						".TM_TABLE_FRM.".email_errmsg, ".TM_TABLE_FRM.".captcha_errmsg, ".TM_TABLE_FRM.".f0_errmsg, ".TM_TABLE_FRM.".f1_errmsg, ".TM_TABLE_FRM.".f2_errmsg, ".TM_TABLE_FRM.".f3_errmsg, ".TM_TABLE_FRM.".f4_errmsg, ".TM_TABLE_FRM.".f5_errmsg, ".TM_TABLE_FRM.".f6_errmsg, ".TM_TABLE_FRM.".f7_errmsg, ".TM_TABLE_FRM.".f8_errmsg, ".TM_TABLE_FRM.".f9_errmsg,
						".TM_TABLE_FRM.".f0_expr, ".TM_TABLE_FRM.".f1_expr, ".TM_TABLE_FRM.".f2_expr, ".TM_TABLE_FRM.".f3_expr, ".TM_TABLE_FRM.".f4_expr, ".TM_TABLE_FRM.".f5_expr, ".TM_TABLE_FRM.".f6_expr, ".TM_TABLE_FRM.".f7_expr, ".TM_TABLE_FRM.".f8_expr, ".TM_TABLE_FRM.".f9_expr
						FROM ".TM_TABLE_FRM."
					";
		if (check_dbid($group_id)) {
			$Query .="LEFT JOIN ".TM_TABLE_FRM_GRP_REF." ON ".TM_TABLE_FRM.".id = ".TM_TABLE_FRM_GRP_REF.".frm_id";
		}
		$Query .=" WHERE ".TM_TABLE_FRM.".siteid='".TM_SITEID."'";
		if ($group_id!=0) {
			$Query .=" AND ".TM_TABLE_FRM_GRP_REF.".siteid='".TM_SITEID."'
						  AND ".TM_TABLE_FRM_GRP_REF.".grp_id='".$group_id."'
						";
		}
						//achtung, durch AND adr_details.siteid='".TM_SITEID."' werden nur die eintraege angezeigt die auch eien detaildatensatz haben!!!
		if (check_dbid($id)) {
			$Query .= " AND ".TM_TABLE_FRM.".id='".$id."'";
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
			$this->FORM[$ac]['id']=$this->DB->Record['id'];
			$this->FORM[$ac]['name']=$this->DB->Record['name'];
			$this->FORM[$ac]['aktiv']=$this->DB->Record['aktiv'];
			$this->FORM[$ac]['descr']=$this->DB->Record['descr'];
			$this->FORM[$ac]['author']=$this->DB->Record['author'];
			$this->FORM[$ac]['created']=$this->DB->Record['created'];
			$this->FORM[$ac]['editor']=$this->DB->Record['editor'];
			$this->FORM[$ac]['updated']=$this->DB->Record['updated'];
			$this->FORM[$ac]['double_optin']=$this->DB->Record['double_optin'];
			$this->FORM[$ac]['subscriptions']=$this->DB->Record['subscriptions'];
			$this->FORM[$ac]['use_captcha']=$this->DB->Record['use_captcha'];
			$this->FORM[$ac]['digits_captcha']=$this->DB->Record['digits_captcha'];
			$this->FORM[$ac]['subscribe_aktiv']=$this->DB->Record['subscribe_aktiv'];
			$this->FORM[$ac]['submit_value']=$this->DB->Record['submit_value'];
			$this->FORM[$ac]['reset_value']=$this->DB->Record['reset_value'];
			$this->FORM[$ac]['email']=$this->DB->Record['email'];
			$this->FORM[$ac]['f0']=$this->DB->Record['f0'];
			$this->FORM[$ac]['f1']=$this->DB->Record['f1'];
			$this->FORM[$ac]['f2']=$this->DB->Record['f2'];
			$this->FORM[$ac]['f3']=$this->DB->Record['f3'];
			$this->FORM[$ac]['f4']=$this->DB->Record['f4'];
			$this->FORM[$ac]['f5']=$this->DB->Record['f5'];
			$this->FORM[$ac]['f6']=$this->DB->Record['f6'];
			$this->FORM[$ac]['f7']=$this->DB->Record['f7'];
			$this->FORM[$ac]['f8']=$this->DB->Record['f8'];
			$this->FORM[$ac]['f9']=$this->DB->Record['f9'];
			$this->FORM[$ac]['f0_type']=$this->DB->Record['f0_type'];
			$this->FORM[$ac]['f1_type']=$this->DB->Record['f1_type'];
			$this->FORM[$ac]['f2_type']=$this->DB->Record['f2_type'];
			$this->FORM[$ac]['f3_type']=$this->DB->Record['f3_type'];
			$this->FORM[$ac]['f4_type']=$this->DB->Record['f4_type'];
			$this->FORM[$ac]['f5_type']=$this->DB->Record['f5_type'];
			$this->FORM[$ac]['f6_type']=$this->DB->Record['f6_type'];
			$this->FORM[$ac]['f7_type']=$this->DB->Record['f7_type'];
			$this->FORM[$ac]['f8_type']=$this->DB->Record['f8_type'];
			$this->FORM[$ac]['f9_type']=$this->DB->Record['f9_type'];
			$this->FORM[$ac]['f0_required']=$this->DB->Record['f0_required'];
			$this->FORM[$ac]['f1_required']=$this->DB->Record['f1_required'];
			$this->FORM[$ac]['f2_required']=$this->DB->Record['f2_required'];
			$this->FORM[$ac]['f3_required']=$this->DB->Record['f3_required'];
			$this->FORM[$ac]['f4_required']=$this->DB->Record['f4_required'];
			$this->FORM[$ac]['f5_required']=$this->DB->Record['f5_required'];
			$this->FORM[$ac]['f6_required']=$this->DB->Record['f6_required'];
			$this->FORM[$ac]['f7_required']=$this->DB->Record['f7_required'];
			$this->FORM[$ac]['f8_required']=$this->DB->Record['f8_required'];
			$this->FORM[$ac]['f9_required']=$this->DB->Record['f9_required'];
			$this->FORM[$ac]['f0_value']=$this->DB->Record['f0_value'];
			$this->FORM[$ac]['f1_value']=$this->DB->Record['f1_value'];
			$this->FORM[$ac]['f2_value']=$this->DB->Record['f2_value'];
			$this->FORM[$ac]['f3_value']=$this->DB->Record['f3_value'];
			$this->FORM[$ac]['f4_value']=$this->DB->Record['f4_value'];
			$this->FORM[$ac]['f5_value']=$this->DB->Record['f5_value'];
			$this->FORM[$ac]['f6_value']=$this->DB->Record['f6_value'];
			$this->FORM[$ac]['f7_value']=$this->DB->Record['f7_value'];
			$this->FORM[$ac]['f8_value']=$this->DB->Record['f8_value'];
			$this->FORM[$ac]['f9_value']=$this->DB->Record['f9_value'];
			$this->FORM[$ac]['email_errmsg']=$this->DB->Record['email_errmsg'];
			$this->FORM[$ac]['captcha_errmsg']=$this->DB->Record['captcha_errmsg'];
			$this->FORM[$ac]['f0_errmsg']=$this->DB->Record['f0_errmsg'];
			$this->FORM[$ac]['f1_errmsg']=$this->DB->Record['f1_errmsg'];
			$this->FORM[$ac]['f2_errmsg']=$this->DB->Record['f2_errmsg'];
			$this->FORM[$ac]['f3_errmsg']=$this->DB->Record['f3_errmsg'];
			$this->FORM[$ac]['f4_errmsg']=$this->DB->Record['f4_errmsg'];
			$this->FORM[$ac]['f5_errmsg']=$this->DB->Record['f5_errmsg'];
			$this->FORM[$ac]['f6_errmsg']=$this->DB->Record['f6_errmsg'];
			$this->FORM[$ac]['f7_errmsg']=$this->DB->Record['f7_errmsg'];
			$this->FORM[$ac]['f8_errmsg']=$this->DB->Record['f8_errmsg'];
			$this->FORM[$ac]['f9_errmsg']=$this->DB->Record['f9_errmsg'];
			$this->FORM[$ac]['f0_expr']=$this->DB->Record['f0_expr'];
			$this->FORM[$ac]['f1_expr']=$this->DB->Record['f1_expr'];
			$this->FORM[$ac]['f2_expr']=$this->DB->Record['f2_expr'];
			$this->FORM[$ac]['f3_expr']=$this->DB->Record['f3_expr'];
			$this->FORM[$ac]['f4_expr']=$this->DB->Record['f4_expr'];
			$this->FORM[$ac]['f5_expr']=$this->DB->Record['f5_expr'];
			$this->FORM[$ac]['f6_expr']=$this->DB->Record['f6_expr'];
			$this->FORM[$ac]['f7_expr']=$this->DB->Record['f7_expr'];
			$this->FORM[$ac]['f8_expr']=$this->DB->Record['f8_expr'];
			$this->FORM[$ac]['f9_expr']=$this->DB->Record['f9_expr'];
			$ac++;
		}
		return $this->FORM;
	}//getForm

	function setAktiv($id=0,$aktiv=1) {
		$Return=false;
		if (check_dbid($id)) {
			#$DB=new tm_DB();
			$Query ="UPDATE ".TM_TABLE_FRM." SET aktiv='".dbesc($aktiv)."' WHERE id='".$id."' AND siteid='".TM_SITEID."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//setAktiv

	function copyForm($id) {
		global $LOGIN;
		$Return=false;
		if (check_dbid($id)) {
			$created=date("Y-m-d H:i:s");
			$author=$LOGIN->USER['name'];
			$FRM=$this->getForm($id);
			$ADDRESS=new tm_ADR();
			$adr_grp=$ADDRESS->getGroupID(0,0,$id);
			//make a copy
			$FRM_copy=$FRM[0];
			//change some values
			$FRM_copy['name']="COPY OF ".$FRM[0]["name"];
			$FRM_copy['created']=$created;
			$FRM_copy['author']=$author;
			//add new form
			$Return=$this->addForm($FRM_copy,$adr_grp);
			//thats it
		}
		return $Return;
	}//copyForm

	function delForm($id) {
		$Return=false;
		if (check_dbid($id)) {
			#$DB=new tm_DB();
			//referenzen loeschen
			$Query ="DELETE FROM ".TM_TABLE_FRM_GRP_REF." WHERE siteid='".TM_SITEID."' AND frm_id='".$id."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
			//subscriptions loeschen
			$Query ="DELETE FROM ".TM_TABLE_FRM_S." WHERE siteid='".TM_SITEID."' AND frm_id='".$id."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
			//formular loeschen
			$Query ="DELETE FROM ".TM_TABLE_FRM." WHERE siteid='".TM_SITEID."' AND id='".$id."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
		}
		return $Return;
	}//delForm

	function addForm($frm,$grp) {
		global $tm_formpath, $tm_tplpath, $tm_URL;//, $TM_SITEID
		$Return=false;
		#$DB=new tm_DB();
		//neues Formular speichern
		$Query ="INSERT INTO
					".TM_TABLE_FRM."
					(
					name,descr,aktiv,author,created,editor,updated,double_optin,subscriptions,use_captcha,digits_captcha,subscribe_aktiv,
					submit_value, reset_value, siteid,
					email, f0,f1,f2,f3,f4,f5,f6,f7,f8,f9,
					f0_type, f1_type, f2_type, f3_type, f4_type, f5_type, f6_type, f7_type, f8_type, f9_type,
					f0_required, f1_required, f2_required, f3_required, f4_required, f5_required, f6_required, f7_required, f8_required, f9_required,
					f0_value, f1_value, f2_value, f3_value, f4_value, f5_value, f6_value, f7_value, f8_value, f9_value,
					email_errmsg, captcha_errmsg, f0_errmsg, f1_errmsg, f2_errmsg, f3_errmsg, f4_errmsg, f5_errmsg, f6_errmsg, f7_errmsg, f8_errmsg, f9_errmsg,
					f0_expr, f1_expr, f2_expr, f3_expr, f4_expr, f5_expr, f6_expr, f7_expr, f8_expr, f9_expr
					)
					VALUES
					(
					'".dbesc($frm["name"])."', '".dbesc($frm["descr"])."', '".dbesc($frm["aktiv"])."', '".dbesc($frm["author"])."', '".dbesc($frm["created"])."', '".dbesc($frm["author"])."', '".dbesc($frm["created"])."',
					'".dbesc($frm["double_optin"])."', 0, '".dbesc($frm["use_captcha"])."',
					'".dbesc($frm["digits_captcha"])."', '".dbesc($frm["subscribe_aktiv"])."',
					'".dbesc($frm["submit_value"])."', '".dbesc($frm["reset_value"])."',
					'".TM_SITEID."',
					'".dbesc($frm["email"])."',
					'".dbesc($frm["f0"])."',
					'".dbesc($frm["f1"])."',
					'".dbesc($frm["f2"])."',
					'".dbesc($frm["f3"])."',
					'".dbesc($frm["f4"])."',
					'".dbesc($frm["f5"])."',
					'".dbesc($frm["f6"])."',
					'".dbesc($frm["f7"])."',
					'".dbesc($frm["f8"])."',
					'".dbesc($frm["f9"])."',
					'".dbesc($frm["f0_type"])."',
					'".dbesc($frm["f1_type"])."',
					'".dbesc($frm["f2_type"])."',
					'".dbesc($frm["f3_type"])."',
					'".dbesc($frm["f4_type"])."',
					'".dbesc($frm["f5_type"])."',
					'".dbesc($frm["f6_type"])."',
					'".dbesc($frm["f7_type"])."',
					'".dbesc($frm["f8_type"])."',
					'".dbesc($frm["f9_type"])."',
					'".dbesc($frm["f0_required"])."',
					'".dbesc($frm["f1_required"])."',
					'".dbesc($frm["f2_required"])."',
					'".dbesc($frm["f3_required"])."',
					'".dbesc($frm["f4_required"])."',
					'".dbesc($frm["f5_required"])."',
					'".dbesc($frm["f6_required"])."',
					'".dbesc($frm["f7_required"])."',
					'".dbesc($frm["f8_required"])."',
					'".dbesc($frm["f9_required"])."',
					'".dbesc($frm["f0_value"])."',
					'".dbesc($frm["f1_value"])."',
					'".dbesc($frm["f2_value"])."',
					'".dbesc($frm["f3_value"])."',
					'".dbesc($frm["f4_value"])."',
					'".dbesc($frm["f5_value"])."',
					'".dbesc($frm["f6_value"])."',
					'".dbesc($frm["f7_value"])."',
					'".dbesc($frm["f8_value"])."',
					'".dbesc($frm["f9_value"])."',
					'".dbesc($frm["email_errmsg"])."',
					'".dbesc($frm["captcha_errmsg"])."',
					'".dbesc($frm["f0_errmsg"])."',
					'".dbesc($frm["f1_errmsg"])."',
					'".dbesc($frm["f2_errmsg"])."',
					'".dbesc($frm["f3_errmsg"])."',
					'".dbesc($frm["f4_errmsg"])."',
					'".dbesc($frm["f5_errmsg"])."',
					'".dbesc($frm["f6_errmsg"])."',
					'".dbesc($frm["f7_errmsg"])."',
					'".dbesc($frm["f8_errmsg"])."',
					'".dbesc($frm["f9_errmsg"])."',
					'".dbesc($frm["f0_expr"])."',
					'".dbesc($frm["f1_expr"])."',
					'".dbesc($frm["f2_expr"])."',
					'".dbesc($frm["f3_expr"])."',
					'".dbesc($frm["f4_expr"])."',
					'".dbesc($frm["f5_expr"])."',
					'".dbesc($frm["f6_expr"])."',
					'".dbesc($frm["f7_expr"])."',
					'".dbesc($frm["f8_expr"])."',
					'".dbesc($frm["f9_expr"])."'
					)";
		if ($this->DB->Query($Query)) {
			$Return=true;
		} else {
			$Return=false;
			return $Return;
		}
		//Abfragen! und ID suchen, die brauchen wir fuer die Verknuepfung zu den Adressgruppen
		$Query ="SELECT id FROM ".TM_TABLE_FRM."
					WHERE name='".dbesc($frm["name"])."'
					AND descr='".dbesc($frm["descr"])."'
					AND aktiv='".dbesc($frm["aktiv"])."'
					AND siteid='".TM_SITEID."'
					ORDER BY id desc LIMIT 1
					";//es muessen nicht alle felder abgefragt werden, order by id desc limit 1 liefert uns den letzten eintrag ;)
		if ($this->DB->Query($Query)) {
			$Return=true;
		} else {
			$Return=false;
			return $Return;
		}
		//wenn ein eintrag gefunden wurde....:
		if ($this->DB->next_record()) {
			//neue id
			$new_frm_id=$this->DB->Record['id'];
			//gruppen eintragen
			$acg=count($grp);
			for ($accg=0;$accg<$acg;$accg++) {
				$Query="INSERT INTO ".TM_TABLE_FRM_GRP_REF." (frm_id,grp_id,siteid) VALUES ('".$new_frm_id."','".$grp[$accg]."','".TM_SITEID."')";
				if ($this->DB->Query($Query)) {
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

		$_Tpl_FRM=new tm_Template();
		$_Tpl_FRM->setTemplatePath($tm_tplpath);

		//Formular Template erzeugen
		$Form_Html=$_Tpl_FRM->renderTemplate($Form_Filename_TPL);
		write_file($tm_formpath,$Form_Filename,$Form_Html);
		//Formular Template erzeugen, Meldung wenn subscribed
		$Form_S_Html=$_Tpl_FRM->renderTemplate($Form_Filename_S_TPL);
		write_file($tm_formpath,$Form_Filename_S,$Form_S_Html);
		//Formular Template erzeugen, OptinMail
		$Form_O_Html=$_Tpl_FRM->renderTemplate($Form_Filename_O_TPL);
		write_file($tm_formpath,$Form_Filename_O,$Form_O_Html);

		//Formular Template erzeugen, OptinMail nach Bestaetigung
		$Form_OS_Html=$_Tpl_FRM->renderTemplate($Form_Filename_OS_TPL);
		write_file($tm_formpath,$Form_Filename_OS,$Form_OS_Html);

		return $Return;
	}//addForm

	function updateForm($frm,$grp) {
		global $tm_formpath, $tm_URL;//, $TM_SITEID
		$Return=false;
		if (check_dbid($frm['id'])) {
			#$DB=new tm_DB();
			$Query ="UPDATE ".TM_TABLE_FRM." SET
						name='".dbesc($frm["name"])."', descr='".dbesc($frm["descr"])."', aktiv='".dbesc($frm["aktiv"])."',
						updated='".dbesc($frm["created"])."',
						editor='".dbesc($frm["author"])."',
						double_optin='".dbesc($frm["double_optin"])."',
						use_captcha='".dbesc($frm["use_captcha"])."',
						digits_captcha='".dbesc($frm["digits_captcha"])."',
						subscribe_aktiv='".dbesc($frm["subscribe_aktiv"])."',
						submit_value='".dbesc($frm["submit_value"])."',
						reset_value='".dbesc($frm["reset_value"])."',
						email='".dbesc($frm["email"])."',
						f0='".dbesc($frm["f0"])."',
						f1='".dbesc($frm["f1"])."',
						f2='".dbesc($frm["f2"])."',
						f3='".dbesc($frm["f3"])."',
						f4='".dbesc($frm["f4"])."',
						f5='".dbesc($frm["f5"])."',
						f6='".dbesc($frm["f6"])."',
						f7='".dbesc($frm["f7"])."',
						f8='".dbesc($frm["f8"])."',
						f9='".dbesc($frm["f9"])."',
						f0_type='".dbesc($frm["f0_type"])."',
						f1_type='".dbesc($frm["f1_type"])."',
						f2_type='".dbesc($frm["f2_type"])."',
						f3_type='".dbesc($frm["f3_type"])."',
						f4_type='".dbesc($frm["f4_type"])."',
						f5_type='".dbesc($frm["f5_type"])."',
						f6_type='".dbesc($frm["f6_type"])."',
						f7_type='".dbesc($frm["f7_type"])."',
						f8_type='".dbesc($frm["f8_type"])."',
						f9_type='".dbesc($frm["f9_type"])."',
						f0_required='".dbesc($frm["f0_required"])."',
						f1_required='".dbesc($frm["f1_required"])."',
						f2_required='".dbesc($frm["f2_required"])."',
						f3_required='".dbesc($frm["f3_required"])."',
						f4_required='".dbesc($frm["f4_required"])."',
						f5_required='".dbesc($frm["f5_required"])."',
						f6_required='".dbesc($frm["f6_required"])."',
						f7_required='".dbesc($frm["f7_required"])."',
						f8_required='".dbesc($frm["f8_required"])."',
						f9_required='".dbesc($frm["f9_required"])."',
						f0_value='".dbesc($frm["f0_value"])."',
						f1_value='".dbesc($frm["f1_value"])."',
						f2_value='".dbesc($frm["f2_value"])."',
						f3_value='".dbesc($frm["f3_value"])."',
						f4_value='".dbesc($frm["f4_value"])."',
						f5_value='".dbesc($frm["f5_value"])."',
						f6_value='".dbesc($frm["f6_value"])."',
						f7_value='".dbesc($frm["f7_value"])."',
						f8_value='".dbesc($frm["f8_value"])."',
						f9_value='".dbesc($frm["f9_value"])."',
						email_errmsg='".dbesc($frm["email_errmsg"])."',
						captcha_errmsg='".dbesc($frm["captcha_errmsg"])."',
						f0_errmsg='".dbesc($frm["f0_errmsg"])."',
						f1_errmsg='".dbesc($frm["f1_errmsg"])."',
						f2_errmsg='".dbesc($frm["f2_errmsg"])."',
						f3_errmsg='".dbesc($frm["f3_errmsg"])."',
						f4_errmsg='".dbesc($frm["f4_errmsg"])."',
						f5_errmsg='".dbesc($frm["f5_errmsg"])."',
						f6_errmsg='".dbesc($frm["f6_errmsg"])."',
						f7_errmsg='".dbesc($frm["f7_errmsg"])."',
						f8_errmsg='".dbesc($frm["f8_errmsg"])."',
						f9_errmsg='".dbesc($frm["f9_errmsg"])."',
						f0_expr='".dbesc($frm["f0_expr"])."',
						f1_expr='".dbesc($frm["f1_expr"])."',
						f2_expr='".dbesc($frm["f2_expr"])."',
						f3_expr='".dbesc($frm["f3_expr"])."',
						f4_expr='".dbesc($frm["f4_expr"])."',
						f5_expr='".dbesc($frm["f5_expr"])."',
						f6_expr='".dbesc($frm["f6_expr"])."',
						f7_expr='".dbesc($frm["f7_expr"])."',
						f8_expr='".dbesc($frm["f8_expr"])."',
						f9_expr='".dbesc($frm["f9_expr"])."'
						 WHERE siteid='".TM_SITEID."' AND id='".$frm["id"]."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
			//alle refs loeschen
			$Query ="DELETE FROM ".TM_TABLE_FRM_GRP_REF." WHERE siteid='".TM_SITEID."' AND frm_id='".$frm['id']."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}
			//neue refs anlegen
			$acg=count($grp);
			for ($accg=0;$accg<$acg;$accg++) {
				$Query="INSERT INTO ".TM_TABLE_FRM_GRP_REF." (frm_id,grp_id,siteid) VALUES ('".$frm['id']."','".$grp[$accg]."','".TM_SITEID."')";
				if ($this->DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
			}
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

			#$DB=new tm_DB();
			$Query ="UPDATE ".TM_TABLE_FRM."
						SET subscriptions='".$subs."'
						WHERE siteid='".TM_SITEID."'
						AND id='".$frm_id."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			} else {
				$Return=false;
				return $Return;
			}//query

			if (check_dbid($adr_id)) {
				$Query ="INSERT INTO ".TM_TABLE_FRM_S."
								(created,frm_id,adr_id,ip,siteid)
								VALUES
								(
								'".date("Y-m-d H:i:s")."',
								'".$frm_id."',
								'".$adr_id."',
								'".getIP()."',
								'".TM_SITEID."'
								)";
				if ($this->DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}//query
			}//if adr_id
		}
		return $Return;
	}//addSub

	function countSubs($frm_id) {
		$Return=0;
		#$DB=new tm_DB();
		$Query ="SELECT count(".TM_TABLE_FRM_S.".id) as c FROM ".TM_TABLE_FRM_S."
					WHERE siteid='".TM_SITEID."'";
		if (check_dbid($frm_id)) {
			$Query .=" AND frm_id='".$frm_id."'";
		}
		if ($this->DB->Query($Query)) {
			$Return=$this->DB->Record['c'];
		} else {
			$Return=false;
			return $Return;
		}//query
		return $Return;
	}//countSubs

	function makeMap(&$img,&$gi,$frm_id,$width,$height) {
		$Query ="SELECT ip FROM ".TM_TABLE_FRM_S."
					WHERE siteid='".TM_SITEID."'";
		$Query .=" AND ip!='0.0.0.0' AND ip!=''";
		if (check_dbid($frm_id)) {
			$Query .=" AND frm_id='".$frm_id."'";
		}
		if ($this->DB->Query($Query)) {
			$Color1 = imagecolorallocate ($img, 255,255,0);
			$Color2 = imagecolorallocate ($img, 255,0,0);
			while ($this->DB->next_Record()) {
				$geoip = geoip_record_by_addr($gi,$this->DB->Record['ip']);
				$pt = getlocationcoords($geoip->latitude, $geoip->longitude, $width, $height);
				imagefilledrectangle($img,$pt["x"]-1,$pt["y"]-1,$pt["x"]+1,$pt["y"]+1,$Color1);
				imagerectangle($img,$pt["x"]-4,$pt["y"]-4,$pt["x"]+4,$pt["y"]+4,$Color2);
			}//while
		}//if query
	}//makeMap

}//class
?>