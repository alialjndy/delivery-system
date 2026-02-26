<?php
namespace src\TrackingContext\Application\Actions ;

use Exception;
use src\Shared\Domain\ValueObjects\Latitude;
use src\Shared\Domain\ValueObjects\Longitude;
use src\TrackingContext\Domain\Entity\DriverLocation;
use src\TrackingContext\Domain\Repositories\TrackingRepositoryInterface;

class UpdateDriverLocation{
    public function __construct(
        private TrackingRepositoryInterface $trackingRepositoryInterface ,
    ){}

    public function execute(array $data){
        try{
            $this->trackingRepositoryInterface->save(new DriverLocation(
                new Latitude($data['latitude']),
                new Longitude($data['longitude']),
                $data['driver_id'],
            ));
        }catch(Exception $e){
            throw $e ;
        }
    }
}
