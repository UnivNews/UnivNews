<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSessionTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_sessions()
    {
        $response = $this->get('/admin/sessions');
        $response->assertRedirect('/admin/sign-in');
    }

    public function test_author_cannot_access_admin_sessions()
    {
        $author = User::factory()->create([
            'role' => 'author',
            'author_status' => 'approved',
        ]);

        $response = $this->actingAs($author)->get('/admin/sessions');
        $response->assertRedirect('/admin/sign-in');
    }

    public function test_admin_can_access_active_sessions_page()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin, 'admin')->get('/admin/sessions');
        $response->assertStatus(200);
        $response->assertSee('Active sessions');
        $response->assertSee('Sign out everywhere else');
        $response->assertSee('This device');
        $response->assertSee('Unusual location');
    }

    public function test_admin_can_revoke_single_session()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin, 'admin')
            ->deleteJson('/admin/sessions/sess_iphone15_test123');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
    }

    public function test_admin_can_revoke_all_other_sessions()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin, 'admin')
            ->postJson('/admin/sessions/revoke-others');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
    }

    public function test_admin_can_update_gps_location()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin, 'admin')
            ->postJson('/admin/sessions/gps-location', [
                'latitude' => -6.1898,
                'longitude' => 106.8415,
                'accuracy' => 15.5,
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $response->assertJsonStructure([
            'success',
            'gps' => [
                'latitude',
                'longitude',
                'accuracy',
                'city',
                'country',
            ],
            'gps_display',
            'location_display',
        ]);
    }
}

