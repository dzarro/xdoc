<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" type="text/css" href="./xdoc_href.css" />
<?php
require_once './xdoc_lib.php';
?>
</head>
<body>

<?php

$cat="";
$file="";

if (isset($_REQUEST['cat'])) {
 $cat = trim($_REQUEST['cat']); 
 $cat=filter_var($cat, FILTER_SANITIZE_STRING);
}

if (isset($_REQUEST['file'])) {
 $file = trim($_REQUEST['file']); 
 $file=filter_var($file, FILTER_SANITIZE_STRING);
}

if (is_blank($cat)) {
 alert('Category not entered.');
 exit(1);
}

// find matches in SSW database

$contents=get_xdoc_map('ssw_info_map.dat');
if (!$contents) exit(1); 
if (isset($_POST['gen'])) {
 $contents=preg_grep('/\$SSW\/gen/',$contents);
}
        
if (!is_blank($file)){
 $dfile=parse_file($file);                     
 $contents=preg_grep("#\/$dfile\.pro#",$contents);
 if (count($contents) == 0) {
  alert("$file filename not found.");
  exit(1);
 }
}

$cat=trim($cat);
$fcat=preg_replace('/(,|\+)/',' ',$cat);
$fcat=preg_replace('/\s+/','|',$fcat);   

$matches=preg_grep("/$fcat/i",$contents);     
$plus=strpos($cat,'+'); 
if ($plus !== false) {
 $chk=explode('+',$cat); 
 $del='.+';
 $fcat='('.$chk[0].$del.$chk[1].')|('.$chk[1].$del.$chk[0].')';
}

$SSW=xdoc_root();
$found=0;
if (count($matches) !== 0 ) {
 foreach ($matches as $value) {
  $pieces=explode('::',$value);
  $pfile=basename($pieces[0]);
  $match=preg_match("/$fcat/i",$pieces[1].$pieces[3]);
  if ($match === 1) {
   $value = str_replace("\$SSW/", "/", $pieces[0]);
   $value2 = str_replace("\$SSW/", "/", $value);
   $url=str_replace('$SSW',"$SSW",$value);
   echo "<a href=\"$pfile\" class=\"popup\">$pieces[0]</a><br> \n";
   $found=1;
  }
 }
}

if ($found == 0) {
 if (is_blank($file)) {
  alert("$cat category not found.");  
 } else {
  alert("$cat category not found for filenames matching: $file");
 }
 exit(1);
}
// load JQUERY dialog code

require_once './xdoc_jquery';
?>

</body>
</html>
