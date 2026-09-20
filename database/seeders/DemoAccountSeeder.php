<?php

namespace Database\Seeders;

use App\Models\University;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Designed to run only once and cannot be executed again after data is seeded.
     * Seeds 1 Author account and 1 Reader account for client presentations (removable later).
     */
    public function run(): void
    {
        $authorEmail = 'author@university.edu';
        $readerEmail = 'public@university.edu';

        // Check if demo accounts already exist to guarantee it only runs once
        if (User::where('email', $authorEmail)->exists() || User::where('email', $readerEmail)->exists()) {
            if ($this->command) {
                $this->command->warn('Demo accounts (Author & Reader) already exist. DemoAccountSeeder is configured to run only once and cannot be executed again.');
            }
            return;
        }

        $university = University::first();

        // 1. Demo Author Account
        User::create([
            'name' => 'Ahmad Fauzi',
            'preferred_name' => 'Fauzi',
            'email' => $authorEmail,
            'phone_number' => '+1 (555) 456-7890',
            'department' => 'Campus News Desk',
            'university_id' => $university?->id,
            'role' => User::ROLE_AUTHOR,
            'author_status' => User::STATUS_APPROVED,
            'author_bio' => 'Jurnalis kampus dan kontributor berita seputar kehidupan akademik, riset, dan inovasi mahasiswa.',
            'page_name' => 'ahmad-fauzi',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'created_at' => now(),
        ]);

        // 2. Demo Reader Account
        User::create([
            'name' => 'Public Reader',
            'preferred_name' => 'Reader',
            'email' => $readerEmail,
            'phone_number' => '+1 (555) 234-5678',
            'university_id' => $university?->id,
            'role' => User::ROLE_PUBLIC,
            'author_status' => User::STATUS_NONE,
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'created_at' => now(),
        ]);

        if ($this->command) {
            $this->command->info("Demo accounts successfully created (Author: {$authorEmail}, Reader: {$readerEmail}).");
        }
    }
}
