<?php
namespace src\OrderContext\Application\Actions ;

use Exception;
use Illuminate\Support\Facades\Log;
use src\OrderContext\Domain\Exceptions\OrderNotFoundException;
use src\OrderContext\Infrastructure\Persistence\EloquentOrderRepository;

class UpdateOrderStatus{
    public function __construct(
        private EloquentOrderRepository $eloquentOrderRepository ,
    ){}
    public function execute($orderId){
        try{
            $order = $this->eloquentOrderRepository->getById($orderId);

            if(!$order){ throw new OrderNotFoundException(); }

            $order->confirmed();

            $this->eloquentOrderRepository->save($order);

            Log::info('order confrimed successfully');
        }catch(Exception $e){
            throw $e ;
        }
    }
}
