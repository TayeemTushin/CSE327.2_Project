<!DOCTYPE html>
<html>
<head>
    <title>Route Optimization</title>
    <style>
        #map {
            height: 500px;
            width: 100%;
            margin-top: 10px;
        }
        .controls {
            margin-bottom: 10px;
        }
        .controls select, .controls button {
            margin: 5px 0;
            padding: 5px;
        }
        .summary {
            margin-top: 10px;
            padding: 10px;
            background-color: #e2e2e2;
            display: none;
        }
    </style>
</head>
<body>

<h2>Route Optimization</h2>

<div class="controls">
    <label>Pickup Location:</label><br>
    <select id="pickup">
        <option value="">Select Pickup Area</option>
        <option value="Uttara, Dhaka">Uttara</option>
        <option value="Mirpur, Dhaka">Mirpur</option>
        <option value="Dhanmondi, Dhaka">Dhanmondi</option>
        <option value="Banani, Dhaka">Banani</option>
        <option value="Gulshan, Dhaka">Gulshan</option>
        <option value="Mohakhali, Dhaka">Mohakhali</option>
    </select><br>

    <label>Destination Location:</label><br>
    <select id="destination">
        <option value="">Select Destination Area</option>
        <option value="Uttara, Dhaka">Uttara</option>
        <option value="Mirpur, Dhaka">Mirpur</option>
        <option value="Dhanmondi, Dhaka">Dhanmondi</option>
        <option value="Mohakhali, Dhaka">Mohakhali</option>
        <option value="Banani, Dhaka">Banani</option>
        <option value="Gulshan, Dhaka">Gulshan</option>
    </select><br>

    <button onclick="calculateAndDisplayRoute()">Show Best Route</button><br>
    <p id="distance"></p>

    <button onclick="confirmRide()" id="confirmBtn" style="display:none;">Confirm Ride</button>
    <button onclick="cancelRide()" id="cancelBtn" style="display:none;">Cancel Ride</button>
</div>

<div id="map"></div>

<div class="summary" id="summaryBox">
    <h3>Ride Summary</h3>
    <p id="summaryText"></p>
</div>

<script>
    let map, directionsService, directionsRenderer;
    let rideDetails = {};

    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: 23.8103, lng: 90.4125 },
            zoom: 12
        });

        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer();
        directionsRenderer.setMap(map);
    }

    function calculateAndDisplayRoute() {
        const pickup = document.getElementById("pickup").value;
        const destination = document.getElementById("destination").value;

        if (!pickup || !destination) {
            alert("Please select both Pickup and Destination areas.");
            return;
        }

        directionsService.route(
            {
                origin: pickup,
                destination: destination,
                travelMode: google.maps.TravelMode.DRIVING
            },
            (response, status) => {
                if (status === "OK") {
                    directionsRenderer.setDirections(response);
                    const route = response.routes[0].legs[0];
                    const distanceText = route.distance.text;
                    const distanceInKm = route.distance.value / 1000;
                    const fare = distanceInKm * 50;

                    document.getElementById("distance").innerHTML = 
                        `Distance: ${distanceText} <br> Fare: ${fare.toFixed(2)} BDT`;

                    document.getElementById("confirmBtn").style.display = "inline-block";
                    document.getElementById("cancelBtn").style.display = "inline-block";

                    // Store details for confirmation
                    rideDetails = {
                        pickup: pickup,
                        destination: destination,
                        distance: distanceText,
                        fare: fare.toFixed(2)
                    };
                } else {
                    alert("Directions request failed due to: " + status);
                }
            }
        );
    }

    function confirmRide() {
        const summary = `
            Pickup: ${rideDetails.pickup} <br>
            Destination: ${rideDetails.destination} <br>
            Distance: ${rideDetails.distance} <br>
            Fare: ${rideDetails.fare} BDT
        `;
        document.getElementById("summaryText").innerHTML = summary;
        document.getElementById("summaryBox").style.display = "block";
    }

    function cancelRide() {
        // Reset all
        document.getElementById("pickup").selectedIndex = 0;
        document.getElementById("destination").selectedIndex = 0;
        document.getElementById("distance").innerHTML = "";
        document.getElementById("confirmBtn").style.display = "none";
        document.getElementById("cancelBtn").style.display = "none";
        document.getElementById("summaryBox").style.display = "none";
        directionsRenderer.set('directions', null);
        rideDetails = {};
    }
</script>



<!-- Google Maps API with your working key -->
<script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAaqd4FYuuJC9SsKGiTZCuB6HSW_6yNY5I=places&callback=initMap">
</script>

<br><br>

</body>
</html>




<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pickup = $_POST['pickup'];
    $destination = $_POST['destination'];

    // Assume distance comes from Google Maps API
    // Here we use a dummy value for testing
    $distance = rand(2, 15); // Example: random distance 2–15 km
    $fare_per_km = 50;
    $fare = $distance * $fare_per_km;

    // Generate new ride number only when a new calculation is done
    if (!isset($_SESSION['last_ride_number'])) {
        $_SESSION['last_ride_number'] = 1000; // starting ride number
    }
    $_SESSION['last_ride_number']++;
    $_SESSION['ride_number'] = $_SESSION['last_ride_number'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Route Optimization</title>
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
        }
        h2 {
            color: #333;
            text-align: center;
        }
        .result {
            margin: 20px 0;
            font-size: 18px;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Route Optimization Result</h2>

    <?php if (isset($fare)): ?>
        <div class="result">
            <p><strong>Ride Number:</strong> <?php echo $_SESSION['ride_number']; ?></p>
            <p><strong>Pickup:</strong> <?php echo htmlspecialchars($pickup); ?></p>
            <p><strong>Destination:</strong> <?php echo htmlspecialchars($destination); ?></p>
            <p><strong>Optimized Distance:</strong> <?php echo $distance; ?> km</p>
            <p><strong>Estimated Fare:</strong> <?php echo $fare; ?> BDT</p>
        </div>

        <!-- Direct link to fare view -->
        <a href="cancellation_view.php" style="display:inline-block; background:#007bff; color:white; padding:10px 20px; border-radius:5px; text-decoration:none;">Proceed to Confirmation</a>
    <?php else: ?>
        <p>No route calculated. Please go back and enter trip details.</p>
    <?php endif; ?>
</div>

</body>
</html>

