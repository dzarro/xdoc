<!DOCTYPE HTML>
<html>
<head>

<?php 
 require_once './xdoc_lib.php';   
?>

</head>
<body>

<?php

// This script finds an IDL procedure in the SSW tree
// by looking up the SSW database $SSW/gen/setup/ssw_map.dat,
// and prints it.


if (!isset($_GET['file'])) {
 alert("Filename not entered.");
 die();
}
$filename=htmlentities($_GET['file']);
    
// check for .pro extension

$dfilename=$filename;
$ext='.pro';
$pos=strpos($filename,$ext);
if ($pos === false) {
 $filename=$filename.$ext;
}

// include IDL/SSW directories
 
// if $SSW is not included in filename, search SSW catalog

$matches=$filename;
if (!preg_match('/^(\$SSW).*/',$filename)) {

// read SSW database with procedure names
 
 $contents=get_xdoc_map();
 if (!$contents) exit(1);

// find first match in SSW database


 $dfilename=preg_quote($filename,'/');
 $temp= preg_grep("/\/$dfilename/",$contents);
 $matches=array_shift($temp);
}
        
// if $SSW is not included in filename, then bail

if (!preg_match('/^(\$SSW).*/',$matches)) {
 alert("$filename not found.");
 exit(1);
}

$SSW=xdoc_root();
$smatches=$matches;
$matches=str_replace('$SSW',"$SSW",$matches);
$matches=trim($matches);

// read the file and print

if (URLIsValid($matches)) {
 $prog=@file($matches); 

 if (!$prog) {
  alert("Problem reading ".basename($filename));
  exit(1);
 }

 $url="./xdoc_download.php?file=$smatches";
 echo "<a href=\"$url\"><b>Download</b></a><br> \n";
 $ncount=count($prog);
 echo "<pre>";
 for($i=0; $i < $ncount; $i++) {
  echo htmlspecialchars($prog[$i]);
 }
 echo "</pre>";
} else {
 echo "<p><b> Oops! </b>";
 echo "<p> $smatches";
 echo "<p><b>not found. </b>" ;
}

?>

</body>
</html>
