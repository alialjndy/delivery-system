<?php
namespace src\PaymentContext\Application\Actions ;

use Event;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use src\PaymentContext\Application\DTOs\PaymentReadModel;
use src\PaymentContext\Domain\Repositories\PaymentRepositoryInterface;
use src\PaymentContext\Infrastructure\Persistence\StripeWebhookProcessor;

class HandlePaymentWebhook{
    private $events = [] ;
    public function __construct(
        private StripeWebhookProcessor $stripeWebhookProcessor,
        private PaymentRepositoryInterface $paymentRepositoryInterface,
    ){}
    public function execute($signature , $payload , $secret){

        // Delegate technical validation (signature verification) and parsing.
        $result = $this->stripeWebhookProcessor->handle($signature , $payload , $secret);

        DB::transaction(function() use ($result){

            // Fetch the Domain Entity using the transaction ID provided by Stripe.
            $payment = $this->paymentRepositoryInterface->getByTransactionId($result['transaction_id']);

            if(!$payment) { throw new ModelNotFoundException(); }

            // We delegate the actual state transition to the Entity itself to ensure encapsulation.
            switch ($result['type']) {

                //
                case 'payment_intent.succeeded':
                    $payment->markAsSuccessful();

                    #TODO إطلاق حدث ما من أجل تفعيل خدمة إرسال الإشعارات إلى السائقين
                    break ;

                //
                case 'payment_intent.payment_failed':
                    $payment->markAsFailed();
                    break ;

                default:
                    return ;

            }

            // Save the updated Entity state back to the database.
            $updatedPayment = $this->paymentRepositoryInterface->save($payment);

            $this->events = $payment->pullEvents();

            // هنا يمكن أن نستغني عن هذا الجزء أي يتم الحفظ من دون أن نعرض أي شيء للمستخدم أو أن يتم إرسال أي ريسبونس للفرونت
            // return new PaymentReadModel(
            //     $updatedPayment->getId(),
            //     $updatedPayment->getUserId(),
            //     $updatedPayment->getOrderId(),
            //     $updatedPayment->getAmount(),
            //     $updatedPayment->getCurrency(),
            //     $updatedPayment->getProvider(),
            //     $updatedPayment->getStatus()->value,
            //     $updatedPayment->getTransactionId(),
            // );
        });
        foreach($this->events as $event){
            event($event);
        }
    }
}
