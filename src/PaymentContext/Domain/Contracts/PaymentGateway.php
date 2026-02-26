<?php
namespace src\PaymentContext\Domain\Contracts ;

use src\PaymentContext\Domain\Entity\Payment;
use src\Shared\Domain\ValueObjects\Money;

interface PaymentGateway{
    public function pay(Payment $payment) : array;
}
