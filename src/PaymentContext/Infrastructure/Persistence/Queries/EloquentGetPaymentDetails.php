<?php
namespace src\PaymentContext\Infrastructure\Persistence\Queries ;

use App\Models\Payment as PaymentModel;
use Exception;
use src\PaymentContext\Application\DTOs\PaymentReadModel;
use src\PaymentContext\Application\Queries\GetPaymentDetailsInterface;
class EloquentGetPaymentDetails implements GetPaymentDetailsInterface{
    public function execute(int $paymentId): ?PaymentReadModel{

        // get eloquent row
        $row = PaymentModel::where('id' , $paymentId)->first();

        return new PaymentReadModel(
            $row->id ,
            $row->user_id ,
            $row->order_id ,
            $row->amount,
            $row->currency ,
            $row->provider ,
            $row->status ,
            $row->transaction_id ,
        ) ?? null ;
    }
}

// mighty-tender-poise-safe
