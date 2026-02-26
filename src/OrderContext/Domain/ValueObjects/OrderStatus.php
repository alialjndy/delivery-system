<?php
namespace src\OrderContext\Domain\ValueObjects ;

enum OrderStatus : string{
    case CREATED = 'created' ;
    case CONFIRMED = 'confirmed' ;
    case CANCELLED = 'cancelled' ;
    case IN_PROGRESS = 'in_progress' ;
    case DELIVERED = 'delivered' ;
}
