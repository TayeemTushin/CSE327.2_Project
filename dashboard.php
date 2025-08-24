<?php
session_start();
if (!isset($_SESSION["user"]) && !isset($_SESSION["driver"])) {
    header("Location: index.php");
    exit();
}

require_once 'db_connect.php';
$conn = Database::getInstance()->getConnection();
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION["user"];
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(90deg, #e2e2e2, #982dea);
            margin: 0;
            padding: 0;
            color: #333;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #982dea;
            padding: 10px 20px;
            color: white;
        }

        .profile-icon {
            font-size: 28px;
            cursor: pointer;
        }

        .btn {
            background: #fff;
            color: #982dea;
            border: none;
            padding: 8px 15px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-group {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .features-row {
            display: flex;
            justify-content: space-around;
            gap: 20px;
            margin: 50px auto;
            max-width: 1000px;
            flex-wrap: wrap;
        }

        .feature-card {
            background: white;
            padding: 30px;
            border-radius: 20px;
            width: 280px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(152, 45, 234, 0.3);
        }

        .feature-card img {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
        }

        .feature-card h3 {
            color: #982dea;
            margin-bottom: 10px;
        }

        .feature-card p {
            font-size: 14px;
            color: #444;
        }
    </style>
</head>
<body>

    <!-- Top bar -->
    <div class="top-bar">
        <i class='bx bx-user-circle profile-icon'></i>
        <h1 class="top-title">Ride Sharing Platform</h1>
        <div class="btn-group">
            <!-- Profile Button now links to profile.php -->
            <a href="profile.php" class="btn">Profile</a>
            <!-- Logout Button -->
            <form action="logout.php" method="POST">
                <button type="submit" class="btn">Logout</button>
            </form>
        </div>
    </div>

    <div class="features-row">
        <a href="find.php" class="feature-card">
            <img src="assets/share.png" alt="Find Ride Partner">
            <h3>Find Ride Partner</h3>
            <p>Match with people going your way and split costs.</p>
        </a>

        <a href="features_integration.php" class="feature-card">
    <img src="assets/main.avif" alt="Smart Features">
    <h3>Explore Smart Features</h3>
    <p>Test fare, route, rating, payment, and cancellation strategies.</p>
</a>
    </div>

    

</body>
</html>
