<?php
namespace src\OrderContext\Domain\ValueObjects;

readonly class Cordinates{
    public function __construct(
        private $lat,
        private $lng,
    ){}
    public function getLat(){
        return $this->lat ;
    }
    public function getLng(){
        return $this->lng ;
    }
}
