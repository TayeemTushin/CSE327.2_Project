<?php
interface RouteStrategyInterface {
    public function getRoute(string $start, string $end): string;
}
?>