<?php
require_once("assets/includes/header.php");
require_once("assets/includes/classes/artPlayer.php");
require_once("assets/includes/classes/artDetailsForm.php");
require_once("assets/includes/classes/artUploadData.php");



if(!User::isLoggedIn()) {
    header("Location: signIn.php");
}

if(!isset($_GET["artId"])) {
    echo "No art selected";
    exit();
}

$art = new art($con, $_GET["artId"], $userLoggedInObj);
if($art->getOwnedBy() != $userLoggedInObj->getUsername()) {
    if(isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] !== 'admin'){
    echo "Not your artwork";
    exit();}
}

$detailsMessage = "";
if(isset($_POST["saveButton"])) {
    $videoData = new artUploadData(
        null,
        $_POST["titleInput"],
        $_POST["descInput"],
        $_POST["categoriesInput"],
        $userLoggedInObj->getUsername(),
        $_POST["Price"]
    );

    if($videoData->updateDetails($con, $art->getId())) {
        $detailsMessage = "<div class='alert alert-success'>
                                <strong>SUCCESS!</strong> Details updated successfully!
                            </div>";
        $video = new art($con, $_GET["artId"], $userLoggedInObj);
    }
    else {
        $detailsMessage = "<div class='alert alert-danger'>
                                <strong>ERROR!</strong> Something went wrong
                            </div>";
    }
}

if (isset($_POST["deleteButton"])) {
    // Assuming you have the necessary database connection and $art object available
    $confirmationMessage = "Are you sure you want to delete this art?";
    $artId = $art->getId();
    

    echo "<script>
        function showConfirmation(message) {
            if (confirm(message)) {
                window.location.href = 'deleteArt.php?artId=$artId';
                
            }
            return false;
        }

        showConfirmation('$confirmationMessage');
    </script>";
}

?>

<script src="javascript/editVideoActions.js"></script>
<div class="editVideoContainer column">

    <div class="message">
        <?php echo $detailsMessage; ?>
    </div>

    <div class="topSection">
        <?php
        $artPlayer = new artPlayer($art);
        echo $artPlayer->create(false);

        ?>
    </div>

    <div class="bottomSection">
        <?php
        $formProvider = new artDetailsForm($con);
        echo $formProvider->createEditDetailsForm($art);
        ?>
    </div>

</div>