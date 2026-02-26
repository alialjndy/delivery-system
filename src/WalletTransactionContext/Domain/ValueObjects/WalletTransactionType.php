<?php
namespace src\WalletTransactionContext\Domain\ValueObjects;
enum WalletTransactionType: string {
    case DEPOSIT = 'deposit';
    case WITHDRAW = 'withdraw';

    public function getValue(): string {
        return $this->value;
    }
}
