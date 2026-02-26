<?php
namespace src\WalletContext\Infrastructure\Persistence\Queries;

use App\Models\Wallet;
use src\WalletContext\Application\DTOs\WalletReadModel;
use src\WalletContext\Application\Queries\GetWalletDetailsQueryInterface;
class EloquentGetWalletDetailsQuery implements GetWalletDetailsQueryInterface{
    public function execute(int $walletId): WalletReadModel{
        $wallet = Wallet::find($walletId);

        if(!$wallet){ throw new \Exception("Wallet not found"); }
        return new WalletReadModel(
            id: $wallet->id,
            driverId: $wallet->driver_id,
            balance: $wallet->balance
        );
    }
}
