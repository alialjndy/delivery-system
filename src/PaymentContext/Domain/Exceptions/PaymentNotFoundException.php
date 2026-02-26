<?php
namespace src\PaymentContext\Domain\Exceptions ;

use Exception;
class PaymentNotFoundException extends Exception{
    public $message = "Payment Not Found";
    public $code = 404 ;
}
