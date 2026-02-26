<?php

namespace App\Http\Requests\Role;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
class AssignRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = JWTAuth::user();
        return $user && $user->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'role' => 'required|string|exists:roles,name',
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
            'user_id' => 'User ID',
            'role' => 'Role',
        ];
    }
    public function messages(){
        return [
            'user_id.required' => 'The :attribute is required.',
            'user_id.integer'  => 'The :attribute must be an integer.',
            'user_id.exists'   => 'The selected :attribute does not exist.',

            'role.required' => 'The :attribute is required.',
            'role.string'   => 'The :attribute must be a string.',
            'role.exists'   => 'The selected :attribute does not exist.',
        ];
    }
}
