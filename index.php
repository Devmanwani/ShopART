<?php 
require_once("assets/includes/header.php");?>

<div class = "videoSection">
<?php
    $artworksProvider = new artworksProvider($con, $userLoggedInObj);
    $artworks = $artworksProvider->getArtworks();

    $artGrid = new artGrid($con, $userLoggedInObj->getUsername());

    //if(user::isLoggedIn() && sizeof($artworks)>0){
        echo $artGrid->create($artworks, "Artworks", false);
    //}
    
    

?>
</div>



<?php require_once("assets/includes/footer.php"); ?>
