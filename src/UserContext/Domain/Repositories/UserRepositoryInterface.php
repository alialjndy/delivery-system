<?php
namespace src\UserContext\Domain\Repositories;

use src\UserContext\Domain\Entities\User as UserEntity;
use src\UserContext\Domain\ValueObjects\Email;

interface UserRepositoryInterface{
    public function save(UserEntity $user);
    public function findByEmail(Email $email): ?UserEntity  ;
    public function findByProvider(string $provider): ?UserEntity ;
    public function findById(int $id): UserEntity ;
}
