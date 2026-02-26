<?php
namespace src\WalletTransactionContext\Application\Queries;

use src\WalletTransactionContext\Application\DTOs\FilterWalletTransactions;

interface GetAllWalletTransactionsQueryInterface{
    public function execute(FilterWalletTransactions $filters , int $perPage = 15) :array ;
}
