<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "otptester";

$connect = new mysqli($servername, $username, $password, $dbname);

$email = "";
$stored_otp = "";
$message = "";
$ip_address = $_SERVER['REMOTE_ADDR'];

$sql = "SELECT email, otp FROM otp WHERE ip = '$ip_address' AND status = 'pending' ORDER BY otp_send_time DESC";
$result = $connect->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $email = $row['email'];
    $stored_otp = $row['otp'];
} else {
    $message = "No pending OTP with this IP address";
}

if (isset($_POST['verify'])) {
    $entered_otp = $_POST['otp'];
    if ($entered_otp === $stored_otp) {
        $sql_update = "UPDATE otp SET status = 'verified' WHERE email = '$email' AND ip = '$ip_address'";
        if ($connect->query($sql_update) === TRUE) {
            $message = "Email Verified Successfully";
            header("Location: success.php");
            exit();
        } else {
            $message = "Error updating OTP status: " . $connect->error;
        }
    } else {
        $message = "Invalid OTP. Please try again.";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="form-container">
        <h5>Verify OTP</h5>
        <?php if ($email): ?>
        <div class="alert alert-info">
            Your Email Is:Strong <strong><?php echo htmlspecialchars($email); ?></strong>
        </div>
    
            <?php else: ?>

    </div>
    <div class="alert alert-danger" role="alert">
        <?php echo $message; ?>
    </div>

    <?php endif; ?>

    <form action="" method="POST">
        <div class="mb-3 input-group">
            <span class="input-group-text"> <i class="fas fa-key"></i></span>
            <input type="text" name="otp" id="otp" class="form-control" placeholder="Enter your otp">
        </div>
        <button type="submit" name="verify" class="btn btn-primary w-100">
            Verify OTP <i class="fas fa-arrow-right button-icon"></i>
        </button>
    </form>

    <?php if ($message && !$email): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
</body>
</html>