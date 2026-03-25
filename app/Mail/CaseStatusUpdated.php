<?php

namespace App\Mail;

use App\Models\Consultation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CaseStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $consultation; // This holds the case data

    // Catch the specific case when the email is created
    public function __construct(Consultation $consultation)
    {
        $this->consultation = $consultation;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Update on Your Legal Request',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.case_status', // We will create this view next
        );
    }
}