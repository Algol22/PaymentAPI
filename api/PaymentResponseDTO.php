<?php

interface PaymentResponseDTO {
    public function getAction(): string;
    public function getStatus(): string;
    public function getTransactionId(): string;
    public function getTransactionDate(): string;
    public function getAmount(): string;
    public function getCurrency(): string;
}
?>
