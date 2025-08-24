<?php
require_once 'RouteStrategyInterface.php';
class ScenicRoute implements RouteStrategyInterface {
    public function getRoute(string $start, string $end): string {
        return "🌄 Scenic route from $start to $end via nature trails and scenic roads.";
    }
}
?>