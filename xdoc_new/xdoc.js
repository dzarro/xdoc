
function setGen(form)
{
 document.xdoc.action ="./xdoc_path.php";
 document.xdoc.target="xdoc_path";
 document.xdoc.submit();

 var input1=form.cat.value;
 var input2=form.file.value;
 if ((input1.length) != 0) {
  document.xdoc.target="xdoc_mods";
  document.xdoc.action ="./xdoc_cat.php" ;
  document.xdoc.submit();
  return true;
 }

 if ((input2.length) != 0) {
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

function closeModal() {


window.parent.$(".ui-dialog-titlebar-close:visible").trigger('click');
//window.parent.$("#somediv1").dialog('close');
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
   
                 var h = $(parent).height();
				//alert(h);
				 dvar=window.parent.document.getElementById("wrap1");
                 var d1 = $(dvar).outerHeight(true);
                 window.parent.document.getElementById("wrap1").style.visibility="visible";
                 
                 var d2=(h-d1)/2;
                 window.parent.document.getElementById("wrap2").style.top = d1+"px";
                 window.parent.document.getElementById("wrap2").style.bottom = d2+"px";
				 window.parent.document.getElementById("wrap2").style.visibility="visible";
                 window.parent.document.getElementById("wrap2").style.zIndex="50";
                 
                 var d3 =(h+d1)/2;
			     window.parent.document.getElementById("wrap3").style.top = d3 +"px";
			     window.parent.document.getElementById("wrap3").style.bottom ="0px";
                 window.parent.document.getElementById("wrap3").style.visibility="visible";
                 window.parent.document.getElementById("wrap3").style.zIndex="100";
                 return true;                  
                 
}


