<?php
namespace src\UserContext\Application\DTOs;
class UserReadModel {
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $role,
    ){}
}
