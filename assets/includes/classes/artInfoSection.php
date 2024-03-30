<?php
require_once("assets/includes/classes/artInfoControls.php");
//require_once("ajax/updatePrice.php");
class artInfoSection{

    private $con, $art, $userLoggedInObj;

    public function __construct($con, $art, $userLoggedInObj){
        $this->con = $con;
        $this->art = $art;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function create(){

        return $this->createPrimaryInfo() . $this->createSecondaryInfo();

        
    }
    

    private function createPrimaryInfo(){
        $title = $this->art->getTitle();
        $price = $this->art->getPrice();
        $currencyValue = isset($_COOKIE['currency']) ? $_COOKIE['currency'] : '';
    
        if ($currencyValue == 'USD') {
            $priceFormatted = number_format($price / 83, 2) . " $";
        } else {
            $priceFormatted = $price. " ₹";
        }
    
        $views = $this->art->getViews();
    
        $artInfoControls = new artInfoControls($this->art, $this->userLoggedInObj);
        $controls = $artInfoControls->create();
    
        return "<div class ='videoInfo'>
                    <h1>$title</h1>
                    <h5 id='priceDisplay'>Price: $priceFormatted</h5>
                    <div class ='bottomSection'>
                        <span class ='viewCount'>$views views</span>
                        $controls
                    </div>
                </div>";
    }
    


    private function createSecondaryInfo(){

        $description =$this->art->getDescription();
        $uploadDate = $this->art->getUploadDate();
        $uploadedBy = $this->art->getUploadedBy();
        $ownedBy = $this->art->getOwnedBy();
        $profileButton = buttonProvider::createUserProfileButton($this->con, $ownedBy);

        if ($ownedBy == $this->userLoggedInObj->getUsername() || (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == 'admin')) {
            $actionButton = buttonProvider::createEditArtButton($this->art->getId());
        } else {
            $actionButton = buttonProvider::createBuyNowButton($this->con, $this->userLoggedInObj, $this->art->getId());
        }
        

        return "<div class='secondaryInfo'>
                   <div class='topRow'>
                        $profileButton

                        <div class='uploadInfo'>
                            <span class='owner'>
                                <a href='profile.php?username=$ownedBy'>
                                    $ownedBy
                                </a>
                            </span>
                            <span class='date'>Published on $uploadDate</span>
                        </div>
                        
                        $actionButton
                   </div>
                        <div class='descriptionContainer'>
                            $description
                        </div>

                </div>";
    }
}




?>

<<script>
    
    function updateDisplayedPrice() {
        // Get the necessary elements
        var priceDisplay = document.getElementById('priceDisplay');
        var currencySwitch = document.getElementById('currencySwitch');

        // Get the original price
        var priceText = priceDisplay.textContent;

        // Use a regular expression to extract the numeric part
        var numericPart = priceText.match(/\d+(\.\d+)?/);

        // Check if there's a match and get the numeric value
        var numericValue = numericPart ? parseFloat(numericPart[0]) : NaN;

        // Determine the currency and update the displayed price
        if (currencySwitch.checked) {
            // Update for USD
            var roundedPrice = (numericValue / 83).toFixed(2);
            priceDisplay.textContent = 'Price: ' + roundedPrice + ' $';
        } else {
            // Update for INR (rounded to the nearest integer)
            var roundedPrice = Math.round(numericValue * 83);
            priceDisplay.textContent = 'Price: ' + roundedPrice + ' ₹';
        }
    }

    // Add event listener for currency switch change
    document.getElementById('currencySwitch').addEventListener('change', function () {
        // Update the displayed price when the currency switch changes
        updateDisplayedPrice();
    });

    


</script>

