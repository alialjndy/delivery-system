<?php
namespace src\WalletContext\Application\Listeners;

use Illuminate\Support\Facades\Log;
use src\Shared\Domain\Events\UserRegisterd;
use src\WalletContext\Domain\Entity\Wallet;
use src\WalletContext\Domain\Repositories\WalletRepositoryInterface;

class CreateWalletOnUserRegistration{
    public function __construct(
        private WalletRepositoryInterface $walletRepositoryInterface,
    ){}
    public function handle(UserRegisterd $event){
        $wallet = Wallet::create($event->userId);

        $this->walletRepositoryInterface->save($wallet);

        Log::info("Wallet created for user ID: {$event->userId}");
    }
}
