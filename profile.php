<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("assets/includes/header.php");
require_once("assets/includes/config.php");
require_once("assets/includes/classes/ProfileGenerator.php");

if(isset($_GET["username"])) {
    $profileUsername = $_GET["username"];
}
else {
    echo "Channel not found";
    exit();
}

if(isset($_POST['hidden'])){
    $oldBalance = $userLoggedInObj->getBalance();
    $amount = $_POST['hidden'] + $oldBalance;
    $newBalance = $_POST['hidden'];

    $query = $con->prepare("UPDATE users SET Wallet=:Wallet WHERE username=:username");
    $query->bindParam(":Wallet", $amount);
    $query->bindParam(":username", $profileUsername);
    $query->execute();

    
    header("Location: profile.php?username=" . $profileUsername);
    exit; // Make sure to exit after the redirect    
}

    


$profileData = new ProfileData($con, $profileUsername);

if (isset($_FILES["fileInput"])) {
    $fileInput = $_FILES["fileInput"];
    $profileData->updateProfilePic($fileInput);
    header("Location:profile.php?username=$profileUsername");
}


$profileGenerator = new ProfileGenerator($con, $userLoggedInObj, $profileUsername);
echo $profileGenerator->create();
?>