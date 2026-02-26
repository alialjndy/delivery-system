<?php
namespace src\Shared\Domain\Events;
class OrderAcceptedEvent{
    public function __construct(
        public readonly int $orderId,
        public readonly int $driverId,
        public readonly ?float $amount,
    ){}
}
