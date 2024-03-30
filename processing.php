<?php
require_once("assets/includes/header.php");
require_once("assets/includes/classes/artUploadData.php");
require_once("assets/includes/classes/artProcessor.php");

if(!isset($_POST["uploadButton"])){
    echo "No file sent to page.";
    exit();
}

$artUploadData=new artUploadData(
    $_FILES["fileInput"],
    $_POST["titleInput"],
    $_POST["descInput"],
    $_POST["categoriesInput"],
    $userLoggedInObj->getUsername(),
    $_POST["Price"]
);

$artProcessor = new artProcessor($con);
$wasSuccessfull = $artProcessor->upload($artUploadData);


if($wasSuccessfull){
    echo "upload successfull";
}

?>