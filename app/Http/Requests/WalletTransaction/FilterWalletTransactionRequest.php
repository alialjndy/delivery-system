<?php

namespace App\Http\Requests\WalletTransaction;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class FilterWalletTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = JWTAuth::user();
        return $user && $user->hasRole('admin');
    }

    public function rules(): array
    {
        return [
            'wallet_id'  => 'nullable|string|exists:wallets,id',
            'min_amount' => 'nullable|numeric|min:0',
            'max_amount' => 'nullable|numeric|min:0|gte:min_amount',
            'type'       => 'nullable|in:deposit,withdraw',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422)
        );
    }

    public function attributes(): array
    {
        return [
            'wallet_id'  => 'wallet',
            'min_amount' => 'minimum amount',
            'max_amount' => 'maximum amount',
            'type'       => 'transaction type',
        ];
    }

    public function messages(): array
    {
        return [
            'max_amount.gte' => 'The maximum amount must be greater than or equal to the minimum amount.',
            'min_amount.numeric' => 'The minimum amount must be a number.',
            'max_amount.numeric' => 'The maximum amount must be a number.',
            'wallet_id.exists' => 'The selected wallet does not exist.',
            'type.in' => 'The transaction type must be either deposit or withdraw.',
        ];
    }
}
