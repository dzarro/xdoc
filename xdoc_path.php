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

// This script lists all the directories in the SSW tree

$contents=get_xdoc_map();
if (!$contents) exit(1);

if (isset($_POST['gen'])) {
 $contents=preg_grep('/\$SSW\/gen/',$contents);
}

$dirs=array();
foreach ($contents as $value) {
 $dir=dirname($value);
 if (in_array($dir,$dirs)) continue;
 $url="./xdoc_list.php?dir=$dir";
 $dir2 = str_replace("\$SSW/", "/", $dir);
 echo "<a href=\"$url\" target=\"xdoc_mods\">$dir2</a><br> \n";
 array_push($dirs,$dir);
}

?>

</body>
</html>

