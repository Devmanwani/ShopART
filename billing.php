<?php
    require_once("assets/includes/header.php");
    require_once("assets/includes/config.php");
    require_once("assets/includes/classes/art.php");
    require_once("assets/includes/classes/user.php");

    

       
        
    

    if(!User::isLoggedIn()) {
        header("Location: signIn.php");
    }
    
    if(!isset($_GET["artId"])) {
        echo "No art selected";
        exit();
    }





    
    
    $art = new art($con, $_GET["artId"], $userLoggedInObj);
    $art->purchaseArtwork($con, $_GET["artId"], $userLoggedInObj);
    $id = $art->getId();
    $title = $art->getTitle();
    $owner = $art->getOwnedBy();
    $desc = $art->getDescription();
    $price = $art->getPrice();
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
    $date = $art->getTimeStamp();
    $path = $art->getFilePath();

    echo "
    <style>
    @media print {
        #headContainer{
            display: none;
        }
        button{
        display:none;}
      }</style>
      
<div class ='billingDetails'>
<h1>ShopArt</h1>
<h3> Billing Details</h3><br>
                <div class='imagebilling'>
                <img src='$path'>
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
                <div class='owner'>
                    Artwork Owner = $owner
                </div><hr>
                <div class='price'>
                    Artwork Price = $price 
                </div><hr>
                <div class='category'>
                    Artwork Category = $category
                </div><hr>
                <div class='date'>
                    Artwork Published Date = $date
                </div><hr>
                <button class='button' onclick = 'window.print();'>Print</button>
                <img src='image/shopART.png'>
            </div>
            ";

            

    ?>

<!DOCTYPE html>
<html lang="en">

<body>
<div class="message" id="congratulations" >
    Congrats! You Bought the Artwork!
</div>
<script src="javascript/confetti.js"></script>
<script>

// start

const start = () => {
    setTimeout(function() {
        confetti.start()
    }, 000); // 1000 is time that after 1 second start the confetti ( 1000 = 1 sec)
};

//  Stop

const stop = () => {
    setTimeout(function() {
        confetti.stop()
    }, 1500); // 5000 is time that after 5 second stop the confetti ( 5000 = 5 sec)
};

start();
stop();
</script>


<script>
    window.onload = function() {
      var message = document.getElementById('congratulations');
      message.style.opacity = '0';

      setTimeout(function() {
        message.style.opacity = '1';
        setTimeout(function() {
          message.style.opacity = '0';
        }, 1500);
      }, 0);
    };
</script>


</body>
</html>