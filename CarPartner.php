<?php
require_once 'RidePartner.php';

class CarPartner implements RidePartner {
    public function getDetails() {
        return "Car Partner: Toyota Corolla, AC, Comfortable seats, GPS navigation";
    }
    
    public function getVehicleType() {
        return "Car";
    }
    
    public function getCapacity() {
        return "4 passengers";
    }
    
    public function getEstimatedFare($distance = 5) {
        // Car fare: Base fare 80 BDT + 15 BDT per km
        $baseFare = 80;
        $perKmRate = 15;
        return $baseFare + ($distance * $perKmRate);
    }
}
?>