<?php
require_once 'RouteStrategyInterface.php';
class ShortestRoute implements RouteStrategyInterface {
    public function getRoute(string $start, string $end): string {
        return "📏 Shortest route from $start to $end via local roads.";
    }
}
?>