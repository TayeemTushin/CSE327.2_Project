<?php
require_once 'RatingStrategyInterface.php';
class AverageRating implements RatingStrategyInterface {
    public function calculate(array $ratings): float {
        return array_sum($ratings) / count($ratings);
    }
}
?>