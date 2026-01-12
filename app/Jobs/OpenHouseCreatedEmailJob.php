<?php

namespace App\Jobs;

use App\Mail\NewRecordEmail;
use App\Mail\OpenHouseCreatedEmail;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class OpenHouseCreatedEmailJob implements ShouldQueue
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
        try {
            // Send email to the creator
            Mail::to($this->emailData['creator_email'])
                ->send(new OpenHouseCreatedEmail($this->emailData));
        } catch (\Exception $e) {
            Log::error('Failed to send Open House created email: ' . $e->getMessage());
        }
    }
}
