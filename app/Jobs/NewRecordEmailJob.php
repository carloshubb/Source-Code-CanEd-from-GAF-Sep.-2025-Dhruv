<?php

namespace App\Jobs;

use App\Mail\NewRecordEmail;
use App\Mail\CustomerThankYouEmail;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NewRecordEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $emailData;
    // protected $customerEmail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($emailData)
    {
        $this->emailData = $emailData;
        // $this->customerEmail = $customerEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $to_email = Setting::where('key', 'admin_registration_email')->value('value');
        // dd($to_email);
        $email = new NewRecordEmail($this->emailData);
        Mail::to($to_email)->send($email);

        // $customerEmail = new CustomerThankYouEmail($this->emailData);
        // Mail::to($this->customerEmail)->send($customerEmail);
    }
}
