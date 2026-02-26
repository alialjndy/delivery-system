<?php
namespace src\OrderContext\Infrastructure\Persistence ;

use App\Models\Order as ModelsOrder;
use src\OrderContext\Domain\Entities\Order;
use src\OrderContext\Domain\Repositories\OrderRepositoryInterface;
class EloquentOrderRepository implements OrderRepositoryInterface{
    public function save(Order $order): ?Order{
        $orderModel = ModelsOrder::updateOrCreate(
            ['id' => $order->getId()],
            [
                'user_id' => $order->getUserId(),
                'driver_id' => $order->getDriverId() ?? null ,
                'pickup_lat' => $order->getPickupPoint()->getLatitude(),
                'pickup_lng' => $order->getPickupPoint()->getLongitude(),
                'dropoff_lat' => $order->getDropoffPoint()->getLatitude(),
                'dropoff_lng' => $order->getDropoffPoint()->getLongitude(),
                'status' => $order->getStatus()->value,
                'cost' => $order->getCost()->getAmount()
            ]
        );

        foreach($order->pullEvents() as $event) {
            event($event);
        }

        // Outpus is Entity Order
        return $order->reconstitute($orderModel->toArray());
    }
    public function getById(int $id): ?Order
    {
        $order = ModelsOrder::where('id' , $id)->first();
        return $order ? Order::reconstitute($order->toArray()) : null ;
    }
}
