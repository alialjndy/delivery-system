<?php
namespace Src\UserContext\Domain\ValueObjects;
enum Role: string
{
    case ADMIN = 'admin';
    case CUSTOMER = 'customer';
    case DRIVER = 'driver';

    public function getValue(): string
    {
        return $this->value;
    }
    public function isAdmin(): bool
    {
        return $this === self::ADMIN;
    }
    public function isCustomer(): bool
    {
        return $this === self::CUSTOMER;
    }
}

