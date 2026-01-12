<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;
    public $token ='';
    public $lang;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token,$lang = null)
    {
        $this->token = $token;
        $this->lang = $lang ?? app()->getLocale();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage())
    //         ->subject('Reset your password')
    //         ->line('You are receiving this email because we received a password reset request for your account.')
    //         ->line('Click on the following link to reset your password:')
    //         ->action('Reset password', url('password/reset', $this->token))
           
    //         ->line('If you did not request a password reset, please ignore this email. Your information will remain secure.')
           
    //         ->line('Thank you');
    // }
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('Reset your password')
            ->view('emails.reset_password', [
                'token' => $this->token,
                'lang' => $this->lang,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
