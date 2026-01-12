<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxKeywords implements Rule
{
    public function passes($attribute, $value)
    {
        $keywords = array_filter(array_map('trim', explode(',', $value)));
        return count($keywords) <= 5;
    }

    public function message()
    {
        return 'You can only enter up to 5 keywords.';
    }
}
