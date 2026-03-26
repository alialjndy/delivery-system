<?php
namespace src\PaymentContext\Infrastructure\Factories ;

use src\PaymentContext\Application\Contracts\PaymentFactoryInterface;
use src\PaymentContext\Domain\Contracts\PaymentGateway;
use src\PaymentContext\Infrastructure\Gateways\PayPalPaymentGateway;
use src\PaymentContext\Infrastructure\Gateways\StripePaymentGateway;

class PaymentFactory implements PaymentFactoryInterface{
    public function make(string $paymentProvider): PaymentGateway{
        return match($paymentProvider){
            'stripe' => app(StripePaymentGateway::class),
            'paypal' => app(PayPalPaymentGateway::class),
            default  => throw new \Exception("Unsupported Gateway"),
        };
    }
}
