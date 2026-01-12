<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class InstagramUrl implements Rule
{
    public function passes($attribute, $value)
    {
        // Regular expression for valid Instagram URLs (profiles, posts, reels, stories, explore, base URL)
        $pattern = '/^(https?:\/\/)?(www\.)?instagram\.com\/?(p\/|reel\/|stories\/|explore\/|[A-Za-z0-9._-]+\/?)?$/i';

        return preg_match($pattern, $value);
    }

    public function message()
    {
        // return 'The :attribute must be a valid Instagram URL.';
        return 'Please add a valid URL of instagram';
    }
}
