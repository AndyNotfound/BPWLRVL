<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public string $subjectLine;
    public string $bladeView;
    public array $emailData;

    public function __construct(array $emailData, string $bladeView, string $subjectLine = "Email Send from Batam Pesona Wisata")
    {
        $this->emailData = $emailData;
        $this->bladeView = $bladeView;
        $this->subjectLine = $subjectLine;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectLine,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: $this->bladeView,
            with: $this->emailData
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
