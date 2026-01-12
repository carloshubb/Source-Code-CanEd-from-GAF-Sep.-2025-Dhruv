<?php

namespace App\Mail;

use App\Models\Business;
use App\Models\Customer;
use App\Models\School;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->data['type'] == 'email_verified'){
            if($this->data['recipent'] == 'user'){
                return $this->markdown('emails.register_customer')->with('emailData', $this->data)->subject("Welcome to Proxima Study");
            }
        }
        else if($this->data['type'] == 'register_customer'){
            if($this->data['recipent'] == 'user'){
                return $this->markdown('emails.email_verification')->with('emailData', $this->data)->subject('Verify your email address');
            }
            // else{
            //     return $this->markdown('emails.register_customer_admin')->with('emailData', $this->data)->subject('A new user registration on ProximaStudy');
            // }
        }
        else if($this->data['type'] == 'register_school'){
            $defaulLang = getDefaultLanguage(1);
            $schoolData = School::with(['schoolDetail' => function ($q) use($defaulLang) {
                $q->where('language_code', $defaulLang->abbreviation);
            }])->where('id',$this->data['id'])->first();
            if($this->data['recipent'] == 'user'){
                return $this->markdown('emails.register_school')->with('emailData', $schoolData)->subject('Welcome to Proxima Study - Connecting Schools and Students!');
            }
            // else{
            //     return $this->markdown('emails.register_school_admin')->with('emailData', $schoolData)->subject('A new school registration on ProximaStudy');
            // }
            
        }
        else if($this->data['type'] == 'register_business'){
            $defaulLang = getDefaultLanguage(1);
            $businessData = Business::with(['businessDetail' => function ($q) use($defaulLang) {
                $q->where('business_details.language_id', $defaulLang->id);
            }])->whereId($this->data['id'])->first();
            if($this->data['recipent'] == 'user'){
                return $this->markdown('emails.register_business')->with('emailData', $businessData)->subject('Welcome to Proxima Study - Promote Your Business');
            }
            // else{
            //     return $this->markdown('emails.register_business_admin')->with('emailData', $businessData)->subject('A new business registration on ProximaStudy');
            // }
            
        }
    }
}
