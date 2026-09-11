<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentConsentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $studentName;
    public $consentUrl;

    public function __construct($studentName, $consentUrl)
    {
        $this->studentName = $studentName;
        $this->consentUrl = $consentUrl;
    }

    public function build()
    {
        return $this
            ->subject('Student Consent & Responsibility Letter')
            ->view('emails.student-consent');
    }
}