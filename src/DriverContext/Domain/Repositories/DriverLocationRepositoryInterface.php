<?php
namespace src\DriverContext\Domain\Repositories;

use src\Shared\Domain\ValueObjects\Latitude;
use src\Shared\Domain\ValueObjects\Longitude;

interface DriverLocationRepositoryInterface
{
    public function getNearbyDrivers(Latitude $latitude,Longitude $longitude) : array;
}
