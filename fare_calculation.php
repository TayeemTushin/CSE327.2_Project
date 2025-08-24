<?php
// Debug mode ON (turn OFF in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
}

require_once 'db_connect.php';
$conn = Database::getInstance()->getConnection();
if (!$conn->ping()) {
    die("❌ Database connection failed.");
}

$username = $_SESSION["user"];

// Get user phone
$stmt = $conn->prepare("SELECT phone FROM users WHERE username=?");
if (!$stmt) die("❌ SQL Prepare failed: " . $conn->error);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$phone = $user['phone'] ?? null;
$stmt->close();

// Ride details
$pickup      = $_GET['pickup']      ?? 'Unknown';
$destination = $_GET['destination'] ?? 'Unknown';
$distance    = $_GET['distance']    ?? 0;
$fare        = $_GET['fare']        ?? 0;
$time        = $_GET['time']        ?? '00:00';
$ride_date   = $_GET['date']        ?? date("Y-m-d");

//  Handle Confirm Button POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['confirm']) && $phone) {
    $stmt = $conn->prepare("INSERT INTO rides (phone, pickup, destination, distance, fare, ride_date, ride_time) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) die("❌ Insert Prepare failed: " . $conn->error);
    $stmt->bind_param("sssddss", $phone, $pickup, $destination, $distance, $fare, $ride_date, $time);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Ride confirmed successfully!'); window.location.href='profile.php';</script>";
    } else {
        die("❌ Insert failed: " . $stmt->error);
    }
    $stmt->close();
    $conn->close();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fare Calculation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #83a4d4, #b6fbff);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .card {
            background: #fff;
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: 0px 8px 20px rgba(0,0,0,0.2);
            max-width: 400px;
            width: 90%;
            text-align: center;
            animation: fadeIn 0.6s ease-in-out;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .ride-info {
            text-align: left;
            margin-bottom: 20px;
        }
        .ride-info p {
            margin: 8px 0;
            font-size: 16px;
        }
        .btn {
            display: inline-block;
            padding: 12px 25px;
            border: none;
            border-radius: 10px;
            background: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.3s ease;
        }
        .btn:hover {
            background: #0056b3;
        }
        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(-20px);}
            to {opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Confirm Your Ride</h2>
        <div class="ride-info">
            <p><strong>User:</strong> <?= htmlspecialchars($username) ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($phone) ?></p>
            <p><strong>Pickup:</strong> <?= htmlspecialchars($pickup) ?></p>
            <p><strong>Destination:</strong> <?= htmlspecialchars($destination) ?></p>
            <p><strong>Distance:</strong> <?= htmlspecialchars($distance) ?> km</p>
            <p><strong>Fare:</strong> ৳<?= htmlspecialchars($fare) ?></p>
            <p><strong>Date:</strong> <?= htmlspecialchars($ride_date) ?></p>
            <p><strong>Time:</strong> <?= htmlspecialchars($time) ?></p>
        </div>
        <!--  Form posts back to same page -->
        <form method="post">
            <input type="hidden" name="confirm" value="1">
            <button type="submit" class="btn">Confirm Ride</button>
        </form>
    </div>
</body>
</html>
