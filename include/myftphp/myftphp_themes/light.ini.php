<? //defines colors for myftphp
// default - light theme
$c['txt']     = '#111';
$c['o'] = '#DDF';
#$c['e'] = ''; //recommended: transparent or ''
$c['bg'] = array(
	'main'       => 'cornsilk',
	'input'      => '#DDD',
	'inputlite'  => '#EEE',
	'inputhover' => '#CCD',
	'fix'        => 'white',
	'tablehover' => '#CCF',
);
$c['a'] = array(
	'link'    => '#222',
	'hover'   => '#000',
	'bghover' => '#EEF',
);
$c['border'] = array(
	'lite'  => '#CCC',
	'light' => '#669',
	'dark'  => '#006',
	'img'   => array(
		'shade' => '#369',
		'light' => '#9AC'
	),
	'ruler' => '#009',
);
//won't work in array above
$c['border']['fix'] = $c['border']['ruler'];

//ie scrollbars
$c['scrollbars'] = array(
	'face'       => '#CCC',
	'highlight'  => '#CFCFCF',
	'shadow'     => '#C0C0C0',
	'3dlight'    => '#DCDCDC',
	'arrow'      => '#333',
	'track'      => $c['bg']['main'],
	'darkshadow' => '#BCBCBC'
);
?>