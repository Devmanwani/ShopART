<?php


require_once("assets/includes/config.php");
require_once("assets/includes/classes/account.php");
require_once("assets/includes/classes/constants.php");
$email = $_GET['em'];


$account = new account($con);

if (isset($_POST['submitButton'])) {
    if (isset($_POST['password'])) {
        $otp = $_SESSION['otp'] ?? '';
        $password = $_POST['password'];
        unset($_SESSION['otp']);

        if ($otp == $password) {
            $em = $_GET['em'];
            header("Location:newpass.php?em=" . ($em));
            exit();
        } else {
            $error = $account->getError(constants::$loginFailed);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>PIXEL</title>
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-5.1.0-dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="assets/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.1/umd/popper.min.js" integrity="sha512-8jeQKzUKh/0pqnK24AfqZYxlQ8JdQjl9gGONwGwKbJiEaAPkD3eoIjz3IuX4IrP+dnxkchGUeWdXLazLHin+UQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/bootstrap-5.1.0-dist/js/bootstrap.min.js"></script>
    <script src="javascript/commonActions.js"></script>
</head>
<body>
    <div class="signInContainer">
        <div class="column">
            <div class="header">
                <img src="assets/images/icons/logo2.png" title="logo" alt="ShopART">
                <h3>Enter OTP</h3>
                <span>to continue to ShopART</span>
            </div>
            <div class="loginForm">
                <form action="otp.php?em=<?php if (isset($_GET['em'])) { echo ($_GET['em']); } ?>" method="POST">
                    <?php echo isset($error) ? $error : ''; ?>
                    <input type="password" name="password" placeholder="Password" pattern="[0-9]{4}" required>
                    <input type="submit" name="submitButton" value="SUBMIT">
                </form>
            </div>
            <a class="signInMessage" href="signup.php">Need an account? Sign up here!</a>
        </div>
    </div>
</body>
</html>
