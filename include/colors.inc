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

$r=0;
$g=0;
$b=0;
$ccc=0;
$step=64;

$_MAIN_OUTPUT .= "
		<script language=\"JavaScript\"> 
		<!-- 
		
		document.".$FormularName.".".$InputName_Color.".style.backgroundColor = document.".$FormularName.".".$InputName_Color.".value;
		
		function showhexcol(opentag, closetag) { 
			document.".$FormularName.".".$InputName_ColorView.".value= ''; 
			document.".$FormularName.".".$InputName_ColorView.".style.backgroundColor = opentag + closetag; 
		} 

		function genhexcol(opentag, closetag) { 
			document.".$FormularName.".".$InputName_Color.".value= opentag + closetag; 
			document.".$FormularName.".".$InputName_Color.".style.backgroundColor = opentag + closetag; 
		} 
		--> 
		</script> 
		"; 
		//=	document.".$FormName.".".$TagField.".value + opentag + closetag

$_MAIN_OUTPUT .= "<table border=\"0\" cellspacing=1  cellpadding=0>
						<tr>";


$cstep=(1536/$step);
$max_cols=$cstep;//sqrt($cstep*$cstep*$cstep);
for ($b=0; $b<=255; $b =$b+$step) {
	for ($g=0; $g<=255; $g =$g+$step) {
		for ($r=0; $r<=255; $r =$r+$step) {
			$tr=false;
			$col[0] = $r;
			$col[1] = $g;
			$col[2] = $b;
			$HEX=hexColor($col);
			$_MAIN_OUTPUT.= "<td bgcolor=\"#".$HEX."\">";
			$_MAIN_OUTPUT .= "<a href=\"javascript:genhexcol('#','".$HEX."');\" onmouseover=\"javascript:showhexcol('#','".$HEX."');\">";
			$_MAIN_OUTPUT.= "<img src=\"img/blank.png\" width=\"4\" height=\"4\" border=0>";
			$_MAIN_OUTPUT .= "</a>";
			$ccc++;
			if ($ccc % $max_cols==0) {
				$_MAIN_OUTPUT.= "</tr>";
				$_MAIN_OUTPUT.= "<tr>";
				$tr=true;
			}
		}
	}
}
$_MAIN_OUTPUT .= "</tr>
						</table>";
?>