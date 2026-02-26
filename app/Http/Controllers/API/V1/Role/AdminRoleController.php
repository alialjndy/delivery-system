<?php

namespace App\Http\Controllers\API\V1\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\AssignRoleRequest;
use App\Http\Requests\Role\RemoveRoleRequest;
use Illuminate\Http\Request;
use src\UserContext\Application\Actions\AssignRoleAction;
use src\UserContext\Application\Actions\RemoveRoleAction;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
class AdminRoleController extends Controller
{
    public function __construct(
        private AssignRoleAction $assignRoleAction,
        private RemoveRoleAction $removeRoleAction,
        ){}
    public function assignRole(AssignRoleRequest $request)
    {
        $user = $this->assignRoleAction->execute(
            $request->validated()['role'],
            $request->validated()['user_id'],
            JWTAuth::user()->id
        );
        return self::success($user , 'Role assigned successfully.');
    }
    public function removeRole(RemoveRoleRequest $request){
        $user = $this->removeRoleAction->execute(
            $request->validated()['user_id'],
            JWTAuth::user()->id,
        );
        return self::success($user , 'Role Removed Successfully.');
    }
}
