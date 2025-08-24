<?php
session_start();

// Generate ride number only if not already set for this session ride
if (!isset($_SESSION['ride_number'])) {
    // If there's a last ride stored, increment it, otherwise start from 1001
    $_SESSION['ride_number'] = isset($_SESSION['last_ride_number']) 
        ? $_SESSION['last_ride_number'] + 1 
        : 1001;

    // Save this as the latest ride
    $_SESSION['last_ride_number'] = $_SESSION['ride_number'];
}

$rideNumber = $_SESSION['ride_number'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ride Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        h2 {
            color: #333;
        }
        .ride-number {
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
            margin: 10px 0;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            border-radius: 5px;
            font-size: 16px;
            color: white;
            text-decoration: none;
        }
        .btn-confirm {
            background-color: #28a745;
        }
        .btn-cancel {
            background-color: #dc3545;
        }
        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Ride Confirmation</h2>
    <div class="ride-number">Ride Number: <?php echo $rideNumber; ?></div>

    <p>Do you want to confirm or cancel this ride?</p>

    <a href="payment_view.php" class="btn btn-confirm">Confirm Ride</a>
    <a href="cancel_ride.php" class="btn btn-cancel">Cancel Ride</a>
</div>

</body>
</html>
