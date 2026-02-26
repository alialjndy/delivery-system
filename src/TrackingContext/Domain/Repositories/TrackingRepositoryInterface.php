<?php
namespace src\TrackingContext\Domain\Repositories ;

use src\TrackingContext\Domain\Entity\DriverLocation;
interface TrackingRepositoryInterface{
    public function save(DriverLocation $driverLocation) : void ;
    public function getById(int $id) : ?DriverLocation ;
}
