<?php
namespace src\DriverContext\Infrastructure\Persistence\Queries;

use Illuminate\Support\Facades\DB;
use src\DriverContext\Application\DTOs\DriverFilters;
use src\DriverContext\Application\DTOs\DriverReadModel;
use src\DriverContext\Application\Queries\GetDriversQueryInterface;

class EloquentGetDriversQuery implements GetDriversQueryInterface{
    public function execute(DriverFilters $driverFilters, int $per_page = 15): array {
        $query = DB::table('drivers')
            ->when($driverFilters->name, function ($q) use ($driverFilters) {
                $q->where('name', 'like', "%{$driverFilters->name}%");
            })
            ->when($driverFilters->status, function ($q) use ($driverFilters) {
                $q->where('status', $driverFilters->status);
            })
            ->when($driverFilters->nationalNumber, function ($q) use ($driverFilters) {
                $q->where('national_number', $driverFilters->nationalNumber);
            });

        $paginator = $query->paginate($per_page);
        $itmes = collect($paginator->items())->map(function ($row){
            return new DriverReadModel(
                $row->id,
                $row->user->id,
                $row->name,
                $row->phone_number,
                $row->address,
                $row->national_number,
                $row->status,
            );
        })->toArray();
        return [
            'data' => $itmes,
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

