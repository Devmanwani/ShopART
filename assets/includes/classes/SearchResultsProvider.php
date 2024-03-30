<?php
class SearchResultsProvider {

    private $con, $userLoggedInObj;

    public function __construct($con, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function getArtworks($term) {
        $query = $this->con->prepare("SELECT * FROM art WHERE title LIKE CONCAT('%', :term, '%')
                                        OR ownedBy LIKE CONCAT('%', :term, '%')");
        $query->bindParam(":term", $term);
        $query->execute();

        $artworks = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $art = new art($this->con, $row, $this->userLoggedInObj);
            array_push($artworks, $art);
        }

        return $artworks;

    }

    public function getArtworksFilter($term, $filter)
{
    function generateSearchQuery($term, $filter)
    {
        switch (strtolower($filter)) {
            case 'date':
                return "SELECT * FROM art WHERE title LIKE CONCAT('%', :term, '%') OR ownedBy LIKE CONCAT('%', :term, '%') ORDER BY uploadDate DESC";
            case 'name':
                return "SELECT * FROM art WHERE title LIKE CONCAT('%', :term, '%')";
            case 'owner':
                return "SELECT * FROM art WHERE ownedBy LIKE CONCAT('%', :term, '%')";
            case 'price':
                return "SELECT * FROM art WHERE title LIKE CONCAT('%', :term, '%') OR ownedBy LIKE CONCAT('%', :term, '%') ORDER BY Price ASC";
            default:
                return "";
        }
    }

    $query = $this->con->prepare(generateSearchQuery($term, $filter));
    $query->bindParam(":term", $term);
    $query->execute();

    $artworks = array();
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $art = new art($this->con, $row, $this->userLoggedInObj);
        array_push($artworks, $art);
    }

    return $artworks;
}


}
?>