<?php
namespace src\DriverContext\Application\Listeners;

use Illuminate\Support\Facades\Log;
use src\DriverContext\Domain\Repositories\DriverLocationRepositoryInterface;
use src\DriverContext\Infrastructure\Jobs\NotifyNearbyDriversJob;
use src\PaymentContext\Domain\Events\PaymentSucceeded;
use src\Shared\Domain\Port\OrderDispatchQueryInterface;
use src\Shared\Domain\ValueObjects\Latitude;
use src\Shared\Domain\ValueObjects\Longitude;

class NotifyNearbyDriver{
    public function __construct(
        private DriverLocationRepositoryInterface $driverLocationRepositoryInterface,
        private OrderDispatchQueryInterface $orderDispatchQueryInterface,
    ){}

    public function handle(PaymentSucceeded $event){
        $orderId = $event->order_id;

        $orderDispatchDetails = $this->orderDispatchQueryInterface->getOrderDispatchDataById($orderId);

        $nearbyDrivers = $this->driverLocationRepositoryInterface->getNearbyDrivers(
            new Latitude($orderDispatchDetails->pickupLatitude),
            new Longitude($orderDispatchDetails->pickupLongitude)
        );

        $driverIds = array_map(fn($driver) => $driver[0], $nearbyDrivers);

        dispatch(new NotifyNearbyDriversJob($driverIds , [
            'order_id' => $orderId,
            'pickup_lat' => $orderDispatchDetails->pickupLatitude,
            'pickup_lon' => $orderDispatchDetails->pickupLongitude,

            'dropoff_lat' => $orderDispatchDetails->dropoffLatitude,
            'dropoff_lon' => $orderDispatchDetails->dropoffLongitude,

            'driver_earnings' => $orderDispatchDetails->cost * 0.20 , // Assuming driver earns 20% of the order cost
        ]));
        Log::info("Dispatched NotifyNearbyDriversJob for order ID: $orderId to " . count($driverIds) . " nearby drivers.");
    }
}
