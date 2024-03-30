<?php
class LikedArtworksProvider {

    private $con, $userLoggedInObj;

    public function __construct($con, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function getArtworks() {
        $artworks = array();

        $query = $this->con->prepare("SELECT artId FROM likes WHERE username=:username
                                        ORDER BY id DESC");
        $query->bindParam(":username", $username);
        $username = $this->userLoggedInObj->getUsername();
        $query->execute();

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $artworks[] = new art($this->con, $row["artId"], $this->userLoggedInObj);
        }

        return $artworks;
    }
}
?>