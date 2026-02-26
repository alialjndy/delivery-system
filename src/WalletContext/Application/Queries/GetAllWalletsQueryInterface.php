<?php
namespace src\WalletContext\Application\Queries;

use src\WalletContext\Application\DTOs\WalletFilter;

interface GetAllWalletsQueryInterface{
    public function execute(WalletFilter $filters , int $perPage = 15): array ;
}
