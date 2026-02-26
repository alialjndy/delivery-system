<?php
namespace src\WalletContext\Application\Listeners;

use src\Shared\Domain\Events\OrderDeliveredEvent;
use src\Shared\Domain\ValueObjects\Money;
use src\WalletContext\Domain\Repositories\WalletRepositoryInterface;

class CreditDriverWalletOnOrderDelivered{
    public function __construct(
        private WalletRepositoryInterface $walletRepositoryInterface,
    ){}
    public function handle(OrderDeliveredEvent $event){
        $wallet = $this->walletRepositoryInterface->getWalletByDriverId($event->driverId);

        // For Debugging purpose.
        if($wallet === null){
            throw new \Exception("Wallet not found for driver id: " . $event->driverId);
        }

        $wallet->deposit(new Money($event->amount));

        $this->walletRepositoryInterface->save($wallet);
    }
}
