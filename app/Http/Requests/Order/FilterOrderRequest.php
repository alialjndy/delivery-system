<?php

namespace App\Http\Requests\Order;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class FilterOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = JWTAuth::user();
        return $user && $user->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status'   => 'nullable|in:created,confirmed,cancelled,in_progress,delivered',
            'min_cost' => 'nullable|numeric|min:0',
            'max_cost' => 'nullable|numeric|greater_than_or_equal:min_cost',
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
    public function attributes(){
        return [
            'status' => 'order status',
            'min_cost' => 'minimum cost',
            'max_cost' => 'maximum cost',
        ];
    }
    public function messages(){
        return [
            'status.in'                         => 'The :attribute must be one of the following: created, confirmed, cancelled, in_progress, delivered.',

            'min_cost.numeric'                  => 'The :attribute must be a number.',
            'min_cost.min'                      => 'The :attribute must be at least :min.',
            'max_cost.numeric'                  => 'The :attribute must be a number.',
            'max_cost.greater_than_or_equal'    => 'The :attribute must be greater than or equal to min_cost.',
        ];
    }
}
