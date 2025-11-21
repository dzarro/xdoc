
<?php
    
require_once './xdoc_lib.php';  

$hstart="<html><body><pre>";
$hend="</pre></body></html>";

if (!isset($_GET['file'])) {
 alert("Filename not entered.");
 exit(1);
}
$filename=htmlentities($_GET['file']);

$err="File not found";
$file=$filename;
if (!IsURL($file)) {
 $file = find_proc($file);
 if (!$file) {
  alert($err);
  exit(1);
 }
}
	
$prog=@file($file);
$ncount=count($prog);
if ($ncount == 0) {
 alert($err);
 exit(1);
}

if ($ncount == 1) {
 if (is_blank($prog[0])) {
  alert($err);
  exit(1);  
 }
}

echo $hstart;
for($i=0; $i < $ncount; $i++) {
echo $prog[$i];
}
echo $hend;

exit(0);


?>

