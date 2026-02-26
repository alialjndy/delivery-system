<?php
namespace src\Shared\Domain\DTOs;
class AvailableOrderDTO{
public function __construct(
        public readonly float $pickupLatitude,
        public readonly float $pickupLongitude,
        public readonly float $dropoffLatitude,
        public readonly float $dropoffLongitude,
        public readonly ?float $cost = null,
        public readonly ?int $userId = null,
    ){}
}
