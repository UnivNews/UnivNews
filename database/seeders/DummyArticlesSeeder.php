<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DummyArticlesSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();

        $categoriesData = [
            'Events' => [
                ['title' => 'National Seminar: Facing the Society 5.0 Era', 'excerpt' => 'Panel discussion with leading technology experts and academics discussing the challenges and opportunities of Society 5.0.', 'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=600&auto=format&fit=crop', 'tag' => 'Seminar'],
                ['title' => 'Inter-Faculty Basketball Championship Finals', 'excerpt' => 'The most anticipated sporting event of the semester, featuring the top four faculty teams competing for the coveted Rector Cup.', 'image' => 'https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?q=80&w=600&auto=format&fit=crop', 'tag' => 'Sports'],
            ],
            'Achievements' => [
                ['title' => 'Robotics Lab Unveils Autonomous Campus Delivery Prototype', 'excerpt' => 'A team of graduate students has developed a self-navigating rover designed to deliver library books and small packages safely.', 'image' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?q=80&w=600&auto=format&fit=crop', 'tag' => 'Students'],
                ['title' => 'Business School Launches New Venture Capital Fellowship', 'excerpt' => 'The fellowship will provide 20 outstanding MBA candidates with hands-on experience managing a $5 million student-run investment fund.', 'image' => 'https://images.unsplash.com/photo-1542744094-24638eff58bb?q=80&w=600&auto=format&fit=crop', 'tag' => 'Faculty'],
            ],
            'Research & Innovation' => [
                ['title' => 'Breakthrough in Quantum Computing Stabilization', 'excerpt' => 'Researchers successfully stabilized a 12-qubit array at room temperature for over 3 seconds, a major leap for quantum hardware.', 'image' => 'https://images.unsplash.com/photo-1635070041078-e363dbe005cb?q=80&w=600&auto=format&fit=crop', 'tag' => 'Physics'],
                ['title' => 'New Biodegradable Polymer Derived from Algae', 'excerpt' => 'A team of chemists has synthesized a new type of plastic alternative that fully degrades in seawater within 60 days.', 'image' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?q=80&w=600&auto=format&fit=crop', 'tag' => 'Engineering'],
            ]
        ];

        foreach ($categoriesData as $categoryName => $articles) {
            $category = Category::firstOrCreate(
                ['name' => $categoryName],
                ['slug' => Str::slug($categoryName)]
            );


            foreach ($articles as $index => $data) {
                // Delete if exists to recreate with correct tags
                Article::where('title', $data['title'])->delete();

                $article = Article::create([
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'title' => $data['title'],
                    'slug' => Str::slug($data['title']),
                    'excerpt' => $data['excerpt'],
                    'content' => '<p>' . $data['excerpt'] . '</p><p>This is a full article page for the ' . $data['title'] . ' event. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>',
                    'status' => Article::STATUS_PUBLISHED,
                    'published_at' => now()->subDays($index * 2),
                    'event_date' => $categoryName === 'Events' ? ($index % 2 === 0 ? now()->addDays(rand(5, 30)) : now()->subDays(rand(1, 10))) : null,
                    'views_count' => rand(100, 5000),
                    'featured_image_path' => $data['image'],
                ]);
                
                // Attach tag
                if (isset($data['tag'])) {
                    $tagModel = \App\Models\Tag::firstOrCreate(['name' => $data['tag']]);
                    $article->tags()->attach($tagModel->id);
                }
            }
        }
    }
}
