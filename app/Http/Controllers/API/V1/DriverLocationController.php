<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\DriverLocation\TrackDriverLocationRequest;
use Illuminate\Http\Request;
use src\TrackingContext\Application\Actions\UpdateDriverLocation;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
class DriverLocationController extends Controller
{
    public function __construct(
        private UpdateDriverLocation $updateDriverLocationAction,
    ){}
    public function update(TrackDriverLocationRequest $request){
        $driverId = JWTAuth::user()->id ;

        $this->updateDriverLocationAction->execute($request->validated() + array_merge(['driver_id' => $driverId]));
        return self::success();
    }
}
