<?php
namespace src\UserContext\Domain\ValueObjects;
class Email{
    public function __construct(private string $email){
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new \InvalidArgumentException("Invalid email format: $email");
        }
    }
    public function getEmail(): string{
        return $this->email;
    }
}
