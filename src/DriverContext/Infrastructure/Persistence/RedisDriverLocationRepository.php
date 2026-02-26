<?php
namespace src\DriverContext\Infrastructure\Persistence;

use Illuminate\Support\Facades\Redis;
use src\DriverContext\Domain\Repositories\DriverLocationRepositoryInterface;
use src\Shared\Domain\ValueObjects\Latitude;
use src\Shared\Domain\ValueObjects\Longitude;

class RedisDriverLocationRepository implements DriverLocationRepositoryInterface{
    public function getNearbyDrivers(Latitude $latitude,Longitude $longitude): array
    {
        return Redis::executeRaw([
            'GEOSEARCH',
            'drivers_locations',
            'FROMLONLAT',
            $longitude->getValue(),
            $latitude->getValue(),
            'BYRADIUS',
            5,
            'km',
            'WITHDIST',
            'ASC'
        ]);
        // return Redis::geoSearch('drivers_locations', 'FROMLONLAT', $longitude->getValue(), $latitude->getValue(), 'BYRADIUS', 5, 'km' , 'WITHDIST' , 'ASC');
    }
}
