<?php
require_once("assets/includes/header.php");



function DeleteArt($con, $artId) {
    // Delete from the 'art' table
    $query = $con->prepare("DELETE FROM art WHERE id = :artid");
    $query->bindParam(":artid", $artId);
    $query->execute();

    // Delete from the 'likes' table
    $query = $con->prepare("DELETE FROM likes WHERE artId = :artid");
    $query->bindParam(":artid", $artId);
    $query->execute();

    $query = $con->prepare("DELETE FROM transactions WHERE artId = :artid");
    $query->bindParam(":artid",$artId);
    $query->execute();

    // JavaScript code to display the alert box and redirect
    echo '<script>
        alert("Art deleted successfully!");
        // Call the DeleteArt function after the redirect
        setTimeout(function() {
            window.location.href = "index.php";
        }, 2000); // 2 seconds delay
    </script>';
}

    
    if (isset($_GET['artId'])) {
        $artId = $_GET['artId'];
        DeleteArt($con, $artId);
    }

    

?>
