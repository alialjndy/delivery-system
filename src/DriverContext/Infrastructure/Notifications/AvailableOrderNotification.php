<?php

namespace src\DriverContext\Infrastructure\Notifications;

use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;

class AvailableOrderNotification extends Notification
{
    public function __construct(
        private array $orderDetails
    ) {}

    public function via()
    {
        return [FcmChannel::class];
    }

    public function toFirebase($notifiable)
    {
        return FcmMessage::create()
            ->setData([
                'order_id' => (string) $this->orderDetails['order_id'],
                
                'pickup_latitude'  => (string) $this->orderDetails['pickup_lat'],
                'pickup_longitude' => (string) $this->orderDetails['pickup_lon'],

                'dropoff_latitude'  => (string) $this->orderDetails['dropoff_lat'],
                'dropoff_longitude' => (string) $this->orderDetails['dropoff_lon'],

                'earnings' => (string) $this->orderDetails['driver_earnings'],
            ])
            ->setNotification(FirebaseNotification::create('New order available', 'A new order is available for you.'));
    }
}
