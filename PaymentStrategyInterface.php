<?php
interface PaymentStrategyInterface {
    public function pay(float $amount): string;
}
?>