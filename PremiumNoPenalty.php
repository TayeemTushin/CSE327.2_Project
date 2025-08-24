<?php
require_once 'CancellationStrategyInterface.php';
class PremiumNoPenalty implements CancellationStrategyInterface {
    public function getCancellationMessage(int $minutesBeforeStart): string {
        return "🌟 Premium user: Ride cancelled successfully. No charges.";
    }
}
?>