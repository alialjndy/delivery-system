<?php
namespace src\Shared\Domain\ValueObjects ;

use InvalidArgumentException;

readonly class Latitude{
    public function __construct(private float $value)
    {
        if($value < -90 || $value > 90){
            throw new InvalidArgumentException('خط العرض يجب أن يكون بين -90 و +90');
        }
    }
    public function isSyrianLocation(){

    }
    public function getValue(){return $this->value;}
}
