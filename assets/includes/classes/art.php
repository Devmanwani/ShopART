<?php

class art{
    private $con, $sqlData, $userLoggedInObj;


    public function __construct($con, $input, $userLoggedInObj){

        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;

        if(is_array($input)){
            $this->sqlData = $input;
        }
        else{
        $query = $this->con->prepare("SELECT * FROM art WHERE id = :id" );
        $query->bindParam(":id", $input);
        $query->execute();
        

        $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function getId(){
        return $this->sqlData["id"];
        
    }

    public function getUploadedBy(){
        return $this->sqlData["uploadedBy"];
        
    }

    public function getOwnedBy(){
        return $this->sqlData["ownedBy"];
        
    }

    public function getTitle(){
        return $this->sqlData["title"];
        
    }

    public function getDescription(){
        return $this->sqlData["description"];
        
    }

    public function getPrivacy(){
        return $this->sqlData["privacy"];
        
    }



    public function getFilePath(){
        return $this->sqlData["filePath"];
        
    }

    public function getPrice(){
        return $this->sqlData["Price"];
    }

    public function getCategories(){
        return $this->sqlData["Categories"];
        
    }

    public function getUploadDate(){
        $date= $this->sqlData["uploadDate"];
        return date("M j, Y",strtotime($date));
        
    }

    public function getTimeStamp(){
        $date= $this->sqlData["uploadDate"];
        return date("M jS, Y",strtotime($date));
        
    }

    public function getViews(){
        return $this->sqlData["Views"];
        
    }

    

    

    public function incrementViews(){
        $query = $this->con->prepare("UPDATE art SET Views=Views+1 WHERE id=:id");
        $query->bindParam(":id", $artId);

        $artId = $this->getId();
        $query->execute();

        $this->sqlData["Views"] = $this->sqlData["Views"]+1;
    }

    public function getLikes(){
        $query = $this->con->prepare("SELECT count(*) as 'count' FROM likes WHERE artId = :artId");
        $query->bindParam(":artId", $artId);
        $artId = $this->getId();
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);
        return $data["count"];

    }

    

    public function like() {
        $id = $this->getId();
        $username = $this->userLoggedInObj->getUsername();

        if($this->wasLikedBy()) {
            // User has already liked
            $query = $this->con->prepare("DELETE FROM likes WHERE username=:username AND artId=:artId");
            $query->bindParam(":username", $username);
            $query->bindParam(":artId", $id);
            $query->execute();

            $result = array(
                "likes"=> -1,

            );
            return json_encode($result);
        }
        else {

            

            $query = $this->con->prepare("INSERT INTO likes(username, artId) VALUES(:username, :artId)");
            $query->bindParam(":username", $username);
            $query->bindParam(":artId", $id);
            $query->execute();

            
            $result = array(
                "likes"=> 1,

            );
            return json_encode($result);
        }
    }

   

    public function wasLikedBy(){
        $id = $this->getId();

        $query = $this->con->prepare("SELECT * FROM likes WHERE username=:username AND artId=:artId");
        $query->bindParam(":username", $username);
        $query->bindParam(":artId", $id);

        $username = $this->userLoggedInObj->getUsername();
        $query->execute();
        return $query->rowCount() > 0;

    }


    public function getArtwork(){

        $query=$this->con->prepare("SELECT filePath FROM art WHERE id=:id");
        $query->bindParam(":id", $id);
        $id = $this->getId();
        $query->execute();

        return $query->fetchColumn();
    }

    public function purchaseArtwork(){
        $con=$this->con;
        $username = $this->userLoggedInObj->getUsername();
        $artId = $this->getId();
        $query = $this->con->prepare("UPDATE art SET ownedBy = :username WHERE id = :artId");
        $query->bindParam(":username", $username);
        $query->bindParam(":artId", $artId);
        $query->execute();

        return true;
    }

}


?>