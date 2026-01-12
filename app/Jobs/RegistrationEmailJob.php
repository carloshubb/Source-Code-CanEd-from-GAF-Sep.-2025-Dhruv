<?php

namespace App\Jobs;

use App\Mail\RegistrationEmail;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class RegistrationEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->data;
        $data['recipent'] = 'user';
        $email = new RegistrationEmail($data);
        Mail::to([$data['email']])->send($email);

        // $to_email = Setting::where('key', 'admin_registration_email')->value('value');
        // $data['recipent'] = 'admin';
        // $email = new RegistrationEmail($data);
        // Mail::to($to_email)->send($email);
    }
}
