<?php
namespace src\DriverContext\Application\Queries;

use src\DriverContext\Application\DTOs\DriverFilters;

interface GetDriversQueryInterface{
    public function execute(DriverFilters $driverFilters , int $per_page = 15): array;
}
