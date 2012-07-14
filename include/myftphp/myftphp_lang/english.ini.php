<?php
	$l['date']     = 'y/m/d';
	$l['time']     = 'h:i:s a';
	$l['fulldate'] = $l['date'].' - '.$l['time'];

	$l['cancel'] = 'cancel';
	$l['close']  = 'close';

	$l['byte'] = array(
		'b' => 'b',
		'k' => 'k',
		'm' => 'm',
		'g' => 'g',
		't' => 't',
		'p' => 'p',
		'e' => 'e',
	);

	$l['back']   = 'back';
	$l['bout']   = 'about';
	$l['change'] = 'change';
	$l['code']   = 'code';
	$l['create'] = 'create';
	$l['delete'] = 'delete';
	$l['dir']    = 'directory';
	$l['empty']  = 'empty';
	$l['edit']   = 'edit';
	$l['field']  = 'textfield';
	$l['file']   = 'file';
	$l['find']   = 'find';
	$l['help']   = 'help';
	$l['home']   = 'home';
	$l['img']    = 'image';
	$l['login']  = 'login';
	$l['logout'] = 'logout';
	$l['new']    = 'new';
	$l['reload'] = 'refresh';
	$l['remove'] = 'remove';
	$l['rename'] = 'rename';
	$l['reset']  = 'reset';
	$l['save']   = 'save';
	$l['show']   = 'show';
	$l['src']    = 'source';
	$l['to']     = 'to';
	$l['up']     = 'up';
	$l['view']   = 'view';


	$l['err'] = array(
		'home' => 'Home-Directory "<i>%s</i>" doesn\'t exist.<br>
		<a href="'.SELF.'?mode=logout">'.$l['back'].'</a>',

		'unexpected' => 'An unexpected error occured (%s).',
		'emptyfield' => ucfirst($l['field']).' is '.$l['empty'],

		'up' => array(
			'nofile'  => 'No (existing) '.$l['file'].' selected.',
			'partial' => ucfirst($l['file']).' uploaded only partially',
			'toobig'  => ucfirst($l['file']).' too big',
			'unknown' => 'An unknown error occured. Please contact the system administrator ',
		),

		'createfile' => 'Error creating file "<i>%s</i>"',
		'deletefile' => 'Error deleting file "<i>%s</i>"',
		'fileexists' => 'File "<i>%1$s</i>" (%2$s) already exists.',
		'openfile'   => 'Error opening file "<i>%s</i>"',
		'readfile'   => 'Error reading file "<i>%s</i>"',
		'writefile'  => 'Error writing to file "<i>%s</i>"',

		'createdir'  => 'Error creating directory "<i>%s</i>"',
		'direxists'  => 'Directory "<i>%s</i>" already exists.',
		'removedir'  => 'Error removing directory "<i>%s</i>',

		'rename' => 'Error renaming "<i>%1$s</i>" to "<i>%2$s</i>"',
		'find'   => 'Error searching in directory "<i>%1$s</i>"',

		'badfile'   => 'File "<i>%s</i>" nonexistent',
		'nofile'    => 'No file selected',
		'baddir'    => 'Directory "<i>%s</i>" nonexistent',
		'nodirs'    => 'No directories to display',
		'nofiles'   => 'No files to display',
		'forbidden' => 'You don\'t have permission to access "<i>%s</i>"',

		'badpass'  => 'Wrong password!',
		'baduser'  => 'User does not exist!',
		'badtheme' => 'Theme does not exist!',
	);

	$l['warn'] = array(
		'reallyrem'  => 'Really remove this directory<br> "<i>%s</i>"?',
		'alldirs'	   => '<b>WARNING: all</b> files and directories inside this directory will also be removed!',
		#'reallysave' => 'Really save and overwrite this file:\n \'%s\' ?',
		'reallysave' => 'Really save and overwrite this file:\\n \\\'%s\\\' ?',
		'reallydel'  => 'Really delete this file:	"<i>%s</i>"?',
	);

	$l['ok'] = array(
		'createdir'  => 'Directory "<i>%s</i>" successfully created',
		'createfile' => 'File "<i>%s</i>" succuessfully created',
		'deletedir'  => 'Directory "<i>%s</i>" was susccessfully deleted',
		'deletefile' => 'File "<i>%s</i>" was susccessfully deleted',
		'granted'    => 'Access granted',
		'rename'     => '"<i>%1$s</i> successfully renamed to "<i>%2$s</i>"',
		'up'         => 'File successfully uploaded to:<br> "<i>%1$s</i>" (%2$s)',
		'writefile'  => '%2$s of data written into file "<i>%1$s</i>"',
	);

	$l['changedir']  = $l['change'].' '.$l['dir'];
	$l['download']   = 'download';
	$l['upload']     = 'upload';
	$l['uploadfile'] = $l['upload'].' '.$l['file'];
	$l['uploadrar'] = $l['upload'].' rar';
	$l['uploadzip'] = $l['upload'].' zip';

	$l['freespace'] = '<b>%1$s</b> of free space on <i>%2$s</i>';
	$l['filetype']  = 'filetype: <i>%s</i>';

	$l['createnewdir']  = $l['create'].' a '.$l['new'].' '.$l['dir'];
	$l['createnewfile'] = $l['create'].' a '.$l['new'].' '.$l['file'];
	$l['deletefile']    = $l['delete'].' '.$l['file'];
	$l['editcode']      = $l['edit'].' '.$l['code'];
	$l['removedir']     = $l['remove'].' '.$l['dir'];
	$l['renamedir']     = $l['rename'].' '.$l['dir'];
	$l['renamefile']    = $l['rename'].' '.$l['file'];
	$l['renameto']      = $l['rename'].' "<i>%s</i>" to:<br>';
	$l['showsrc']       = $l['show'].' '.$l['src'];
	$l['viewfile']      = $l['view'].' '.$l['file'];
	$l['viewdir']       = $l['view'].' '.$l['dir'];
	$l['viewthumbs']    = $l['viewdir'] . ' as thumbnail gallery';
	$l['searchfor']     = 'What to search for in "<i>%s</i>"';

	$l['overwrite']  = 'overwrite';
	$l['uploadto']   = ucfirst($l['upload']).' '.$l['file'].' '.$l['to'].' "<i>%s</i>"';

	$l['casesensitive'] = 'case sensitive';
	$l['exactmatch']    = 'whole word only';
	$l['findsubdirs']   = 'include sub directories';


	//titles for switch shid, same name as forks
	//except login
	$l['title'] = array(
		'default' => '[myFTPhp]',
		'bout'    => &$l['bout'],
		'del'     => &$l['deletefile'],
		'del'     => &$l['download'],
		'edit'    => &$l['editcode'],
		'find'    => 'find files and folders',
		'login'   => &$l['login'],
		'new'     => &$l['createnewfile'],
		'rem'     => &$l['removedir'],
		'ren'     => &$l['rename'],
		'src'     => &$l['showsrc'],
		'thumbs'  => 'thumbnail gallery',
		'tree'    => 'browse folders',
		'up'      => 'upload file',
		'view'    => 'view folder',
	);

?>
