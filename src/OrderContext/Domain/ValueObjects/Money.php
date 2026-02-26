<?php
namespace src\OrderContext\Domain\ValueObjects ;

use InvalidArgumentException;
readonly class Money{
    public function __construct(
        private int $amount,
        private string $currency = 'USD',
    ){
        if($amount < 0){
            throw new InvalidArgumentException('لا يمكن للعملة أن تكون سالبة.');
        }
    }
    public function getAmount(){return $this->amount;}
    public function getCurrency(){return $this->currency;}
    public function getFormatAmount(){return $this->getAmount() .' '. $this->getCurrency();}
}
