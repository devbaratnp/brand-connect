<?php

namespace App\Console\Commands;

use App\Mail\ApplicationReceivedMail;
use App\Mail\ApplicationStatusChangedMail;
use App\Mail\MessageReceivedMail;
use App\Mail\WelcomeMail;
use App\Models\Campaign;
use App\Models\CampaignApplication;
use App\Models\Message;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmails extends Command
{
    protected $signature = 'emails:test';

    protected $description = 'Send test emails for all Mailables';

    public function handle(): int
    {
        $testEmail = 'mind59024@gmail.com';
        $this->info("Sending test emails to {$testEmail}...");

        // 1. Welcome Email
        $this->info('1/4 Sending WelcomeMail...');
        $testUser = User::firstOrCreate(
            ['email' => $testEmail],
            ['name' => 'Test User', 'password' => bcrypt('password'), 'role' => 'creator']
        );
        Mail::to($testEmail)->send(new WelcomeMail($testUser));
        $this->info('   WelcomeMail sent!');

        // 2. Message Received
        $this->info('2/4 Sending MessageReceivedMail...');
        $sender = User::firstOrCreate(
            ['email' => 'sender@test.com'],
            ['name' => 'John Creator', 'password' => bcrypt('password'), 'role' => 'creator']
        );
        $receiver = User::firstOrCreate(
            ['email' => 'receiver@test.com'],
            ['name' => 'Jane Brand', 'password' => bcrypt('password'), 'role' => 'brand']
        );
        $message = Message::firstOrCreate(
            ['sender_id' => $sender->id, 'receiver_id' => $receiver->id, 'message' => 'Hey! I love your content. Would you be interested in collaborating on our new campaign?'],
            ['sender_id' => $sender->id, 'receiver_id' => $receiver->id, 'message' => 'Hey! I love your content. Would you be interested in collaborating on our new campaign?']
        );
        Mail::to($testEmail)->send(new MessageReceivedMail($message));
        $this->info('   MessageReceivedMail sent!');

        // 3. Application Received
        $this->info('3/4 Sending ApplicationReceivedMail...');
        $brand = User::firstOrCreate(
            ['email' => 'brand@test.com'],
            ['name' => 'Acme Corp', 'password' => bcrypt('password'), 'role' => 'brand']
        );
        $creator = User::firstOrCreate(
            ['email' => 'creator@test.com'],
            ['name' => 'Sarah Influencer', 'password' => bcrypt('password'), 'role' => 'creator']
        );
        $campaign = Campaign::firstOrCreate(
            ['title' => 'Summer Collection Launch', 'brand_id' => $brand->id],
            ['title' => 'Summer Collection Launch', 'brand_id' => $brand->id, 'description' => 'Promote our new summer collection', 'budget' => 50000, 'status' => 'open']
        );
        $application = CampaignApplication::firstOrCreate(
            ['campaign_id' => $campaign->id, 'creator_id' => $creator->id],
            ['campaign_id' => $campaign->id, 'creator_id' => $creator->id, 'message' => 'I would love to promote your summer collection! My audience aligns perfectly with your brand.']
        );
        $campaign->load('brand');
        Mail::to($testEmail)->send(new ApplicationReceivedMail($application, $campaign));
        $this->info('   ApplicationReceivedMail sent!');

        // 4. Application Status Changed
        $this->info('4/4 Sending ApplicationStatusChangedMail...');
        Mail::to($testEmail)->send(new ApplicationStatusChangedMail($application, $campaign, 'accepted'));
        $this->info('   ApplicationStatusChangedMail sent!');

        $this->newLine();
        $this->info('All 4 test emails sent to '.$testEmail);
        $this->info('Check your inbox (and spam folder)!');

        return Command::SUCCESS;
    }
}
