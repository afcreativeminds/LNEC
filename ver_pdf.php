<?php
if(!empty($_GET['file'])){
    $fileName = basename($_GET['file']);
    $filePath = 'upload/'.$fileName;
    if(!empty($fileName) && file_exists($filePath)){
        // Define headers
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $fileName . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($filePath));
        header('Accept-Ranges: bytes');

        // Read the file
        readfile($filePath);
        exit;
    }else{
        echo 'The file does not exist.';
    }
} else {
    die("Invalid file name!");
}

?>