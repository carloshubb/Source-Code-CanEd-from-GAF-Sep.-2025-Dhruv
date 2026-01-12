<?php

namespace App\Mail;

use App\Models\Business;
use App\Models\Customer;
use App\Models\School;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OpenHouseCreatedEmail extends Mailable
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
        return $this->subject('Your Open House is Live on Proxima Study')
                    ->view('emails.open_house_created')
                    ->with([
                        'open_day_url' => $this->emailData['open_day_url'], // Pass the URL to the template
                    ]);
    }
}
