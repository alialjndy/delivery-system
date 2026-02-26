<?php
namespace src\Shared\Domain\Events;
class DriverRegistered{
    public function __construct(
        public readonly int $driverId,
    ){}
}
