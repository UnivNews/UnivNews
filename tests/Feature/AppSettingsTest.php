<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Boost;
use App\Models\BoostPrice;
use App\Models\Setting;
use App\Models\University;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppSettingsTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $author;

    protected function setUp(): void
    {
        parent::setUp();

        University::create(['name' => 'University of Indonesia', 'abbreviation' => 'UI']);

        $this->admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'author_status' => User::STATUS_APPROVED,
        ]);

        $this->author = User::factory()->create([
            'role' => User::ROLE_AUTHOR,
            'author_status' => User::STATUS_APPROVED,
        ]);
    }

    public function test_guest_cannot_access_payment_settings()
    {
        $response = $this->get('/admin/app-settings');
        $response->assertRedirect('/admin/sign-in');
    }

    public function test_author_cannot_access_payment_settings()
    {
        $response = $this->actingAs($this->author)->get('/admin/app-settings');
        $response->assertRedirect('/admin/sign-in');
    }

    public function test_admin_can_access_payment_settings_page()
    {
        Setting::set('publish_fee', 25000);
        BoostPrice::create([
            'duration_type' => '3_days',
            'duration_days' => 3,
            'price' => 50000,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin, 'admin')->get('/admin/app-settings');

        $response->assertStatus(200);
        $response->assertSee('Payment Configuration');
        $response->assertSee('Boost Price Configuration');
        $response->assertSee('25000');
        $response->assertSee('3 Days');
    }

    public function test_admin_can_update_publication_fee()
    {
        $response = $this->actingAs($this->admin, 'admin')->put('/admin/app-settings', [
            'publish_fee' => 35000,
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals(35000, Setting::get('publish_fee'));
    }

    public function test_publish_fee_validation_rejects_out_of_range_values()
    {
        // Less than 1000
        $response = $this->actingAs($this->admin, 'admin')->put('/admin/app-settings', [
            'publish_fee' => 500,
        ]);
        $response->assertSessionHasErrors('publish_fee');

        // Greater than 10,000,000
        $response = $this->actingAs($this->admin, 'admin')->put('/admin/app-settings', [
            'publish_fee' => 20000000,
        ]);
        $response->assertSessionHasErrors('publish_fee');
    }

    public function test_admin_can_toggle_boost_price_active_switch()
    {
        $bp = BoostPrice::create([
            'duration_type' => '1_week',
            'duration_days' => 7,
            'price' => 100000,
            'is_active' => true,
        ]);

        // Toggle OFF (when unchecked, HTML form does not submit is_active)
        $response = $this->actingAs($this->admin, 'admin')->put('/admin/app-settings', [
            'publish_fee' => 25000,
            'boost_prices' => [
                $bp->id => [
                    'price' => 120000,
                    // is_active omitted
                ],
            ],
        ]);

        $response->assertSessionHas('success');
        $bp->refresh();
        $this->assertFalse((bool) $bp->is_active);
        $this->assertEquals(120000, $bp->price);

        // Toggle ON (when checked, is_active is submitted as 1)
        $response = $this->actingAs($this->admin, 'admin')->put('/admin/app-settings', [
            'publish_fee' => 25000,
            'boost_prices' => [
                $bp->id => [
                    'price' => 120000,
                    'is_active' => '1',
                ],
            ],
        ]);

        $response->assertSessionHas('success');
        $bp->refresh();
        $this->assertTrue((bool) $bp->is_active);
    }

    public function test_admin_can_add_new_boost_variant()
    {
        $response = $this->actingAs($this->admin, 'admin')->put('/admin/app-settings', [
            'publish_fee' => 25000,
            'new_boost_prices' => [
                [
                    'duration_type' => '2_weeks',
                    'duration_days' => 14,
                    'price' => 180000,
                    'is_active' => '1',
                ],
            ],
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('boost_prices', [
            'duration_type' => '2_weeks',
            'duration_days' => 14,
            'price' => 180000,
            'is_active' => true,
        ]);
    }

    public function test_admin_can_delete_unused_boost_price()
    {
        $bp = BoostPrice::create([
            'duration_type' => '3_days',
            'duration_days' => 3,
            'price' => 50000,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin, 'admin')->delete(route('admin.boost-prices.destroy', $bp));

        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('boost_prices', ['id' => $bp->id]);
    }

    public function test_admin_cannot_delete_boost_price_with_existing_boosts()
    {
        $bp = BoostPrice::create([
            'duration_type' => '1_month',
            'duration_days' => 30,
            'price' => 350000,
            'is_active' => true,
        ]);

        $article = Article::factory()->create([
            'user_id' => $this->author->id,
            'status' => 'published',
        ]);

        Boost::create([
            'article_id' => $article->id,
            'user_id' => $this->author->id,
            'boost_price_id' => $bp->id,
            'duration_type' => '1_month',
            'duration_days' => 30,
            'price_paid' => 350000,
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->admin, 'admin')->delete(route('admin.boost-prices.destroy', $bp));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('boost_prices', ['id' => $bp->id]);
    }

    public function test_author_boost_screen_only_shows_active_boost_prices()
    {
        $activeBp = BoostPrice::create([
            'duration_type' => '3_days',
            'duration_days' => 3,
            'price' => 50000,
            'is_active' => true,
        ]);

        $inactiveBp = BoostPrice::create([
            'duration_type' => '1_month',
            'duration_days' => 30,
            'price' => 350000,
            'is_active' => false,
        ]);

        $article = Article::factory()->create([
            'user_id' => $this->author->id,
            'status' => 'published',
        ]);

        $response = $this->actingAs($this->author)->get(route('author.articles.boost', $article));

        $response->assertStatus(200);
        $response->assertSee('3 Days');
        $response->assertDontSee('1 Month');
    }
}
