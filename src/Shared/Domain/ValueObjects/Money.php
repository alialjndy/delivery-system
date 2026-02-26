<?php
namespace src\Shared\Domain\ValueObjects ;
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
    public  function add(Money $other): Money{

        // Check if the currencies are the same
        if($this->currency !== $other->currency){
            throw new InvalidArgumentException('you cannot add two different currencies.');
        }
        return new Money($this->amount + $other->amount, $this->currency);
    }
    public function subtract(Money $other): Money{

        // Check if the currencies are the same
        if($this->currency !== $other->currency){
            throw new InvalidArgumentException('you cannot subtract two different currencies.');
        }

        // Check if the current amount is greater than or equal to the other amount
        if($this->amount < $other->amount){
            throw new InvalidArgumentException('you not have enough balance to perform this operation.');
        }

        return new Money($this->amount - $other->amount, $this->currency);
    }
    public function getAmount(){return $this->amount;}
    public function getCurrency(){return $this->currency;}
    public function getFormatAmount(){return $this->getAmount() .' '. $this->getCurrency();}
}
