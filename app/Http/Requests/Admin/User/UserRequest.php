<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'name' => ['required', 'string', 'max:100', Rule::unique('users', 'name')->ignore($this->user)],
            'email' => ['required', 'string', 'max:30', Rule::unique('users', 'email')->ignore($this->user)],
            'password' => ['required', 'string', 'max:100', Rule::unique('users', 'password')->ignore($this->user)],
            'password_confirmation' => ['required']
        ];
    }
}
