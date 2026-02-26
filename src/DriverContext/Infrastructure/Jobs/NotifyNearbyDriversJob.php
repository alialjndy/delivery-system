<?php
namespace src\DriverContext\Infrastructure\Jobs;

use App\Models\Driver;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use src\DriverContext\Infrastructure\Notifications\AvailableOrderNotification;

class NotifyNearbyDriversJob implements ShouldQueue{
    use Dispatchable , InteractsWithQueue , SerializesModels;
    public function __construct(
        private array $driverIds ,
        private array $orderDetails
    ){}
    public function handle()
    {
        $tokens = Driver::whereIn('id', $this->driverIds)
            ->whereNotNull('fcm_token')
            ->pluck('fcm_token')
            ->toArray();

        #TODO
        // For Debug Purpose :
        if(empty($tokens)){
            Log::info("No drivers found with valid FCM tokens for order ID: {$this->orderDetails['order_id']}");
        }

        foreach($tokens as $token){
            Notification::route('firebase', $token)
                ->notify(new AvailableOrderNotification($this->orderDetails));

            Log::info("Notification sent to driver with token: $token for order ID: {$this->orderDetails['order_id']}");
        }
    }
}
