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
                ['title' => 'Architecture Faculty Final Year Exhibition 2024', 'excerpt' => 'Graduating students present their capstone design projects exploring sustainable urban living and future city planning.', 'image' => 'https://images.unsplash.com/photo-1517502884422-41eaead166d4?q=80&w=600&auto=format&fit=crop', 'tag' => 'Arts & Culture'],
                ['title' => 'Workshop on Writing Scopus-Indexed Research Papers', 'excerpt' => 'A hands-on workshop designed to help faculty and graduate students successfully publish in international indexed journals.', 'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=600&auto=format&fit=crop', 'tag' => 'Academic'],
                ['title' => 'Student Community Service at Partner Village', 'excerpt' => 'Hundreds of students join hands for a two-day community service program providing health checks and educational workshops.', 'image' => 'https://images.unsplash.com/photo-1559027615-cd4628902d4a?q=80&w=600&auto=format&fit=crop', 'tag' => 'Community'],
                ['title' => 'University Symphony Orchestra Autumn Concert', 'excerpt' => 'A special performance featuring classical and contemporary works by students of the performing arts faculty.', 'image' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=600&auto=format&fit=crop', 'tag' => 'Arts & Culture'],
                ['title' => 'Annual Tech Startup Pitching Competition', 'excerpt' => 'Budding student entrepreneurs showcase their innovative tech startups to a panel of venture capitalists and industry leaders.', 'image' => 'https://images.unsplash.com/photo-1556761175-4b46a572b786?q=80&w=600&auto=format&fit=crop', 'tag' => 'Academic'],
                ['title' => 'International Cultural Festival 2024', 'excerpt' => 'Celebrating diversity on campus with food, music, and traditional performances from over 30 countries represented by our international students.', 'image' => 'https://images.unsplash.com/photo-1533174000265-e8bb602492f5?q=80&w=600&auto=format&fit=crop', 'tag' => 'Arts & Culture'],
                ['title' => 'Alumni Networking Night and Career Fair', 'excerpt' => 'Connecting current students with successful alumni for mentorship opportunities, internships, and career guidance in various industries.', 'image' => 'https://images.unsplash.com/photo-1515169067868-5387ec356754?q=80&w=600&auto=format&fit=crop', 'tag' => 'Seminar'],
            ],
            'Achievements' => [
                ['title' => 'Robotics Lab Unveils Autonomous Campus Delivery Prototype', 'excerpt' => 'A team of graduate students has developed a self-navigating rover designed to deliver library books and small packages safely.', 'image' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?q=80&w=600&auto=format&fit=crop', 'tag' => 'Students'],
                ['title' => 'Business School Launches New Venture Capital Fellowship', 'excerpt' => 'The fellowship will provide 20 outstanding MBA candidates with hands-on experience managing a $5 million student-run investment fund.', 'image' => 'https://images.unsplash.com/photo-1542744094-24638eff58bb?q=80&w=600&auto=format&fit=crop', 'tag' => 'Faculty'],
                ['title' => 'New Study Links Urban Green Spaces to Lower Stress Levels', 'excerpt' => 'Researchers found a significant correlation between time spent in campus parks and reduced cortisol levels during finals week.', 'image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=600&auto=format&fit=crop', 'tag' => 'Science'],
                ['title' => 'University Track Team Breaks State Relay Record', 'excerpt' => 'The 4x100m relay team set a new state record this weekend, qualifying for the national championships.', 'image' => 'https://images.unsplash.com/photo-1552674605-db6ffd4facb5?q=80&w=600&auto=format&fit=crop', 'tag' => 'Athletics'],
                ['title' => 'Debate Team Secures National Championship Title', 'excerpt' => 'After a grueling three-day tournament, the university debate society brought home the national trophy.', 'image' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=600&auto=format&fit=crop', 'tag' => 'Students'],
                ['title' => 'Professor Awarded Prestigious Humanities Fellowship', 'excerpt' => 'Dr. Elena Rostova has been granted a two-year fellowship to complete her research on pre-colonial trade routes.', 'image' => 'https://images.unsplash.com/photo-1544717302-de2939b7ef71?q=80&w=600&auto=format&fit=crop', 'tag' => 'Faculty'],
                ['title' => 'Student Robotics Team Wins International Gold at Global Tech Symposium', 'excerpt' => 'The university\'s undergraduate robotics team surpassed 40 international institutions to claim first place.', 'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=600&auto=format&fit=crop', 'tag' => 'Students'],
                ['title' => 'English Debate Team Claims 1st Place at Southeast Asia Competition', 'excerpt' => 'Four students achieved a brilliant victory after defeating 28 universities from 10 ASEAN countries in the international debate tournament.', 'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=600&auto=format&fit=crop', 'tag' => 'Students'],
                ['title' => 'Engineering Faculty Student Patents New Waste Processing Technology', 'excerpt' => 'A student innovation converting plastic waste into alternative fuel received international recognition and a full patent.', 'image' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?q=80&w=600&auto=format&fit=crop', 'tag' => 'Science'],
            ],
            'Research & Innovation' => [
                ['title' => 'Breakthrough in Quantum Computing Stabilization', 'excerpt' => 'Researchers successfully stabilized a 12-qubit array at room temperature for over 3 seconds, a major leap for quantum hardware.', 'image' => 'https://images.unsplash.com/photo-1635070041078-e363dbe005cb?q=80&w=600&auto=format&fit=crop', 'tag' => 'Physics'],
                ['title' => 'New Biodegradable Polymer Derived from Algae', 'excerpt' => 'A team of chemists has synthesized a new type of plastic alternative that fully degrades in seawater within 60 days.', 'image' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?q=80&w=600&auto=format&fit=crop', 'tag' => 'Engineering'],
                ['title' => 'AI Model Predicts Protein Folding with 99% Accuracy', 'excerpt' => 'Computer science and biology departments collaborated to develop an AI model that surpasses current standards in predicting protein structures.', 'image' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?q=80&w=600&auto=format&fit=crop', 'tag' => 'AI'],
                ['title' => 'Nanotech Coating Makes Solar Panels 20% More Efficient', 'excerpt' => 'A revolutionary spray-on coating utilizes nanotechnology to capture a wider spectrum of light, boosting solar panel output significantly.', 'image' => 'https://images.unsplash.com/photo-1509391366360-2e959784a276?q=80&w=600&auto=format&fit=crop', 'tag' => 'Engineering'],
                ['title' => 'Urban Farming Initiative Yields First Successful Indoor Wheat Crop', 'excerpt' => 'The agricultural sciences faculty demonstrated the viability of growing staple crops in high-density urban environments using aeroponics.', 'image' => 'https://images.unsplash.com/photo-1530836369250-ef71a4fc5ac9?q=80&w=600&auto=format&fit=crop', 'tag' => 'Sustainability'],
                ['title' => 'Linguistics Study Maps Evolution of Internet Slang', 'excerpt' => 'A fascinating new study tracks how internet dialects evolve and spread across different social media platforms over a decade.', 'image' => 'https://images.unsplash.com/photo-1455390582262-044cdead2708?q=80&w=600&auto=format&fit=crop', 'tag' => 'Research'],
                ['title' => 'Affordable Prosthetic Limb Designed Using 3D Printing', 'excerpt' => 'Engineering students have created a highly functional, customizable prosthetic arm that can be 3D printed for under $50.', 'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=600&auto=format&fit=crop', 'tag' => 'Engineering'],
                ['title' => 'Psychology Dept Publishes Findings on Sleep and Memory Retention', 'excerpt' => 'New research provides concrete evidence linking specific stages of deep sleep to long-term memory consolidation in young adults.', 'image' => 'https://images.unsplash.com/photo-1541781774459-bb2af2f05b55?q=80&w=600&auto=format&fit=crop', 'tag' => 'Medicine'],
                ['title' => 'University Open-Sources New Climate Modeling Software', 'excerpt' => 'The environmental science department has released a powerful new software tool to help researchers accurately model localized climate change impacts.', 'image' => 'https://images.unsplash.com/photo-1569163139599-0f4517e36f51?q=80&w=600&auto=format&fit=crop', 'tag' => 'Sustainability'],
            ]
        ];

        foreach ($categoriesData as $categoryName => $articles) {
            $category = Category::where('name', $categoryName)->first();
            
            if (!$category) continue;

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
