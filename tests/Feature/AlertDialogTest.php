<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\University;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlertDialogTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        University::create(['name' => 'University of Indonesia', 'abbreviation' => 'UI']);
        Category::create(['name' => 'Campus Life', 'slug' => 'campus-life']);
    }

    public function test_admin_articles_page_renders_alert_dialog_component()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin, 'admin')->get('/admin/articles');
        $response->assertStatus(200);
        $response->assertSee('id="global-alert-dialog"', false);
        $response->assertSee('role="alertdialog"', false);
        $response->assertSee('window.showAlertDialog', false);
        $response->assertSee('bg-crimson', false);
    }

    public function test_article_delete_form_has_data_confirm_attributes()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $article = Article::create([
            'title' => 'Test Article To Delete',
            'slug' => 'test-article-to-delete',
            'content' => 'Sample content here for deletion test.',
            'category_id' => 1,
            'user_id' => $admin->id,
            'university_id' => 1,
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->actingAs($admin, 'admin')->get('/admin/articles');
        $response->assertStatus(200);
        $response->assertSee('data-confirm-title="Delete article?"', false);
        $response->assertSee('data-confirm-btn="Delete"', false);
    }

    public function test_public_pages_render_alert_dialog_component()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('id="global-alert-dialog"', false);
        $response->assertSee('window.showAlertDialog', false);
    }

    public function test_admin_can_successfully_delete_article()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $article = Article::create([
            'title' => 'Article Destined For Destruction',
            'slug' => 'article-destined-for-destruction',
            'content' => 'Content of doomed article.',
            'category_id' => 1,
            'user_id' => $admin->id,
            'university_id' => 1,
            'status' => 'draft',
        ]);

        $response = $this->actingAs($admin, 'admin')->delete('/admin/articles/' . $article->id);
        $response->assertRedirect();
        
        $this->assertDatabaseMissing('articles', [
            'id' => $article->id,
        ]);
    }
}
