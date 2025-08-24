<?php
require_once 'CancellationStrategyInterface.php';
class FreeCancellation implements CancellationStrategyInterface {
    public function getCancellationMessage(int $minutesBeforeStart): string {
        return "✅ Ride cancelled successfully. No charges applied.";
    }
}
?>