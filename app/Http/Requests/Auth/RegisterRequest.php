<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required','string','confirmed' , Password::min(8)->mixedCase()->numbers()->symbols()->max(400)],
        ];
    }
    public function passedValidation()
    {
        return $this->merge([
            'name' => strtolower($this->name),
            'email' => strtolower($this->email),
       ]);
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
            'name' => 'Full Name',
            'email' => 'Email Address',
            'password' => 'Password',
        ];
    }
    public function messages(){
        return [
            'name.required' => 'The :attribute is required.',
            'name.string' => 'The :attribute must be a string.',
            'name.max' => 'The :attribute may not be greater than :max characters.',

            'email.required' => 'The :attribute is required.',
            'email.email' => 'The :attribute must be a valid email address.',
            'email.unique' => 'The :attribute has already been taken.',

            'password.required' => 'The :attribute is required.',
            'password.min' => 'The :attribute must be at least :min characters.',
            'password.max' => 'The :attribute may not be greater than :max characters.',
            'password.mixedCase' => 'The :attribute must contain both uppercase and lowercase letters.',
            'password.numbers' => 'The :attribute must contain at least one number.',
            'password.symbols' => 'The :attribute must contain at least one symbol.',
        ];
    }
}
