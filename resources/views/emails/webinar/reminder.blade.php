@component('mail::message')
# Hello {{ $registration->name ?? 'Participant' }},

This is a reminder that your webinar **{{ $webinar->title }}** is scheduled to start soon.

📅 Date: {{ \Carbon\Carbon::parse($webinar->start_date)->timezone($webinar->timezone)->format('M d, Y h:i A') }}
🔗 Join Link: [Join Webinar]({{ $registration->room_link }})

We look forward to seeing you!

Thanks,
{{ config('app.name') }}
@endcomponent