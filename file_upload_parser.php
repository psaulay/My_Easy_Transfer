<?php
    $fileName = $_FILES["uploaded_file"]["name"]; // The file name
    $fileTmpLoc = $_FILES["uploaded_file"]["tmp_name"]; // File in the PHP tmp folder
    $fileType = $_FILES["uploaded_file"]["type"]; // The type of file it is
    $fileSize = $_FILES["uploaded_file"]["size"]; // File size in bytes
    $fileErrorMsg = $_FILES["uploaded_file"]["error"]; // 0 for false... and 1 for true

    echo "$fileName upload is complete"; 

?>