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

class tm_HOST {
	var $HOST=Array();

  var $DB;
#  var $DB2;//2nd connection, e.g. needed to count adr from within getgroup()!

  function tm_HOST() {
		$this->DB=new tm_DB();
#		$this->DB2=new tm_DB();
  }

	function getHost($id=0,$search=Array()) {
		$this->HOST=Array();
		#$DB=new tm_DB();
		$Query ="SELECT ".TM_TABLE_HOST.".id, "
										.TM_TABLE_HOST.".name, "
										.TM_TABLE_HOST.".host, "
										.TM_TABLE_HOST.".type, "
										.TM_TABLE_HOST.".port, "
										.TM_TABLE_HOST.".options, "
										.TM_TABLE_HOST.".smtp_auth, "
										.TM_TABLE_HOST.".smtp_domain, "
										.TM_TABLE_HOST.".aktiv, "
										.TM_TABLE_HOST.".user, "
										.TM_TABLE_HOST.".pass, "
										.TM_TABLE_HOST.".siteid";

		$Query .=" FROM ".TM_TABLE_HOST;
		$Query .=" WHERE ".TM_TABLE_HOST.".siteid='".TM_SITEID."'";

		if (check_dbid($id)) {
			$Query .= " AND ".TM_TABLE_HOST.".id='".$id."'";
		}
		if (isset($search['type']) && !empty($search['type'])) {
			$Query .= " AND ".TM_TABLE_HOST.".type='".dbesc($search['type'])."'";
		}
		if (isset($search['aktiv']) && !empty($search['aktiv'])) {
			$Query .= " AND ".TM_TABLE_HOST.".aktiv='".dbesc(checkset_int($search['aktiv']))."'";
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

		$this->DB->Query($Query);
		$hc=0;
		while ($this->DB->next_record()) {
			$this->HOST[$hc]['id']=$this->DB->Record['id'];
			$this->HOST[$hc]['name']=$this->DB->Record['name'];
			$this->HOST[$hc]['host']=$this->DB->Record['host'];
			$this->HOST[$hc]['type']=$this->DB->Record['type'];
			$this->HOST[$hc]['port']=$this->DB->Record['port'];
			$this->HOST[$hc]['options']=$this->DB->Record['options'];
			$this->HOST[$hc]['smtp_auth']=$this->DB->Record['smtp_auth'];
			$this->HOST[$hc]['smtp_domain']=$this->DB->Record['smtp_domain'];
			$this->HOST[$hc]['aktiv']=$this->DB->Record['aktiv'];
			$this->HOST[$hc]['user']=$this->DB->Record['user'];
			$this->HOST[$hc]['pass']=$this->DB->Record['pass'];
			$this->HOST[$hc]['siteid']=$this->DB->Record['siteid'];
			$hc++;
		}
		return $this->HOST;
	}//getHost

	function setAktiv($id=0,$aktiv=1) {
		$Return=false;
		if (check_dbid($id)) {
			$Query ="UPDATE ".TM_TABLE_HOST." SET aktiv='".dbesc($aktiv)."' WHERE id='".$id."' AND siteid='".TM_SITEID."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//setAktiv


	function addHost($host) {
		$Return=false;
		$Query ="INSERT INTO ".TM_TABLE_HOST." (
					name,host,
					type,port,
					options,
					smtp_auth,
					smtp_domain,
					user,pass,
					aktiv,
					siteid
					)
					VALUES (
					'".dbesc($host["name"])."', '".dbesc($host["host"])."',
					'".dbesc($host["type"])."', '".dbesc($host["port"])."',
					'".dbesc($host["options"])."',
					'".dbesc($host["smtp_auth"])."',
					'".dbesc($host["smtp_domain"])."',
					'".dbesc($host["user"])."',	'".dbesc($host["pass"])."',
					'".dbesc($host["aktiv"])."',
					'".TM_SITEID."')";
		if ($this->DB->Query($Query)) {
			$Return=true;
		}
		return $Return;
	}//addHost

	function updateHost($host) {
		$Return=false;
		if (isset($host['id']) && check_dbid($host['id'])) {
			$Query ="UPDATE ".TM_TABLE_HOST."
					SET
					name='".dbesc($host["name"])."', host='".dbesc($host["host"])."',
					type='".dbesc($host["type"])."', port='".dbesc($host["port"])."',
					options='".dbesc($host["options"])."',
					smtp_auth='".dbesc($host["smtp_auth"])."',
					smtp_domain='".dbesc($host["smtp_domain"])."',
					user='".dbesc($host["user"])."', pass='".dbesc($host["pass"])."',
					aktiv='".dbesc($host["aktiv"])."'
					WHERE siteid='".TM_SITEID."' AND id='".dbesc($host["id"])."'";
			if ($this->DB->Query($Query)) {
				$Return=true;
			}
		}
		return $Return;
	}//updateHost

	function delHost($id) {
		$Return=false;
		if (check_dbid($id)) {
			$Query ="DELETE FROM ".TM_TABLE_HOST." WHERE siteid='".TM_SITEID."' AND id='".$id."'";
				if ($this->DB->Query($Query)) {
					$Return=true;
				} else {
					$Return=false;
					return $Return;
				}
		}
		//todo: defaulthost fuer offene versendeauftraege!!! host nur loeschen wenn nicht aktuell benutzt wird! oder komplett loeschen....
		
		return $Return;
	}//delHost

}  //class
?>