<?php
require_once("assets/includes/header.php");
require_once("assets/includes/classes/gifProvider.php");

$collectiblesProvider = new gifProvider($con, $userLoggedInObj);
$artworks = $collectiblesProvider->getArtworks();

$artGrid = new artGrid($con, $userLoggedInObj);
?>
<div class="largeVideoGridContainer">
    <?php
    if(sizeof($artworks) > 0) {
        echo $artGrid->createLarge($artworks, "GIF", false);
    }
    else {
        echo "No collecibles to show";
    }
    ?>
</div>