<?php
namespace src\OrderContext\Infrastructure\Persistence;

use Illuminate\Support\Facades\Log;
use src\OrderContext\Domain\Repositories\OrderRepositoryInterface;
use src\Shared\Domain\DTOs\AvailableOrderDTO;
use src\Shared\Domain\Port\OrderDispatchQueryInterface;
class OrderDispatchQuery implements OrderDispatchQueryInterface{
    public function __construct(
     private OrderRepositoryInterface $orderRepository,
    ){}
    public function getOrderDispatchDataById(string $orderId): ?AvailableOrderDTO
    {
        $order = $this->orderRepository->getById($orderId);
        return new AvailableOrderDTO(
            $order->getPickupPoint()->getLatitude(),
            $order->getPickupPoint()->getLongitude(),

            $order->getDropoffPoint()->getLatitude(),
            $order->getDropoffPoint()->getLongitude(),

            $order->getCost()->getAmount(),
        );
        Log::info("Retrieved geolocation for order ID: $orderId - Pickup: ({$order->getPickupPoint()->getLatitude()}, {$order->getPickupPoint()->getLongitude()}), Dropoff: ({$order->getDropoffPoint()->getLatitude()}, {$order->getDropoffPoint()->getLongitude()})");
    }
}
