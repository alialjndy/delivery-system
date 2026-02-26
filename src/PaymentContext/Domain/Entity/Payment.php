<?php
namespace src\PaymentContext\Domain\Entity ;

use src\PaymentContext\Domain\Events\PaymentSucceeded;
use src\PaymentContext\Domain\ValueObject\PaymentStatus;
use src\Shared\Domain\ValueObjects\Money;

class Payment{
    private $domainEvents = [] ;
    public function __construct(
        private readonly ?int $id ,
        private int $userId,
        private int $orderId ,
        private Money $amount ,
        private string $provider ,
        private ?string $transactionId ,
        private PaymentStatus $status = PaymentStatus::PENDING ,
    ){}
    public static function create(int $orderId , int $userId, Money $amount , string $provider , string $transactionId = null){
        return new self(
            null,
            $userId ,
            $orderId,
            $amount,
            $provider ,
            $transactionId,
        );
    }
    public static function reconstitute(array $data){
        return new self(
            $data['id'] ,
            $data['user_id'],
            $data['order_id'],
            new Money($data['amount'] , $data['currency']),
            $data['provider'],
            $data['transaction_id'] ?? null ,
            PaymentStatus::from($data['status']),
        );
    }

    //
    public function setTransactionId(string $transactionId){$this->transactionId = $transactionId ;}

    //
    public function markAsSuccessful(){
        $this->status = PaymentStatus::SUCCESSFUL;

        $this->domainEvents[] = new PaymentSucceeded($this->getOrderId());
    }

    //
    public function markAsFailed(){$this->status = PaymentStatus::FAILED;}

    //
    public function pullEvents() : array {
        $events = $this->domainEvents;
        $this->domainEvents = [] ;

        return $events ;
    }

    // Getters
    public function getId(){return $this->id;}
    public function getUserId(){return $this->userId;}
    public function getOrderId(){return $this->orderId;}
    public function getAmount(){return $this->amount->getAmount();}
    public function getCurrency(){return $this->amount->getCurrency();}
    public function getStatus(){return $this->status;}
    public function getTransactionId(){return $this->transactionId;}
    public function getProvider(){return $this->provider;}
}
