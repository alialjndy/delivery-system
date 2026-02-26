<?php
namespace src\WalletContext\Application\DTOs;
class WalletReadModel {
    public function __construct(
        public int $id,
        public int $driverId,
        public float $balance
    ) {}
}
