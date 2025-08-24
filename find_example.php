<?php
require_once 'RidePartnerFactory.php';
?>
<form action="" method="post">
    <label>Select Vehicle Type:</label>
    <select name="vehicle_type">
        <option value="car">Car</option>
        <option value="bike">Bike</option>
        <option value="cng">CNG</option>
    </select>
    <input type="submit" value="Find Partner">
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicleType = $_POST['vehicle_type'];
    $factory = new RidePartnerFactory();
    $partner = $factory->getPartner($vehicleType);
    if ($partner) {
        echo "<p>" . $partner->getDetails() . "</p>";
    } else {
        echo "<p>No partner found for the selected vehicle type.</p>";
    }
}
?>