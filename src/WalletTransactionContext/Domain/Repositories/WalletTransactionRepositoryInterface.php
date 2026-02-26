<?php
namespace src\WalletTransactionContext\Domain\Repositories;

use src\WalletTransactionContext\Domain\Entity\WalletTransaction;

interface WalletTransactionRepositoryInterface{
    public function save(WalletTransaction $transaction): ?WalletTransaction;
    public function findById(int $id): ?WalletTransaction ;
}
