<?php
namespace src\OrderContext\Infrastructure\Persistence\Queries;

use App\Models\Order;
use src\OrderContext\Application\DTOs\OrderReadModel;
use src\OrderContext\Application\Queries\GetOrderDetailsQueryInterface;
use src\OrderContext\Domain\Exceptions\OrderNotFoundException;
use src\OrderContext\Domain\Repositories\OrderRepositoryInterface;

class EloquentGetOrderDetailsQuery implements GetOrderDetailsQueryInterface{
    public function __construct(
        private OrderRepositoryInterface $orderRepositoryInterface,
    ){}
    public function execute(int $orderId)
    {
        $order = Order::find($orderId);
        if (!$order) {throw new OrderNotFoundException("Order not found!");}

        return new OrderReadModel(
            $order->id,
            $order->user_id,
            $order->driver_id,
            $order->pickup_lat,
            $order->pickup_lng,
            $order->dropoff_lat,
            $order->dropoff_lng,
            $order->status,
            $order->cost
        );
    }
}
