<? //defines colors for myftphp
// negative theme
$c['txt']     = '#EEE';
$c['o'] = '#220';
#$c['e'] = ''; //recommended: transparent or ''
$c['bg'] = array(
	'main'       => '#100',
	'input'      => '#222',
	'inputlite'  => '#111',
	'inputhover' => '#332',
	'fix'        => 'black',
	'tablehover' => '#330',
);
$c['a'] = array(
	'link'    => '#DDD',
	'hover'   => '#FFF',
	'bghover' => '#110',
);
$c['border'] = array(
	'lite'  => '#333',
	'light' => '#996',
	'dark'  => '#FF9',
	'img'   => array(
		'shade' => '#C96',
		'light' => '#653'
	),
	'ruler' => '#FF6',
);
//won't work in array above
$c['border']['fix'] = $c['border']['ruler'];

//ie scrollbars
$c['scrollbars'] = array(
	'face'       => '#333',
	'highlight'  => '#303030',
	'shadow'     => '#3F3F3F',
	'3dlight'    => '#232323',
	'arrow'      => '#CCC',
	'track'      => $c['bg']['main'],
	'darkshadow' => '#434343'
);
?>