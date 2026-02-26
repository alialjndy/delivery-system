<?php
namespace src\DriverContext\Application\DTOs;
class DriverReadModel{
    public function __construct(
        public readonly ?int $id,
        public readonly int $userId,
        public readonly string $name,
        public readonly string $phoneNumber,
        public readonly ?string $address,
        public readonly string $nationalNumber,
        public readonly string $status,
    ){}
}
