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


require_once ($mnl_includepath."/db_mysql.inc");

/*DB*/ 
define ("DBDB",$MNL["DB"]["Name"]); 
define ("DBHOST", $MNL["DB"]["Host"].":".$MNL["DB"]["Port"]); 
define ("DBUSER",$MNL["DB"]["User"]); 
define ("DBPASS",$MNL["DB"]["Pass"]); 
class ConnectDB extends DB_Sql 
{ 
	var $classname = "ConnectDB"; 
	var $Host     = DBHOST; 
	var $Database = DBDB; 
	var $User     = DBUSER; 
	var $Password = DBPASS; 
	var $Autofree = false; 
	var $Debug = 0; 

	function halt($msg) 
	{ 
		global $SERVER_NAME; 
		$Message = sprintf("<pre>mySQL Error: %s (%s)\n<BR>%s\n</pre>", $this->Errno, $this->Error, $msg); 
		echo("<br><font color=\"#ff0000\">Database Error in Database $this->Database:</font><font color=\"#3300ff\"><pre>".$Message."</pre></font>"); 
 	} 
} 

// 
class mURL {  
	var $Params;  
	var $URLName;  
  
	function addStdParam($Para,$Value) {  
		if ($this->Params[$Para]=$Value) {  
			return true;  
		} else {  
			return false;  
		}  
	}  
	function addParam($Para,$Value,$must_not_be_empty=0) {  
		if ($must_not_be_empty==1) {
			if (empty($Value)) {
				return false;
			}
		}
		if ($this->Params[$Para]=urlencode($Value)) {  
			return true;  
		} else {  
			return false;  
		}  
	}
	function delParam($Para) {  
		unset($this->Params[$Para]);
	}  
	function getParamString($Para) {  
		if (isset($Para) && !empty($Para) && $Para!='') {  
			return "$Para=".$this->Params[$Para];  
		}	else {  
			return false;  
		}  
	}  
	function getParamValue($Para) {  
		if (isset($Para) && !empty($Para) && $Para!='') {  
			return $this->Params[$Para];  
		} else {  
			return false;  
		}  
	}  
	function getParamCount() {  
		return count($this->Params);  
	}  
	function getAllParams() {  
		$P="?1=1";  
		$P_=array_keys($this->Params);  
		
		//print_r($this->Params);
		
		for ($i=0;$i<$this->getParamCount($this->Params);$i++) {  
			$P__=$P_[$i];  

			if ($this->Params[$P__]!="" ) {//&& !empty($this->Params[$P__])
				$P .="&amp;".$P__."=".$this->Params[$P__];  
			} 
		}
		//$P = str_replace("//", "/", $P); 
		return urldecode($P);  
	}  
}  
  
 
 
//////formclass 
class mForm {  
	var $Hidden;  
	  
	function addHidden($Para,$Value) {  
		global $must_not_be_empty;
		if ($must_not_be_empty==1) {
			if (empty($Value)) {
				return false;
			}
		}
		if ($this->Hidden[$Para]=$Value) {  
			return true; 
		} else {  
			return false; 
		}  
	}  
	function addHiddenText($Para,$Value) {  
		if ($this->Hidden[$Para]=urlencode($Value)) {  
			return true;  
		} else {  
			return false;  
		}  
	}  
	/* 
	function getHidden($Para) {  
		if (isset($Para) && !empty($Para) && $Para!='') {  
			return "$Para=".$this->Params[$Para];  
		}	else {  
			return false;  
		}  
	}  
	function getParamValue($Para) {  
		if (isset($Para) && !empty($Para) && $Para!='') {  
			return $this->Params[$Para];  
		} else {  
			return false;  
		}  
	}  
	*/ 
	function getHiddenFieldCount() {  
		return count($this->Hidden);  
	}  
	function getAllHiddenFields() {  
		$P="";  
		$P_=array_keys($this->Hidden);  
		for ($i=0;$i<$this->getHiddenFieldCount($this->Hidden);$i++) {  
			$P__=$P_[$i];  
			$P .="<INPUT TYPE=\"HIDDEN\" NAME=\"".$P__."\" VALUE=\"".$this->Hidden[$P__]."\">\n\r"; 
		} 
		return $P;  
	}  
}  


class mTemplate{
//
  var $file;
//
  var $path;
  var $replace_str = array();
  var $value = array();
  
  # Pfad zu den Templates übergeben
  function setTemplatePath($tpl_path=''){
      if(!empty($tpl_path)){
          if(substr($tpl_path, -1) == '/'){ # Auf Slash bei der Pfadeingabe prüfen
              $this->path = $tpl_path;
          }else{
              $this->path = $tpl_path.'/';
          }
      }
  }
  
  # welche Variablen ersetzen
  function setParseValue($r_str, $v_str){
      $this->replace_str[$r_str] = $r_str;
      $this->value[$r_str] = $v_str;
  }
  
  # Template anzeigen
  function renderTemplate($templateFile){
      $this->file = $this->path.$templateFile;
      $output = '';
      if(!is_file($this->file)){
          $output.="Error: Die Datei ".$this->file." existiert nicht!";
      } else {

	      $handle = fopen ($this->file, 'r');
   	   while (!feof($handle)){
  	        $buffer = fgets($handle, 4096);
  	        $output .= $buffer;
  	    }
  	    foreach($this->replace_str as $val){
  	        $output = str_replace('{'.$this->replace_str[$val].'}', $this->value[$val], $output);
  	    }
  	    fclose ($handle);
  	   }
    return $output;
  }
}

class Digit {

  var $bits = array(1,2,4,8,16,32,64,128,256,512,1024,2048,4096,8192,16384);
  var $matrix  = array();
  var $bitmasks = array(31599, 18740, 29607, 31143, 18921, 31183, 31695, 18855, 31727, 31215);

  function digit( $dig ) {
    $this->matrix[] = array(0, 0, 0); // 2^0, 2^1, 2^2 ... usw.
    $this->matrix[] = array(0, 0, 0);
    $this->matrix[] = array(0, 0, 0);
    $this->matrix[] = array(0, 0, 0);
    $this->matrix[] = array(0, 0, 0); // ..., ..., 2^14

    ((int)$dig >= 0 && (int)$dig <= 9) && $this->setMatrix( $this->bitmasks[(int)$dig] );
  }

  function setMatrix( $bitmask ) {
    $bitsset = array();

    for ($i=0; $i<count($this->bits); ++$i)
      (($bitmask & $this->bits[$i]) != 0) && $bitsset[] = $this->bits[$i];

    foreach($this->matrix AS $row=>$col)
      foreach($col AS $cellnr => $bit)
        in_array( pow(2,($row*3+$cellnr)), $bitsset) && $this->matrix[$row][$cellnr] = 1;
  }
}

class Number {

  var $num = 0;
  var $digits = array();

  function number( $num ) {
    $this->num = (int)$num;

    $r = "{$this->num}";
    for( $i=0; $i<strlen($r); $i++ )
      $this->digits[] = new Digit((int)$r[$i]);
  }

  function getNum() { return $this->num; }

  function printNumber() {
  	$n="";
    for($row=0; $row<count($this->digits[0]->matrix); $row++) {
      foreach( $this->digits AS $digit ) {
        foreach($digit->matrix[$row] AS $cell)
          if($cell === 1) $n.="<span class=\"s\">&nbsp;&nbsp;</span>"; else $n.="<span class=\"w\">&nbsp;&nbsp;</span>";
	        $n.="<span class=\"w\">&nbsp;</span>";
      }
      $n.="<br>";
    }
    return $n;
  }
}

class Timer
		{
		var $Start;
		var $MiddleTime;

		function getMicroSecs($Var)
			{
			$Tmp = array();
			$Tmp = explode(" ", $Var);
			return $Tmp[1] + $Tmp[0];
			}

		function Timer()
			{
			$this->Start = $this->getMicroSecs(microtime());
			$this->MiddleTime = $this->Start;
			}

		function Result()
			{
			return $this->getMicroSecs(microtime()) - $this->Start;
			}

		function MidResult()
			{
			$Tmp = $this->getMicroSecs(microtime());
			$Result = $Tmp - $this->MiddleTime;
			$this->MiddleTime = $Tmp;
			return $Result;
			}
		}
		
		
require_once ($mnl_includepath."/Class_CFG.inc");
require_once ($mnl_includepath."/Class_NL.inc");
require_once ($mnl_includepath."/Class_Q.inc");
require_once ($mnl_includepath."/Class_Adr.inc");
require_once ($mnl_includepath."/Class_Form.inc");
require_once ($mnl_includepath."/Class_Mail.inc");
require_once ($mnl_includepath."/Class_Bounce.inc");
require_once ($mnl_includepath."/Class_mSimpleForm.inc");
?>
