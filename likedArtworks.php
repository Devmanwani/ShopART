<?php
require_once("assets/includes/header.php");
require_once("assets/includes/classes/LikedArtworksProvider.php");

if(!user::isLoggedIn()) {
    header("Location: signIn.php");
}

$likedArtworksProvider = new LikedArtworksProvider($con, $userLoggedInObj);
$artworks = $likedArtworksProvider->getArtworks();

$artGrid = new artGrid($con, $userLoggedInObj);
?>
<div class="largeVideoGridContainer">
    <?php
    if(sizeof($artworks) > 0) {
        echo $artGrid->createLarge($artworks, "Artworks that you have liked", false);
    }
    else {
        echo "No videos to show";
    }
    ?>
</div>