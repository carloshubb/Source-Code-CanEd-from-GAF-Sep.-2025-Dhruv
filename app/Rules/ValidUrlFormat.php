<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidUrlFormat implements Rule
{
    public function passes($attribute, $value)
    {
        // Corrected regex (escaped special characters properly)
        return preg_match(
            '/^(https?:\/\/)?([\da-z\.-]+\.[a-z]{2,63}|(\d{1,3}\.){3}\d{1,3})(:\d{1,5})?([\/\?\#\&\=\+\%\w\.\-~:\@\p{L}\p{N}]*)*\/?$/iu',
            $value
        );
    }

    public function message()
    {
        return 'The :attribute is not a valid URL.';
    }
}