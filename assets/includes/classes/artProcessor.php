<?php
class artProcessor{
    private $con;
    private $allowedTypes=array("jpg","png","jpeg","gif");
    

    public function __construct($con){
        $this->con=$con;
        
    }

    public function upload($artUploadData){

        $targetdir="uploads/videos/";
        $artData=$artUploadData->artDataArray;

        $tempFilePath=$targetdir . uniqid() . basename($artData["name"]);

        $tempFilePath= str_replace(" ","_",$tempFilePath);

        $isValidData = $this->processData($artData, $tempFilePath);

        if(!$isValidData){
            return false;
        }

        if (move_uploaded_file($artData["tmp_name"], $tempFilePath)){
            
            //$finalFilePath = $targetdir . uniqid() . ".mp4";

            if(!$this->insertArtData($artUploadData, $tempFilePath)){
            echo " insert query failed";
            return false;
            }

            
            return true;
        }
    }

    private function processData($artData, $filepath){

    $artType= pathinfo($filepath, PATHINFO_EXTENSION);

    if(!$this->isValidType($artType)) {
        echo "Invalid file type";
        return false;
    }

    else if($this->hasError($artData)){
        echo "Error code:"  . $artData["error"];
        return false;
    }

    return true;
    }

    private function isValidType($type) {
        $lowercased=strtolower($type);
        return in_array($lowercased, $this->allowedTypes);
    }

    private function hasError($data){
        return $data["error"]!=0;
    }

    private function insertArtData($uploadData, $filePath){
        $query= $this->con->prepare("INSERT INTO art(title, uploadedBy, description, Categories, filePath,Price, ownedBy)
                                    VALUES(:title, :uploadedBy, :description, :Categories, :filePath,:Price,:ownedBy)");
        
        $query->bindParam("title", $uploadData->title);
        $query->bindParam("uploadedBy", $uploadData->uploadedBy);
        $query->bindParam("description", $uploadData->description);
        $query->bindParam("Categories", $uploadData->Categories);
        $query->bindParam("filePath", $filePath); 
        $query->bindParam("Price", $uploadData->Price); 
        $query->bindParam("ownedBy", $uploadData->uploadedBy);
        
        return $query->execute();
    }

    

    

}
?>
