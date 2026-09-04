<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin already exists to prevent duplication
        $adminEmail = 'admin@univnews.site';
        
        if (!User::where('email', $adminEmail)->exists()) {
            User::create([
                'name' => 'Super Admin',
                'preferred_name' => 'Admin',
                'email' => $adminEmail,
                'phone_number' => '+6280000000000',
                'department' => 'IT Operations',
                'role' => User::ROLE_ADMIN,
                'author_status' => User::STATUS_APPROVED,
                'password' => Hash::make('password123!'), // Ganti ini nanti!
                'created_at' => now(),
            ]);

            $this->command->info('Admin account created: ' . $adminEmail . ' / password123!');
        } else {
            $this->command->warn('Admin account already exists.');
        }
    }
}
