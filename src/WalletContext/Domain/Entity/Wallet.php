<?php
namespace src\WalletContext\Domain\Entity;

use src\Shared\Domain\ValueObjects\Money;
use src\WalletContext\Domain\Events\WalletCreditedEvent;
use src\WalletContext\Domain\Events\WalletDebitedEvent;

class Wallet{
    private array $domainEvents = [];
    public function __construct(
        private ?int $id,
        private int $driverId,
        private Money $balance,
    ){}
    public static function create(int $driverId , Money $balance = new Money(0)): self{
        return new self(null, $driverId, $balance);
    }
    public static function reconstitute(array $data): self{
        return new self(
            $data['id'],
            $data['driver_id'],
            new Money($data['balance'])
        );
    }
    public function deposit(Money $amount): void{
        $this->balance = $this->balance->add($amount);
        $this->domainEvents[] = new WalletCreditedEvent(
            $this->getId(),
            $this->getDriverId(),
            $amount->getAmount(),
        );
    }
    public function withdraw(Money $amount): void{
        $this->balance = $this->balance->subtract($amount);
        $this->domainEvents[] = new WalletDebitedEvent(
            $this->getId(),
            $this->getDriverId(),
            $amount->getAmount()
        );
    }
    public function pullEvents(){
        $events = $this->domainEvents;
        $this->domainEvents = [];
        return $events;
    }

    // Getters
    public function getId(){return $this->id;}
    public function getDriverId(){return $this->driverId;}
    public function getBalance(){return $this->balance;}
}
