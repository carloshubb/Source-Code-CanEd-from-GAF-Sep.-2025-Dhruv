<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class ProximaRequestRequest extends FormRequest
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
            'name' => ['required'],
            'email' => ['required', 'email'],
            'phone' => ['required' ,'digits_between:1,15'],
            'inquiry' => ['required'],
        ];
    }
    public function messages()
{
    return [
        'phone.digits_between' => 'Phone number cannot exceed 15 digits.',
        // 'name.required' => __('static_translations.proxima_request_setting_detail.0.name_error'),
        // Add more custom messages for other fields...
    ];
}
    // public function messages()
    // {
    //     return [
    //         'name.required' => __('this field is rquired'), // Fetch from translations
    //         'email.required' => __('proxima_request.email_required'),
    //         'email.email' => __('proxima_request.email_invalid'),
    //         'phone.required' => __('proxima_request.phone_required'),
    //         'inquiry.required' => __('proxima_request.inquiry_required'),
    //     ];
    // }
}
