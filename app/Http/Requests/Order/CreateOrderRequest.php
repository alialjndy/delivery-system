<?php

namespace App\Http\Requests\Order;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = JWTAuth::user();
        return ($user && $user->hasRole('customer')) ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pickup_lat'    => 'required|numeric|min:-90|max:90',
            'pickup_lng'    => 'required|numeric|min:-180|max:180',
            'dropoff_lat'   => 'required|numeric|min:-90|max:90',
            'dropoff_lng'   => 'required|numeric|min:-180|max:180',
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
            'pickup_lat'    => 'Pickup Latitude',
            'pickup_lng'    => 'Pickup Longitude',
            'dropoff_lat'   => 'Dropoff Latitude',
            'dropoff_lng'   => 'Dropoff Longitude',
        ];
    }

    public function messages()
    {
        return [
            'pickup_lat.required' => 'The :attribute is required.',
            'pickup_lat.numeric'  => 'The :attribute must be an numeric.',
            'pickup_lat.min'      => 'The :attribute must be at least :min.',
            'pickup_lat.max'      => 'The :attribute may not be greater than :max.',

            'pickup_lng.required' => 'The :attribute is required.',
            'pickup_lng.numeric'  => 'The :attribute must be an numeric.',
            'pickup_lng.min'      => 'The :attribute must be at least :min.',
            'pickup_lng.max'      => 'The :attribute may not be greater than :max.',

            'dropoff_lat.required' => 'The :attribute is required.',
            'dropoff_lat.numeric'  => 'The :attribute must be an numeric.',
            'dropoff_lat.min'      => 'The :attribute must be at least :min.',
            'dropoff_lat.max'      => 'The :attribute may not be greater than :max.',

            'dropoff_lng.required' => 'The :attribute is required.',
            'dropoff_lng.numeric'  => 'The :attribute must be an numeric.',
            'dropoff_lng.min'      => 'The :attribute must be at least :min.',
            'dropoff_lng.max'      => 'The :attribute may not be greater than :max.',
        ];
    }
}
