<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('pdewbrath@gmail.com', 'Brand Connect'),
            subject: 'Welcome to Brand Connect!',
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: view('emails.welcome', ['user' => $this->user])->render(),
        );
    }
}
