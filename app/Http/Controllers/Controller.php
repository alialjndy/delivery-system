<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller
{
    use AuthorizesRequests;
    public function success($data = null , $message = "Done Succesfully!" , $code = 200){
        return response()->json([
            'status' => 'success',
            "data" => $data,
            "message" => $message,
        ] , $code);
    }
    public function failed($errors = null , $message = "Error Occurred!" , $code = 500){
        return response()->json([
            "status" => "error",
            "errors" => $errors,
            "message" => $message,
        ] , $code);
    }
    public function paginated($paginator ,$resourceClass = null , $code = 200){
        $items = is_null($resourceClass) ? $paginator->items() : $resourceClass::collection($paginator->items());
        return response()->json([
            "data" => $items,
            "pagination" => [
                "current_page" => $paginator->currentPage(),
                "last_page" => $paginator->lastPage(),
                "per_page" => $paginator->perPage(),
                "total" => $paginator->total(),
            ],
        ] , $code);
    }
}
