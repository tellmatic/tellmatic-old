<?php
/* modified to fit into tellmatic....

fixed link to work with absoulte path....
fixed root directory to match tm_filepath
not needed: included tm_config.inc
setting $accounts = array();

line 765:
//Tellmatic!
$home = TM_PATH."/files";

*/
//tellmatic
define("TM_DOCROOT",$_SERVER["DOCUMENT_ROOT"]);
$self=$_SERVER["PHP_SELF"];
$pathinfo=pathinfo($self);
$tm_dir_tmp=str_replace("/include/myftphp","",$pathinfo['dirname']);
//ersten slash killen!!! sonst klappt das nich mit php_self, da doppelslash und das raffen manche browser nich!
if (substr($tm_dir_tmp, 0,1)=="/") {
	$tm_dir_tmp=substr($tm_dir_tmp, 1,strlen($tm_dir_tmp));
}
define ("TM_DIR",$tm_dir_tmp);

define("TM_INCLUDEDIR","include");
define("TM_PATH",TM_DOCROOT."/".TM_DIR);
define("TM_INCLUDEPATH",TM_PATH."/".TM_INCLUDEDIR);
include(TM_INCLUDEPATH."/Functions.inc.php");

/********_________________some_note____________________********/
/*****////////////////////////////////////////////////////*****/
/***                                                        ***/
/***  http://myftphp.sf.net                                 ***/
/***                                                        ***/
/***  alright, my file manager:                             ***/
/***      multiple users                                    ***/
/***      tree view                                         ***/
/***      thumbnail galleries                               ***/
/***      language support                                  ***/
/***      famfamfam icons                                   ***/
/***      minimalistic use of javascript                    ***/
/***         to make it work in almost every browser        ***/
/***  mail me on questions, hints and requests              ***/
/***                                                        ***/
/***  knittl <knittl89@yahoo.de>                            ***/
/***      <http://knittl.net.tf>                            ***/
/***                                                        ***/
/*****====================================================*****/
/***                                                        ***/
/***  Silk icon set 1.3                                     ***/
/***  by Mark James <mjames@gmail.com>                      ***/
/***     <http://www.famfamfam.com/lab/icons/silk/>         ***/
/***                                                        ***/
/*****////////////////////////////////////////////////////*****/

// _known issues:_
//   - there are still some issues using the dir-up link,
//   - if you are in a parent dir of the myftphp-dir
//     - didn't figure out a function that works the way i want
//
//   - the user limitations for dirs should work now
//     - limited to home dir now

// _tasks atm:_
//	 * implementing checkboxes > multiple file operations
//	 * archive support (down & upload): zip, tar.gz/bz2, rar
//	 * sorting view list: name, size, modified
//   * packing all colors into an single array for central color definition
//   * login with forwarding to requested page: should be fixed within one minute - done
//   * showing icons of filetype either in dirview or galleryview
//   * translations
//     * french
//     * italian
//     * spanish
//     * ...
//

// _tasks in the future:_
//   * refactoring/oop recode: class based
//     * exception handler to log errors
//   * better themeability
//

if (version_compare(phpversion(), "5.0", ">=")) {
	$usePhp5 = true;
} else {
	$usePhp5 = false;
}
define("PHP5",$usePhp5);
if (PHP5) ini_set('zend.ze1_compatibility_mode', '1');

//__configuration__
// user accounts,
// must exist, but if array is empty *no* authentification happens
// user => (md5(password), home-dir[w/o ending slash], language name, theme name)
$accounts = array();

// image files
$img = array(
	'del'      => 'page_delete.png',
	'dir'      => 'folder.png',
	'dirup'    => 'folder_go.png',
	'download' => 'arrow_down.png',
	'drive'    => 'drive_web.png',
	'edit'     => 'page_edit.png',
	'enter'    => 'door_in.png',
	// error: must be png
	'error'    => 'error.png',
	'exit'     => 'door_out.png',
	'explore'  => 'folder_explore.png',
	'find'     => 'find.png',
	'home'     => 'house.png',
	'images'   => 'images.png',
	'info'     => 'information.png',
	'keyboard' => 'keyboard.png',
	'newdir'   => 'folder_add.png',
	'newfile'  => 'page_white_add.png',
	'ok'       => 'accept.png',
	'pwd'      => 'key.png',
	'reload'   => 'arrow_refresh_small.png',
	'rem'      => 'folder_delete.png',
	'ren'      => 'link_edit.png',
	'src'      => 'page_code.png',
	'thumbs'   => 'application_view_tile.png',
	'tree'     => 'folder_magnify.png',
	'upload'   => 'attach.png',
	'upzip'    => 'compress.png',
	'user'     => 'group.png',
	'water'    => '../water.gif',

	'asc'  => 'bullet_arrow_up.png',
	'desc' => 'bullet_arrow_down.png',
);
//filetypes and extensions
$ftypes = array(
	'acrobat' => array('pdf'),
	'as'      => array('as'),
	'c#'      => array('cs'),
	'c'       => array('c'),
	'c++'     => array('cpp'),
	'cf'      => array('cfm'),
	'code'    => array('css', 'js'),
	'db'      => array('sql', 'mdb', 'mde'),
	'doc'     => array('doc', 'dot'),
	'fh'      => array('fh'),
	'fla'     => array('fla', 'swf'),
	'h'       => array('h'),
	'html'    => array('htm','html','shtml'),
	'iso'     => array('iso'),
	'msvs'    => array(),
	'office'  => array(),
	'php'     => array('php', 'php3'),
	'ppt'     => array('ppt', 'pps', 'pot'),
	'rb'      => array('rb'),
	'svg'     => array('svg'),
	'txt'     => array('txt', 'rtf', 'ini'),
	'xls'     => array('xls', 'xlt'),
	'zip'     => array('zip'),
	'zipped'  => array('rar', 'gz', 'bz2', '7zip'),
);

//filetype images
$icons = array(
	'no'      => 'page_white.png',
	'acrobat' => 'page_white_acrobat.png',
	'as'      => 'page_white_actionscript.png',
	'c#'      => 'page_white_csharp.png',
	'c'       => 'page_white_c.png',
	'c++'     => 'page_white_cplusplus.png',
	'cf'      => 'page_white_coldfusion.png',
	'code'    => 'page_white_code.png',
	'db'      => 'page_white_database.png',
	'doc'     => 'page_white_word.png',
	'fh'      => 'page_white_freehand.png',
	'fla'     => 'page_white_flash.png',
	'h'       => 'page_white_h.png',
	'html'    => 'page_white_world.png',
	'iso'     => 'page_white_cd.png',
	'msvs'    => 'page_white_visualstudio.png',
	'office'  => 'page_white_office.png',
	'php'     => 'page_white_php.png',
	'ppt'     => 'page_white_powerpoint.png',
	'rb'      => 'page_white_ruby.png',
	'svg'     => 'page_white_vector.png',
	'txt'     => 'page_white_text.png',
	'xls'     => 'page_white_excel.png',
	'zip'     => 'page_white_compressed.png',
	'zipped'  => 'page_white_zip.png',
);

ini_set('post_max_size', '256M');
@set_time_limit(60);


//___main script____
//include dirs, w/o slash
$langdir  = 'myftphp_lang';
$imgdir   = 'myftphp_img/silk';
#$imgdir  = 'nocvs/gfx/old_images';
$icondir  = 'myftphp_img/silk/icons';
$themedir = 'myftphp_themes';

//file-tree, bool
//if directoy tree takes too many resources to read > set to zero or decrease the value of $level
$tree = 1;

//depth of recursion in treeview > 1
//0: infinite recursion, ATTENTION: may crash server or make script not useable anymore
//please consider recursive symbolic links as a problem
//default: 2
$level = 2;

//thumbnailing config
//maxw & maxh are pixel values
$maxw       = 65;
$maxh       = 65;
$imgquality = 90;
$perline    = 5;
$resizeall  = false;

//^^configuration^^





// donotchange
///////////////////////
#error_reporting(E_ALL ^ E_STRICT);
#if(@date_default_timezone_set('Europe/Vienna')){}

// init debug buffer
$debug = '';
$errmsg = '';
$allok  = false;

// classes
//error class
class mfp_error {
	var $errmsg;
	var $errcount;

	function mfp_error() {
		$this->errmsg   = array();
		$this->errcount = 0;
	}

	function add($errtext) {
		$this->errmsg[$this->errcount] = $errtext;
		$this->errcount++;
	}
	function printout() {
		echo '<b>:::E:R:R:O:R:::</b> <br><br>';
		foreach($this->errmsg as $msg) {
			echo $msg . "<br>\n";
		}
	}
} $error = new mfp_error();

// session class... under construction
class mfp_session {
	var $user;
	var $on;
	var $id;
	var $name;

	function mfp_session($sessionname) {
		$this->name = session_name($sessionname);
		session_start();
		$this->init();
	}

	function init() {
		$this->user = &$_SESSION['myftphp_user'];
		$this->on   = &$_SESSION['myftphp_on'];
		$this->id   = SID;
	}

	// add session id
	function dosid($uri) {
		if (!empty($this->id) && !preg_match('#'.$this->name.'=#', $uri))
			$uri .= (strpos($uri, '?') !== false ? '&amp;' : '?'). SID;
		return $uri;
	}
	function login() {
	}

	function _user() { return $this->user; }
	function _on() { return $this->on; }
} $session = new mfp_session('myftphp');

//listing classes
 class mfp_list {
	var $list;
	var $count;

	function mfp_list() {
		$this->list = array();
		$this->count = 0;
	}
	#function add(array $listArray) {}
	function printout() {}

	function get($index) { return $this->list[$index]; }
	function getCount() { return $this->count; }
	function getArray() { return $this->list; }

	// adding independent of keys
	function add($listArray) {
		foreach($listArray as $key => $value) {
			$this->list[$this->count][$key] = $value;
		}
		/*foreach($listArray as $element => $current) {
			foreach($current as $key => $prop) {
				$this->list[$this->count][$key] =
			}
		}*/
		$this->count++;
	}

	// -- sort, experimental -- but seems to work quite reasonable
	function sortList($param, $case = true) {
		if(!(empty($param) || empty($this->list))) {
			$tosort = substr($param, 1);
			$tosort = array_key_exists($tosort, $this->list[0]) ? $tosort : 'name';
			$order  = $param{0};
			$order  = $order == '-' ? SORT_DESC : SORT_ASC;
			// array needs to be restructured for this
			// get columned array
			foreach ($this->list as $file => $props) {
				foreach($props as $key => $prop) {
					${$key}[$file] = $case ? strtolower($prop) : $prop;
				}
			}
			array_multisort($$tosort, $order, $this->list);
		}
	}
}
class mfp_dirs extends mfp_list {
	#private $l = &$GLOBALS['l'];

	function add($dirArray) {
	if(!($dirArray['name'] == '..' || $dirArray['name'] == '.'))
		parent::add($dirArray);
	}

	function printout() {
		//print directories as table with alternating colored lines
		global $l;
		global $session;

		$oe = 0;
		foreach($this->list as $dir) {
			//kein . or ..
			if($dir['name'] != '.' && $dir['name'] != '..') {
				$oe++;
			?>
			<tr class="<?=($oe % 2) ? 'o' : 'e'?>">

			<td class="left"></td>
			<td><a href="<?=$session->dosid(SELF.'?a=rem&amp;dir='.$dir['path'])?>" title="<?=$l['removedir']?>" onClick="popUp(this.href, 'remwin'); return false;"><img src="<?=img('rem')?>" width="16" height="16"></a></td>
			<td><a href="<?=$session->dosid(SELF.'?a=ren&amp;file='.$dir['path'])?>" title="<?=$l['renamedir']?>" onClick="popUp(this.href, 'renwin'); return false;"><img src="<?=img('ren')?>" width="16" height="16"></a></td>
			<td><!--<a href="<?=$session->dosid(SELF.'?a=gallery&amp;dir='.$dir['path'])?>" title="<?=$l['viewthumbs']?>"><img src="<?=img('thumbs')?>" width="16" height="16"></a>--></td>
			<td><a href="<?=$session->dosid(SELF.'?a=tree&amp;dir='.$dir['path'])?>" title="<?=$l['viewdir']?>" target="tree"><img src="<?=img('tree')?>" width="16" height="16"></a></td>
			<?##?>
			<th><a href="<?=$session->dosid(SELF.'?a=view&amp;dir='.urlencode($dir['path']))?>" title="<?=$l['changedir']?>" class="rnd"><?=$dir['name']?></a></th>
			<td></td>
			<td></td>

			<td><?= $dir['perm'] ?></td>
			<td class="right"><?=@date($l['fulldate'], $dir['lmod']); ?></td></tr>
			<?
			}
			echo "\n";
		}
	}
	#function get($index) { return $this->list[$index]; }
}
class mfp_files extends mfp_list {
	#private $l = &$GLOBALS['l'];

	function printout() {
		//print files and alternate lines
		global $l;
		global $session;
		$oe = 0;
		foreach($this->list as $file) {
			$oe++;

			$size = getfsize($file['size'], true);
			$sizedesc = $size[1];
			$size     = $size[0];

			$directlink = $file['path'];

			/*// windows fuck - should be dependent of os in future
			if(allowed($directlink)) {
				$directlink = relativePath($directlink);
				$directlink = str_replace('\\', '/', $directlink);
			} else {
				$directlink = '.';
			}*/

			//Tellmatic!
			$directlink = relativePath($directlink);
			$directlink = TM_DIR."/files".$directlink;
			//ouch!
			$directlink="http://".$_SERVER["HTTP_HOST"]."/".str_replace("include/myftphp","",$directlink);
			//echo $directlink."<br>";

		?>
		<tr class="<?=($oe % 2) ? 'o' : 'e'?>">
		<td class="left"><a href="<?=$session->dosid(SELF.'?a=down&amp;file='.$file['path'])?>" title="<?=$l['download']?>"><img src="<?=img('download')?>" width="16" height="16" alt="<?=$l['download']?>"></a></td>
		<td><a href="<?=$session->dosid(SELF.'?a=del&amp;file='.$file['path'])?>" title="<?=$l['deletefile']?>" onClick="popUp(this.href, 'delwin'); return false;"><img src="<?=img('del')?>" width="16" height="16" alt="<?=$l['delete']?>"></a></td>
		<td><a href="<?=$session->dosid(SELF.'?a=ren&amp;file='.$file['path'])?>" title="<?=$l['renamefile']?>" onClick="popUp(this.href, 'renwin'); return false;"><img src="<?=img('ren')?>" width="16" height="16" alt="<?=$l['rename']?>"></a></td>
		<td><a href="<?=$session->dosid(SELF.'?a=edit&amp;file='.$file['path'])?>" title="<?=$l['editcode']?>" onClick="popUp(this.href, 'editwin', 'width=640,height=480'); return false;"><img src="<?=img('edit')?>" width="16" height="16" alt="<?=$l['edit']?>"></a></td>

		<td><a href="<?=$session->dosid(SELF.'?a=src&amp;file='.$file['path'])?>" title="<?=$l['showsrc']?>" onClick="popUp(this.href, 'showwin', 'width=700,height=500'); return false;"><img src="<?=img('src')?>" width="16" height="16" alt="<?=$l['src']?>"></a></td>
		<td><a href="<?=$session->dosid($directlink)?>" title="<?=$l['viewfile']?>" target="_blank" class="rnd"><?=$file['name']?></a></td>
		<td><?= $size ?></td>
		<td><?= $sizedesc ?></td>
		<td><?= $file['perm'] ?></td>
		<td class="right"><?= @date($l['fulldate'], $file['lmod']) ?></td>
		</tr>
		<?}
	}
}

// activate buffering
#header('X-ob_mode: ' . 1);
//compression buffer + content buffer
//using tellmatic function
m_obstart();
ob_start();


// sessions - moved to class
/*session_name('myftphp');
session_start();
$on = &$_SESSION['myftphp_on'];
$user = &$_SESSION['myftphp_user'];*/

// gets magicquotes, scriptlink, and browser
define('MQUOTES', get_magic_quotes_gpc());
define('SELF', $_SERVER['PHP_SELF']);
define('AGENT', $_SERVER['HTTP_USER_AGENT']);
// check or internet explorer
if(strpos(AGENT, 'MSIE') !== false) define('IE', true);
else define('IE', false);

$clipboard = &$_SESSION['clipboard'];

// language initiation
$l = array();
$l['login']           = 'login';
$l['err']['badlang']  = 'Language does not exist!';
$l['err']['badtheme'] = 'Theme does not exist!';
$l['err']['baduser']  = 'User does not exist!';
$l['err']['home']     = 'Root-Directory does not exist!';

$lang = $session->_user() ? $accounts[$session->_user()]['lang'] : 'english';
if(!@include('./' . $langdir . '/' . $lang . '.ini.php')) {
	echo $l['err']['badlang'];
	exit();
}

//colors #RGB, #RRGGBB, rgb(rrr,ggg,bbb), color name
$c = array();
$c['txt']        = '#111';
$c['bg']['main'] = '#EFF';

$theme = $session->_user() ? $accounts[$session->_user()]['theme'] : 'light';
if(!@include('./' . $themedir . '/' . $theme . '.ini.php')) {
	echo $l['err']['badtheme'];
	exit();
}


// some functions
// format filesize to a reasonable number
function getfsize($size, $array = false) {

	$byte = &$GLOBALS['l']['byte'];

	//init
	$factor = 1;
	$sizedesc = '';


	//convert to kilo, mega, giga, tera, peta und exa ;)
	//microsoft behavior :-/ > means: check is performed with 1000 and calculated with 1024
	if($size > 1000) {
		$factor *= 1024;
		$sizedesc = $byte['k'];        }
	if($size > 1000 * 1000) {
		$factor *= 1024;
		$sizedesc = $byte['m'];        }
	if($size > 1000 * 1000 * 1000) {
		$factor *= 1024;
		$sizedesc = $byte['g'];        }
	if($size > 1000 * 1000 * 1000 * 1000) {
		$factor *= 1024;
		$sizedesc = $byte['t'];        }
	if($size > 1000 * 1000 * 1000 * 1000 * 1000) {
		$factor *= 1024;
		$sizedesc = $byte['p'];        }
	if($size > 1000 * 1000 * 1000 * 1000 * 1000 * 1000) {
		$factor *= 1024;
		$sizedesc = $byte['e'];        }

	//float number with a precision of two
	if($array) {
		$return = array(sprintf('%02.2f', $size / $factor), $sizedesc . $byte['b']);
	} else {
		$return = sprintf('%02.2f', $size / $factor) .' '. $sizedesc . $byte['b'];
	}
	return $return;
}

// wrap long strings
function wrap($str, $at = 20) {
	return wordwrap($str, $at, "<br>\n", true);
}

// insert image links
function img($img) {
	return $GLOBALS['imgdir'] .'/'. $GLOBALS['img'][$img];
}

// check for subdir
function allowed($path) {
	if(strpos(realpath($path), HOME) === 0) return true;
	return false;
}

//show relative path - substracts $home
function relativePath($path, $home = HOME) {
	#return str_replace(realpath($_SERVER['DOCUMENT_ROOT']), '', realpath($path));
	return str_replace(realpath($home), '', realpath($path));
}

// action -> todo?
$a = &$_GET['a'];

// cases available without login
// (bout,css,logout)
switch($a) {
	//__logout__
	case 'logout':
		#unset($_SESSION['myftphp_on']);
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-42000, '/');
		}
		session_destroy();
		header('Location: '. $session->dosid(SELF));
		exit();
	break;
	//^^logout^^

	//__bout__
	case 'bout':
		$title = $l['title']['bout'];
		?>
		<style type="text/css">
		<!--
			body { background-repeat:repeat; }
		-->
		</style>

		<div id="fix">
		<center><a href="http://myftphp.sf.net" target="_blank">myFtPhp</a>, 2007 </center>
		</div>

		<div id="scroll" style="background-color:<?=$c['bg']['main']?>; -moz-border-radius:2.5em; padding:1em; <?if(IE) echo 'filter:alpha(opacity=80) DropShadow(color=#C0C0C0, offx=3, offy=3);'?> -moz-opacity:0.8; opacity:0.8;">

		Code and idea: Knittl<br>
		<a href="http://sourceforge.net/projects/myftphp">&lt;sourceforge.net/projects/myftphp&gt;</a><br>

		<a href="mailto:knittl89@yahoo.de">&gt;knittl89@yahoo.de&lt;</a>
		<br><br>
		<hr>
		<a href="http://www.famfamfam.com/lab/icons/silk/">Silk icon set 1.3</a> by	<u>Mark James</u>
		<br>
		His work is licensed under a
		<a href="http://creativecommons.org/licenses/by/2.5/">Creative Commons Attribution 2.5 License</a><br>

		<hr>
		</div>
	<?break;
	//^^bout^^

	//__css__
	case 'css':
	//set filetype to css
	header('Content-Type: text/css');
	?>
	body {
		color:<?=$c['txt']?>;
		background-color:<?=$c['bg']['main']?>;
		background-image:url(<?=img('water')?>);
		background-repeat:no-repeat;
		background-attachment:fixed;
		background-position:bottom right;

		<?if(IE) { // only works in ie?>
			scrollbar-face-color:<?=$c['scrollbars']['face']?>;
			scrollbar-highlight-color:<?=$c['scrollbars']['highlight']?>;
			scrollbar-shadow-color:<?=$c['scrollbars']['shadow']?>;
			scrollbar-3dlight-color:<?=$c['scrollbars']['3dlight']?>;
			scrollbar-arrow-color:<?=$c['scrollbars']['arrow']?>;
			scrollbar-track-color:<?=$c['scrollbars']['track']?>;
			scrollbar-darkshadow-color:<?=$c['scrollbars']['darkshadow']?>;
		<?}?>

	}
	iframe { border:none; margin:0px; }

	input, textarea, button {
		background-color:<?=$c['bg']['input']?>;
		border:1px solid <?=$c['border']['dark']?>;
		border-top-color:<?=$c['border']['light']?>;
		border-left-color:<?=$c['border']['light']?>;
		color:<?=$c['txt']?>;
		padding:0.3em;
		-moz-border-radius:0.4em;
	}
	textarea { background-color:<?=$c['bg']['inputlite']?>; font-family:monospace; -moz-border-radius:1em; }
	input { padding:0pt; text-indent:2px; }
	button { padding:0pt; -moz-border-radius:0.3em; background-color:transparent; cursor:pointer; }

	input[type=text] {
		background-image:url(<?=img('keyboard')?>);
		background-repeat:no-repeat;
		border:1px solid <?=$c['border']['lite']?>;
		border-bottom:1px solid <?=$c['border']['dark']?>;
		<?#personal flavour?>
		text-indent:5px;
		-moz-border-radius:0.6em 0.6em 0 0;
	}
	input:hover { background-color:<?=$c['bg']['inputhover']?>; text-decoration:underline; }
	input[type=text]:focus { background-image:url(); background-color:<?=$c['bg']['inputlite']?>; text-decoration:none; }
	input[type=submit] {
		font-weight:bold;
		background-image:url(<?=img('ok')?>);
		background-repeat:no-repeat;
		background-position:left center;
		text-indent:16px;
	}

	a { color:<?=$c['a']['link']?>; text-decoration:none; font-weight:bold; font-family:system,monospace; }
	a:hover { color:<?=$c['a']['hover']?>; background-color:<?=$c['a']['bghover']?>; text-decoration:underline; }
	a.rnd { padding:0pt 0.5em; }
	a.rnd:hover { -moz-border-radius:0.5em; }
	a.lrnd:hover { -moz-border-radius:0.5em 0 0 0.5em; }

	a img { border:1px <?=!IE ? 'transparent' : $c['bg']['main']; ?> solid; }
	a:hover img {
		border:1px <?=$c['border']['img']['shade']?> solid;
		border-top-color:<?=$c['border']['img']['light']?>;
		border-left-color:<?=$c['border']['img']['light']?>;
	}

	#fix {
		position:fixed;
		top:0pt; left:0pt;
		background-color:<?=$c['bg']['fix']?>;
		display:block;
		width:100%;
		margin:0px;
		border-bottom:1px <?=$c['border']['fix']?> solid;
		-moz-border-radius:0 0 2em 2em;
		padding:0px;
		padding-top:0.4em;
		padding-left:0.5em;
		overflow:hidden;
		float:left; clear:both;
		<?= IE ? 'filter:alpha(opacity=90);' : null?> -moz-opacity:0.9; opacity:0.9;
	}

	#fix * { margin:0px; padding:0px; }
	<?if(!IE) echo '#scroll { margin-top:2.5em; }'?>

	#fm {
		top:60pt; left:0pt;
		background-color:<?=$c['bg']['fix']?>;
		display:block;
		width:100%;
		height:600px;
		margin:0px;
		border-bottom:1px <?=$c['border']['fix']?> solid;
		-moz-border-radius:0 0 2em 2em;
		padding:0px;
		padding-top:0.4em;
		padding-left:0.5em;
		overflow:hidden;
		float:left; clear:both;
		<?= IE ? 'filter:alpha(opacity=90);' : null?> -moz-opacity:0.9; opacity:0.9;
	}

	table { border:none; border-collapse:collapse; padding:0; }
	table tr td.toprnd { -moz-border-radius:1em; }
	td.left  { -moz-border-radius:0.5em 0 0 0.5em; }
	td.right { -moz-border-radius:0 0.5em 0.5em 0; }

	col td { -moz-border-radius:1em 1em 0 0; }
	/*table tr.l th:hover, table tr.l:hover { background-color:#DDD; }*/

	th { text-align:left; padding:0pt; margin:1px 1px; }

	/* hovered table rows */
	table tr.e:hover,
	table tr.o:hover,
	table tr.e:hover th,
	table tr.o:hover th,
	table tr.hover th,
	table tr.hover {
		background-color:<?=$c['bg']['tablehover']?>;
	}

	td { padding:0px 3px; }

	tr.treeUp { border-top:1px <?=$c['border']['ruler']?> solid; font-weight:bolder; }

	.e, .o { white-space:nowrap; }
	.o { background-color:<?=$c['o']?>; }

	tr.l a { display:block; white-space:nowrap;}
	tr.l a img.folder { display:inline; }
	tr.l a:hover img.folder { display:none; }
	tr.l a img.explore { display:none; }
	tr.l a:hover img.explore { display:inline; }

	.e a, .o a { display:block; }

	label:hover { background-color:<?=$c['bg']['inputhover']?>; -moz-border-radius:0.5em; }

	img { vertical-align:middle; border:0px none; }
	hr { color:blue; background-color:white; width:80%; }
	<?
	// omit further output
	return;
	break;
	//^^css^^

	//__default__
	default:


// root: chmod 0777
//$home = !empty($accounts[$session->_user()]['home']) ? $accounts[$session->_user()]['home'] : '.';

//Tellmatic!
$home = $tm_path."/files";

// is root existing?
if(!(define('HOME', realpath($home))) || !is_dir($home)) {
	$_SESSION['myftphp_on'] = false;
	#$_SESSION['myftphp_user'] = false;
	die(sprintf($l['err']['home'], $home));
	#die('Bad root');
}


// main script
if($session->_on() || (empty($accounts) && isset($accounts))) {
//logged in or empty user array

//what to do?
switch($a) {
//a(ction) = (del,down,edit,find,gallery,new,rem,ren,src,thumb,tree,up,view,'default')



//__del__
case 'del':
//delete file
$title = $l['title']['del'];
?>

<table width="100%" height="100%">

<tr>
	<td align="center">

<?
if(isset($_POST['delete'])) {
$file = &$_POST['file'];

	if(isset($file)) {
		$realpath = wrap(relativePath($file));
		if(allowed($file)) {
			if(@unlink($file)) {
				printf($l['ok']['deletefile'], $realpath);
			} else {
				printf($l['err']['deletefile'], $realpath);
			}
		} else {
			printf($l['err']['forbidden'], $realpath);
		}
	}
?>
<br><br>
	<form name="myftphp_form" action="javascript:window.close()">
	<input name="closebut" type="submit" value="  <?=$l['close']?>  " onClick="window.close()">
	<script type="text/javascript" language="JavaScript">
	<!--
			opener.location.reload();

			document.myftphp_form.closebut.focus();
	//-->
	</script>
	</form>

<?
} else {
?>

<form method="post" action="<?=$session->dosid(SELF.'?a=del')?>">
	<input type="hidden" name="file" value="<?=$_GET['file']?>">

	<?printf($l['warn']['reallydel'], wrap(relativePath($_GET['file'])))?><br>

	<input type="submit" name="delete" value="  <?=$l['delete']?>  ">&nbsp;
	<input type="button" name="cancel" value="  <?=$l['cancel']?>  " onClick="window.close()">
</form>

<? } ?>
	</td>
</tr>

</table>

<?
break;
//^^del^^


//__down__
case 'down':
//download
$title = $l['title']['down'];

$file = &$_GET['file'];
//filename passed?
if(isset($file)) {

	if(file_exists($file)) {
		if(allowed($file)) {
			// clean output buffer
			ob_clean();

			// set filetype -not needed anymore
			#header('Content-type: x-type/x-subtype');

			// set filename for download
			header('Content-Disposition: attachment; filename=' . basename($file));
			// read and print file content
			readfile($file);

			exit();
		} else {
			printf($l['err']['forbidden'], $file);
		}
	} else {
		printf($l['err']['nofile'], $file);
	}
} else {
	echo $l['err']['nofile'];
}

break;
//^^down^^


//__edit__
case 'edit':
$title = $l['title']['edit'];
//fixed line
?>
	<form method="post" action="<?=$session->dosid(SELF.'?a=edit')?>" name="form" onSubmit="return confirm('<?printf($l['warn']['reallysave'], (addcslashes(relativePath($_REQUEST['file']), '\\')))?>'); return false;">
	<div id="fix">
		<input type="submit" name="save" value="  <?=$l['save']?>  " accessKey="s">&nbsp;
		<input type="button" name="reset" value="  <?=$l['reset']?>  " onClick="setText()">&nbsp;
		<input type="button" name="cancel" value="  <?=$l['close']?>  " onClick="window.close()">&nbsp;
		<input type="button" name="showsource" value="  <?=$l['showsrc']?>  "
		onClick="popUp('<?=$session->dosid(SELF.'?a=src&amp;file='.$file)?>', 'highwin', ',width=500,height=400')">
	</div>

	<div id="scroll">
	<?if(isset($_POST['save'])) {

	$file = &$_POST['file'];

		if(allowed($file)) {
			if($handle = @fopen($file, 'w+b')) {

				$content = &$_POST['source'];
				if(MQUOTES) {
					$content = stripslashes($content);
				}

				if($written = fwrite($handle, $content)) {
					printf($l['ok']['writefile'], wrap(relativePath($file)), getfsize($written));
					echo '<hr>';
				} else {
					printf($l['err']['writefile'], $file);
				}
			} else {
				printf($l['err']['openfile'], $file);
			}
			@fclose($handle);
		} else {
			printf($l['err']['forbidden'], $file);
		}
		echo '<br>';

	}# else {

		$file = &$_REQUEST['file'];

		if(allowed($file)) {

			if(($handle = @fopen($file, 'rb')) !== false) {
				if(($source = @fread($handle, filesize($file))) === false) {
					printf($l['err']['readfile'], $file);
				} else {
					echo ucfirst($l['file']).': "<i>' . wrap(relativePath($file)) . '</i>"<br>';
					echo '('.getfsize(filesize($file)).')';
				}
			@fclose($handle);
	?>


		<textarea name="source" width="100%" height="80%" style="width:100%; height:80%;" cols="10" rows="20" wrap="off"><?=htmlspecialchars($source);?></textarea>
		<?#<textarea name="source" cols="65" rows="20"></textarea>?>
		<?#<textarea name="source" width="100%" height="80%"></textarea>?>
		<input type="hidden" name="file" value="<?=$file?>">
		<br>

	</div>
	</form>
	<script type="text/javascript" language="JavaScript">
	<!--
		opener.location.reload();
	//-->
	</script>


	<script type="text/javascript" language="JavaScript">
	<!--
		var area = document.form.source
		var nowText = area.value;

		function setText() {
			area.value = nowText;
		}
	//-->
	</script>
<?
		} else {
			printf($l['err']['openfile'], $file);
		}

	} else {
		printf($l['err']['forbidden'], $file);
	}
#}
break;
//^^edit^^

//__find__
case 'find':
$title = $l['title']['find'];
	// find files recursive
	$dir   = &$_REQUEST['dir'];
	$realdir = relativePath($dir);
	if(allowed($dir)) {

	?>
<div id="fix">
<form method="post" action="<?=$session->dosid(SELF.'?a=find')?>">
	<input type="hidden" name="dir" value="<?=$dir?>">

	<table>
	<tr>
		<td><a href="<?=$session->dosid(SELF.'?a=view&amp;dir='.$dir);?>"><img src="<?=img('explore')?>" width="16" height="16" title="<?=$l['viewdir']?>"></a></td>
		<td><a href="<?=$session->dosid(SELF.'?a=gallery&amp;dir='.$dir);?>"><img src="<?=img('thumbs')?>" width="16" height="16" title="<?=$l['viewthumbs']?>"></a></td>
		<td><a href="<?=$session->dosid($_SERVER['REQUEST_URI']);?>"><img src="<?=img('reload')?>" width="16" height="16" title="<?=$l['reload']?>"></a></td>
		<td><?#printf($l['searchfor'], $realdir)?>
		<input type="text" name="term" value="<?=isset($_POST['term'])?$_POST['term']:''?>" maxlength="201" size="50" style="width:25em;">&nbsp;&nbsp;
		<input type="submit" name="find" value=" <?=$l['find']?> ">

		</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td><label for="case"><input type="checkbox" name="case" id="case"> <?=$l['casesensitive']?></label>
		<label for="exact"><input type="checkbox" name="exact" id="exact"> <?=$l['exactmatch']?></label>

		<label for="rec"><input type="checkbox" name="rec" id="rec"> <?=$l['findsubdirs']?></label>
		</td>
	</tr>
</table>
</form>
</div>

<div id="scroll">
<?
	if(isset($_POST['find'])) {

		if(isset($dir)) {

			$realdir = wrap(relativePath($dir));

			$matches['dirs'] = new mfp_dirs();
			$matches['files'] = new mfp_files();

			function match($haystack, $needle) {
				$case  = &$_POST['case'];
				$exact = &$_POST['exact'];

				if($case) {
					return strpos($haystack, $needle);
				} else {
					return stripos($haystack, $needle);
				}
				return false;
			}

			function recursiveFind($dir) {
				$term  = &$_POST['term'];
				global $matches;

				$handle = @opendir($dir);
					while($file = @readdir($handle)) {
						$path = $dir.'/'.$file;
						$stat = @lstat($path);

						// one can't check too much
						if(allowed($dir)) {
							if(is_dir($path)) {
								if($file != '.' && $file != '..') {
									if(match($file, $term) !== false) {
										$matches['dirs']->add(array(
											'name' => $file,
											'path' => $path,
											'lmod' => $stat[9],
											'perm'    => decoct(@fileperms($path)%01000)
										));
									}

									//recursion
									recursiveFind($path);
								}
							} else {
								if(match($file, $term) !== false) {

									$matches['files']->add(array(
										'name' => $file,
										'path' => $path,

										'size'     => $stat[7],
										'lmod'  => $stat[9],
										'perm'     => decoct(@fileperms($path)%01000)
									));
								}
							}
						}
					}
				@closedir($handle);
				return true;
			}

				//recursion
				if(recursiveFind($dir)) {
					?>
					<br><br>
					<form name="myftphp_form" action="javascript:window.close()">
					<table>

					<? //dirs
					if($matches['dirs']->getCount()>0) {
						$matches['dirs']->printout();
					} else {	?>
						<tr>
							<td colspan="11"><?=$l['err']['nodirs']?></td>
						</tr>
					<? } ?>

				<tr style="border-top:1px <?=$c['border']['ruler']?> solid;">
					<td colspan="11">&nbsp;</td>
				</tr>
					<? //files
					if($matches['files']->getCount()>0) {
						$matches['files']->printout();
					} else {	?>
						<tr>

							<td colspan="11"><?=$l['err']['nofiles']?></td>
						</tr>
					<? } ?>

					</table>
					</form>
			<?
			} else {
				printf($l['err']['find'], $realdir);
			}
		} else {
			printf($l['err']['baddir'], $dir);
		}

} ?>
</div>

<?
	} else {
		printf($l['err']['forbidden'], $dir);
	}
break;
//^^find^^

//__gallery__
case 'gallery':
// thumbnail gallery
$title = $l['title']['thumbs'];

$dir = &$_GET['dir'];
	if(isset($dir)) {
		if(allowed($dir)) {

			if(file_exists($dir)) {
				//init
				$thumbdirs = new mfp_dirs();
				$thumbfiles = new mfp_files();

				#$filecount = $dircount = 0;
				#$files = $dirs = array();

				// benchmark...
				#$start = microtime(1);

				$handle = @opendir($dir);
				while($file = @readdir($handle)){

					$filepath = $dir.'/'.$file;
					$stat = @lstat($filepath);

					if(is_file($filepath)) {
						$size = explode(' ', getfsize(filesize($filepath)));

						$thumbfiles->add(array(
							'name' => $file,
							'path' => $filepath,

							'size' => $size[0],
							'sizedesc' => $size[1],

							'perm'    => decoct(@fileperms($path)%01000),

							'lmod' => $stat[9]
						));
					} else if(is_dir($filepath)) {
						#if(!($file == '.' || $file == '..')) {
						$thumbdirs->add(array(
							'name' => $file,
							'path' => $filepath,

							'stat' => @lstat($filepath),
							'perm' => decoct(@fileperms($filepath)%01000),

							'lmod' => $stat[9]
						));
					}
				}
				@closedir($handle);

				#$end = microtime(1);
				#echo $end-$start;

				#$start = microtime(1);

				$nowdir = &$dirs[0]['path'];
				$thisdir = dirname($nowdir);

				$lastFolder = (substr($thisdir, -2)) == '..'
						? $thisdir . '/..'
						: dirname($thisdir);
				#*/
				$updir = $lastFolder;
				$dirs[0]['path'] = $updir;
				$dirs[0]['name'] = $l['up'];


				// grid output
				?>

				<!-- quick access panel, fixed -->

				<div id="fix">
					<input type="hidden" name="dir" value="<?=dirname($dir)?>">

					<table>
					<tr class="l">
						<td><a href="<?=$session->dosid(SELF.'?a=view&amp;dir='.$dir);?>"><img src="<?=img('explore')?>" width="16" height="16" title="<?=$l['viewdir']?>"></a></td>
						<td><a href="<?=$session->dosid(SELF.'?a=find&amp;dir='.$dir);?>"><img src="<?=img('find')?>" width="16" height="16" title="<?=$l['find']?>"></a></td>
						<td><a href="<?=$session->dosid(SELF.'?a=gallery&amp;dir='.$dir);?>"><img src="<?=img('reload')?>" width="16" height="16" title="<?=$l['reload']?>"></a></td>
						<td><img src="<?=img('images')?>" width="16" height="16">

						(<?=$thumbfiles->getcount()?>)
						</td>

						<td><img src="<?=img('dir')?>" width="16" height="16">
						(<?=$thumbdirs->getcount()?>)
						</td>
						<td><?='&nbsp;&nbsp;'.($dir)?></td>

					</tr>
					</table>

				</form>
				</div>

				<center id="scroll"><br>
				<table style="border-collapse:collapse; text-align:center;"><tr class="e"><td colspan="<?=$perline?>"></td>
				<?	//dirs
				$oe = $i = 0;
				foreach($thumbdirs->getArray() as $dir) {
					if($dir['name'] != '.' && $dir['name'] != '..') {
						$newline = !($i % $perline);
						if($newline) {
							$oe++; ?>
					</tr>
					<tr class="<?=($oe % 2) ? 'o' : 'e'?>">
						<?}?>

						<td><a href="<?=$session->dosid(SELF.'?a=gallery&amp;dir='.$dir['path'])?>">
						<img src="<?=img('dir')?>" width="<?=$maxw?>" height="<?=$maxh?>"></a>
						<?=$dir['name']?>
						</td>
						<?
						$i++;
					}
				}?>
					<td colspan="<?=$perline-($i % $perline)?>"></td>

			<tr><td colspan="<?=$perline?>">&nbsp;</td></tr>

				<? //files
				$oe = $i = $block = 0;
				foreach($thumbfiles->getArray() as $file) {
					$newline = !($i % $perline);
					if($newline) {
						$oe++;
				?>
			</tr>

			<tr class="<?=($oe % 2) ? 'o' : 'e'?>">
				<?}?>
				<td><a href="<?=$file['path']?>" target="_blank">
				<img src="<?=$session->dosid(SELF.'?a=thumb&amp;file='.$file['path'])?>" width="<?=$maxw?>" height="<?=$maxh?>"></a><?= $file['size'].$file['sizedesc']?><br>
				<?#=$file['name']?>
				</td>
				<?
				$i++;
				}	?>
			<td colspan="<?=$perline-($i % $perline)?>"></td>
			</tr></table></center>

			<?}

			#$end = microtime(1);
			#echo $end-$start;
		} else {
			printf($l['err']['forbidden'], $dir);
		}
	} else {
			echo $l['err']['baddir'];
	}
break;
//^^gallery^^

//__multi__
//multiple file ops, still under *construction*
case 'multi':
echo '<pre>';

#var_dump($_POST);
#var_dump($_GET);
var_dump($_REQUEST);
$dir = &$_GET['dir'];

echo '</pre>';
if(isset($_REQUEST['ren'])) {
	echo 'renaming...<br>';
	foreach($_POST['chks'] as $name) {
	?>
		<?=$dir?> // <?=$name?><br>
	<?}
}
if(isset($_REQUEST['del'])) {
	echo 'deleting...<br>';
}
if(isset($_REQUEST['down'])) {
	echo 'downloading...<br>';
}
if(isset($_REQUEST['src'])) {
	echo 'show code...<br>';
}
if(isset($_REQUEST['edit'])) {
	echo 'editing...<br>';
}
break;
//^^multi^^

//__new__
case 'new':
$title = $l['title']['new'];
?>

<table width="100%" height="100%">
<tr>
	<td align="center">

<?
	if(isset($_POST['create'])) {
		$allok = true;
		if(allowed($_POST['dir'])) $allok = true;
			else { $allok = false; $error->add(sprintf($l['err']['forbidden'], $_POST['dir'])); }

	} else { $allok = false; $error->add('Forbidden'); }

if($allok === true) {

		$newname = $_POST['dir'] . '/' . $_POST['filename'];
		$newtextname = wrap(relativePath($_POST['dir']) .'/'. $newname);

		if(!empty($_POST['filename'])) {

			switch($_POST['what']) {

				case 'dir':
					if(file_exists($newname)) {
						printf($l['err']['direxists'], $newtextname);
					} else {
						if(@mkdir($newname)) {
							printf($l['ok']['createdir'], $newtextname);
						} else {
							printf($l['err']['createdir'], $newtextname);
						}
					}
				break;

				case 'file':
					if(file_exists($newname)) {
						printf($l['err']['fileexists'], $newtextname, getfsize(filesize($newname)));
				} else {
						if($handle = @fopen($newname, 'w+b')) {
							printf($l['ok']['createfile'], $newtextname);
						} else {
							printf($l['err']['createfile'], $newtextname);
						}
						@fclose($handle);
					}
				break;
			}

?>
			<br><br>
			<form name="myftphp_form" action="javascript:window.close()">
			<input name="closebut" type="submit" value="  <?=$l['close']?>  " onClick="window.close()">

			<?= $_POST['what'] == 'file' ? '<input name="editbut" type="button" value="  '.$l['editcode'].'  " onClick="document.location = \''.$session->dosid(SELF.'?a=edit&amp;file='.$newname).'\';">' : "\n" ?>

			<script type="text/javascript" language="JavaScript">
			<!--
					opener.location.reload();
					opener.document.quickform.filename.value = "";
					opener.parent.tree.location.reload();

					document.myftphp_form.closebut.focus();
			//-->
			</script>
			</form>

<?
		} else {
			echo $l['err']['emptyfield'];
		}
	} else {
		$error->printout();
	}
?>

	</td>

</tr>
</table>

<?
break;
//^^new^^


//__rem__
case 'rem':
//remove directory recursive
$title = $l['title']['rem'];
?>
<table width="100%" height="100%">
<tr>
		<td align="center">

<?
if(isset($_POST['remove'])) {

	$dir = &$_POST['dir'];
	if(!allowed($dir)) die('permission denied');

	$realdir = relativePath($dir);
	$wrapdir = wrap($realdir);

	function recursiveRem($dir) {
		global $debug;

		$handle = @opendir($dir);
			while($file = @readdir($handle)) {
				$path = $dir.'/'.$file;

				// coz of symlinks
				if(allowed($path)) {
					if(is_dir($path)) {
						if($file != '.' && $file != '..') {
							//recursion
							recursiveRem($path);
							rmdir($path);
							$debug.= '<br><b>dir: '.$path.'</b>';
						}
					} else {
						unlink($path);
						$debug.= '<br>file: '.$path;
					}
				}
			}
		@closedir($handle);
		return true;
	}

	//recursion
	if(recursiveRem($dir)) {
		//remove directory itself
		// shouldn't remove rootdir - needs workaround
		if(!allowed($dir) ||
			HOME == realpath($dir)) die('ouch');
		rmdir($dir);
		printf($l['ok']['deletedir'], $wrapdir);
?>
			<br><br>
			<form name="myftphp_form" action="javascript:window.close()">
			<input name="closebut" type="submit" value="  <?=$l['close']?>  " onClick="window.close()">

			<script type="text/javascript" language="JavaScript">
			<!--
				opener.location.reload();
				opener.parent.tree.location.reload();

				document.myftphp_form.closebut.focus();
			//-->
			</script>
			</form>
		<?
		} else {
			printf($l['err']['deletedir'], $realdir);
		}

} else {
	$dir = &$_GET['dir'];
	if(allowed($dir)) {

		$wrapdir = wrap(relativePath($_GET['dir']));
		// confirm - very ugly
?>
<form method="post" action="<?=$session->dosid(SELF.'?a=rem')?>" onSubmit="return confirm('Remove <?=addcslashes(relativePath($dir), '\\')?>?'); return false;">
	<input type="hidden" name="dir" value="<?=$dir?>">
	<?printf($l['warn']['reallyrem'],$wrapdir)?><br>
	<?=$l['warn']['alldirs']?><br>
	<input type="submit" name="remove" value=" <?=$l['remove']?> ">&nbsp;
	<input type="button" name="cancel" value="  <?=$l['cancel']?>  " onClick="window.close()">

</form>
<?} else {
		printf($l['err']['forbidden'], $_GET['dir']);
	}
} ?>
	</td>
</tr>
</table>


<?
break;
//^^rem^^


//__ren__
case 'ren':
$title = $l['title']['ren'];
?>
<table width="100%" height="100%">
<tr>
	<td align="center">
	<?
	$oldfile = &$_POST['oldfile'];

	if(isset($_POST['rename'])) {

		if(file_exists($oldfile)) {
			if(allowed($oldfile)) {
				if(!empty($_POST['newname'])) {

					$newname = dirname($oldfile).'/'.$_POST['newname'];

					if(rename($_POST['oldfile'], $newname)) {
						printf($l['ok']['rename'], $oldfile, $newname);
					} else {
						printf($l['err']['rename'], $oldfile, $newname);
					}
				} else {
					echo $l['err']['emptyfield'];
				}
		?><br><br>
		<form name="myftphp_form" action="javascript:window.close()">

		<input name="closebut" type="submit" value="  <?=$l['close']?>  " onClick="window.close()">
		<script type="text/javascript" language="JavaScript">
		<!--
				opener.location.reload();
				document.myftphp_form.closebut.focus();
		//-->
		</script>
		</form>
		<?
			} else {
				printf($l['err']['forbidden'], $oldfile);
			}
		// /isset
		} else {
			printf($l['err']['badfile'], $oldfile);
		}
	} else {

		$file = &$_GET['file'];
		if(file_exists($file)) {
			if(allowed($file)) {
	?>
	<script type="text/javascript" language="JavaScript">
	<!--
		function chkform() {
			if(document.forms.renform.newname.value == '') {
				alert('<?=$l['err']['emptyfield']?>');
				return false;
			}
			return true;
		}
	//-->
	</script>


	<form method="post" action="<?=$session->dosid(SELF.'?a=ren')?>" name="renform" onSubmit="return chkform(); return false;">
		<input type="hidden" name="oldfile" value="<?=$file?>">

		<?printf($l['renameto'], basename($file))?><br>
		<input type="text" name="newname" value="<?=basename($file)?>"><br>
		<input type="submit" name="rename" value=" <?=$l['rename']?> ">&nbsp;
		<input type="button" value="  <?=$l['cancel']?>  " onClick="window.close()">
	</form>

	<?	} else {
				printf($l['err']['forbidden'], $file);
			}
		} else {
			printf($l['err']['badfile'], $file);
		}
	}?>
	</td>
</tr>
</table>

<?
break;
//^^ren^^

//__src__
case 'src':
// show source code
$title = $l['title']['src'];
$file = &$_GET['file'];

	if(isset($file)
		&& file_exists($file)
		&& allowed($file)) { ?>
		<div id="fix">
			<form method="post" action="<?=$session->dosid(SELF.'?a=edit')?>" target="editwin" onSubmit="popUp(this.action, 'editwin', 'width=640,height=480');">
			<input type="hidden" name="file" value="<?=$_GET['file']?>">
			<input type="submit" name="edit" value="  <?=$l['editcode']?>  ">&nbsp;
			<input type="button" name="close" value="  <?=$l['close']?>  " onClick="window.close()">&nbsp;
			</form>
		</div>
		<div id="scroll" style="border:1px <?=$c['border']['fix']?> solid; padding:0.4em; -moz-border-radius:1em;">

		<?
		// another approach
		#/*
			// buffering highlighted source
			ob_start();
			show_source($file);
			$src = ob_get_contents();
			ob_end_clean();

			#$src = str_replace('&nbsp;', ' ', $src);
			// clean html
			$src = str_replace('<br />', '</span><br />', $src);
			$src = str_replace('<br />', '<br /><span>', $src);

			#$asrc = explode("\n", $src);
			#$asrc = preg_split('/?:\r\n|[\r\n]/', $src);
			$asrc = explode("<br />", $src);


		// shows colored source
			// still some fuck with multiline spans
		// with line numbers
		?>
		<ol style="font-family:monospace;">
		<?
		foreach($asrc as $line) { ?>
			<li><?=($line)?><br></li>
		<? } ?>
		</ol>

		</div>

		<?
	} else {
		printf($l['err']['badfile'], $_GET['file']);
	}
break;
//^^src^^


//__thumb__
case 'thumb':
// create thumbnailed images
// thx to http://www.weberdev.com/ViewArticle-388.html

	$file = $_GET['file'];

	if(isset($file)) {
		if(file_exists($file)
			&& allowed($file)) {

			ob_clean();

			//png in most cases better | just toggle the '#' in this and the generate paragraph below
			#header('Content-Type: image/jpg');/*
			header('Content-Type: image/png');/**/

			$wh = getimagesize($file);
			$w = $wh[0];
			$h = $wh[1];

			switch($wh[2]) {
				case 1:
					$oldimg = imageCreateFromGif($file);
				break;
				case 2:
					$oldimg = imageCreateFromJpeg($file);
				break;
				case 3:
					$oldimg = imageCreateFromPng($file);
				break;
				default:
					//get extension - and draw file icon
					$ext = strtolower(substr(strrchr($file,'.'),1));
					$resizeall = true;

					foreach($ftypes as $key => $val) {
						if(in_array($ext, $val)) {
							$imgpath = $icondir.'/'.$icons[$key];

							//draws file icon
							$wh = getimagesize($imgpath);
							$w = $wh[0];
							$h = $wh[1];
							$oldimg = imageCreateFromPng($imgpath);
						}
					}
					if(!isset($oldimg)) {
						// draws default error image
						$wh = getimagesize(img('error'));
						$w = $wh[0];
						$h = $wh[1];

						$oldimg = imageCreateFromPng(img('error'));
					}

/*					switch($ext) {
						default:
							// draws error image
							$wh = getimagesize($err);
							$w = $wh[0];
							$h = $wh[1];

							$oldimg = imageCreateFromPng($err);
						break;
					}
*/
				break;
			}


			if(($w > $maxw || $h > $maxh) || $resizeall) {
				$ratio = ($w >= $h) ? $maxw / $w : $maxh / $h;
				$nw = $w * $ratio;
				$nh = $h * $ratio;
			} else {
				$nw = $w;
				$nh = $h;
			}
			$newimg = imageCreate($maxw,$maxh);
			imageAntiAlias($newimg,true);
			//center image ;)
			imageCopyResampled($newimg,$oldimg,($maxw - $nw)/2,($maxh - $nh)/2,0,0,$nw,$nh, $w, $h);

			//send image - toggle 'tween jpeg/png
			#imageJpeg($newimg,'',$imgquality);/*
			imagePng($newimg);/**/
		} else {
			printf($l['err']['badfile'], $file);
		}
	} else {
		echo $l['err']['nofile'];
	}

	// end script - no further output
	return;
break;
//^^thumb^^


//__tree__
case 'tree':
// directories: tree view
$title = $l['title']['tree'];

	//if no dir was passed, use root instead
	$dir = isset($_GET['dir']) ? $_GET['dir'] : $home;
	if (!allowed($dir)) $dir = $home;

	//the maximum depth of directory tree
	$maxlevel = 0;

	//root
	$dirs = array();

	//walk through directories recursive
	function listTree($dir) {
		if(file_exists($dir)) {
			global $level, $dirs, $maxlevel;
			//doesn't get deleted after function call
			static $nowlevel = 0;

			$nowlevel++;
			//set new maximum depth
			$maxlevel < $nowlevel ? $maxlevel = $nowlevel : NULL;

			$handle = @opendir($dir);
			//maximum depth already reached, or infinite recursion?
			if($nowlevel <= $level || $level === 0) {
				//read directory
				while($file = @readdir($handle)) {
					$path = $dir.'/'.$file;

					//check if directory
					if(@is_dir($path)) {
						//don't fetch . and ..
						if($file != '.' && $file != '..') {

							//fill array
							$dirs[] = array (
								'name' => $file,
								'path' => $path,
								'level' => $nowlevel,
							);

							//descend deeper
							listTree($path);

							//level down -in logical structure up
							$nowlevel--;
						}
					//no directory: file, link or . and ..
					} else {
						#$dirs[$j]['subfiles']++;
					}
				}
			}
			@closedir($handle);
		} else {
			printf('<br><br>'.$GLOBALS['l']['err']['baddir'],$dir);
		}
	}

	//open requested dir
	listTree($dir);

	//print header line
	?>
<div id="fix" style="text-align:center;">
	<a href="<?=$session->dosid(SELF.'?a=tree&amp;dir='.$home);?>" title="<?=$l['home']?>"><img src="<?=img('home')?>" width="16" height="16"></a>
	<a href="<?=$session->dosid($_SERVER['REQUEST_URI']);?>" title="<?=$l['reload']?>"><img src="<?=img('reload')?>" width="16" height="16"></a>
</div>

<div id="scroll">
	<table width="100%">

		<tr class="l"><td>

		<a href="<?=$session->dosid(SELF.'?a=view&amp;dir='.$home)?>" target="view" class="lrnd">

			<img src="<?=img('home')?>" width="16" height="16" class="folder">
			<img src="<?=img('explore')?>" width="16" height="16" class="explore">
			Home [<?=basename(realpath($home)) ?>]
			</a>

			</td></tr>

<?
	//formatted output
	$prevlevel = 0;
	if($dirs) {
		foreach($dirs as $tmp) {

			$up = $prevlevel < $tmp['level'] ? ' treeUp' : '';
			echo '<tr class="l '.$up.'"><td>';

			#echo '<td colspan="'.($maxlevel - $tmp['level']).'" ';
			#echo $prevlevel > $tmp['level'] ? 'class="treeUp"' : null;

			echo '<a href="';
			echo $session->dosid(SELF.
								 '?a=view&amp;dir='.
								 $tmp['path']);
			echo '" target="view" ';
			echo 'class="lrnd"';
			echo '>';

			for($i = 0; $i < $tmp['level']; $i++) {
				echo '&nbsp&nbsp;';
			}

			echo "\n".'<img src="'.img('dir').'" width="16" height="16" class="folder">';
			echo '<img src="'.img('explore').'" width="16" height="16" class="explore">'."\n";
			echo $tmp['name'];
			echo '</a>';

			echo '</td></tr>';
			#echo '<br>';
			echo "\n";
			$prevlevel = $tmp['level'];
		}
	} else {
		echo $l['err']['nodirs'];
	}
	echo '</table>';
	echo '</div>';

break;
//^^tree^^

//__up__
case 'up':
// file upload
$title = $l['title']['up'];
?>

<table width="100%" height="100%">
<tr>
	<td align="center">

<?

// sent form
if(isset($_POST['upload'])) {

	$dir = ($_POST['dir']).'/';
	$overwrite = isset($_POST['over']);

	if(allowed($dir)) {

		$remotename = &$_FILES['file']['name'];
		$tmpname    = &$_FILES['file']['tmp_name'];
		$newname    = $dir . $remotename;

		$filesize = &$_FILES['file']['size'];
		$filetype = &$_FILES['file']['type'];

		$errorcode = &$_FILES['file']['error'];

		#dump($_POST);

		switch($errorcode) {
			case UPLOAD_ERR_NO_FILE:
				echo $l['err']['up']['nofile'];
			break;
			case UPLOAD_ERR_INI_SIZE:
				echo $l['err']['up']['toobig'];
			break;
			case UPLOAD_ERR_PARTIAL:
				echo $l['err']['up']['partially'];
			break;

			case UPLOAD_ERR_OK:
				if(file_exists($newname) && !$overwrite) {
					printf($l['err']['fileexists'], $newname, getfsize(filesize($newname)));
				} else {
					if(@move_uploaded_file($tmpname, $newname)){
						printf($l['ok']['up'] . '<br>', wrap(relativePath($newname)), getfsize($filesize));
						printf(ucfirst($l['filetype']).'<br>', $filetype);
					} else {
						printf($l['err']['unexpected'].'<br>', $errorcode);
					}
					echo '<script type="text/javascript" language="JavaScript">
					<!--
						opener.location.reload();
					//-->
					</script>';
				}
			break;
			default:
				echo $l['err']['up']['unknown'];
			break;
		}
		?>
		<br><input type="button" onClick="history.back();" value=" <?=$l['back']?> ">
		&nbsp;<input type="button" onClick="window.close();" value=" <?=$l['close']?> ">

	<?
	} else {
		printf($l['err']['forbidden'], $dir);
	}
} else {

	printf($l['uploadto'], wrap(relativePath($_GET['dir'])))?>:<br><br>
	<form enctype="multipart/form-data" method="post" action="<?=$session->dosid(SELF.'?a=up')?>">
		<input type="hidden" name="dir" value="<?=$_GET['dir']?>">

		<input type="file" name="file" size="40"><br>
		<input type="submit" name="upload" value=" <?=$l['upload']?> ">&nbsp;
		<input type="button" value=" <?=$l['cancel']?> " onClick="window.close();">&nbsp;
		<label for="over"><input type="checkbox" name="over" id="over"><?=$l['overwrite']?></label>
	</form>
<? } ?>

	</td>
</tr>
</table>

<?
break;
//^^up^^


//__view__
case 'view':
// view single directories
	$title = $l['title']['view'];

	//if no dir was passed, use root instead
	$dir = isset($_GET['dir']) ? $_GET['dir'] : $home;
	#//security
	#$dir = str_replace('\\', '/', relativePath($dir));

	// sorting values
	$sort = isset($_GET['sort']) ? $_GET['sort'] : '+name';

	//check if dir is *subdirectory* of root - thanks to vizzy
	#if(!allowed($dir)) $dir = $home;

	//flags
	$dir_exists = false;
	$dir_allowed = false;
	if(file_exists($dir)) $dir_exists = true;
		else { $dir_exists = false; $error->add(sprintf($l['err']['baddir'], $dir)); }
	if(allowed($dir)) $dir_allowed = true;
		else { $dir_allowed = false; $error->add(sprintf($l['err']['forbidden'], $dir)); }

	if($dir_exists && $dir_allowed) $allok = true;
		else $allok = false;

	if($allok) {
		// initiate objects
		$viewdirs = new mfp_dirs();
		$viewfiles = new mfp_files();

		// open directory and read it
		$handle = @opendir($dir);
		while($file = @readdir($handle)){

			$path = $dir.'/'.$file;
			$stat = @lstat($path);

				if(@is_dir($path)) {
					//directory

					//class
					$viewdirs->add(array(
						'name'    => $file,
						'path'    => $path,
						'lmod' => $stat[9],
						'perm'    => decoct(@fileperms($path)%01000)
					));

					/*if($file == '..') {
						$dirs[$i]['name'] = '__up__';
						$dirs[$i]['path'] = dirname(substr($filepath, 0, strrpos($filepath, '/')));
					}*/

				} else {
					//other(file, link)

					//file informationen
					$viewfiles->add(array(
						'name' => $file,
						'path' => $path,

						'size'     => $stat[7],
						'lmod'  => $stat[9],
						'perm'     => decoct(@fileperms($path)%01000)
					));
				}
		}
		//free handle
		@closedir($handle);


		//quick hack after new add method --needs workaround
		#$nowdir = $viewdirs->get(0);
		$nowdir = $dir.'/.';
		$thisdir = dirname($nowdir);

		//the one thing ding
		/*
		$lastslash = strrpos($thisdir,'/');
		 if (!$lastslash) { $lastFolder = $thisdir; }
		 else {
			 $lastFolder = substr($thisdir,0,$lastslash);
		 }#*/

		/* my try
		$lastFolder = (substr($thisdir, -2)) == '..'
				? $thisdir . '/..'
				: dirname($thisdir);
		#*/
		$lastFolder = dirname($thisdir);
		$updir = $lastFolder;
	?>

	<script type="text/javascript" language="JavaScript">
	<!--
		function chkform() {
				if(document.forms.quickform.filename.value == '') {
					alert("<?=$l['err']['emptyfield']?>");
					return false;
				}
				popUp('<?=$session->dosid(SELF.'?a=new')?>', 'newwin');
				return true;
		}
	//-->
	</script>

	<!-- quick access panel, fixed -->
	<div id="fix">
	<form method="post" name="quickform" action="<?=$session->dosid(SELF.'?a=new')?>" onSubmit="return chkform(); return false;" target="newwin">
		<input type="hidden" name="dir" value="<?=$thisdir?>">

		<table>

		<tr class="l">
			<td><!--<a href="<?=$session->dosid(SELF.'?a=gallery&amp;dir='.$dir)?>" title="<?=$l['viewthumbs']?>"><img src="<?=img('thumbs')?>" width="16" height="16"></a>--></td>
			<td><a href="<?=$session->dosid(SELF.'?a=find&amp;dir='.$dir)?>" title="<?=$l['find']?>"><img src="<?=img('find')?>" width="16" height="16" alt="<?=$l['find']?>"></a>
			</td>
			<td><a href="<?=$session->dosid($_SERVER['REQUEST_URI']);?>"><img src="<?=img('reload')?>" width="16" height="16" title="<?=$l['reload']?>"></a></td>
			<td><a href="<?=$session->dosid(SELF.'?a=up&amp;dir='.$dir)?>" onClick="popUp(this.href, 'upwin', 'width=440,height=200,status=yes'); return false;" title="<?=$l['uploadfile']?>">
			<img src="<?=img('upload')?>" width="16" height="16" alt="<?=$l['upload']?>"></a>
			</td>

			<td><input type="text" name="filename" maxlength="201" size="50" style="width:25em;"></td>
			<td><label for="file" title="<?=$l['createnewfile']?>">
			<input type="radio" name="what" value="file" id="file">
			<img src="<?=img('newfile')?>" width="16" height="16">
			(<?=$viewfiles->getCount()?>)
			</label></td>
			<td><label for="dir" title="<?=$l['createnewdir']?>">
			<input type="radio" name="what" value="dir" id="dir" checked>
			<img src="<?=img('newdir')?>" width="16" height="16">

			(<?=$viewdirs->getCount()?>)
			</label></td>

			<td>&nbsp;<input type="submit" name="create" value="<?=$l['new']?>"></td>
		</tr>
		</table>
	</form>
	</div>

	<div id="scroll"><br>

	<form method="post" action="<?=$session->dosid(SELF.'?a=multi&amp;dir='.$dir)?>">
		<table style="border-collapse:collapse;">
		<colgroup>
			<col>
			<col>
			<col>
			<col>
			<col>
			<col <?if(substr($sort,1) == 'name') echo 'style="background-color:'.$c['o'].';"'?>>
			<col <?if(substr($sort,1) == 'size') echo 'style="background-color:'.$c['o'].';"'?>>
			<col <?if(substr($sort,1) == 'size') echo 'style="background-color:'.$c['o'].';"'?>>
			<col <?if(substr($sort,1) == 'perm') echo 'style="background-color:'.$c['o'].';"'?>>
			<col <?if(substr($sort,1) == 'lmod') echo 'style="background-color:'.$c['o'].';"'?>>
		</colgroup>

		<?//sorting buttons?>
			<tr style="text-align:center;" class="toprnd">
				<td colspan="5"></td>
				<td class="toprnd"><a href="<?=$session->dosid(SELF.'?a=view&amp;sort=+name&amp;dir='.$dir)?>"><img src="<?=img('asc')?>" width="16" height="16"></a><a href="<?=$session->dosid(SELF.'?a=view&amp;sort=-name&amp;dir='.$dir)?>"><img src="<?=img('desc')?>" width="16" height="16"></a></td>
				<td colspan="2"><a href="<?=$session->dosid(SELF.'?a=view&amp;sort=+size&amp;dir='.$dir)?>"><img src="<?=img('asc')?>" width="16" height="16"></a><a href="<?=$session->dosid(SELF.'?a=view&amp;sort=-size&amp;dir='.$dir)?>"><img src="<?=img('desc')?>" width="16" height="16"></a></td>
				<td><a href="<?=$session->dosid(SELF.'?a=view&amp;sort=+perm&amp;dir='.$dir)?>"><img src="<?=img('asc')?>" width="16" height="16"></a><a href="<?=$session->dosid(SELF.'?a=view&amp;sort=-perm&amp;dir='.$dir)?>"><img src="<?=img('desc')?>" width="16" height="16"></a></td>
				<td><a href="<?=$session->dosid(SELF.'?a=view&amp;sort=+lmod&amp;dir='.$dir)?>"><img src="<?=img('asc')?>" width="16" height="16"></a><a href="<?=$session->dosid(SELF.'?a=view&amp;sort=-lmod&amp;dir='.$dir)?>"><img src="<?=img('desc')?>" width="16" height="16"></a></td>
			</tr>

		<? if(allowed(dirname($dir))) { ?>
			<tr class="l" style="border-bottom:1px <?=$c['border']['dark']?> solid;">
				<td></td>
				<td><a href="<?=$session->dosid(SELF.'?a=rem&amp;dir='.$dir);?>" onClick="popUp(this.href, 'remwin'); return false;"><img src="<?=img('rem')?>" width="16" height="16"></a></td>
				<td><a href="<?=$session->dosid(SELF.'?a=ren&amp;file='.$dir)?>" title="<?=$l['renamedir']?>" onClick="popUp(this.href, 'renwin'); return false;"><img src="<?=img('ren')?>" width="16" height="16"></a></td>
				<td></td>
				<td><a href="<?=$session->dosid(SELF.'?a=tree&amp;dir='.$dir)?>" title="<?=$l['viewdir']?>" target="tree"><img src="<?=img('tree')?>" width="16" height="16"></a></td>
				<th><a href="<?= $session->dosid(SELF.'?a=view&amp;dir='.$updir) ?>" title="<?=$l['changedir']?>" class="rnd">
				--<img src="<?=img('dirup')?>" width="16" height="16"><?=$l['up']?>--</a></th>

				<td></td><td></td>
				<td></td><td></td>
			</tr>
		<? } // /check for root
		$viewdirs->sortlist($sort);
		$viewdirs->printout();

		//spacing + ruler
		?>
			<tr style="border-top:1px <?=$c['border']['ruler']?> solid;">
				<td colspan="11">&nbsp;</td>
			</tr>
		<?
		$viewfiles->sortlist($sort);
		$viewfiles->printout() ?>

		</table>
	</form>

	</div>

	<?} else {
		$error->printout();
	}
break;
//^^view^^


//__default__
default:

//(i)frameset
$title = $l['title']['default'];
?>

<div id="fix">
<?=$session->_user()?>, <a href="<?=$session->dosid(SELF.'?a=logout')?>" title="<?=$l['logout']?>"><img src="<?=img('exit')?>" width="16" height="16"></a>
<a href="<?=$session->dosid(SELF.'?a=bout')?>" title="<?=$l['help']?>" onClick="popUp(this.href, 'helpwin'); return false;"><img src="<?=img('info')?>" width="16" height="16"></a>
&nbsp;&nbsp;|&nbsp;&nbsp;
<img src="<?=img('drive')?>" width="16" height="16">
<? //free space
	//bytes:
	$freespace = @disk_free_space($home);
	$location  = relativePath($home, $_SERVER['DOCUMENT_ROOT']);
	#echo realpath(HOME);

	//format and output
	printf($l['freespace'], getfsize($freespace), $location);
?>
</div>
<div id="fm">
<!-- //hier! die hoehe aendern-->
<table width="100%" height="500px"cellspacing="0" cellpadding="0" style="padding:0px; border-collapse:collapse; margin:0px; margin-top:2em;">
<tr>

	<? if($tree) {?><td width="185px" height="100%"><iframe src="<?=$session->dosid(SELF.'?a=tree&amp;dir='.$home)?>" height="100%" width="100%" name="tree" frameborder="0">Browser needs to understand inlineframes</iframe>
	</td><?}?>
	<td height="100%"><iframe src="<?=$session->dosid(SELF.'?a=view&amp;dir='.$home)?>" height="100%" width="100%" name="view" frameborder="0">
	Browser needs to understand inlineframes<br>
	<a href="<?=$session->dosid(SELF.'?a=view')?>">Load only directory view without tree view</a></iframe>
</td>
</tr>
</table>
</div>
<?
break;
//^^default^^
}

} else {
// no login yet
$title = $l['title']['login'];


$user = &$_POST['user'];

	if(isset($_POST['login'])) {

		$pass = &$accounts[$user]['pass'];
		if(isset($pass)) $allok = true;
			else { $allok = false; $error->add($l['err']['baduser']);
				if(md5($_POST['pwd']) == $pass) $allok = true;
					else { $error->add($l['err']['badpass']); }
			}

		if($allok === true) {

		@include('./' . $langdir . '/' . $accounts[$user]['lang'] . '.ini.php');
				$_SESSION['myftphp_on'] = true;
				$_SESSION['myftphp_user'] = &$user;
				header('Location: '.$session->dosid($_SERVER['REQUEST_URI']));
				echo $l['ok']['granted']."<br>\n";
				echo '<a href="'.$session->dosid($_SERVER['REQUEST_URI']).'">Click here if redirection doesn\'t work</a>';
		} else {
			$error->printout();
		}

	} else { ?>
	<table width="100%" height="100%">

	<tr valign="middle">
		<td><hr>
		<form method="post" action="<?=$session->dosid($_SERVER['REQUEST_URI'])?>">
			<table align="center" style="text-align:center;">
			<tr><td></td><td><img src="<?=img('water')?>" alt="myftphp"><a href="<?=$session->dosid(SELF.'?a=bout')?>" title="<?=$l['help']?>" onClick="popUp(this.href, 'helpwin'); return false;"><img src="<?=img('info')?>" width="16" height="16"></a></td></tr>
			<tr><td><img src="<?=img('user')?>" width="16" height="16"></td><td><input type="text" name="user" style="width:140px;" size="40"></td></tr>
			<tr><td><img src="<?=img('pwd')?>" width="16" height="16"></td><td><input type="password" name="pwd" style="width:140px;" size="40"></td></tr>
			<tr><td><img src="<?=img('enter')?>" width="16" height="16"></td><td><input type="submit" name="login" value="<?=$l['login']?> " style="width:140px;"></td></tr>
			</table>

		</form>
		<hr></td>
	</tr>
	</table>
	<?
	}
}
// end no login block
break;
}

?>

<? // get output buffer
$buffer = ob_get_contents();
ob_end_clean();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<title> [myFtPhp]&nbsp;&nbsp;<?=$title?> </title>

<meta name="author" content="Knittl">
<meta name="OBGZip" content="true">

<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet"  type="text/css" href="<?=$session->dosid(SELF.'?a=css')?>">
<?if(IE) { // double check for IE?>
<!--[if lt IE 7]><style type="text/css">
	@media screen {
		html, body { height: 100%; overflow: hidden; }

		#scroll { padding:0pt; margin:0pt; height: 95%; width: 100%; overflow: auto; }
		#scroll * { position: static; }
	}
</style><![endif]--><?
}?>
<script type="text/javascript">
<!--
	function popUp(url, name, size) {
		var xy = 'left=200,top=100';
		var size = size ? size  : 'width=500,height=300';
		win = window.open(url, name, xy + ',resizable=yes,scrollbars=yes,' + size);
		win.focus();
	}

	function co(e) {
		//if(!ev) ev = window.event;
		var x=(document.all)?window.event.x+document.body.scrollLeft:e.pageX;
		var y=(document.all)?window.event.y+document.body.scrollTop:e.pageY;
		alert (x+'< x |||| y >'+y);
		//alert('left='+ev.screenX+',top='+ev.screenY);
		var xy = 'left='+e.screenX+',top='+e.screenY;
		//meins = window.open('<?=SELF?>', 'me', xy + ',resizable=yes,scrollbars=yes,width=320,height=240');
	}
	//document.onclick = co;
//-->
</script>

</head>

<body>
<?
	// print buffer
	print($buffer);
?>
</body>
</html>

<? //end compressed buffer
ob_end_flush();?>