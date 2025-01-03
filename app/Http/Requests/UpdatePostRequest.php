<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
    public function rules()
    {
        return [
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
        ];
    }

    public function messages()
    {
        return [
            'title.max' => 'The title may not be greater than 255 characters.',
            'content.string' => 'The content must be a valid string.'
        ];
    }
}
