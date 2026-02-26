<?php
namespace src\UserContext\Infrastructure\Persistence;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use src\Shared\Domain\Events\UserRegisterd;
use src\UserContext\Domain\Entities\User as UserEntity;
use src\UserContext\Domain\Repositories\UserRepositoryInterface;
use src\UserContext\Domain\ValueObjects\Email;

class EloquentUserRepository implements UserRepositoryInterface{
    /**
     * Save user entity to database
     * @param UserEntity $userEntity
     * @return UserEntity
     */
    public function save(UserEntity $userEntity){
        $user = User::updateOrCreate(
            ['email'=> $userEntity->getEmail()],
            [
                'name' => $userEntity->getName(),
                'email' => $userEntity->getEmail(),
                'password' => $userEntity->getPassword()?->getHashedValue(),
                'provider' => $userEntity->getProvider(),
                'email_verified_at' => $userEntity->getEmailVerifiedAt(),
            ]
        );
        $roleName = $userEntity->getRole()->getValue();

        // Sync user role from domain entity
        $user->syncRoles($roleName);

        // Rebuild fresh domain entity from persisted data
        return UserEntity::reconstitute($user->toArray() + ['role' => $roleName]);
    }
    /**
     * findByEmail
     * @param Email $email
     * @return UserEntity|null
     */
    public function findByEmail(Email $email): ?UserEntity{
        $user = User::where('email', $email->getEmail())->first();
        $userRole = $user->getRoleNames();

        return $user? UserEntity::reconstitute($user->toArray() + ['role' => $userRole[0] ?? 'customer']) : null;
    }
    /**
     * findByProvider
     * @param string $provider
     * @return UserEntity|null
     */
    public function findByProvider(string $provider): ?UserEntity{
        $user = User::where('provider', $provider)->first();

        return $user ? UserEntity::reconstitute($user->toArray() + ['role' => $user->getRoleNames()[0] ?? 'customer']) : null ;
    }
    /**
     * Get user by ID
     * @param int $id
     * @return UserEntity|null
     */
    public function findById(int $id): UserEntity
    {
        $user = User::find($id);
        return $user? UserEntity::reconstitute($user->toArray() + ['role' => $user->getRoleNames()[0] ?? 'customer']) : null;
    }
}
