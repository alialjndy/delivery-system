<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use src\PaymentContext\Application\Actions\HandlePaymentWebhook;

class StripeWebhookController extends Controller
{
    public function __construct(
        protected HandlePaymentWebhook $handlePaymentWebhook,
    ){}
    public function handleWebhook(Request $request){
        $signatue = $request->header('Stripe_Signature');
        $payload = $request->getContent();
        $secret = config('services.stripe.webhook');

        $this->handlePaymentWebhook->execute($signatue , $payload , $secret);

        Log::info("payment changed successfully");
    }
}
