<?php
class artworksProvider {

    private $con, $userLoggedInObj;

    public function __construct($con, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function getArtworks() {
        $artworks = array();

        $query = $this->con->prepare("SELECT * FROM art ");
        $query->execute();

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $art = new art($this->con, $row, $this->userLoggedInObj);
            array_push($artworks, $art);
        }

        return $artworks;
    }
}
?>