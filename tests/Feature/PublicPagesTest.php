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

    public function test_article_page_renders_html_formatting_properly()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $article = Article::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'content' => 'Paragraf dengan <b>tulisan tebal</b>, <u>garis bawah</u>, dan <i>miring</i>.',
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->get('/article/' . $article->slug);
        $response->assertStatus(200);
        $response->assertSee('<b>tulisan tebal</b>', false);
        $response->assertSee('<u>garis bawah</u>', false);
        $response->assertSee('<i>miring</i>', false);
        $response->assertDontSee('&lt;b&gt;tulisan tebal&lt;/b&gt;', false);
    }

    public function test_privacy_policy_page_loads_successfully()
    {
        $response = $this->get('/privacy-policy');
        $response->assertStatus(200);
    }

    public function test_footer_privacy_policy_links()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        // Column 5 HELP & SUPPORT should have Privacy Policy and Accessibility
        $response->assertSee(route('page.privacy'));
        $response->assertSee('Accessibility');
        // Bottom bar should display Terms of Service
        $response->assertSee('Terms of Service');
        $response->assertSee('Terms of Service options are currently in development.');
    }

    public function test_homepage_hero_shows_only_active_boosted_articles_when_boost_exists()
    {
        $user = User::factory()->create(['role' => 'author', 'author_status' => 'approved']);
        $category = Category::factory()->create();
        $boostPrice = \App\Models\BoostPrice::create([
            'duration_type' => '3_days',
            'duration_days' => 3,
            'price' => 50000,
            'is_active' => true,
        ]);

        // Active boosted article
        $activeArticle = Article::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Active Boosted News',
            'status' => 'published',
            'published_at' => now(),
        ]);
        \App\Models\Boost::create([
            'article_id' => $activeArticle->id,
            'user_id' => $user->id,
            'boost_price_id' => $boostPrice->id,
            'duration_type' => '3_days',
            'duration_days' => 3,
            'price_paid' => 50000,
            'start_date' => now()->subDay()->toDateString(),
            'end_date' => now()->addDays(2)->toDateString(),
            'status' => 'active',
        ]);

        // Expired boosted article
        $expiredArticle = Article::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Expired Boosted News',
            'status' => 'published',
            'published_at' => now()->subDays(5),
        ]);
        \App\Models\Boost::create([
            'article_id' => $expiredArticle->id,
            'user_id' => $user->id,
            'boost_price_id' => $boostPrice->id,
            'duration_type' => '3_days',
            'duration_days' => 3,
            'price_paid' => 50000,
            'start_date' => now()->subDays(5)->toDateString(),
            'end_date' => now()->subDays(2)->toDateString(),
            'status' => 'expired',
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);

        $featured = $response->viewData('featuredArticles');
        $this->assertCount(1, $featured);
        $this->assertEquals($activeArticle->id, $featured->first()->id);
        $this->assertFalse($featured->pluck('id')->contains($expiredArticle->id));
    }

    public function test_homepage_hero_falls_back_to_5_latest_articles_when_no_active_boost_exists()
    {
        $user = User::factory()->create(['role' => 'author', 'author_status' => 'approved']);
        $category = Category::factory()->create();

        $articles = [];
        for ($i = 1; $i <= 8; $i++) {
            $articles[] = Article::factory()->create([
                'user_id' => $user->id,
                'category_id' => $category->id,
                'title' => "News Article $i",
                'status' => 'published',
                'published_at' => now()->subHours(10 - $i),
            ]);
        }

        $response = $this->get('/');
        $response->assertStatus(200);

        $featured = $response->viewData('featuredArticles');
        $this->assertCount(5, $featured);

        $recent = $response->viewData('recentArticles');
        $featuredIds = $featured->pluck('id');

        // Recent articles must NOT overlap with hero featured articles
        foreach ($recent as $r) {
            $this->assertFalse($featuredIds->contains($r->id));
        }
    }

    public function test_homepage_hero_auto_expires_past_boosts_on_load()
    {
        $user = User::factory()->create(['role' => 'author', 'author_status' => 'approved']);
        $category = Category::factory()->create();
        $boostPrice = \App\Models\BoostPrice::create([
            'duration_type' => '3_days',
            'duration_days' => 3,
            'price' => 50000,
            'is_active' => true,
        ]);

        $pastArticle = Article::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Past Boosted News',
            'status' => 'published',
            'published_at' => now()->subDays(10),
        ]);
        $boost = \App\Models\Boost::create([
            'article_id' => $pastArticle->id,
            'user_id' => $user->id,
            'boost_price_id' => $boostPrice->id,
            'duration_type' => '3_days',
            'duration_days' => 3,
            'price_paid' => 50000,
            'start_date' => now()->subDays(6)->toDateString(),
            'end_date' => now()->subDays(3)->toDateString(),
            'status' => 'active', // not updated yet in db
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);

        $this->assertEquals('expired', $boost->fresh()->status);
        $featured = $response->viewData('featuredArticles');
        // Because no active boosts remain, it should fallback to latest articles
        $this->assertCount(1, $featured); // only 1 article exists in total
        $this->assertEquals($pastArticle->id, $featured->first()->id);
    }

    public function test_homepage_pagination_and_recent_news_visibility()
    {
        $user = User::factory()->create(['role' => 'author', 'author_status' => 'approved']);
        $category = Category::factory()->create();

        // Create 25 articles so that 5 are featured, 6 recent, and 14 in other articles (2 pages of 10)
        for ($i = 1; $i <= 25; $i++) {
            Article::factory()->create([
                'user_id' => $user->id,
                'category_id' => $category->id,
                'title' => "Pagination Article $i",
                'status' => 'published',
                'published_at' => now()->subHours(30 - $i),
            ]);
        }

        $response = $this->get('/');
        $response->assertStatus(200);

        $otherArticles = $response->viewData('otherArticles');
        $this->assertEquals(10, $otherArticles->perPage());
        $this->assertEquals(10, $otherArticles->count());
        $this->assertTrue($otherArticles->hasPages());
        $this->assertEquals(10, $response->viewData('perPage'));
        $response->assertSee('Recent News');

        // On page 2, Recent News must be hidden
        $page2Response = $this->get('/?page=2');
        $page2Response->assertStatus(200);
        $page2Response->assertDontSee('Recent News');
        $page2Response->assertSee('Others');

        // perPage=1 is no longer supported and must fallback to 10
        $fallbackResponse = $this->get('/?perPage=1');
        $this->assertEquals(10, $fallbackResponse->viewData('perPage'));
    }
}


