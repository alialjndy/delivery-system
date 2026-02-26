<?php
namespace src\DriverContext\Application\Actions;

use Illuminate\Support\Facades\Log;
use src\DriverContext\Application\DTOs\DriverReadModel;
use src\DriverContext\Domain\Entities\Driver as DriverEntity;
use src\DriverContext\Domain\Repositories\DriverRepositoryInterface;
use src\DriverContext\Domain\ValueObjects\NationalNumber;
use src\DriverContext\Domain\ValueObjects\PhoneNumber;
use src\UserContext\Domain\Exceptions\BaseDomainException;

class CreateDriver{
    public function __construct(
        private DriverRepositoryInterface $driverRepositoryInterface,
    )
    {}
    public function execute(array $data){
        try{
            $driver = DriverEntity::create(
                $data['name'],
                new PhoneNumber($data['phone_number']),
                $data['address'],
                new NationalNumber($data['national_number']),
                $data['user_id'],
            );

            $savedDriver = $this->driverRepositoryInterface->save($driver);

            return new DriverReadModel(
                $savedDriver->getId(),
                $savedDriver->getUserId(),
                $savedDriver->getName(),
                $savedDriver->getPhoneNumber()->getNumber(),
                $savedDriver->getAddress(),
                $savedDriver->getNationalNumber()->getNumber(),
                $savedDriver->getStatus()->value,
            );
        }catch(\Throwable $e){
            Log::error('Error creating driver: ' . $e->getMessage());
            throw $e;
        }
    }
}
