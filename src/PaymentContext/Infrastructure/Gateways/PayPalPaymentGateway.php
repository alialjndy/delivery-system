<?php
namespace src\PaymentContext\Infrastructure\Gateways ;

use src\PaymentContext\Domain\Contracts\PaymentGateway;
use src\Shared\Domain\ValueObjects\Money;

class PayPalPaymentGateway implements PaymentGateway{
    public function pay(Money $money): string
    {
        throw new \Exception('Not implemented');
    }
}
