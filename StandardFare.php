<?php
require_once 'FareStrategyInterface.php';
class StandardFare implements FareStrategyInterface {
    public function calculateFare(float $distance): float {
        return 5 + ($distance * 10);
    }
}
?>