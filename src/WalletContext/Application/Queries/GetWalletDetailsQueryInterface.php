<?php
namespace src\WalletContext\Application\Queries;

use src\WalletContext\Application\DTOs\WalletReadModel;

interface GetWalletDetailsQueryInterface{
    public function execute(int $walletId): WalletReadModel;
}
