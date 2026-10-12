<?php

namespace App\Mail;

use App\Models\Campaign;
use App\Models\CampaignApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public CampaignApplication $application,
        public Campaign $campaign
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('pdewbrath@gmail.com', 'Brand Connect'),
            subject: 'New Application for "'.$this->campaign->title.'"',
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: view('emails.application-received', [
                'application' => $this->application,
                'campaign' => $this->campaign,
            ])->render(),
        );
    }
}
