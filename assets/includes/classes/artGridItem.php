<?php
//require_once("ajax/updatePrice.php");
class artGridItem{
    private $art, $largeMode;

    public function __construct($art, $largeMode){
        $this->art=$art;
        $this->largeMode=$largeMode;
    
    }

    public function create(){
        $thumbnail = $this->createThumbnail();
        $details = $this->createDetails();
        $url = "watch.php?id=" . $this->art->getId();

        return "<a href='$url'>
                    <div class='videoGridItem'>
                        $thumbnail
                        $details
                    </div>
                </a>";
    }

    public function createThumbnail(){
        
        $thumbnail = $this->art->getArtwork();

        return "<div class='thumbnail'>
                    <img src='$thumbnail'>
                   
                </div>";
    }

    public function createDetails(){
        $title = $this->art->getTitle();
        $username = $this->art->getOwnedBy();
        $views = $this->art->getViews();
        $timeStamp = $this->art->getTimeStamp();
        $price = $this->art->getPrice();
        
        $currencyValue = $currencyValue = isset($_COOKIE['currency']) ? $_COOKIE['currency'] : 'INR';
        if($currencyValue=='USD'){
            $price = number_format($price / 83, 2) . " $";
        }else{
            $price = $price. " ₹";
        }

        return "<div class='details'>
                    <div class='upperdetails'>
                    <h3 class='title'>$title</h3>
                    <h6 class='title' id='pDisplay'>$price </h3></div>
                    <span class='username'>$username</span>
                    
                </div>";
    }
}




?>
<<script>
    document.addEventListener('DOMContentLoaded', function () {
        

    // Add event listener for currency switch change
    document.getElementById('currencySwitch').addEventListener('change', function () {
        // Update the displayed price when the currency switch changes
        location.reload();
    });
    });
    

    


</script>