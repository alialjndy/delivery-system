<?php
namespace src\UserContext\Application\Actions;

use App\Traits\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use src\UserContext\Domain\Exceptions\BaseDomainException;

class LogoutAction{
    use Response ;
    public function execute(){
        try{
            Auth::logout();
        }catch(BaseDomainException $e){
            Log::error('Error When Logout User '.$e->getMessage());
            return $this->error("Failed to logout user" , 500);
        }
    }
}
