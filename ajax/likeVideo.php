<?php

require_once("../assets/includes/config.php");
require_once("../assets/includes/classes/art.php");
require_once("../assets/includes/classes/user.php");

$username = $_SESSION["userLoggedIn"];
$artId = $_POST["artId"];

$userLoggedInObj = new User($con, $username);
$art = new art($con, $artId, $userLoggedInObj);

echo $art->like();

?>