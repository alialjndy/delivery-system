<?php
namespace src\UserContext\Application\Actions;

use App\Models\User;
use Dotenv\Parser\Entry;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Socialite;
use src\UserContext\Domain\Entities\User as EntitiesUser;
use src\UserContext\Domain\Exceptions\BaseDomainException;
use src\UserContext\Domain\Repositories\UserRepositoryInterface;
use src\UserContext\Domain\ValueObjects\Email;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
class SocialAction{
    public function __construct(private UserRepositoryInterface $repository)
    {}
    public function execute($provider , $providerUserData){
        try{
            $user = $this->repository->findByProvider($provider);

            if(!$user){
                $user = EntitiesUser::registerWithProvider(
                    $providerUserData['nickname'] ?? $providerUserData['name'],
                    new Email($providerUserData['email']),
                    $provider
                );
                return $this->repository->save($user);
            }

            return $user ;
        }catch(BaseDomainException $e){
            Log::error("Error when handle user from social provider ".$e->getMessage());
            throw new BaseDomainException();
        }
    }
}
