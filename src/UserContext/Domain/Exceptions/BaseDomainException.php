<?php
namespace src\UserContext\Domain\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class BaseDomainException extends Exception
{
    public function report(){
        Log::error("[" . static::class . "] Error: " . $this->getMessage(), [
            'trace' => $this->getTraceAsString(),
            'context' => 'UserContext'
        ]);
    }
    public function render(){
        return response()->json([
            'status' => 'error',
            'message' => 'Error occurred please try again later.',
        ], 400);
    }
}
