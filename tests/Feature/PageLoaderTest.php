<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageLoaderTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_renders_3d_book_page_loader()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('id="global-page-loader"', false);
        $response->assertSee('class="uiverse-loader"', false);
        $response->assertSee('window.showPageLoader', false);
        $response->assertSee('window.hidePageLoader', false);
    }

    public function test_cms_portal_renders_3d_book_page_loader()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin, 'admin')->get('/admin/sessions');
        $response->assertStatus(200);
        $response->assertSee('id="global-page-loader"', false);
        $response->assertSee('class="uiverse-loader"', false);
        $response->assertSee('rgba(0, 8, 30, 0.72)', false);
        $response->assertSee('DEFAULT_DELAY = 650', false);
        $response->assertSee('Loading');
    }
}
