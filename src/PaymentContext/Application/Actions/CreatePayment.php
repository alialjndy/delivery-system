<?php
namespace src\PaymentContext\Application\Actions ;

use Exception;
use Illuminate\Support\Facades\Log;
use src\PaymentContext\Application\Contracts\PaymentFactoryInterface;
use src\PaymentContext\Application\DTOs\PaymentReadModel;
use src\PaymentContext\Domain\Entity\Payment as PaymentEntity ;
use src\PaymentContext\Domain\Repositories\PaymentRepositoryInterface;
use src\Shared\Domain\ValueObjects\Money;

class CreatePayment{
    public function __construct(
        private PaymentRepositoryInterface $paymentRepositoryInterface ,
        private PaymentFactoryInterface $paymentFactoryInterface,
    ){}
    public function execute(array $data){
        try{
            // Initialize the Domain Entity using the Static Factory method.
            // At this stage, the transaction_id is typically null as the process hasn't started externally.
            $paymentEntity = PaymentEntity::create(
                $data['order_id'],
                $data['user_id'],
                new Money($data['amount']),
                $data['provider'],
                $data['transaction_id'] ?? null ,
            );


            $paymentProvider = $this->paymentFactoryInterface->make($data['provider']);

            // This interacts with Stripe/PayPal APIs to generate a PaymentIntent or Order.
            $paymentGateWayInfo = $paymentProvider->pay($paymentEntity);

            // This ensures our system is synced with the external transaction.
            $paymentEntity->markAsInitiatedExternally($paymentGateWayInfo['payment_intent_id']);

            $savedPayment = $this->paymentRepositoryInterface->save($paymentEntity);

            $paymentEntityInfo =  new PaymentReadModel(
                $savedPayment->getId(),
                $savedPayment->getUserId(),
                $savedPayment->getOrderId(),
                $savedPayment->getAmount(),
                $savedPayment->getCurrency(),
                $savedPayment->getProvider(),
                $savedPayment->getStatus()->value,
                $savedPayment->getTransactionId(),
            );
            return [
                'payment_entity_info' => $paymentEntityInfo ,
                'payment_gateway_info'=> $paymentGateWayInfo ,
            ];
        }catch(Exception $e){
            Log::error('Error When create payment record and pay '.$e->getMessage());
            throw $e;
        }
    }
}
