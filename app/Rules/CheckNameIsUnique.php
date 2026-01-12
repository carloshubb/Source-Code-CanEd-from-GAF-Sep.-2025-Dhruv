<?php

namespace App\Rules;

use App\Models\MessagingAppDetail;
use Illuminate\Contracts\Validation\Rule;

class CheckNameIsUnique implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $language;
    private $messagingAppId;


    public function __construct($language, $messagingAppId)
    {
        $this->language = $language;
        $this->messagingAppId = $messagingAppId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $messagingAppDetail = MessagingAppDetail::where('name', $value)->whereLanguageId($this->language->id);
        if (isset($this->messagingAppId)) {
            $messagingAppDetail = $messagingAppDetail->where('messaging_app_id', '!=', $this->messagingAppId);
        }
        $messagingAppDetail = $messagingAppDetail->exists();
        if ($messagingAppDetail) {
            return 0;
        }
        return 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The name must be unique in the ' . $this->language->name . ' language.';
    }
}
