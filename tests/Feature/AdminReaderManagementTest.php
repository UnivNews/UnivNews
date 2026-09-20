<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\ReadingHistory;
use App\Models\University;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminReaderManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected University $university;

    protected function setUp(): void
    {
        parent::setUp();

        $this->university = University::create([
            'name'         => 'University of Indonesia',
            'abbreviation' => 'UI',
        ]);

        $this->admin = User::factory()->create([
            'role'          => User::ROLE_ADMIN,
            'author_status' => User::STATUS_APPROVED,
            'university_id' => $this->university->id,
        ]);
    }

    public function test_admin_can_view_author_and_reader_tabs(): void
    {
        // 1. Check default view (authors tab)
        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.authors.index'));
        $response->assertStatus(200);
        $response->assertSee('User &amp; Author Management', false);
        $response->assertSee('Authors &amp; Contributors', false);
        $response->assertSee('Reader Users', false);
        $response->assertSee('Pending Author Applications');

        // 2. Check readers tab view
        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.authors.index', ['tab' => 'readers']));
        $response->assertStatus(200);
        $response->assertSee('Total Readers');
        $response->assertSee('Active Readers');
        $response->assertSee('All Reader Users');
    }

    public function test_reading_history_is_recorded_when_authenticated_reader_views_article(): void
    {
        $reader = User::factory()->create([
            'role'          => User::ROLE_PUBLIC,
            'author_status' => User::STATUS_NONE,
            'university_id' => $this->university->id,
        ]);

        $author = User::factory()->create([
            'role'          => User::ROLE_AUTHOR,
            'author_status' => User::STATUS_APPROVED,
            'university_id' => $this->university->id,
        ]);

        $category = Category::create([
            'name' => 'Campus Life',
            'slug' => 'campus-life',
        ]);

        $article = Article::create([
            'user_id'      => $author->id,
            'category_id'  => $category->id,
            'title'        => 'Test Reader Article Views',
            'slug'         => 'test-reader-article-views',
            'excerpt'      => 'A test excerpt',
            'content'      => '<p>Test article content.</p>',
            'status'       => Article::STATUS_PUBLISHED,
            'published_at' => now()->subHour(),
            'views_count'  => 0,
        ]);

        // Reader views article via public route
        $response = $this->actingAs($reader, 'web')->get(route('article', $article->slug));
        $response->assertStatus(200);

        // Verify ReadingHistory record created
        $history = ReadingHistory::where('user_id', $reader->id)
            ->where('article_id', $article->id)
            ->first();

        $this->assertNotNull($history);
        $this->assertEquals(1, $history->read_count);
        $this->assertNotNull($history->last_read_at);

        // Read again to test counter increment
        $this->actingAs($reader, 'web')->get(route('article', $article->slug));
        $history->refresh();
        $this->assertEquals(2, $history->read_count);
    }

    public function test_admin_can_view_reader_history_in_reader_management(): void
    {
        $reader = User::factory()->create([
            'name'          => 'Jane Reader Test',
            'email'         => 'jane.reader@test.com',
            'university_id' => $this->university->id,
            'role'          => User::ROLE_PUBLIC,
            'author_status' => User::STATUS_NONE,
        ]);

        $author = User::factory()->create([
            'role'          => User::ROLE_AUTHOR,
            'author_status' => User::STATUS_APPROVED,
            'university_id' => $this->university->id,
        ]);

        $category = Category::create([
            'name' => 'Research News',
            'slug' => 'research-news',
        ]);

        // Create 4 distinct read articles for this reader
        for ($i = 1; $i <= 4; $i++) {
            $article = Article::create([
                'user_id'      => $author->id,
                'category_id'  => $category->id,
                'title'        => "Story Number {$i} For Jane",
                'slug'         => "story-{$i}-jane",
                'excerpt'      => "Excerpt {$i}",
                'content'      => "<p>Content {$i}</p>",
                'status'       => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDay(),
            ]);

            ReadingHistory::create([
                'user_id'      => $reader->id,
                'article_id'   => $article->id,
                'last_read_at' => now()->subMinutes($i * 10),
                'read_count'   => 1,
            ]);
        }

        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.authors.index', ['tab' => 'readers', 'q' => 'jane.reader@test.com']));
        $response->assertStatus(200);
        $response->assertSee('Jane Reader Test');
        $response->assertSee('jane.reader@test.com');
        $response->assertSee('Story Number 1 For Jane');
        $response->assertSee('Reading History (Last 3–5 Articles Read)');
    }

    public function test_admin_can_toggle_reader_status(): void
    {
        $reader = User::factory()->create([
            'role'          => User::ROLE_PUBLIC,
            'author_status' => User::STATUS_NONE,
            'university_id' => $this->university->id,
        ]);

        // Suspend reader
        $response = $this->actingAs($this->admin, 'admin')->post(route('admin.readers.toggle-status', $reader));
        $response->assertRedirect();
        $reader->refresh();
        $this->assertEquals(User::STATUS_SUSPENDED, $reader->author_status);

        // Unsuspend reader
        $response = $this->actingAs($this->admin, 'admin')->post(route('admin.readers.toggle-status', $reader));
        $response->assertRedirect();
        $reader->refresh();
        $this->assertEquals(User::STATUS_NONE, $reader->author_status);
    }

    public function test_non_admin_cannot_access_user_management(): void
    {
        $reader = User::factory()->create([
            'role'          => User::ROLE_PUBLIC,
            'university_id' => $this->university->id,
        ]);

        // Guest
        $response = $this->get(route('admin.authors.index'));
        $response->assertRedirect();

        // Reader
        $response = $this->actingAs($reader, 'web')->get(route('admin.authors.index'));
        $response->assertRedirect();
    }
}
