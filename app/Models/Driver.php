<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory ;
    protected $fillable = [
        'name',
        'user_id',
        'phone_number',
        'address',
        'status',
        'national_number',
        'fcm_token',
    ];
    public function orders(){
        return $this->hasMany(Order::class , 'driver_id');
    }
    public function wallet(){
        return $this->hasOne(Wallet::class , 'driver_id');
    }
    public function user(){
        return $this->belongsTo(User::class , 'user_id');
    }
}
