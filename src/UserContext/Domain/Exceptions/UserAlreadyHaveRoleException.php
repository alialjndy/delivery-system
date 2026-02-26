<?php
namespace src\UserContext\Domain\Exceptions;

use Exception;

class UserAlreadyHaveRoleException extends Exception
{
    protected $message = 'User already has the specified role.';
    protected $code = 409;
}
