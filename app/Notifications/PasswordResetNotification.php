<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Lang;

class PasswordResetNotification extends ResetPassword implements ShouldQueue
{
  use Queueable;

  /**
   * Get the mail representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail($notifiable)
  {
    if (static::$toMailCallback) {
      return call_user_func(static::$toMailCallback, $notifiable, $this->token);
    }

    $url = config('const.FRONTEND_URL') . '/password/reset?token=' . $this->token . '&email=' . $notifiable->getEmailForPasswordReset();
    return (new MailMessage)
        ->subject(Lang::get('mail.password_reset.subject'))
        ->line(Lang::get('mail.password_reset.line_01'))
        ->action(Lang::get('mail.password_reset.action'), $url)
        ->line(Lang::get('mail.password_reset.line_02', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
        ->line(Lang::get('mail.password_reset.line_03'));
  }
}