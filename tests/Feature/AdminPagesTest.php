<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\University;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create default test university & category
        University::create(['name' => 'University of Indonesia', 'abbreviation' => 'UI']);
        Category::create(['name' => 'Campus Life', 'slug' => 'campus-life']);
    }

    public function test_admin_dashboard_requires_authentication()
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_dashboard()
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'author_status' => User::STATUS_APPROVED,
        ]);
        
        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
    }

    public function test_author_cannot_access_admin_area()
    {
        $author = User::factory()->create([
            'role' => User::ROLE_AUTHOR,
            'author_status' => User::STATUS_APPROVED,
        ]);
        
        $response = $this->actingAs($author)->get('/admin/articles');
        $response->assertStatus(403);
    }

    public function test_author_can_access_author_dashboard()
    {
        $author = User::factory()->create([
            'role' => User::ROLE_AUTHOR,
            'author_status' => User::STATUS_APPROVED,
        ]);
        
        $response = $this->actingAs($author)->get('/author/dashboard');
        $response->assertStatus(200);
    }

    public function test_admin_can_review_and_approve_article()
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $author = User::factory()->create(['role' => User::ROLE_AUTHOR]);
        $category = Category::first();

        $article = Article::create([
            'title' => 'Breakthrough in Quantum Computing',
            'slug' => 'breakthrough-in-quantum-computing',
            'content' => 'Sample article content for quantum research',
            'user_id' => $author->id,
            'category_id' => $category->id,
            'status' => Article::STATUS_PENDING_REVIEW,
        ]);

        $response = $this->actingAs($admin)->get("/admin/articles/{$article->id}/review");
        $response->assertStatus(200);
        $response->assertSee('Review Article');

        \Illuminate\Support\Facades\Http::fake([
            '*' => \Illuminate\Support\Facades\Http::response(['data' => ['id' => 'dummy_tx_id', 'link' => 'http://dummy.url']], 200)
        ]);

        $approveResponse = $this->actingAs($admin)->post("/admin/articles/{$article->id}/approve", [
            'publish_date' => date('Y-m-d'),
            'publish_time' => '10:00',
        ]);

        $approveResponse->assertRedirect('/admin/articles');
        $this->assertEquals(Article::STATUS_AWAITING_PAYMENT, $article->fresh()->status);
        $this->assertNotNull($article->fresh()->published_at);
    }
}
