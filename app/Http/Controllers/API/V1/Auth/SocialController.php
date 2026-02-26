<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Auth\SocialService;
use Illuminate\Http\Request;
use Laravel\Socialite\Socialite;
use src\UserContext\Application\Actions\SocialAction;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
class SocialController extends Controller
{
    public function __construct(protected SocialAction $socialAction)
    {

    }
    public function handleRedirect($driver){
        return Socialite::driver($driver)->redirect();
    }
    public function handleUser($driver){
        $providerUserData = Socialite::driver($driver)->stateless()->user();

        $userEntity = $this->socialAction->execute($driver , $providerUserData);

        $userModel = User::where('email' , $userEntity->getEmail())->first();
        $token = JWTAuth::fromUser($userModel);

        return self::success(['user' => $userModel,'token' => $token] , 'Done Successfully!' , 200);
    }
}
