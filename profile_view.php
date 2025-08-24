<?php
session_start();
if (!isset($_SESSION["user"]) && !isset($_SESSION["driver"])) {
    header("Location: index.php");
    exit();
}

require_once 'db_connect.php';
$conn = Database::getInstance()->getConnection();

$username = $_SESSION["user"];

// 🔹 Handle profile update
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $phone = trim($_POST['phone']);
    $present_address = trim($_POST['present_address']);
    $work_address = trim($_POST['work_address']);
    $profile_pic = null;

    // Handle file upload
    if (!empty($_FILES['profile_pic']['name'])) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $profile_pic = time() . "_" . basename($_FILES['profile_pic']['name']);
        $targetFile = $targetDir . $profile_pic;

        if (!move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFile)) {
            $profile_pic = null;
        }
    }

    // Update database
    if ($profile_pic) {
        $stmt = $conn->prepare("UPDATE users SET phone=?, present_address=?, work_address=?, profile_pic=? WHERE username=?");
        $stmt->bind_param("sssss", $phone, $present_address, $work_address, $profile_pic, $username);
    } else {
        $stmt = $conn->prepare("UPDATE users SET phone=?, present_address=?, work_address=? WHERE username=?");
        $stmt->bind_param("ssss", $phone, $present_address, $work_address, $username);
    }
    $stmt->execute();
}

// 🔹 Fetch updated profile
$stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// 🔹 Fetch ride history using phone (not username)
$userPhone = $user['phone'];

$stmt2 = $conn->prepare("SELECT * FROM rides WHERE phone=? ORDER BY ride_date DESC");
$stmt2->bind_param("s", $userPhone);
$stmt2->execute();
$rides = $stmt2->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile Details</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #982dea, #6d1ac6);
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        h2 {
            text-align: center;
            color: #982dea;
            margin-bottom: 25px;
        }
        .profile-pic {
            display: block;
            margin: 0 auto 20px;
            width: 130px;
            height: 130px;
            border-radius: 50%;
            border: 4px solid #982dea;
            object-fit: cover;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .profile-card {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 25px;
        }
        .detail {
            padding: 12px;
            background: #f8f8f8;
            border-radius: 10px;
            font-size: 15px;
        }
        .rides h3 {
            text-align: center;
            color: #982dea;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            overflow-x: auto;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            font-size: 14px;
            text-align: center;
        }
        table th {
            background: #982dea;
            color: #fff;
        }
        table tr:hover {
            background: #f1e6ff;
        }
        .back-link {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 18px;
            background: #982dea;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
        }
        .back-link:hover {
            background: #6d1ac6;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>My Profile</h2>

        <img src="uploads/<?php echo $user['profile_pic'] ?: 'default.png'; ?>" class="profile-pic" alt="Profile Picture">

        <div class="profile-card">
            <div class="detail"><strong>👤 Username:</strong> <?php echo htmlspecialchars($user['username']); ?></div>
            <div class="detail"><strong>📧 Email:</strong> <?php echo htmlspecialchars($user['email']); ?></div>
            <div class="detail"><strong>📞 Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></div>
            <div class="detail"><strong>🏠 Present Address:</strong> <?php echo htmlspecialchars($user['present_address']); ?></div>
            <div class="detail"><strong>💼 Work Address:</strong> <?php echo htmlspecialchars($user['work_address']); ?></div>
        </div>

        <div class="rides">
            <h3>🚖 My Ride History</h3>
            <?php if ($rides->num_rows > 0): ?>
                <table>
                    <tr>
                        <th>Pickup</th>
                        <th>Destination</th>
                        <th>Distance (km)</th>
                        <th>Fare (BDT)</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                    <?php while ($ride = $rides->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($ride['pickup']); ?></td>
                            <td><?php echo htmlspecialchars($ride['destination']); ?></td>
                            <td><?php echo number_format($ride['distance'], 2); ?></td>
                            <td><?php echo number_format($ride['fare'], 2); ?></td>
                            <td><?php echo htmlspecialchars($ride['ride_date']); ?></td>
                            <td><?php echo htmlspecialchars($ride['ride_time']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p style="text-align:center; color:#777;">No rides found.</p>
            <?php endif; ?>
        </div>

        <div style="text-align:center;">
            <a href="dashboard.php" class="back-link">⬅ Back to Dashboard</a>
            
        </div>
    </div>
</body>
</html>
