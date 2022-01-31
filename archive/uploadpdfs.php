<?PHP 
session_start();
include "cherry.php";
?>

<?php
$target_dir = "patient_files/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$fname = basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if file already exists
//if ($fname == "patients.csv"){    
    //$uploadOk = 1;
//} elseif($fname == "drugs.csv") {
	//$uploadOk = 1;
//} elseif ($fname == "students.csv") {
	//$uploadOk = 1;
//} else {
	//echo "That is not a vaild file name. <br>Only patients.csv, drugs.csv and students.csv";
    //$uploadOk = 0;
//}


// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
//if($imageFileType != "pdf" && $imageFileType != "png" && $imageFileType != "jpeg"
//&& $imageFileType != "gif" ) {
//    echo "Sorry, only .csv files are allowed.";
//    $uploadOk = 0;
//}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
