<?php
namespace src\DriverContext\Infrastructure\Persistence\Queries;

use App\Models\Driver;
use src\DriverContext\Application\DTOs\DriverReadModel;
use src\DriverContext\Application\Queries\GetDriverProfileQueryInterface;

class EloquentGetDriverProfileQuery implements GetDriverProfileQueryInterface{
    public function execute(int $driverId): ?DriverReadModel {
        // Get A Driver by ID using Eloquent ORM
        $row = Driver::where('id', $driverId)->first();

        return $row ? new DriverReadModel(
            $row->id,
            $row->user->id,
            $row->name,
            $row->phone_number,
            $row->address,
            $row->national_number,
            $row->status,
        ) : null;
    }
}
