<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|max:40',
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
            'email' => 'Email Address',
            'password' => 'Password',
        ];
    }
    public function messages(){
        return [
            'email.required' => 'The :attribute is required.',
            'email.email' => 'The :attribute must be a valid email address.',

            'password.required' => 'The :attribute is required.',
            'password.min' => 'The :attribute must be at least :min characters.',
            'password.max' => 'The :attribute may not be greater than :max characters.',
            'password.string' => 'The :attribute must be a string.',

        ];
    }
}
