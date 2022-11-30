<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Lang;

class VerifyMailNotification extends VerifyEmail implements ShouldQueue
{
  use Queueable;

  public function toMail($notifiable)
  {
    $verificationUrl = $this->verificationUrl($notifiable);

    if (static::$toMailCallback) {
      return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
    }

    return (new MailMessage)
        ->subject(Lang::get('mail.verification.subject'))
        ->line(Lang::get('mail.verification.line_01'))
        ->action(Lang::get('mail.verification.action'), $verificationUrl)
        ->line(Lang::get('mail.verification.line_02'));
  }
}
