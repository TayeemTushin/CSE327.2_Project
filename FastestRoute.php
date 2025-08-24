<?php
require_once 'RouteStrategyInterface.php';
class FastestRoute implements RouteStrategyInterface {
    public function getRoute(string $start, string $end): string {
        return "🚀 Fastest route from $start to $end via highway.";
    }
}
?>