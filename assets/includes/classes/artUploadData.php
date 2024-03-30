<?php 
class artUploadData {
    public $artDataArray, $title, $description, $Categories, $uploadedBy,$Price;

    public function __construct($artDataArray, $title, $description, $Categories, $uploadedBy,$Price){
        $this->artDataArray= $artDataArray;
        $this->title=$title;
        $this->description=$description;
        $this->Categories=$Categories;
        $this->uploadedBy=$uploadedBy;
        $this->Price = $Price;
    }

    public function updateDetails($con, $artId) {
        $query = $con->prepare("UPDATE art SET title=:title, description=:description,
                                    Categories=:Categories, Price=:Price WHERE id=:artid");
        $query->bindParam(":title", $this->title);
        $query->bindParam(":description", $this->description);
        $query->bindParam(":Categories", $this->Categories);
        $query->bindParam(":artid", $artId);
        $query->bindParam(":Price",$this->Price);


        return $query->execute();
    }

    
}
?>