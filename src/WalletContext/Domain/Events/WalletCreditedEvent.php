<?php
namespace src\WalletContext\Domain\Events;
class WalletCreditedEvent{
    public function __construct(
        public readonly int $walletId,
        public readonly int $driverId,
        public readonly int $amount,
    ){}
}
