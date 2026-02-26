<?php
namespace src\PaymentContext\Application\DTOs ;
class PaymentReadModel{
    public function __construct(
        public int $id ,
        public int $userId ,
        public int $orderId ,
        public float $amount ,
        public string $currency ,
        public string $provider ,
        public string $status ,
        public string $transactionId,
    ){}
}
