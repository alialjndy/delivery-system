<?php
namespace src\WalletTransactionContext\Application\DTOs;
class FilterWalletTransactions{
    public function __construct(
        public readonly ?int $walletId,
        public readonly ?float $minAmount,
        public readonly ?float $maxAmount,
        public readonly ?string $type,
    ){}
}
