<?php
namespace src\DriverContext\Application\Actions;

use Illuminate\Support\Facades\Log;
use src\DriverContext\Application\DTOs\DriverReadModel;
use src\DriverContext\Domain\Exceptions\DriverNotFoundException;
use src\DriverContext\Domain\ValueObjects\PhoneNumber;
use src\DriverContext\Infrastructure\Persistence\EloquentDriverRepository;
use src\UserContext\Domain\Exceptions\BaseDomainException;

class UpdateDriver{
    public function __construct(private EloquentDriverRepository $eloquentDriverRepository)
    {}
    public function execute(array $data , int $driverId){
        try{
            // Retrieve the driver entity from the repository by ID.
            $driver = $this->eloquentDriverRepository->findById($driverId);

            if(!$driver){
                throw new DriverNotFoundException("Driver not found");
            }

            // Apply changes only to the fields that are provided in the request,
            if(isset($data['name'])){
                $driver->changeName($data['name']);
            }
            if(isset($data['phone_number'])){
                $driver->changePhoneNumber(new PhoneNumber($data['phone_number']));
            }
            if(isset($data['address'])){
                $driver->changeAddress($data['address']);
            }

            $savedDriver = $this->eloquentDriverRepository->save($driver);

            return new DriverReadModel(
                id: $savedDriver->getId(),
                userId: $savedDriver->getUserId(),
                name: $savedDriver->getName(),
                phoneNumber: $savedDriver->getPhoneNumber()->getNumber(),
                address: $savedDriver->getAddress(),
                nationalNumber: $savedDriver->getNationalNumber()->getNumber(),
                status: $savedDriver->getStatus()->value,
            );
        }catch(BaseDomainException $e){
            Log::error('Error updating driver: ' . $e->getMessage());
            throw $e;
        }
    }
}
