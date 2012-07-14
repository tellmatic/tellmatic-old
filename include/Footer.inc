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


?><script type="text/javascript">

/*
	if (document.getElementById("head") && document.getElementById("head").style.MozOpacity) //if Firefox/ NS6+
	setInterval("fadein('head')",5)
*/
	if (document.getElementById("main_info") && document.getElementById("main_info").style.MozOpacity) //if Firefox/ NS6+
	setInterval("fadein('main_info')",5)

	if (document.getElementById("main_help") && document.getElementById("main_help").style.MozOpacity) //if Firefox/ NS6+
	setInterval("fadein('main_help')",5)
/*
	if (document.getElementById("menu") && document.getElementById("menu").style.MozOpacity) //if Firefox/ NS6+
	setInterval("fadein('menu')",5)
*/

/*
	if (document.getElementById("foot") && document.getElementById("foot").style.MozOpacity) //if Firefox/ NS6+
	setInterval("fadein('foot')",5)
*/
	if (document.getElementById("main_head") && document.getElementById("main_head").style.MozOpacity) //if Firefox/ NS6+
	setInterval("fadein('main_head')",25)
/*
	if (document.getElementById("main_detail") && document.getElementById("main_detail").style.MozOpacity) //if Firefox/ NS6+
	setInterval("fadein('main_detail')",5)
*/	
/*
	if (document.getElementById("main") && document.getElementById("main").style.MozOpacity) //if Firefox/ NS6+
	setInterval("fadein('main')",5)
*/	
	switchSection("sprechblase");
	switchSection("div_loader");
	switchSection("div_debug");
	switchSection("main_info");

	loaded();




//var draggers=document.getElementsByTagName('div')
//for (var i_tem = 0; i_tem < draggers.length; i_tem++)
//if ( draggers[i_tem].className=='drag' )
//	Drag.init(draggers)

<?php
if (!empty($_MAIN_MESSAGE)) {
	echo "switchSection('main_info');";
}

//drag macht nur probleme bei mouseover divs... ....
/*	
	echo "var draggers=document.getElementById('main_info');
			Drag.init(draggers);
			";
*/
/*
if (!empty($_MAIN_MESSAGE)) {
	echo "
			var draggers=document.getElementById('main_info');
			Drag.init(draggers);
			switchSection('main_info');
			";
}
*/
?>
</script>
<br>


<br>
</body>
</html>