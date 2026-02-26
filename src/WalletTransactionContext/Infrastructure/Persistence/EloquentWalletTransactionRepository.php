<?php
namespace src\WalletTransactionContext\Infrastructure\Persistence;

use App\Models\WalletTransaction as ModelsWalletTransaction;
use src\WalletTransactionContext\Domain\Entity\WalletTransaction;
use src\WalletTransactionContext\Domain\Repositories\WalletTransactionRepositoryInterface;

class EloquentWalletTransactionRepository implements WalletTransactionRepositoryInterface{
    public function save(WalletTransaction $transaction): ?WalletTransaction
    {
        $WalletTransactionModel = ModelsWalletTransaction::Create(
            // ['id' => $transaction->getId()],
            [
                'wallet_id' => $transaction->getWalletId(),
                'amount' => $transaction->getMoney()->getAmount(),
                'type' => $transaction->getType()->getValue(),
            ]
        );

        return $transaction->reconstitute($WalletTransactionModel->toArray());
    }
    public function findById(int $id): ?WalletTransaction
    {
        $modelTransaction = ModelsWalletTransaction::find($id);
        return $modelTransaction ? WalletTransaction::reconstitute($modelTransaction->toArray()) : null;
    }
}
