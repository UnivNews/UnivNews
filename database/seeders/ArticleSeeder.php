<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Designed to run only once and cannot be executed again after data is seeded.
     * Seeds exactly 20 articles for initial setup and client presentation (removable later).
     */
    public function run(): void
    {
        // Check if articles have already been seeded to guarantee single execution
        if (Article::count() >= 20) {
            if ($this->command) {
                $this->command->warn('Articles have already been seeded (' . Article::count() . ' articles present). ArticleSeeder is configured to run only once and cannot be executed again.');
            }
            return;
        }

        // 1. Ensure categories exist
        $categoryResearch = Category::firstWhere('name', 'Research & Innovation')
            ?? Category::firstOrCreate(['name' => 'Research & Innovation'], ['slug' => Str::slug('Research & Innovation')]);

        $categoryEvents = Category::firstWhere('name', 'Events')
            ?? Category::firstOrCreate(['name' => 'Events'], ['slug' => Str::slug('Events')]);

        $categoryAchievements = Category::firstWhere('name', 'Achievements')
            ?? Category::firstOrCreate(['name' => 'Achievements'], ['slug' => Str::slug('Achievements')]);

        // 2. Resolve default author user
        $author = User::where('role', User::ROLE_AUTHOR)->first()
            ?? User::where('role', User::ROLE_ADMIN)->first()
            ?? User::first();

        if (!$author) {
            if ($this->command) {
                $this->command->error('No author or user found to associate articles with. Please run AdminSeeder and DemoAccountSeeder first.');
            }
            return;
        }

        // 3. Define 20 structured demo articles
        $articlesData = [
            // --- Research & Innovation (8 articles) ---
            [
                'category_id' => $categoryResearch->id,
                'title' => 'Breakthrough in Quantum Computing Stabilization',
                'slug' => 'breakthrough-in-quantum-computing-stabilization',
                'excerpt' => 'Researchers successfully stabilize a 12-qubit topological matrix at room temperature, paving the way for commercial quantum processors.',
                'content' => '<p>The persistent challenge of quantum decoherence has long stymied practical applications of quantum computing. Today, university researchers at the Advanced Physics Laboratory published findings in <em>Nature Physics</em> detailing a novel stabilization protocol.</p><p>"We have essentially created a noise-canceling environment at the sub-atomic level," the lead researcher explained during the morning symposium. "By utilizing a proprietary topological insulator matrix, coherence times were extended by a factor of 100 compared to prior benchmarks."</p><h3>Methodology & Results</h3><p>The team synthesized layered graphene composites capable of suppressing background thermal noise. Future experiments will scale the architecture to 64 qubits.</p>',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays(1),
                'views_count' => 3840,
                'featured_image_path' => 'https://images.unsplash.com/photo-1635070041078-e363dbe005cb?q=80&w=800&auto=format&fit=crop',
                'tags' => ['Physics', 'Quantum', 'Innovation', 'Research'],
            ],
            [
                'category_id' => $categoryResearch->id,
                'title' => 'University Launches State-of-the-Art AI Research Center',
                'slug' => 'university-launches-state-of-the-art-ai-research-center',
                'excerpt' => 'A cross-disciplinary facility established to develop ethical foundation models and real-time healthcare diagnostic systems.',
                'content' => '<p>The university has officially inaugurated the new Center for Artificial Intelligence and Human Flourishing. Equipped with high-performance GPU clusters, the center will bridge academic theory and critical public health applications.</p><blockquote>"Our objective is not solely computational speed, but algorithmic transparency and ethical resilience."</blockquote><p>Partnerships have been established with leading teaching hospitals to accelerate early detection of pulmonary conditions.</p>',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays(3),
                'views_count' => 2950,
                'featured_image_path' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=800&auto=format&fit=crop',
                'tags' => ['AI', 'Research', 'Innovation'],
            ],
            [
                'category_id' => $categoryResearch->id,
                'title' => 'Next-Generation Solid-State Batteries for Clean Energy Storage',
                'slug' => 'next-generation-solid-state-batteries-clean-energy-storage',
                'excerpt' => 'Chemical engineers formulate non-flammable ceramic electrolytes that triple energy density for municipal grid storage.',
                'content' => '<p>Overcoming battery safety limits has been the holy grail of grid modernization. A multidisciplinary engineering cohort revealed a sulfur-tolerant solid electrolyte capable of operating under extreme temperatures without degradation.</p><p>Prototypes have demonstrated over 1,500 continuous discharge cycles with negligible capacity retention loss.</p>',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays(5),
                'views_count' => 2120,
                'featured_image_path' => 'https://images.unsplash.com/photo-1509391365360-2e959784a276?q=80&w=800&auto=format&fit=crop',
                'tags' => ['Sustainability', 'Engineering', 'Research'],
            ],
            [
                'category_id' => $categoryResearch->id,
                'title' => 'Marine Chemists Discover Biodegradable Polymer from Microalgae',
                'slug' => 'marine-chemists-discover-biodegradable-polymer-microalgae',
                'excerpt' => 'A sustainable packaging material synthesized from coastal microalgae decomposes safely in saltwater within 45 days.',
                'content' => '<p>Addressing oceanic microplastic contamination requires material innovation at source. Faculty researchers harvested endemic microalgae species to extract polysaccharides capable of forming durable, heat-resistant films.</p><p>Life cycle assessments confirm the production process consumes net carbon through accelerated algal bioreactors.</p>',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays(7),
                'views_count' => 1780,
                'featured_image_path' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?q=80&w=800&auto=format&fit=crop',
                'tags' => ['Sustainability', 'Innovation'],
            ],
            [
                'category_id' => $categoryResearch->id,
                'title' => 'Clinical Trial Validates Targeted Nanomedicine for Oncology',
                'slug' => 'clinical-trial-validates-targeted-nanomedicine-oncology',
                'excerpt' => 'Precision liposome nanocarriers successfully deliver chemotherapeutic compounds directly to tumor microenvironments.',
                'content' => '<p>The Faculty of Medicine announced phase-two clinical results for lipid nanoparticle carriers designed to minimize systemic side effects during chemotherapy treatment.</p><p>Patients exhibited improved tolerance alongside a 40% uptick in targeted tumor localization.</p>',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays(10),
                'views_count' => 1430,
                'featured_image_path' => 'https://images.unsplash.com/photo-1576086213369-97a306d36557?q=80&w=800&auto=format&fit=crop',
                'tags' => ['Medicine', 'Research'],
            ],
            [
                'category_id' => $categoryResearch->id,
                'title' => 'Atmospheric Monitoring Drones Map Urban Microclimate Trends',
                'slug' => 'atmospheric-monitoring-drones-map-urban-microclimates',
                'excerpt' => 'Autonomous drone networks collect hyper-local thermal data to guide urban reforestation and heat-island mitigation.',
                'content' => '<p>Urban planners and geomatics scientists coordinated a fleet of sensor-bearing quadcopters across metropolitan transit corridors. The findings will provide actionable feedback for green roof policies.</p>',
                'status' => Article::STATUS_REJECTED,
                'admin_notes' => 'Please include flight telemetry charts and citations from municipal environmental regulators before resubmission.',
                'published_at' => null,
                'views_count' => 0,
                'featured_image_path' => 'https://images.unsplash.com/photo-1527977966376-1c8408f9f108?q=80&w=800&auto=format&fit=crop',
                'tags' => ['Engineering', 'Sustainability'],
            ],
            [
                'category_id' => $categoryResearch->id,
                'title' => 'Campus Green Spaces Support Surprising Urban Biodiversity',
                'slug' => 'campus-green-spaces-support-urban-biodiversity',
                'excerpt' => 'A three-year ecological survey registers over 120 pollinator species and native birds flourishing within university grounds.',
                'content' => '<p>The Department of Biological Sciences completed its quadrennial campus biodiversity audit, identifying rare bee species and thriving songbird populations within native botanical sanctuaries.</p>',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays(12),
                'views_count' => 1100,
                'featured_image_path' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=800&auto=format&fit=crop',
                'tags' => ['Sustainability', 'Research'],
            ],
            [
                'category_id' => $categoryResearch->id,
                'title' => 'Deep-Space Laser Communication Protocol Sets Bandwidth Record',
                'slug' => 'deep-space-laser-communication-bandwidth-record',
                'excerpt' => 'Astrophysicists and telecommunications researchers transmit high-definition telemetry data across lunar distances.',
                'content' => '<p>Optical communications represent the future of interplanetary data links. By synchronizing adaptive optics with narrow-beam infrared lasers, researchers received ultra-dense video streams with near-zero packet loss.</p>',
                'status' => Article::STATUS_PENDING_REVIEW,
                'published_at' => null,
                'views_count' => 450,
                'featured_image_path' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=800&auto=format&fit=crop',
                'tags' => ['Science & Technology', 'Physics', 'Research'],
            ],

            // --- Events (6 articles) ---
            [
                'category_id' => $categoryEvents->id,
                'title' => 'Annual Spring Arts and Culture Festival Dates Announced',
                'slug' => 'annual-spring-arts-culture-festival-dates-announced',
                'excerpt' => 'Join us for a week-long celebration featuring live orchestra performances, multicultural food pavilions, and interactive exhibits.',
                'content' => '<p>The University Cultural Council has released the official schedule for the 2026 Spring Festival. Festivities will span the North Quad and Student Union with over forty visiting international performers.</p>',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays(2),
                'event_date' => now()->addDays(14),
                'views_count' => 2400,
                'featured_image_path' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?q=80&w=800&auto=format&fit=crop',
                'tags' => ['Campus Life', 'Announcement'],
            ],
            [
                'category_id' => $categoryEvents->id,
                'title' => 'International Academic Symposium on Artificial Intelligence Ethics',
                'slug' => 'international-academic-symposium-ai-ethics',
                'excerpt' => 'Leading philosophers, computer scientists, and legal experts convene for keynotes on automated governance and societal trust.',
                'content' => '<p>Registration is now open for the 2026 International Symposium on Ethical Computing. Keynote speakers include UNESCO delegates and principal AI safety researchers.</p>',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays(4),
                'event_date' => now()->addDays(21),
                'views_count' => 1950,
                'featured_image_path' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=800&auto=format&fit=crop',
                'tags' => ['AI', 'Seminar', 'Academic'],
            ],
            [
                'category_id' => $categoryEvents->id,
                'title' => 'Inter-Faculty Basketball Championship Finals',
                'slug' => 'inter-faculty-basketball-championship-finals',
                'excerpt' => 'The Engineering Titans face off against the Economics Lions in an electric battle for the annual Rector Cup.',
                'content' => '<p>The University Sports Complex saw record attendance as rival faculty teams battled through double overtime in the annual basketball tournament finals.</p>',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays(6),
                'event_date' => now()->subDays(1),
                'views_count' => 1650,
                'featured_image_path' => 'https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?q=80&w=800&auto=format&fit=crop',
                'tags' => ['Sports', 'Campus Life'],
            ],
            [
                'category_id' => $categoryEvents->id,
                'title' => 'Campus Career Fair 2026: Connecting Students with Global Innovators',
                'slug' => 'campus-career-fair-2026-global-innovators',
                'excerpt' => 'Over 150 top technology, finance, and research organizations host live interviews and recruiting workshops.',
                'content' => '<p>The Career Development Center welcomes undergraduate and postgraduate students to the university Grand Hall for networking and direct internship placement sessions.</p>',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays(8),
                'event_date' => now()->addDays(28),
                'views_count' => 2800,
                'featured_image_path' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=800&auto=format&fit=crop',
                'tags' => ['Campus Life', 'Announcement', 'Students'],
            ],
            [
                'category_id' => $categoryEvents->id,
                'title' => 'Global Climate Hackathon Welcomes Student Innovators',
                'slug' => 'global-climate-hackathon-student-innovators',
                'excerpt' => 'A 48-hour sprint focusing on climate data analytics, smart urban transit, and circular resource management.',
                'content' => '<p>Teams from 25 international universities will build and present software and hardware prototypes aimed at tackling regional decarbonization targets.</p>',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays(9),
                'event_date' => now()->addDays(35),
                'views_count' => 1250,
                'featured_image_path' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?q=80&w=800&auto=format&fit=crop',
                'tags' => ['Innovation', 'Sustainability', 'Students'],
            ],
            [
                'category_id' => $categoryEvents->id,
                'title' => 'Central Library Digital Archive and 24/7 Study Hub Launch',
                'slug' => 'central-library-digital-archive-study-hub-launch',
                'excerpt' => 'Major infrastructural upgrades bring high-speed research terminals, soundproof seminar pods, and extensive digitized manuscripts.',
                'content' => '<p>Following eight months of modernization, the University Central Library celebrated the grand opening of its refurbished East Wing, open 24 hours daily during examination periods.</p>',
                'status' => Article::STATUS_DRAFT,
                'published_at' => null,
                'event_date' => null,
                'views_count' => 0,
                'featured_image_path' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=800&auto=format&fit=crop',
                'tags' => ['Campus Life', 'Announcement'],
            ],

            // --- Achievements (6 articles) ---
            [
                'category_id' => $categoryAchievements->id,
                'title' => 'Student Robotics Team Triumphs at National Autonomous Challenge',
                'slug' => 'student-robotics-team-triumphs-national-autonomous-challenge',
                'excerpt' => 'The undergraduate engineering cohort clinches first place with their self-navigating search-and-rescue rover platform.',
                'content' => '<p>After months of intensive testing, the student robotics delegation outperformed thirty rival collegiate institutions at the National Engineering Showcase.</p><p>Judges commended the rover system for its real-time LIDAR sensor fusion and robust fault recovery algorithms under simulated disaster conditions.</p>',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays(2),
                'views_count' => 3100,
                'featured_image_path' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?q=80&w=800&auto=format&fit=crop',
                'tags' => ['Engineering', 'Robotics', 'Achievements'],
            ],
            [
                'category_id' => $categoryAchievements->id,
                'title' => 'Business School Fellows Win Global Venture Capital Challenge',
                'slug' => 'business-school-fellows-win-global-venture-challenge',
                'excerpt' => 'MBA candidates take top honors after successfully pitching a clean-tech agritech venture fund model in Zurich.',
                'content' => '<p>Demonstrating rigorous financial modeling and sustainability metrics, the student investment committee earned the grand prize in the International Venture Competition.</p>',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays(4),
                'views_count' => 1890,
                'featured_image_path' => 'https://images.unsplash.com/photo-1542744094-24638eff58bb?q=80&w=800&auto=format&fit=crop',
                'tags' => ['Students', 'Achievements', 'Innovation'],
            ],
            [
                'category_id' => $categoryAchievements->id,
                'title' => 'Solar Vehicle Cohort Sets Cross-Country Endurance Record',
                'slug' => 'solar-vehicle-cohort-cross-country-endurance-record',
                'excerpt' => 'The student-designed aerodynamically optimized solar vehicle completes a 2,000-kilometer continental endurance journey.',
                'content' => '<p>Powered entirely by solar panels and proprietary regenerative braking systems, the aerodynamic prototype vehicle crossed the finish line with zero mechanical stoppages.</p>',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays(7),
                'views_count' => 2250,
                'featured_image_path' => 'https://images.unsplash.com/photo-1558981806-ec527fa84c39?q=80&w=800&auto=format&fit=crop',
                'tags' => ['Engineering', 'Sustainability', 'Achievements'],
            ],
            [
                'category_id' => $categoryAchievements->id,
                'title' => 'University Debate Union Crowned Pan-Asian Champions',
                'slug' => 'university-debate-union-crowned-pan-asian-champions',
                'excerpt' => 'Student debaters defeat international contenders across seven elimination rounds covering international economic policy.',
                'content' => '<p>The Parliamentary Debate Society concluded an undefeated championship tournament, earning highest individual speaker rankings and securing the regional trophy.</p>',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays(11),
                'views_count' => 1520,
                'featured_image_path' => 'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?q=80&w=800&auto=format&fit=crop',
                'tags' => ['Campus Life', 'Achievements', 'Students'],
            ],
            [
                'category_id' => $categoryAchievements->id,
                'title' => 'Computer Science Fellows Win International ACM Hackathon',
                'slug' => 'computer-science-fellows-win-acm-hackathon',
                'excerpt' => 'Student software architects design a zero-knowledge cryptographic protocol for secure cross-border identity verification.',
                'content' => '<p>Competing against 80 top technical institutions, our four-member delegation authored and proved the cryptographic correctness of a distributed authentication system.</p>',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays(13),
                'views_count' => 2670,
                'featured_image_path' => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?q=80&w=800&auto=format&fit=crop',
                'tags' => ['AI', 'Engineering', 'Achievements'],
            ],
            [
                'category_id' => $categoryAchievements->id,
                'title' => 'Alumni Global Network Reaches 100,000 Verified Members',
                'slug' => 'alumni-global-network-reaches-100k-members',
                'excerpt' => 'A historic milestone highlighting the international impact and mentorship reach of the university alumni community.',
                'content' => '<p>The University Alumni Association formally celebrated its 100,000th active registered member, marking decades of collaborative scholarship, research impact, and global leadership across 95 nations.</p>',
                'status' => Article::STATUS_PUBLISHED,
                'published_at' => now()->subDays(15),
                'views_count' => 3340,
                'featured_image_path' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=800&auto=format&fit=crop',
                'tags' => ['Announcement', 'Achievements'],
            ],
        ];

        // 4. Insert each article and synchronize tags
        $seededCount = 0;
        foreach ($articlesData as $item) {
            $tagNames = $item['tags'] ?? [];
            unset($item['tags']);

            $item['user_id'] = $author->id;

            $article = Article::firstOrCreate(
                ['slug' => $item['slug']],
                $item
            );

            if (!empty($tagNames)) {
                $tagIds = collect($tagNames)->map(function ($tagName) {
                    return Tag::firstOrCreate(['name' => $tagName])->id;
                })->filter();

                $article->tags()->syncWithoutDetaching($tagIds);
            }

            $seededCount++;
        }

        if ($this->command) {
            $this->command->info("ArticleSeeder completed successfully. Total articles seeded: {$seededCount}.");
        }
    }
}
