<?php
namespace src\OrderContext\Application\DTOs;
class OrderFilters{
    public function __construct(
        public ?string $status = null ,
        public ?float $min_cost = null ,
        public ?float $max_cost = null ,
    ){}
}
