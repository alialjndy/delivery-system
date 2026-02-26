<?php
namespace src\OrderContext\Application\Actions ;

use Illuminate\Support\Facades\Log;
use src\OrderContext\Application\DTOs\OrderReadModel;
use src\OrderContext\Domain\Exceptions\OrderNotFoundException;
use src\OrderContext\Domain\Repositories\OrderRepositoryInterface;
use Throwable;

class CancelOrder{
    public function __construct(
        private OrderRepositoryInterface $orderRepositoryInterface ,
    ){}
    public function execute(int $orderId){
        try{
            // OrderEntity
            $order = $this->orderRepositoryInterface->getById($orderId);

            if(!$order){throw new OrderNotFoundException();}

            $order->cancel() ;

            $cancelledOrder = $this->orderRepositoryInterface->save($order);

            return new OrderReadModel(
                $cancelledOrder->getId(),
                $cancelledOrder->getDriverId(),
                $cancelledOrder->getPickupPoint()->getLatitude(),
                $cancelledOrder->getPickupPoint()->getLongitude(),
                $cancelledOrder->getDropoffPoint()->getLatitude(),
                $cancelledOrder->getDropoffPoint()->getLongitude(),
                $cancelledOrder->getStatus()->value ,
                $cancelledOrder->getCost()->getFormatAmount(),
            );
        }catch(Throwable $e){
            Log::info('Error when cancel order . '.$e->getMessage());
            throw $e ;
        }
    }
}
