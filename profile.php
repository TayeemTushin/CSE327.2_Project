<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
}

require_once 'db_connect.php';
$conn = Database::getInstance()->getConnection();
$username = $_SESSION["user"];

//  Handle profile update
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newUsername = trim($_POST['username']);
    $email       = trim($_POST['email']);
    $phone       = trim($_POST['phone']);
    $present_address = trim($_POST['present_address']);
    $work_address    = trim($_POST['work_address']);
    $profile_pic     = null;

    // Handle profile picture upload
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
        $stmt = $conn->prepare("UPDATE users SET username=?, email=?, phone=?, present_address=?, work_address=?, profile_pic=? WHERE username=?");
        $stmt->bind_param("sssssss", $newUsername, $email, $phone, $present_address, $work_address, $profile_pic, $username);
    } else {
        $stmt = $conn->prepare("UPDATE users SET username=?, email=?, phone=?, present_address=?, work_address=? WHERE username=?");
        $stmt->bind_param("ssssss", $newUsername, $email, $phone, $present_address, $work_address, $username);
    }

    if ($stmt->execute()) {
        $_SESSION["user"] = $newUsername; // update session if username changed
        $stmt->close();
        $success = "Profile updated successfully!";
    } else {
        $error = "Update failed: " . $stmt->error;
    }
}

// 🔹 Fetch current profile data
$stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
$stmt->bind_param("s", $_SESSION["user"]);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Profile</title>
<style>
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(90deg, #e2e2e2, #982dea);
    margin: 0;
    padding: 0;
    color: #333;
}
.container {
    max-width: 600px;
    margin: 50px auto;
    background: #fff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}
h2 {
    color: #982dea;
    text-align: center;
    margin-bottom: 20px;
}
.profile-pic {
    display: block;
    margin: 0 auto 20px auto;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    border: 3px solid #982dea;
    object-fit: cover;
}
label {
    font-weight: 600;
    display: block;
    margin-top: 15px;
}
input {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border-radius: 8px;
    border: 1px solid #ccc;
}
button {
    margin-top: 20px;
    width: 100%;
    padding: 10px;
    background: #982dea;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
}
button:hover { background: #7d1ac6; }
.back-link {
    display: block;
    margin-top: 15px;
    text-align: center;
    color: #982dea;
    text-decoration: none;
    font-weight: bold;
}
.success-message {
    text-align: center;
    padding: 10px;
    background-color: #d4edda;
    color: #155724;
    margin-bottom: 15px;
    border-radius: 8px;
}
.error-message {
    text-align: center;
    padding: 10px;
    background-color: #f8d7da;
    color: #721c24;
    margin-bottom: 15px;
    border-radius: 8px;
}
</style>
</head>
<body>

<div class="container">
    <h2>My Profile</h2>

    <?php if(!empty($success)) echo "<div class='success-message'>{$success}</div>"; ?>
    <?php if(!empty($error)) echo "<div class='error-message'>{$error}</div>"; ?>

    <img src="<?= $user['profile_pic'] ? "uploads/".$user['profile_pic'] : "assets/default.png"; ?>" class="profile-pic">

    <form method="POST" enctype="multipart/form-data">
        <label>Username</label>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label>Phone Number</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>">

        <label>Present Address</label>
        <input type="text" name="present_address" value="<?= htmlspecialchars($user['present_address']) ?>">

        <label>Work Address</label>
        <input type="text" name="work_address" value="<?= htmlspecialchars($user['work_address']) ?>">

        <label>Profile Picture</label>
        <input type="file" name="profile_pic">

        <button type="submit">Update Profile</button>
    </form>

    <a href="dashboard.php" class="back-link">⬅ Back to Dashboard</a>
    <a href="profile_view.php" class="back-link">View Rides </a>
</div>

</body>
</html>
