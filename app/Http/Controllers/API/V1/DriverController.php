<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Driver\CreateDriverRequest;
use App\Http\Requests\Driver\FilterDriverRequest;
use App\Http\Requests\Driver\UpdateDriverRequest;
use Illuminate\Support\Facades\Log;
use src\DriverContext\Application\Actions\CreateDriver;
use src\DriverContext\Application\Actions\DeleteDriverAction;
use src\DriverContext\Application\Actions\UpdateDriver;
use src\DriverContext\Application\DTOs\DriverFilters;
use src\DriverContext\Application\Queries\GetDriverProfileQueryInterface;
use src\DriverContext\Application\Queries\GetDriversQueryInterface;

class DriverController extends Controller
{
    public function __construct(
        protected CreateDriver $createDriverAction,
        protected UpdateDriver $updateDriverAction,
        protected GetDriversQueryInterface $getDriversQueryInterface,
        protected GetDriverProfileQueryInterface $getDriverProfileQueryInterface,
        protected DeleteDriverAction $deleteDriverAction,
    )
    {}
    /**
     * Display a listing of the resource.
     */
    public function index(FilterDriverRequest $request)
    {
        $allDrivers = $this->getDriversQueryInterface->execute(new DriverFilters(
            $request->validated()['name'] ?? null,
            $request->validated()['status'] ?? null,
            $request->validated()['national_number'] ?? null,
            // $request->validated()['minBalance'] ?? null,
            // $request->validated()['maxBalance'] ?? null,
        ));
        return self::success($allDrivers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateDriverRequest $request)
    {
        $driver = $this->createDriverAction->execute($request->validated());
        return self::success($driver , "Done Successfully!" , 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $driverId)
    {
        $driverProfile = $this->getDriverProfileQueryInterface->execute($driverId);
        return self::success($driverProfile);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDriverRequest $request, int $driverId)
    {
        $driver = $this->updateDriverAction->execute($request->validated() , $driverId);
        return self::success($driver);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $driverId)
    {
        $this->deleteDriverAction->execute($driverId);
        return self::success();
    }
}
