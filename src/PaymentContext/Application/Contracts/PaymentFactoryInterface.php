<?php
namespace src\PaymentContext\Application\Contracts;

use src\PaymentContext\Domain\Contracts\PaymentGateway;

interface PaymentFactoryInterface{
    public function make(string $paymentProvider): PaymentGateway;
}
