<?php

namespace App\Http\Requests\Wallet;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class FilterGetAllWalletsRequest extends FormRequest
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
            'min_cost' => 'minimum cost',
            'max_cost' => 'maximum cost',
        ];
    }
    public function messages(){
        return [
            'max_cost.greater_than_or_equal' => 'The maximum cost must be greater than or equal to the minimum cost.',

            'min_cost.numeric' => 'The minimum cost must be a number.',
            'max_cost.numeric' => 'The maximum cost must be a number.',
        ];
    }
}
