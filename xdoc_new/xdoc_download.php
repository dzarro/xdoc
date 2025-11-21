
<?php
    
require_once './xdoc_lib.php';  

$SSW=xdoc_root();

if (!isset($_GET['file'])) {
 alert("Filename not entered.");
 exit(1);
}
$filename=htmlentities($_GET['file']);

$file=$filename;
if (!IsURL($filename)) {
 $file=find_proc($filename);
 if (!$file) {
  alert("Invalid filename entered.");
  exit(1);
 }
}

//$fsize=filesize($file);  
//if ($fsize === 0) {
// alert("Cannot determine file size.");
// exit(1);
//}

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.basename($file));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
//header('Content-Length: ' .$fsize);
readfile($file);
exit(0);


?>

