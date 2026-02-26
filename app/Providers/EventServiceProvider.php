<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use src\OrderContext\Application\Listeners\UpdateOrderOnPaymentSuccess;
use src\PaymentContext\Domain\Events\PaymentSucceeded;

class EventServiceProvider extends ServiceProvider
{
    // protected $listen = [
    //     PaymentSucceeded::class => [
    //         UpdateOrderOnPaymentSuccess::class,
    //     ],
    // ];
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
