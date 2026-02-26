<?php
namespace src\TrackingContext\Domain\Entity ;

use src\Shared\Domain\ValueObjects\Latitude;
use src\Shared\Domain\ValueObjects\Longitude;

class DriverLocation{
    public function __construct(
        private Latitude $latitude ,
        private Longitude $longitude,
        private int $driver_id,
    ){}
    public static function create(Latitude $latitude , Longitude $longitude , int $driver_id){
        return new self(
            $latitude ,
            $longitude ,
            $driver_id,
        );
    }
    public static function reconstitude(array $data){
        return new self(
            $data['latitude'],
            $data['longitude'],
            $data['driver_id']
        );
    }
    public function changeLatitude(Latitude $latitude){
        $this->latitude = $latitude ;
    }
    public function changeLongitue(Longitude $longitude){
        $this->longitude = $longitude ;
    }

    // Getters
    public function getLatitude(){return $this->latitude ;}
    public function getLongitude(){return $this->longitude ;}
    public function getDriverId(){return $this->driver_id ;}
}
