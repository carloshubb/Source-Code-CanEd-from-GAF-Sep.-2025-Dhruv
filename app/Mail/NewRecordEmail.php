<?php

namespace App\Mail;

use App\Models\Business;
use App\Models\Customer;
use App\Models\School;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewRecordEmail extends Mailable
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
        $customerName = $this->emailData['customer'];
        return $this
                    ->markdown('emails.new_record')
                    ->with('emailData', $this->emailData)
            //         ->subject('A user has created a new'
            //   .$this->emailData['record_type_string']. 'on Proxima Study');
            ->subject($customerName.' created Program on Proxima Study');
    }
}
