<?php

namespace App\Mail;

use App\Models\Business;
use App\Models\Customer;
use App\Models\School;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BusinessInvitaionEmailCopy extends Mailable
{
    use Queueable, SerializesModels;

    protected $emailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailData)
    {
        $this->emailData = $emailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                    ->markdown('emails.business_invitaion_copy')
                    ->with('emailData', $this->emailData)
                    // ->subject('Thank You for contacting '.$this->emailData['business_name']);
                    ->subject('Thank You for contacting '.$this->emailData['main_business_name']);
    }
}
