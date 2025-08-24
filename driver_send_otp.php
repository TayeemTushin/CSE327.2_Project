<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $phone = $_POST["phone"];
    $license_no = $_POST["license_no"];
    $otp = rand(100000, 999999);

    $_SESSION["driver_otp"] = $otp;
    $_SESSION["driver_name"] = $name;
    $_SESSION["driver_email"] = $email;
    $_SESSION["driver_password"] = $password;
    $_SESSION["driver_phone"] = $phone;
    $_SESSION["driver_license_no"] = $license_no;

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 't.tushin360@gmail.com';
        $mail->Password = 'jbonfgxhddbgiemy';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('yourgmail@gmail.com', 'Ride Sharing Platform');
        $mail->addAddress($email);
        $mail->Subject = 'Your Driver OTP Verification Code';
        $mail->Body    = "Hi $name,\n\nYour OTP code is: $otp\n\nUse this to verify your driver account.";

        $mail->send();

        header("Location: index.php?show=driver_otp&email=" . urlencode($email));
        exit();
    } catch (Exception $e) {
        echo "OTP email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>