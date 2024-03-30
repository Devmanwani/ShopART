<?php
class transactionDetails {
    private $con, $sqlData;

    public function __construct($con, $username){
        $this->con = $con;

        $query = $this->con->prepare("SELECT * FROM transaction WHERE bought_from = :un OR sold_to = :un" );
        $query->bindParam(":un", $username);
        $query->execute();

        $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getUsername(){
        if (is_array($this->sqlData)) {
            return $this->sqlData["username"];
        } else {
            return false;
        }
    }

    public function getId(){
        return $this->sqlData["id"];
    }

    public function getArtId(){
        return $this->sqlData["art_id"];
    }

    public function getTransaction(){
        return $this->sqlData["transaction"];
    }

    public function getPrice(){
        return $this->sqlData["price"];
    }

    public function getBoughtFrom(){
        return $this->sqlData["bought_from"];
    }

    public function getSoldTo(){
        return $this->sqlData["sold_to"];
    }

    public function getDate(){
        $date= $this->sqlData["date"];
        return date("M jS, Y",strtotime($date));
    }

    public static function getAllTransactionsForUser($con, $username){
        $query = $con->prepare("SELECT * FROM transaction WHERE bought_from = :un OR sold_to = :un ORDER BY id DESC" );
        $query->bindParam(":un", $username);
        $query->execute();
    
        $transactions = array();
    
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $transaction = new self($con, $username);
            $transaction->sqlData = $row; // Set sqlData for each transaction
            $transactions[] = $transaction;
        }
    
        return $transactions;
    }


    public static function getTransactionById($con, $transactionId) {
        $query = $con->prepare("SELECT * FROM transaction WHERE id = :id");
        $query->bindParam(":id", $transactionId);
        $query->execute();

        $transaction = new self($con, ''); // Empty string as username won't be used

        if ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $transaction->sqlData = $row; // Set sqlData for the specific transaction
            return $transaction;
        }

        return null; // Return null if transaction with the given ID is not found
    }

    public static function getAllTransactionsForAdmin($con, $username){
        $query = $con->prepare("SELECT * FROM transaction ORDER BY id DESC" );
        
        $query->execute();

        $transactions = array();

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $transaction = new self($con, $username);
            $transaction->sqlData = $row; // Set sqlData for each transaction
            $transactions[] = $transaction;
        }

        return $transactions;
    }
}
?>
