<?php
namespace src\OrderContext\Domain\Services;

use src\OrderContext\Domain\Entities\Order;
use src\OrderContext\Domain\ValueObjects\Money;
use src\OrderContext\Domain\ValueObjects\Point;

class PriceCalculator{
    private const PRICE_PER_MINUTE = 0.005 ; // Dollar
    public function __construct(
    ){}
    public function calculate(Point $pickup , Point $dropoff){

        $distance = $pickup->distanceTo($dropoff);
        return new Money($distance * self::PRICE_PER_MINUTE) ;
    }
}
