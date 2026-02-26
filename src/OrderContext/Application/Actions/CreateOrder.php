<?php
namespace src\OrderContext\Application\Actions ;

use Exception;
use Illuminate\Support\Facades\Log;
use src\OrderContext\Application\DTOs\OrderReadModel;
use src\OrderContext\Domain\Entities\Order as OrderEntity;
use src\OrderContext\Domain\Repositories\OrderRepositoryInterface;
use src\OrderContext\Domain\Services\PriceCalculator;
use src\OrderContext\Domain\ValueObjects\Latitude;
use src\OrderContext\Domain\ValueObjects\Longitude;
use src\OrderContext\Domain\ValueObjects\Point;

class CreateOrder{
    public function __construct(
        private PriceCalculator $priceCalculator ,
        private OrderRepositoryInterface $orderRepositoryInterface,

    ){}
    public function execute(array $data){
        try{
            // Calculate cost
            $cost = $this->priceCalculator->calculate(
                new Point(new Latitude($data['pickup_lat']) , new Longitude($data['pickup_lng'])),
                new Point(new Latitude($data['dropoff_lat']) , new Longitude($data['dropoff_lng']))
                );
            $order = OrderEntity::create(
                $data['user_id'],
                new Point(new Latitude($data['pickup_lat']) , new Longitude($data['pickup_lng'])),
                new Point(new Latitude($data['dropoff_lat']) , new Longitude($data['dropoff_lng'])),
                $cost,
            );
            $createdOrder = $this->orderRepositoryInterface->save($order);
            return new OrderReadModel(
                $createdOrder->getId(),
                $createdOrder->getUserId(),
                $createdOrder->getDriverId(),
                $createdOrder->getPickupPoint()->getLatitude(),
                $createdOrder->getPickupPoint()->getLongitude(),
                $createdOrder->getDropoffPoint()->getLatitude(),
                $createdOrder->getDropoffPoint()->getLongitude(),
                $createdOrder->getStatus()->value,
                $createdOrder->getCost()->getAmount() .' '. $createdOrder->getCost()->getCurrency(),
            );
        }catch(Exception $e){
            throw $e ;
        }
    }
}
