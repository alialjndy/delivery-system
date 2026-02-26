<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\DriverOrder\AcceptOrderRequest;
use App\Http\Requests\DriverOrder\DeliverOrderRequest;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use src\OrderContext\Application\Actions\AcceptOrder;
use src\OrderContext\Application\Actions\DeliverOrder;

class DriverOrderController extends Controller
{
    public function __construct(
        private AcceptOrder $acceptOrderAction,
        private DeliverOrder $deliverOrderAction,
    ){}
    public function accept(int $order_id){
        // $this->authorize('accept', User::class);
        $authId = JWTAuth::user()->id;
        $driverId = Driver::select('id')->where('user_id', $authId)->firstOrFail()->id;

        $this->acceptOrderAction->execute($order_id , $driverId);
        return self::success(null , 'Order accepted successfully');
    }

    public function deliver($order_id){
        $authId = JWTAuth::user()->id;
        $driverId = Driver::select('id')->where('user_id', $authId)->firstOrFail()->id;

        $this->deliverOrderAction->execute($order_id , $driverId);
        return self::success(message: 'Order delivered successfully');
    }
}
