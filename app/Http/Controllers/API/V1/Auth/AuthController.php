<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use src\UserContext\Application\Actions\LoginAction;
use src\UserContext\Application\Actions\LogoutAction;
use src\UserContext\Application\Actions\RegisterUserAction;
use src\UserContext\Domain\Exceptions\BaseDomainException;

class AuthController extends Controller
{
    /**
     * Summary of __construct
     */
    public function __construct(
        protected RegisterUserAction $registerUserAction,
        protected LoginAction $loginAction,
        protected LogoutAction $logoutAction,
        ){}

    public function register(RegisterRequest $request){
        $user = $this->registerUserAction->execute($request->validated());
        return self::success(new UserResource($user) , "User registered successfully" , 201);
    }

    public function login(LoginRequest $request){
        $result = $this->loginAction->execute($request->validated());
        return $result['status'] === 'success'
            ?self::success($result['data'] , $result['message'] , $result['code'])
            :self::failed($result['errors'] , $result['message'] , $result['code']);
    }
    public function logout(){
        $this->logoutAction->execute();
        return self::success(null , "User logged out successfully" , 200);
    }
}
