<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TwitterUrl implements Rule
{
    public function passes($attribute, $value)
    {
        // Regular expression for a valid X (formerly Twitter) URL
        $pattern = '/^(https?:\/\/)?(www\.)?(x\.com|twitter\.com)(\/[A-Za-z0-9_]+(\/status\/[0-9]+)?)?\/?$/';

        return preg_match($pattern, $value);
    }

    public function message()
    {
        // return 'The :attribute must be a valid X (formerly Twitter) URL.';

        return 'Please add a valid URL of twitter.';
    }
}
