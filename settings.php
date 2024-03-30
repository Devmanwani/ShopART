<?php
require_once("assets/includes/header.php");
require_once("assets/includes/classes/account.php");
require_once("assets/includes/classes/formEdit.php");
require_once("assets/includes/classes/SettingsFormProvider.php");
require_once("assets/includes/classes/constants.php");

if(!user::isLoggedIn()) {
    header("Location: signIn.php");
}



$detailsMessage = "";
$passwordMessage = "";
$formProvider = new SettingsFormProvider();

if(isset($_POST["saveDetailsButton"])) {
    $account = new account($con);

    $firstName = formEdit::formEditString($_POST["firstName"]);
    $lastName = formEdit::formEditString($_POST["lastName"]);
    $email = formEdit::formEditEmail($_POST["email"]);
    $uname="";

    if(isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == 'admin'){
        if(isset($_GET['username'])){
            $uname = $_GET['username'];
        }else{
            $uname = $userLoggedInObj->getusername();
        }
    }else{
        $uname = $userLoggedInObj->getusername();
    }
    

    if($account->updateDetails($firstName, $lastName, $email,$uname)) {
        $detailsMessage = "<div class='alert alert-success'>
                                <strong>SUCCESS!</strong> Details updated successfully!
                            </div>";
    }
    else {
        $errorMessage = $account->getFirstError();

        if($errorMessage == "") $errorMessage = "Something went wrong";

        $detailsMessage = "<div class='alert alert-danger'>
                                <strong>ERROR!</strong> $errorMessage
                            </div>";
    }
}

if(isset($_POST["savePasswordButton"])) {
    $account = new account($con);

    $oldPassword = formEdit::formEditPassword($_POST["oldPassword"]);
    $newPassword = formEdit::formEditPassword($_POST["newPassword"]);
    $newPassword2 = formEdit::formEditPassword($_POST["newPassword2"]);

    if(isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == 'admin'){
        if(isset($_GET['username'])){
            $uname = $_GET['username'];
        }else{
            $uname = $userLoggedInObj->getusername();
        }
    }else{
        $uname = $userLoggedInObj->getusername();
    }

    if($account->updatePassword($oldPassword, $newPassword, $newPassword2, $uname)) {
        $passwordMessage = "<div class='alert alert-success'>
                                <strong>SUCCESS!</strong> Password updated successfully!
                            </div>";
    }
    else {
        $errorMessage = $account->getFirstError();

        if($errorMessage == "") $errorMessage = "Something went wrong";

        $passwordMessage = "<div class='alert alert-danger'>
                                <strong>ERROR!</strong> $errorMessage
                            </div>";
    }
}
?>
<div class="settingsContainer column">

    <div class="formSection">
        <div class="message">
            <?php echo $detailsMessage; ?>
        </div>
        <?php
    if(isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == 'admin'){
        if(isset($_GET['username'])){
            $uname = $_GET['username'];
        }else{
            $uname = $userLoggedInObj->getusername();
        }
    }else{
        $uname = $userLoggedInObj->getusername();
    }
        $userLoggedIn = new user($con, $uname);
            echo $formProvider->createUserDetailsForm(
                isset($_POST["firstName"]) ? $_POST["firstName"] : $userLoggedIn->getFirstName(),
                isset($_POST["lastName"]) ? $_POST["lastName"] : $userLoggedIn->getLastName(),
                isset($_POST["email"]) ? $_POST["email"] : $userLoggedIn->getEmail()
            );
        ?>
    </div>

    <div class="formSection">
        <div class="message">
            <?php echo $passwordMessage; ?>
        </div>
        <?php
            echo $formProvider->createPasswordForm();
            
        ?>
    </div>

    

</div>