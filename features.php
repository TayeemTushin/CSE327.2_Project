<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Strategy Features</title>
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
    <p>Select a feature to try it out.</p>
    <div class="grid">
      <div class="card"><h3>Fare Calculator</h3><p>Switch algorithms by ride type.</p><a href="strategies/fare/fare_view.php">Open</a></div>
      <div class="card"><h3>Route Optimization</h3><p>Shortest / Fastest / Scenic routes.</p><a href="strategies/route/route_view.php">Open</a></div>
      <div class="card"><h3>Payment Method</h3><p>Credit / Cash / In‑App Wallet.</p><a href="strategies/payment/payment_view.php">Open</a></div>
      <div class="card"><h3>Driver Rating</h3><p>Average / Weighted / Custom.</p><a href="strategies/rating/rating_view.php">Open</a></div>
      <div class="card"><h3>Ride Cancellation</h3><p>Free / Time penalty / Premium.</p><a href="strategies/cancellation/cancellation_view.php">Open</a></div>
    </div>
  </div>
</body>
</html>