<?php

class artPlayer{

    private $art;

    public function __construct($art){
        $this->art = $art;
    }

    public function create($autoPlay){
        if($autoPlay){
            $autoPlay = "autoplay";

        }
        else{
            $autoPlay = "";
            
        }

        $filePath = $this->art->getFilePath();
        return "<img class='videoPlayer'
                src ='$filePath'
                
                >";
    }
}




?>
