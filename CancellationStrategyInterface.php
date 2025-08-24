<?php
interface CancellationStrategyInterface {
    public function getCancellationMessage(int $minutesBeforeStart): string;
}
?>