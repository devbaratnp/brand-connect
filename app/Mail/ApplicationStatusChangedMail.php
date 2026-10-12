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

class ApplicationStatusChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public CampaignApplication $application,
        public Campaign $campaign,
        public string $status
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('pdewbrath@gmail.com', 'Brand Connect'),
            subject: 'Application '.ucfirst($this->status).' — "'.$this->campaign->title.'"',
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: view('emails.application-status-changed', [
                'application' => $this->application,
                'campaign' => $this->campaign,
                'status' => $this->status,
            ])->render(),
        );
    }
}
