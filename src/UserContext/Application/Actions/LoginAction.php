<?php
namespace src\UserContext\Application\Actions;

use App\Traits\Response;
use Illuminate\Support\Facades\Log;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;
use src\UserContext\Domain\Exceptions\BaseDomainException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
class LoginAction{
    use Response ;
    public function execute(array $credentials){
        try{
            $token = FacadesJWTAuth::attempt($credentials);
            if(!$token){
                return $this->error("Invalid credentials" , 401);
            }

            $user = JWTAuth::user();
            return $this->success([
                'token' => $token,
                'token_type' => 'Bearer',
                'user_role' => $user->getRoleNames(),
            ] , "User logged in successfully" , 200);
        }catch(BaseDomainException $e){
            Log::error('Error When Login User '.$e->getMessage());

            throw new BaseDomainException();
        }
    }
}
