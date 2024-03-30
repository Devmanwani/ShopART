<?php
require_once("assets/includes/config.php");
require_once("assets/includes/classes/account.php");
require_once("assets/includes/classes/constants.php");
if (isset($_GET['em'])) {
    $email = $_GET['em'];
}

function generateOTP($length = 4) {
    $otp = "";
    $characters = "0123456789";
    $charLength = strlen($characters);

    for ($i = 0; $i < $length; $i++) {
        $otp .= $characters[rand(0, $charLength - 1)];
    }

    return $otp;
}
$otp = generateOTP();
$_SESSION['otp'] = $otp;
    
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'add your email';            // SMTP username
    $mail->Password = 'add your password';                 // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    // Recipients
    $mail->setFrom('add your email');
    $mail->addAddress($email);                            // Add a recipient

    // Content
    $mail->isHTML(false);                                 // Set email format to plain text
    $mail->Subject = 'OTP to reset password';
    //$otp = generateOTP();                                 // Generate OTP
    $mail->Body = 'Your OTP to reset the password is ' . $otp;

    // Send the email
    if ($mail->send()) {
        $recipientAddress = $email;
        header("Location:otp.php?em=" .($email));
        exit();
    } else {
        echo "Email sending failed. Error: {$mail->ErrorInfo}";
    }
} catch (Exception $e) {
    echo "Email sending failed. Error: {$mail->ErrorInfo}";
}



?>


