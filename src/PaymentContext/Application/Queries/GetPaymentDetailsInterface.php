<?php
namespace src\PaymentContext\Application\Queries ;

use src\PaymentContext\Application\DTOs\PaymentReadModel;

interface GetPaymentDetailsInterface{
    public function execute(int $paymentId) : ?PaymentReadModel ;
}
