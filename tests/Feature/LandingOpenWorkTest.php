<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingOpenWorkTest extends TestCase
{
    use RefreshDatabase;

    private function makeCampaign(User $brand, array $over = []): Campaign
    {
        return Campaign::create(array_merge([
            'brand_id' => $brand->id,
            'title' => 'Open Work Campaign',
            'description' => 'A description.',
            'status' => 'open',
        ], $over));
    }

    public function test_guest_sees_only_open_campaigns_with_gated_apply_links(): void
    {
        $brand = User::factory()->create(['role' => 'brand']);
        $open = $this->makeCampaign($brand, ['title' => 'Open Work Campaign']);
        $this->makeCampaign($brand, ['title' => 'Closed Work Campaign', 'status' => 'closed']);

        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Open Work Campaign')
            ->assertSee('from real brands')
            ->assertDontSee('Closed Work Campaign')
            ->assertSee(route('campaigns.show', $open), false);
    }

    public function test_guest_apply_bounces_to_login_then_lands_on_campaign(): void
    {
        $brand = User::factory()->create(['role' => 'brand']);
        $creator = User::factory()->create(['role' => 'creator']);
        $campaign = $this->makeCampaign($brand);

        $this->get(route('campaigns.show', $campaign))->assertRedirect(route('login'));

        $this->post('/login', [
            'email' => $creator->email,
            'password' => 'password',
        ])->assertRedirect(route('campaigns.show', $campaign));
    }

    public function test_creator_sees_apply_now_and_brand_sees_view_campaign(): void
    {
        $brand = User::factory()->create(['role' => 'brand']);
        $creator = User::factory()->create(['role' => 'creator']);
        $this->makeCampaign($brand);

        $this->actingAs($creator)->get('/')
            ->assertOk()
            ->assertSee('Apply Now', false)
            ->assertDontSee('View Campaign');

        $this->actingAs($brand)->get('/')
            ->assertOk()
            ->assertSee('View Campaign', false)
            ->assertDontSee('Apply Now');
    }

    public function test_empty_state_when_no_open_campaigns(): void
    {
        $this->get('/')->assertOk()->assertSee('No open work right now');
    }
}
