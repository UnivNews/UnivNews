<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\University;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Universities
        $ui = University::create([
            'name' => 'University of Indonesia',
            'abbreviation' => 'UI',
        ]);

        $itb = University::create([
            'name' => 'Bandung Institute of Technology',
            'abbreviation' => 'ITB',
        ]);

        $ugm = University::create([
            'name' => 'Gadjah Mada University',
            'abbreviation' => 'UGM',
        ]);

        $unair = University::create([
            'name' => 'Airlangga University',
            'abbreviation' => 'UNAIR',
        ]);

        $undip = University::create([
            'name' => 'Diponegoro University',
            'abbreviation' => 'UNDIP',
        ]);

        $mit = University::create([
            'name' => 'Massachusetts Institute of Technology',
            'abbreviation' => 'MIT',
        ]);

        // 2. Users
        $admin = User::create([
            'name' => 'Admin User',
            'preferred_name' => 'Admin',
            'email' => 'admin@university.edu',
            'phone_number' => '+1 (555) 123-4567',
            'department' => 'Department of Communications',
            'university_id' => $ui->id,
            'role' => User::ROLE_ADMIN,
            'author_status' => User::STATUS_APPROVED,
            'author_bio' => 'Senior editor managing university-wide communications and digital content strategy. Overseeing a team of writers and ensuring brand consistency across all public-facing platforms.',
            'page_name' => 'admin-office',
            'password' => bcrypt('password'),
            'created_at' => now()->subYears(3),
        ]);

        $authorElena = User::create([
            'name' => 'Dr. Elena Rostova',
            'preferred_name' => 'Elena',
            'email' => 'elena.rostova@university.edu',
            'phone_number' => '+1 (555) 987-6543',
            'department' => 'Advanced Physics Laboratory',
            'university_id' => $ui->id,
            'role' => User::ROLE_AUTHOR,
            'author_status' => User::STATUS_APPROVED,
            'author_bio' => 'Lead researcher at the Advanced Physics Laboratory focusing on quantum decoherence and topological insulator matrices.',
            'page_name' => 'elena-rostova',
            'password' => bcrypt('password'),
            'created_at' => now()->subMonths(10),
        ]);

        $staffWriter = User::create([
            'name' => 'Staff Writer',
            'preferred_name' => 'Writer',
            'email' => 'author@university.edu',
            'phone_number' => '+1 (555) 456-7890',
            'department' => 'Campus News Desk',
            'university_id' => $ui->id,
            'role' => User::ROLE_AUTHOR,
            'author_status' => User::STATUS_APPROVED,
            'author_bio' => 'Staff reporter covering campus life, achievements, academic breakthroughs, and student affairs.',
            'page_name' => 'campus-desk',
            'password' => bcrypt('password'),
            'created_at' => now()->subMonths(6),
        ]);

        $pendingAuthor = User::create([
            'name' => 'Budi Santoso',
            'preferred_name' => 'Budi',
            'email' => 'budi@university.edu',
            'phone_number' => '+62 812 3456 7890',
            'department' => 'Faculty of Computer Science',
            'university_id' => $ui->id,
            'role' => User::ROLE_PUBLIC,
            'author_status' => User::STATUS_PENDING,
            'author_bio' => 'Lecturer and AI enthusiast applying to publish faculty news and student competitions.',
            'page_name' => 'budi-santoso',
            'password' => bcrypt('password'),
            'created_at' => now()->subDays(3),
        ]);

        $publicUser = User::create([
            'name' => 'Public Reader',
            'preferred_name' => 'Reader',
            'email' => 'public@university.edu',
            'university_id' => $ui->id,
            'role' => User::ROLE_PUBLIC,
            'author_status' => User::STATUS_NONE,
            'password' => bcrypt('password'),
            'created_at' => now()->subMonth(),
        ]);

        // 3. Categories
        $categoriesList = [
            'Events',
            'Research & Innovation',
            'Achievements',
        ];

        $categories = collect($categoriesList)->mapWithKeys(function ($name) {
            $cat = Category::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
            return [$name => $cat];
        });

        // 4. Tags
        $tagsList = ['Physics', 'Research', 'Innovation', 'AI', 'Medicine', 'Sustainability', 'Engineering', 'Announcement', 'Quantum', 'Campus Life', 'Sports', 'Academic', 'Science & Technology'];
        $tags = collect($tagsList)->mapWithKeys(function ($name) {
            $tag = Tag::firstOrCreate(['name' => $name]);
            return [$name => $tag];
        });

        // 5. Featured Article for Review (matching screenshot 3)
        $quantumArticle = Article::create([
            'user_id' => $authorElena->id,
            'category_id' => $categories['Research & Innovation']->id,
            'title' => 'Breakthrough in Quantum Computing',
            'slug' => 'breakthrough-in-quantum-computing',
            'excerpt' => "Researchers at the University's Advanced Physics Laboratory have announced a significant breakthrough in quantum entanglement stabilization, potentially paving the way for commercially viable quantum computing within the decade.",
            'content' => "<p>The persistent challenge of quantum decoherence has long stymied practical applications of quantum computing. Today, Dr. Elena Rostova and her team at the Advanced Physics Laboratory published findings in <em>Nature Physics</em> detailing a novel stabilization protocol.</p><p>\"We've essentially created a 'noise-canceling' environment at the sub-atomic level,\" Rostova explained during the morning press briefing. \"By utilizing a proprietary topological insulator matrix, we extended coherence times by a factor of 100 compared to previous baselines.\"</p><h3>Methodology</h3><p>The team utilized a cryogenically cooled vacuum chamber operating at near absolute zero. The primary innovation lies in the specific layering of synthetic graphene and heavy-fermion materials.</p><blockquote>\"This isn't just an incremental step; it's a leap over a chasm that the physics community thought might take another twenty years to cross.\" - Dr. Arthur Chen, Head of Department.</blockquote><p>Further research is required to scale the matrix beyond the current 12-qubit array, but the fundamental theoretical hurdle appears to have been cleared.</p>",
            'status' => Article::STATUS_PENDING_REVIEW,
            'views_count' => 1240,
            'created_at' => now()->subDays(2),
            'updated_at' => now()->subHours(5),
        ]);
        $quantumArticle->tags()->attach([
            $tags['Physics']->id,
            $tags['Research']->id,
            $tags['Innovation']->id,
        ]);

        // 6. Additional Articles
        $articles = [
            [
                'user_id' => $admin->id,
                'category_id' => $categories['Research & Innovation']->id,
                'title' => 'University Launches New AI Research Center',
                'slug' => 'university-launches-new-ai-research-center',
                'excerpt' => 'A state-of-the-art facility dedicated to advancing artificial intelligence for social good.',
                'content' => '<p>The university has officially opened its doors to the new Artificial Intelligence Research Center. This facility aims to bridge the gap between theoretical AI research and practical applications.</p><p>Led by top researchers, the center will focus on machine learning, natural language processing, and ethical robotics.</p>',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays(2),
                'views_count' => 3420,
                'tags' => ['AI', 'Research', 'Innovation'],
                'featured_image_path' => 'https://picsum.photos/seed/ai/800/533',
            ],
            [
                'user_id' => $staffWriter->id,
                'category_id' => $categories['Research & Innovation']->id,
                'title' => 'Breakthrough in Renewable Energy Storage',
                'slug' => 'breakthrough-in-renewable-energy-storage',
                'excerpt' => 'Researchers have developed a new battery technology that could revolutionize solar energy storage.',
                'content' => '<p>In a groundbreaking paper published this week, university researchers unveiled a new solid-state battery design with significantly higher energy density.</p>',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays(5),
                'views_count' => 2190,
                'tags' => ['Sustainability', 'Engineering', 'Research'],
                'featured_image_path' => 'https://picsum.photos/seed/energy/800/533',
            ],
            [
                'user_id' => $staffWriter->id,
                'category_id' => $categories['Achievements']->id,
                'title' => 'Students Win National Robotics Competition',
                'slug' => 'students-win-national-robotics-competition',
                'excerpt' => 'The engineering team took first place at the annual collegiate robotics showcase.',
                'content' => '<p>After months of preparation, our student engineering team emerged victorious at the National Robotics Showcase with their autonomous search-and-rescue platform.</p>',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays(8),
                'views_count' => 1840,
                'tags' => ['Engineering', 'Innovation'],
                'featured_image_path' => 'https://picsum.photos/seed/robotics/800/1000',
            ],
            [
                'user_id' => $staffWriter->id,
                'category_id' => $categories['Events']->id,
                'title' => 'Annual Spring Festival Dates Announced',
                'slug' => 'annual-spring-festival-dates-announced',
                'excerpt' => 'Get ready for a week of music, food, and cultural celebrations across campus.',
                'content' => '<p>The Student Union has officially announced the dates for this year\'s Spring Festival. The week-long event will feature live performances and international pavilions.</p>',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays(1),
                'views_count' => 950,
                'tags' => ['Campus Life', 'Announcement'],
            ],
            // 6 Extra Duplicate Articles to fill out the homepage masonry grid
            [
                'user_id' => $admin->id,
                'category_id' => $categories['Research & Innovation']->id,
                'title' => 'New Quantum Labs Open for Undergraduate Research',
                'slug' => 'new-quantum-labs-open',
                'excerpt' => 'Undergraduates will now have access to state-of-the-art quantum computing facilities.',
                'content' => '<p>We are excited to announce...</p>',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays(3),
                'views_count' => 500,
                'tags' => ['Physics', 'Innovation'],
                'featured_image_path' => 'https://picsum.photos/seed/quantum/800/600',
            ],
            [
                'user_id' => $staffWriter->id,
                'category_id' => $categories['Events']->id,
                'title' => 'Cafeteria Adds Vegan and Gluten-Free Options',
                'slug' => 'cafeteria-adds-vegan-options',
                'excerpt' => 'Responding to student feedback, the main dining hall has revamped its menu.',
                'content' => '<p>More options are coming to campus...</p>',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays(4),
                'views_count' => 300,
                'tags' => ['Campus Life'],
                'featured_image_path' => 'https://picsum.photos/seed/vegan/800/800',
            ],
            [
                'user_id' => $staffWriter->id,
                'category_id' => $categories['Achievements']->id,
                'title' => 'Varsity Basketball Team Secures Regional Championship',
                'slug' => 'basketball-regional-championship',
                'excerpt' => 'A thrilling overtime victory propels the team to the national tournament.',
                'content' => '<p>What a game it was...</p>',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays(6),
                'views_count' => 1200,
                'tags' => ['Sports', 'Achievements'],
                'featured_image_path' => 'https://picsum.photos/seed/basketball/800/533',
            ],
            [
                'user_id' => $admin->id,
                'category_id' => $categories['Events']->id,
                'title' => 'New Scholarships Available for International Students',
                'slug' => 'new-scholarships-international',
                'excerpt' => 'The university announces a $5 million fund to support global talent.',
                'content' => '<p>Apply now for the new scholarships...</p>',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays(7),
                'views_count' => 4500,
                'tags' => ['Announcement'],
                'featured_image_path' => 'https://picsum.photos/seed/scholarship/800/1000',
            ],
            [
                'user_id' => $authorElena->id,
                'category_id' => $categories['Research & Innovation']->id,
                'title' => 'Study Reveals Surprising Biodiversity in Urban Areas',
                'slug' => 'biodiversity-urban-areas',
                'excerpt' => 'Urban ecology study finds rare species thriving in campus green spaces.',
                'content' => '<p>Nature finds a way...</p>',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays(8),
                'views_count' => 850,
                'tags' => ['Research', 'Sustainability'],
                'featured_image_path' => 'https://picsum.photos/seed/biodiv/800/533',
            ],
            [
                'user_id' => $staffWriter->id,
                'category_id' => $categories['Achievements']->id,
                'title' => 'Alumni Network Reaches 100,000 Members',
                'slug' => 'alumni-network-reaches-100k',
                'excerpt' => 'A major milestone for the university community worldwide.',
                'content' => '<p>We are proud to announce...</p>',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays(9),
                'views_count' => 200,
                'tags' => ['Achievements'],
                'featured_image_path' => 'https://picsum.photos/seed/alumni/800/533',
            ],
            [
                'user_id' => $staffWriter->id,
                'category_id' => $categories['Events']->id,
                'title' => 'Upcoming Library Digital Transformation',
                'slug' => 'upcoming-library-digital-transformation',
                'excerpt' => 'Plans are underway for a major upgrade to the central library digital archival facilities.',
                'content' => '<p>The central library will undergo significant renovations starting next semester to expand 24/7 collaborative spaces and high-speed digital research terminals.</p>',
                'status' => Article::STATUS_DRAFT,
                'published_at' => null,
                'views_count' => 0,
                'tags' => ['Campus Life', 'Announcement'],
                'featured_image_path' => 'articles/Annual_Spring_Festival_Dates_Announced.jpg',
            ],
            [
                'user_id' => $authorElena->id,
                'category_id' => $categories['Research & Innovation']->id,
                'title' => 'Curriculum Modernization for STEM Programs',
                'slug' => 'curriculum-modernization-for-stem-programs',
                'excerpt' => 'Faculty senate reviews updated syllabus for advanced physics and computational mathematics.',
                'content' => '<p>The academic council submitted proposals for introducing applied AI modules into undergraduate science curricula.</p>',
                'status' => Article::STATUS_REJECTED,
                'admin_notes' => 'Please provide more specific department quotes and details on implementation dates before resubmitting.',
                'published_at' => null,
                'views_count' => 0,
                'tags' => ['Physics', 'Announcement'],
            ],
        ];

        foreach ($articles as $data) {
            $tagNames = $data['tags'] ?? [];
            unset($data['tags']);

            $article = Article::create($data);
            
            if (!empty($tagNames)) {
                $tagIds = collect($tagNames)->map(fn ($name) => $tags[$name]->id ?? null)->filter();
                $article->tags()->attach($tagIds);
            }
        }

        // 7. Boost Prices
        $this->call([
            BoostPriceSeeder::class,
        ]);
    }
}
