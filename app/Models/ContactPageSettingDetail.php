<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactPageSettingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_page_setting_id',
        'language_id',
        'page_title_1',
        'page_title_2',
        'description',
        'mainling_address',
        'toll_free',
        'phone',
        'email',
        'website',
        'name_input_lable',
        'name_input_placeholder',
        'name_input_error',
        'email_input_lable',
        'email_input_placeholder',
        'email_input_error',
        'message_input_lable',
        'message_input_placeholder',
        'message_input_error',
        'button_text',
    ];

    public $timestamps = false;

    public function contactPageSetting()
    {
        return $this->belongsTo(ContactPageSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
