<?php
namespace src\WalletContext\Infrastructure\Persistence;

use App\Models\Wallet as ModelWallet;
use src\WalletContext\Domain\Entity\Wallet;
use src\WalletContext\Domain\Repositories\WalletRepositoryInterface;
class EloquentWalletRepository implements WalletRepositoryInterface{
    public function save(Wallet $wallet): ?Wallet
    {
        $ModelWallet = ModelWallet::updateOrCreate(
            ['driver_id' => $wallet->getDriverId()],
            [
                'driver_id' => $wallet->getDriverId(),
                'balance' => $wallet->getBalance()->getAmount(),
            ]
        );

        foreach($wallet->pullEvents() as $event){
            event($event);
        }
        return Wallet::reconstitute($ModelWallet->toArray());
    }
    public function getWalletById(int $id): ?Wallet
    {
        $wallet = ModelWallet::find($id);
        return $wallet ? Wallet::reconstitute($wallet->toArray()) : null;
    }

    public function getWalletByDriverId(int $driverId): ?Wallet
    {
        $wallet = ModelWallet::where('driver_id', $driverId)->first();
        return $wallet ? Wallet::reconstitute($wallet->toArray()) : null;
    }
}
