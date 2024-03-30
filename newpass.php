<?php
require_once("assets/includes/config.php");
require_once("assets/includes/classes/formEdit.php");
require_once("assets/includes/classes/account.php");
require_once("assets/includes/classes/constants.php");

$email = $_GET['em'];

// Check if the page is accessed directly or not from otp.php
if (!isset($_SERVER['HTTP_REFERER']) || (strpos($_SERVER['HTTP_REFERER'], "otp.php?em=$email") === false)) {
    header("Location: index.php"); // Replace "index.php" with the desired page URL
    exit();
}

$account = new account($con);

if (isset($_POST["submitButton"])) {
    $pw = formEdit::formEditPassword($_POST["password"]);
    $pw2 = formEdit::formEditPassword($_POST["password2"]);
    $em = $_GET['em'];

    $wasSuccessful = $account->ResetPassword($pw, $pw2, $em);
    if ($wasSuccessful) {
        header("Location: signin.php");
        exit();
    } else {
        echo "failed";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title> Reset Password</title>
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
            <span style="font-size:16px;"><b>to continue to ShopART<b></span>
        </div>
        <div class="loginForm">
            <form action="newpass.php?em=<?php if(isset($_GET['em'])){ echo $_GET['em'];}?>" method="POST">
                <?php echo $account->getError(constants::$passwordsDoNotMatch);?>
                <?php echo $account->getError(constants::$passwordLength);?>
                <input type="password" name="password" placeholder="Password" autocomplete="off" required>
                <input type="password" name="password2" placeholder="Confirm password" autocomplete="off" required>
                <input type="submit" name="submitButton" value="SUBMIT">
            </form> 
        </div>
        <a class="signInMessage" href="signIn.php"><b>Already have an account? Sign in here!<b></a>
    </div>
</div>
</body>
</html>
