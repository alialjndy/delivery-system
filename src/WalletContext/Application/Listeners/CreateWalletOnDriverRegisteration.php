<?php
namespace src\WalletContext\Application\Listeners;

use Illuminate\Support\Facades\Log;
use src\Shared\Domain\Events\DriverRegistered;
use src\WalletContext\Domain\Entity\Wallet;
use src\WalletContext\Domain\Repositories\WalletRepositoryInterface;

class CreateWalletOnDriverRegisteration{
    public function __construct(
        private WalletRepositoryInterface $walletRepository,
    ){}
    public function handle(DriverRegistered $event){
        $wallet = Wallet::create($event->driverId);

        $this->walletRepository->save($wallet);

        Log::info("Wallet created for driver with ID: {$event->driverId}");
    }
}
