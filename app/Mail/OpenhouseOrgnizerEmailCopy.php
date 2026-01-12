<?php

namespace App\Mail;

use App\Models\Business;
use App\Models\Customer;
use App\Models\School;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OpenhouseOrgnizerEmailCopy extends Mailable
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
                    ->markdown('emails.open_house_orgnizer_copy')
                    ->with('emailData', $this->emailData)
                    // ->subject('Thank You for Contacting '.$this->emailData['open_house']);
                    ->subject('Your message on Proxima Study');
    }
}
