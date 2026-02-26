<?php

namespace App\Http\Requests\DriverLocation;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TrackDriverLocationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'latitude'  => 'required|numeric|min:-90|max:90',
            'longitude' => 'required|numeric|min:-180|max:180',
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
            'latitude'  => 'latitude',
            'longitude' => 'longitude',
            'driver_id' => 'Driver ID'
        ];
    }
    public function messages()
    {
        return [
            'latitude.required' => 'Latitude is required.',
            'latitude.numeric'  => 'Latitude must be a valid number.',
            'latitude.between'  => 'Latitude must be between -90 and 90.',

            'longitude.required' => 'Longitude is required.',
            'longitude.numeric'  => 'Longitude must be a valid number.',
            'longitude.between'  => 'Longitude must be between -180 and 180.',

            'driver_id.required' => 'Driver ID is required.',
            'driver_id.integer'  => 'Driver ID must be an integer.',
            'driver_id.exists'   => 'The selected driver does not exist.',
        ];
    }
}
