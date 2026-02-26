<?php
namespace src\DriverContext\Domain\Exceptions;

use Exception;
class DriverNotFoundException extends Exception{
    protected $message = 'Driver not found.';
    protected $code = 404;
}
