<?php

namespace App\Http\Requests\Payment;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
class CreatePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = JWTAuth::user();
        return ($user && $user->hasRole('customer')) ? true : false ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'order_id' => 'required|exists:orders,id',
            'provider' => 'required|string',
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
    public function attributes()
    {
        return [
            'order_id' => 'order',
            'provider' => 'payment provider',
        ];
    }

    public function messages()
    {
        return [
            'order_id.required' => 'Order ID is required.',
            'order_id.integer'  => 'Order ID must be a valid integer.',
            'order_id.exists'   => 'The selected order does not exist.',

            'provider.required' => 'Payment provider is required.',
            'provider.string'   => 'Payment provider must be a string.',
            'provider.in'       => 'The selected payment provider is not supported.',
        ];
    }
}
