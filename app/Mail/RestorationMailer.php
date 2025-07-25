<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RestorationMailer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $name;
    public $ticket_number;
    public $siteId;
    public $dateAndTime;
    public $reason;
    public $troubleshoot;
    public function __construct($name, $ticket_number, $siteId, $dateAndTime, $reason, $troubleshoot)
    {
        $this->name = $name;
        $this->ticket_number = $ticket_number;
        $this->siteId = $siteId;
        $this->dateAndTime = $dateAndTime;
        $this->reason = $reason;
        $this->troubleshoot = $troubleshoot;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Restoration Mailer',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.restoration-mailer',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
