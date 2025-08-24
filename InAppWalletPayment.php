<?php
require_once 'PaymentStrategyInterface.php';
class InAppWalletPayment implements PaymentStrategyInterface {
    public function pay(float $amount): string {
        return "📱 Paid ₹" . number_format($amount, 2) . " using In-App Wallet.";
    }
}
?>