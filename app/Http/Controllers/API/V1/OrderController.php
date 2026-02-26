<?php

namespace App\Http\Controllers\API\V1 ;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Http\Requests\Order\FilterOrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use src\OrderContext\Application\Actions\CancelOrder;
use src\OrderContext\Application\Actions\CreateOrder;
use src\OrderContext\Application\DTOs\OrderFilters;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use src\OrderContext\Application\Queries\GetAllOrdersQueryInterface;
use src\OrderContext\Application\Queries\GetOrderDetailsQueryInterface;

class OrderController extends Controller
{
    public function __construct(
        private CreateOrder $createOrderAction ,
        private CancelOrder $cancelOrderAction ,
        protected GetAllOrdersQueryInterface $getAllOrdersQueryInterface,
        protected GetOrderDetailsQueryInterface $getOrderDetailsQueryInterface,
    ){}
    /**
     * Display a listing of the resource.
     */
    public function index(FilterOrderRequest $request)
    {
        $validated = $request->validated();
        $data = $this->getAllOrdersQueryInterface->execute(
            new OrderFilters(
                $validated['status'] ?? null,
                $validated['min_cost'] ?? null,
                $validated['max_cost'] ?? null,
            ),
        );

        return self::success($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateOrderRequest $request)
    {
        $userId = JWTAuth::user()->id ;
        $order = $this->createOrderAction->execute(array_merge($request->validated() , ['user_id' => $userId]));

        return self::success($order);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $orderId)
    {
        $order = $this->getOrderDetailsQueryInterface->execute($orderId);
        return self::success($order);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        return response()->json(['message' => 'not implemented'] , 501);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        return response()->json(['message' => 'not implemented'] , 501);
    }
    public function cancel(int $id){
        $order = $this->cancelOrderAction->execute($id);
        return self::success($order , 'Order Cancelled Successfully!');
    }
}
