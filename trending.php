<?php
require_once("assets/includes/header.php");
require_once("assets/includes/classes/TrendingProvider.php");

$trendingProvider = new TrendingProvider($con, $userLoggedInObj);
$artworks = $trendingProvider->getArtworks();

$artGrid = new artGrid($con, $userLoggedInObj);
?>
<div class="largeVideoGridContainer">
    <?php
    if(sizeof($artworks) > 0) {
        echo $artGrid->createLarge($artworks, "Trending artworks uploaded in the last week", false);
    }
    else {
        echo "No trending artworks to show";
    }
    ?>
</div>