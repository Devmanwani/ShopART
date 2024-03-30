<?php
require_once("assets/includes/header.php");
require_once("assets/includes/classes/collectiblesProvider.php");

$collectiblesProvider = new collectiblesProvider($con, $userLoggedInObj);
$artworks = $collectiblesProvider->getArtworks();

$artGrid = new artGrid($con, $userLoggedInObj);
?>
<div class="largeVideoGridContainer">
    <?php
    if(sizeof($artworks) > 0) {
        echo $artGrid->createLarge($artworks, "Collectibles", false);
    }
    else {
        echo "No collecibles to show";
    }
    ?>
</div>