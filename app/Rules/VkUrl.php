<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class VkUrl implements Rule
{
    public function passes($attribute, $value)
    {
        // Regular expression for a valid VK (VKontakte) URL
        $pattern = '/^(https?:\/\/)?(www\.)?(vk\.com\/)([A-Za-z0-9_]{1,})?\/?$/';

        return preg_match($pattern, $value);
    }

    public function message()
    {
        // return 'The :attribute must be a valid VK URL.';
        return 'Please add a valid URL of VK';
    }
}
