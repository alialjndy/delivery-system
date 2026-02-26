<?php

use App\Http\Controllers\API\V1\Auth\SocialController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Socialite;

Route::get('/', function () {
    return view('welcome');
});

Route::get('auth/redirect/{driver}', [SocialController::class , 'handleRedirect']);

Route::get('auth/{driver}/callback',[SocialController::class,'handleUser']);
