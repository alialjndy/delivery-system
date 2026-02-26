<?php
namespace src\OrderContext\Domain\Entities;

use Brick\Math\BigInteger;
use DomainException;
use src\OrderContext\Domain\ValueObjects\Cordinates;
use src\OrderContext\Domain\ValueObjects\Latitude;
use src\OrderContext\Domain\ValueObjects\Longitude;
use src\OrderContext\Domain\ValueObjects\Money;
use src\OrderContext\Domain\ValueObjects\OrderStatus;
use src\OrderContext\Domain\ValueObjects\Point;
use src\Shared\Domain\Events\OrderAcceptedEvent;
use src\Shared\Domain\Events\OrderDeliveredEvent;

class Order{
    private array $domainEvents = [];
    public function __construct(
        private readonly ?int $id ,
        private int $user_id ,
        private ?int $driver_id ,
        private Point $pickupPoint ,
        private Point $dropoffPoint ,
        private Money $cost = new Money(0),
        private OrderStatus $status = OrderStatus::CREATED ,

    ){}
    public static function create(int $user_id , Point $pickupPoint , Point $dropoffPoint , Money $cost){
        return new self(
            id: null ,
            user_id: $user_id ,
            driver_id: null ,
            pickupPoint: $pickupPoint ,
            dropoffPoint: $dropoffPoint ,
            cost: $cost
        );
    }
    public static function reconstitute(array $data){
        return new self(
            id: $data['id'],
            user_id: $data['user_id'],
            driver_id: $data['driver_id'],
            pickupPoint: new Point(new Latitude($data['pickup_lat']) , new Longitude($data['pickup_lng'])),
            dropoffPoint: new Point(new Latitude($data['dropoff_lat']) , new Longitude($data['dropoff_lng'])),
            status: OrderStatus::from($data['status']),
            cost: new Money($data['cost']),
        );
    }

    public function cancel(){
        if($this->status !== OrderStatus::CREATED){
            throw new DomainException("This order cannot be cancelled because its current status is {$this->getStatus()->value}.");
        }
        $this->status = OrderStatus::CANCELLED ;
    }
    public function confirmed(){
        if($this->status !== OrderStatus::CREATED){
            throw new DomainException("This order cannot be cancelled because its current status is {$this->getStatus()->value}.");
        }

        $this->status = OrderStatus::CONFIRMED ;
    }
    /**
     * Summary of deliveredOrder
     * @throws DomainException
     * @return void
     */
    public function deliveredOrder(int $driver_id){

        // Check if the order is in progress before delivering it
        if($this->status !== OrderStatus::IN_PROGRESS){
            throw new DomainException("This order cannot be delivered because its current status is {$this->getStatus()->value}.");
        }

        // Check if the order is assigned to the driver trying to deliver it
        if($this->driver_id !== $driver_id){
            throw new DomainException("This order cannot be delivered by this driver because it is assigned to another driver.");
        }

        $this->status = OrderStatus::DELIVERED ;

        $this->domainEvents[] = new OrderDeliveredEvent(
            $this->getId(),
            $this->getDriverId() ,
            $this->getCost()->getAmount() * 0.20
        );
    }
    public function assignDriver(int $driver_id){
        if($this->status !== OrderStatus::CONFIRMED){
            throw new DomainException("This order cannot be assigned to a driver because its current status is {$this->getStatus()->value}.");
        }
        if($this->status === OrderStatus::IN_PROGRESS){
            throw new DomainException("This order is not available");
        }
        $this->driver_id = $driver_id ;
        $this->status = OrderStatus::IN_PROGRESS ;
    }
    public function pullEvents(){
        $events = $this->domainEvents ;
        $this->domainEvents = [] ;
        return $events ;
    }

    // Getters
    public function getId(){return $this->id;}
    public function getUserId(){return $this->user_id;}
    public function getDriverId(){return $this->driver_id ;}
    public function getPickupPoint(){return $this->pickupPoint;}
    public function getDropoffPoint(){return $this->dropoffPoint;}
    public function getStatus(){return $this->status ;}
    public function getCost(){return $this->cost;}
}
