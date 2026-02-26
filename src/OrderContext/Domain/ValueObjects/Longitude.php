<?php
namespace src\OrderContext\Domain\ValueObjects ;

use InvalidArgumentException;
readonly class Longitude{
    public function __construct(private float $value)
    {
        if($value < -180 || $value > 180){
            throw new InvalidArgumentException('خط الطول يجب أن يكون بين -180 و +180');
        }
    }
    public function getValue(){return $this->value;}
}
