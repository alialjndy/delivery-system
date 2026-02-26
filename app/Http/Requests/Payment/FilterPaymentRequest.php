<?php

namespace App\Http\Requests\Payment;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
class FilterPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = JWTAuth::user();
        return ($user && $user->hasRole('admin')) ? true : false ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id'    => 'nullable|string|exists:users,id',
            'status'     => 'nullable|string|in:pending,confirmed,failed',
            'provider'   => 'nullable|string|in:paypal,stripe',
            'min_amount' => 'nullable|numeric|min:0',
            'max_amount' => 'nullable|numeric|min:0,gte:min_amount'
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
    public function attributes(): array{
        return [
            'user_id'    => 'user',
            'status'     => 'payment status',
            'provider'   => 'payment provider',
            'min_amount' => 'minimum amount',
            'max_amount' => 'maximum amount',
        ];
    }
    public function messages(): array {
        return [
            'user_id.integer' => 'User ID must be a valid integer.',
            'user_id.exists'  => 'The selected user does not exist.',

            'status.in' => 'Invalid payment status. Allowed values: pending, confirmed, failed.',

            'provider.in' => 'Invalid payment provider. Allowed values: stripe, paypal.',

            'min_amount.numeric' => 'Minimum amount must be a valid number.',
            'min_amount.min'     => 'Minimum amount cannot be negative.',

            'max_amount.numeric' => 'Maximum amount must be a valid number.',
            'max_amount.min'     => 'Maximum amount cannot be negative.',
            'max_amount.gte'     => 'Maximum amount must be greater than or equal to minimum amount.',
        ];
    }
}
