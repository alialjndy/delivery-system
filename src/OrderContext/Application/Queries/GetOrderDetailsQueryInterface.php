<?php
namespace src\OrderContext\Application\Queries;
interface GetOrderDetailsQueryInterface
{
    public function execute(int $orderId);
}
