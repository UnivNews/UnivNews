<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@university.edu',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        $editor = User::factory()->create([
            'name' => 'Editorial Lead',
            'email' => 'editor@university.edu',
            'role' => 'editor',
            'password' => bcrypt('password'),
        ]);

        $author = User::factory()->create([
            'name' => 'Staff Writer',
            'email' => 'author@university.edu',
            'role' => 'author',
            'password' => bcrypt('password'),
        ]);

        // Categories
        $categories = collect([
            'Research & Innovation',
            'Campus Life',
            'Achievements',
            'Student Life',
            'International',
            'Events',
        ])->map(function ($name) {
            return Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        });

        // Tags
        $tags = collect(['AI', 'Medicine', 'Sustainability', 'Engineering', 'Arts', 'Alumni'])
            ->map(fn ($name) => Tag::create(['name' => $name]));

        // Realistic Articles
        $articleData = [
            [
                'title' => 'University Launches New AI Research Center',
                'excerpt' => 'A state-of-the-art facility dedicated to advancing artificial intelligence for social good.',
                'content' => '<p>The university has officially opened its doors to the new Artificial Intelligence Research Center. This facility aims to bridge the gap between theoretical AI research and practical applications.</p><p>Led by Dr. Alan Turing, the center will focus on machine learning, natural language processing, and robotics.</p>',
                'category_id' => $categories->where('name', 'Research & Innovation')->first()->id,
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'featured_image_path' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Breakthrough in Renewable Energy Storage',
                'excerpt' => 'Researchers have developed a new battery technology that could revolutionize solar energy storage.',
                'content' => '<p>In a groundbreaking paper published this week, university researchers unveiled a new solid-state battery design.</p><p>This new approach promises higher energy density and improved safety compared to traditional lithium-ion batteries.</p>',
                'category_id' => $categories->where('name', 'Research & Innovation')->first()->id,
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'featured_image_path' => 'https://images.unsplash.com/photo-1509391366360-2e959784a276?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Students Win National Robotics Competition',
                'excerpt' => 'The engineering team took first place at the annual collegiate robotics showcase.',
                'content' => '<p>After months of preparation, our student engineering team emerged victorious at the National Robotics Showcase.</p><p>Their autonomous rescue robot outperformed 50 other teams in simulated disaster scenarios.</p>',
                'category_id' => $categories->where('name', 'Achievements')->first()->id,
                'status' => 'published',
                'published_at' => now()->subDays(10),
                'featured_image_path' => 'https://images.unsplash.com/photo-1561557944-6e7860d1a7eb?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Annual Spring Festival Dates Announced',
                'excerpt' => 'Get ready for a week of music, food, and cultural celebrations across campus.',
                'content' => '<p>The Student Union has officially announced the dates for this year\'s Spring Festival. The week-long event will feature live performances, international food stalls, and interactive workshops.</p>',
                'category_id' => $categories->where('name', 'Campus Life')->first()->id,
                'status' => 'published',
                'published_at' => now()->subDays(1),
                'featured_image_path' => 'articles/Annual_Spring_Festival_Dates_Announced.jpg',
            ],
            [
                'title' => 'Draft: Upcoming Library Renovations',
                'excerpt' => 'Plans are underway for a major upgrade to the central library facilities.',
                'content' => '<p>The central library will undergo significant renovations starting next semester to modernize study spaces and expand the digital archives.</p>',
                'category_id' => $categories->where('name', 'Campus Life')->first()->id,
                'status' => 'draft',
                'published_at' => null,
                'featured_image_path' => 'https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=800&auto=format&fit=crop',
            ],
        ];

        foreach ($articleData as $data) {
            $article = Article::create([
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'excerpt' => $data['excerpt'],
                'content' => $data['content'],
                'status' => $data['status'],
                'published_at' => $data['published_at'],
                'user_id' => $author->id,
                'category_id' => $data['category_id'],
                'views_count' => rand(100, 5000),
                'featured_image_path' => $data['featured_image_path'] ?? null,
            ]);

            // Attach 1-3 random tags
            $article->tags()->attach($tags->random(rand(1, 3))->pluck('id'));
        }
        
        // Generate a few more random articles to populate the archive
        Article::factory(15)->create([
            'user_id' => $author->id,
            'category_id' => fn () => $categories->random()->id,
        ])->each(function ($article) use ($tags) {
            $article->tags()->attach($tags->random(rand(1, 3))->pluck('id'));
        });
    }
}
