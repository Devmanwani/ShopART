<?php
class ProfileData {
    
    private $con, $profileUserObj;

    public function __construct($con, $profileUsername) {
        $this->con = $con;
        $this->profileUserObj = new user($con, $profileUsername);
    }

    public function getProfileUserObj() {
        return $this->profileUserObj;
    }

    public function getProfileUsername() {
        return $this->profileUserObj->getUsername();
    }

    public function userExists() {
        $query = $this->con->prepare("SELECT * FROM users WHERE username = :username");
        $query->bindParam(":username", $profileUsername);
        $profileUsername = $this->getProfileUsername();
        $query->execute();

        return $query->rowCount() != 0;
    }

    public function getCoverPhoto() {
        return "assets/images/coverPhotos/default-cover-photo.jpg";
    }

    public function getProfileUserFullName() {
        return $this->profileUserObj->getName();
    }

    public function getProfilePic() {
        return $this->profileUserObj->getProfilePic();
    }

    public function getSubscriberCount() {
        return $this->profileUserObj->getSubscriberCount();
    }

    public function getUsersArtworks() {
        $query = $this->con->prepare("SELECT * FROM art WHERE ownedBy=:ownedBy ORDER BY uploadDate DESC");
        $query->bindParam(":ownedBy", $username);
        $username = $this->getProfileUsername();
        $query->execute();

        $artworks = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $artworks[] = new art($this->con, $row, $this->profileUserObj->getUsername());
        }
        return $artworks;
    }

    public function getAllUserDetails() {
        return array(
            "Name" => $this->getProfileUserFullName(),
            "Username" => $this->getProfileUsername(),
            "Total views" => $this->getTotalViews(),
            "Sign up date" => $this->getSignUpDate()
        );
    }

    private function getTotalViews() {
        $query = $this->con->prepare("SELECT sum(views) FROM art WHERE uploadedBy=:uploadedBy");
        $query->bindParam(":uploadedBy", $username);
        $username = $this->getProfileUsername();
        $query->execute();

        return $query->fetchColumn();
    }

    private function getSignUpDate() {
        $date = $this->profileUserObj->getSignUpDate();
        return date("F jS, Y", strtotime($date));
    }

    
    public function updateProfilePic($artUploadData){

        $targetdir="uploads/ProfilePicture/";
        $artData=$artUploadData;

        $tempFilePath=$targetdir . uniqid() . basename($artData["name"]);

        $tempFilePath= str_replace(" ","_",$tempFilePath);

        

        if (move_uploaded_file($artData["tmp_name"], $tempFilePath)){
            
            //$finalFilePath = $targetdir . uniqid() . ".mp4";

            if(!$this->updateProfile($tempFilePath)){
            echo " insert query failed";
            return false;
            }

            
            return true;
        }
    }
    public function updateProfile($url){
        
        $username = $this->profileUserObj->getUsername();
        $query = $this->con->prepare("UPDATE users SET profilePic=:pic where username=:un");
        $query->bindParam(":un", $username);
        $query->bindParam(":pic",$url);
        return $query->execute();
    }
}
?>