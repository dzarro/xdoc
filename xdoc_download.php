<?php
    
require_once './xdoc_lib.php';  

$SSW=xdoc_root();

if (!isset($_GET['file'])) {
 alert("Filename not entered.");
 exit(1);
}
$filename=htmlentities($_GET['file']);

if ((strpos($filename,'$SSW') === false)) {
 alert("Invalid filename entered.");
 exit(1);
}

$file=str_replace('$SSW',"$SSW",$filename);
$fsize=@filesize($file);  

//if ($fsize === 0) {
// alert("Cannot determine file size.");
// exit(1);
//}


header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.basename($file).'"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
if ($fsize !== 0 && $fsize !== false) header('Content-Length: ' .$fsize);
ob_clean();
flush();
readfile($file);
exit(0);

?>