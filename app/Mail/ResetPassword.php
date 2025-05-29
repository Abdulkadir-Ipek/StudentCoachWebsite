<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $resetLink;
    public $userName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userName, $resetLink)
    {
        $this->resetLink = $resetLink;
        $this->userName = $userName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Şifre Sıfırlama Bağlantısı - EduCoach')
                    ->view('emails.reset-password');
    }
} 