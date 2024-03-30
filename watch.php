<?php 
require_once("assets/includes/header.php");
require_once("assets/includes/classes/artPlayer.php");
require_once("assets/includes/classes/artInfoSection.php");



if(!isset($_GET["id"])){
    echo "no url passed into the page";
    exit();

}

$art = new art($con, $_GET["id"], $userLoggedInObj);
$art->incrementViews();
?>

<script src = "javascript/videoPlayerActions.js"></script>

<script src = "javascript/commentActions.js"></script>

<div class = "watchLeft">

    <?php
        $artPlayer = new artPlayer($art);
        echo $artPlayer->create(true);

        $artPlayer = new artInfoSection($con, $art, $userLoggedInObj);
        echo $artPlayer->create();

       
    ?>

</div>

<div class = "suggestions">
    <?php
        $artGrid = new artGrid($con, $userLoggedInObj);
        echo $artGrid->create(null, null, false);

    ?>

</div>

<?php require_once("assets/includes/footer.php"); ?>
