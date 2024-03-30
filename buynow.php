<?php
require_once("assets/includes/header.php");
require_once("assets/includes/config.php");
require_once("assets/includes/classes/art.php");
require_once("assets/includes/classes/user.php");

if (isset($_GET['artId'])) {
    $query = $con->prepare("SELECT Price, ownedby FROM art WHERE id = :artId");
    $query->bindParam(':artId', $_GET['artId']);
    $query->execute();

    $result = $query->fetch(PDO::FETCH_ASSOC);
    $price = $result['Price'];
    $prevOwnedby = $result['ownedby'];
    
    $username = $_SESSION["userLoggedIn"];
    $userLoggedInObj = new User($con, $username);
    $newBalance = $userLoggedInObj->getAmount();

    if ($price <= $newBalance) {
        header("Location: billing.php?artId=" . $_GET['artId']);
        // Sufficient balance for purchase
        $Balance = $newBalance - $price;
        $updateQuery = $con->prepare("UPDATE users SET Wallet=:Wallet WHERE username = :username");
        $updateQuery->bindParam(":Wallet", $Balance);
        $updateQuery->bindParam(":username", $username);
        $updateQuery->execute();

        // Insert purchase transaction
        $insertPurchaseQuery = $con->prepare("INSERT INTO transaction(art_id, price, transaction, bought_from, sold_to) VALUES (:artId, :price, :transaction, :bought_from, :sold_to)");
        $transactionType = 1; // Assuming 1 represents a purchase
        $insertPurchaseQuery->bindParam(":artId", $_GET['artId']);
        $insertPurchaseQuery->bindParam(":price", $price);
        $insertPurchaseQuery->bindParam(":transaction", $transactionType);
        $insertPurchaseQuery->bindParam(":bought_from", $prevOwnedby);
        $insertPurchaseQuery->bindParam(":sold_to", $username);
        $insertPurchaseQuery->execute();

        // Insert sale transaction
        

        
        exit();
    }else {
        
            
            echo '<script type="text/javascript">';
            echo 'if (confirm("Insufficient Balance")) {';
            echo 'window.location.href = "watch.php?id=' . $_GET['artId'] . '";';
            echo '} else {';
            echo 'window.location.href = "watch.php?id=' . $_GET['artId'] . '";';
            echo '}';
            echo '</script>';
        }
        

    }
    
    ?>
