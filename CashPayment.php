<?php
require_once 'PaymentStrategyInterface.php';
class CashPayment implements PaymentStrategyInterface {
    public function pay(float $amount): string {
        return "💵 Paid ₹" . number_format($amount, 2) . " in Cash.";
    }
}
?>