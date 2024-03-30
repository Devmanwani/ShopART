<?php
class photographyProvider {

    private $con, $userLoggedInObj;

    public function __construct($con, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function getArtworks() {
        $artworks = array();

        $query = $this->con->prepare("SELECT * FROM art WHERE Categories=3 
                                        ORDER BY views DESC LIMIT 15");
        $query->execute();

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $art = new art($this->con, $row, $this->userLoggedInObj);
            array_push($artworks, $art);
        }

        return $artworks;
    }
}
?>