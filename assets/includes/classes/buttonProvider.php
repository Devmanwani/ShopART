<?php

class buttonProvider{
    
    public static $signInFunction = "notSignedIn()";

    public static function createLink($link) {
        if(isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == 'admin'){
            return null; // If the user is admin, return null or handle accordingly
        } 
        return user::isLoggedIn()? $link : buttonProvider::$signInFunction;
    
    }

    public static function createButton($text, $imageSrc, $action, $class){
        if(isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == 'admin'){
            return null; // If the user is admin, return null or handle accordingly
        } 

        $image = ($imageSrc==null) ? "" : "<image src='$imageSrc'>";

        $action = buttonProvider::createlink($action);

        return "<button class='$class' onclick='$action'>
                $image
                <span class='text'>$text</span>
                </button>";
    }

    public static function createHyperlinkButton($text, $imageSrc, $href, $class){
        

        $image = ($imageSrc == null) ? "" : "<image src='$imageSrc'>";

        return "<a href='$href'>
                    <button class='$class'>
                        $image
                        <span class='text'>$text</span>
                    </button>
                </a>";
    }

    public static function createUserProfileButton($con, $username){
        if(isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == 'admin'){
            return null; // If the user is admin, return null or handle accordingly
        } 
        $userObj = new user($con, $username);
        $profilePic = $userObj->getProfilePic();
        $link = "profile.php?username=$username";

        return "<a href='$link'>
                    <img src='$profilePic' class='profilePicture'>
                </a>";
    }

    public static function createEditArtButton($artId){
        $href = "editVideo.php?artId=$artId";

        $button = buttonProvider::createHyperlinkButton("EDIT ART", null,$href,"edit button");

        return "<div class='editArtButtonContainer'>
                    $button
                </div>";
    }

    

    public function createUserNavigationButton($con, $username){
        if(isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == 'admin'){
            return null; // If the user is admin, return null or handle accordingly
        } else if(user::isLoggedIn()){
            return buttonProvider::createUserProfileButton($con, $username);
        } else {
            return "<a href='signIn.php'>
                        <span class='signInLink'>SIGN IN</span>
                    </a>";
        }
    }
    

    public static function createBuyNowButton($con, $username, $artId) {
        if (user::isLoggedIn() && isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] !== 'admin'){
             // If the user is admin, return null or handle accordingly
        
            $href = "buynow.php?artId=$artId";
            $buttonText = "BUY NOW";
            $class = "buy button";
            $confirmationMessage = "Are you sure you want to buy this item?";
    
            $onclickAttr = $confirmationMessage ? "onclick='return showConfirmation(\"$confirmationMessage\", \"$href\")'" : "";
    
            return "<div class ='buyNow'>
                        <button class='$class' $onclickAttr>
                            $buttonText
                        </button>
                    </div>
                    <script>
                        function showConfirmation(message, redirectUrl) {
                            if (confirm(message)) {
                                window.location.href = redirectUrl;
                                
                            }
                            return false;
                        }
                    </script>";
        } else {
            return "";
        }
    }
    
    
    
    
    
}


?>