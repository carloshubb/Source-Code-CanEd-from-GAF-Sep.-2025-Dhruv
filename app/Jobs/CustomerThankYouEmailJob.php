<?php

namespace App\Jobs;

use App\Mail\CustomerThankYouEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class CustomerThankYouEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $emailData;
    protected $customerEmail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($emailData, $customerEmail)
    {
        $this->emailData = $emailData;
        $this->customerEmail = $customerEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Send email to customer
        $customerEmail = new CustomerThankYouEmail($this->emailData);
        Mail::to($this->customerEmail)->send($customerEmail);
    }
}