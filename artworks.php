<?php
require_once("assets/includes/header.php");
require_once("assets/includes/classes/ArtworksProvider.php");

if(!user::isLoggedIn()) {
    header("Location: signIn.php");
}

$ArtworksProvider = new artworksProvider($con, $userLoggedInObj);
$artworks = $ArtworksProvider->getArtworks();

$artGrid = new artGrid($con, $userLoggedInObj);
?>
<div class="largeVideoGridContainer">
    <?php
    if(sizeof($artworks) > 0) {
        echo $artGrid->createLarge($artworks, "Artworks", false);
    }
    else {
        echo "No videos to show";
    }
    ?>
</div>