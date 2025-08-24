<?php
require_once 'FareStrategyInterface.php';
class SharedRideFare implements FareStrategyInterface {
    public function calculateFare(float $distance): float {
        return 2 + ($distance * 6);
    }
}
?>