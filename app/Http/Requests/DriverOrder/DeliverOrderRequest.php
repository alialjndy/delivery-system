<?php

namespace App\Http\Requests\DriverOrder;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class DeliverOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = JWTAuth::user();
        return $user && $user->hasRole('driver');

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'order_id' => 'required|integer|exists:orders,id',
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
            'order_id' => 'Order ID',
        ];
    }
    public function messages()
    {
        return [
            'order_id.required' => 'The :attribute is required.',
            'order_id.integer'  => 'The :attribute must be an integer.',
            'order_id.exists'   => 'The specified :attribute does not exist.',
        ];
    }
}
