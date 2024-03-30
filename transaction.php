<?php
    require_once("assets/includes/header.php");
    require_once("assets/includes/config.php");
    require_once("assets/includes/classes/art.php");
    require_once("assets/includes/classes/user.php");
    require_once("assets/includes/classes/transactionDetails.php");

    

       
        
    

    if(!User::isLoggedIn()) {
        header("Location: signIn.php");
    }

    

    
    $username = $userLoggedInObj->getUsername();
    $id = $_GET['id'];
    $transaction = transactionDetails::getTransactionById($con, $id);
    $artid = $transaction->getArtId();
    
    $art = new art($con, $artid, $userLoggedInObj);
    
    $title = $art->getTitle();
    $bought_from = $transaction->getBoughtFrom();
    $sold_to = $transaction->getSoldTo();
    $desc = $art->getDescription();
    $price = $transaction->getPrice();
    $currencyValue = $currencyValue = isset($_COOKIE['currency']) ? $_COOKIE['currency'] : 'INR';
        if($currencyValue=='USD'){
            $price = number_format($price / 83, 2) . " $";
        }else{
            $price = $price. " ₹";
        }
    $categories = $art->getCategories();
    if($categories==1){
        $category="gif";
    }
    if($categories==2){
        $category="art";
    }
    if($categories==3){
        $category="photography";
    }
    if($categories==4){
        $category="Collectible";
    }
    $date = $transaction->getDate();
    
    if ($username == $sold_to) {
            $transaction_type = "Buy";
            $transaction_detail = "Bought from = $bought_from";
        } else {
            $transaction_type = "Sell";
            $transaction_detail = "Sold to = $sold_to";
        }
    $path = $art->getFilePath();

    
    echo"<style>
    @media print {
        #headContainer{
            display: none;
        }
        button{
        display:none;}
      }</style>
      
<div class ='transactiondetails billingDetails'>
<h3>Transaction Details</h3><br>
                <div class='imagebilling'>
                <img src='$path'>
                </div><hr>
                <div class='type'>
                Transaction = $transaction_type
                </div><hr>
                <div class='id'>
                    Artwork Id = $id
                </div><hr>
                <div class='title'>
                    Artwork Title = $title
                </div><hr>
                
                <div class='desc'>
                    Artwork Description = $desc
                </div><hr>
                <div class='Bought From'>
                    Artwork Bought From = $bought_from
                </div><hr>
                <div class='Sold To'>
                    Artwork Sold To = $sold_to
                </div><hr>
                <div class='price'>
                    Artwork Price = $price 
                </div><hr>
                <div class='category'>
                    Artwork Category = $category
                </div><hr>
                <div class='date'>
                    Artwork Transaction Date = $date
                </div><hr>
                <button class='button' onclick = 'window.print();'>Print</button>
                <img src='image/shopART.png'>
            </div>
            ";

            

    ?>