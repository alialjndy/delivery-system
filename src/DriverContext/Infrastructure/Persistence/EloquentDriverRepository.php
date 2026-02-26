<?php
namespace src\DriverContext\Infrastructure\Persistence;

use App\Models\Driver as ModelsDriver;
use Brick\Math\BigInteger;
use src\DriverContext\Domain\Entities\Driver;
use src\DriverContext\Domain\Repositories\DriverRepositoryInterface;
use src\DriverContext\Domain\ValueObjects\DriverStatus;
use src\DriverContext\Domain\ValueObjects\NationalNumber;
use src\DriverContext\Domain\ValueObjects\PhoneNumber;
use src\Shared\Domain\Events\DriverRegistered;

class EloquentDriverRepository implements DriverRepositoryInterface {
    // Implementation of the repository methods using Eloquent ORM
    public function save(Driver $driver): Driver
    {
        $driverModel = ModelsDriver::updateOrCreate([
            'id' => $driver->getId(),
        ], [
            'name' => $driver->getName(),
            'user_id' => $driver->getUserId(),
            'phone_number' => $driver->getPhoneNumber()->getNumber(),
            'address' => $driver->getAddress(),
            'national_number' => $driver->getNationalNumber()->getNumber(),
            'status' => $driver->getStatus()->value ?? DriverStatus::ACTIVE,
        ]);

        if($driverModel->wasRecentlyCreated){
            $driverModel->user->syncRoles('driver');
            $driver->addEvent(new DriverRegistered($driverModel->id));
        }

        foreach($driver->pullEvents() as $event){
            event($event);
        }

        return Driver::reconstitute($driverModel->toArray());
    }
    public function findByNationalNumber(NationalNumber $id): ?Driver {
        $driver = ModelsDriver::where('national_number', $id->getNumber())->first();
        return $driver ? Driver::reconstitute($driver->toArray()) : null ;
    }

    public function findByPhoneNumber(PhoneNumber $phoneNumber): ?Driver {
        $driver = ModelsDriver::where('phone_number', $phoneNumber->getNumber())->first();
        return $driver ? Driver::reconstitute($driver->toArray()) : null ;
    }
    public function findById(int $id): ?Driver {
        $driver = ModelsDriver::find($id);
        return $driver ? Driver::reconstitute($driver->toArray()) : null ;
    }
    public function findByUserId(int $userId): ?Driver {
        $driver = ModelsDriver::where('user_id', $userId)->first();
        return $driver ? Driver::reconstitute($driver->toArray()) : null ;
    }
    public function deleteDriver(Driver $driver): void {
        ModelsDriver::where('id', $driver->getId())->delete();
    }

}
