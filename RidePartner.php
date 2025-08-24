<?php
interface RidePartner {
    public function getDetails();
    public function getVehicleType();
    public function getCapacity();
    public function getEstimatedFare($distance = 5);
}
?>