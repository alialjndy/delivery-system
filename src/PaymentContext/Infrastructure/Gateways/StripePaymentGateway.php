<?php
namespace src\PaymentContext\Infrastructure\Gateways ;

use Exception;
use src\PaymentContext\Domain\Contracts\PaymentGateway;
use src\PaymentContext\Domain\Entity\Payment;
use src\Shared\Domain\ValueObjects\Money;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripePaymentGateway implements PaymentGateway{
    public function pay(Payment $payment): array
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $paymentIntent = PaymentIntent::create([
            'amount' => $payment->getAmount() * 100 , // convert to cint
            'currency' => $payment->getCurrency(),
            'capture_method' => 'automatic',
            'metadata' => [
                'user_id' => $payment->getUserId(),
                'order_id' => $payment->getOrderId(),
            ],
        ]);
        return [
            'payment_intent_id' => $paymentIntent->id ,
            'client_secret' => $paymentIntent->client_secret ,
            'status' => $paymentIntent->status ,
        ];
    }
}
