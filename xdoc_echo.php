<!DOCTYPE HTML>
<html>
<head>

<?php

$filename = "./index.html";


try {
    $fileContents = file_get_contents($filename);
#  echo "File Contents:\n"; // Optional: Add a header
    echo $fileContents;
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}
?>

</body>
</html>
