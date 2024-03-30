<?php
require_once("assets/includes/header.php");
require_once("assets/includes/classes/user.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>Withdraw</title>
</head>
<body>

<div class = "withdraw"> 
    <div class="upi"><span>▼  withdraw using UPI</span>
        
        <div id = 'upi'><input type="email" name = "upi" placeholder ="Enter UPI ID" required></div>
        
    </div>
    <div class = "account"><span>▼  Withdraw using bank account</span>
        
        <div id='accno'><input type="number" name = "account" placeholder = "Enter Account No." required></div>
        <div id = 'code'><input type="text"  name = "ifsc" placeholder = "Enter IFSC Code" required></div>
        
    </div>
    <div class="WithdrawAmount">
      <form action="withdraw.php" method="get">
        <input type="number" name = 'WithdrawAmount' placeholder = 'Enter Amount to Withdraw'arequired >
    </div>
    <button>Withdraw</button>
    </form>
</div>
</body>
<script>
let upi = document.querySelector('.upi span');
let upiContent = document.getElementById('upi');

function toggle() {
  if (upiContent.style.display === 'block') {
    upiContent.style.display = 'none';
  } else {
    upiContent.style.display = 'block';
  }
}

upi.addEventListener('click', toggle);

let account = document.querySelector('.account span');
let accno = document.getElementById('accno');
let code = document.getElementById('code');

function toggleacc() {
  if (accno.style.display && code.style.display === 'block') {
    accno.style.display = 'none';
    code.style.display = 'none';
  } else {
    code.style.display = 'block';
    accno.style.display = 'block';
  }
}

account.addEventListener('click', toggleacc);

</script>
<?php
if(user::isLoggedIn()){
$username = $_SESSION["userLoggedIn"];
$userLoggedInObj = new User($con, $username);
$oldBalance = $userLoggedInObj->getBalance();}else{
  header("location:index.php");
}


if(isset($_GET['WithdrawAmount'])){
  if($_GET['WithdrawAmount'] <= $oldBalance && $_GET['WithdrawAmount']>0){
    echo '<script type="text/javascript">';
    echo 'alert("Withdrawal successful");';
    echo '</script>';
    $newBalance = $oldBalance - $_GET['WithdrawAmount'];
    $query = $con->prepare("UPDATE users SET Wallet=:Wallet where username = :username");
    $query->bindParam(":Wallet",$newBalance);
    $query->bindParam(":username",$username);
    $query->execute();
  }else{
    echo '<script type="text/javascript">';
    echo 'alert("Enter Valid Input");';
    echo '</script>';
  }
}
?>


</html>