<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "otptester";

$connect = new mysqli($servername, $username, $password, $dbname);

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (isset($_POST['send'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $otp = $_POST['otp'];

    $ip_address = $_SERVER['REMOTE_ADDR'];

    $sql = "INSERT INTO otp (name,email,phone,password,otp,status,otp_send_time,ip) VALUES 
    ('$name','$email','$phone','$password','$otp','pending',NOW(),'$ip_address')";

    if ($connect->query($sql) === TRUE) {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            // SMTP server configuration - update with your SMTP server details
            $mail->Host = 'smtp.gmail.com';  // Set the SMTP server to send through
            $mail->SMTPAuth = true;
            $mail->Username = 'bigornia.kaisser@gmail.com'; // SMTP username - replace with your email
            $mail->Password = 'zinjprghhtfjindo'; // SMTP password - replace with your email password or app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('bigornia.kaisser@gmail.com', 'Mailer');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = isset($_POST['subject']) ? $_POST['subject'] : 'OTP Verification';
            $mail->Body = "Your OTP Verification is: " . $otp;

            $mail->send();
            echo "
            <script>
            alert('Verification code has been sent to your email.');
            document.location.href='verify.php';
            </script>";
        } catch (Exception $e) {
            echo "
            <script>
            alert('ERROR: Message could not be sent. Mailer Error: {$mail->ErrorInfo}. Please check your SMTP settings, credentials, and network connection.');
            document.location.href='index.php';
            </script>";
        }
    } else {
        echo "
        <script>
        alert('ERROR: " . $connect->error . "');
        document.location.href='index.php';
        </script>";
    }
}
?>
