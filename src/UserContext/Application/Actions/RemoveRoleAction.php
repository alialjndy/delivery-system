<?php
namespace src\UserContext\Application\Actions;

use Exception;
use src\UserContext\Application\DTOs\UserReadModel;
use src\UserContext\Domain\Exceptions\UserNotFoundException;
use Src\UserContext\Domain\ValueObjects\Role;
use src\UserContext\Infrastructure\Persistence\EloquentUserRepository;
use Throwable;

class RemoveRoleAction {
    public function __construct(private EloquentUserRepository $eloquentUserRepository){}
    public function execute(int $userId , int $adminId ){
        try{
            $user = $this->eloquentUserRepository->findById($userId);
            $admin = $this->eloquentUserRepository->findById($adminId);

            if(!$user || !$admin){
                throw new UserNotFoundException('User not found.');
            }

            if($user->getRole()->isCustomer()){
                throw new Exception('User already has the default role.');
            }

            if(!$admin->getRole()->isAdmin()){
                throw new Exception('Only admins can remove roles.');
            }

            $user->assignDefaultRole(Role::CUSTOMER);

            $savedUser = $this->eloquentUserRepository->save($user);

            return new UserReadModel(
                $savedUser->getId(),
                $savedUser->getName(),
                $savedUser->getEmail(),
                $savedUser->getRole()->getValue()
            );
        }catch(Throwable $e){
            throw $e;
        }
    }
}
