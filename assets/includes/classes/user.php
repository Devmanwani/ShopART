<?php
class user {
    private $con, $sqlData;

    public function __construct($con, $username){

        $this->con = $con;

        $query = $this->con->prepare("SELECT * FROM users WHERE username = :un" );
        $query->bindParam(":un", $username);
        $query->execute();

        $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);

    }

    public static function isLoggedIn() {
        return isset($_SESSION["userLoggedIn"]);
    }

    public function getUsername(){
        if (is_array($this->sqlData)) {
            return $this->sqlData["username"];
        } else {
            return false;
        }
    }
    
    /*public function getUsername(){
        return $this->sqlData["username"];
        
    }*/

    public function getname(){
        return $this->sqlData["firstName"] . " " . $this->sqlData["lastName"];
        
    }

    public function getfirstName(){
        return $this->sqlData["firstName"];
        
    }

    public function getlastName(){
        return $this->sqlData["lastName"];
        
    }

    public function getEmail(){
        return $this->sqlData["email"];
        
    }

    public function getProfilePic(){
        if (is_array($this->sqlData)) {
            return $this->sqlData["profilePic"];
        } else {
            return false;
        }
    }

    public function getsignUpDate(){
        return $this->sqlData["signUpDate"];
        
    }
    public function getBalance(){
        $price = $this->sqlData["wallet"];
        $currencyValue = $currencyValue = isset($_COOKIE['currency']) ? $_COOKIE['currency'] : 'INR';
        if($currencyValue=='USD'){
            $price = number_format($price / 83, 2) . " $";
        }else{
            $price = $price. " ₹";
        }
        return $price;
    }

    public function getAmount(){
        return $this->sqlData["wallet"];
        
    }

    public function hasBalance() {
        $balance = $this->sqlData["wallet"];
        
        if ($balance > 0) {
            return true;
        } else {
            return false;
        }
    }

   
}


?>