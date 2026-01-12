<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ThresholdEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailData;

    public function __construct($emailData)
    {
        $this->emailData = $emailData;
    }

    public function build()
    {
        return $this->subject('School threshold has been reached on Proxima Study')
                    ->view('emails.threshold')
                    ->with([
                        'school_name' => $this->emailData['school_name'],
                        'threshold' => $this->emailData['threshold'],
                        'current_count' => $this->emailData['current_count'],
                    ]);
    }
}