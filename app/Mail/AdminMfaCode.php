<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminMfaCode extends Mailable
{
    use Queueable, SerializesModels;

    public string $otp;

    public function __construct(string $otp)
    {
        $this->otp = $otp;
    }

    public function build()
    {
        return $this->subject('H2WHOA Admin — Your Login Code')
                    ->view('emails.admin_mfa_code');
    }

    public function attachments(): array
    {
        return [];
    }
}
