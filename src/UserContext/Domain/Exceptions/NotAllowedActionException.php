<?php
namespace src\UserContext\Domain\Exceptions;
use Exception;

class NotAllowedActionException extends Exception
{
    protected $message = 'You are not allowed to perform this action.';
    protected $code = 403;
}
