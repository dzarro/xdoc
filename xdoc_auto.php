<?php
    
require_once './xdoc_lib.php';  

$term="";
if (isset($_REQUEST['term'])) {
 $term=$_REQUEST['term'];
 $term = filter_var($term, FILTER_SANITIZE_STRING);
 $term= trim($term);
}

if (is_blank($term)) {
 echo json_encode(array());
} else {
 $files=get_xdoc_files();
 $out=match_files($files,$term);
}

exit(0);
?>

