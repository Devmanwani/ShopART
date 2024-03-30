<?php require_once("assets/includes/config.php");
require_once("assets/includes/classes/formEdit.php");
require_once("assets/includes/classes/account.php");
require_once("assets/includes/classes/constants.php");

$account = new account($con);

if (isset($_POST["submitButton"])){

    $email = formEdit::formEditEmail($_POST["email"]);

    $wasSuccessful = $account->validateEmail($email);
    if($wasSuccessful){
        header("Location:test.php?em=$email");
    }
    else{
        echo "failed";
    }
}

function getInputValue($name){
    if(isset($_POST[$name])){
        echo $_POST[$name];
    }
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Reset Password</title>
<link rel="stylesheet" type= "text/css" href="assets/bootstrap-5.1.0-dist/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="style.css">
<script src="assets/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.1/umd/popper.min.js" integrity="sha512-8jeQKzUKh/0pqnK24AfqZYxlQ8JdQjl9gGONwGwKbJiEaAPkD3eoIjz3IuX4IrP+dnxkchGUeWdXLazLHin+UQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="assets/bootstrap-5.1.0-dist/js/bootstrap.min.js"></script>

</head>
<body>
<div class="signUpContainer">

<div class="column">

    <div class="header">
    <img src="assets/images/icons/logo2.png" title="logo" alt="PIXEL">
        <h3><b>Reset Password<b></h3>
    </div>

    <div class="loginForm">
        <form action="resetpass.php" method = "POST">

            <?php echo $account->getError(constants::$firstNameCharacters);?>

                <?php echo $account->getError(constants::$emailInvalid);?>
                <?php echo $account->getError(constants::$emailNotFound);?>
                <input type="email" name="email" placeholder="Email"  value="<?php getInputValue('email');?>"  required>


                <input type="submit" name="submitButton" value="SUBMIT">
        </form> 
    
    </div>

    <a class="signInMessage" href="signIn.php"><b>Already have an account? Sign in here!<b></a>

</div>

</div>




</body>
</html>