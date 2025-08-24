<?php
require_once 'CancellationStrategyInterface.php';
class TimeBasedPenalty implements CancellationStrategyInterface {
    public function getCancellationMessage(int $minutesBeforeStart): string {
        if ($minutesBeforeStart < 10) {
            return "⚠️ ₹50 cancellation fee applied (within 10 minutes of start).";
        }
        return "✅ Ride cancelled successfully. No charges applied.";
    }
}
?>