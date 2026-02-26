<?php
namespace src\WalletTransactionContext\Application\Listeners;

use src\Shared\Domain\Events\OrderDeliveredEvent;
use src\Shared\Domain\ValueObjects\Money;
use src\WalletContext\Domain\Events\WalletCreditedEvent;
use src\WalletTransactionContext\Domain\Entity\WalletTransaction;
use src\WalletTransactionContext\Domain\Repositories\WalletTransactionRepositoryInterface;
use src\WalletTransactionContext\Domain\ValueObjects\WalletTransactionType;

class RecordDepositAction
{
    public function __construct(
        private WalletTransactionRepositoryInterface $walletTransactionRepositoryInterface,
    ){}
    public function handle(WalletCreditedEvent $event)
    {
        $walletTransaction = WalletTransaction::create(
            $event->walletId ,
            new Money($event->amount) ,
            WalletTransactionType::DEPOSIT,
        );
        $this->walletTransactionRepositoryInterface->save($walletTransaction);
    }
}
