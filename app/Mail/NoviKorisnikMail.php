<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NoviKorisnikMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public \App\Models\User $user) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'AgroLog — novi korisnik: ' . $this->user->naziv_gospodarstva,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.novi-korisnik',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
