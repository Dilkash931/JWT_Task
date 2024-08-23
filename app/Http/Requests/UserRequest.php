<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->routeIs('password.email')) {
            return $this->resetLinkRules();
        } elseif ($this->routeIs('password.update')) {
            return $this->resetPasswordRules();
        } else {
            return $this->isRegistering() ? $this->registerRules() : $this->loginRules();
        }
    }

    protected function resetLinkRules()
    {
        return [
            'email' => 'required|email|exists:users,email',
        ];
    }

    protected function resetPasswordRules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    protected function isRegistering()
    {
        return $this->routeIs('register') || $this->has('name');
    }

    protected function loginRules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    protected function registerRules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
            'Status' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'The email field is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.exists' => 'This email does not exist in our records.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'token.required' => 'The reset token is required.',
            'name.required' => 'The name field is required.',
            'email.unique' => 'This email is already registered.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        throw new HttpResponseException(response()->json([
            'response' => [
                'message' => 'Validation error',
                'status' => 422,
                'errors' => $errors,
            ]
        ], 422));
    }
}
