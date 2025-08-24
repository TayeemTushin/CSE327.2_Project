<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $password = $_POST["password"];

    require_once 'db_connect.php';
    $conn = Database::getInstance()->getConnection();

    $stmt = $conn->prepare("SELECT password FROM drivers WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $_SESSION["driver"] = $name;
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<h2 style='color:red; text-align:center;'>Incorrect password.</h2>";
        }
    } else {
        echo "<h2 style='color:red; text-align:center;'>Driver not found.</h2>";
    }

    $stmt->close();
    $conn->close();
}
?>