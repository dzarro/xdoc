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

$filename=($_SERVER['REQUEST_METHOD'] == 'GET') ? htmlentities($_GET['file']) : htmlentities($_POST['file']);

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

foreach ($matches as $value) {
 $value=trim($value);
 $url="javascript:void reformat('$value');";
 $value2 = str_replace("\$SSW/", "/", $value);
 echo "<a href=\"$url\">$value2</a><br> \n";
}
    
?>

</body>
</html>

