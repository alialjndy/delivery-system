<?php
namespace src\WalletContext\Application\DTOs;
class WalletFilter{
    public function __construct(
        public ?float $minBalance = null,
        public ?float $maxBalance = null,
    ){}
}
