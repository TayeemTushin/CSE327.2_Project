<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
}

// Include the Factory Pattern files
require_once 'RidePartnerFactory.php';
// Include your existing fare strategies
require_once 'StandardFare.php';
require_once 'SharedRideFare.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Find Ride Partner</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(90deg, #e2e2e2, #982dea);
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            text-align: center;
            color: #982dea;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        select, input[type="submit"], input[type="number"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #eee;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        select:focus, input:focus {
            border-color: #982dea;
            outline: none;
        }
        
        input[type="submit"] {
            background: #982dea;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: 600;
            margin-top: 10px;
        }
        
        input[type="submit"]:hover {
            background: #7a1fc2;
        }
        
        .result {
            margin-top: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #982dea;
        }
        
        .no-result {
            color: #dc3545;
            border-left-color: #dc3545;
        }
        
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        
        .back-btn:hover {
            background: #5a6268;
        }
        
        .partner-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(152, 45, 234, 0.1);
            margin-top: 15px;
            border: 1px solid #eee;
        }
        
        .vehicle-icon {
            font-size: 24px;
            margin-right: 10px;
            color: #982dea;
        }
        
        .fare-info {
            background: #e8f5e8;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            border-left: 4px solid #28a745;
        }
        
        .confirm-btn {
            background: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            text-decoration: none;
            display: inline-block;
        }
        
        .confirm-btn:hover {
            background: #218838;
        }
        
        .two-column {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        @media (max-width: 600px) {
            .two-column {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class='bx bx-car'></i> Find a Suitable Ride Partner</h1>
        
        <form action="" method="post">
            <div class="form-group">
                <label for="vehicle_type">
                    <i class='bx bx-transfer-alt'></i> Select Vehicle Type:
                </label>
                <select name="vehicle_type" id="vehicle_type" required>
                    <option value="">Choose your preferred vehicle...</option>
                    <option value="car">🚗 Car - Comfortable & Spacious</option>
                    <option value="cng">🛺 CNG Auto - Economical</option>
                </select>
            </div>
            
            <div class="two-column">
                <div class="form-group">
                    <label for="pickup_area">
                        <i class='bx bx-map-pin'></i> Pickup Area:
                    </label>
                    <select name="pickup_area" id="pickup_area" required>
                        <option value="">Select pickup location...</option>
                        <option value="Uttara">Uttara</option>
                        <option value="Mirpur">Mirpur</option>
                        <option value="Dhanmondi">Dhanmondi</option>
                        <option value="Banani">Banani</option>
                        <option value="Gulshan">Gulshan</option>
                        <option value="Mohakhali">Mohakhali</option>
                        <option value="Bashundhara">Bashundhara</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="destination_area">
                        <i class='bx bx-map'></i> Destination Area:
                    </label>
                    <select name="destination_area" id="destination_area" required>
                        <option value="">Select destination...</option>
                        <option value="Motijheel">Motijheel</option>
                        <option value="Mohakhali">Mohakhali</option>
                        <option value="Gulshan">Gulshan</option>
                        <option value="Bashundhara">Bashundhara</option>
                        <option value="Uttara">Uttara</option>
                        <option value="Mirpur">Mirpur</option>
                        <option value="Dhanmondi">Dhanmondi</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="distance">
                    <i class='bx bx-ruler'></i> Estimated Distance (km):
                </label>
                <input type="number" name="distance" id="distance" value="5" min="1" max="50" required>
                <small style="color: #666;">Default: 5 km (adjust based on your route)</small>
            </div>
            
            <input type="submit" value="🔍 Find Partner & Calculate Fare">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $vehicleType = $_POST['vehicle_type'];
            $pickupArea = $_POST['pickup_area'];
            $destinationArea = $_POST['destination_area'];
            $distance = floatval($_POST['distance']);
            
            // Use Factory Pattern to get partner
            $factory = new RidePartnerFactory();
            $partner = $factory->getPartner($vehicleType);
            
            if ($partner && !empty($pickupArea) && !empty($destinationArea)) {
                echo '<div class="result">';
                echo '<h3><i class="bx bx-check-circle vehicle-icon"></i>Partner Found!</h3>';
                echo '<div class="partner-card">';
                echo '<h4>Vehicle Details</h4>';
                echo '<p><strong>Type:</strong> ' . $partner->getVehicleType() . '</p>';
                echo '<p><strong>Details:</strong> ' . $partner->getDetails() . '</p>';
                echo '<p><strong>Capacity:</strong> ' . $partner->getCapacity() . '</p>';
                echo '<p><strong>Route:</strong> ' . htmlspecialchars($pickupArea) . ' → ' . htmlspecialchars($destinationArea) . '</p>';
                echo '<p><strong>Distance:</strong> ' . $distance . ' km</p>';
                echo '<p><strong>Status:</strong> <span style="color: #28a745;">Available Now</span></p>';
                echo '<p><strong>Estimated Time:</strong> ' . ceil($distance * 3) . '-' . ceil($distance * 4) . ' minutes</p>';
                
                // Calculate fare using both factory pattern and strategy pattern
                $partnerFare = $partner->getEstimatedFare($distance);
                
                // Also calculate using your existing strategy patterns for comparison
                $standardFare = new StandardFare();
                $sharedFare = new SharedRideFare();
                $standardAmount = $standardFare->calculateFare($distance);
                $sharedAmount = $sharedFare->calculateFare($distance);
                
                echo '<div class="fare-info">';
                echo '<h4><i class="bx bx-money"></i> Fare Information</h4>';
                echo '<p><strong>Partner Estimated Fare:</strong> ৳' . $partnerFare . '</p>';
                echo '<p><strong>Standard Rate:</strong> ৳' . $standardAmount . '</p>';
                echo '<p><strong>Shared Ride Rate:</strong> ৳' . $sharedAmount . '</p>';
                echo '<p style="color: #28a745;"><strong>Recommended:</strong> ৳' . min($partnerFare, $standardAmount, $sharedAmount) . ' (Best Deal)</p>';
                echo '</div>';
                
                // Generate a simple ride ID for demonstration
                $rideId = 'RID' . date('Ymd') . rand(1000, 9999);
                echo '<p><strong>Ride ID:</strong> ' . $rideId . '</p>';
                
                // Store ride details in session for next steps
                $_SESSION['current_ride'] = [
                    'ride_id' => $rideId,
                    'vehicle_type' => $vehicleType,
                    'pickup' => $pickupArea,
                    'destination' => $destinationArea,
                    'distance' => $distance,
                    'fare' => min($partnerFare, $standardAmount, $sharedAmount)
                ];
                
                echo '<a href="cancellation_view.php" class="confirm-btn">Proceed to Book Ride</a>';
                echo '</div>';
                echo '</div>';
            } else {
                echo '<div class="result no-result">';
                echo '<h3><i class="bx bx-x-circle vehicle-icon"></i>No Partner Found</h3>';
                echo '<p>Sorry, no partner available for the selected vehicle type and route at the moment.</p>';
                echo '<p>Please try again later or select a different vehicle type.</p>';
                echo '</div>';
            }
        }
        ?>
        
        <a href="dashboard.php" class="back-btn">
            <i class='bx bx-arrow-back'></i> Back to Dashboard
        </a>
    </div>
</body>
</html>