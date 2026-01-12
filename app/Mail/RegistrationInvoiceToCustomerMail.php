<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class RegistrationInvoiceToCustomerMail extends Mailable
{
    use Queueable, SerializesModels;
    private $data = [];
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data)
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
        $pdf = null;
        if ($this->data['order']) {
            Log::info('public/invoices/registration-invoice/' . $this->data['order']['invoice_no'] . '.pdf');

            $pdf = Storage::get('public/invoices/registration-invoice/' . $this->data['order']['invoice_no'] . '.pdf');
        }

        $email = $this->markdown('emails/registration-invoice-to-customer')
            ->subject("Your receipt- Thank you")
            ->with("data1", $this->data);

        if (isset($pdf)) {
            $email->attachData($pdf, 'invoice.pdf');
        }

        return $email;
    }
}
