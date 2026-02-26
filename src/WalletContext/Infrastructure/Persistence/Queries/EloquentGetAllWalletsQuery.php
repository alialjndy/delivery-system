<?php
namespace src\WalletContext\Infrastructure\Persistence\Queries;

use Illuminate\Support\Facades\DB;
use src\WalletContext\Application\DTOs\WalletFilter;
use src\WalletContext\Application\DTOs\WalletReadModel;
use src\WalletContext\Application\Queries\GetAllWalletsQueryInterface;

class EloquentGetAllWalletsQuery implements GetAllWalletsQueryInterface{
    public function execute(WalletFilter $filters, int $perPage = 15): array
    {
        $query = DB::table('wallets')
            ->when($filters->minBalance ?? null, function ($q) use ($filters) {
                $q->where('balance', '>=', $filters->minBalance);
            })
            ->when($filters->maxBalance ?? null, function ($q) use ($filters) {
                $q->where('balance', '<=', $filters->maxBalance);
            })
            ->select('id', 'driver_id as driverId', 'balance');

        $paginator = $query->paginate($perPage);


        $items = collect($paginator->items())->map(function ($item) {
            return new WalletReadModel(
                id: $item->id,
                driverId: $item->driverId,
                balance: $item->balance
            );
        });

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
