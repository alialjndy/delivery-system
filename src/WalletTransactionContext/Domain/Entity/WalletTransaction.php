<?php
namespace src\WalletTransactionContext\Domain\Entity;

use src\Shared\Domain\ValueObjects\Money;
use src\WalletTransactionContext\Domain\ValueObjects\WalletTransactionType;

class WalletTransaction{
    public function __construct(
        private ?int $id,
        private int $walletId,
        private Money $amount,
        private WalletTransactionType $type,
    ){}

    public static function create(int $walletId , Money $amount , WalletTransactionType $type): self{
        return new self(
            id: null,
            walletId: $walletId,
            amount: $amount,
            type: $type
        );
    }

    public static function reconstitute(array $data){
        return new self(
            $data['id'],
            $data['wallet_id'],
            new Money($data['amount']),
            WalletTransactionType::from($data['type'])
        );
    }

    // Getters
    public function getId(): ?int {return $this->id;}
    public function getWalletId(): int {return $this->walletId;}
    public function getMoney(){return $this->amount;}
    public function getType(){return $this->type;}
// OrderDeliveredEvent
}
