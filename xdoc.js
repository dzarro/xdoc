
function setGen(form)
{
 document.xdoc.action ="./xdoc_path.php";
 document.xdoc.target="xdoc_path";
 document.xdoc.submit();

 var input1=form.cat.value;
 var input2=form.file.value;
 if ((input1.length) !== 0) {
  document.xdoc.target="xdoc_mods";
  document.xdoc.action ="./xdoc_cat.php" ;
  document.xdoc.submit();
  return true;
 }

 if ((input2.length) !== 0) {
  document.xdoc.target="xdoc_mods";
  document.xdoc.action ="./xdoc_search.php" ;
  document.xdoc.submit();
 }

 return true;
}

/////////////////////////////////////////////////////////////////////////////////

function handle(event,input)
{
 var key=event.keyCode || event.which;  
 document.xdoc.target="xdoc_mods";
 if (key === 13){
  if (input.name === "file") document.xdoc.action ="./xdoc_search.php" ;
  if (input.name === "cat" ) document.xdoc.action ="./xdoc_cat.php" ;  
  document.xdoc.submit();
  return true;
 }
}

/////////////////////////////////////////////////////////////////////////////////
function searchFile(btn)
{
   document.xdoc.target="xdoc_mods";
   
   if (btn.name === "Filename") document.xdoc.action ="./xdoc_search.php" ;
   if (btn.name === "Category") document.xdoc.action ="./xdoc_cat.php" ;
   document.xdoc.submit();
   return true;
}

//////////////////////////////////////////////////////////////////////////////////

function jsUpdateSize()
{
// Get the dimensions of the viewport
    
   // var width = window.innerWidth ||
   //             document.documentElement.clientWidth ||
   //             document.body.clientWidth;
   // var height = window.innerHeight ||
   //              document.documentElement.clientHeight ||
   //              document.body.clientHeight;
   
                 var h = $(window).height();
                 var d1 = $("#wrap1").outerHeight(true);
                 document.getElementById("wrap1").style.visibility="visible";
                 document.getElementById("wrap1").style.backgroundColor="#99ccff";
                 
                 var d2=(h-d1)/2;
                 document.getElementById("wrap2").style.top = d1+"px";
                 document.getElementById("wrap2").style.bottom = d2+"px";
				         document.getElementById("wrap2").style.visibility="visible";
                 document.getElementById("wrap2").style.zIndex="50";
                 
                 var d3 =(h+d1)/2;
			           document.getElementById("wrap3").style.top = d3 +"px";
			           document.getElementById("wrap3").style.bottom ="0px";
                 document.getElementById("wrap3").style.visibility="visible";
                 document.getElementById("wrap3").style.zIndex="100";
                                   
                 
}

///////////////////////////////////////////////////////////////////////////////

function defined(variable) {
 if (typeof(variable) !== 'undefined') {
  return true;
 } else {
  return false;
 }
} 

///////////////////////////////////////////////////////////////////////////////
// Javascript Popout Window 
// Written: Zarro (SAC/GSFC), August 1998

// url: URL to display in window
// height: window height in pixels [def=300]
// width: window width in pixels [def=300]
// name: window name [def='popup']
// text: boolean 1 or 0; if 1 entered URL is to be displayed as text

var win;

function popup(url,height,width,name,text,resize) {

if (!defined(name)) {var name='popup';}
               
// default to fit within 75% of browser window

var def_width=300;
if (window.screen){
 var screen_width=parseFloat(window.screen.width);
 def_width=parseInt(0.75*screen_width);
}
if (!defined(width)) {width=def_width;}
width=parseInt(width);
if (screen_width) { 
 if (width > screen_width) {width=def_width;}
}

var def_height=300;
if (window.screen){
 var screen_height=parseFloat(window.screen.height);
 def_height=parseInt(0.75*screen_height);
}
if (!defined(height)) {height=def_height;}
height=parseInt(height);
if (screen_height) { 
 if (height > screen_height) {height=def_height;}
}

var do_open=true;

if (typeof(win) == "object") {
 do_open=(win.closed || win.name != name);
}

if (!defined(resize)) {resize="yes";}

if (do_open) {
 win = open("",name,"width="+width.toString()+",height="+height.toString()+",scrollbars=yes,resizable="+resize);
}

// check if URL or string text entered


if (!defined(url)) {return true;}

if (!defined(text)) {text=0;}
var url_entered=(url.indexOf('http://') === 0 || text === 0);
         
if (win) {

 if (!defined(win.opener)) {
  win.opener=this;
 }

 win.name=name;
 if (url_entered) {
  win.location=url;
 } else {
  win.document.write(url);
  win.document.close();
 }

 //win.document.bgColor="yellow"


 win.focus();

} else {
 if (url_entered) {
  parent.location.href=url;
 } else {
  parent.document.write(url);
  parent.document.close();
 }
}

return true;

}

///////////////////////////////////////////////////////////////////////////////////
function reformat(file) {
var host=top.location.host;
var path=top.location.pathname;

var pos=path.lastIndexOf("/");
var basename=path.substr(0,pos);
var proc="http://"+host+basename+"/xdoc_print.php?file=";
//alert(proc);
proc="./xdoc_print.php?file=";
var url=proc+file;

popup(url);
return;
}
