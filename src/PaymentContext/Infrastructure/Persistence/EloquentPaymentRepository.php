<?php
namespace src\PaymentContext\Infrastructure\Persistence ;

use App\Models\Payment as ModelsPayment;
use src\PaymentContext\Domain\Entity\Payment;
use src\PaymentContext\Domain\Repositories\PaymentRepositoryInterface;

class EloquentPaymentRepository implements PaymentRepositoryInterface{
    public function save(Payment $payment): ?Payment{
        $paymentModel = ModelsPayment::updateOrCreate(
            ['id' => $payment->getId()],
            [
                'user_id'       => $payment->getUserId(),
                'order_id'      => $payment->getOrderId(),
                'amount'        => $payment->getAmount(),
                'currency'      => $payment->getCurrency(),
                'provider'      => $payment->getProvider(),
                'status'        => $payment->getStatus()->value,
                'transaction_id'=> $payment->getTransactionId(),
            ]
        );
        return Payment::reconstitute($paymentModel->toArray());
    }
    public function getById(int $id): ?Payment
    {
        $paymentModel = ModelsPayment::where('id' , $id)->first();
        return $paymentModel ? Payment::reconstitute($paymentModel->toArray()) : null ;
    }
    public function getByTransactionId(string $transaction_id): ?Payment{
        $paymentModel = ModelsPayment::where('transaction_id' , $transaction_id)->first();
        return $paymentModel ? Payment::reconstitute($paymentModel->toArray()) : null ;
    }
}
