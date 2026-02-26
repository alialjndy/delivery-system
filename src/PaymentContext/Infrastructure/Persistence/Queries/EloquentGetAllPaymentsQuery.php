<?php
namespace src\PaymentContext\Infrastructure\Persistence\Queries ;

use Illuminate\Support\Facades\DB;
use src\PaymentContext\Application\DTOs\PaymentFilter;
use src\PaymentContext\Application\Queries\GetAllPaymentsInterface;
class EloquentGetAllPaymentsQuery implements GetAllPaymentsInterface{
    public function execute(PaymentFilter $filterGetAllPayments, int $per_page = 15): array{
        $query = DB::table('payments')->select(['id','user_id','order_id','amount','currency','provider','status','transaction_id'])

            // Filter by user ID
            ->when($filterGetAllPayments->userId ?? null , function ($q) use ($filterGetAllPayments){
                $q->where('user_id' , $filterGetAllPayments->userId);
            })

            // Filtery by status
            ->when($filterGetAllPayments->status , function ($q) use ($filterGetAllPayments){
                $q->where('status' , $filterGetAllPayments->status);
            })

            // Filter by payment method
            ->when($filterGetAllPayments->provider , function($q) use ($filterGetAllPayments){
                $q->where('provider' , $filterGetAllPayments->provider);
            })

            // Filter by min amount
            ->when($filterGetAllPayments->min_amount , function ($q) use ($filterGetAllPayments){
                $q->where('amount' , '>=' , $filterGetAllPayments->min_amount);
            })

            // Filter by max amount
            ->when($filterGetAllPayments->max_amount , function ($q) use ($filterGetAllPayments){
                $q->where('amount', '<=' , $filterGetAllPayments->max_amount);
            });
            $paginator = $query->paginate($per_page);
            return [
                'info' => $paginator->items(),
                'meta' => [
                    'current_page'  => $paginator->currentPage(),
                    'previous_page' => $paginator->previousPageUrl(),
                    'next_page'     => $paginator->nextPageUrl(),
                    'per_page'      => $paginator->perPage(),
                    'last_page'     => $paginator->lastPage(),
                    'total'         => $paginator->total(),
                ],
            ];
    }
}
