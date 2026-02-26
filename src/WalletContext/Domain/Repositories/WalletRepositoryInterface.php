<?php
namespace src\WalletContext\Domain\Repositories;

use src\WalletContext\Domain\Entity\Wallet;

interface WalletRepositoryInterface{
    public function save(Wallet $wallet) : ?Wallet;
    public function getWalletById(int $id) : ?Wallet;
    public function getWalletByDriverId(int $driverId) : ?Wallet;
}
