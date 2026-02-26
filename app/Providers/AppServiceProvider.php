<?php

namespace App\Providers;

use Clockwork\Support\Laravel\ClockworkServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use src\DriverContext\Application\Listeners\NotifyNearbyDriver;
use src\DriverContext\Application\Queries\GetDriverProfileQueryInterface;
use src\DriverContext\Application\Queries\GetDriversQueryInterface;
use src\DriverContext\Domain\Repositories\DriverLocationRepositoryInterface;
use src\DriverContext\Domain\Repositories\DriverRepositoryInterface;
use src\DriverContext\Infrastructure\Persistence\EloquentDriverRepository;
use src\DriverContext\Infrastructure\Persistence\Queries\EloquentGetDriverProfileQuery;
use src\DriverContext\Infrastructure\Persistence\Queries\EloquentGetDriversQuery;
use src\DriverContext\Infrastructure\Persistence\RedisDriverLocationRepository as PersistenceRedisDriverLocationRepository;
use src\OrderContext\Application\Actions\AcceptOrder;
use src\OrderContext\Application\Listeners\UpdateOrderOnPaymentSuccess;
use src\OrderContext\Application\Queries\GetAllOrdersQueryInterface;
use src\OrderContext\Application\Queries\GetOrderDetailsQueryInterface;
use src\OrderContext\Domain\Repositories\OrderRepositoryInterface;
use src\OrderContext\Infrastructure\Persistence\EloquentOrderRepository;
use src\OrderContext\Infrastructure\Persistence\OrderDispatchQuery;
use src\OrderContext\Infrastructure\Persistence\Queries\EloquentGetAllOrdersQuery;
use src\OrderContext\Infrastructure\Persistence\Queries\EloquentGetOrderDetailsQuery;
use src\PaymentContext\Application\Queries\GetAllPaymentsInterface;
use src\PaymentContext\Application\Queries\GetPaymentDetailsInterface;
use src\PaymentContext\Domain\Contracts\PaymentGateway;
use src\PaymentContext\Domain\Events\PaymentSucceeded;
use src\PaymentContext\Domain\Repositories\PaymentRepositoryInterface;
use src\PaymentContext\Infrastructure\Gateways\StripePaymentGateway;
use src\PaymentContext\Infrastructure\Persistence\EloquentPaymentRepository;
use src\PaymentContext\Infrastructure\Persistence\Queries\EloquentGetAllPaymentsQuery;
use src\PaymentContext\Infrastructure\Persistence\Queries\EloquentGetPaymentDetails;
use src\Shared\Domain\Events\DriverRegistered;
use src\Shared\Domain\Events\OrderDeliveredEvent;
use src\Shared\Domain\Events\UserRegisterd;
use src\Shared\Domain\Port\OrderDispatchQueryInterface;
use src\TrackingContext\Domain\Repositories\TrackingRepositoryInterface;
use src\TrackingContext\Infrastructure\Persistence\RedisDriverLocationRepository;
use src\UserContext\Domain\Repositories\UserRepositoryInterface;
use src\UserContext\Infrastructure\Persistence\EloquentUserRepository;
use src\WalletContext\Application\Listeners\CreateWalletOnDriverRegisteration;
use src\WalletContext\Application\Listeners\CreateWalletOnUserRegistration;
use src\WalletContext\Application\Listeners\CreditDriverWalletOnOrderDelivered;
use src\WalletContext\Application\Queries\GetAllWalletsQueryInterface;
use src\WalletContext\Application\Queries\GetWalletDetailsQueryInterface;
use src\WalletContext\Domain\Events\WalletCreditedEvent;
use src\WalletContext\Domain\Events\WalletDebitedEvent;
use src\WalletContext\Domain\Repositories\WalletRepositoryInterface;
use src\WalletContext\Infrastructure\Persistence\EloquentWalletRepository;
use src\WalletContext\Infrastructure\Persistence\Queries\EloquentGetAllWalletsQuery;
use src\WalletContext\Infrastructure\Persistence\Queries\EloquentGetWalletDetailsQuery;
use src\WalletTransactionContext\Application\Listeners\RecordDepositAction;
use src\WalletTransactionContext\Application\Listeners\RecordDriverEarningOnOrderDelivered;
use src\WalletTransactionContext\Application\Listeners\RecordWithdrawAction;
use src\WalletTransactionContext\Application\Queries\GetAllWalletTransactionsQueryInterface;
use src\WalletTransactionContext\Application\Queries\GetWalletTransactionQueryInerface;
use src\WalletTransactionContext\Domain\Repositories\WalletTransactionRepositoryInterface;
use src\WalletTransactionContext\Infrastructure\Persistence\EloquentWalletTransactionRepository;
use src\WalletTransactionContext\Infrastructure\Persistence\Queries\EloquentGetAllWalletTransactionsQuery;
use src\WalletTransactionContext\Infrastructure\Persistence\Queries\EloquentGetWalletTransactionQuery;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        ClockworkServiceProvider::class;

        $this->app->bind(UserRepositoryInterface::class , EloquentUserRepository::class);
        $this->app->bind(DriverRepositoryInterface::class , EloquentDriverRepository::class);
        $this->app->bind(GetDriversQueryInterface::class , EloquentGetDriversQuery::class);
        $this->app->bind(GetDriverProfileQueryInterface::class , EloquentGetDriverProfileQuery::class);
        $this->app->bind(OrderRepositoryInterface::class , EloquentOrderRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class , EloquentPaymentRepository::class);
        $this->app->bind(PaymentGateway::class , StripePaymentGateway::class);
        $this->app->bind(GetAllPaymentsInterface::class ,  EloquentGetAllPaymentsQuery::class);
        $this->app->bind(GetPaymentDetailsInterface::class ,  EloquentGetPaymentDetails::class);
        $this->app->bind(TrackingRepositoryInterface::class , RedisDriverLocationRepository::class);
        $this->app->bind(DriverLocationRepositoryInterface::class , PersistenceRedisDriverLocationRepository::class);
        $this->app->bind(OrderDispatchQueryInterface::class, OrderDispatchQuery::class);
        $this->app->bind(WalletRepositoryInterface::class, EloquentWalletRepository::class);
        $this->app->bind(WalletTransactionRepositoryInterface::class, EloquentWalletTransactionRepository::class);

        $this->app->bind(GetAllOrdersQueryInterface::class, EloquentGetAllOrdersQuery::class);
        $this->app->bind(GetOrderDetailsQueryInterface::class, EloquentGetOrderDetailsQuery::class);

        $this->app->bind(GetAllWalletsQueryInterface::class, EloquentGetAllWalletsQuery::class);
        $this->app->bind(GetWalletDetailsQueryInterface::class, EloquentGetWalletDetailsQuery::class);

        $this->app->bind(GetAllWalletTransactionsQueryInterface::class , EloquentGetAllWalletTransactionsQuery::class);
        $this->app->bind(GetWalletTransactionQueryInerface::class,EloquentGetWalletTransactionQuery::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(PaymentSucceeded::class , UpdateOrderOnPaymentSuccess::class);
        Event::listen(PaymentSucceeded::class , NotifyNearbyDriver::class);
        Event::listen(UserRegisterd::class , CreateWalletOnUserRegistration::class);
        Event::listen(DriverRegistered::class , CreateWalletOnDriverRegisteration::class);
        Event::listen(OrderDeliveredEvent::class , CreditDriverWalletOnOrderDelivered::class);
        Event::listen(WalletDebitedEvent::class , RecordWithdrawAction::class);
        Event::listen(WalletCreditedEvent::class , RecordDepositAction::class);
    }
}
