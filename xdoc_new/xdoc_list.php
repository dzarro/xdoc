<!DOCTYPE HTML>
<html>

<head>
<link rel="stylesheet" type="text/css" href="./xdoc_href.css" />
<script src="./xdoc.js"></script>
<?php
require_once './xdoc_lib.php';
?>
</head>

<body>
<?php

// This script lists IDL procedures in a specified SSW directory

$dirname=htmlentities($_GET['dir']);
if (is_blank($dirname)) {
 alert("Directory name not entered");
 exit(1);
}

// check if valid IDL/SSW directory

if ((strpos($dirname,'$SSW') === false) && (strpos($dirname,'$IDL_DIR') === false )) {
 alert("Entered name is not a valid SSW directory");
 exit(1);
}

$dirname=trim($dirname);
$contents= get_xdoc_map();
if (!$contents) exit(1);

// extract matching pro names

$odirname=preg_quote($dirname,'/');
$pros=preg_grep("/$odirname\/[^\/]*\.pro/",$contents);
if (count($pros) == 0) {
 alert("No IDL routines in directory");
 exit(1);
}

// create links

$SSW=xdoc_root();
foreach ($pros as $value) {
 $value=trim($value);
 $value2 = str_replace("\$SSW/", "/", $value);
 $url=str_replace('$SSW',"$SSW",$value);
 echo "<a href=\"$url\" class=\"popup\">$value2</a><br> \n";
}

// load JQUERY dialog code

require_once './xdoc_jquery';
?>
<script>
window.onload=closeModal;
</script>

</body>
</html>
