<?php
require_once 'RatingStrategyInterface.php';
class WeightedRecentRatings implements RatingStrategyInterface {
    public function calculate(array $ratings): float {
        $weights = range(1, count($ratings));
        $weightedSum = 0;
        $totalWeight = 0;
        foreach ($ratings as $index => $rating) {
            $weight = $weights[$index];
            $weightedSum += $rating * $weight;
            $totalWeight += $weight;
        }
        return $weightedSum / $totalWeight;
    }
}
?>