<?php
namespace src\WalletTransactionContext\Infrastructure\Persistence\Queries;

use Illuminate\Support\Facades\DB;
use src\WalletTransactionContext\Application\DTOs\FilterWalletTransactions;
use src\WalletTransactionContext\Application\DTOs\WalletTransactionReadModel;
use src\WalletTransactionContext\Application\Queries\GetAllWalletTransactionsQueryInterface;

class EloquentGetAllWalletTransactionsQuery implements GetAllWalletTransactionsQueryInterface{
    public function execute(FilterWalletTransactions $fitlers , int $perPage = 15): array{
        $query = DB::table('wallet_transactions')
            ->when($fitlers->minAmount , function ($q) use ($fitlers){
                $q->where('amount', '<=' , $fitlers->minAmount);
            })
            ->when($fitlers->maxAmount , function ($q) use ($fitlers){
                $q->where('amount', '>=' , $fitlers->maxAmount);
            })
            ->when($fitlers->walletId , function ($q) use ($fitlers){
                $q->where('wallet_id' , $fitlers->walletId);
            })
            ->when($fitlers->type ?? null , function($q) use ($fitlers){
                $q->where('type' , $fitlers->type);
            });

        $paginator = $query->paginate($perPage);

        $items =  collect($paginator->items())->map(function($item){
            return new WalletTransactionReadModel(
                $item->id,
                $item->wallet_id,
                $item->amount,
                $item->type,
            );
        })->toArray();

        return [
            'data' => $items,
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'next_page' => $paginator->nextPageUrl(),
                'prev_page' => $paginator->previousPageUrl(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
            ],
        ];
    }
}
