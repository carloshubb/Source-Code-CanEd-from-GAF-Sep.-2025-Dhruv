<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class CustomerRequest extends FormRequest
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
            'first_name'=> ['required'] ,
            'last_name' => ['required'] ,
            'email'=> ['required', 'email'] ,
            'display_name'=> ['nullable'] ,
            'image'=> ['nullable'] ,
            'user_type'=> ['nullable'] ,
            'dob'=> ['nullable'] ,
            'messagingAppDetail_id'=> ['nullable'] ,
            'gender'=> ['nullable'] ,
            'martial_status'=> ['nullable'] ,
            'city'=> ['nullable'] ,
            'country'=> ['nullable'] ,
            'province'=> ['nullable'] ,
            'postal_code'=> ['nullable'] ,
            'home_phone'=> ['nullable'] ,
            'mobile_phone'=> ['nullable'] ,
        ];
    }
}
