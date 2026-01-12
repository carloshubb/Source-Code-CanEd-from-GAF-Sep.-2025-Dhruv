<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

class ProximatchJobEmail extends Mailable
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
        $proximatch = $this->emailData;
        $pdf = PDF::loadView('front.proxima_quotation', ['proximatch' => $proximatch]);
        $pdfData = $pdf->output();
        if ($proximatch['type'] == 'form_request') {
            if (isset($proximatch['send_me_a_copy']) && $proximatch['send_me_a_copy'] == 1) {
                return $this->markdown('emails.proximatch_copy')
                    ->with('proximatch', $proximatch)
                    ->subject('Your Information Submitted for Proximatch');
            }
        } else {
            if ($proximatch['recipient'] === 'user') {
                return $this->markdown('emails.proximatch')
                    ->with('proximatch', $proximatch)
                    ->subject('Confirmation - Your Information has been Submitted!')
                    ->attachData($pdfData, 'quotation.pdf');
            }
        }
        return $this->markdown('emails.proximatch_admin')
            ->with('proximatch', $proximatch)
            ->subject('New Student Information Submitted for Proximatch')
            ->attachData($pdfData, 'quotation.pdf');
    }
}
