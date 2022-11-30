<?php

namespace App\Mail\Account;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class AccountWelcomeNewMail extends Mailable
{
    use Queueable, SerializesModels;

    var $user_id;
    var $raw_password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_id, $raw_password)
    {
        $this->user_id = $user_id;
        $this->raw_password = $raw_password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = User::find($this->user_id);

        return $this->to($user->email)
            ->markdown('emails.account.welcome_new_mail')
            ->subject('アカウント発行のお知らせ')
            ->with(['user' => $user, 'raw_password' => $this->raw_password]);
    }
}
