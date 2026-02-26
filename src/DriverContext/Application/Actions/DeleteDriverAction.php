<?php
namespace src\DriverContext\Application\Actions;

use Illuminate\Support\Facades\Log;
use src\DriverContext\Domain\Exceptions\DriverNotFoundException;
use src\DriverContext\Domain\Repositories\DriverRepositoryInterface;
use src\UserContext\Domain\Exceptions\BaseDomainException;

class DeleteDriverAction{
    public function __construct(
        private DriverRepositoryInterface $driverRepository,
        )
    {}
    public function execute(int $driverId): void {
        try{
            // Retrieve the driver entity
            $driver = $this->driverRepository->findById($driverId);

            if(!$driver){
                throw new DriverNotFoundException();
            }

            $this->driverRepository->deleteDriver($driver);
        }catch(BaseDomainException $e){
            Log::error('Error deleting driver: ' . $e->getMessage());
            throw $e;
        }
    }
}
