<?php

namespace App\Http\Requests\Admin\Tag;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest {
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
            'tag_name' => 'required|max:255|unique:tags,tag_name',
        ];
    }
//  The Custom message method
//    public function messages(): array {
//        return [
//            'tag_name.required' => 'The tag name field is required.',
//        ];
//    }
}
