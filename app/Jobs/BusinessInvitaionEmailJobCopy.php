<?php

namespace App\Jobs;

use App\Mail\BusinessInvitaionEmail;
use App\Mail\BusinessInvitaionEmailCopy;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class BusinessInvitaionEmailJobCopy implements ShouldQueue
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
        $email = new BusinessInvitaionEmailCopy($this->data);
        Mail::to($this->data['visitor_email'])->send($email);
    }
}
