<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class LinkedInUrl implements Rule
{
    public function passes($attribute, $value)
    {
        // Updated regular expression to cover LinkedIn event URLs
        $pattern = '/^(https?:\/\/)?(www\.)?(linkedin\.com)(\/(in|company|posts|jobs|feed|events)\/[A-Za-z0-9\-_%]+)?\/?$/i';

        return preg_match($pattern, $value);
    }

    public function message()
            // return 'The :attribute must be a valid LinkedIn URL.';

    {
        return 'Please add a valid URL of linkedin';
    }
}
