<?php
	$l['date']     = 'd.m.y';
	$l['time']     = 'H:i:s';
	$l['fulldate'] = $l['date'].', '.$l['time'];

	$l['cancel'] = 'abbruch';
	$l['close']  = 'beenden';

	$l['byte'] = array(
		'b' => 'b',
		'k' => 'k',
		'm' => 'm',
		'g' => 'g',
		't' => 't',
		'p' => 'p',
		'e' => 'e',
	);

	$l['back']   = 'zur&uuml;ck';
	$l['bout']   = '&uuml;ber';
	$l['change'] = '&auml;ndern';
	$l['code']   = 'code';
	$l['create'] = 'erzeugen';
	$l['delete'] = 'l&ouml;schen';
	$l['dir']    = 'verzeichnis';
	$l['empty']  = 'leer';
	$l['edit']   = 'bearbeiten';
	$l['field']  = 'textfeld';
	$l['file']   = 'datei';
	$l['find']   = 'suchen';
	$l['help']   = 'hilfe';
	$l['home']   = 'home';
	$l['img']    = 'bild';
	$l['login']  = 'einloggen';
	$l['logout'] = 'ausloggen';
	$l['new']    = 'neu';
	$l['reload'] = 'aktualisieren';
	$l['remove'] = 'entfernen';
	$l['rename'] = 'umbennen';
	$l['reset']  = 'zur&uuml;cksetzen';
	$l['save']   = 'speichern';
	$l['show']   = 'zeigen';
	$l['src']    = 'quelle';
	$l['to']     = 'nach';
	$l['up']     = 'hoch';
	$l['view']   = 'anzeigen';

	$l['err'] = array(
		'home' => 'Home-Verzeichnis "<i>%s</i>" existiert nicht.<br>
		<a href="'.SELF.'?mode=logout">'.$l['back'].'</a>',

		'unexpected' => 'Unerwarteter Fehler (%s).',
		'emptyfield' => ucfirst($l['field']).' ist '.$l['empty'],

		'up' => array(
			'nofile'  => 'Keine (existierende) '.$l['file'].' ausgew&auml;hlt.',
			'partial' => ucfirst($l['file']).' wurde nur teilweise hochgeladen',
			'toobig'  => ucfirst($l['file']).' zu gro&szlig;',
			'unknown' => 'Es trat ein unbekannter Fehler auf. Bitte an den Systemadministrator wenden',
		),

		'createfile' => 'Fehler beim Erzeugen der Datei "<i>%s</i>"',
		'deletefile' => 'Fehler beim L&ouml;schen der Datei "<i>%s</i>"',
		'fileexists' => 'Datei "<i>%1$s</i>" (%2$s) existiert bereits.',
		'openfile'   => 'Fehler beim &Ouml;ffnen der Datei "<i>%s</i>"',
		'readfile'   => 'Fehler beim Lesen der Datei "<i>%s</i>"',
		'writefile'  => 'Fehler beim Schreiben in Datei "<i>%s</i>"',

		'createdir'  => 'Fehler beim Erzeuen des Verzeichnisse "<i>%s</i>"',
		'direxists'  => 'Verzeichnis "<i>%s</i>" existiert bereits.',
		'removedir'  => 'Fehler beim Entferen des Verzeichnisses "<i>%s</i>',

		'rename' => 'Fehler beim Umbenennen von "<i>%1$s</i>" in "<i>%2$s</i>"',
		'find'   => 'Fehler beim Suchen in "<i>%1$s</i>"',

		'badfile'   => 'Datei "<i>%s</i>" existiert nicht',
		'nofile'    => 'Keine Datei ausgew&auml;hlt',
		'baddir'    => 'Verzeichnis "<i>%s</i>" existiert nicht',
		'nodirs'    => 'Keine Verzeichnisse zum anzeigen',
		'nofiles'   => 'Keine Dateien zum anzeigen',
		'forbidden' => 'Sie haben keine Berechtigungen um auf "<i>%s</i>" zuzugreifen',

		'badpass'  => 'Falsches Passwort!',
		'baduser'  => 'Benutzer existiert nicht!',
		'badtheme' => 'Theme existiert nicht!',
	);

	$l['warn'] = array(
		'reallyrem'  => 'Dieses Verzeichnis wirklich entfernen "<i>%s</i>"?',
		'alldirs'	   => '<b>ACHTUNG: alle</b> Dateien und Unterverzeichnisse werden auch gel&ouml;scht!',
		#'reallysave' => 'Wirklich speichern und diese Datei &uuml;berschreiben:\n \'%s\' ?',
		'reallysave' => 'Wirklich speichern und diese Datei &uuml;berschreiben:\\n \\\'%s\\\' ?',
		'reallydel'  => 'Diese Datei wirklich l&ouml;schen:	"<i>%s</i>"?',
	);

	$l['ok'] = array(
		'createdir'  => 'Verzeichnis "<i>%s</i>" erfolgreich erstellt',
		'createfile' => 'Datei "<i>%s</i>" erfolgreich erstellt',
		'deletedir'  => 'Verzeichnis "<i>%s</i>" wurde erfolgreich gel&ouml;scht',
		'deletefile' => 'Datei "<i>%s</i>" wurde erfolgreich gel&ouml;scht',
		'granted'    => 'Zugriff erlaubt, Login erfolreich',
		'rename'     => '"<i>%1$s</i> erfolgreich umbenannt in "<i>%2$s</i>"',
		'up'         => 'Datei erfolgreich auf: "<i>%1$s</i> (%2$s)" hochgeladen',
		'writefile'  => '%2$s Daten in Datei "<i>%1$s</i>" geschrieben',
	);

	$l['changedir']  = $l['dir'].' '.$l['change'];
	$l['download']   = 'herunterladen';
	$l['upload']     = 'hochladen';
	$l['uploadfile'] = $l['file'].' '.$l['upload'];
	$l['uploadrar']  = 'rar '.$l['upload'];
	$l['uploadzip']  = 'zip '.$l['upload'];

	$l['freespace'] = '<b>%1$s</b> freier Speicher auf <i>%2$s</i>';
	$l['filetype']  = 'Dateityp: <i>%s</i>';

	$l['createnewdir']  = 'Neues Verzeichnis erstellen';
	$l['createnewfile'] = $l['new'].'e '.$l['file'].' '.$l['create'];
	$l['deletefile']    = $l['file'].' '.$l['delete'];
	$l['editcode']      = $l['code'].' '.$l['edit'];
	$l['removedir']     = $l['dir'].' '.$l['remove'];
	$l['renamedir']     = $l['dir'].' '.$l['rename'];
	$l['renamefile']    = $l['file'].' '.$l['rename'];
	$l['renameto']      = '"<i>%s</i>" '.$l['rename'].' nach:<br>';
	$l['showsrc']       = $l['src'].' '.$l['show'];
	$l['viewfile']      = $l['file'].' '.$l['view'];
	$l['viewdir']       = $l['dir'].' '.$l['view'];
	$l['viewthumbs']    = $l['dir'].' als Thumbnail Gallerie anzeigen';
	$l['searchfor']     = 'Nach was suchen in "<i>%s</i>"';

	$l['casesensitive'] = 'Groß/Kleinschreibung beachten';
	$l['exactmatch']    = 'nur ganze Wörter';
	$l['findsubdirs']   = 'Unterverzeichnisse durchsuchen';

	$l['overwrite']  = '&Uuml;berschreiben';
	$l['uploadto']   = ucfirst($l['file']).' '.$l['to'].' '.$l['upload'].': "<i>%s</i>"';


	//titles for switch shid, same name as forks
	//except login
	$l['title'] = array(
		'default' => '[myFTPhp]',
		'bout'    => &$l['bout'],
		'del'     => &$l['deletefile'],
		'down'    => &$l['download'],
		'edit'    => &$l['editcode'],
		'find'    => 'Dateien und Ordner finden',
		'login'   => &$l['login'],
		'new'     => &$l['createnewfile'],
		'rem'     => &$l['removedir'],
		'ren'     => &$l['rename'],
		'src'     => &$l['showsrc'],
		'thumbs'  => 'thumbnail Gallerie',
		'tree'    => 'Ordner browsen',
		'up'      => 'Datei hochladen',
		'view'    => 'Ordner anzeigen',
	);
?>