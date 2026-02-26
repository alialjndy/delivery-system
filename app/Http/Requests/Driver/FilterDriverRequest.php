<?php

namespace App\Http\Requests\Driver;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
class FilterDriverRequest extends FormRequest
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
            'name'              => 'nullable|string',
            'status'            => 'nullable|in:busy,available,offline',
            'national_number'   => 'nullable|string',
            'minBalance'        => 'nullable|numeric|min:0',
            'maxBalance'        => 'nullable|numeric|min:0',
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
            'name'              => 'Driver Name',
            'status'            => 'Driver Status',
            'national_number'   => 'National Number',
            'minBalance'        => 'Minimum Balance',
            'maxBalance'        => 'Maximum Balance',
        ];
    }
    public function messages(){
        return [
            'name.string'   => 'The :attribute must be a string.',

            'status.in'     => 'The selected :attribute is invalid. Allowed values are active, inactive, suspended.',

            'national_number.string'   => 'The :attribute must be a string.',

            'minBalance.numeric'  => 'The :attribute must be a number.',
            'minBalance.min'      => 'The :attribute must be at least :min.',

            'maxBalance.numeric'  => 'The :attribute must be a number.',
            'maxBalance.min'      => 'The :attribute must be at least :min.',
        ];
    }
}
