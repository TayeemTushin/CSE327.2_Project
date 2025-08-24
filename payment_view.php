<!DOCTYPE html>
<html>
<head>
    <title>Payment Option</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }
        .container {
            background: #fff;
            padding: 25px;
            max-width: 600px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0px 0px 10px #ccc;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .info {
            margin-top: 20px;
            font-size: 18px;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .note {
            margin-top: 15px;
            color: #777;
            text-align: center;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Select Payment Method</h2>
        <div class="info">
            <p><strong>Available Payment Option:</strong></p>
            <ul>
                <li>Cash (only option available)</li>
            </ul>
            <form method="post" action="">
                <input type="hidden" name="payment_method" value="Cash">
                <button type="submit" class="btn">Confirm Payment</button>
            </form>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $payment_method = $_POST['payment_method'];
                    echo "<p class='info'><strong>Payment Method Selected:</strong> " . htmlspecialchars($payment_method) . "</p>";
                    echo "<p class='note'>Please pay your driver with cash after the ride is complete.</p>";
                }
            ?>
        </div>
    </div>
</body>
</html>
