<?php
require_once("../assets/includes/config.php");
require_once("../assets/includes/classes/art.php");
require_once("../assets/includes/classes/user.php");
// code to update the balance
$username = $_SESSION["userLoggedIn"];
$userLoggedInObj = new User($con, $username);
$newBalance = $userLoggedInObj->getBalance();
echo $newBalance;
?>
