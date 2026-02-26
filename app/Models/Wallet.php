<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        'driver_id',
        'balance',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class , 'wallet_id');
    }

}
