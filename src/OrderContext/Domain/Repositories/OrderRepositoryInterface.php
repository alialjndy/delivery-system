<?php
namespace src\OrderContext\Domain\Repositories ;

use src\OrderContext\Domain\Entities\Order;

interface OrderRepositoryInterface{
    public function save(Order $order) : ?Order;
    public function getById(int $id) : ?Order ;
}
