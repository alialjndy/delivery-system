<?php
namespace src\PaymentContext\Infrastructure\Persistence ;

use Exception;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use UnexpectedValueException;

class StripeWebhookProcessor{
    public function handle($signature , $payload , $secret){
        try{

            // Comment this line when you need to test stripe in postman.
            // $event = Webhook::constructEvent($payload , $signature , $secret);

            // un comment this line when you need to test stripe with postman.
            $event = json_decode($payload);


            $type = $event->type ;
            $transaction_id = $event->data->object->id ;

            return [
                'type' => $type ,
                'transaction_id' => $transaction_id ,
            ];

        //
        }catch(SignatureVerificationException $e){
            Log::error("Stripe Webhook Signature Verification Failed: " . $e->getMessage());
            abort(400 , 'Invalid Singature');

        //
        }catch(UnexpectedValueException $e){
            Log::error("Stripe Webhook Invalid Payload: " . $e->getMessage());
            abort(400 , 'Invalid Payload');

        //
        }catch(Exception $e){
            Log::error("Stripe Webhook Error: " . $e->getMessage());
            abort(500);
        }
    }
}
