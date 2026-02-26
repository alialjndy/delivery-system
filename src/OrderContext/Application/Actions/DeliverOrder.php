<?php
namespace src\OrderContext\Application\Actions;

use src\OrderContext\Domain\Repositories\OrderRepositoryInterface;

class DeliverOrder{
    public function __construct(
        private OrderRepositoryInterface $orderRepositoryInterface,
    ){}
    public function execute($orderId , $authDriverId){
        $order = $this->orderRepositoryInterface->getById($orderId);

        $order->deliveredOrder($authDriverId);

        $this->orderRepositoryInterface->save($order);
    }
}
