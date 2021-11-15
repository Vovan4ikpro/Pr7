<?php
$target_dir = "images/";
$target_file = $target_dir . basename($_FILES["photo"]["name"]);
$isUploaded = false;
$filePath = '';
$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
if (file_exists($target_file)) {
   echo "Sorry, file already exists.<br>";
   echo "Sorry, your file was not uploaded. Set default image<br>";
    $filePath = "images/defaultt.jpg";
}
else{
   $check = getimagesize($_FILES["photo"]["tmp_name"]);
   if($check !== false) {
      echo "File is an image - " . $check["mime"] . ".<br>";
      $isUploaded = true;
      } else {
         echo "File is not an image.<br>";
         $isUploaded = false;
   }

   if ($_FILES["photo"]["size"] > 500000) {
      echo "Sorry, your file is too large.<br>";
      $isUploaded = false;
   }
   if($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg"
      && $fileType != "gif" ) {
      echo "Sorry,onlyJPG,JPEG,PNG&GIF files are allowed.<br>";
      $isUploaded = false;
   }
   if (!$isUploaded) {
      echo "Sorry, your file was not uploaded. Set default image<br>";
      $filePath = "images/defaultt.jpg";
   } else {
      if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
         $filePath = $target_dir . basename($_FILES["photo"]["name"]);
         echo "The file ". basename( $_FILES["photo"]["name"]). " has been uploaded.<br>";
      } else {
         echo "Sorry, there was an error uploading your file.<br>";
      }
   }
}