<?php
require_once("assets/includes/header.php");
require_once("assets/includes/classes/photographyProvider.php");

$collectiblesProvider = new photographyProvider($con, $userLoggedInObj);
$artworks = $collectiblesProvider->getArtworks();

$artGrid = new artGrid($con, $userLoggedInObj);
?>
<div class="largeVideoGridContainer">
    <?php
    if(sizeof($artworks) > 0) {
        echo $artGrid->createLarge($artworks, "Photography", false);
    }
    else {
        echo "No collecibles to show";
    }
    ?>
</div>