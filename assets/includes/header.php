<?php require_once("assets/includes/config.php");
    require_once("assets/includes/classes/user.php");
    require_once("assets/includes/classes/buttonProvider.php");
    require_once("assets/includes/classes/art.php");
    require_once("assets/includes/classes/artGrid.php");
    require_once("assets/includes/classes/artGridItem.php");
    require_once("assets/includes/classes/NavigationMenuProvider.php");
    require_once("assets/includes/classes/ArtworksProvider.php");
    //require_once("ajax/updatePrice.php");
    
    $usernameLoggedIn = isset($_SESSION["userLoggedIn"]) ? $_SESSION["userLoggedIn"] : "";
    $userLoggedInObj = new user($con, $usernameLoggedIn);
    
?>
<!DOCTYPE html>
<html>
<head>
<title> PIXEL</title>
<link rel="stylesheet" type= "text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="style.css">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> 
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js"></script>
<script src="https://kit.fontawesome.com/ff2cd040fd.js" crossorigin="anonymous"></script>
<script src="javascript/commonActions.js"></script>
<script src="javascript/userActions.js"></script>
<script src="javascript/confetti.js"></script>
<script src="javascript/confetti.min.js"></script>



</head>
<body>
<div id="pageContainer">
    <div id="headContainer">
        <button class="navShowHide">
            <img src="assets/images/icons/menu.png" title="Menu" alt="Menu">
        </button>
        <a class="logoContainer" href="index.php"><img src="assets/images/icons/logo2.png" title="logo" alt="shopART"></a>
        
        <div class="searchBarContainer" >
            <form action="search.php" method="GET">
                <input type="text" class="searchBar" name="term" placeholder="Search">
                <button class="searchButton ">
                    <img src="assets/images/icons/search.png" alt="search" title="search">
                </button>
                
            </form>
        </div>
        
        <div class=rightIcons>
        <div class="switch-container">
            <span class="symbol a"><i class="fa-solid fa-indian-rupee-sign fa-xl"></i></span>
            <label class="switch">
            <input type="checkbox" id="currencySwitch">
            <span class="slider"></span>
            </label>
            <span class="symbol b"><i class="fa-solid fa-dollar-sign fa-xl"></i></span>
        </div>

        
    
            <?php if(user::isLoggedIn() ){
                $a="";
                if(isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == 'admin'){$a.="";}else{
                $a.=buttonProvider::createHyperlinkButton(null,'assets/images/icons/upload.png','upload.php', 'newUpload');}
                    echo $a;
                }?>
            
            
            <?php $var = new buttonProvider();
             echo $var->createUserNavigationButton($con, $userLoggedInObj->getUsername());?>

            <?php if(user::isLoggedIn()){
            echo buttonProvider::createButton(null,'image/wallet.png','WalletContainer()', 'Wallet');}?>

            
        </div>
        
    </div>
    <div id="sideNavContainer" style="display: none">
        <?php
        $navigationProvider = new NavigationMenuProvider($con, $userLoggedInObj);
        echo $navigationProvider->create();
        
        ?>
    </div>
    <div id="mainSectionContainer">
        
        <div id="mainContentContainer">
        <div id="WalletContainer">
        <span id="balance">Balance: <?php echo $userLoggedInObj->getBalance();?></span>
        <form action="payscript.php?username=<?php echo $userLoggedInObj->getUsername();?>" method="POST">
        <div class="Addbalance">
        <input style="display:none" type = "number" id="inputBalance" name = "addBalance">
        <button style="display:none">Add</button></div>
        </form> 
            <div class="WalletActions">
                <button >Add</button>
                <button id="withdrawbutton" onclick="withdraw(<?php echo $userLoggedInObj->getAmount()?>)">withdraw</button>
                
                </div>
                
            </div>

<script>
    let add2 = document.getElementsByClassName("Addbalance")[0].querySelector("button");
    let add1 = document.getElementsByClassName("WalletActions")[0].querySelector("button");
    let textbox = document.getElementById("inputBalance");

    add1.addEventListener("click", function() {
        textbox.style.display = "block";
        add1.style.display = "none";
        add2.style.display = "block";
    });
</script>
