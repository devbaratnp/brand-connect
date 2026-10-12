<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MessageReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Message $message) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('pdewbrath@gmail.com', 'Brand Connect'),
            subject: 'New Message from '.$this->message->sender->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: view('emails.message-received', ['message' => $this->message])->render(),
        );
    }
}
