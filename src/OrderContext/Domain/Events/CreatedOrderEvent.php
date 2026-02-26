<?php
namespace src\OrderContext\Domain\Events ;

use src\OrderContext\Domain\Entities\Order;

class CreatedOrderEvent{
    public function __construct(
        Order $order
    ){}
}
