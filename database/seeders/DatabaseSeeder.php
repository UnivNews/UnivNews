<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use App\Models\University;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Core Universities (idempotent)
        $universities = [
            ['name' => 'University of Indonesia', 'abbreviation' => 'UI'],
            ['name' => 'Bandung Institute of Technology', 'abbreviation' => 'ITB'],
            ['name' => 'Gadjah Mada University', 'abbreviation' => 'UGM'],
            ['name' => 'Airlangga University', 'abbreviation' => 'UNAIR'],
            ['name' => 'Diponegoro University', 'abbreviation' => 'UNDIP'],
            ['name' => 'Massachusetts Institute of Technology', 'abbreviation' => 'MIT'],
        ];

        foreach ($universities as $uni) {
            University::firstOrCreate(
                ['abbreviation' => $uni['abbreviation']],
                ['name' => $uni['name']]
            );
        }

        // 2. Seed Core Categories (idempotent)
        $categoriesList = [
            'Events',
            'Research & Innovation',
            'Achievements',
        ];

        foreach ($categoriesList as $name) {
            Category::firstOrCreate(
                ['name' => $name],
                ['slug' => Str::slug($name)]
            );
        }

        // 3. Seed Core Tags (idempotent)
        $tagsList = [
            'Physics', 'Research', 'Innovation', 'AI', 'Medicine',
            'Sustainability', 'Engineering', 'Announcement', 'Quantum',
            'Campus Life', 'Sports', 'Academic', 'Science & Technology',
            'Seminar', 'Students', 'Faculty', 'Robotics',
        ];

        foreach ($tagsList as $name) {
            Tag::firstOrCreate(['name' => $name]);
        }

        // 4. Execute Modular System and Setup Seeders
        $this->call([
            BoostPriceSeeder::class,   // Essential system pricing config
            AdminSeeder::class,        // Crucial Admin account (run-only-once)
            DemoAccountSeeder::class,  // 1 Author & 1 Reader demo accounts (removable later, run-only-once)
            ArticleSeeder::class,      // 20 initial articles (removable later, run-only-once)
        ]);
    }
}
