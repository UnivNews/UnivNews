<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AdminPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_requires_authentication()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_dashboard()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        $response = $this->actingAs($admin)->get('/dashboard');
        $response->assertStatus(200);
    }

    public function test_author_cannot_access_article_management()
    {
        $author = User::factory()->create(['role' => 'author']);
        
        $response = $this->actingAs($author)->get('/admin/articles');
        $response->assertStatus(403);
    }

    public function test_editor_can_access_article_management()
    {
        $editor = User::factory()->create(['role' => 'editor']);
        
        $response = $this->actingAs($editor)->get('/admin/articles');
        $response->assertStatus(200);
    }
}
