<?php
namespace src\WalletTransactionContext\Application\Queries;

use src\WalletTransactionContext\Application\DTOs\FilterWalletTransactions;
use src\WalletTransactionContext\Application\DTOs\WalletTransactionReadModel;

interface GetWalletTransactionQueryInerface{
    public function execute(int $walletTransactionId): WalletTransactionReadModel ;
}
