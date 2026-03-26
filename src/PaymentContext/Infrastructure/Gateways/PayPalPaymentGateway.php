<?php
namespace src\PaymentContext\Infrastructure\Gateways ;

use src\PaymentContext\Domain\Contracts\PaymentGateway;
use src\PaymentContext\Domain\Entity\Payment;

class PayPalPaymentGateway implements PaymentGateway{
    public function pay(Payment $payment): array
    {
        throw new \Exception('Sorry! , This feature is not yet activated. Unable to retrieve credentials.');
    }
}
