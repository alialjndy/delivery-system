<?php
namespace src\UserContext\Application\Actions ;

use Illuminate\Support\Facades\Log;
use src\UserContext\Application\DTOs\UserReadModel;
use src\UserContext\Domain\Exceptions\NotAllowedActionException;
use src\UserContext\Domain\Exceptions\UserNotFoundException;
use src\UserContext\Domain\Repositories\UserRepositoryInterface;
use src\UserContext\Domain\ValueObjects\Role;
use Throwable;

class AssignRoleAction {
    public function __construct(private UserRepositoryInterface $repository)
    {}
    public function execute(string $role , int $userId , int $adminId){
        try{
            $admin = $this->repository->findById($adminId);
            $user = $this->repository->findById($userId);

            if(!$user){
                throw new UserNotFoundException();
            }

            if(!$admin->getRole()->isAdmin()){
                throw new NotAllowedActionException('Only admins can assign roles.');
            }

            $user->assignRole(Role::from($role));

            $savedUser = $this->repository->save($user);

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
