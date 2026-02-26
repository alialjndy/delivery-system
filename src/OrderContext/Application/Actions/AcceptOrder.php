<?php
namespace src\OrderContext\Application\Actions;

use src\OrderContext\Domain\Exceptions\OrderNotFoundException;
use src\OrderContext\Domain\Repositories\OrderRepositoryInterface;
use src\Shared\Domain\Port\TransactionManagerInterface;

class AcceptOrder {
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        // private TransactionManagerInterface $transactionManager
    ){}

    public function execute(int $orderId, int $driverId)
    {
            $order = $this->orderRepository->getById($orderId);

            if (!$order) { throw new OrderNotFoundException();}

            $order->assignDriver($driverId);

            $this->orderRepository->save($order);

            return $order;
    }
}
