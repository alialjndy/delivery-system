<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\CreatePaymentRequest;
use App\Http\Requests\Payment\FilterPaymentRequest;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use src\PaymentContext\Application\Actions\CreatePayment;
use src\PaymentContext\Application\DTOs\PaymentFilter;
use src\PaymentContext\Application\Queries\GetAllPaymentsInterface;
use src\PaymentContext\Application\Queries\GetPaymentDetailsInterface;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
class PaymentController extends Controller
{
    public function __construct(
        private CreatePayment $createPaymentAction ,
        private GetAllPaymentsInterface $getAllPaymentsInterface ,
        private GetPaymentDetailsInterface $getPaymentDetailsInterface ,
    ){}
    /**
     * Display a listing of the resource.
     */
    public function index(FilterPaymentRequest $request)
    {
        $allPayments = $this->getAllPaymentsInterface->execute(new PaymentFilter(
            $request->validated()['user_id'] ?? null,
            $request->validated()['status'] ?? null,
            $request->validated()['provider'] ?? null,
            $request->validated()['min_amount'] ?? null,
            $request->validated()['max_amount'] ?? null,
        ));
        return self::success($allPayments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePaymentRequest $request)
    {
        $user_id = JWTAuth::user()->id ;
        $order = Order::findOrFail($request->validated()['order_id']);

        $info = $this->createPaymentAction->execute(
            array_merge($request->validated() + ['user_id' => $user_id] , ['amount' => $order->cost]));
        return self::success($info);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $paymentDetails = $this->getPaymentDetailsInterface->execute($id);
        return self::success($paymentDetails);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        return self::success(null , 'Not allowed method (not implemented update!' , 409);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        return self::success(null , 'Not allowed method (not implemented delete!)' , 409);
    }
}
