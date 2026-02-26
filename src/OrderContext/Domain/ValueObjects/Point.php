<?php
namespace src\OrderContext\Domain\ValueObjects ;

use InvalidArgumentException;
class Point{
    private const EARTH_RADIUS_METERS = 6371000;
    public function __construct(
        private Latitude $latitude ,
        private Longitude $longitude ,
    ){
        if(!self::isInSyria()){
            throw new InvalidArgumentException('The Location must be in Syrian Arab Republic.');
        }
    }

    public function distanceTo(Point $other){
        $latFrom = deg2rad($this->latitude->getValue());
        $latTo = deg2rad($other->latitude->getValue());

        $latDelta = deg2rad($this->latitude->getValue()) - deg2rad($other->latitude->getValue()) ;
        $lonDelta = deg2rad($this->longitude->getValue()) - deg2rad($other->longitude->getValue());

        $angle = 2 * asin(sqrt(
            pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)
        ));

        return $angle * self::EARTH_RADIUS_METERS;
    }
    public function isInSyria(){
        $lat = $this->latitude->getValue();
        $lng = $this->longitude->getValue();

        return ($lat >= 32.0 || $lat <= 37.5) && ($lng >= 35.7 || $lng <= 42.4);
    }

    // Getters
    public function getLatitude(){return $this->latitude->getValue();}
    public function getLongitude(){return $this->longitude->getValue();}
}
