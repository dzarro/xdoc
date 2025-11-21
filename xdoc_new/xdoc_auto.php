
<?php
    
require_once './xdoc_lib.php';  

if (!isset($_GET['term'])) {
 alert("Search term not entered.");
exit(1);
}

$term=$_GET['term'];
$files=get_xdoc_files();

$out=match_files($files,$term);

exit(0);


?>

