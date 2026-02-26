<?php
namespace src\Shared\Domain\Events;
class UserRegisterd{
    public function __construct(
        public readonly int $userId,
    ){}
}
