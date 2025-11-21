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

// This script lists IDL procedures in a specified SSW directory

// Javascript supported?


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

foreach ($pros as $value) {
 $value=trim($value);
 $url="javascript:void reformat('$value');";
 $value2 = str_replace("\$SSW/", "/", $value);
 echo "<a href=\"$url\">$value2</a><br> \n";
}
?>

</body>
</html>
