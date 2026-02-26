<?php
namespace src\Shared\Domain\Events;
class OrderDeliveredEvent{
    public function __construct(
        public readonly int $orderId,
        public readonly int $driverId,
        public readonly ?float $amount,
    ){}
}
