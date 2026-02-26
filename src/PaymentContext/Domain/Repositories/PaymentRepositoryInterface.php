<?php
namespace src\PaymentContext\Domain\Repositories ;

use src\PaymentContext\Domain\Entity\Payment;

interface PaymentRepositoryInterface{
    public function save(Payment $payment): ?Payment;
    public function getById(int $id): ?Payment ;
    public function getByTransactionId(string $transaction_id) : ?Payment ;
}
