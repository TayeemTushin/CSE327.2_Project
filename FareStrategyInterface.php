<?php
interface FareStrategyInterface {
    public function calculateFare(float $distance): float;
}
?>