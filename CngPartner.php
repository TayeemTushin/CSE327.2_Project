<?php
require_once 'RidePartner.php';

class CngPartner implements RidePartner {
    public function getDetails() {
        return "CNG Partner: Auto Rickshaw, Economical choice, Local routes";
    }
    
    public function getVehicleType() {
        return "CNG Auto";
    }
    
    public function getCapacity() {
        return "3 passengers";
    }
    
    public function getEstimatedFare($distance = 5) {
        // CNG fare: Base fare 30 BDT + 8 BDT per km
        $baseFare = 30;
        $perKmRate = 8;
        return $baseFare + ($distance * $perKmRate);
    }
}
?>