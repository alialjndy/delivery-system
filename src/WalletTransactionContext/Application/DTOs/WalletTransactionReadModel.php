<?php
namespace src\WalletTransactionContext\Application\DTOs;
class WalletTransactionReadModel{
    public function __construct(
        public readonly int $id,
        public readonly int $walletId,
        public readonly float $amount,
        public readonly string $type,
    ){}
}
