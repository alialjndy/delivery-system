<?php
namespace src\TrackingContext\Infrastructure\Persistence ;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use src\Shared\Domain\ValueObjects\Latitude;
use src\Shared\Domain\ValueObjects\Longitude;
use src\TrackingContext\Domain\Entity\DriverLocation;
use src\TrackingContext\Domain\Repositories\TrackingRepositoryInterface;
class RedisDriverLocationRepository implements TrackingRepositoryInterface{
    public function save(DriverLocation $driverLocation): void
    {
        Redis::geoadd(
            'driver_locations',
            $driverLocation->getLongitude()->getValue() ,
            $driverLocation->getLatitude()->getValue() ,
            $driverLocation->getDriverId(),
        );
        Log::info("Latitude Location is : " . $driverLocation->getLatitude()->getValue());
        Log::info("Longitude Location is : " . $driverLocation->getLongitude()->getValue());
        Log::info("Driver ID is : " . $driverLocation->getDriverId());

        Redis::expire('driver_locations' , 3600);
    }
    public function getById(int $id): ?DriverLocation
    {
        $position = Redis::geopos('driver_locations' , $id);
        Log::info($position);
        return new DriverLocation(
            new Latitude($position[0][1]),
            new Longitude($position[0][0]),
            $id
        );
    }
}
