<!DOCTYPE html>
<html>
<head>
    <title>Fare Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h2 {
            color: #2c3e50;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        select, input[type="date"], input[type="time"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .button-container {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        button {
            padding: 12px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            flex: 1;
        }
        button:disabled {
            background-color: #95a5a6;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <h2>Fare Calculator premium car </h2>
    
    <div class="form-group">
        <label for="pickup">Pickup Location:</label>
        <select id="pickup">
            <option value="Banani">Banani</option>
            <option value="Dhanmondi">Dhanmondi</option>
            <option value="Mirpur">Mirpur</option>
            <option value="Uttara">Uttara</option>
            <option value="Gulshan">Gulshan</option>
            <option value="Mohakhali">Mohakhali</option>
            <option value="Motijheel">Motijheel</option>
            <option value="Bashundhara">Bashundhara</option>
        </select>
    </div>

    <div class="form-group">
        <label for="destination">Destination:</label>
        <select id="destination">
            <option value="Banani">Banani</option>
            <option value="Dhanmondi">Dhanmondi</option>
            <option value="Mirpur">Mirpur</option>
            <option value="Uttara">Uttara</option>
            <option value="Gulshan">Gulshan</option>
            <option value="Mohakhali">Mohakhali</option>
            <option value="Motijheel">Motijheel</option>
            <option value="Bashundhara">Bashundhara</option>
        </select>
    </div>

    <!-- Date Picker -->
    <div class="form-group">
        <label for="date">Travel Date:</label>
        <input type="date" id="date" required>
    </div>

    <!-- Time Picker -->
    <div class="form-group">
        <label for="time">Travel Time:</label>
        <input type="time" id="time" required>
    </div>

    <div class="button-container">
        <button id="calculate">Calculate Fare</button>
    </div>
    
    <script>
        // Distance chart (in km)
        const distances = {
            "Banani":     { "Dhanmondi":10.2, "Mirpur":14.5, "Uttara":16.8, "Gulshan":2.1, "Mohakhali":2.3, "Motijheel":8.5, "Bashundhara":7.2 },
            "Dhanmondi":  { "Banani":10.2, "Mirpur":9.7, "Uttara":18.2, "Gulshan":8.3, "Mohakhali":6.5, "Motijheel":7.2, "Bashundhara":11.4 },
            "Mirpur":     { "Banani":14.5, "Dhanmondi":9.7, "Uttara":19.3, "Gulshan":14.2, "Mohakhali":12.5, "Motijheel":16.3, "Bashundhara":15.8 },
            "Uttara":     { "Banani":16.8, "Dhanmondi":18.2, "Mirpur":19.3, "Gulshan":16.8, "Mohakhali":15.2, "Motijheel":19.5, "Bashundhara":10.3 },
            "Gulshan":    { "Banani":2.1, "Dhanmondi":8.3, "Mirpur":14.2, "Uttara":16.8, "Mohakhali":3.5, "Motijheel":9.2, "Bashundhara":6.8 },
            "Mohakhali":  { "Banani":2.3, "Dhanmondi":6.5, "Mirpur":12.5, "Uttara":15.2, "Gulshan":3.5, "Motijheel":7.8, "Bashundhara":5.2 },
            "Motijheel":  { "Banani":8.5, "Dhanmondi":7.2, "Mirpur":16.3, "Uttara":19.5, "Gulshan":9.2, "Mohakhali":7.8, "Bashundhara":12.7 },
            "Bashundhara":{ "Banani":7.2, "Dhanmondi":11.4, "Mirpur":15.8, "Uttara":10.3, "Gulshan":6.8, "Mohakhali":5.2, "Motijheel":12.7 }
        };

        document.getElementById("calculate").addEventListener("click", () => {
            const pickup = document.getElementById("pickup").value;
            const destination = document.getElementById("destination").value;
            const date = document.getElementById("date").value;
            const time = document.getElementById("time").value;

            if (pickup === destination) {
                alert("Pickup and destination cannot be the same.");
                return;
            }

            if (!date) {
                alert("Please select a travel date.");
                return;
            }

            if (!time) {
                alert("Please select a travel time.");
                return;
            }

            const distance = distances[pickup]?.[destination] || distances[destination]?.[pickup];

            if (!distance) {
                alert("Distance not available for this route.");
                return;
            }

            const fare = distance * 50;

            // Redirect with results + date + time
            window.location.href = `fare_calculation.php?pickup=${encodeURIComponent(pickup)}&destination=${encodeURIComponent(destination)}&date=${encodeURIComponent(date)}&time=${encodeURIComponent(time)}&distance=${distance.toFixed(2)}&fare=${fare.toFixed(2)}`;
        });
    </script>
</body>
</html>
