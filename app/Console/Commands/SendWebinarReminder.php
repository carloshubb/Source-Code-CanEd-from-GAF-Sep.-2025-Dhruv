<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Webinar;
use App\Models\WebinarRegistration;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendWebinarReminder extends Command
{
    protected $signature = 'webinars:send-reminders';
    protected $description = 'Send webinar reminders 12 hours before start';

    public function handle()
    {
        $now = Carbon::now('UTC');

        $rangeStart = $now->copy()->addHours(12);
        $rangeEnd = $now->copy()->addHours(13);

        $webinars = Webinar::whereBetween('start_date', [$rangeStart, $rangeEnd])->get();
        // dd([
        //     'now' => $now,
        //     'rangeStart' => $rangeStart,
        //     'rangeEnd' => $rangeEnd,
        //     'webinars' => $webinars
        // ]);
        foreach ($webinars as $webinar) {
            $registrations = WebinarRegistration::where('webinar_id', $webinar->id)->get();

            foreach ($registrations as $registration) {
                Mail::to($registration->email)->send(new \App\Mail\WebinarReminderMail($webinar, $registration));
            }
        }

        $this->info('Webinar reminders sent successfully.');
    }
}
