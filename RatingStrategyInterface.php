<?php
interface RatingStrategyInterface {
    public function calculate(array $ratings): float;
}
?>