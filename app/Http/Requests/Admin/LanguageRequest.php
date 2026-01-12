<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class LanguageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'abbreviation' => ['required', 'string', 'max:10'],
            'native_name' => ['required', 'string', 'max:50'],
            'is_default' => ['required', 'boolean'],
            'flag_icon' => ['required', 'string']
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Language name is required.',
            // 'name.string' => 'The language name must be a valid string.',
            // 'name.max' => 'The language name must not exceed 50 characters.',
            
            'abbreviation.required' => 'Abbreviation is required.',
            // 'abbreviation.string' => 'The abbreviation must be a valid string.',
            // 'abbreviation.max' => 'The abbreviation must not exceed 10 characters.',
            
            'native_name.required' => 'Native name is required.',
            // 'native_name.string' => 'The native name must be a valid string.',
            // 'native_name.max' => 'The native name must not exceed 50 characters.',
            
            // 'is_default.required' => 'Please specify if this language is default.',
            // 'is_default.boolean' => 'The default status must be true or false.',
            
            // 'flag_icon.required' => 'The flag icon is required.',
            // 'flag_icon.string' => 'The flag icon must be a valid string.',
        ];
    }
}
