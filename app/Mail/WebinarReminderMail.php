<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Webinar;
use App\Models\WebinarRegistration;

class WebinarReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $webinar;
    public $registration;

    public function __construct(Webinar $webinar, WebinarRegistration $registration)
    {
        $this->webinar = $webinar;
        $this->registration = $registration;
    }

    public function build()
    {
        return $this->subject('Reminder: Your Webinar is Coming Up!')
            ->markdown('emails.webinar.reminder');
    }
}
