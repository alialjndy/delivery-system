<?php
namespace src\OrderContext\Application\Listeners ;

use src\OrderContext\Application\Actions\UpdateOrderStatus;
use src\PaymentContext\Domain\Events\PaymentSucceeded;

class UpdateOrderOnPaymentSuccess{
    public function __construct(
        private UpdateOrderStatus $updateOrderStatus ,
    ){}
    public function handle(PaymentSucceeded $event){
        $this->updateOrderStatus->execute($event->order_id);
    }
}
