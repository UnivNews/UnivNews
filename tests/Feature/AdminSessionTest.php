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
        $response->assertSee('This device');
        $response->assertSee('Device Sessions');
    }

    public function test_admin_can_revoke_single_session()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        \Illuminate\Support\Facades\DB::table('sessions')->insert([
            'id' => 'sess_secondary_device_123',
            'user_id' => $admin->id,
            'ip_address' => '10.0.0.5',
            'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X)',
            'payload' => base64_encode(serialize([])),
            'last_activity' => time() - 3600,
        ]);

        $response = $this->actingAs($admin, 'admin')
            ->deleteJson('/admin/sessions/sess_secondary_device_123');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseMissing('sessions', [
            'id' => 'sess_secondary_device_123',
        ]);
    }

    public function test_admin_can_view_multiple_active_sessions()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        \Illuminate\Support\Facades\DB::table('sessions')->insert([
            'id' => 'sess_remote_laptop_99',
            'user_id' => $admin->id,
            'ip_address' => '192.168.1.100',
            'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)',
            'payload' => base64_encode(serialize([])),
            'last_activity' => time() - 3600,
        ]);

        $response = $this->actingAs($admin, 'admin')->get('/admin/sessions');
        $response->assertStatus(200);
        $response->assertSee('sess_remote_laptop_99');
        $response->assertSee('Sign out everywhere else');
    }

    public function test_admin_can_revoke_all_other_sessions()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        \Illuminate\Support\Facades\DB::table('sessions')->insert([
            'id' => 'sess_other_1',
            'user_id' => $admin->id,
            'ip_address' => '10.0.0.10',
            'user_agent' => 'Mozilla/5.0',
            'payload' => base64_encode(serialize([])),
            'last_activity' => time() - 7200,
        ]);

        $response = $this->actingAs($admin, 'admin')
            ->postJson('/admin/sessions/revoke-others');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseMissing('sessions', [
            'id' => 'sess_other_1',
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

