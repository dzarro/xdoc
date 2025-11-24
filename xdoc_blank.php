<?php

$filename = "./xdoc_blank.html";
try {
    $fileContents = file_get_contents($filename);
    echo $fileContents;
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}
?>
