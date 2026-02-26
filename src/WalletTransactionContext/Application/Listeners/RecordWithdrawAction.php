<?php
namespace src\WalletTransactionContext\Application\Listeners;

use src\Shared\Domain\ValueObjects\Money;
use src\WalletContext\Domain\Events\WalletDebitedEvent;
use src\WalletTransactionContext\Domain\Entity\WalletTransaction;
use src\WalletTransactionContext\Domain\Repositories\WalletTransactionRepositoryInterface;
use src\WalletTransactionContext\Domain\ValueObjects\WalletTransactionType;

class RecordWithdrawAction{
    public function __construct(
        private WalletTransactionRepositoryInterface $walletTransactionRepositoryInterface,
    ){}

    public function handle(WalletDebitedEvent $event)
    {
        $walletTransaction = WalletTransaction::create(
            $event->walletId ,
            new Money($event->amount) ,
            WalletTransactionType::WITHDRAW,
        );
        $this->walletTransactionRepositoryInterface->save($walletTransaction);
    }
}
