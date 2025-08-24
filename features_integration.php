<?php
// Optional: keep this protected by login
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Smart Features</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .container { max-width: 900px; margin: 40px auto; }
    .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px,1fr)); gap: 16px; }
    .card { background:#fff; border-radius:16px; padding:18px; text-align:center; box-shadow:0 8px 20px rgba(0,0,0,0.08); }
    .card a { display:inline-block; margin-top:10px; text-decoration:none; padding:10px 14px; border-radius:8px; background:#982dea; color:#fff; }
  </style>
</head>
<body>
  <div class="container">
    <h1>🚗 Smart Ride Features</h1>
    <div class="grid">
      <div class="card">
        <h3>Fare Calculator</h3>
        <p>Standard • Luxury • Shared</p>
        <a href="fare_view.php">Open</a>
      </div>
      <div class="card">
        <h3>Route Optimization</h3>
        <p>Shortest • Fastest • Scenic</p>
        <a href="route_view.php">Open</a>
      </div>
      <div class="card">
        <h3>Payment Method</h3>
        <p>Credit • Cash • Wallet</p>
        <a href="payment_view.php">Open</a>
      </div>
      <div class="card">
        <h3>Driver Rating</h3>
        <p>Average • Weighted • Custom</p>
        <a href="driver_rating.php">Open</a>
      </div>
      <div class="card">
        <h3>Ride Cancellation</h3>
        <p>Free • Time Penalty • Premium</p>
        <a href="cancellation_view.php">Open</a>
      </div>
    </div>
  </div>
</body>
</html>
