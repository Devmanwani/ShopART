<?php
require_once("assets/includes/header.php");
require_once("assets/includes/config.php");
require_once("assets/includes/classes/art.php");
require_once("assets/includes/classes/user.php");    
    
$art = new art($con, $_GET["artId"], $userLoggedInObj);
$wasSuccessful = $art->purchaseArtwork($con, $_GET["artId"], $userLoggedInObj);

var_dump($wasSuccessful);

if($wasSuccessful){
    header("Location: billing.php?artId={$_GET['artId']}");
    exit(); // Make sure to call exit after calling header to prevent further execution
} else {
    echo "An error occurred";
}

?>
