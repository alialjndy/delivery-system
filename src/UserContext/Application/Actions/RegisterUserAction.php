<?php
namespace src\UserContext\Application\Actions;

use App\Traits\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use src\UserContext\Domain\Entities\User;
use src\UserContext\Domain\Exceptions\BaseDomainException;
use src\UserContext\Domain\Repositories\UserRepositoryInterface;
use src\UserContext\Domain\ValueObjects\Email;
use src\UserContext\Domain\ValueObjects\Password;

class RegisterUserAction{
    public function __construct(private UserRepositoryInterface $repository){}
    public function execute(array $data){
        try{
            return DB::transaction(function() use ($data){
            // create Value Objects
            $user = User::register(
                $data['name'],
                new Email(($data['email'])),
                new Password($data['password'])
            );

            // save user in DB.
            $registerdUser = $this->repository->save($user);

            return $registerdUser ;
            });
        }catch(BaseDomainException $e){
            Log::error("error when register user " . $e->getMessage());
            throw new BaseDomainException();
        }
    }
}
