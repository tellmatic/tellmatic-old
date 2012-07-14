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

// bei import und delete diverse felder deaktivieren:
function checkImport() {
	form=document.getElementById('adr_import');
	field=document.getElementById('delete');
	if (field.checked)  {
		var changefield=document.getElementById('merge_groups');
	    changefield.disabled = true;
		var changefield=document.getElementById('adr_grp');
	    changefield.disabled = true;
		var changefield=document.getElementById('status_new');
	    changefield.disabled = true;
		var changefield=document.getElementById('status_exists');
	    changefield.disabled = true;
		var changefield=document.getElementById('aktiv_new');
	    changefield.disabled = true;
		var changefield=document.getElementById('aktiv_existing');
	    changefield.disabled = true;
		var changefield=document.getElementById('check_double');
	    changefield.disabled = true;
	} else {
		var changefield=document.getElementById('merge_groups');
	    changefield.disabled = false;
		var changefield=document.getElementById('adr_grp');
	    changefield.disabled = false;
		var changefield=document.getElementById('status_new');
	    changefield.disabled = false;
		var changefield=document.getElementById('status_exists');
	    changefield.disabled = false;
		var changefield=document.getElementById('aktiv_new');
	    changefield.disabled = false;
		var changefield=document.getElementById('aktiv_existing');
	    changefield.disabled = false;
		var changefield=document.getElementById('check_double');
	    changefield.disabled = false;
	}
}

function checkQNewLimitOffset() {
	form=document.getElementById('queue_new');
	field=document.getElementById('send_now');
	if (field.checked)  {
		var changefield=document.getElementById('usr_limit');
	    changefield.disabled = false;
		var changefield=document.getElementById('usr_offset');
	    changefield.disabled = false;
	} else {
		var changefield=document.getElementById('usr_limit');
	    changefield.disabled = true;
		var changefield=document.getElementById('usr_offset');
	    changefield.disabled = true;
	}
}


//flash element
function flash(id, color) {
	var element = document.getElementById(id);
	var color_cur = element.style.backgroundColor;
	element.style.backgroundColor = color;
	setTimeout("flash('" + id + "', '" + color_cur + "')", 1000);
}
      
//checkbox auswahl umkehren fuer alle checkboxen im formular !!!
//auwahl umkehren alle selectboxen in formular mit der id....
function checkAllForm(id) {
  for (var i = 0; i < document.getElementById(id).elements.length; i++) {
     if(document.getElementById(id).elements[i].type == 'checkbox'){
      document.getElementById(id).elements[i].checked = !(document.getElementById(id).elements[i].checked);
    }
  }
}

//auswahl umkehren bei checkboxen mit der id...., bei mehreren checkboxen mit gleichem namen.....  wir dnur der erste bearbeitet!!
function checkByID(id) {
  if(document.getElementById(id).type == 'checkbox'){
    document.getElementById(id).checked = !(document.getElementById(id).checked);
  }
}

//setzt den focus auf das erste test oder passwortfeld!
//aus squirrelmail
function checkForm() {
   var f = document.forms.length;
   var i = 0;
   var pos = -1;
   while( pos == -1 && i < f ) {
       var e = document.forms[i].elements.length;
       var j = 0;
       while( pos == -1 && j < e ) {
           if ( document.forms[i].elements[j].type == 'text'            || document.forms[i].elements[j].type == 'password' ) {
               pos = j;
           }
           j++;
       }
   i++;
   }
   if( pos >= 0 ) {
       document.forms[i-1].elements[pos].focus();
   }
}

//setzt style hintergrundfarbe ueber id
function setBGColor(my_id,color)
{
	element=document.getElementById(my_id);
	element.style.background=color;
}

//schreibt den inhalt von arg2 in einen bestimmten bereich mit der id arg1 , zbsp.ein div, der alte inhalt wird aber geloescht!!!
//irgendwo im netz gefunden
function doc_writer(arg1,arg2)
  {
    o = false;
    if (document.getElementById)
      { o = document.getElementById(arg1); }
    else if (document.all)
      { o = document.all[arg1]; }
    if (o)
      { o.innerHTML = arg2; }
    else if (document.layers)
      {
        with (document.layers[arg1].document)
          { 
            open();
            write(arg2);
            close();
          }
      }
  }     


function confirmLink(theLink, theMessage)
{
    confirmMsg='Sind Sie sich sicher?';
    if (confirmMsg == '' || typeof(window.opera) != 'undefined') {
        return true;
    }
    var is_confirmed = confirm(confirmMsg + ' \n' + theMessage);
    if (is_confirmed) {
        theLink.href += '&doit=1';
    }
    return is_confirmed;
} // end of the 'confirmLink()' function






opacity=0 //opacity of image
var increase=1 //increase opacity indicator
var decrease=0 //decrease opacity indicator

	
function switchSection(input)
{
	section=document.getElementById(input);
	if(section.style.display=="none")
	{
		section.style.display="block"
	}
	else
	{
		section.style.display="none"
	}
}


function fadein(objid){
	if (opacity<1)
		opacity+=0.05
	else{
		increase=0
		decrease=1
	}
	document.getElementById(objid).style.MozOpacity=opacity
}

function iflip(iname,img) {
 for(imageno=0;document.images[imageno];imageno++) {
	 if (document.images[imageno].name==iname) {
	 	window.document.images[imageno].src = img;
	 }
 }
}

/* setVisibility(objId, sVisibility)
* Parameters: 
* objId - the id of an element (case sensitive)
* sVisibility - "visible" | "inherit" | "none" (case insensitive)
*
* USAGE: 
* Show div1:
* onclick='setVisibility("div1","visible")' 
*
* Inherit the visibility of div2's parentNode:
* onblur='setVisibility("div2", "inherit")' 
*
* Hide span3:
* onblur='setVisibility("span3", "hidden")'
*/         

   function setVisibility(objId, sVisibility) {
        var obj = document.getElementById(objId);
         obj.style.visibility = sVisibility;
   }





WMTT=null;
document.onmousemove=updateToolTip;

function updateToolTip(e) 
{
	x=(document.all)?window.event.x+document.body.scrollLeft:e.pageX;
	y=(document.all)?window.event.y+document.body.scrollTop:e.pageY;
	
	if (WMTT!=null) 
	{		
		versetzungY=-150;
		versetzungX=-180;
		
		var WMTTID = WMTT.id;
		var ersterTeilDerID = WMTTID.substr(0,6);
		

			WMTT.style.left=(x+versetzungX)+"px";
			WMTT.style.top=(y+versetzungY+8)+"px";
	}
}
function showToolTip(id,inputposition) 
{
	updateToolTip;
	position=inputposition;
	WMTT=document.getElementById(id);
	WMTT.style.display="block"
}

function hideToolTip() 
{
	WMTT.style.display="none";
}





ini = new Date().getTime();
var pcld = 4;
var pc = 4;
var pct = 2;
var pctt = 1;


function load() {
pcld +=8
pc += 4;
pct += 2;
pctt += 1;

if (pc < 50) { 
	document.getElementById('ld').style.width = pcld + "%";
} else {
	pcld=8;
}
if (pc < 100) { 
	document.getElementById('lpc').style.width = pc + "%";
} else {
	pc=4;
}
if (pct < 100) { 
	document.getElementById('lt').style.width =  pct + "%";
} else {
	pct=2;
}
if (pctt < 100) { 
	document.getElementById('ltt').style.width =  pctt + "%";
} else {
	pctt=1;
}
time = setTimeout("load()",111);
//if (pc > 100) { clearTimeout(time); loaded() }

}

function loaded() {
fim = new Date().getTime();
dif = fim - ini;
document.getElementById('ld').style.display = 'none';

}


/**
 * Sets/unsets the pointer and marker in browse mode
 *
 * @param   object   the table row
 * @param   string   the action calling this script (over, out or click)
 * @param   string   the default background color
 * @param   string   the color to use for mouseover
 * @param   string   the color to use for marking a row
 *
 * @return  boolean  whether pointer is set or not
 */
function setPointer(theRow, theAction, theDefaultColor, thePointerColor, theMarkColor)
{
    var theCells = null;

    // 1. Pointer and mark feature are disabled or the browser can't get the
    //    row -> exits
    if ((thePointerColor == '' && theMarkColor == '')
        || typeof(theRow.style) == 'undefined') {
        return false;
    }

    // 2. Gets the current row and exits if the browser can't get it
    if (typeof(document.getElementsByTagName) != 'undefined') {
        theCells = theRow.getElementsByTagName('td');
    }
    else if (typeof(theRow.cells) != 'undefined') {
        theCells = theRow.cells;
    }
    else {
        return false;
    }

    // 3. Gets the current color...
    var rowCellsCnt  = theCells.length;
    var domDetect    = null;
    var currentColor = null;
    var newColor     = null;
    // 3.1 ... with DOM compatible browsers except Opera that does not return
    //         valid values with "getAttribute"
    if (typeof(window.opera) == 'undefined'
        && typeof(theCells[0].getAttribute) != 'undefined') {
        currentColor = theCells[0].getAttribute('bgcolor');
        domDetect    = true;
    }
    // 3.2 ... with other browsers
    else {
        currentColor = theCells[0].style.backgroundColor;
        domDetect    = false;
    } // end 3

    // 4. Defines the new color
    // 4.1 Current color is the default one
    if (currentColor == null || currentColor == ''
        || currentColor.toLowerCase() == theDefaultColor.toLowerCase()) {
        if (theAction == 'over' && thePointerColor != '') {
            newColor = thePointerColor;
        }
        else if (theAction == 'click' && theMarkColor != '') {
            newColor = theMarkColor;
        }
    }
    // 4.1.2 Current color is the pointer one
    else if (currentColor.toLowerCase() == thePointerColor.toLowerCase()) {
        if (theAction == 'out') {
            newColor = theDefaultColor;
        }
        else if (theAction == 'click' && theMarkColor != '') {
            newColor = theMarkColor;
        }
    }
    // 4.1.3 Current color is the marker one
    else if (currentColor.toLowerCase() == theMarkColor.toLowerCase()) {
        if (theAction == 'click') {
            newColor = (thePointerColor != '')
                     ? thePointerColor
                     : theDefaultColor;
        }
    } // end 4

    // 5. Sets the new color...
    if (newColor) {
        var c = null;
        // 5.1 ... with DOM compatible browsers except Opera
        if (domDetect) {
            for (c = 0; c < rowCellsCnt; c++) {
                theCells[c].setAttribute('bgcolor', newColor, 0);
            } // end for
        }
        // 5.2 ... with other browsers
        else {
            for (c = 0; c < rowCellsCnt; c++) {
                theCells[c].style.backgroundColor = newColor;
            }
        }
    } // end 5

    return true;
} // end of the 'setPointer()' function