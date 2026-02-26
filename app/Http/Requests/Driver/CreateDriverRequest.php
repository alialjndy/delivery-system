<?php

namespace App\Http\Requests\Driver;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
class CreateDriverRequest extends FormRequest
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
            'name'              => 'required|string|max:255|min:5',
            'user_id'           => 'required|exists:users,id',
            'phone_number'      => 'required|string|unique:drivers,phone_number',
            'address'           => 'required|string|max:500',
            'national_number'   => 'required|string|unique:drivers,national_number',
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
            'phone_number'      => 'Phone Number',
            'address'           => 'Address',
            'national_number'   => 'National Number',
            'user_id'           => 'User ID',
        ];
    }
    public function messages(){
        return [
            'name.required' => 'The :attribute is required.',
            'name.string'   => 'The :attribute must be a string.',
            'name.max'      => 'The :attribute may not be greater than :max characters.',
            'name.min'      => 'The :attribute must be at least :min characters.',

            'phone_number.required' => 'The :attribute is required.',
            'phone_number.string'   => 'The :attribute must be a string.',
            'phone_number.unique'   => 'The :attribute has already been taken.',

            'address.required'  => 'The :attribute is required.',
            'address.string'    => 'The :attribute must be a string.',
            'address.max'       => 'The :attribute may not be greater than :max characters.',

            'national_number.required'  => 'The :attribute is required.',
            'national_number.string'    => 'The :attribute must be a string.',
            'national_number.unique'    => 'The :attribute has already been taken.',

            'user_id.required' => 'The :attribute is required.',
            'user_id.exists'   => 'The selected :attribute is invalid.',
            'user_id.integer'  => 'The :attribute must be an integer.',
        ];
    }
}
