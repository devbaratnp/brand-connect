<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\CampaignApplication;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PortalFixesTest extends TestCase
{
    use RefreshDatabase;

    private function makeUser(string $role): User
    {
        return User::factory()->create(['role' => $role]);
    }

    private function makeCampaign(User $brand, array $over = []): Campaign
    {
        return Campaign::create(array_merge([
            'brand_id' => $brand->id,
            'title' => 'Test Campaign',
            'description' => 'A description.',
            'status' => 'open',
        ], $over));
    }

    public function test_creator_can_save_profile_with_unavailable_status(): void
    {
        $creator = $this->makeUser('creator');

        $response = $this->actingAs($creator)->put('/creator/profile', [
            'niche' => 'Fashion',
            'availability' => 'unavailable',
        ]);

        $response->assertRedirect(route('creator.profile'));
        $this->assertDatabaseHas('creator_profiles', [
            'user_id' => $creator->id,
            'availability' => 'unavailable',
        ]);
    }

    public function test_brand_can_save_profile(): void
    {
        $brand = $this->makeUser('brand');

        $response = $this->actingAs($brand)->put('/brand/profile', [
            'company_name' => 'Acme',
        ]);

        $response->assertRedirect(route('brand.profile'));
        $this->assertDatabaseHas('brand_profiles', [
            'user_id' => $brand->id,
            'company_name' => 'Acme',
        ]);
    }

    public function test_inbox_shows_unread_marker_only_for_unread_messages(): void
    {
        $brand = $this->makeUser('brand');
        $creator = $this->makeUser('creator');
        Message::create(['sender_id' => $creator->id, 'receiver_id' => $brand->id, 'message' => 'Unread one']);
        Message::create(['sender_id' => $creator->id, 'receiver_id' => $brand->id, 'message' => 'Read one', 'read_at' => now()]);

        $response = $this->actingAs($brand)->get('/messages/inbox');

        $response->assertOk()->assertSee('Unread');
        $this->assertSame(1, substr_count($response->getContent(), 'width:10px;height:10px;border-radius:50%'));
    }

    public function test_message_store_redirects_back_to_conversation(): void
    {
        Mail::fake();
        $brand = $this->makeUser('brand');
        $creator = $this->makeUser('creator');

        $response = $this->actingAs($brand)->post('/messages', [
            'receiver_id' => $creator->id,
            'message' => 'Hello',
        ]);

        $response->assertRedirect(route('messages.conversation', $creator));
    }

    public function test_visiting_message_marks_it_read(): void
    {
        $brand = $this->makeUser('brand');
        $creator = $this->makeUser('creator');
        $msg = Message::create(['sender_id' => $creator->id, 'receiver_id' => $brand->id, 'message' => 'Hi']);

        $this->actingAs($brand)->get(route('messages.show', $msg))->assertOk();

        $this->assertNotNull($msg->fresh()->read_at);
    }

    public function test_brand_can_open_review_form_and_submit_for_accepted_creator(): void
    {
        $brand = $this->makeUser('brand');
        $creator = $this->makeUser('creator');
        $campaign = $this->makeCampaign($brand);
        CampaignApplication::create(['campaign_id' => $campaign->id, 'creator_id' => $creator->id, 'status' => 'accepted']);

        $this->actingAs($brand)
            ->get(route('reviews.create', $campaign).'?for='.$creator->id)
            ->assertOk()
            ->assertSee('value="'.$creator->id.'"', false);

        $response = $this->actingAs($brand)->post(route('reviews.store', $campaign), [
            'reviewee_id' => $creator->id,
            'rating' => 5,
            'review' => 'Great work',
        ]);

        $response->assertRedirect(route('campaigns.show', $campaign));
        $this->assertDatabaseHas('reviews', ['reviewer_id' => $brand->id, 'reviewee_id' => $creator->id, 'rating' => 5]);
    }

    public function test_review_store_rejects_duplicate_and_self_review(): void
    {
        $brand = $this->makeUser('brand');
        $creator = $this->makeUser('creator');
        $campaign = $this->makeCampaign($brand);
        CampaignApplication::create(['campaign_id' => $campaign->id, 'creator_id' => $creator->id, 'status' => 'accepted']);

        $payload = ['reviewee_id' => $creator->id, 'rating' => 4];
        $this->actingAs($brand)->post(route('reviews.store', $campaign), $payload)->assertRedirect();
        $this->actingAs($brand)->post(route('reviews.store', $campaign), $payload)->assertSessionHas('error');

        $this->actingAs($brand)->post(route('reviews.store', $campaign), [
            'reviewee_id' => $brand->id, 'rating' => 5,
        ])->assertSessionHas('error');
    }

    public function test_reviews_show_page_loads(): void
    {
        $brand = $this->makeUser('brand');
        $creator = $this->makeUser('creator');

        $this->actingAs($brand)->get(route('reviews.show', $creator))->assertOk();
    }

    public function test_stranger_cannot_open_review_form(): void
    {
        $brand = $this->makeUser('brand');
        $stranger = $this->makeUser('creator');
        $campaign = $this->makeCampaign($brand);

        $this->actingAs($stranger)->get(route('reviews.create', $campaign))->assertForbidden();
    }

    public function test_campaign_update_accepts_in_progress_status(): void
    {
        $brand = $this->makeUser('brand');
        $campaign = $this->makeCampaign($brand);

        $response = $this->actingAs($brand)->put(route('campaigns.update', $campaign), [
            'title' => 'Test Campaign',
            'description' => 'A description.',
            'status' => 'in_progress',
        ]);

        $response->assertRedirect(route('brand.campaigns'));
        $this->assertSame('in_progress', $campaign->fresh()->status);
    }

    public function test_rejecting_last_accepted_application_reopens_campaign(): void
    {
        Mail::fake();
        $brand = $this->makeUser('brand');
        $creator = $this->makeUser('creator');
        $campaign = $this->makeCampaign($brand, ['status' => 'in_progress']);
        $app = CampaignApplication::create(['campaign_id' => $campaign->id, 'creator_id' => $creator->id, 'status' => 'accepted']);

        $response = $this->actingAs($brand)->post(
            route('applications.update-status', [$campaign, $app]), ['status' => 'rejected']);

        $response->assertRedirect();
        $this->assertSame('open', $campaign->fresh()->status);
    }

    public function test_rejecting_one_of_two_accepted_keeps_campaign_in_progress(): void
    {
        Mail::fake();
        $brand = $this->makeUser('brand');
        $c1 = $this->makeUser('creator');
        $c2 = $this->makeUser('creator');
        $campaign = $this->makeCampaign($brand, ['status' => 'in_progress']);
        CampaignApplication::create(['campaign_id' => $campaign->id, 'creator_id' => $c1->id, 'status' => 'accepted']);
        $app2 = CampaignApplication::create(['campaign_id' => $campaign->id, 'creator_id' => $c2->id, 'status' => 'accepted']);

        $this->actingAs($brand)->post(
            route('applications.update-status', [$campaign, $app2]), ['status' => 'rejected'])->assertRedirect();

        $this->assertSame('in_progress', $campaign->fresh()->status);
    }

    public function test_campaign_show_renders_with_null_deadline_and_budget(): void
    {
        $brand = $this->makeUser('brand');
        $campaign = $this->makeCampaign($brand, ['deadline' => null, 'budget' => null]);

        $this->actingAs($brand)->get(route('campaigns.show', $campaign))->assertOk();
        $this->actingAs($this->makeUser('creator'))->get(route('campaigns.show', $campaign))
            ->assertOk()
            ->assertSee('Flexible', false)
            ->assertSee('Not specified', false);
    }

    public function test_brand_dashboard_counts_are_not_capped_by_preview_limits(): void
    {
        $brand = $this->makeUser('brand');
        $campaign = $this->makeCampaign($brand);
        for ($i = 0; $i < 12; $i++) {
            $c = $this->makeUser('creator');
            CampaignApplication::create(['campaign_id' => $campaign->id, 'creator_id' => $c->id]);
        }

        $response = $this->actingAs($brand)->get('/dashboard');

        $response->assertOk()->assertSee('>12<', false);
    }

    public function test_creator_dashboard_shows_true_unread_count(): void
    {
        $brand = $this->makeUser('brand');
        $creator = $this->makeUser('creator');
        Message::create(['sender_id' => $brand->id, 'receiver_id' => $creator->id, 'message' => 'One']);
        Message::create(['sender_id' => $brand->id, 'receiver_id' => $creator->id, 'message' => 'Two', 'read_at' => now()]);

        $response = $this->actingAs($creator)->get('/dashboard');

        $response->assertOk()->assertSee('Unread messages');
    }

    public function test_applying_twice_redirects_to_my_applications(): void
    {
        Mail::fake();
        $brand = $this->makeUser('brand');
        $creator = $this->makeUser('creator');
        $campaign = $this->makeCampaign($brand);
        CampaignApplication::create(['campaign_id' => $campaign->id, 'creator_id' => $creator->id]);

        $response = $this->actingAs($creator)->post(route('campaigns.apply', $campaign), ['message' => 'Again']);

        $response->assertRedirect(route('creator.applications'));
        $response->assertSessionHas('error');
    }
}
