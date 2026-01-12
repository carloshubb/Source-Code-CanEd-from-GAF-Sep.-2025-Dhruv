<?php

namespace App\Jobs;

use App\Mail\ProximatchJobEmail;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class ProximatchJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $emailData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($emailData)
    {
        $this->emailData = $emailData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $email = new ProximatchJobEmail($this->emailData);
        // $to_email = Setting::where('key', 'admin_registration_email')->value('value');
        // Mail::to([$this->emailData['email'],$to_email])->send($email);

        $emailData = $this->emailData;
        if ($emailData['type'] == 'form_request' && isset($emailData['send_me_a_copy']) && $emailData['send_me_a_copy'] == 1) {
            $email = new ProximatchJobEmail($emailData);
            Mail::to([$emailData['email']])->send($email);
            $emailData['recipient'] = 'admin';
            $emailData['type'] = '';

        } 
        if($emailData['type'] == 'qoutation'){
            $emailData['recipient'] = 'user';
            $email = new ProximatchJobEmail($emailData);
            Mail::to([$emailData['email']])->send($email);
        }

        $to_email = Setting::where('key', 'admin_registration_email')->value('value');
        $emailData['recipient'] = 'admin';
        $email = new ProximatchJobEmail($emailData);
        Mail::to($to_email)->send($email);
    }
}
