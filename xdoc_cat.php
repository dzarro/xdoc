<!DOCTYPE HTML>
<html>
<head>

<?php
require_once './xdoc_header';  
require_once './xdoc_lib.php';
?>
</head>
<body>

<?php

$cat="";
$file="";
$method=$_SERVER['REQUEST_METHOD'];
if ($method == 'GET') {
 if (isset($_GET['cat'])) $cat=$_GET['cat']; 
 if (isset($_GET['file'])) $file=$_GET['file']; 
 } else {
 if (isset($_POST['cat'])) $cat=$_POST['cat'];
 if (isset($_POST['file'])) $file=$_POST['file']; 
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

$found=0;
if (count($matches) !== 0 ) {
 foreach ($matches as $value) {
  $pieces=explode('::',$value);
  $pfile=basename($pieces[0]);
  $match=preg_match("/$fcat/i",$pieces[1].$pieces[3]);
  if ($match === 1) {
   $url="javascript:void reformat('$pfile');";
   $value = str_replace("\$SSW/", "/", $pieces[0]);
   echo "<a href=\"$url\">$value</a><br> \n";
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

?>

</body>
</html>
