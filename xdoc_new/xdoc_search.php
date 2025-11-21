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

$filename ="";
if (isset($_REQUEST['file'])) {
 $filename = trim($_REQUEST['file']); 
 $filename =filter_var($filename, FILTER_SANITIZE_STRING);
}

if (is_blank($filename)) {
 alert('Filename not entered.');
 exit(1);
}

// check for .pro extension. If no extension, use wild cards.

$dfilename=parse_file($filename);

// find matches in database

$contents=get_xdoc_map();
if (!$contents) exit(1);
if (isset($_POST['gen'])) {
 $contents=preg_grep('/\$SSW\/gen/',$contents);
}
$matches=preg_grep("#\/$dfilename\.pro#",$contents);

if (count($matches) == 0) {
 alert("$filename not found.");
 exit(1);
}

$SSW=xdoc_root();
foreach ($matches as $value) {
 $value=trim($value);
 $value2 = str_replace("\$SSW/", "/", $value);
 $url=str_replace('$SSW',"$SSW",$value);
 echo "<a href=\"$url\" class=\"popup\">$value2</a><br> \n";
}
  
// load JQUERY dialog code

require_once './xdoc_jquery';
?>

</body>
</html>

