<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'driver_id',
        'pickup_lat',
        'pickup_lng',
        'dropoff_lat',
        'dropoff_lng',
        'status',
        'cost',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function driver(){
        return $this->belongsTo(Driver::class);
    }
    public function payment(){
        return $this->hasOne(Payment::class ,'order_id');
    }
}

#TODO حذف هذه التعليمة
// INSERT INTO orders
// (user_id, driver_id, pickup_lat, pickup_lng, dropoff_lat, dropoff_lng, status, cost)
// VALUES
// (1, 2, 24.7136, 46.6753, 24.7743, 46.7386, 'in_progress', 35.50),
// (2, 3, 24.7200, 46.6800, 24.7600, 46.7400, 'delivered', 42.00),
// (3, 4, 24.7000, 46.6700, 24.7500, 46.7300, 'cancelled', 0.00),
// (4, 5, 24.7100, 46.6900, 24.7700, 46.7200, 'in_progress', 28.75),
// (5, 6, 24.7300, 46.6600, 24.7800, 46.7100, 'delivered', 50.00),
// (6, 7, 24.7400, 46.6500, 24.7900, 46.7000, 'in_progress', 33.20),
// (7, 8, 24.7500, 46.6400, 24.8000, 46.6900, 'delivered', 44.10),
// (8, 9, 24.7600, 46.6300, 24.8100, 46.6800, 'cancelled', 0.00),
// (9, 10, 24.7700, 46.6200, 24.8200, 46.6700, 'in_progress', 29.99),
// (10, 11, 24.7800, 46.6100, 24.8300, 46.6600, 'delivered', 60.00),
// (11, 12, 24.7900, 46.6000, 24.8400, 46.6500, 'in_progress', 38.45),
// (12, 11, 24.8000, 46.5900, 24.8500, 46.6400, 'delivered', 47.30),
// (13, 10, 24.8100, 46.5800, 24.8600, 46.6300, 'cancelled', 0.00),
// (14, 9, 24.8200, 46.5700, 24.8700, 46.6200, 'in_progress', 26.80),
// (15, 6, 24.8300, 46.5600, 24.8800, 46.6100, 'delivered', 55.25),
// (16, 7, 24.8400, 46.5500, 24.8900, 46.6000, 'in_progress', 31.40),
// (17, 8, 24.8500, 46.5400, 24.9000, 46.5900, 'delivered', 49.99),
// (18, 9, 24.8600, 46.5300, 24.9100, 46.5800, 'cancelled', 0.00),
// (19, 2, 24.8700, 46.5200, 24.9200, 46.5700, 'in_progress', 34.60),
// (20, 1, 24.8800, 46.5100, 24.9300, 46.5600, 'delivered', 52.75);

// INSERT INTO wallets (driver_id , balance)
// VALUES
// (1, 100.00),
// (2, 150.00),
// (3, 200.00),
// (4, 250.00),
// (5, 300.00),
// (6, 350.00),
// (7, 400.00),
// (8, 450.00),
// (9, 500.00),
// (10, 550.00),
// (11, 600.00);

