<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $enteredOtp = $_POST["otp_input"];
    $email = $_POST["email"];

    if (
        isset($_SESSION["driver_otp"], $_SESSION["driver_email"], $_SESSION["driver_name"], $_SESSION["driver_password"], $_SESSION["driver_phone"], $_SESSION["driver_license_no"]) &&
        $_SESSION["driver_email"] === $email &&
        $_SESSION["driver_otp"] == $enteredOtp
    ) {
        // DB connection
        require_once 'db_connect.php';
        $conn = Database::getInstance()->getConnection();

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $name = $_SESSION["driver_name"];
        $hashedPassword = password_hash($_SESSION["driver_password"], PASSWORD_DEFAULT);
        $phone = $_SESSION["driver_phone"];
        $license_no = $_SESSION["driver_license_no"];

        // Insert into drivers table
        $stmt = $conn->prepare("INSERT INTO drivers (name, email, password, phone, license_no) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $hashedPassword, $phone, $license_no);
        $stmt->execute();
        $stmt->close();
        $conn->close();

        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    } else {
        echo "<h2 style='color:red; text-align:center;'>Invalid OTP. Try again.</h2>";
        echo "<p style='text-align:center;'><a href='index.php?show=driver_otp&email=$email'>Retry</a></p>";
    }
}
?>

<!-- In index.php, driver registration form -->
<form action="driver_send_otp.php" method="POST">
    <h1>Driver Registration</h1>
    <div class="input-box">
        <input type="text" name="name" placeholder="Driver Name" required>
        <i class="bx bx-user"></i>
    </div>
    <div class="input-box">
        <input type="email" name="email" placeholder="Driver E-mail" required>
        <i class="bx bx-envelope"></i>
    </div>
    <div class="input-box">
        <input type="password" name="password" placeholder="Password" required>
        <i class="bx bx-lock"></i>
    </div>
    <div class="input-box">
        <input type="text" name="phone" placeholder="Phone Number" required>
        <i class="bx bx-phone"></i>
    </div>
    <div class="input-box">
        <input type="text" name="license_no" placeholder="License Number" required>
        <i class="bx bx-id-card"></i>
    </div>
    <button type="submit" class="btn">Sign Up as Driver</button>
    <p>Already have a driver account?</p>
    <button type="button" class="btn driver-login-btn" id="showDriverLogin">Login as Driver</button>
</form>