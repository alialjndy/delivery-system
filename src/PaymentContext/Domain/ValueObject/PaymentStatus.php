<?php
namespace src\PaymentContext\Domain\ValueObject ;
enum PaymentStatus: string{
    case PENDING    = 'pending';
    case SUCCESSFUL  = 'successful';
    case FAILED     = 'failed' ;
}
