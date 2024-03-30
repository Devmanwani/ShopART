<?php
require_once("assets/includes/header.php");
require_once("assets/includes/config.php");
require_once("assets/includes/classes/art.php");
require_once("assets/includes/classes/user.php");
require_once("assets/includes/classes/transactionDetails.php");

if (!User::isLoggedIn()) {
    header("Location: signIn.php");
}

function displayAllTransactions($con, $userLoggedInObj)
{
    if(isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == 'admin'){
        $username = $_SESSION['userLoggedIn'];
    }else{
        $username = $userLoggedInObj->getUsername();
    }
    
    
    if($username =='admin'){$transactions = transactionDetails::getAllTransactionsForAdmin($con, $username);}
    else{
    $transactions = transactionDetails::getAllTransactionsForUser($con, $username);}

    foreach ($transactions as $transaction) {
        $artid = $transaction->getArtId();
        $id = $transaction->getId();
        $art = new art($con, $artid, $userLoggedInObj);

        $title = $art->getTitle();
        $bought_from = $transaction->getBoughtFrom();
        $sold_to = $transaction->getSoldTo();
        $desc = $art->getDescription();
        $price = $transaction->getPrice();
        $currencyValue = isset($_COOKIE['currency']) ? $_COOKIE['currency'] : 'INR';

        if ($currencyValue == 'USD') {
            $price = number_format($price / 83, 2) . " $";
        } else {
            $price = $price . " ₹";
        }

        if ($username == $sold_to) {
            $transaction_type = "Buy";
            $transaction_detail = "Bought from = $bought_from";
        } else {
            $transaction_type = "Sell";
            $transaction_detail = "Sold to = $sold_to";
        }
        $path = $art->getFilePath();

        echo "<a style='color:black;' href='transaction.php?id=$id'><div class ='transactions'>
                    <div style='margin-right:3vw'>
                    <div class='imagebilling'>
                    <img src='$path'>
                    </div></div>
                    <div style='display:flex; flex-direction:column;  justify-content:space-evenly;'>
                    <div class='type'>
                    Transaction = $transaction_type
                    </div>
                    <div class='title'>
                        Artwork Title = $title
                    </div>
                    
                    <div class='desc'>
                        Artwork Description = $desc
                    </div>
                    <div class='Bought From'>
                        $transaction_detail
                    </div>
                    <div class='price'>
                        Artwork Price = $price 
                    </div>
                    </div>
                </div></a>
                <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('mainContentContainer').classList.add('extra');
        });

        window.addEventListener('popstate', function() {
            // Remove the class when the URL changes
            document.getElementById('mainContentContainer').classList.remove('extra');
        });
    </script>
                ";
    }
}

// Display all transactions for the user
displayAllTransactions($con, $userLoggedInObj);
?>
