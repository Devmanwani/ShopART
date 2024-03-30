<?php
require_once("../assets/includes/config.php");
require_once("../assets/includes/classes/art.php");
require_once("../assets/includes/classes/user.php");


$username = $_SESSION["userLoggedIn"];
if (isset($_GET['artId'])) {
    $artId = $_GET['artId'];}

$userLoggedInObj = new User($con, $username);
$art = new art($con, $artId, $userLoggedInObj);


public function purchaseArtwork($username, $artId) {
    $query = $this->con->prepare("UPDATE art SET ownedBy = :username WHERE id = :artId");
    $query->bindParam(":username", $username);
    $query->bindParam(":artId", $artId);
    $query->execute();
}?>
