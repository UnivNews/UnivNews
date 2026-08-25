<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Article;
use App\Models\User;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_loads_successfully()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_research_page_loads_successfully()
    {
        Category::firstOrCreate(['slug' => 'research-innovation'], ['name' => 'Research & Innovation']);
        
        $response = $this->get('/research');
        $response->assertStatus(200);
    }

    public function test_article_page_loads_successfully()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $article = Article::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->get('/article/' . $article->slug);
        $response->assertStatus(200);
        $response->assertSee($article->title);
    }
}
