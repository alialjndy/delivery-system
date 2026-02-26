<?php
namespace src\WalletTransactionContext\Infrastructure\Persistence\Queries;

use App\Models\WalletTransaction;
use Exception;
use src\WalletTransactionContext\Application\DTOs\WalletTransactionReadModel;
use src\WalletTransactionContext\Application\Queries\GetWalletTransactionQueryInerface;
class EloquentGetWalletTransactionQuery implements GetWalletTransactionQueryInerface{
    public function execute(int $walletTransactionId): WalletTransactionReadModel{
        $walletTransaction = WalletTransaction::find($walletTransactionId);
        if(!$walletTransaction) {throw new Exception("Wallet Transaction no found");}

        return new WalletTransactionReadModel(
            $walletTransaction->id,
            $walletTransaction->wallet_id,
            $walletTransaction->amount,
            $walletTransaction->type,
        );
    }
}
