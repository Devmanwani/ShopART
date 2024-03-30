<?php
require_once("assets/includes/classes/buttonProvider.php");

class artInfoControls{

    private $art, $userLoggedInObj;

    public function __construct($art, $userLoggedInObj){
        $this->art = $art;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function create(){

        $likeButton = $this->createLikeButton();

        return "<div class = 'controls'>
                    $likeButton
                </div>";

    }

    private function createLikeButton(){

        $text = $this->art->getLikes();
        $artId = $this->art->getId();
        $action = "likeVideo(this, $artId)";
        $class = "likeButton";

        $imageSrc = "assets/images/icons/thumb-up.png";

        if($this->art->wasLikedBy()){
            $imageSrc = "assets/images/icons/thumb-up-active.png";
        }
        return buttonProvider::createButton($text, $imageSrc, $action, $class);
    }

    
}

?>