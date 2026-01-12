<?php

namespace App\Jobs;

use App\Mail\MasterApplicationEmail;
use App\Models\School;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class MasterApplicationEmailJob implements ShouldQueue
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
        $email = new MasterApplicationEmail($this->data);

        $to_email = Setting::where('key', 'admin_registration_email')->value('value');
        if(isset($this->data['school_id'])){
            $schoolEmail = School::whereId($this->data['school_id'])->first();
        }
        if(isset($this->data['send_me_a_copy']) && !empty($this->data['send_me_a_copy'])){
            Mail::to([$to_email,$schoolEmail,$this->data['email']])->send($email);
        }else{
            Mail::to([$to_email,$schoolEmail])->send($email);
        }
        
    }
}
