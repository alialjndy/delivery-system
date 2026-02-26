<?php
namespace src\DriverContext\Application\DTOs;
class DriverFilters{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $status = null,
        public readonly ?string $nationalNumber = null,
        public readonly ?int $min_cost = null,
        public readonly ?int $max_cost = null,
    ){}
}
