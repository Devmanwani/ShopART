<?php
class artGrid{

    private $con, $userLoggedInObj;
    private $largeMode=false;
    private $gridClass="artGrid";

    public function __construct($con, $userLoggedInObj){
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function create($artworks, $title){

        if($artworks==null){
            $gridItems=$this->generateItems();

        }
        else{
            $gridItems = $this->generateItemsFromArtworks($artworks);
        }

        $header="";

        if($title !=null){
            $header=$this->createGridHeader($title);

            
        }

        return "$header
                <div class='$this->gridClass'>
                    $gridItems
                </div>";
    }

    public function generateItems(){
        $query = $this->con->prepare("SELECT * FROM art ORDER BY RAND() LIMIT 15");
        $query->execute();
    
        $elementsHtml="";
        while($row=$query->fetch(PDO::FETCH_ASSOC)){
            
            $video = new art($this->con, $row, $this->userLoggedInObj);
            $item = new artGridItem($video, $this->largeMode);
            $elementsHtml .= $item->create();
        }
    
        return $elementsHtml;
    }
    
    public function generateItemsFromArtworks($artworks){
    
        $elementsHtml = "";

        foreach($artworks as $art) {
            $item = new artGridItem($art, $this->largeMode);
            $elementsHtml .= $item->create();
        }

        return $elementsHtml;
    }
    
    public function createGridHeader($title){
        
        return "<div class='videoGridHeader'>
                    <div class='left'>
                        $title 
                    </div>
                </div>";
    }

    public function createLarge($artworks, $title){
        $this->gridClass .=" large";
        $this->largeMode=true;
        return $this->create($artworks, $title);
    }

}



?>