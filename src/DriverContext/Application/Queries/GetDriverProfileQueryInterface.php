<?php
namespace src\DriverContext\Application\Queries;

use src\DriverContext\Application\DTOs\DriverReadModel;

interface GetDriverProfileQueryInterface{
    public function execute(int $driverId): ?DriverReadModel;
}
