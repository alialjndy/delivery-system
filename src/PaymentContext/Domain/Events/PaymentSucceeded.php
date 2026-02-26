<?php
namespace src\PaymentContext\Domain\Events ;
class PaymentSucceeded{
    public function __construct(
        public readonly int $order_id ,
    ){}
}
