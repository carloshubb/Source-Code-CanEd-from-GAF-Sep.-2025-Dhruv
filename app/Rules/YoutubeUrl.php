<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class YoutubeUrl implements Rule
{
    public function passes($attribute, $value)
    {
        // Updated regex to match multiple YouTube URL formats
        $pattern = '/^(https?:\/\/)?(www\.)?(youtube\.com\/(watch\?v=[a-zA-Z0-9_-]+|channel\/[a-zA-Z0-9_-]+|embed\/[a-zA-Z0-9_-]+|shorts\/[a-zA-Z0-9_-]+)|youtu\.be\/[a-zA-Z0-9_-]+)(\S+)?$/';

        return preg_match($pattern, $value);
    }

    public function message()
    // return 'The :attribute must be a valid YouTube URL.';
    {
        return 'Please add a valid YouTube URL.';
    }
}