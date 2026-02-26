<?php
namespace src\DriverContext\Domain\Repositories;

use src\DriverContext\Domain\Entities\Driver;
use src\DriverContext\Domain\ValueObjects\NationalNumber;
use src\DriverContext\Domain\ValueObjects\PhoneNumber;

interface DriverRepositoryInterface {
    public function save(Driver $driver): Driver;
    public function findByNationalNumber(NationalNumber $id) : ?Driver;
    public function findByPhoneNumber(PhoneNumber $phoneNumber) : ?Driver;
    public function findById(int $id) : ?Driver;
    public function deleteDriver(Driver $driver) : void;
    public function findByUserId(int $userId): ?Driver ;
}
