<?php
namespace src\DriverContext\Domain\Entities;

use Brick\Math\BigInteger;
use src\DriverContext\Domain\ValueObjects\DriverStatus;
use src\DriverContext\Domain\ValueObjects\NationalNumber;
use src\DriverContext\Domain\ValueObjects\PhoneNumber;

class Driver{
    private $domainEvents = [];
    public function __construct(
        private readonly ?int $id,
        private string $name,
        private int $userId,
        private PhoneNumber $phoneNumber,
        private ?string $address,
        private NationalNumber $nationalNumber,
        private DriverStatus $status = DriverStatus::ACTIVE,
        private ?string $fcmToken = null,
    ){}

    public static function create(string $name , PhoneNumber $phoneNumber , ?string $address , NationalNumber $nationalNumber , int $user_id): self {
        return new self(
            id: null,
            name: $name,
            userId: $user_id,
            phoneNumber: $phoneNumber,
            address: $address,
            nationalNumber: $nationalNumber,
            status: DriverStatus::ACTIVE,
        );
    }
    public function addEvent(object $event): void{$this->domainEvents[] = $event;}
    public function pullEvents(): array{
        $events = $this->domainEvents;
        $this->domainEvents = [];
        return $events;
    }

    public function changeName(string $newName) {
        $this->name = $newName;
    }
    public function changeStatus(DriverStatus $newStatus) {
        $this->status = $newStatus;
    }
    public function changePhoneNumber(PhoneNumber $newPhoneNumber) {
        $this->phoneNumber = $newPhoneNumber ;
    }
    public function changeAddress(?string $newAddress) {
        $this->address = $newAddress;
    }
    public function setFcmToken(string $fcmToken): void {
        $this->fcmToken = $fcmToken;
    }
    public static function reconstitute(array $data): self{
        return new self(
            id: $data['id'],
            name: $data['name'],
            userId: $data['user_id'],
            phoneNumber: new PhoneNumber($data['phone_number']),
            address: $data['address'],
            nationalNumber: new NationalNumber($data['national_number']),
            status: DriverStatus::from($data['status']),
        );
    }
    public function routeNotificationForFcm(){return $this->fcmToken;}
    // Getters and setters can be added here as needed
    public function getId(): ?int {return $this->id;}
    public function getNationalNumber(): NationalNumber {return $this->nationalNumber;}
    public function getName(): string {return $this->name;}
    public function getPhoneNumber(): PhoneNumber {return $this->phoneNumber;}
    public function getAddress(){return $this->address;}
    public function getStatus(){return $this->status ;}
    public function getFcmToken()  {return $this->fcmToken;}
    public function getUserId(): int {return $this->userId;}
}
