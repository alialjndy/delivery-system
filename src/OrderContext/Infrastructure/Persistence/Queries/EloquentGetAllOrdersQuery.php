<?php
namespace src\OrderContext\Infrastructure\Persistence\Queries;

use Illuminate\Support\Facades\DB;
use src\DriverContext\Application\DTOs\DriverFilters;
use src\OrderContext\Application\DTOs\OrderFilters;
use src\OrderContext\Application\DTOs\OrderReadModel;
use src\OrderContext\Application\Queries\GetAllOrdersQueryInterface;
class EloquentGetAllOrdersQuery implements GetAllOrdersQueryInterface{
    public function execute(OrderFilters $filters , int $perPage = 15) : array {
        $query = DB::table('orders')
            ->when($filters->status ?? null, function ($query) use ($filters) {
                $query->where('status', $filters->status);
            })
            ->when($filters->min_cost ?? null , function ($query) use ($filters) {
                $query->where('cost', '>=', $filters->min_cost);
            })
            ->when($filters->max_cost ?? null, function ($query) use ($filters) {
                $query->where('cost', '<=', $filters->max_cost);
            });
        $paginator = $query->paginate($perPage);

        $itmes = collect($paginator->items())->map(function ($row){
            return new OrderReadModel(
                $row->id,
                $row->user_id,
                $row->driver_id,
                $row->pickup_lat,
                $row->pickup_lng,
                $row->dropoff_lat,
                $row->dropoff_lng,
                $row->status,
                $row->cost,
            );
        })->toArray();
        return [
            'data' => $itmes ,
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
            ]
        ];
    }
}
