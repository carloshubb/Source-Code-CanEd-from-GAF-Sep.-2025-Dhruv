<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FacebookUrl implements Rule
{
    public function passes($attribute, $value)
    {
        // Regular expression for a valid Facebook URL
        $pattern = '/^(https?:\/\/)?(www\.)?(facebook\.com)(\/[A-Za-z0-9.\-_]+)?\/?$/i';

        return preg_match($pattern, $value);
    }

    public function message()
    {
        // return 'The :attribute must be a valid Facebook URL.';
        return 'Please add a valid URL of facebook';
    }
}
