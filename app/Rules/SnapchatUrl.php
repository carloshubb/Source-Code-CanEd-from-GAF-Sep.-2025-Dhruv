<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SnapchatUrl implements Rule
{
    public function passes($attribute, $value)
    {
        $pattern = '/^(https?:\/\/)?(www\.)?snapchat\.com(\/[a-zA-Z0-9._\/-]*)?$/';

        return preg_match($pattern, $value);
    }

    public function message()
    {
        // return 'The :attribute must be a valid Snapchat profile URL.';
        return 'Please add a valid URL of snapchat.';
    }
}
