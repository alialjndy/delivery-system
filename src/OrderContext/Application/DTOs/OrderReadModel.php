<?php
namespace src\OrderContext\Application\DTOs ;
class OrderReadModel{
    public function __construct(
        public ?int $id,
        public int $user_id ,
        public ?int $driver_id ,
        public float $pickup_lat ,
        public float $pickup_lng ,
        public float $dropoff_lat ,
        public float $dropoff_lng ,
        public string $status ,
        public string $cost,
    ){}
}
