<?php
require_once 'RatingStrategyInterface.php';
class CustomFeedbackScore implements RatingStrategyInterface {
    public function calculate(array $ratings): float {
        $adjusted = array_map(function ($r) {
            return $r < 3 ? $r - 0.5 : $r;
        }, $ratings);
        return array_sum($adjusted) / count($adjusted);
    }
}
?>