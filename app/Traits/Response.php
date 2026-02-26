<?php
namespace App\Traits ;
trait Response {
    public function success($data = null, $message = "Done Succesfully!", $code = 200){
        return [
            'status' => 'success',
            'message' => $message,
            'data' => $data,
            'code' => $code
        ];
    }

    public function error($message = "Error Occurred", $code = 500, $errors = null){
        return [
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
            'code' => $code
        ];
    }
}
