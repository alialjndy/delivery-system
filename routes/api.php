<?php

use App\Http\Controllers\API\V1\Auth\AuthController;
use App\Http\Controllers\API\V1\DriverController;
use App\Http\Controllers\API\v1\DriverLocationController;
use App\Http\Controllers\API\V1\OrderController;
use App\Http\Controllers\API\V1\PaymentController;
use App\Http\Controllers\API\V1\Role\AdminRoleController;
use App\Http\Controllers\API\v1\StripeWebhookController;
use App\Http\Controllers\API\V1\DriverOrderController;
use App\Http\Controllers\API\V1\WalletController;
use App\Http\Controllers\API\V1\WalletTransactionController;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:api')->prefix('v1')->group(function(){

    Route::controller(AuthController::class)->group(function(){
        Route::post('/auth/register','register')->withoutMiddleware('auth:api');
        Route::post('/auth/login','login')->withoutMiddleware('auth:api');
        Route::post('/auth/logout','logout');
    });
    Route::resource('drivers', DriverController::class);

    Route::post('/roles/assign' , [AdminRoleController::class ,'assignRole']);
    Route::post('/roles/remove' , [AdminRoleController::class ,'removeRole']);

    Route::resource('orders',OrderController::class);
    Route::post('orders/{id}/cancel',[OrderController::class , 'cancel']);

    Route::resource('payments', PaymentController::class);

    Route::post('drivers/tracking',[DriverLocationController::class ,'update']);

    Route::post('driver/order/{order_id}/accept',[DriverOrderController::class,'accept']);
    Route::post('driver/order/{order_id}/deliver',[DriverOrderController::class,'deliver']);

    Route::resource('wallets', WalletController::class);

    Route::resource('wallet-transactions' , WalletTransactionController::class);

    });

    Route::get('/allUsers' ,function (){ // For Debug Issue
    $users = User::all();
    foreach($users as $user){
        echo "ID: " . $user->id . " | Name: " . $user->name . " | Email: " . $user->email . " | Role: " . $user->getRoleNames() . "<br>";
        }
    });

Route::post('stripe/webhook' , [StripeWebhookController::class , 'handleWebhook']);
