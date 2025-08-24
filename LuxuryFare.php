<?php
require_once 'FareStrategyInterface.php';
class LuxuryFare implements FareStrategyInterface {
    public function calculateFare(float $distance): float {
        return 20 + ($distance * 25);
    }
}
?>