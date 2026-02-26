<?php
namespace src\PaymentContext\Application\DTOs ;
class PaymentFilter{
    public function __construct(
        public readonly ?int $userId ,
        public readonly ?string $status ,
        public readonly ?string $provider ,
        public readonly ?float $min_amount,
        public readonly ?float $max_amount,
    ){}
}
