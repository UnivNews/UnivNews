<?php

namespace Database\Seeders;

use App\Models\University;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Designed to run only once and cannot be executed again after data is seeded.
     */
    public function run(): void
    {
        $adminEmail = env('ADMIN_SEEDER_EMAIL', 'admin@university.edu');

        // Check if admin already exists to guarantee it only runs once
        if (User::where('role', User::ROLE_ADMIN)->exists() || User::where('email', $adminEmail)->exists()) {
            if ($this->command) {
                $this->command->warn('Admin account already exists. AdminSeeder is configured to run only once and cannot be executed again.');
            }
            return;
        }

        $university = University::first();

        User::create([
            'name' => 'Super Admin',
            'preferred_name' => 'Admin',
            'email' => $adminEmail,
            'phone_number' => '+1 (555) 123-4567',
            'department' => 'Department of Communications',
            'university_id' => $university?->id,
            'role' => User::ROLE_ADMIN,
            'author_status' => User::STATUS_APPROVED,
            'author_bio' => 'Senior editor managing university-wide communications and digital content strategy. Overseeing editorial workflows and campus announcements.',
            'page_name' => 'admin-office',
            'password' => Hash::make(env('ADMIN_SEEDER_PASSWORD', 'password')),
            'email_verified_at' => now(),
            'created_at' => now(),
        ]);

        if ($this->command) {
            $this->command->info("Admin account successfully created ({$adminEmail}).");
        }
    }
}
