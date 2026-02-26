<?php
namespace src\OrderContext\Domain\Exceptions ;

use Exception;
class OrderNotFoundException extends Exception{
    protected $message = 'Order Not Found!';
    protected $code = 404 ;
}
