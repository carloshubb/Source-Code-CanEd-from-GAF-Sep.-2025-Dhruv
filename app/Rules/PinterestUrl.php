<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PinterestUrl implements Rule
{
    public function passes($attribute, $value)
    {
        // Regular expression for a valid Pinterest URL (including base domain, profiles, and pins)
        $pattern = '/^(https?:\/\/)?(www\.)?pinterest\.com(\/[a-zA-Z0-9_\/-]*)?$/';

        return preg_match($pattern, $value);
    }

    public function message()
    {
        // return 'The :attribute must be a valid Pinterest URL.';
                // return 'The :attribute must be a valid Pinterest URL.';
                return 'Please add a valid URL of pinterest';
    }
}
