<!DOCTYPE html>
<html>
<head>
    <title>Driver Rating</title>
</head>
<body>
    <h2>Rate Your Driver</h2>
    <form method="post">
        <label for="driver_name">Driver Name:</label>
        <input type="text" name="driver_name" required><br><br>

        <label for="rating">Rating (1 to 5):</label>
        <input type="number" name="rating" min="1" max="5" required><br><br>

        <input type="submit" name="submit" value="Submit Rating">
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $driver = htmlspecialchars($_POST['driver_name']);
        $rating = intval($_POST['rating']);
        echo "<p>Thanks for rating $driver with $rating star(s)!</p>";

        // (Optional) save to DB or file
        // file_put_contents("ratings.txt", "$driver:$rating\n", FILE_APPEND);
    }
    ?>
</body>
</html>
